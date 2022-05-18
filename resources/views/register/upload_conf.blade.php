@extends('layouts.frame', [
    'pageTitle' => 'トップページ',
])


@push('script')
    <script>
        function delconf() {
            if (window.confirm('購入履歴を削除しますか？')) {
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

        <h1>購入履歴CSVアップロード</h1>

        <p>下記、<span class="underbar">{{ $index }}件</span> の購入履歴をアップロードします。</p>

        <div id="tableContent">



            <form enctype="multipart/form-data" method="POST" action="/upload/last" name="csv_file" id="customselect">
                {{ csrf_field() }}
                @csrf

                <input type="hidden" name="csvJson" value={{ $reqAllRows }}>

                <table id="purchase_table">
                    <tbody>

                        <tr id="header">
                            <td>購入日</td>
                            <td>製品名</td>
                            <td>カテゴリー</td>
                            <td>値段</td>
                            <td>支払方法</td>
                        </tr>

                        @foreach ($reqRows as $row => $index)
                            <tr>
                                <td class="category">
                                    {{ $index['purchase_date'] }}
                                </td>

                                <td class="category">
                                    {{ $index['product_name'] }}
                                </td>

                                <td class="category">
                                    <span class="proKind">
                                        {{ $index['product_kind'] }}
                                    </span>
                                </td>

                                <td class="right">
                                    {{ number_format($index['price']) }} 円
                                </td>

                                <td class="category">
                                    @if ($index['cash_no'] == 1)
                                        <span class="cashNo_1">
                                            {{ $index['cash_kind'] }}
                                        </span>
                                    @elseif($index['cash_no'] == 2)
                                        <span class="cashNo_2">
                                            {{ $index['cash_kind'] }}
                                        </span>
                                    @elseif($index['cash_no'] == 3)
                                        <span class="cashNo_3">
                                            {{ $index['cash_kind'] }}
                                        </span>
                                    @elseif($index['cash_no'] == 4)
                                        <span class="cashNo_4">
                                            {{ $index['cash_kind'] }}
                                        </span>
                                    @elseif($index['cash_no'] == 5)
                                        <span class="cashNo_5">
                                            {{ $index['cash_kind'] }}
                                        </span>
                                    @elseif($index['cash_no'] == 6)
                                        <span class="cashNo_6">
                                            {{ $index['cash_kind'] }}
                                        </span>
                                    @elseif($index['cash_no'] == 7)
                                        <span class="cashNo_7">
                                            {{ $index['cash_kind'] }}
                                        </span>
                                    @endif
                                </td>

                            </tr>
                        @endforeach

                    </tbody>

                </table>


                <div class="uploadBtn">

                    <button type="submit" class="regist_btn">登録</button>

                    <button type="button" class="regist_btn">
                        <a href="javascript:history.back()" class="a-button">戻る</a>
                    </button>

                </div>

            </form>



        </div>

    </div>
@endsection
