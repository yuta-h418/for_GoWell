<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Purchasehistory;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class CSV_DownloadController extends Controller
{
    /**
     * 
     * 検索結果　CSV出力
     * 
     */

    public function csvExoprt(Request $request)
    {

        header('Content-Type: application/octet-stream');
        header("Content-Disposition: attachment; filename=".date('Y-m-d').".csv");
        header('Pragma: no-cache');
        header('Expires: 0');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate,post-check=0,pre-check=0');

        $makeCsvFile = fopen('php://output', 'w');

        //　column
        $colums = [
            'purchase_no',
            'purchase_date',
            'price',
            'product_name',
            'product_no',
            'product_kind',
            'cash_no',
            'cash_kind',
        ];

        mb_convert_variables('SJIS', 'UTF-8', $colums);
        fputcsv($makeCsvFile, $colums);

        //リスト 抽出/記述
        $reqall = $request->all();
        Log::debug(__LINE__." reqall is ".print_r($reqall , true));

        $query = $request->query;
        Log::debug(__LINE__." query is ".print_r($query , true));

        $searchQuery = Crypt::decryptString($request->query);
        Log::debug(__LINE__." searchQuery is ".print_r($searchQuery , true));

        $queryResults = DB::select($searchQuery);

        foreach ($queryResults as $row) {

            $list = [
                $row->purchase_no,
                $row->purchase_date,
                $row->price,
                $row->product_name,
                $row->product_no,
                $row->product_kind,
                $row->cash_no,
                $row->cash_kind,
            ];

            mb_convert_variables('SJIS', 'UTF-8', $list);
            fputcsv($makeCsvFile, $list);

        }

        fclose($makeCsvFile);
        exit;

        return response()->download($makeCsvFile);


    }
}
