<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchasehistory;
use Illuminate\Support\Facades\DB;
use SplFileObject;
use Illuminate\Support\Facades\Validator;
// use App\Models\Cash_details;
// use App\Models\Product_details;
use Illuminate\Support\Facades\Log;

class PurchaseHistory_uploadController extends Controller
{
    public function uploadformView(){

        return view('register.upload_form');

    }
    
    public function uploadConf(Request $request){

        // setlocaleを設定
        setlocale(LC_ALL, 'ja_JP.UTF-8');

        //ファイル取得
        $uploaded_file = $request->file('purchase_csvFile');

        //ファイルが存在しない場合はリダイレクト
        // if ($uploaded_file == "") {
        //     return redirect('/customer/upload/new');
        // }

        //fileパスを取得/読み込み
        $file_path = $request->file('purchase_csvFile')->path($uploaded_file);

        // 読み込んだファイルをUTF-8に変換して保存
        file_put_contents($file_path, mb_convert_encoding(file_get_contents($file_path), 'UTF-8', 'SJIS,UTF-8,ASCII,eucJP-win,SJIS-win,JIS'));

        // UTF-8に変換したデータをSplFileObjectでCSVとして読み込み
        $file = new SplFileObject($file_path);
        $file->setCsvControl("\t");
        $file->setFlags(
            SplFileObject::READ_CSV |
                SplFileObject::READ_AHEAD |
                SplFileObject::SKIP_EMPTY |
                SplFileObject::DROP_NEW_LINE
        );

        foreach ($file as $index => $row) {

            $file = explode(",", $row[0]);

            $product_no = DB::table('product_details')
            ->where('product_kind',$file[2])
            ->value('product_no');

            $cashNo = DB::table('cash_details')
            ->where('cash_kind',$file[4])
            ->value('cash_no');

            //データまとめ
            $reqRows[] = [
                'purchase_date' => $file[0],
                'product_name' => $file[1],
                'product_kind' => $file[2],
                'product_no' => $product_no,
                'price' => $file[3],
                'cash_kind' => $file[4],
                'cash_no' => $cashNo,
            ];


        }

        //ヘッダー削除
        array_splice($reqRows, 0, 1);

        // Log::debug(__LINE__ . " requestRow " . print_r($reqRows, true));
        
        // Log::debug(__LINE__ . " index " . print_r($index, true));



        //JSONへ変換
        $reqAllRows = json_encode($reqRows);


        return view('register.upload_conf')->with([
            "reqRows" => $reqRows,
            "reqAllRows" => $reqAllRows,
            "index" => $index,
        ]);

    }

    public function uploadRegist(Request $request){

        $reqall = json_decode($request->csvJson);

        //TODO : 分割して挿入

        $uploadReq = [];

        foreach($reqall as $key => $row){

            $purchase_no = Purchasehistory::max('purchase_no') + $key + 1;
            $purchase_date = $row->purchase_date;
            $product_name = $row->product_name;
            $product_kind = $row->product_no;
            $price = $row->price;
            $cash_kind = $row->cash_no;
            $customer_id = 1;

            $uploadList = [
                "purchase_no" => "$purchase_no",
                "purchase_date" => "$purchase_date",
                "product_name" => "$product_name",
                "product_kind" => "$product_kind",
                "price" => "$price",
                "cash_kind" => "$cash_kind",
                "customer_id" => "$customer_id",
            ];

            array_push($uploadReq,$uploadList);

        }

        // Log::debug(__LINE__ . " uploadReq " . print_r($uploadReq, true));

        Purchasehistory::insert($uploadReq);

        return view('register.upload_last');

    }
}
