<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticket Resmi - ChasingTicket</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #103370; margin: 0; padding: 40px 20px; color: #ffffff; }
        .container { max-width: 480px; margin: 0 auto; width: 100%; }
        .header-text { text-align: center; margin-bottom: 25px; }
        .header-text h1 { font-size: 26px; font-weight: 900; margin: 0 0 8px 0; color: #ffffff; }
        .header-text p { color: #b8ff00; margin: 0; font-weight: bold; font-size: 14px; }
        .ticket-card { background-color: #ffffff; color: #103370; border-radius: 30px; overflow: hidden; box-shadow: 0 15px 35px rgba(0,0,0,0.3); }
        .ticket-top { background-color: #103370; padding: 30px; text-align: center; border-bottom: 2px dashed #e2e8f0; color: #ffffff; }
        .ticket-top .badge { background-color: #b8ff00; color: #103370; font-size: 10px; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; padding: 4px 12px; border-radius: 20px; display: inline-block; margin-bottom: 12px; }
        .ticket-top h2 { font-size: 22px; font-weight: 900; margin: 0; color: #ffffff; line-height: 1.3; }
        .ticket-body { padding: 30px; }
        .grid { display: block; width: 100%; margin-bottom: 20px; }
        .grid-item { display: inline-block; width: 45%; vertical-align: top; margin-bottom: 20px; }
        .label { color: #94a3b8; font-size: 10px; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; margin: 0 0 5px 0; }
        .value { font-weight: 800; font-size: 15px; color: #103370; margin: 0; }
        .qr-section { background-color: #f8fafc; padding: 25px; border-radius: 24px; text-align: center; margin-top: 10px; border: 2px solid #f1f5f9; }
        .qr-container { background-color: white; padding: 12px; border-radius: 16px; display: inline-block; margin-bottom: 12px; border: 1px solid #e2e8f0; }
        .footer { text-align: center; padding: 0 30px 30px 30px; color: #64748b; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">

        <div class="header-text">
            <h1>Pembayaran Berhasil!</h1>
            <p>Tiket Anda telah terbit & siap digunakan.</p>
        </div>

        <div class="ticket-card">

            <div class="ticket-top">
                <span class="badge">E-Ticket Resmi</span>
                <h2>{{ $transaction->event->title }}</h2>
            </div>

            <div class="ticket-body">
                <div class="grid">
                    <div class="grid-item">
                        <p class="label">Nama Pembeli</p>
                        <p class="value">{{ $transaction->customer_name }}</p>
                    </div>
                    <div class="grid-item">
                        <p class="label">Tanggal & Waktu</p>
                        <p class="value">{{ \Carbon\Carbon::parse($transaction->event->date)->format('d M Y, H:i') }} WIB</p>
                    </div>
                    <div class="grid-item">
                        <p class="label">Order ID</p>
                        <p class="value" style="font-family: monospace;">{{ $transaction->order_id }}</p>
                    </div>
                    <div class="grid-item">
                        <p class="label">Lokasi</p>
                        <p class="value">{{ $transaction->event->location }}</p>
                    </div>
                </div>

                <div class="qr-section">
                    <p class="label" style="margin-bottom: 12px; color: #103370;">Scan QR Code Untuk Check-in</p>
                    <div class="qr-container">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=160x160&data={{ urlencode($transaction->order_id) }}" alt="QR Code Tiket" width="160" height="160" style="display: block;">
                    </div>
                    <p style="margin: 0; font-family: monospace; font-weight: 900; color: #103370; font-size: 14px;">{{ $transaction->order_id }}</p>
                </div>
            </div>

            <div class="footer">
                <p>Mohon tunjukkan E-Ticket ini dalam bentuk cetak atau layar HP saat memasuki area acara.</p>
                <p style="margin-top: 10px; font-weight: bold; color: #103370;">&copy; {{ date('Y') }} ChasingTicket. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>