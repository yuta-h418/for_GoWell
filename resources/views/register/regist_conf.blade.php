@extends('layouts.frame', [
'pageTitle' => 'トップページ',
])

@section('contents')
<div id="mainContent">

    <h1>購入内容登録 確認</h1>

    <p>以下、購入内容を登録します。</p>

    <div id="formContent">

        <form action="" method="POST" id="registerForm">
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
                           {{ $registRow['product_kind_name'] }}
                           <input type="hidden" name="product_kind" value="{{ $registRow['product_kind'] }}" class="formText">
                        </td>
                    </tr>
    
                    <tr id="">
                        <td>
                           <span class="bold">値段</span>
                        </td>
                        <td>
                            {{ $registRow['price'] }}
                            <input type="hidden" name="price" value="{{ $registRow['purchase_date'] }}" class="formText">
                        </td>
                    </tr>
    
                    <tr id="">
                        <td>
                           <span class="bold">支払方法</span>
                        </td>
                        <td>
                            {{ $registRow['cash_kind_name'] }}
                            <input type="hidden" name="cash_kind" value="{{ $registRow['cash_kind'] }}" class="formText">
                        </td>
                    </tr>
    
                </tbody>
            </table>

            
        </form>
        
    </div>
    <div class="registBtn">

        <button type="submit" class="">確認</button>
        <button href="" class="">リセット</button>

    </div>
    
</div>
@endsection

<!-- TODO -->
<!-- 
バリデーション
ボタンCSS
-->