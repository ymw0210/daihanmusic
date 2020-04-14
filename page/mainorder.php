<?php


$objPHPExcel = new PHPExcel();

?>

  <style>

    table {
      margin : 1% auto;
      border: 1px solid;

    }

    .table caption {
      caption-side :top;
      text-align: center;
    }
    .table th {
      border: 1px solid;
      text-align : center;
      font-size: 0.75em;
      vertical-align: middle;
    }
    .table td {
      border: 1px solid;
      text-align : center;
      font-size: 0.75rem;
      padding: 1%;
    }

    .list {
      max-width: 900px;
    }
    .list th {
      border: 1px solid;
      text-align : center;
      font-size: 0.75em;
      vertical-align: middle;
      padding: 0.7rem;
    }
    .list td {
      border: 1px solid;
    }
    .list td.id{
      text-align: center;
    }

    .sec01 a:link {
      text-decoration: none;
      color: #30343b;
      -webkit-transition: background-color 0.3s linear;
      -moz-transition: background-color 0.3s linear;
      -ms-transition: background-color 0.3s linear;
      -o-transition: background-color 0.3s linear;
      transition: background-color 0.3s linear;
    }

    .sec01 a:visited {
        text-decoration: none;
        color: #30343b;
    }

    .sec01 a:hover {
        text-decoration: none;
        background-color: #f27835;
        border-radius: 5px;
        color: white;
    }

    .sec01 a:active {
        text-decoration: none;
        color: #30343b;
    }

    tr.ok {
      background-color:yellow;
    }

    tr.cancel {
      background-color:#850016;
      color:white;
    }

    tr.restricted {
      background-color:#004411;
      color:white;
    }

    tr.cancel a:link, tr.cancel a:visited, tr.cancel a:hover, tr.cancel a:active, tr.restricted a:link, tr.restricted a:visited, tr.restricted a:hover, tr.restricted a:active  {
      background-color:rgba(255,255,255,0);
      color:white;
    }
  </style>

  <div class="sec01">
    <h2 class="sec01_title">메인 오더</h2>
    <h6>정렬 방식 :
    <select onchange="location.href=this.value">
    <option value="#">선택</option>
    <option value="../welcome.php?page=mainorder&sort=1">날짜순</option>
    <option value="../welcome.php?page=mainorder&sort=2">이름순</option>
  </select></h6>
    <div class="accordion" id="accordionExample">
      <p class="location">
    <?php
    $dir = "upload/mainorder"; //파일 경로

    $fileList = getCurrentFileList($dir);

    //파라미터 허락값 검사 후 파일정렬
    $sort_allowed = array('1', '2');
    $sort_method = isset($_GET['sort']) && $_GET['sort'] ? $_GET['sort'] : 1;

    if ( in_array($sort_method, $sort_allowed, false) ) {

      $sort_fileList = arr_sort($fileList, $sort_method);

    } else {

      echo '<script language="javascript">';
      echo 'alert("잘못된 경로입니다."); location.href="../welcome.php?page=mainorder"';
      echo '</script>';

    }

    //현재 년도
    $now = date("Y");

    $month = array(
      'jan'=> array('1월', $now.'01'),
      'feb'=> array('2월', $now.'02'),
      'mar'=> array('3월', $now.'03'),
      'apr'=> array('4월', $now.'04'),
      'may'=> array('5월', $now.'05'),
      'jun'=> array('6월', $now.'06'),
      'jul'=> array('7월', $now.'07'),
      'aug'=> array('8월', $now.'08'),
      'sep'=> array('9월', $now.'09'),
      'oct'=> array('10월', $now.'10'),
      'nov'=> array('11월', $now.'11'),
      'dec'=> array('12월', $now.'12')
    );

    //각 월별 버튼 출력
    foreach ($month as $key => $value) {

      echo '
      <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#' . $key . '" aria-expanded="false" aria-controls="collapseOne">' . $value[0] . '</button>';
    }

    echo'</p>
    <div class="card"><form action="" method="post" id="order_check" name="order_check">';

    //파일 내용 출력
    foreach ($month as $key => $value) {

    echo'
    <div id="' . $key . '" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
        <table class="list">
        <tr>
          <th scope="col">번호</th>
          <th scope="col">파일 이름</th>
          <th scope="col">체크</th>
        </tr>';

          //번호 초기값설정
          $i=0;
          foreach ($sort_fileList as $file) {

            //파일이름 합치기
            $name ="";
            for ($j=0; $j < count($file) ; $j++) {

              $name = $name . $file[$j] . " ";

            }

            $file_name = trim($name);

            //날짜 추출
            $order_date = substr($file_name, 4, 6 );

            //각 월별로 출력
            if ($order_date == $value[1]) {

              //구문 검사
              $mainorder = new MainorderClass($file_name);
              $vals = $mainorder->check_value();

              //ok와 cancel에 따른 색깔 변화
              if ($vals == 'ok') {

                $check = 'class="ok"';

              } elseif ( $vals == 'Cancel') {

                $check = 'class="cancel"';

              } elseif ($vals == 'Restricted') {

                $check = 'class="restricted"';

              } else {

                $check = null;

              }

              $i++;

              echo'
              <tr ' . $check . '>
                <td class="id">'. $i .
                 '<td style="text-align:left;">
                    <a href="../welcome.php?page=mainorder&sort=' . $sort_method . '&name=' . $file_name . '">' . $file_name .
                    '</a>
                  </td>
                  <td class="id">
                    <input type="radio" id="' . $i . '" name="del_unit" value="' . $file_name . '">
                  </td>
                </td>
              </tr>';

            }

          }

        echo '</table>';

        //관리자만 버튼활성화
        if ($login_session == '김현경' || $login_session == '윤무원') { ?>

          <input type="button" value="삭제" onClick="del_check()">
          <input type="button" value="확인" onClick="ok_check()">
          <input type="button" value="수입 불가" onClick="order_cancel1()">
          <input type="button" value="주문 취소" onClick="order_cancel2()">
          <input type="button" value="취소" onClick="ok_cancel()">

          <?php

        }

        ?>

        </div>
      </div>

      <?php

      }

      ?>

      </div>
      </form>
      </div>

      <?php

      $get_filename = isset($_GET['name']) && $_GET['name'] ? $_GET['name'] : null;

      if (isset($get_filename)) {

      $filename = 'upload/mainorder/'.$get_filename; // 읽어들일 엑셀 파일의 경로와 파일명을 지정한다.

      $file_date1 = substr($get_filename, 8, 4 ); //날짜 추출
      $file_date2 = substr_replace($file_date1,'월 ', 2,0); //'월' 추가
      $final_date = substr_replace($file_date2, '일', 8, 0); //'일' 추가

      //확장자 제거
      $file_ex = explode( '.', $get_filename);
      $real_name = '';

      for ($i=0; $i < (count($file_ex)-1) ; $i++) {
        $real_name = $real_name . '. '. $file_ex[$i];
      }

      $head_name = substr($real_name, 18 );

      ?>

      <table class="table">
        <caption>
          <h3>
            주문 날짜 : <?=$final_date?><br/>
            매입처 : <?=$head_name?>
          </h3>
        </caption>
        <thead class="thead-dark align-middle">
          <tr>
            <th scope="col" id="id_number">번호</th>
            <th scope="col" id="date">작곡가</th>
            <th scope="col" id="order_number">곡명</th>
            <th scope="col" id="name">출판사</th>
            <th scope="col" id="reason">악기</th>
            <th scope="col" id="account_name">수량</th>
            <th scope="col" id="bank">고유코드</th>
          </tr>

        <?php


        try {

          $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
          $cacheSettings = array( ' memoryCacheSize ' => '8MB');
          PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);

          // 업로드 된 엑셀 형식에 맞는 Reader객체를 만든다.
          $objReader = PHPExcel_IOFactory::createReaderForFile($filename);

          // 읽기전용으로 설정
          //$objReader->setReadDataOnly(false);

          // 엑셀파일을 읽는다
          $objExcel = $objReader->load($filename);


          // 첫번째 시트를 선택
          $objExcel->setActiveSheetIndex(0);
          $objWorksheet = $objExcel->getActiveSheet();
          $rowIterator = $objWorksheet->getRowIterator();

          foreach ($rowIterator as $row) { // 모든 행에 대해서

                $cellIterator = $row->getCellIterator();

                $cellIterator->setIterateOnlyExistingCells(false);

              }

              $maxRow = $objWorksheet->getHighestRow();

              for ($i = 9 ; $i <= $maxRow ; $i++) {
                $a_font_color = $objWorksheet->getStyle('A' . $i)->getFont()->getColor()->getRGB(); // A열
                $b_font_color = $objWorksheet->getStyle('B' . $i)->getFont()->getColor()->getRGB(); // B열
                $c_font_color = $objWorksheet->getStyle('C' . $i)->getFont()->getColor()->getRGB(); // C열
                $d_font_color = $objWorksheet->getStyle('D' . $i)->getFont()->getColor()->getRGB(); // D열
                $e_font_color = $objWorksheet->getStyle('E' . $i)->getFont()->getColor()->getRGB(); // E열
                $f_font_color = $objWorksheet->getStyle('F' . $i)->getFont()->getColor()->getRGB(); // F열
                $g_font_color = $objWorksheet->getStyle('G' . $i)->getFont()->getColor()->getRGB(); // G열

                $a = $objWorksheet->getCell('A' . $i)->getValue(); // A열
                $b = $objWorksheet->getCell('B' . $i)->getValue(); // B열
                $c = $objWorksheet->getCell('C' . $i)->getValue(); // C열
                $d = $objWorksheet->getCell('D' . $i)->getValue(); // D열
                $e = $objWorksheet->getCell('E' . $i)->getValue(); // E열
                $f = $objWorksheet->getCell('F' . $i)->getValue(); // F열
                $g = $objWorksheet->getCell('G' . $i)->getValue(); // G열

                echo '<tr style="background-color:white;">' .
                '<td style="color:#'. $a_font_color .'">' . htmlspecialchars($a) . '</td>' .
                '<td style="text-align:left; color:#'. $b_font_color .'">' . htmlspecialchars($b) . '</td>' .
                '<td style="text-align:left; color:#'. $c_font_color .'">' . htmlspecialchars($c) . '</td>' .
                '<td style="color:#'. $d_font_color .'">' . htmlspecialchars($d) . '</td>' .
                '<td style="color:#'. $e_font_color .'">' . htmlspecialchars($e) . '</td>' .
                '<td style="color:#'. $f_font_color .'">' . htmlspecialchars($f) . '</td>' .
                '<td style="color:#'. $g_font_color .'">' . htmlspecialchars($g) . '</td>' .
                '</tr>';


                if ($a == null) {

                  break;

                }

              }

            } catch(Exception $exception) {

              echo'Error loading file "'.pathinfo($file, PATHINFO_BASENAME).'" : '.$exception->getMessage();

            }

            echo "</table>";

          } else {

            echo "<h3>파일을 선택해 주세요.</h3>";

          }

        //관리자만 업로드 활성화
        if ($login_session == '김현경' || $login_session == '윤무원') { ?>

          <form enctype="multipart/form-data" action="../data/process_mainorder.php?mode=up" method="post">
            <table border="1">
              <tr>
                <th style="background-color:#DCDCDC">
                  파일
                </th>
                <td>
                  <input type="file" name="fileup"/>
                </td>
              </tr>
              <tr>
                <th style="background-color:#DCDCDC">
                  등록
                </th>
                <td style="text-align:center;">
                  <input type="submit" value="업로드"/>
                </td>
              </tr>
            </table>
          </form>

     <?php

      }

      ?>
