
<style>
  .sec01 {
    width: 80%;
    margin: auto;
  }

  div.col-sm-10 {
    text-align : left;

  }

  div.pay_method, .returnReason{
    display: none;
  }

  .col-form-label {
    text-align: right;
  }
</style>
  <!-- 본문 -->
  <div class="sec01">
    <h3 class="sec01_title">택배 등록</h3>
    <form action="" method="POST">
      <div class="form-group row">
        <label for="reqType" class="col-sm-2 col-form-label">택배 유형</label>
        <div class="col-sm-10">
          <select name="reqType" id="reqType" onchange="itemChange()" class="form-control col-md-2">
            <option>선택</option>
            <option value="1" required>신규</option>
            <option value="2" required>반품</option>
          </select>

              <!--
          <input type="radio" name="reqType" id="new" value="1" required>신규
          <input type="radio" name="reqType" id="return" value="2" required>반품-->

        </div>
      </div>
      <div class="pay_method">
        <div class="form-group row">
          <label for="pay_method" class="col-sm-2 col-form-label">결제 방식</label>
          <div class="col-sm-10">
            <select name="pay_method" id="pay_method" class="form-control col-md-2">
            </select>
          </div>
        </div>
      </div>
      <div class="returnReason">
        <div class="form-group row">
          <label for="reason" class="col-sm-2 col-form-label">사 유</label>
          <div class="col-sm-10">
          <select name="reason1" id="reason" class="form-control col-md-3">
            <option>사유 선택..</option>
            <option>손님 실수 반품</option>
            <option>손님 실수 교환</option>
            <option>직원 주문 접수 실수 반품</option>
            <option>직원 주문 접수 실수 교환</option>
            <option>오발송 반품</option>
            <option>오발송 교환</option>
            <option>악보 상태 불량</option>
            <option>악보 파본</option>
            <option>기타</option>
          </select>
          <input type="text" class="form-control" name="reason2" placeholder="상세 사유">
          </div>
        </div>
      </div>
      <div class="form-group row">
        <label for="orderNo" class="col-sm-2 col-form-label">주문 번호</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="orderNo" id="orderNo" placeholder="주문 번호">
        </div>
      </div>
      <div class="form-group row">
        <label for="recNm" class="col-sm-2 col-form-label">성 함</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="recNm" id="recNm" placeholder="고객 이름">
        </div>
      </div>
      <div class="form-group row">
        <label for="recMob" class="col-sm-2 col-form-label">전화 번호</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="recMob" id="recMob" placeholder="전화번호">
        </div>
      </div>

      <div class="form-group row">
       <label for="recZip" class="col-sm-2 col-form-label">우편 번호</label>
        <div class="col-sm-10">
          <input type="text" id="sample2_postcode" name="recZip" placeholder="우편번호">
          <input type="button" onclick="sample2_execDaumPostcode()" value="우편번호 찾기">
        </div>
      </div>
      <div class="form-group row">
        <label for="recAddr1" class="col-sm-2 col-form-label">주 소</label>
        <div class="col-sm-10">
          <input type="text" id="sample2_address" class="form-control" name="recAddr1" placeholder="주소">
          <input type="text" id="sample2_extraAddress" class="form-control" name="recAddExtra" placeholder="참고항목">
        </div>
      </div>
      <div class="form-group row">
        <label for="recAddr2" class="col-sm-2 col-form-label">상세주소</label>
        <div class="col-sm-10">
          <input type="text" id="sample2_detailAddress" class="form-control" name="recAddr2" placeholder="상세주소">

        </div>
      </div>

     <!-- iOS에서는 position:fixed 버그가 있음, 적용하는 사이트에 맞게 position:absolute 등을 이용하여 top,left값 조정 필요 -->
       <div id="layer" style="display:none;position:fixed;overflow:hidden;z-index:1;-webkit-overflow-scrolling:touch;">
         <img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnCloseLayer" style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:1" onclick="closeDaumPostcode()" alt="닫기 버튼">
       </div>
     <!--
     <div class="form-group row">
       <label for="name" class="col-sm-2 col-form-label">recTel</label>
       <div class="col-sm-10">
         <input type="text" class="form-control" name="recTel">
       </div>
     </div>
       <div class="form-group row">
         <label for="name" class="col-sm-2 col-form-label">goodsNm</label>
         <div class="col-sm-10">
           <input type="text" class="form-control" name="goodsNm" value="악보" disabled>
         </div>
       </div>
     -->
       <div class="bottom_btn">
        <button type="submit" class="btn btn-secondary" value="돌아가기" formaction="..\page\welcome_page.php?page=post_list_page.php&pg=1">돌아가기</button>
        <button type="submit" class="btn btn-secondary" value="저 장" formaction="..\data\process_post.php?mode=insert">저 장</button>
        <button type="button" class="btn btn-secondary" onclick="seocho()">서초 택배</button>
      </div>
    </form>
  </div>

  <script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
  <script>
      // 우편번호 찾기 화면을 넣을 element
      var element_layer = document.getElementById('layer');

      function closeDaumPostcode() {
          // iframe을 넣은 element를 안보이게 한다.
          element_layer.style.display = 'none';
      }

      function sample2_execDaumPostcode() {
          new daum.Postcode({
              oncomplete: function(data) {
                  // 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                  // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                  // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                  var addr = ''; // 주소 변수
                  var extraAddr = ''; // 참고항목 변수

                  //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                  if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                      addr = data.roadAddress;
                  } else { // 사용자가 지번 주소를 선택했을 경우(J)
                      addr = data.jibunAddress;
                  }

                  // 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
                  if(data.userSelectedType === 'R'){
                      // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                      // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                      if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
                          extraAddr += data.bname;
                      }
                      // 건물명이 있고, 공동주택일 경우 추가한다.
                      if(data.buildingName !== '' && data.apartment === 'Y'){
                          extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                      }
                      // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                      if(extraAddr !== ''){
                          extraAddr = ' (' + extraAddr + ')';
                      }
                      // 조합된 참고항목을 해당 필드에 넣는다.
                      document.getElementById("sample2_extraAddress").value = extraAddr;

                  } else {
                      document.getElementById("sample2_extraAddress").value = '';
                  }

                  // 우편번호와 주소 정보를 해당 필드에 넣는다.
                  document.getElementById('sample2_postcode').value = data.zonecode;
                  document.getElementById("sample2_address").value = addr;
                  // 커서를 상세주소 필드로 이동한다.
                  document.getElementById("sample2_detailAddress").focus();

                  // iframe을 넣은 element를 안보이게 한다.
                  // (autoClose:false 기능을 이용한다면, 아래 코드를 제거해야 화면에서 사라지지 않는다.)
                  element_layer.style.display = 'none';
              },
              width : '100%',
              height : '100%',
              maxSuggestItems : 5
          }).embed(element_layer);

          // iframe을 넣은 element를 보이게 한다.
          element_layer.style.display = 'block';

          // iframe을 넣은 element의 위치를 화면의 가운데로 이동시킨다.
          initLayerPosition();
      }

      // 브라우저의 크기 변경에 따라 레이어를 가운데로 이동시키고자 하실때에는
      // resize이벤트나, orientationchange이벤트를 이용하여 값이 변경될때마다 아래 함수를 실행 시켜 주시거나,
      // 직접 element_layer의 top,left값을 수정해 주시면 됩니다.
      function initLayerPosition(){
          var width = 300; //우편번호서비스가 들어갈 element의 width
          var height = 400; //우편번호서비스가 들어갈 element의 height
          var borderWidth = 5; //샘플에서 사용하는 border의 두께

          // 위에서 선언한 값들을 실제 element에 넣는다.
          element_layer.style.width = width + 'px';
          element_layer.style.height = height + 'px';
          element_layer.style.border = borderWidth + 'px solid';
          // 실행되는 순간의 화면 너비와 높이 값을 가져와서 중앙에 뜰 수 있도록 위치를 계산한다.
          element_layer.style.left = (((window.innerWidth || document.documentElement.clientWidth) - width)/2 - borderWidth) + 'px';
          element_layer.style.top = (((window.innerHeight || document.documentElement.clientHeight) - height)/2 - borderWidth) + 'px';
      }

      function seocho() {

        $('#reqType').val("1");
        $('#orderNo').val('123456789');
        $('#recNm').val('대한음악사');
        $('#recMob').val('02-597-3157');
        $('#sample2_postcode').val('06757');
        $('#sample2_address').val('서울 서초구 남부순환로 2406');
        $('#sample2_extraAddress').val('(서초동)');
        $('#sample2_detailAddress').val('비타민스테이션 내 대한음악사');

      }

      function itemChange(){

        var changeValue = ["card","cash"];

        var changeElement = ["카드","현금"];

        var selectItem = $("#reqType").val();

        var changeItem;

        if(selectItem == "2"){
          changeV = changeValue;
          changeE = changeElement;

          $('.pay_method').show();
          $('.returnReason').show();

        } else {
          $('.pay_method').hide();
          $('.returnReason').hide();
        }


        $('#pay_method').empty();

        for(var count = 0; count < changeV.length; count++){
                        var option = $("<option value="+changeV[count]+">"+changeE[count]+"</option>");
                        $('#pay_method').append(option);
              }

  }

    </script>
  <!-- 본문 끝-->
