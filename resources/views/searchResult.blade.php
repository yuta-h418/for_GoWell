@extends('layouts.frame', [
    'pageTitle' => 'トップページ',
])


@push('script')
    <script>
        function dlconf() {
            if (window.confirm('検索結果をCSVへ出力しますか？')) {
                return true;
            } else {
                return false;
            }
        }

        function editconf() {
            if (window.confirm('購入履歴を編集しますか？')) {
                return true;
            } else {
                return false;
            }
        }
    </script>
@endpush

@section('contents')
    <div id="mainContent">
        <h1>購入履歴　検索結果</h1>

        <div class="dlbtn">

            <button type="button" class="EdiDelBtn">
                <a href="javascript:history.back()" class="a-button">戻る</a>
            </button>

            <form action="/search/download" method="POST" name="DLform" class="operation_btn">
                {{ csrf_field() }}
                @csrf

                <input type="hidden" name="query" value="{{ $searchValue }}">

                <button type="submit" class="EdiDelBtn" onclick="return dlconf()">
                    <a class="a-button">CSV出力</a>
                </button>

            </form>
        </div>

        <div id="tableContent">
            <table id="purchase_table">
                <tbody>

                    <tr id="header">
                        <td>購入日</td>
                        <td>製品名</td>
                        <td>カテゴリー</td>
                        <td>値段</td>
                        <td>支払方法</td>
                        <td>操作</td>
                    </tr>

                    @foreach ($queryResults as $row)
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
                                @if ($row->cash_no == 1)
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

                            <td class="center">
                                <form action="/purchase_history/delete" method="POST" name="Delform" class="operation_btn">
                                    {{ csrf_field() }}
                                    @csrf

                                    <input type="hidden" name="del_no" value="{{ $row->purchase_no }}">

                                    <button type="button" class="EdiDelBtn">
                                        <a href="#modal-edit-{{ $row->purchase_no }}" class="a-button">Edit</a>
                                    </button>

                                    <button type="submit" class="EdiDelBtn" onclick="return delconf()">
                                        <a>Delete</a>
                                    </button>

                                </form>
                            </td>

                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

    </div>


    {{-- <!-- 購入履歴編集モーダル --> --}}

    {{-- @foreach ($queryResults as $editItems)

        <div class="modal-wrapper" id="modal-edit-{{ $editItems->purchase_no }}">
            
            <a href="javascript:void(0);"></a>
            <div class="modal-window" style="height: auto;max-height:90vh;padding-top:0;">
                
                <div id="modal-content jmodal-content formContent" style="max-height:initial;">

                    <h1>購入履歴編集</h1>

                    <form action="/purchase_history/edit" method="POST" id="registerForm">
                        {{ csrf_field() }}

                        <input type="hidden" name="purchase_no" value="{{ $editItems->purchase_no }}">
                        
                        <table id="register_table">
                            <tbody>
                                
                                <tr id="">
                                    <td>
                                       <span class="bold">購入日</span>
                                    </td>
                                    <td>
                                        <input type="date" name="purchase_date" class="formText" value="{{ $editItems->purchase_date }}" require>
                                    </td>
                                </tr>
                
                                <tr id="">
                                    <td>
                                        <span class="bold">製品名</span>
                                    </td>
                                    <td>
                                        <input type="text" name="product_name" class="formText" value="{{ $editItems->product_name }}" require>
                                    </td>
                                </tr>
                
                                <tr id="">
                                    <td>
                                        <span class="bold">カテゴリー</span>
                                    </td>
                                    <td>
                                        
                                        <select type="text" name="product_kind" class="formText" require>
                                            <option>選択して下さい</option>
                                            @foreach ($productDetails as $pd)
                                                <option value="{{ $pd->product_no }}" @if ($editItems->product_no == $pd->product_no) selected @endif>{{ $pd->product_kind }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                
                                <tr id="">
                                    <td>
                                       <span class="bold">値段</span>
                                    </td>
                                    <td>
                                        <input type="number" min="0" name="price" class="formText" value="{{ $editItems->price }}" require>
                                    </td>
                                </tr>
                
                                <tr id="">
                                    <td>
                                       <span class="bold">支払方法</span>
                                    </td>
                                    <td>
                                        <select type="text" name="cash_kind" class="formText" require>
                                            <option>選択して下さい</option>
                                            @foreach ($cashDetails as $cd)
                                                <option value="{{ $cd->cash_no }}" @if ($editItems->cash_no == $cd->cash_no) selected @endif>{{ $cd->cash_kind }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                
                            </tbody>
                        </table>
            
                        <div class="registBtn">
                    
                            <button type="submit" class="jmodal-button" onclick="return editconf()">登録</button>
                            <button type="button" class="jmodal-button">
                                <a href="#!" class="a-button">閉じる</a>
                            </button>
            
                        </div>
                        
                    </form>
                    
                </div>

            </div>
        </div>
    @endforeach --}}
@endsection


<!-- TODO -->
<!--
経過日数
ペジネーション
今月/先月btn
-->
