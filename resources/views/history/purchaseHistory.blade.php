@extends('layouts.frame', [
'pageTitle' => 'トップページ',
])

@section('contents')
<div id="mainContent">
    <h1>購入履歴</h1>

    <div id="tableContent">
        <table id="purchase_table">
            <tbody>
                
                <tr id="header">
                    <td>購入日</td>
                    <td>製品名</td>
                    <td>カテゴリー</td>
                    <td>値段</td>
                    <td>支払方法</td>
                    <td>経過日数</td>
                    <td>操作</td>
                </tr>
                
                @foreach($purchasehistory as $row)
                <tr>
                    <td>
                        {{ $row->purchase_date }}
                    </td>
                    
                    <td>
                        {{ $row->product_name }}
                    </td>
                    
                    <td class="category">
                        <span class="proKind">
                            {{ $row->product_kind }}
                        </span>
                    </td>
                    
                    <td class="right">
                        {{ number_format($row->price) }} 円
                    </td>

                    <td class="category">
                        @if($row->cash_no == 1)
                            <span class="cashNo_1">
                              {{ $row->cash_kind }}
                            </span>
                        @elseif($row->cash_no == 2)
                            <span class="cashNo_2">
                                {{ $row->cash_kind }}
                            </span>
                        @elseif($row->cash_no == 3)
                            <span class="cashNo_3">
                                {{ $row->cash_kind }}
                            </span>
                        @elseif($row->cash_no == 4)
                            <span class="cashNo_4">
                                {{ $row->cash_kind }}
                            </span>
                        @elseif($row->cash_no == 5)
                            <span class="cashNo_5">
                                {{ $row->cash_kind }}
                            </span>
                        @elseif($row->cash_no == 6)
                            <span class="cashNo_6">
                                {{ $row->cash_kind }}
                            </span>
                        @elseif($row->cash_no == 7)
                            <span class="cashNo_7">
                                {{ $row->cash_kind }}
                            </span>
                        @endif
                    </td>
                    
                    <td>
                        {{ $row->purchase_date }}
                    </td>
                    <!-- <td>{{\Carbon\Carbon::now()->format("Y/m/d")}}->diffInMonths({{ $row->purchase_date }})</td> -->
                    
                    <td class="center">
                        <a href="" class="ediBtn">Edit</a>
                        <a href="" class="delBtn">Delete</a>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    
</div>
@endsection


<!-- TODO -->
<!-- 
経過日数
ペジネーション
今月/先月btn
btnデザイン
-->