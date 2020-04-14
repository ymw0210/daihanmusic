<style>
.sec01 {
  width: 80%;
}

</style>
<?php
if(isset($_POST['checked'])) {
 ?>

    <!-- 본문 -->
    <div class="sec01">
      <h3 class="sec01_title">환불 등록</h3>
      <form action="" method="POST">
        <?php
        $id = $_POST['checked'];
        $query = "SELECT * FROM $dbName WHERE id = :id";
        $stmt = $db->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $stmt->execute(array(':id'=>$id[0]));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        ?>

        <div class="form-group row">
          <label for="order_number" class="col-sm-2 col-form-label">주문 번호</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="order_number" id="order_number" value="<?=$row['order_number']?>">
          </div>
        </div>
        <div class="form-group row">
          <label for="name" class="col-sm-2 col-form-label">이 름</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="name" id="name" value="<?=$row['name']?>">
          </div>
        </div>
        <div class="form-group row">
          <label for="reason" class="col-sm-2 col-form-label">사 유</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="reason" id="reason" value="<?=$row['reason']?>">
          </div>
        </div>
        <div class="form-group row">
          <label for="bank" class="col-sm-2 col-form-label">은 행</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="bank" id="bank">
          </div>
        </div>
        <div class="form-group row">
          <label for="account" class="col-sm-2 col-form-label">계 좌</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="account" id="account">
          </div>
        </div>
        <div class="form-group row">
          <label for="account_name" class="col-sm-2 col-form-label">예금주</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="account_name" id="account_name">
          </div>
        </div>
        <div class="form-group row">
          <label for="return_money" class="col-sm-2 col-form-label">금 액</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="return_money" id="return_money">
          </div>
        </div>
        <button type="submit" class="btn btn-secondary" value="돌아가기" formaction="..\welcome.php?page=return&pg=1">돌아가기</button>
        <button type="submit" class="btn btn-secondary" value="저 장" formaction="..\data\process_return.php?mode=insert">저 장</button>
      </form>
    </div>

<?php
} else { ?>
    <div class="sec01">
      <h3 class="sec01_title">환불 등록</h3>
      <form action="" method="POST">
        <div class="form-group row">
          <label for="order_number" class="col-sm-2 col-form-label">주문 번호</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="order_number" id="order_number">
          </div>
        </div>
        <div class="form-group row">
          <label for="name" class="col-sm-2 col-form-label">이 름</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="name" id="name">
          </div>
        </div>
        <div class="form-group row">
          <label for="reason" class="col-sm-2 col-form-label">사 유</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="reason" id="reason">
          </div>
        </div>
        <div class="form-group row">
          <label for="bank" class="col-sm-2 col-form-label">은 행</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="bank" id="bank">
          </div>
        </div>
        <div class="form-group row">
          <label for="account" class="col-sm-2 col-form-label">계 좌</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="account" id="account">
          </div>
        </div>
        <div class="form-group row">
          <label for="account_name" class="col-sm-2 col-form-label">예금주</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="account_name" id="account_name">
          </div>
        </div>
        <div class="form-group row">
          <label for="return_money" class="col-sm-2 col-form-label">금 액</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="return_money" id="return_money">
          </div>
        </div>
        <div class="bottom_btn">
          <button type="submit" class="btn btn-secondary" value="돌아가기" formaction="..\welcome.php?page=return&pg=1">돌아가기</button>
          <button type="submit" class="btn btn-secondary" value="저 장" formaction="..\data\process_return.php?mode=insert">저 장</button>
        </div>
      </form>
    </div>
  <?php
  }
  ?>


  <!-- 본문 끝-->
