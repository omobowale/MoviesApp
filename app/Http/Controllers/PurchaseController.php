<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Purchase;
use App\User;

class PurchaseController extends Controller
{

    
    public function index(){
        $authuser = Auth::user();

        $purchases = User::find($authuser->id)->purchases;

        return view('purchases.index')->with('purchases', $purchases);
    }
}
