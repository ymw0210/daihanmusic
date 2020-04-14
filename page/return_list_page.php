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
  #bank {
    width  : 6%;
  }
  #account {
    width : 12%;
  }
  #account_name {
    width : 6%
  }
  #return_money {
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
  <div class="sec01">
    <h2 class="sec01_title">환불 일지</h2>
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
          <input type="hidden" name="page" value="return">
          <input type="hidden" name="pg" value="1">
          <select name="search_by" class="form-control">
            <option value="name">이름</option>
            <option value="order_number">주문번호</option>
          </select>
          <input type="text" id="search" class="form-control mx-sm-1" name="search" value="<?=$search_name?>" aria-label="Recipient's username" aria-describedby="button-addon2">
          <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="submit" id="button-addon2" value="검색" formaction="<?=htmlentities($_SERVER['PHP_SELF'])?>">검색</button>
          </div>
      </div>
    </form>
    <form action="" method="POST" id="return">
      <?php

      // 한페이지 줄수, 한페이지 블럭수 설정
      $pagenation = new Pagenation(10, 5);

      $query='SELECT count(id) AS total FROM $dbName '.$search_qr.' LIKE "%' . $search_name . '%"';

      $pg_result = $pagenation->getReturnPageData($query);


      /* Load data */
      $search_query = 'SELECT * FROM daihan.return_list2 '.$search_qr.' LIKE "%' . $search_name . '%"';
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
                <th scope="col" id="return_money">환불금액</th>
                <th scope="col" id="account_name">예금주</th>
                <th scope="col" id="bank">은행</th>
                <th scope="col" id="account">계좌번호</th>
                <th scope="col" id="member">담당자</th>
                <th scope="col" id="check">확인<div><input type="checkbox" name="checkall" id="checkall" onClick="check_all(this.checked);" /></div>
              </tr>
      <?php

        foreach ($db->query($query2) as $row) {

              echo '<tr style="background-color : white;" class="' . $row['checked'] . '"><td>' . htmlspecialchars($row['id']) . '</td>' .
              '<td>' . htmlspecialchars($row['date']) . '</td>' .
              '<td>' . htmlspecialchars($row['order_number']) . '</td>' .
              '<td>' . htmlspecialchars($row['name']) . '</td>' .
              '<td id="reason_contents">' . htmlspecialchars($row['reason']) . '</td>' .
              '<td>' . htmlspecialchars($row['return_money']) . '</td>' .
              '<td>' . htmlspecialchars(dec($row['account_name'])) . '</td>' .
              '<td>' . htmlspecialchars(dec($row['bank'])) . '</td>' .
              '<td>' . htmlspecialchars(dec($row['account'])) . '</td>' .
              '<td>' . htmlspecialchars($row['submit_id']) . '</td>' .
              '<td>' . '<input class="' . $row['checked'] . '" type="checkbox" name="checked[ ]" value="' . htmlspecialchars($row['id']) . '"</td>' .
              '</tr>';
          }
          ?>
          </table>
          <ul class="pagination justify-content-center">
          <?php
          echo ($pg_result['prev_page'] > 0) ?
           "<li class='page-item'><a class='page-link' href='" . $pg_result['PHP_SELF'] . "&pg=" . $pg_result['prev_page'] . $search_para . "'>Previous</a></li>" :
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
            <button type="submit" class="btn btn-secondary" value="수정" formaction="../welcome.php?page=return_modify">수 정</button>
            <button type="submit" class="btn btn-secondary" value="확인" formaction="../data/process_return.php?mode=checked">확 인</button>
            <button type="submit" class="btn btn-secondary" value="확인" formaction="../data/process_return.php?mode=checked_cancel">확인 취소</button>
            <button type="submit" class="btn btn-secondary" value="삭제" onClick="return_del_check()">삭 제</button>
            <button type="submit" class="btn btn-secondary" value="엑셀" formaction="../data/return_excel_export.php">엑셀 저장</button>
          </div>
        </form>
      </div>
      <!-- 본문끝-->
      <script>
      var checked = document.getElementsByClassName('1');
      for (i=0; i<checked.length; i++) {
      checked[i].style.backgroundColor = 'yellow';
      }
      var checked = document.getElementsByClassName('2');
      for (i=0; i<checked.length; i++) {
      checked[i].style.backgroundColor = 'orangered';
      }
      function check_all(isChecked) {
        if(isChecked) {
          $('input[name="checked[ ]"]').each(function() {
            this.checked = true;
          });
        } else {
          $('input[name="checked[ ]"]').each(function() {
            this.checked = false;
          });
        }
      }

      //삭제
      function return_del_check() {
        var theForm = document.getElementById('return');
          if (confirm("정말 삭제하시겠습니까??") == true) { //확인

          theForm.action = "../data/process_return.php?mode=del";
          theForm.submit();

        } else { //취소

          return false;

        }

      }
      </script>
