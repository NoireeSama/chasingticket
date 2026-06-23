<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partner;

class PartnerController extends Controller
{
    public function index(){
        $partners = Partner::all();
        view('admin.partners.index',compact('partners'));
    }
}
