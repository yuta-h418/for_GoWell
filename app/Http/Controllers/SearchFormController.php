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

    /**
     * 
     * 検索処理
     * 
     */

    public static $betweenKeyValue = [
        // 購入日付
        'purcDate_From' => ['column' => 'purchase_date', 'fromtoType' => 'FROM', 'table' => 'purchasehistories'],
        'purcDate_To' => ['column' => 'purchase_date', 'fromtoType' => 'TO', 'table' => 'purchasehistories'],
        // 値段
        'price_From' => ['column' => 'price', 'fromtoType' => 'FROM', 'table' => 'purchasehistories'],
        'price_To' => ['column' => 'price', 'fromtoType' => 'TO', 'table' => 'purchasehistories'],

    ];
    public static $likeKeyValue = [
        // 製品名
        'product_name' => ['column' => 'product_name', 'type' => 'string_like', 'table' => 'purchasehistories'],
    ];

    public static $InClauseKeyValue = [
        // カテゴリー
        'product_no' => ['column' => 'product_kind', 'type' => 'in_clause', 'table' => 'purchasehistories'],
        // 支払方法
        'cash_no' => ['column' => 'cash_no', 'type' => 'in_clause', 'table' => 'purchasehistories'],

    ];

    public static $INTERKeyValue = [
        // 購入月:年
        'purcYear' => ['column' => 'purchase_date', 'fromtoType' => 'FROM', 'table' => 'purchasehistories'],
        // 購入月:月
        'purcMonth' => ['column' => 'purchase_date', 'fromtoType' => 'FROM', 'table' => 'purchasehistories'],
    ];

    public function result(Request $request)
    {
        // ini_setでタイムアウト上限値を更新
        ini_set("max_execution_time", 300);
        set_time_limit(300);

        require '../vendor/autoload.php';

        $sessionData = session()->all();
        // Log::debug(__LINE__." sessionData is ".print_r($sessionData , true));

        $reqAllArr = $request->all();
        Log::debug(__LINE__ . " reqAllArr is  " . print_r($reqAllArr, true));

        if (!array_key_exists('page', $reqAllArr) || (!session()->has('wherestr') && !session()->has('fromstr'))) {
            list($fromStr, $WhereStr) = $this->makeFromAndWhere($reqAllArr);
            session()->put(['fromstr' => $fromStr, 'wherestr' => $WhereStr]);
        } else {
            $fromStr = session()->get('fromstr');
            $WhereStr = session()->get('wherestr');
        }

        // Log::debug(__LINE__ . " WhereStr is  " . print_r($WhereStr, true));

        //表示件数の値
        if (!array_key_exists('page', $reqAllArr) || !session()->has('lastnum')) {
            $lastn = 50;
            session()->put(['lastnum' => $lastn]);
        } else {
            $lastn = session()->get('lastnum');
        }

        if (array_key_exists('page', $reqAllArr)) {
            $offsetNum = ($reqAllArr['page'] - 1) * $lastn;
            $nowPage = $reqAllArr['page'];
        } else {
            $offsetNum = 0;
            $nowPage = 1;
        }

        $displayNumFrom = $offsetNum + 1;
        $displayNumTo = $nowPage * $lastn;


        //件数の値
        $countQuery = "SELECT COUNT(cusInfo.customer_id) as count ";
        $countQuery .= $fromStr;
        if($WhereStr == ""){
            $countQuery .= $WhereStr;
        }
        elseif($WhereStr != ""){
            $countQuery .= " WHERE " . $WhereStr;
        }
        // Log::debug(__LINE__ . " countQuery 4 is  " . print_r($countQuery, true));

        $queryForDataCount = DB::select(
            $countQuery
        );

        $InsExpDateFlg = "";
        $CarCalesFlg = "";
        $InsuranceFlg = "";

        $searchQuery = "SELECT
                        purchase_date as purchase_date,
                        price as price,
                        product_name as product_name,
                        product_kind as product_kind,
                        cash_no as cash_no ";

        $searchQuery .= $fromStr;

        if($WhereStr == ""){
            $searchQuery .= $WhereStr;
        }
        elseif($WhereStr != ""){
            $searchQuery .= " WHERE " . $WhereStr;
        }

        $searchQuery .= " ORDER BY purchase_date ASC ";
        $searchQuery .= " LIMIT " . $lastn . " OFFSET " . $offsetNum;

        Log::debug(__LINE__ . " Query " . print_r($searchQuery, true));

        $queryResults = DB::select(
            $searchQuery
        );

        foreach ($queryForDataCount as $rowcount) {
            $countval = $rowcount->count;
        }

        // 件数表示の設定
        if ($displayNumTo > $countval) {
            $displayNumTo = $countval;
        }

        //Session -> CSV export
        $request->session()->put('fromStr', $fromStr);
        $request->session()->put('whereStr', $WhereStr);

        $csvExSessFrom = session()->get('fromStr');
        $csvExSessWhere = session()->get('whereStr');

        // paginate設定
        $paginate = new LengthAwarePaginator(
            $queryResults, //表示する配列
            $countval, //総数
            $lastn, //表示件数
            $nowPage,  //現在のページNo.
            array('path' => $request->url()) //URL
        );

        return view('customer')->with([
            "queryResults" => $queryResults,
            "countval" => $countval,
            "lastn" => $lastn,
            "queryStr" => "",
            "searchQuery" => $searchQuery,
            "InsExpDateFlg" => $InsExpDateFlg,
            "CarCalesFlg" => $CarCalesFlg,
            "InsuranceFlg" => $InsuranceFlg,
            "paginate" => $paginate,
            "displayNumFrom" => $displayNumFrom,
            "displayNumTo" => $displayNumTo,
            'WhereStr', $request->session()->get('WhereStr'),
        ]);
    }

    /*
        From句、Where句を作成していくメソッド
    */

    // // pucHis  `purchasehistories` as pucHis
    // // proDet  `product_details` as proDet
    // // cashDet  `cash_details` as cashDet

    private function makeFromAndWhere($reqAllArr)
    {

        $WhereStr = "";
        $serviceInfo_flg = 0;
        $PosInfo_flg = 0;
        $carSalesInfo_flg = 0;
        $insurInfo_flg = 0;
        $FromStr = "";

        $reqEditArr = $reqAllArr;

        // Log::debug(__LINE__ . " reqAllArr is  " . print_r($reqAllArr, true));

        foreach ($reqAllArr as $key => $value) {

            // Log::debug(__LINE__ . " key is  " . print_r($key, true));
            // Log::debug(__LINE__ . " value is  " . print_r($value, true));

            if ($value == "") {
                continue;
            }

            // likeKeyValue
            if (array_key_exists($key, self::$likeKeyValue)) {
                if ($WhereStr != "") {
                    $WhereStr .= " AND ";
                }

                if ($key == 'product_name') {
                    $part = '1';
                    $WhereStr .= $this->makeLikeKeyValueWheresStr($reqEditArr, self::$likeKeyValue[$key]['column'], $part, 'lf_name_kana');
                    unset($reqAllArr['product_name']);
                }
            }

            // InClauseKeyValue
            if (array_key_exists($key, self::$InClauseKeyValue)) {

                if ($WhereStr != "") {
                    $WhereStr .= " AND ";
                }
                if ($key == 'product_no') {
                    $WhereStr .= $this->makeInClauseWheresStr($reqEditArr, self::$InClauseKeyValue[$key]['column'], 'product_no');
                    unset($reqAllArr->product_no);
                }
                if ($key == 'cash_no') {
                    $WhereStr .= $this->makeInClauseWheresStr($reqEditArr, self::$InClauseKeyValue[$key]['column'], 'cash_no');
                    unset($reqAllArr->cash_no);
                }
            }

            // betweenkeyValue
            if (array_key_exists($key, self::$betweenKeyValue) && array_key_exists($key, $reqEditArr)) {

                $exi = '0';

                if ($WhereStr != "") {
                    $WhereStr .= " AND ";
                }

                //for_MIC
                if (($key == 'purcDate_From' || $key == 'purcDate_To')) {
                    $WhereStr .= $this->makeFromToWheresStr($reqEditArr, self::$betweenKeyValue[$key]['column'], 'purcDate_From', 'purcDate_To', $exi);
                    unset($reqEditArr['purcDate_From'], $reqEditArr['purcDate_To']);
                }

                if (($key == 'price_From' || $key == 'price_To')) {
                    $WhereStr .= $this->makeFromToWheresStr($reqEditArr, self::$betweenKeyValue[$key]['column'], 'price_From', 'price_To', $exi);
                    unset($reqEditArr['price_From'], $reqEditArr['price_To']);
                }

            }

            // $INTERKeyValue
            if (array_key_exists($key, self::$INTERKeyValue) && array_key_exists($key, $reqEditArr)) {

                $exi = '0';

                if ($WhereStr != "") {
                    $WhereStr .= " AND ";
                }

                if (($key == 'purcYear' || $key == 'purcMonth')) {
                    $WhereStr .= $this->makeInterFromToWheresStr($reqEditArr, self::$INTERKeyValue[$key]['column'], 'purcYear', 'purcMonth', $exi);
                    unset($reqEditArr['purcYear'], $reqEditArr['purcMonth']);
                }

            }
        }

        //FROM句
        $FromStr .= "`purchasehistories` as pucHis";
        $FromStr .= " LEFT JOIN `product_details` as proDet ";
        $FromStr .= " ON pucHis.product_kind = proDet.cash_no ";
        $FromStr .= " LEFT JOIN `cash_details` as cashDet ";
        $FromStr .= " ON pucHis.cash_kind = cashDet.cash_no ";
        
        Log::debug(__LINE__ . " FromStr is " . print_r($FromStr, true));
        Log::debug(__LINE__ . " WhereStr is " . print_r($WhereStr, true));

        $FromStr = " FROM " . $FromStr;
        $retArr = [$FromStr, $WhereStr];

        // Log::debug(__LINE__ . " retArr is  " . print_r($retArr, true));

        return $retArr;
    }

    //LIKE検索
    private function makeLikeKeyValueWheresStr($reqEditArr, $columnName, $part, $likeKeyValue)
    {
        $WhereStr = "";

        $WhereStr .=  " " . $columnName . " LIKE '%" . $reqEditArr[$likeKeyValue] . "%' ";

        // Log::debug(__LINE__ . " key is " . print_r($part, true));

        return $WhereStr;
    }

    //リスト検索
    private function makeInClauseWheresStr($reqEditArr, $columnName, $InClauseKeyval)
    {
        $WhereStr = "";

        if ($reqEditArr[$InClauseKeyval] != "") {
            $InClause = implode("','", $reqEditArr[$InClauseKeyval]);
            $WhereStr .= $columnName . " IN ('$InClause') ";
        }

        // Log::debug(__LINE__ . " InClause is " . print_r($InClause, true));

        return $WhereStr;
    }

    //BETWEEN検索
    private function makeFromToWheresStr($reqEditArr, $columnName, $fromKeyval, $toKeyval, $exi)
    {
        $WhereStr = "";
        
        if ($reqEditArr[$fromKeyval] != "" && $reqEditArr[$toKeyval] != "") {
            $WhereStr .=  " BETWEEN '" .  $reqEditArr[$fromKeyval] . "' AND '" . $reqEditArr[$toKeyval] . "' ";
        } else {
            if ($reqEditArr[$fromKeyval] != "") {
                $WhereStr .= " >= '" . $reqEditArr[$fromKeyval] . "' ";
            }
            if ($reqEditArr[$toKeyval] != "") {
                $WhereStr .= " <= '" . $reqEditArr[$toKeyval] . "' ";
            }
        }
        $WhereStr = " $columnName "  .  $WhereStr;

        // if ($exi == '0' || $exi == '1') {
        // } 

        return $WhereStr;
    }

    //INTER検索
    private function makeInterFromToWheresStr($reqEditArr, $columnName, $fromKeyval, $toKeyval, $exi)
    {
        $WhereStr = "";

        // $today = Carbon::today('Asia/Tokyo')->toDateString(); //1027
        // $todaysubMonth = Carbon::today('Asia/Tokyo')->subMonth($reqEditArr[$fromKeyval])->toDateString(); //0927
        // $todayMonthBefore = Carbon::today('Asia/Tokyo')->subMonth($reqEditArr[$toKeyval])->toDateString(); //0827
        // $todayaddMonth = Carbon::today('Asia/Tokyo')->addMonth($reqEditArr[$fromKeyval])->toDateString(); //1127
        // $todayMonthAfter = Carbon::today('Asia/Tokyo')->addMonth($reqEditArr[$toKeyval])->toDateString(); //1227

        if ($reqEditArr[$fromKeyval] != "" && $reqEditArr[$toKeyval] != "") {

            $WhereStr .=  " BETWEEN '" . $todayaddMonth . "' AND '" . $todayMonthAfter . "' ";

        } else {

            if ($reqEditArr[$fromKeyval] != "") {
                $WhereStr .=  " BETWEEN '" .  $today . "' AND '" . $todayaddMonth . "' ";
            }
            if ($reqEditArr[$toKeyval] != "") {
                $WhereStr .=  " BETWEEN '" .  $today . "' AND '" . $todayMonthAfter . "' ";
            }
        }

        return $WhereStr;
        
    }

}
