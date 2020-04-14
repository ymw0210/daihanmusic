<?php
if(isset($_POST['checked'])) {
 ?>
  <style>
  .sec01 {
    width: 80%;
    margin: auto;
  }

  </style>
    <!-- 본문 -->
    <div class="sec01">
      <h3 class="sec01_title">반품 수정</h3>
      <form action="../data/process_return.php?mode=modify" method="POST">
        <?php
        $id = $_POST['checked'];
        $query = "SELECT * FROM daihan.return_list2 WHERE id = :id";
        $stmt = $db->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $stmt->execute(array(':id'=>$id[0]));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $title = array ('주문 번호', '이름', '사유', '은행', '계좌', '예금주', '금액');
        $row_name = array ('order_number', 'name', 'reason', 'bank', 'account', 'account_name', 'return_money');
        $contents = array ($row['order_number'], $row['name'], $row['reason'], dec($row['bank']), dec($row['account']), dec($row['account_name']), $row['return_money'] );

        ?>
          <div class="form-group row">
            <label for="id" class="col-sm-2 col-form-label">등록 번호</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="id" id="id" value="<?=$id[0]?>" readonly>
          </div>
        </div>
        <?php
        for ( $i = 0; $i < count($contents) ; $i++ ) {
          echo '<div class="form-group row">
            <label for="order_number" class="col-sm-2 col-form-label">' . $title[$i] .'</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" name="' . $row_name[$i] .'" id="' . $row_name[$i] . '" value="' . htmlspecialchars($contents[$i]) . '"></div></div>';

        }
         ?>
         <div class="bottom_btn">
           <button type="submit" class="btn btn-secondary" value="돌아가기" formaction="../welcome.php?page=return&pg=1">돌아가기</button>
           <button type="submit" class="btn btn-secondary" value="저 장">저 장</button>
           <button type="submit" class="btn btn-secondary" value="저 장" formaction="../data/process_return.php?mode=error_checked">수정요청</button>
         </div>
      </form>
    </div>
    <!-- 본문 끝-->
<?php
  } else {
    echo '<script language="javascript">';
    echo 'alert("수정할 목록을 선택해주세요."); location.href="../welcome.php?page=return&pg=1"';
    echo '</script>';
  }
?>
