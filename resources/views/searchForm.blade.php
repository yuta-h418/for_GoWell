@extends('layouts.frame', [
    'pageTitle' => 'トップページ',
])


@push('script')
  <script>
    function proAllselect() {
      var proName = document.getElementsByName("product_no[]");
      for(i=0;i<proName.length;i++) {
        proName[i].checked = true;
      }
    }
    function proAlllift() {
      var proName = document.getElementsByName("product_no[]");
      for(i=0;i<proName.length;i++) {
        proName[i].checked = false;
      }
    }

    function cashAllselect() {
      var cashName = document.getElementsByName("cash_no[]");
      for(i=0;i<cashName.length;i++) {
        cashName[i].checked = true;
      }
    }
    function cashAlllift() {
      var cashName = document.getElementsByName("cash_no[]");
      for(i=0;i<cashName.length;i++) {
        cashName[i].checked = false;
      }
    }
  </script>
@endpush

@section('contents')
    <div id="mainContent">

        <h1>購入履歴 検索</h1>

        <div id="mainArea">
            
            <form method="POST" action="/customer" id="mainform">
              {{ csrf_field() }}
              <div id="searchForm">
        
                <table id="search_table">

                  <tbody>
        
                    <tr id="" style="">
                        <td class="itemName">購入日付</td>
                        <td class="">
                          <input class="formText" type="date" name="purcDate_From" value="">
                           ～
                          <input class="formText" type="date" name="purcDate_To" value="">
 
                        </td>
                    </tr>

                    <tr id="" style="">
                        <td class="itemName">製品名</td>
                        <td class="">
                          <input class="formText" type="text" name="product_name" value="">  を含む
                        </td>
                    </tr>

                    <tr id="" style="">
                        <td class="itemName">カテゴリー</td>
          
                        <td class="" >
          
                          <div id="checkSelect">
                            @foreach($product_details as $row => $productKind)
                                <label>
                                   <input type="checkbox" value="{{ $productKind->product_no }}" name="product_no[]">{{ $productKind->product_kind }}
                                </label>
                            @endforeach
                          </div>
                          
                          <button type="button" class="regist_btn" onclick="proAllselect()" value="">全選択</button>
                          <button type="button" class="regist_btn" onclick="proAlllift()" value="">全解除</button>
                        </td>
                    </tr>

                    <tr id="" style="">
                        <td class="itemName">値段</td>
                        <td class="">
                          <input class="formText" type="number" min="0" name="price_From" value="">
                           ～
                          <input class="formText" type="number" min="0" name="price_To" value="">

                        </td>
                    </tr>

                    <tr id="" style="">
                        <td class="itemName">支払方法</td>
          
                        <td class="" >
          
                          <div id="checkSelect">
                            @foreach($cash_details as $row => $cashKind)
                                <label>
                                   <input type="checkbox" value="{{ $cashKind->cash_no }}" name="cash_no[]">{{ $cashKind->cash_kind }}
                                </label>
                            @endforeach
                          </div>
                          
                          <button type="button" class="regist_btn" onclick="cashAllselect()" value="">全選択</button>
                          <button type="button" class="regist_btn" onclick="cashAlllift()" value="">全解除</button>
                        </td>
                    </tr>
                    
                  </tbody>
                </table>

                <div class="registBtn">
        
                    <button type="submit" class="regist_btn">検索</button>
                    <button type="reset" class="reset_btn">リセット</button>
            
                </div>


              </div>
            </form>
        
          </div>
        
        </div>

        

    </div>



@endsection


<!-- TODO -->
<!--
選択肢CSS（product/cash）
-->
