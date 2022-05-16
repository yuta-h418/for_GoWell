<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchasehistory;
use Illuminate\Support\Facades\DB;
// use App\Models\Cash_details;
// use App\Models\Product_details;
use Illuminate\Support\Facades\Log;

class PurchaseHistoryController extends Controller
{
    public function historyView(){

        $purchasehistory = DB::table('purchasehistories')
        ->leftJoin('product_details','product_details.product_no', '=', 'purchasehistories.product_kind')
        ->leftJoin('cash_details','cash_details.cash_no', '=', 'purchasehistories.cash_kind')
        ->where('customer_id',1)
        ->orderby('purchase_date','desc')
        ->get();
        
        // $purchasehistory = Purchasehistory::where('customer_id', '=', 1)->get();
        // $productDetails = DB::table('product_details')->get();
        // $cashDetails = DB::table('cash_details')->get();

        Log::debug(__LINE__ . " hisory " . print_r($purchasehistory, true));


        return view('history.purchaseHistory')->with([
            "purchasehistory" => $purchasehistory,
        ]);
    }
}
