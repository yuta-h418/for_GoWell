<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseFormController extends Controller
{
    public function formView(){

        $productDetails = DB::table('product_details')->get();
        $cashDetails = DB::table('cash_details')->get();

        return view('register.form')->with([
            "productDetails" => $productDetails,
            "cashDetails" => $cashDetails,
        ]);
    }
}
