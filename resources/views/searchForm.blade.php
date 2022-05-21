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
                        <td class="itemName">購入年月</td>
                        <td class="">
                            年：
                            <select type="text" name="purcYear" class="formText">
                                <option>選択して下さい</option>
                                <option value="2018">2018</option>
                                <option value="2019">2019</option>
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                                <option value="2027">2027</option>
                                <option value="2028">2028</option>
                            </select>

                            <span style="margin-left:30px;">月：</span>
                            <select type="text" name="purcMonth" class="formText">
                                <option>選択して下さい</option>
                                <option value="1">1月</option>
                                <option value="2">2月</option>
                                <option value="3">3月</option>
                                <option value="4">4月</option>
                                <option value="5">5月</option>
                                <option value="6">6月</option>
                                <option value="7">7月</option>
                                <option value="8">8月</option>
                                <option value="9">9月</option>
                                <option value="10">10月</option>
                                <option value="11">11月</option>
                                <option value="12">12月</option>
                            </select>
 
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
