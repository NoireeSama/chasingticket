<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    function index(){

    }

    function show(Event $event){
        $categories = \App\Models\Category::all();
        return view('event-detail', compact('event', 'categories'));
    }

    function checkout(){
        $categories = \App\Models\Category::all();
        return view('checkout', compact('categories'));
    }

    function ticket(){
        $categories = \App\Models\Category::all();
        $transaction = null;
        if (session()->has('transaction_id')) {
            $transaction = \App\Models\Transaction::with('event')->find(session('transaction_id'));
        }
        return view('ticket', compact('categories', 'transaction'));
    }
}
