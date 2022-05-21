@extends('layouts.frame', [
    'pageTitle' => 'トップページ',
])


@push('script')
  {{-- <script>
      function delconf(){
        if(window.confirm('購入履歴を削除しますか？')){
           return true;
        }else{
           return false;
        }
      }

      function editconf(){
        if(window.confirm('購入履歴を編集しますか？')){
           return true;
        }else{
           return false;
        }
      }
  </script> --}}
@endpush

@section('contents')
    <div id="mainContent">

        <h1>購入履歴 検索</h1>

        <div id="mainArea">
            
            <form method="POST" action="/customer" id="mainform">
              {{ csrf_field() }}
              <div id="searchForm">
        
                <table id="customer-table1">
        
                  <tbody id="customer-tbody">
        
                    

                    <tr id="customer_addline1" style="">
                        <td align="left" class="tab_input_collmn_score_a">購入日付</td>
                        <td class="chgct1">
                          <input id="f1getd_p" type="checkbox" name="period" value="" class="f1GetDate">期間
                          <input id="f1getd_From_p" disabled="disabled" class="datepicker" type="text" name="f1_get_date_From_period" value="" maxlength="10" autocomplete="off" pattern="^\d{4}-\d{2}-\d{2}$">
                           ～
                          <input id="f1getd_To_p" disabled="disabled" class="datepicker" type="text" name="f1_get_date_To_period" value="" maxlength="10" autocomplete="off" pattern="^\d{4}-\d{2}-\d{2}$">
                          <span class="form_example">(例)2022-01-01 ～ 2022-12-31</span>

                        </td>
                    </tr>

                    <tr id="customer_addline1" style="">
                        <td align="left" class="tab_input_collmn_score_a">製品名</td>
                        <td class="chgct1">
                          <input id="lf_name_kana" type="text" name="lf_name_kana" value="" onchange="inputChange();">  を含む
                        </td>
                    </tr>

                    <tr id="customer_addline2" style="">
                        <td align="left" class="tab_input_collmn_score_a">カテゴリー</td>
          
                        <td class="chgct1" >
          
                          <div id="shopSelect">
                            @foreach($product_details as $row => $productKind)
                              <label>
                                <input id="shop_name" class="ck_shopList" type="checkbox" value="{{ $productKind->product_no }}" name="shop_name[]">{{ $productKind->product_kind }}
                              </label>
                            @endforeach
                          </div>
                          
                          <button type="button" class="jmodal-button" style="font-weight:bold;font-size:11px;margin:10px;" onclick="shopAllselect()" value="">全選択</button>
                          <button type="button" class="jmodal-button" style="font-weight:bold;font-size:11px;margin:10px;" onclick="shopAlllift()" value="">全解除</button>
                        </td>
                    </tr>

                    <tr id="customer_addline1" style="">
                        <td align="left" class="tab_input_collmn_score_a">値段</td>
                        <td class="chgct1">
                          <input id="f1getd_p" type="checkbox" name="period" value="" class="f1GetDate">期間
                          <input id="f1getd_From_p" disabled="disabled" class="datepicker" type="text" name="f1_get_date_From_period" value="" maxlength="10" autocomplete="off" pattern="^\d{4}-\d{2}-\d{2}$">
                           ～
                          <input id="f1getd_To_p" disabled="disabled" class="datepicker" type="text" name="f1_get_date_To_period" value="" maxlength="10" autocomplete="off" pattern="^\d{4}-\d{2}-\d{2}$">
                          <span class="form_example">(例)2022-01-01 ～ 2022-12-31</span>

                        </td>
                    </tr>

                    <tr id="customer_addline2" style="">
                        <td align="left" class="tab_input_collmn_score_a">支払方法</td>
          
                        <td class="chgct1" >
          
                          <div id="shopSelect">
                            @foreach($cash_details as $row => $cashKind)
                              <label>
                                <input id="shop_name" class="ck_shopList" type="checkbox" value="{{ $cashKind->cash_no }}" name="shop_name[]">{{ $cashKind->cash_kind }}
                              </label>
                            @endforeach
                          </div>
                          
                          <button type="button" class="jmodal-button" style="font-weight:bold;font-size:11px;margin:10px;" onclick="shopAllselect()" value="">全選択</button>
                          <button type="button" class="jmodal-button" style="font-weight:bold;font-size:11px;margin:10px;" onclick="shopAlllift()" value="">全解除</button>
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
経過日数
ペジネーション
今月/先月btn
-->
