<?php
include('..\session.php');


switch ($_GET['mode']) {

  case 'vac_insert':

  $date = $_POST['date'];
  $date_year = date('Y',strtotime($_POST['date']));

  if ( date('Y') != $date_year) {

    echo '<script language="javascript">';
    echo 'alert("잘못된 날짜입니다."); location.href="../welcome.php?page=vacation"';
    echo '</script>';

  } else {

  //vac 값 별로 쿼리 저장

  //남아있는 연차 불러오기
  $remain_query = "SELECT remain FROM daihan.2020_vacation WHERE name='$login_session' AND vacation='y' ORDER BY id DESC LIMIT 1";
  $remain = $db->query($remain_query);
  $remain_result = $remain->fetch(PDO::FETCH_ASSOC);

  switch ($_POST['vac']) {

    case 'work_vac': //근무휴일

    $query = "INSERT INTO daihan.2020_vacation (date, name, benefit_vac) VALUES ( :date, :name, :benefit_vac)";

    $stmt = $db->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $stmt->execute(array(
      ':date'=>$date,
        ':name'=>$login_session,
        ':benefit_vac'=>'v'
      ));

    $count = $stmt->rowCount();

      if($count>0){

        echo '<script language="javascript">';
        echo 'alert("저장이 완료되었습니다."); location.href="../welcome.php?page=vacation"';
        echo '</script>';

        } else {
          echo "<script>alert('오류가 발생하였습니다. 담당자에게 문의해주세요.')\;</script>";
        }

    break;

    case 'w': //연차 등록

    $div_vac = 'w';
    $use_date = 1;

    //연차계산
    $cal_result = $remain_result['remain'] - $use_date;

    //계산된 연차 등록
    $query = "INSERT INTO daihan.2020_vacation (date, use_date, remain, name, vacation, am_pm_w) VALUES ( :date, :use_date, :remain, :name, :vacation, :am_pm_w)";

    $stmt = $db->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $stmt->execute(array(
      ':date'=>$date,
        ':use_date'=>$use_date,
        ':remain'=>$cal_result,
        ':name'=>$login_session,
        ':vacation'=>'y',
        ':am_pm_w'=>$div_vac
      ));

    $count = $stmt->rowCount();


      if($count>0){

        echo '<script language="javascript">';
        echo 'alert("저장이 완료되었습니다."); location.href="../welcome.php?page=vacation"';
        echo '</script>';

        } else {
          echo "<script>alert('오류가 발생하였습니다. 담당자에게 문의해주세요.')\;</script>";
        }

    break;

    case 'a': //오전반차

    $div_vac = 'a';
    $use_date = 0.5;

    //연차계산
    $cal_result = $remain_result['remain'] - $use_date;

    //계산된 연차 등록
    $query = "INSERT INTO daihan.2020_vacation (date, use_date, remain, name, vacation, am_pm_w) VALUES ( :date, :use_date, :remain, :name, :vacation, :am_pm_w)";

    $stmt = $db->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $stmt->execute(array(
      ':date'=>$date,
        ':use_date'=>$use_date,
        ':remain'=>$cal_result,
        ':name'=>$login_session,
        ':vacation'=>'y',
        ':am_pm_w'=>$div_vac
      ));

    $count = $stmt->rowCount();

      if($count>0){

        echo '<script language="javascript">';
        echo 'alert("저장이 완료되었습니다."); location.href="../welcome.php?page=vacation"';
        echo '</script>';

        } else {
          echo "<script>alert('오류가 발생하였습니다. 담당자에게 문의해주세요.')\;</script>";
        }

    break;

    case 'p': //오후반차

    $div_vac = 'p';
    $use_date = 0.5;

    //연차계산
    $cal_result = $remain_result['remain'] - $use_date;

    //계산된 연차 등록
    $query = "INSERT INTO daihan.2020_vacation (date, use_date, remain, name, vacation, am_pm_w) VALUES ( :date, :use_date, :remain, :name, :vacation, :am_pm_w)";

    $stmt = $db->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $stmt->execute(array(
      ':date'=>$date,
        ':use_date'=>$use_date,
        ':remain'=>$cal_result,
        ':name'=>$login_session,
        ':vacation'=>'y',
        ':am_pm_w'=>$div_vac
      ));

    $count = $stmt->rowCount();

      if($count>0){

        echo '<script language="javascript">';
        echo 'alert("저장이 완료되었습니다."); location.href="../welcome.php?page=vacation"';
        echo '</script>';

        } else {
          echo "<script>alert('오류가 발생하였습니다. 담당자에게 문의해주세요.')\;</script>";
        }

    break;

    default:
    echo '<script language="javascript">';
    echo 'alert("오류가 발생했습니다. 담당자에게 문의해주세요."); location.href="../welcome.php?page=vacation"';
    echo '</script>';
    break;

  }

}

  break;

  //근무일 등록
  case 'work_insert':

    if ( !isset($_POST['member'])) {

      echo '<script language="javascript">';
      echo 'alert("이름을 선택해주세요."); location.href="../welcome.php?page=vacation"';
      echo '</script>';

    } else {

      $date = $_POST['date'];
      $date_year = date('Y',strtotime($_POST['date']));

      if ( date('Y') != $date_year) {
        echo '<script language="javascript">';
        echo 'alert("잘못된 날짜입니다."); location.href="../welcome.php?page=vacation"';
        echo '</script>';
      } else {

      $member = $_POST['member'];

      foreach ($member as $name) {
        $query = "INSERT INTO daihan.2020_vacation (date, name, weekend_work) VALUES ( :date, :name, :weekend_work)";

        $stmt = $db->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $stmt->execute(array(
          ':date'=>$date,
            ':name'=>$name,
            ':weekend_work'=>'y'
          ));

      }

      $count = $stmt->rowCount();

        if($count>0){

          echo '<script language="javascript">';
          echo 'alert("저장이 완료되었습니다."); location.href="../welcome.php?page=vacation"';
          echo '</script>';

          } else {

            echo "<script>alert('오류가 발생하였습니다. 담당자에게 문의해주세요.')\;</script>";

          }
        }
      }

  break;


  //삭제
  case 'delete':

    if (!isset($_POST['check_name'])) {

      echo '<script language="javascript">';
      echo 'alert("삭제할 목록을 선택해주세요."); location.href="../welcome.php?page=vacation"';
      echo '</script>';

    } else {

      $ex = explode('-', $_POST['check_name']);

      $delete = $ex[1];
      $query = "DELETE FROM daihan.2020_vacation WHERE id = '$delete'";
      $result = $db->query($query);

      $count = $result->rowCount();

      if($count>0){
        echo '<script language="javascript">';
        echo 'alert("저장이 완료되었습니다."); location.href="../welcome.php?page=vacation"';
        echo '</script>';

        } else {
          echo "<script>alert('오류가 발생하였습니다. 담당자에게 문의해주세요.')\;</script>";
        }
    }


  break;

  //수당 신청
  case 'benefit':

    $ex = explode('-', $_POST['check_name']);

    if ($ex[0] != 'work') {

      echo '<script language="javascript">';
      echo 'alert("주말 근무를 선택해주세요."); location.href="../welcome.php?page=vacation"';
      echo '</script>';

    } elseif (end($ex) == '(수당)' || end($ex) == '(수당 확인)') {
      echo '<script language="javascript">';
      echo 'alert("이미 신청되었습니다."); location.href="../welcome.php?page=vacation"';
      echo '</script>';
    } else {

      $id = $ex[1];

      $query = "UPDATE daihan.2020_vacation SET benefit_vac = :benefit_vac WHERE id = :id";

      $stmt = $db->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
      $stmt->execute(array(
        ':benefit_vac'=>'b',
          ':id'=>$id
        ));

      $count = $stmt->rowCount();

      if($count>0){
        echo '<script language="javascript">';
        echo 'alert("저장이 완료되었습니다."); location.href="../welcome.php?page=vacation"';
        echo '</script>';

        } else {
          echo "<script>alert('오류가 발생하였습니다. 담당자에게 문의해주세요.')\;</script>";
        }
    }

  break;

  //수당신청 취소
  case 'benefit_cancel':

        $ex = explode('-', $_POST['check_name']);

        if ($ex[0] != 'work') {

          echo '<script language="javascript">';
          echo 'alert("주말 근무를 선택해주세요."); location.href="../welcome.php?page=vacation"';
          echo '</script>';

        } elseif (end($ex) == '') {
          echo '<script language="javascript">';
          echo 'alert("취소할 수 없습니다."); location.href="../welcome.php?page=vacation"';
          echo '</script>';
        } else {

          $id = $ex[1];

          $query = "UPDATE daihan.2020_vacation SET benefit_vac = :benefit_vac WHERE id = :id";

          $stmt = $db->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
          $stmt->execute(array(
            ':benefit_vac'=>'n',
              ':id'=>$id
            ));

          $count = $stmt->rowCount();

          if($count>0){
            echo '<script language="javascript">';
            echo 'alert("저장이 완료되었습니다."); location.href="../welcome.php?page=vacation"';
            echo '</script>';

            } else {
              echo "<script>alert('오류가 발생하였습니다. 담당자에게 문의해주세요.')\;</script>";
            }
        }

  break;

  //수당 신청 확인
  case 'benefit_ok':

    $ex = explode('-', $_POST['check_name']);

    if ($ex[0] != 'work') {

      echo '<script language="javascript">';
      echo 'alert("주말 근무를 선택해주세요."); location.href="../welcome.php?page=vacation"';
      echo '</script>';

    } else {

      $id = $ex[1];

      $query = "UPDATE daihan.2020_vacation SET benefit_vac = :benefit_vac WHERE id = :id";

      $stmt = $db->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
      $stmt->execute(array(
        ':benefit_vac'=>'b_ok',
          ':id'=>$id
        ));

      $count = $stmt->rowCount();

      if($count>0){
        echo '<script language="javascript">';
        echo 'alert("저장이 완료되었습니다."); location.href="../welcome.php?page=vacation"';
        echo '</script>';

        } else {
          echo "<script>alert('오류가 발생하였습니다. 담당자에게 문의해주세요.')\;</script>";
        }
    }

  break;

}


?>
