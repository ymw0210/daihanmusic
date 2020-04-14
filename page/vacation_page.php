
    <style>
      .sec01 {
        margin : 1% auto;
      }
      .sec01_title {
        margin : 2% auto;
      }
      table {
        margin: 5% auto;
      }

      .table-responsive{

        display: table;
      }

      table.info {
        width : 55rem;
      }

      div.form {
        padding : 1%;
      }
      .card {
        width:35rem;
        margin: auto;
      }
      .hd_width{
        width: 16%;
      }
      .hd_center_width{
        width: 40%;
      }

      font.holy {
        font-family: tahoma;
        font-size: 20px;
        color: #FF6C21;
      }
      font.blue {
        font-family: tahoma;
        font-size: 20px;
        color: #0000FF;
      }
      font.black {
        font-family: tahoma;
        font-size: 20px;
        color: #000000;
      }
      td.current {
        background-color: #DCDCDC;
      }

      span.name {
        font-size: 0.8rem;
      }
      span.work, .rest_whole, .rest_half, .work_rest {
        color: white;
        border-radius:10px;
        padding: 1px;
      }
      span.work {
        background-color: #dc3545;
      }
      span.rest_whole {
        background-color: #006C1A;
      }
      span.rest_half {
        background-color: #00BD2E;
      }
      span.work_rest {
        background-color: #F5A002;
      }

    </style>
    <!-- 본문 -->
    <div class="sec01">
      <h3 class="sec01_title">근무 스케줄</h3>
      <form method="post">
      <div class="container">
      <table class="table table-bordered table-responsive">
        <tr align="center" >
          <td class="hd_width">
              <a href=<?php echo "../welcome.php?page=vacation&year={$preyear}&month={$month}&day=1"; ?>>◀◀ 이전 연도</a>
          </td>
          <td>
              <a href=<?php echo "../welcome.php?page=vacation&year={$prev_year}&month={$prev_month}&day=1"; ?>>◀ 이전 월</a>
          </td>
          <td colspan="3" class="hd_center_width">
            <a href=<?php echo "../welcome.php?page=vacation&year={$thisyear}&month={$thismonth}&day=1"; ?>>
            현재로 이동</a>
          </td>
          <td>
              <a href=<?php echo "../welcome.php?page=vacation&year={$next_year}&month={$next_month}&day=1"; ?>>다음 월 ▶</a>
          </td>
          <td class="hd_width">
              <a href=<?php echo "../welcome.php?page=vacation&year={$nextyear}&month={$month}&day=1"; ?>>다음 연도 ▶▶</a>
          </td>
        </tr>
        <tr>
          <td height="50" bgcolor="#FFFFFF" colspan="7">
              <?php echo "&nbsp;&nbsp;" . "{$year}년 {$month}월 " . "&nbsp;&nbsp;"; ?>
          </td>
        </tr>
        <tr class="info">
          <th hight="30">일</td>
          <th>월</th>
          <th>화</th>
          <th>수</th>
          <th>목</th>
          <th>금</th>
          <th>토</th>
        </tr>

        <?php

          // 5. 화면에 표시할 화면의 초기값을 1로 설정
          $day=1;

          $query_year = date("Y-m", mktime(0, 0, 0, $month, $day, $year));
          $final_qdate = $query_year . '%';

          $work_query = "SELECT name, date, benefit_vac, am_pm_w, id FROM daihan.2020_vacation WHERE date LIKE '{$final_qdate}' AND weekend_work = 'y'";
          $vac_query = "SELECT name, date, use_date, am_pm_w, benefit_vac, id FROM daihan.2020_vacation WHERE date LIKE '{$final_qdate}' AND vacation = 'y' OR benefit_vac = 'v'";

          // 6. 총 주 수에 맞춰서 세로줄 만들기
          for($i=1; $i <= $total_week; $i++){?>
        <tr>
          <?php
          // 7. 총 가로칸 만들기
          for ($j = 0; $j < 7; $j++) {

            //현재 날짜 표시 
            if ( !( ($i == 1 && $j < $start_week) || ($i == $total_week && $j > $last_week) ) && $year == $thisyear && $month == $thismonth && $day == date("j")) {
              $current = "class='current'";
            } else {
              $current = "";
            }

              // 8. 첫번째 주이고 시작요일보다 $j가 작거나 마지막주이고 $j가 마지막 요일보다 크면 표시하지 않음
              echo '<td style="width:2rem; height:auto;" valign="top" ' . $current . '>';

              if ( !( ($i == 1 && $j < $start_week) || ($i == $total_week && $j > $last_week) ) ) {

                  if ($j == 0) {
                      // 9. $j가 0이면 일요일이므로 빨간색
                      $style = "holy sun";
                  } else if ($j == 6) {
                      // 10. $j가 0이면 토요일이므로 파란색
                      $style = "blue sat";
                  } else {
                      // 11. 그외는 평일이므로 검정색
                      $style = "black";
                  }


                  // 12. 오늘 날짜면 굵은 글씨
                  if ($year == $thisyear && $month == $thismonth && $day == date("j")) {
                      // 13. 날짜 출력
                      echo "<font class='{$style} current'>";
                      echo $day;
                      echo '</font>';
                  } else {
                      echo "<font class={$style}>";
                      echo $day;
                      echo '</font>';
                  }

                  //저장된 근무날짜 불러오기
                  foreach ($db->query($work_query) as $work_row){

                      $work_ex_date = explode('-', $work_row['date']);
                      $work_date = date("j", mktime(0, 0, 0, $work_ex_date[1], $work_ex_date[2], $work_ex_date[0]));
                      $work_month = date("n", mktime(0, 0, 0, $work_ex_date[1], $work_ex_date[2], $work_ex_date[0]));
                      $work_year = date("Y", mktime(0, 0, 0, $work_ex_date[1], $work_ex_date[2], $work_ex_date[0]));

                      if ($work_row['benefit_vac'] == 'b') {

                        $vac_div = '(수당)';

                      } elseif ( $work_row['benefit_vac'] == 'b_ok') {

                        $vac_div = '(수당 확인)';

                      } else {

                        $vac_div = null;

                      }

                      //날짜가 같으면 삽입
                      if ($day == $work_date && $month == $work_month && $year == $work_year) {

                        echo '<br><span class="name">';
                        echo htmlspecialchars($work_row['name']) . ' <span class="work">근무' . $vac_div;
                        echo '</span> <input type=radio name="check_name"  value ="work-' . $work_row["id"] . '-' . $vac_div . '">';

                      }

                    }

                  //저장된 휴무날짜 불러오기
                  foreach ($db->query($vac_query) as $vac_row){

                      $vac_ex_date = explode('-', $vac_row['date']);
                      $vac_date = date("j", mktime(0, 0, 0, $vac_ex_date[1], $vac_ex_date[2], $vac_ex_date[0]));
                      $vac_month = date("n", mktime(0, 0, 0, $vac_ex_date[1], $vac_ex_date[2], $vac_ex_date[0]));
                      $vac_year = date("Y", mktime(0, 0, 0, $vac_ex_date[1], $vac_ex_date[2], $vac_ex_date[0]));

                      $vac_div = $vac_row['am_pm_w'];
                      $work_vac = $vac_row['benefit_vac'];

                      //반차, 연차, 근무 휴무 구분
                      if ($vac_div == 'a') {

                        $vac_name = "<b><span class='rest_half'>오전 반차</span></b>";

                      } elseif ( $vac_div == 'p' ) {

                        $vac_name = "<b><span class='rest_half'>오후 반차</span></b>";

                      } elseif ( $vac_div == 'w' ) {

                        $vac_name = "<b><span class='rest_whole'>연차 휴무</span></b>";

                      } elseif ($vac_div == 'n' && $work_vac == 'v') {

                        $vac_name = "<b><span class='work_rest'>근무 휴무</span></b>";

                      }

                      //날짜가 같으면 삽입
                      if ($vac_row['date'] == '2020-01-01') {//첫 연차 저장날짜 제외

                        echo '';

                      } elseif ($day == $vac_date && $month == $vac_month && $year == $vac_year) {

                        echo '<br><span class="name">';
                        echo htmlspecialchars($vac_row['name']) . " " . $vac_name . '</span></span>';
                        echo ' <input type=radio name="check_name" value ="vac-'.$vac_row["id"].'">';

                      }

                    }

                  // 14. 날짜 증가
                  $day++;
              }

              echo '</td>';
          }

       ?>
        </tr>
        <?php }
     ?>
      </table>
      <button type="submit" class="btn btn-secondary" value="삭 제" formaction="..\data\process_vacation.php?mode=delete">삭제</button>
      <button type="submit" class="btn btn-secondary" value="삭 제" formaction="..\data\process_vacation.php?mode=benefit">수당 신청</button>
      <button type="submit" class="btn btn-secondary" value="삭 제" formaction="..\data\process_vacation.php?mode=benefit_cancel">수당 신청 취소</button>
      <?php //관리자만 활성화
      if ($login_session == '정윤희' || $login_session == '윤무원') { ?>
      <button type="submit" class="btn btn-secondary" value="삭 제" formaction="..\data\process_vacation.php?mode=benefit_ok">수당 신청 확인</button>
     <?php } ?>
    </div>
  </form>
  <form method="post">
    <div class="form">
      <table class="table info">
        <tbody>
          <tr>
            <th scope="row">
            날짜 선택
            </th>
            <td>
              <input type="date" name="date" placeholder="yyyy-mm-dd" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}">
            </td>
          </tr>
          <?php //관리자만 활성화
          if ($login_session == '양혜경' || $login_session == '윤무원') { ?>
          <tr>
            <th scope="row">
              근무자 선택
            </th>
            <td>
              <input type="checkbox" name="member[]" value="양혜경">양혜경
              <input type="checkbox" name="member[]" value="김현경">김현경
              <input type="checkbox" name="member[]" value="최용훈">최용훈
              <input type="checkbox" name="member[]" value="최성윤">최성윤
              <input type="checkbox" name="member[]" value="정윤희">정윤희
              <input type="checkbox" name="member[]" value="윤정연">윤정연
              <input type="checkbox" name="member[]" value="김재형">김재형
              <input type="checkbox" name="member[]" value="윤무원">윤무원
            </td>
          </tr>
          <?php } ?>
          <tr>
            <th scope="row">
              휴무 방식 선택
            </th>
            <td>
              <input type="radio" name="vac" value="a">오전 반차
              <input type="radio" name="vac" value="p">오후 반차
              <input type="radio" name="vac" value="w">1일
              <input type="radio" name="vac" value="work_vac">주말근무 휴무
            </td>
          </tr>
        </tbody>
      </table>
      <button type="submit" class="btn btn-secondary" value="휴무 등록" formaction="..\data\process_vacation.php?mode=vac_insert">휴무 등록</button>
      <?php
      if ($login_session == '양혜경' || $login_session == '윤무원' ) { ?>
        <button type="submit" class="btn btn-secondary" value="근무 등록" formaction="..\data\process_vacation.php?mode=work_insert">근무 등록</button>
      <?php } ?>
    </div>
  </form>

      <h3 class="sec01_title">연차 현황</h3>
          <div class="accordion" id="accordionExample">
            <p class="location">
        <?php
        $members = ['양혜경', '김현경', '최용훈', '최성윤', '정윤희', '김재형', '윤정연', '윤무원'];

        //load data
        for( $i=0; $i < sizeof($members); $i++ ){

          echo '
          <button class="btn btn-info collapsed" type="button" data-toggle="collapse" data-target="#'. $members[$i] .'" aria-expanded="false" aria-controls="collapseOne">'. $members[$i] .'</button>';
        }

        echo '</p>';

        for ($i=0; $i < sizeof($members); $i++) {
          $query = "SELECT * FROM daihan.2020_vacation WHERE name= '$members[$i]' AND vacation='y' AND am_pm_w != 'v' ORDER BY id";
          $result = $db->query($query);
          echo '<div class="card">
          <div id="'. $members[$i] .'" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample" style="">
          <div class="card-body">
          <table class="table table-striped">
            <thead>
            <tr>
            <th scope="col">사용 날짜</th>
            <th scope="col">사용일수</th>
            <th scope="col">남은일수</th>
            </tr>
            </thead>
            ';

            //휴일 분류에 따라 표시
            foreach ($result as $row) {
              if ( $row['use_date'] == '0.0') {

                $vac_div = '';

              } elseif ($row['am_pm_w'] == 'a') {

                $vac_div = '(오전 반차)';

              } elseif ($row['am_pm_w'] == 'p') {

                $vac_div = '(오후 반차)';

              } else {
                $vac_div = '(연차 휴무)';
              }

              echo '

              <tbody><tr>
              <td scope="row">' . $row['date'] . '</td>' .
              '<td>' . $row['use_date'] . $vac_div . '</td>' .
              '<td>' . $row['remain'] . '</td>' .
              '</tr>';
            }

          echo '</tbody></table></div></div></div>';

        }
        ?>
      </div>
  </div>
