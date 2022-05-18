@extends('layouts.frame', [
    'pageTitle' => 'トップページ',
])


@push('script')
  <script>
      
  </script>
@endpush

@section('contents')

    <div id="mainContent">

        <h1>購入履歴CSVアップロード</h1>

        <p>アップロードするファイルを選択して下さい。</p>

        <form enctype="multipart/form-data" method="POST" action="/upload/conf" name="csv_file" id="customselect">
            {{ csrf_field() }}

            <input type="file" name="purchase_csvFile">

            <div class="uploadBtn">
        
                <button type="submit" class="regist_btn">確認</button>
                <button type="reset" class="reset_btn">リセット</button>
        
            </div>

        </form>

    </div>


    
@endsection

{{-- 
バリデーション    
--}}