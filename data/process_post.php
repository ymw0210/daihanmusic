<?php
include('..\session.php');

switch ($_GET['mode']) {
  case 'insert':

  //택배신청 정보생성
  $mobile = str_replace("-", "", htmlspecialchars($_POST['recMob'])); //전화번호 "-" 제거
  $adress = htmlspecialchars($_POST['recAddr1']) . htmlspecialchars($_POST['recAddExtra']); //상세주소를 제외한 주소
  $adress2 = htmlspecialchars($_POST['recAddr2']) == null ? "." : htmlspecialchars($_POST['recAddr2']);
  $reqType = "reqType=".htmlspecialchars($_POST['reqType']); //신규=1, 반품=2
  //$weight = "weight=1";
  //$volume = "volume=50";
  $ordCompNm = "ordCompNm=대한음악사";
  $recNm = "recNm=".htmlspecialchars($_POST['recNm']);
  $recZip = "recZip=".htmlspecialchars($_POST['recZip']);
  $recAddr1 = "recAddr1={$adress}";
  $recAddr2 = "recAddr2={$adress2}";
  $recTel = "recTel={$mobile}";
  $recMob = "recMob={$mobile}";
  $payType = "payType=".htmlspecialchars($_POST['reqType']); //1=선불 2=후불, 신규면 선불, 반품이면 후불
  $microYn = "microYn=N"; //초소형택배
  $contCd = "contCd=024"; //서적
  $goodsNm = "goodsNm=악보"; //상품이름
  $orderNo = "orderNo=".htmlspecialchars($_POST['orderNo']); //주문번호
  //$printYn = "printYn=Y"; //자체출력여부
  //$test = "testYn=Y"; //테스트신청


  $req_regdata =
  "{$custNo}&{$reqType}&{$officeSer}&{$ordCompNm}&{$recNm}&{$recZip}&{$recAddr1}&{$recAddr2}&{$recTel}&{$recMob}&{$apprNo}&{$payType}&{$microYn}&{$contCd}&{$goodsNm}&{$orderNo}"; //요청정보

  $req_encryptStr = $seed->getEncryptData($sec_key, $req_regdata);
  $url4 = "http://ship.epost.go.kr/api.InsertOrder.jparcel?key={$key}{$regdata}{$req_encryptStr}";
  $result4 = file_get_contents($url4);
  $xml4 = simplexml_load_string($result4);
  $track_Number = trim($xml4->regiNo);
  $reqNo = trim($xml4->reqNo);
  $resNo = trim($xml4->resNo);

  /*
  //운송조회
  $track_key = "2515b239435db7fc81492587344442";
  $url5 = "http://biz.epost.go.kr/KpostPortal/openapi?regkey={$track_key}&target=trace&query={$track_Number}";*/


  if ( $track_Number != NULL && $_POST['reqType'] == '2' ) { //송장번호가 존재하고 반품일경우 데이타베이스 저장

    $return_reason = (isset($_POST['reason2']) && htmlspecialchars($_POST['reason2'])) ? htmlspecialchars($_POST['reason1']) . " - " . htmlspecialchars($_POST['reason2']) : htmlspecialchars($_POST['reason1']);


    $query = "INSERT INTO daihan.return_post
    ( date, order_number, name, reason, tracking_number, userid, pay_method, reqNo, resNo )
    VALUES
    ( NOW(), :order_number, :name, :reason, :tracking_number, :userid, :pay_method, :reqNo, :resNo )";

    $stmt = $db->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $stmt->execute(array(
      ':order_number'=>htmlspecialchars($_POST['orderNo']),
        ':name'=>htmlspecialchars($_POST['recNm']),
        ':reason'=>$return_reason,
        ':tracking_number'=>$track_Number,
        ':userid'=>$login_session,
        ':pay_method'=>htmlspecialchars($_POST['pay_method']),
        ':reqNo'=>$reqNo,
        ':resNo'=>$resNo
      ));

      $count = $stmt->rowCount();

      if($count>0){
        echo '<script language="javascript">';
        echo 'alert("저장이 완료되었습니다."); location.href="../welcome.php?page=post&pg=1"';
        echo '</script>';

      } else {
        echo '<script language="javascript">';
        echo 'alert("오류입니다1. 담당자에게 문의해주세요."); location.href="../welcome.php?page=post&pg=1"';
        echo '</script>';
      }

  } elseif ( $track_Number != NULL && htmlspecialchars($_POST['reqType']) == '1' ) {//송장번호가 있고 신규일경우

    echo '<script language="javascript">';
    echo 'alert("신청이 처리되었습니다."); location.href="../welcome.php?page=post&pg=1"';
    echo '</script>';

  } else {

    echo '<script language="javascript">';
    echo 'alert("오류입니다2. 담당자에게 문의해주세요."); location.href="../welcome.php?page=post&pg=1"';
    echo '</script>';

  }

    break;

    case 'modify':

      $id = htmlspecialchars($_POST['id']);
      $order_number = htmlspecialchars($_POST['order_number']);
      $name = htmlspecialchars($_POST['name']);
      $pay_method = htmlspecialchars($_POST['pay_method']);
      $return_reason = (isset($_POST['reason2']) && htmlspecialchars($_POST['reason2'])) ? htmlspecialchars($_POST['reason1']) . " - " . htmlspecialchars($_POST['reason2']) : htmlspecialchars($_POST['reason1']);


      $query = "UPDATE daihan.return_post SET
        order_number = :order_number,
        name = :name,
        pay_method = :pay_method,
        reason = :reason WHERE id = :id";

      $stmt = $db->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
      $stmt->execute(array(
        ':order_number'=>$order_number,
          ':name'=>$name,
          ':pay_method'=>$pay_method,
          ':reason'=>$return_reason,
          ":id"=>$id
        ));

        $count = $stmt->rowCount();
        if($count>0){
          echo '<script language="javascript">';
          echo 'alert("저장이 완료되었습니다."); location.href="../welcome.php?page=post&pg=1"';
          echo '</script>';

          } else {
            echo "<script>alert('오류가 발생하였습니다. 담당자에게 문의해주세요.')\;</script>";
          }
    break;

    case 'checked':
      if(isset($_POST['checked'])){

        $checked = $_POST['checked'];

        foreach( $checked as $value ) {

          $query = "UPDATE daihan.return_post SET ok = 'y' WHERE id = $value";
          $stmt = $db->query($query);

          $count = $stmt->rowCount();

          if($count>0){
            echo '<script language="javascript">';
            echo 'alert("저장이 완료되었습니다."); location.href="../welcome.php?page=post&pg=1"';
            echo '</script>';

            } else {
              echo "<script>alert('오류가 발생하였습니다. 담당자에게 문의해주세요.')\;</script>";
            }
          }
        } else {
          echo '<script language="javascript">';
          echo 'alert("데이터확인을 체크해 주세요."); location.href="../welcome.php?page=post&pg=1"';
          echo '</script>';
        }
    break;

    case 'post_cancel':
    //주문 취소
    $id = $_POST['checked'];

    $query = "SELECT * FROM daihan.return_post WHERE id = :id";

    $stmt = $db->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $stmt->execute(array(
        ":id"=>$id[0]
      ));

    $row = $stmt -> fetch(PDO::FETCH_ASSOC);
    $date = date("Ymd", strtotime($row['date']));

    $reqType = "reqType=2";
    $regiNo = "&regiNo=".htmlspecialchars($row['tracking_number']);
    $reqNo = "&reqNo=".htmlspecialchars($row['reqNo']);
    $resNo = "&resNo=".htmlspecialchars($row['resNo']);
    $reqYmd = "reqYmd={$date}";
    $delYn = "delYn=N";

    $cancel_regdata =
    "{$custNo}&{$apprNo}&{$reqType}{$regiNo}{$reqNo}{$resNo}&{$reqYmd}&{$delYn}";

    $CancelCmd_encryptStr = $seed->getEncryptData($sec_key, $cancel_regdata);
    $url = "http://ship.epost.go.kr/api.GetResCancelCmd.jparcel?key={$key}{$regdata}{$CancelCmd_encryptStr}";
    $result = file_get_contents($url);
    $xml = simplexml_load_string($result);
    $cancel_stat = trim($xml->canceledyn);


    if ($cancel_stat == "Y") {

      $query = "UPDATE daihan.return_post SET ok = 'c' WHERE id = $id[0]";
      $stmt = $db->query($query);

      $count = $stmt->rowCount();

      if ($count>0) {

        echo '<script language="javascript">';
        echo 'alert("취소되었습니다."); location.href="../welcome.php?page=post&pg=1"';
        echo '</script>';
      } else {
        echo '<script language="javascript">';
        echo 'alert("오류가 발생햇습니다."); location.href="../welcome.php?page=post&pg=1"';
        echo '</script>';
      }


    } else {
      echo '<script language="javascript">';
      echo 'alert("오류가 발생햇습니다."); location.href="../welcome.php?page=post&pg=1"';
      echo '</script>';
    }

    break;

    case 'cancel':
      if(isset($_POST['checked'])){

        $checked = $_POST['checked'];

        foreach( $checked as $value ) {

          $query = "UPDATE daihan.return_post SET ok = 'n' WHERE id = $value";
          $stmt = $db->query($query);

          $count = $stmt->rowCount();

          if($count>0){
            echo '<script language="javascript">';
            echo 'alert("저장이 완료되었습니다."); location.href="../welcome.php?page=post&pg=1"';
            echo '</script>';

            } else {
              echo "<script>alert('오류가 발생하였습니다. 담당자에게 문의해주세요.')\;</script>";
            }
          }
        } else {
          echo '<script language="javascript">';
          echo 'alert("데이터확인을 체크해 주세요."); location.href="../welcome.php?page=post&pg=1"';
          echo '</script>';
        }
    break;


}

?>
