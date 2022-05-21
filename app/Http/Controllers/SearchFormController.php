<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Purchasehistory;
use Illuminate\Support\Facades\Log;

class SearchFormController extends Controller
{
     /**
     * 
     * 検索フォーム
     * 
     */
    public function searchForm()
    {
        $product_details = DB::table('product_details')
        ->get();

        $cash_details = DB::table('cash_details')
        ->get();

        return view('searchForm')->with([
            "product_details" => $product_details,
            "cash_details" => $cash_details,
        ]);
    }
}
