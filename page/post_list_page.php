<style>
table {
  margin : 1% auto;
}
th {
  border: 1px solid;
  text-align : center;
  font-size: 0.75em;
  vertical-align: middle;
}
td {
  border: 1px solid;
  text-align : center;
  font-size: 0.75rem;
  padding: 0;
}

.form-inline {
  width : 30%;
  margin: auto;
}

.tracking_table {
  width: 30%;
}

span.process {
  font-weight: 900;
}

#id_number {
  width : 5%;
}
#date {
  width : 9%;
}
#order_number {
  width : 2%;
}
#name {
  width : 6%;
}
#reason {
  width : auto;
}
#tracking_number {
  width : 12%;
}
#pay_method {
  width : 6%
}
#ok {
  width : 8%;
}
#member {
  width : 6%;
}
#check {
  width : 5%;
}
#reason_contents {
  text-align : left;
}
</style>
<?php

$tracking_number = isset($_GET['tracking_number']) && $_GET['tracking_number'] ? htmlspecialchars($_GET['tracking_number']) : ""; //등기번호 파라미터
$pg = isset($_GET['pg']) && $_GET['pg'] ? "pg=" . $_GET['pg'] : null; //현재페이지

if ( $tracking_number != "" ) {


$url = "http://biz.epost.go.kr/KpostPortal/openapi?regkey={$track_key}&target=trace&query={$tracking_number}";; //xml 리턴
$result = file_get_contents($url); //url 컨텐츠 저장
$xml = simplexml_load_string($result); //컨텐츠 xml object로 저장
$tracking = $xml->itemlist->item;

  if ($tracking == NULL) {
    echo '<table class="table table-striped tracking_table">
      <thead class="thead-dark">
      <tr>
      <th scope="col">접수 날짜</th>
      <th scope="col">시간</th>
      <th scope="col">관리국</th>
      <th scope="col">상태</th>
      </tr>
      </thead>
      <tr>
      <td colspan="4">
      조회결과가 없습니다.
      </td>
      </tr>
      <tbody></table>';

  } else {

  echo '<table class="table table-striped tracking_table">
    <thead class="thead-dark">
    <tr>
    <th scope="col">접수 날짜</th>
    <th scope="col">시간</th>
    <th scope="col">관리국</th>
    <th scope="col">상태</th>
    </tr>
    </thead><tbody>';


  foreach($tracking as $row) {
      echo '<tr>
      <td scope="row">'. $row->sortingdate . '</td>' .
      '<td>' . $row->eventhms . '</td>' .
      '<td>' . $row->eventregiponm . '</td>' .
      '<td>' . $row->tracestatus . '</td>' .
      '</tr>';
  }
  echo "</tbody></table>";
  //echo "<div class='result'>수취인 : ".$xml->recevnm . "  " . $xml->relationnm . "</div><br>";
}

}


?>

<!--
  <form action="<?=$_SERVER['PHP_SELF']?>" method="GET">
   <div class="form-group row">
     <label for="name" class="col-sm-2 col-form-label">등기번호</label>
     <div class="col-sm-10">
       <input type="hidden" name="page" value="post">
       <input type="hidden" name="pg" value="1">
       <input type="text" class="form-control" name="tracking_number" value="<?=$tracking_number?>" id="<?=$tracking_number?>">
     </div>
   </div>
   <button type="submit" class="btn btn-secondary" value="검색">검색</button>
   <button type="button" onclick="inputReset('<?=$tracking_number?>')">초기화</button>
  </form>
-->
    <div class="sec01">
      <h2 class="sec01_title">반품 현황</h2>
      <?php

      $search_by = (isset($_GET['search_by']) && $_GET['search_by']) ? htmlspecialchars($_GET['search_by']) : "--";
      $search_name = (isset($_GET['search']) && $_GET['search']) ? htmlspecialchars($_GET['search']) : null;

      if ($search_by == "order_number") {

        $search_qr = "WHERE order_number";

      } elseif ($search_by == "name") {

        $search_qr = "WHERE name";

      } else {
        $search_qr = "--";
      }

      if ($search_name != null) {
        $search_para = "&search_by=".$search_by."&search=".$search_name;
      } else {
        $search_para = null;
      }



      ?>
      <form class="form-inline" action="" method="GET">
        <div class="form-group">
            <input type="hidden" name="page" value="post">
            <input type="hidden" name="pg" value="1">
            <select name="search_by" class="form-control">
              <option value="name" selected>이름</option>
              <option value="order_number">주문번호</option>
            </select>
            <input type="text" id="search" class="form-control mx-sm-1" name="search" value="<?=$search_name?>" aria-label="Recipient's username" aria-describedby="button-addon2">
            <div class="input-group-append">
              <button class="btn btn-outline-secondary" type="submit" id="button-addon2" value="검색" formaction="<?=$_SERVER['PHP_SELF']?>">검색</button>
            </div>
        </div>
      </form>
      <form action="" method="POST">
        <?php

        // 한페이지 줄수, 한페이지 블럭수 설정
        $pagenation = new Pagenation(10, 5);

        $query='SELECT count(id) AS total FROM $dbName '.$search_qr.' LIKE "%' . $search_name . '%"';

        $pg_result = $pagenation->getPostPageData($query);

        /* Load data */
        $search_query = 'SELECT * FROM daihan.return_post '.$search_qr.' LIKE "%' . $search_name . '%"';
        $page_query = 'ORDER BY id DESC LIMIT ' . $pg_result['limit_idx'] . ', '. $pg_result['page_set'];
        $ex_search_query = explode("--", $search_query);
        $query2 =  $ex_search_query[0]. $page_query;

        ?>
            <table class="table">
              <thead class="thead-dark align-middle">
                <tr>
                  <th id="id_number" scope="col">번호</th>
                  <th scope="col" id="date">날짜</th>
                  <th scope="col" id="order_number">주문번호</th>
                  <th scope="col" id="name">성함</th>
                  <th scope="col" id="reason">사유</th>
                  <th scope="col" id="tracking_number">반품 송장번호</th>
                  <th scope="col" id="pay_method">결제 방식</th>
                  <th scope="col" id="ok">처리여부</th>
                  <th scope="col" id="member">담당자</th>
                  <th scope="col" id="check">확인<div><input type="checkbox" name="checkall" id="checkall" onClick="check_all(this.checked);" /></div>
                </tr>
        <?php

          foreach ($db->query($query2) as $row) {

            if ($row['pay_method'] == "cash") {
              $pay_method = "현금";
            } elseif ($row['pay_method'] == "card") {
              $pay_method = "카드";
            } else {
              $pay_method = '';
            }

            if ($row['ok'] == 'n') {
              $process = "미처리";
            } elseif ($row['ok'] == 'y') {
              $process = "<span style='font-weight: bold;'>처리완료</span>";
            } elseif ($row['ok'] == 'c') {
              $process = "<span style='font-style: italic;'>신청취소</span>";
            } else {
              $process = "";
            }

                echo '<tr style="background-color : white;" class="' . $row['ok'] . '"><td>' . htmlspecialchars($row['id']) . '</td>' .
                '<td>' . htmlspecialchars($row['date']) . '</td>' .
                '<td>' . htmlspecialchars($row['order_number']) . '</td>' .
                '<td>' . htmlspecialchars($row['name']) . '</td>' .
                '<td id="reason_contents">' . htmlspecialchars($row['reason']) . '</td>' .
                '<td><a href="'.htmlentities($_SERVER['PHP_SELF']).'?page=post&'. $pg .'&tracking_number='.htmlspecialchars($row['tracking_number']).'">' . htmlspecialchars($row['tracking_number']) . '</a></td>' .
                '<td>' . htmlspecialchars($pay_method) . '</td>' .
                '<td>' . $process . '</td>' .
                '<td>' . htmlspecialchars($row['userid']) . '</td>' .
                '<td>' . '<input class="' . $row['ok'] . '" type="checkbox" name="checked[ ]" value="' . htmlspecialchars($row['id']) . '"</td>' .
                '</tr>';
            }
            ?>
            </table>
            <ul class="pagination justify-content-center">
            <?php
            echo ($pg_result['prev_page'] > 0) ?
             "<li class='page-item'><a class='page-link' href='" . $pg_result['PHP_SELF'] . "&pg=" . $pg_result['prev_page'] . $search_para. "'>Previous</a></li>" :
             "<li class='page-item'><a class='page-link'>Previous</a></li>";

            for ($i=$pg_result['first_page']; $i<=$pg_result['last_page']; $i++) {

            echo ($i != $pg_result['page']) ?
            "<li class='page-item'><a class='page-link' href='" . $pg_result['PHP_SELF'] . "&pg=" . $i . $search_para . "'>$i</a></li> " :
            "<li class='page-item active'><a class='page-link' href='" . $pg_result['PHP_SELF'] . "&pg=" . $i . $search_para . "'><b>$i</b></a></li>";

            }

            echo ($pg_result['next_page'] <= $pg_result['total_page']) ?
            "<li class='page-item'><a class='page-link' href='". $pg_result['PHP_SELF'] . "&pg=" . $pg_result['next_page'] . $search_para . "'>Next</a></li>" :
            "<li class='page-item'><a class='page-link'>Next</a></li>";

            ?>
          </ul>
            <div class="bottom_btn">
              <button type="submit" class="btn btn-secondary" value="수정" formaction="../welcome.php?page=post_modify">수 정</button>
              <button type="submit" class="btn btn-secondary" value="확인" formaction="../data/process_post.php?mode=checked">확 인</button>
              <button type="submit" class="btn btn-secondary" value="확인" formaction="../data/process_post.php?mode=cancel">취 소</button>
              <button type="submit" class="btn btn-secondary" value="취소" formaction="../data/process_post.php?mode=post_cancel">택배신청 취소</button>
              <button type="submit" class="btn btn-secondary" value="엑셀" formaction="../welcome.php?page=return_insert">환불 일지 등록</button>
            </div>
          </form>
        </div>



<script>

  function inputReset(id) {
    var input = document.getElementById(id);
    input.value = "";
  }

  var checked = document.getElementsByClassName('y');
  for (i=0; i<checked.length; i++) {
  checked[i].style.backgroundColor = 'yellow';
  }

  var checked = document.getElementsByClassName('c');
  for (i=0; i<checked.length; i++) {
  checked[i].style.backgroundColor = 'orange';
  }

  </script>
