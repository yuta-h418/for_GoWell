@extends('layouts.frame', [
'pageTitle' => 'トップページ',
])

@section('contents')
<div id="mainContent">

    <h1>購入内容登録</h1>

    <p>購入内容を登録します。フォームに入力してください。</p>

    <div id="formContent">

        <form action="/regist/conf" method="POST" id="registerForm">
            {{ csrf_field() }}
            
            <table id="register_table">
                <tbody>
                    
                    
                    <tr id="">
                        <td>
                            <span class="mustCheck">必須</span>
                        </td>
                        <td>
                           <span class="bold">購入日</span>
                        </td>
                        <td>
                            <input type="date" name="purchase_date" class="formText" required>
                        </td>
                    </tr>
    
                    <tr id="">
                        <td>
                            <span class="mustCheck">必須</span>
                        </td>
                        <td>
                            <span class="bold">製品名</span>
                        </td>
                        <td>
                            <input type="text" name="product_name" class="formText" required>
                        </td>
                    </tr>
    
                    <tr id="">
                        <td>                        
                            <span class="mustCheck">必須</span>
                        </td>
                        <td>
                            <span class="bold">カテゴリー</span>
                        </td>
                        <td>
                            
                            <select type="text" name="product_kind" class="formText" required>
                                <option>選択して下さい</option>
                                @foreach($productDetails as $pd)
                                    <option value="{{ $pd->product_no }}">{{ $pd->product_kind }}</option>
                                @endforeach
                            </select>
                            <!-- <input type="text" name="product_kind" value="{{ $pd->product_no }}" class="formText"> -->
                        </td>
                    </tr>
    
                    <tr id="">
                        <td>
                            <span class="mustCheck">必須</span>
                        </td>
                        <td>
                           <span class="bold">値段</span>
                        </td>
                        <td>
                            <input type="number" min="0" name="price" class="formText" required>
                        </td>
                    </tr>
    
                    <tr id="">
                        <td>
                            <span class="mustCheck">必須</span>
                        </td>
                        <td>
                           <span class="bold">支払方法</span>
                        </td>
                        <td>
                            <select type="text" name="cash_kind" class="formText" required>
                                <option>選択して下さい</option>
                                @foreach($cashDetails as $cd)
                                    <option value="{{ $cd->cash_no }}">{{ $cd->cash_kind }}</option>
                                @endforeach
                            </select>
                            <!-- <input type="text" name="cash_kind" value="{{ $cd->cash_no }}" class="formText"> -->
                        </td>
                    </tr>
    
                </tbody>
            </table>

            <div class="registBtn">
        
                <button type="submit" class="regist_btn">確認</button>
                <button type="reset" class="reset_btn">リセット</button>
        
            </div>
            
        </form>
        
    </div>
    
</div>
@endsection

<!-- TODO -->
<!-- 
バリデーション
-->