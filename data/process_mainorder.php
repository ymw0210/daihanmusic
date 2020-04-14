<?php
include('..\session.php');

$getfile = $_POST['del_unit'] ? $_POST['del_unit'] : null;

$filename= iconv("UTF-8", "EUC-KR", $getfile);
$folder = "../upload/mainorder/";
$mainorder = new MainorderClass($filename);

switch ($_GET['mode']) {

  case 'up':

  $tmpfile = $_FILES['fileup']['tmp_name'];
  $name = $_FILES['fileup']['name'];
  $file_ex = explode('.', $name);
  $ext = strtolower(end($file_ex));
  $filename2 = str_replace('&', 'and', $name );
  $allowed_ext = array('xlsx','xls');

  // 확장자 확인
  if( in_array($ext, $allowed_ext, false) ) {

    $result = move_uploaded_file($tmpfile,$folder.$filename2);

      if($result == true){

        echo '<script language="javascript">';
        echo 'alert("저장이 완료되었습니다."); location.href="../welcome.php?page=mainorder"';
        echo '</script>';

        } else {

          echo '<script language="javascript">';
          echo 'alert("오류가 발생하였습니다. 담당자에게 문의해주세요."); location.href="../welcome.php?page=mainorder"';
          echo '</script>';

        }

  } else {

    echo '<script language="javascript">';
    echo 'alert("허용되지 않은 확장자입니다."); location.href="../welcome.php?page=mainorder"';
    echo '</script>';

  }
    break;

    //파일 삭제
    case 'del':

      if(unlink($folder.$filename)){

        echo '<script language="javascript">';
        echo 'alert("삭제되었습니다.."); location.href="../welcome.php?page=mainorder"';
        echo '</script>';

        } else {

          echo '<script language="javascript">';
          echo 'alert("오류가 발생하였습니다. 담당자에게 문의해주세요."); location.href="../welcome.php?page=mainorder"';
          echo '</script>';

        }

    break;

    //파일 ok 삽입
    case 'ok_check':

    $value = $mainorder->check_value();

    if ($value == 'no_value') {

      $file = $mainorder->real_filename();
      $new_name = $file['realname'] . " - ok." . $file['ex'];
      $re_name = rename($folder.$filename, $folder.$new_name);

      if($re_name){

        echo '<script language="javascript">';
        echo 'alert("저장되었습니다."); location.href="../welcome.php?page=mainorder"';
        echo '</script>';

      } else {

        echo '<script language="javascript">';
        echo 'alert("오류가 발생하였습니다. 담당자에게 문의해주세요."); location.href="../welcome.php?page=mainorder"';
        echo '</script>';

      }

    } else {

      echo '<script language="javascript">';
      echo 'alert("이미 확인되었습니다."); location.href="../welcome.php?page=mainorder"';
      echo '</script>';

    }

        break;

    //check 지우기
    case 'check_cancel':

    $value = $mainorder->check_value();
    if ($value != "no_value") {

      $file = $mainorder->del_check();
      $re_name = rename($folder.$filename, $folder.$file);


      echo '<script language="javascript">';
      echo 'alert("취소되었습니다."); location.href="../welcome.php?page=mainorder"';
      echo '</script>';

    } else {

      echo '<script language="javascript">';
      echo 'alert("다시 선택해주세요."); location.href="../welcome.php?page=mainorder"';
      echo '</script>';

    }

    break;

    //주문 불가 cancel 삽입
    case 'order_cancel1':

    $value = $mainorder->check_value();

    if ($value == 'no_value' ) {

      $file = $mainorder->real_filename();
      $new_name = $file['realname'] . " - Order Restricted." . $file['ex'];
      $re_name = rename($folder.$filename, $folder.$new_name);

      if($re_name){

        echo '<script language="javascript">';
        echo 'alert("저장되었습니다."); location.href="../welcome.php?page=mainorder"';
        echo '</script>';

      } else {

        echo '<script language="javascript">';
        echo 'alert("오류가 발생하였습니다. 담당자에게 문의해주세요."); location.href="../welcome.php?page=mainorder"';
        echo '</script>';

      }

    } else {

      echo '<script language="javascript">';
      echo 'alert("이미 저장되었습니다."); location.href="../welcome.php?page=mainorder"';
      echo '</script>';

    }

    break;

    //cancel 삽입
    case 'order_cancel2':

    $value = $mainorder->check_value();

    if ($value == 'no_value' ) {

      $file = $mainorder->real_filename();
      $new_name = $file['realname'] . " - Order Cancel." . $file['ex'];
      $re_name = rename($folder.$filename, $folder.$new_name);

      if($re_name){

        echo '<script language="javascript">';
        echo 'alert("저장되었습니다."); location.href="../welcome.php?page=mainorder"';
        echo '</script>';

      } else {

        echo '<script language="javascript">';
        echo 'alert("오류가 발생하였습니다. 담당자에게 문의해주세요."); location.href="../welcome.php?page=mainorder"';
        echo '</script>';

      }

    } else {

      echo '<script language="javascript">';
      echo 'alert("이미 저장되었습니다."); location.href="../welcome.php?page=mainorder"';
      echo '</script>';

    }

    break;

}


?>
