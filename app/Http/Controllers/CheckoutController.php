<?php

namespace App\Http\Controllers;

use App\Mail\EventTicketMail;
use App\Models\Category;
use App\Models\Event;
use App\Models\Transaction;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    public function create(Event $event)
    {
        if ($event->stock <= 0) {
            return redirect()->route('events.show', $event)->with('error', 'Mohon maaf, tiket untuk acara ini sudah habis.');
        }

        if ($event->price == 0 && auth()->check()) {
            $alreadyClaimed = Transaction::where('event_id', $event->id)
                ->where('customer_email', auth()->user()->email)
                ->whereIn('status', ['success', 'settlement'])
                ->exists();
            if ($alreadyClaimed) {
                return redirect()->route('events.show', $event)->with('error', 'Kamu sudah mengambil event ini, silahkan cek riwayat belanja.');
            }
        }

        $categories = Category::all();

        return view('checkout.create', compact('event', 'categories'));
    }

    public function store(Request $request, Event $event)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'qty' => 'required|integer|min:1|max:5',
            'attendee_names' => 'nullable|array',
            'attendee_names.*' => 'required|string|max:255',
            'attendee_emails' => 'nullable|array',
            'attendee_emails.*' => 'required|email|max:255',
            'attendee_phones' => 'nullable|array',
            'attendee_phones.*' => 'required|string|max:20',
            'coupons' => 'nullable|array|max:2',
            'coupons.*' => 'required|string',
        ]);

        if ($event->price == 0) {
            $alreadyClaimed = Transaction::where('event_id', $event->id)
                ->where('customer_email', $request->customer_email)
                ->whereIn('status', ['success', 'settlement'])
                ->exists();
            if ($alreadyClaimed) {
                return back()->with('error', 'Kamu sudah mengambil event ini, silahkan cek riwayat belanja.');
            }
        }

        $qty = ($event->price == 0) ? 1 : intval($request->input('qty', 1));
        $ticketSubtotal = $event->current_price * $qty;
        $discountAmount = 0;
        $couponsUsed = [];

        if ($event->price > 0 && $request->has('coupons')) {
            $inputCoupons = array_unique(array_slice($request->input('coupons'), 0, 2));
            foreach ($inputCoupons as $code) {
                $code = strtoupper(trim($code));
                $coupon = Coupon::with('user')->where('code', $code)->first();
                $isUniversal = $coupon && $coupon->user && $coupon->user->role === 'admin';
                if ($coupon && ($isUniversal || $coupon->user_id === $event->user_id)) {

                    if ($coupon->expires_at && $coupon->expires_at->isPast()) {
                        continue;
                    }

                    if ($coupon->is_limited && $coupon->used_count >= $coupon->limit_count) {
                        continue;
                    }

                    $value = intval($coupon->value);
                    $disc = 0;
                    if ($coupon->type === 'percent') {
                        $disc = intval($ticketSubtotal * ($value / 100));
                    } else {
                        $disc = $value;
                    }
                    $discountAmount += $disc;
                    $couponsUsed[] = [
                        'code' => $coupon->code,
                        'value' => $value,
                        'type' => $coupon->type,
                        'discount' => $disc
                    ];
                }
            }
        }

        if ($event->stock < $qty) {
            return back()->with('error', 'Mohon maaf, sisa tiket yang tersedia tidak mencukupi.');
        }

        $orderId = 'TRX-'.time().'-'.Str::random(5);
        if ($event->price == 0) {
            $totalPrice = 0;
        } else {
            $totalPrice = $ticketSubtotal + 5000 - $discountAmount;
            if ($totalPrice < 0) {
                $totalPrice = 0;
            }
        }

        $attendees = [];
        if ($qty > 1 && $request->has('attendee_names')) {
            for ($i = 0; $i < $qty - 1; $i++) {
                $attendees[] = [
                    'name' => $request->attendee_names[$i] ?? '',
                    'email' => $request->attendee_emails[$i] ?? '',
                    'phone' => $request->attendee_phones[$i] ?? '',
                ];
            }
        }

        $transaction = Transaction::create([
            'event_id' => $event->id,
            'order_id' => $orderId,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'total_price' => $totalPrice,
            'status' => ($event->price == 0) ? 'success' : 'pending',
            'quantity' => $qty,
            'attendees' => $attendees,
            'coupons_used' => ($event->price == 0) ? [] : $couponsUsed,
            'discount_amount' => ($event->price == 0) ? 0 : $discountAmount,
        ]);

        $affected = \Illuminate\Support\Facades\DB::table('events')
            ->where('id', $event->id)
            ->where('stock', '>=', $qty)
            ->decrement('stock', $qty);

        if (!$affected) {
            
            $transaction->delete();
            return back()->with('error', 'Mohon maaf, sisa tiket yang tersedia tidak mencukupi.');
        }
        $event->refresh();

        if ($event->price == 0) {
            try {
                Mail::to($transaction->customer_email)
                    ->send(new EventTicketMail($transaction));
            } catch (\Exception $e) {
                \Log::error('Gagal mengirim email E-Ticket untuk event gratis: '.$e->getMessage());
            }

            if (auth()->check()) {
                auth()->user()->update([
                    'phone' => $request->customer_phone,
                ]);
            }

            return redirect()->route('checkout.success', $transaction->order_id);
        }

        if (auth()->check()) {
            auth()->user()->update([
                'phone' => $request->customer_phone,
            ]);
        }

        Config::$serverKey = config('midtrans.server_key') ?: env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = config('midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $totalPrice,
            ],
            'customer_details' => [
                'first_name' => $request->customer_name,
                'email' => $request->customer_email,
                'phone' => $request->customer_phone,
            ],
        ];

        try {

            $snapToken = Snap::getSnapToken($params);

            $transaction->update(['snap_token' => $snapToken]);

            return redirect()->route('checkout.payment', $transaction->order_id);

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses pembayaran jaringan: '.$e->getMessage());
        }
    }

    public function payment($order_id)
    {
        $categories = Category::all();
        $transaction = Transaction::with('event')->where('order_id', $order_id)->firstOrFail();

        if (strtolower($transaction->status) === 'pending' && $transaction->created_at->addMinutes(2)->isPast()) {
            if ($transaction->event) {
                $transaction->event->stock = $transaction->event->stock + $transaction->quantity;
                $transaction->event->save();
            }
            $transaction->update(['status' => 'failed']);
            
            \App\Models\ActivityLog::log("Reservasi tiket Order ID {$transaction->order_id} kedaluwarsa. Stok dikembalikan.");
        }

        return view('checkout.payment', compact('transaction', 'categories'));
    }

    public function success($order_id)
    {
        $categories = Category::all();
        $transaction = Transaction::with('event')->where('order_id', $order_id)->firstOrFail();

        if ($transaction->total_price > 0 && strtolower($transaction->status) === 'pending') {
            Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            Config::$isProduction = false;
            Config::$isSanitized = true;
            Config::$is3ds = true;

            try {
                $status = \Midtrans\Transaction::status($order_id);

                if ($status) {
                    $trx_status = is_array($status) ? ($status['transaction_status'] ?? '') : ($status->transaction_status ?? '');

                    if (in_array($trx_status, ['settlement', 'capture'])) {
                        if (strtolower($transaction->status) === 'pending') {
                            $transaction->update(['status' => 'success']);

                            if ($transaction->coupons_used) {
                                foreach ($transaction->coupons_used as $uCoupon) {
                                    if (isset($uCoupon['code'])) {
                                        $couponObj = Coupon::where('code', $uCoupon['code'])->first();
                                        if ($couponObj) {
                                            $couponObj->increment('used_count');
                                        }
                                    }
                                }
                            }

                            try {
                                Mail::to($transaction->customer_email)
                                    ->send(new EventTicketMail($transaction));
                            } catch (\Exception $e) {
                                \Log::error('Gagal mengirim email E-Ticket secara manual (Bypass): '.$e->getMessage());
                            }
                        }
                    }
                }
            } catch (\Exception $e) {
                return redirect()->route('home')->with('error', 'Transaksi tidak ditemukan atau gagal diproses oleh sistem pembayaran.');
            }
        }

        return view('checkout.success', compact('transaction', 'categories'));
    }

    public function validateCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'event_id' => 'required|integer',
        ]);

        $code = strtoupper(trim($request->code));
        $coupon = Coupon::with('user')->where('code', $code)->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Kupon tidak valid.'
            ]);
        }

        $event = Event::find($request->event_id);
        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => 'Event tidak ditemukan.'
            ]);
        }

        $isUniversal = $coupon->user && $coupon->user->role === 'admin';
        if (!$isUniversal && $coupon->user_id !== $event->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Kupon ini tidak berlaku untuk event dari merchant ini.'
            ]);
        }

        if ($coupon->expires_at && $coupon->expires_at->isPast()) {
            return response()->json([
                'success' => false,
                'message' => 'Kupon ini telah kedaluwarsa.'
            ]);
        }

        if ($coupon->is_limited && $coupon->used_count >= $coupon->limit_count) {
            return response()->json([
                'success' => false,
                'message' => 'Kuota penggunaan kupon ini telah habis.'
            ]);
        }

        return response()->json([
            'success' => true,
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value,
        ]);
    }

    public function expire($order_id)
    {
        $transaction = Transaction::with('event')->where('order_id', $order_id)->firstOrFail();

        if (strtolower($transaction->status) === 'pending') {
            if ($transaction->event) {
                $transaction->event->stock = $transaction->event->stock + $transaction->quantity;
                $transaction->event->save();
            }
            $transaction->update(['status' => 'failed']);
            
            \App\Models\ActivityLog::log("Reservasi tiket Order ID {$transaction->order_id} kedaluwarsa. Stok dikembalikan.");
            
            return response()->json([
                'success' => true,
                'message' => 'Reservasi tiket kedaluwarsa. Stok telah dikembalikan ke database.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Transaksi tidak berada dalam status pending.'
        ]);
    }
}
