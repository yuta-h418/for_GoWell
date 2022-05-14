<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PurchaseFormController extends Controller
{
    public function formView(){

        $productDetails = DB::table('product_details')
        ->get();

        $cashDetails = DB::table('cash_details')
        ->get();

        return view('register.form')->with([
            "productDetails" => $productDetails,
            "cashDetails" => $cashDetails,
        ]);
    }

    public function registConf(Request $request){

        $registRow = $request->all();
        Log::debug(__LINE__ . " request " . print_r($registRow, true));

        $product_kind_name = DB::table('product_details')
        ->where('product_no',$request->product_kind)
        ->value('product_kind');

        $cash_kind_name = DB::table('cash_details')
        ->where('cash_no',$request->cash_kind)
        ->value('cash_kind');

        return view('register.regist_conf')->with([
            "registRow" => $registRow,
            "product_kind_name" => $product_kind_name,
            "cash_kind_name" => $cash_kind_name,
        ]);
    }
}
