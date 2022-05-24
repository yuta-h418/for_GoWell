<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Purchasehistory;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Crypt;
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

    public static $likeKeyValue = [
        // 製品名
        'product_name' => ['column' => 'product_name', 'type' => 'string_like', 'table' => 'purchasehistories'],
    ];

    public static $InClauseKeyValue = [
        // カテゴリー
        'product_no' => ['column' => 'proDet.product_no', 'type' => 'in_clause', 'table' => 'purchasehistories'],
        // 支払方法
        'cash_no' => ['column' => 'cashDet.cash_no', 'type' => 'in_clause', 'table' => 'purchasehistories'],

    ];

    public static $betweenKeyValue = [
        // 購入日付
        'purcDate_From' => ['column' => 'purchase_date', 'fromtoType' => 'FROM', 'table' => 'purchasehistories'],
        'purcDate_To' => ['column' => 'purchase_date', 'fromtoType' => 'TO', 'table' => 'purchasehistories'],
        // 値段
        'price_From' => ['column' => 'price', 'fromtoType' => 'FROM', 'table' => 'purchasehistories'],
        'price_To' => ['column' => 'price', 'fromtoType' => 'TO', 'table' => 'purchasehistories'],

    ];

    public static $INTERKeyValue = [
        // 購入月:年
        'purcYear' => ['column' => 'purchase_date', 'fromtoType' => 'FROM', 'table' => 'purchasehistories'],
        // 購入月:月
        'purcMonth' => ['column' => 'purchase_date', 'fromtoType' => 'FROM', 'table' => 'purchasehistories'],
    ];

    public function searchResult(Request $request)
    {
        // ini_setでタイムアウト上限値を更新
        ini_set("max_execution_time", 300);
        set_time_limit(300);

        require '../vendor/autoload.php';

        $sessionData = session()->all();
        // Log::debug(__LINE__." sessionData is ".print_r($sessionData , true));

        $requestAll = $request->all();
        Log::debug(__LINE__ . " requestAll is  " . print_r($requestAll, true));

        if (!array_key_exists('page', $requestAll) || (!session()->has('wherestr') && !session()->has('fromstr'))) {
            list($fromStr, $WhereStr) = $this->makeWhereAndFrom($requestAll);
            session()->put(['fromstr' => $fromStr, 'wherestr' => $WhereStr]);
        } else {
            $fromStr = session()->get('fromstr');
            $WhereStr = session()->get('wherestr');
        }

        // Log::debug(__LINE__ . " WhereStr is  " . print_r($WhereStr, true));

        //表示件数の値
        if (!array_key_exists('page', $requestAll) || !session()->has('lastnum')) {
            $lastn = 50;
            session()->put(['lastnum' => $lastn]);
        } else {
            $lastn = session()->get('lastnum');
        }

        if (array_key_exists('page', $requestAll)) {
            $offsetNum = ($requestAll['page'] - 1) * $lastn;
            $nowPage = $requestAll['page'];
        } else {
            $offsetNum = 0;
            $nowPage = 1;
        }

        $displayNumFrom = $offsetNum + 1;
        $displayNumTo = $nowPage * $lastn;


        //件数の値
        $countQuery = "SELECT COUNT(purchase_no) as count ";
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
                        pucHis.purchase_no as purchase_no,
                        pucHis.purchase_date as purchase_date,
                        pucHis.price as price,
                        pucHis.product_name as product_name,
                        proDet.product_no as product_no,
                        proDet.product_kind as product_kind,
                        cashDet.cash_no as cash_no,
                        cashDet.cash_kind as cash_kind ";
        $searchQuery .= $fromStr;

        if($WhereStr == ""){
            $searchQuery .= $WhereStr;
        }
        elseif($WhereStr != ""){
            $searchQuery .= " WHERE " . $WhereStr;
        }

        $searchQuery .= " ORDER BY purchase_date DESC ";

        // LIMIT以下を削除して〜
        $searchValue = Crypt::encryptString($searchQuery);
        // Log::debug(__LINE__ . " searchValue " . print_r($searchValue, true));

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
        // $paginate = new LengthAwarePaginator(
        //     $queryResults, //表示する配列
        //     $countval, //総数
        //     $lastn, //表示件数
        //     $nowPage,  //現在のページNo.
        //     array('path' => $request->url()) //URL
        // );

        return view('searchResult')->with([
            "queryResults" => $queryResults,
            "countval" => $countval,
            "lastn" => $lastn,
            "queryStr" => "",
            "searchQuery" => $searchQuery,
            "searchValue" => $searchValue,
            "InsExpDateFlg" => $InsExpDateFlg,
            "CarCalesFlg" => $CarCalesFlg,
            "InsuranceFlg" => $InsuranceFlg,
            // "paginate" => $paginate,
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

    private function makeWhereAndFrom($requestAll)
    {

        $WhereStr = "";
        $FromStr = "";

        $requestEdit = $requestAll;

        // Log::debug(__LINE__ . " requestAll is  " . print_r($requestAll, true));

        foreach ($requestAll as $key => $value) {

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
                    $WhereStr .= $this->makeLikeStr($requestEdit, self::$likeKeyValue[$key]['column'], 'product_name');
                    unset($requestAll['product_name']);
                }
            }

            // InClauseKeyValue
            if (array_key_exists($key, self::$InClauseKeyValue)) {

                if ($WhereStr != "") {
                    $WhereStr .= " AND ";
                }
                if ($key == 'product_no') {
                    $WhereStr .= $this->makeIncStr($requestEdit, self::$InClauseKeyValue[$key]['column'], 'product_no');
                    unset($requestAll->product_no);
                }
                if ($key == 'cash_no') {
                    $WhereStr .= $this->makeIncStr($requestEdit, self::$InClauseKeyValue[$key]['column'], 'cash_no');
                    unset($requestAll->cash_no);
                }
            }

            // betweenkeyValue
            if (array_key_exists($key, self::$betweenKeyValue) && array_key_exists($key, $requestEdit)) {

                if ($WhereStr != "") {
                    $WhereStr .= " AND ";
                }

                if (($key == 'purcDate_From' || $key == 'purcDate_To')) {
                    $WhereStr .= $this->makeBetweenStr($requestEdit, self::$betweenKeyValue[$key]['column'], 'purcDate_From', 'purcDate_To');
                    unset($requestEdit['purcDate_From'], $requestEdit['purcDate_To']);
                }

                if (($key == 'price_From' || $key == 'price_To')) {
                    $WhereStr .= $this->makeBetweenStr($requestEdit, self::$betweenKeyValue[$key]['column'], 'price_From', 'price_To');
                    unset($requestEdit['price_From'], $requestEdit['price_To']);
                }

            }

            // $INTERKeyValue
            if (array_key_exists($key, self::$INTERKeyValue) && array_key_exists($key, $requestEdit)) {

                if ($WhereStr != "") {
                    $WhereStr .= " AND ";
                }

                if (($key == 'purcYear' || $key == 'purcMonth')) {
                    $WhereStr .= $this->makeInterStr($requestEdit, self::$INTERKeyValue[$key]['column'], 'purcYear', 'purcMonth');
                    unset($requestEdit['purcYear'], $requestEdit['purcMonth']);
                }

            }
        }

        //FROM
        $FromStr .= "`purchasehistories` as `pucHis`";
        $FromStr .= " LEFT JOIN `product_details` as `proDet` ";
        $FromStr .= " ON pucHis.product_kind = proDet.product_no ";
        $FromStr .= " LEFT JOIN `cash_details` as `cashDet` ";
        $FromStr .= " ON pucHis.cash_kind = cashDet.cash_no ";
        
        Log::debug(__LINE__ . " FromStr is " . print_r($FromStr, true));
        Log::debug(__LINE__ . " WhereStr is " . print_r($WhereStr, true));

        $FromStr = " FROM " . $FromStr;
        $retArr = [$FromStr, $WhereStr];

        // Log::debug(__LINE__ . " retArr is  " . print_r($retArr, true));

        return $retArr;
    }

    //LIKE
    private function makeLikeStr($requestEdit, $columnName, $likeKeyValue)
    {
        $WhereStr = "";

        $WhereStr .=  " " . $columnName . " LIKE '%" . $requestEdit[$likeKeyValue] . "%' ";

        // Log::debug(__LINE__ . " key is " . print_r($part, true));

        return $WhereStr;
    }

    //InClauseKey
    private function makeIncStr($requestEdit, $columnName, $InClauseKeyval)
    {
        $WhereStr = "";

        if ($requestEdit[$InClauseKeyval] != "") {
            $InClause = implode("','", $requestEdit[$InClauseKeyval]);
            $WhereStr .= $columnName . " IN ('$InClause') ";
        }

        // Log::debug(__LINE__ . " InClause is " . print_r($InClause, true));

        return $WhereStr;
    }

    //BETWEEN
    private function makeBetweenStr($requestEdit, $columnName, $fromKeyval, $toKeyval)
    {
        $WhereStr = "";
        
        if ($requestEdit[$fromKeyval] != "" && $requestEdit[$toKeyval] != "") {
            $WhereStr .=  " BETWEEN '" .  $requestEdit[$fromKeyval] . "' AND '" . $requestEdit[$toKeyval] . "' ";
        } else {
            if ($requestEdit[$fromKeyval] != "") {
                $WhereStr .= " >= '" . $requestEdit[$fromKeyval] . "' ";
            }
            if ($requestEdit[$toKeyval] != "") {
                $WhereStr .= " <= '" . $requestEdit[$toKeyval] . "' ";
            }
        }

        $WhereStr = " $columnName "  .  $WhereStr;

        return $WhereStr;
    }

    //INTER
    private function makeInterStr($requestEdit, $columnName, $InterFrom , $InterTo)
    {
        $WhereStr = "";

        if ($requestEdit[$InterFrom] != "" && $requestEdit[$InterTo] != "") {

            // Year and Month
            $firstDayMonth = Carbon::create($requestEdit[$InterFrom], $requestEdit[$InterTo], 1)->firstOfMonth()->toDateString();
            $lastDayMonth = Carbon::create($requestEdit[$InterFrom], $requestEdit[$InterTo], 1)->lastOfMonth()->toDateString();

            $WhereStr .=  " BETWEEN '" . $firstDayMonth . "' AND '" . $lastDayMonth . "' ";
            
        } elseif($requestEdit[$InterFrom] != "" && $requestEdit[$InterTo] == "") {

            // Only Year
            $firstDayOfYear = "$requestEdit[$InterFrom]-01-01";
            $lastDayOfYear = "$requestEdit[$InterFrom]-12-31";

            $WhereStr .=  " BETWEEN '" . $firstDayOfYear . "' AND '" . $lastDayOfYear . "' ";

        } elseif($requestEdit[$InterFrom] == "" && $requestEdit[$InterTo] != "") {

            // Only Month
            $today = new Carbon();
            $thisYear = $today->year;
            $firstDayYearMonth = Carbon::create($thisYear, $requestEdit[$InterTo], 1)->firstOfMonth()->toDateString();
            $lastDayYearMonth = Carbon::create($thisYear, $requestEdit[$InterTo], 1)->lastOfMonth()->toDateString();

            $WhereStr .=  " BETWEEN '" . $firstDayYearMonth . "' AND '" . $lastDayYearMonth . "' ";

        }

        $WhereStr = " $columnName "  .  $WhereStr;

        return $WhereStr;
        
    }

}
