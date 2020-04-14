<?php
include('..\session.php');

switch ($_GET['mode']) {
  case 'insert':
    $order_number = htmlspecialchars($_POST['order_number']);
    $name = htmlspecialchars($_POST['name']);
    $reason = htmlspecialchars($_POST['reason']);
    $ec_bank = ec(htmlspecialchars($_POST['bank']));
    $ec_account = ec(htmlspecialchars($_POST['account']));
    $ec_account_name = ec(htmlspecialchars($_POST['account_name']));
    $return_money = htmlspecialchars($_POST['return_money']);

    $query = "INSERT INTO daihan.return_list2 (date, order_number, name, reason, bank, account, account_name, return_money, submit_id, checked ) VALUES ( NOW(), :order_number, :name, :reason, :ec_bank, :ec_account, :ec_account_name, :return_money, :login_session , '')";
    $stmt = $db->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $stmt->execute(array(
      ':order_number'=>$order_number,
        ':name'=>$name,
        ':reason'=>$reason,
        ':ec_bank'=>$ec_bank,
        ':ec_account'=>$ec_account,
        ':ec_account_name'=>$ec_account_name,
        ':return_money'=>$return_money,
        ':login_session'=>$login_session
      ));

      $count = $stmt->rowCount();

      if($count>0){
        echo '<script language="javascript">';
        echo 'alert("저장이 완료되었습니다."); location.href="../welcome.php?page=return&pg=1"';
        echo '</script>';

      } else {
        echo "<script>alert('오류가 발생하였습니다. 담당자에게 문의해주세요.')\;</script>";
      }
    break;

    case 'modify':
      $id = htmlspecialchars($_POST['id']);
      $order_number = htmlspecialchars($_POST['order_number']);
      $name = htmlspecialchars($_POST['name']);
      $reason = htmlspecialchars($_POST['reason']);
      $ec_bank = ec(htmlspecialchars($_POST['bank']));
      $ec_account = ec(htmlspecialchars($_POST['account']));
      $ec_account_name = ec(htmlspecialchars($_POST['account_name']));
      $return_money = htmlspecialchars($_POST['return_money']);

      $query = "UPDATE daihan.return_list2 SET
        order_number = :order_number,
        name = :name,
        reason = :reason,
        bank = :ec_bank,
        account = :ec_account,
        account_name = :ec_account_name,
        return_money = :return_money,
        checked = '0' WHERE id = :id";

      $stmt = $db->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
      $stmt->execute(array(
        ':order_number'=>$order_number,
          ':name'=>$name,
          ':reason'=>$reason,
          ':ec_bank'=>$ec_bank,
          ':ec_account'=>$ec_account,
          ':ec_account_name'=>$ec_account_name,
          ':return_money'=>$return_money,
          ':id'=>$id
        ));

        $count = $stmt->rowCount();

        if($count>0){
          echo '<script language="javascript">';
          echo 'alert("저장이 완료되었습니다."); location.href="../welcome.php?page=return&pg=1"';
          echo '</script>';

          } else {
            echo "<script>alert('오류가 발생하였습니다. 담당자에게 문의해주세요.')\;</script>";
          }
    break;

    case 'checked':
      if(isset($_POST['checked'])){

        $checked = $_POST['checked'];

        foreach( $checked as $value ) {

          $query = "UPDATE daihan.return_list2 SET checked = '1' WHERE id = $value";
          $stmt = $db->query($query);

          $count = $stmt->rowCount();

          if($count>0){
            echo '<script language="javascript">';
            echo 'alert("저장이 완료되었습니다."); location.href="../welcome.php?page=return&pg=1"';
            echo '</script>';

            } else {
              echo "<script>alert('오류가 발생하였습니다. 담당자에게 문의해주세요.')\;</script>";
            }
          }
        } else {
          echo '<script language="javascript">';
          echo 'alert("데이터확인을 체크해 주세요."); location.href="../welcome.php?page=return&pg=1"';
          echo '</script>';
        }
    break;

    case 'error_checked':

    $id = htmlspecialchars($_POST['id']);
    $order_number = htmlspecialchars($_POST['order_number']);
    $name = htmlspecialchars($_POST['name']);
    $reason = htmlspecialchars($_POST['reason']);
    $ec_bank = ec(htmlspecialchars($_POST['bank']));
    $ec_account = ec(htmlspecialchars($_POST['account']));
    $ec_account_name = ec(htmlspecialchars($_POST['account_name']));
    $return_money = htmlspecialchars($_POST['return_money']);


    $query = "UPDATE daihan.return_list2 SET
      order_number = :order_number,
      name = :name,
      reason = :reason,
      bank = :ec_bank,
      account = :ec_account,
      account_name = :ec_account_name,
      return_money = :return_money,
      checked = '2' WHERE id = :id";

      $stmt = $db->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
      $stmt->execute(array(
        ':order_number'=>$order_number,
          ':name'=>$name,
          ':reason'=>$reason,
          ':ec_bank'=>$ec_bank,
          ':ec_account'=>$ec_account,
          ':ec_account_name'=>$ec_account_name,
          ':return_money'=>$return_money,
          ':id'=>$id
        ));

        $count = $stmt->rowCount();

        if($count>0){
          echo '<script language="javascript">';
          echo 'alert("저장이 완료되었습니다."); location.href="../welcome.php?page=return&pg=1"';
          echo '</script>';

          } else {
            echo "<script>alert('오류가 발생하였습니다. 담당자에게 문의해주세요.')\;</script>";
          }

    break;

    case 'del':

    $id = $_POST['checked'];

    $query = "DELETE FROM daihan.return_list2 WHERE id = :id";


      $stmt = $db->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
      $stmt->execute(array(
        ':id'=>$id[0]
        ));

        $count = $stmt->rowCount();


        if($count>0){
          echo '<script language="javascript">';
          echo 'alert("삭제되었습니다."); location.href="../welcome.php?page=return&pg=1"';
          echo '</script>';

          } else {
            echo "<script>alert('오류가 발생하였습니다. 담당자에게 문의해주세요.')\;</script>";
          }

    break;

    case 'checked_cancel':


      if(isset($_POST['checked'])){

        $checked = $_POST['checked'];

        foreach( $checked as $value ) {

          $query = "UPDATE daihan.return_list2 SET checked = '0' WHERE id = $value";
          $stmt = $db->query($query);

          $count = $stmt->rowCount();
          if($count>0){
            echo '<script language="javascript">';
            echo 'alert("저장이 완료되었습니다."); location.href="../welcome.php?page=return&pg=1"';
            echo '</script>';

            } else {
              echo "<script>alert('오류가 발생하였습니다. 담당자에게 문의해주세요.')\;</script>";
            }
          }
        } else {
          echo '<script language="javascript">';
          echo 'alert("데이터확인을 체크해 주세요."); location.href="../welcome.php?page=return&pg=1"';
          echo '</script>';
        }
    break;


}

?>
