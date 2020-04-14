<?php
if(isset($_POST['checked'])) {
 ?>
  <style>
  .sec01 {
    width: 80%;
    margin: auto;
  }
  div.col-sm-10 {
    text-align : left;

  }

  .col-form-label {
    text-align: right;
  }

  </style>
    <!-- 본문 -->
    <div class="sec01">
      <h3 class="sec01_title">반품 수정</h3>
      <form action="../data/process_post.php?mode=modify" method="POST">
        <?php
        $id = $_POST['checked'];
        $query = "SELECT * FROM daihan.return_post WHERE id = :id";
        $stmt = $db->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $stmt->execute(array(':id'=>$id[0]));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $reason_ex = explode('-', htmlspecialchars($row['reason']));
        $reason1 = trim($reason_ex[0]);

        if (count($reason_ex) >= 2) {
          $reason2 = $reason_ex[1];
        } else {
          $reason2 = null;
        }

        ?>

        <div class="form-group row">
          <label for="id" class="col-sm-2 col-form-label">등록 번호</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="id" id="id" value="<?=htmlspecialchars($row['id'])?>" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label for="order_number" class="col-sm-2 col-form-label">주문 번호</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="order_number" id="order_number" value="<?=htmlspecialchars($row['order_number'])?>">
          </div>
        </div>
        <div class="form-group row">
          <label for="name" class="col-sm-2 col-form-label">성 함</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="name" id="name" value="<?=htmlspecialchars($row['name'])?>">
          </div>
        </div>
        <div class="form-group row">
          <label for="tracking_number" class="col-sm-2 col-form-label">반품 송장번호</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="tracking_number" id="tracking_number" value="<?=htmlspecialchars($row['tracking_number'])?>" readonly>
          </div>
        </div>
        <div class="pay_method">
          <div class="form-group row">
            <label for="pay_method" class="col-sm-2 col-form-label">결제 방식</label>
            <div class="col-sm-10">
              <select name="pay_method" id="pay_method" class="pay_<?=htmlspecialchars($row['pay_method'])?> form-control col-md-2">
                <option id="card" value="card" <?php if(htmlspecialchars($row['pay_method']) == "card") echo "selected";?>selected>카드</option>
                <option id="card" value="cash" <?php if(htmlspecialchars($row['pay_method']) == "cash") echo "selected";?>>현금</option>
              </select>
            </div>
          </div>
        </div>
        <div class="returnReason">
          <div class="form-group row">
            <label for="reason1" class="col-sm-2 col-form-label">사 유</label>
            <div class="col-sm-10">
            <select name="reason1" id="reason" value="<?=$reason1?>">
              <option>사유 선택..</option>
              <option <?php if($reason1 == "손님 실수 반품") echo "selected";?>>손님 실수 반품</option>
              <option <?php if($reason1 == "손님 실수 교환") echo "selected";?>>손님 실수 교환</option>
              <option <?php if($reason1 == "직원 주문 접수 실수 반품") echo "selected";?>>직원 주문 접수 실수 반품</option>
              <option <?php if($reason1 == "직원 주문 접수 실수 교환") echo "selected";?>>직원 주문 접수 실수 교환</option>
              <option <?php if($reason1 == "오발송 반품") echo "selected";?>>오발송 반품</option>
              <option <?php if($reason1 == "오발송 교환") echo "selected";?>>오발송 교환</option>
              <option <?php if($reason1 == "악보 상태 불량") echo "selected";?>>악보 상태 불량</option>
              <option <?php if($reason1 == "악보 파본") echo "selected";?>>악보 파본</option>
              <option <?php if($reason1 == "기타") echo "selected";?>>기타</option>
            </select>
            <input type="text" class="form-control" name="reason2" value="<?=$reason2?>" placeholder="상세 사유">
            </div>
          </div>
        </div>
        <div class="bottom_btn">
          <button type="submit" class="btn btn-secondary" value="돌아가기" formaction="..\page\welcom.php?page=post&pg=1">돌아가기</button>
          <button type="submit" class="btn btn-secondary" value="저 장" formaction="..\data\process_post.php?mode=modify">저 장</button> <!--..\data\process_post.php?mode=modify-->
        </div>
      </form>
    </div>

    <script>

    if (document.getElementById("pay_method").className == "pay_card") {

      document.getElementById("pay_method").selectedIndex = "0";

    } else {

      document.getElementById("pay_method").selectedIndex = "1";

    }
    </script>
    <!-- 본문 끝-->
<?php

  } else {
    echo '<script language="javascript">';
    echo 'alert("수정할 목록을 선택해주세요."); location.href="../welcome.php?page=post&pg=1"';
    echo '</script>';
  }
?>
