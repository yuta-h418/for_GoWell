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

            //データまとめ
            $reqRows[] = [
                'purchase_date' => $file[0],
                'product_name' => $file[1],
                'product_kind' => $file[2],
                'price' => $file[3],
                'cash_kind' => $file[4],
            ];


        }

        //ヘッダー削除
        array_splice($reqRows, 0, 1);

        Log::debug(__LINE__ . " requestRow " . print_r($reqRows, true));

        //JSONへ変換
        $reqAllRows = json_encode($reqRows);


        // return view('register.upload_conf')->with([
        //     "reqRows" => $reqRows,
        // ]);

    }
}
