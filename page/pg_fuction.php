<?php
include("../config.php");

        $pagenation = new Pagenation(10, 5);

          /* Load data */
          $query = "SELECT count(id) as total from $dbName";

          $pg_result = $pagenation->getPageData($query);

          $query2 = "SELECT * FROM daihan.return_list2 ORDER BY id DESC LIMIT ".$pg_result['limit_idx'].", ".$pg_result['page_set'];

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
          echo ($pg_result['prev_page'] > 0) ? "<li class='page-item'><a class='page-link' href='" . $pg_result['PHP_SELF'] . "&pg=" . $pg_result['prev_page']."'>Previous</a></li>" : "<li class='page-item'><a class='page-link'>Previous</a></li>";

          for ($i=$pg_result['first_page']; $i<=$pg_result['last_page']; $i++) {
          echo ($i != $pg_result['page']) ? "<li class='page-item'><a class='page-link' href='".$pg_result['PHP_SELF']."&pg=$i'>$i</a></li> " : "<li class='page-item active'><a class='page-link' href='".$pg_result['PHP_SELF']."&pg=$i'><b>$i</b></a></li>";
          }

          echo ($pg_result['next_page'] <= $pg_result['total_page']) ? "<li class='page-item'><a class='page-link' href='".$pg_result['PHP_SELF']."&pg=".$pg_result['next_page']."'>Next</a></li>" : "<li class='page-item'><a class='page-link'>Next</a></li>";
          ?>
