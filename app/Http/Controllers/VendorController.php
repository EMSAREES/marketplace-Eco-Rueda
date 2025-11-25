<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    // Dashboard Vendor
    public function dashboard(){
        return view('vendor.dashboard');
    }
}
