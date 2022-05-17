@extends('layouts.frame', [
'pageTitle' => 'トップページ',
])

@section('contents')
<div id="mainContent">

    <h1>購入内容登録 確認</h1>

    <p>以下、購入内容を登録します。</p>

    <div id="formContent">

        <form action="/regist/last" method="POST" id="registerForm">
            {{ csrf_field() }}
            <table id="register_table">
                <tbody>
                    
                    
                    <tr id="">
                        <td>
                           <span class="bold">購入日</span>
                        </td>
                        <td>
                            {{ $registRow['purchase_date'] }}
                            <input type="hidden" name="purchase_date" value="{{ $registRow['purchase_date'] }}" class="formText" >
                        </td>
                    </tr>
    
                    <tr id="">
                        <td>
                            <span class="bold">製品名</span>
                        </td>
                        <td>
                            {{ $registRow['product_name'] }}
                            <input type="hidden" name="product_name" value="{{ $registRow['product_name'] }}" class="formText">
                        </td>
                    </tr>
    
                    <tr id="">
                        <td>
                            <span class="bold">カテゴリー</span>
                        </td>
                        <td>
                           {{ $product_kind_name }}
                           <input type="hidden" name="product_kind" value="{{ $registRow['product_kind'] }}" class="formText">
                        </td>
                    </tr>
    
                    <tr id="">
                        <td>
                           <span class="bold">値段</span>
                        </td>
                        <td>
                            {{ $registRow['price'] }}
                            <input type="hidden" name="price" value="{{ $registRow['price'] }}" class="formText">
                        </td>
                    </tr>
    
                    <tr id="">
                        <td>
                           <span class="bold">支払方法</span>
                        </td>
                        <td>
                            {{ $cash_kind_name }}
                            <input type="hidden" name="cash_kind" value="{{ $registRow['cash_kind'] }}" class="formText">
                        </td>
                    </tr>
    
                </tbody>
            </table>

            <div class="registBtn">
                    
                <button type="submit" class="jmodal-button">登録</button>
                <button type="button" class="jmodal-button">
                    <a href="javascript:history.back()" class="a-button">戻る</a>
                </button>

            </div>
            
        </form>
        
    </div>
    
    
</div>
@endsection
