<?php

$id = $_GET['no'];
$query = "SELECT title, content, date, hit, id, author, fileup FROM $dbName WHERE id = $id";
$result = $db->query($query);
$row = $result->fetch(PDO::FETCH_ASSOC);


//$row['hit'] + 1  WHERE id = $row['id']
	// 조회수 증가 처리 (DB)
	$cal_hit = $row['hit']+1;
	$hit_query = "UPDATE $dbName SET hit = $cal_hit WHERE id = $id";
  $db->query($hit_query);
  $hit_result_query = "SELECT hit FROM $dbName WHERE id = $id";
  $hit_result = $db->query($hit_result_query);
  $hit_row = $hit_result->fetch(PDO::FETCH_ASSOC);
?>

  <div class="row">
    <div class="col-xs-2 col-md-2"></div>
      <div class="col-xs-8 col-md-8">
        <h2 class="text-center">게시글 보기</h2><p>&nbsp;</p>
        <div class="table table-responsive">
          <form action="" method="post">
          <table class="table">
            <tr>
              <th class="success">제목</th>
              <td colspan="3"><?=htmlspecialchars($row['title'])?></td>
            </tr>
            <tr>
              <th class="success">글번호</th>
              <td><?=htmlspecialchars($row['id'])?></td>
              <th class="success">조회수</th>
              <td><?=htmlspecialchars($hit_row['hit'])?></td>
            </tr>
            <tr>
              <th class="success">작성자</th>
              <td><?=htmlspecialchars($row['author'])?></td>
              <th class="success">작성일</th>
              <td><?=htmlspecialchars($row['date'])?></td>
            </tr>
            <tr>
              <th class="success">첨부 파일</th>
              <td colspan="3"><a href="../upload/<?=$row['fileup']?>" download><?=$row['fileup']?></a></td>
            </tr>
            <tr>
              <th class="success">글 내용</th>
              <td colspan="3" style="height:300px;"><?=nl2br(htmlspecialchars($row['content']))?></td>
            </tr>
            <tr>
              <td colspan="4" class="text-center">
                <input type="submit" class="btn btn-secondary" value="수정하기" formaction="../welcome.php?page=pre_modify&id=<?=$row['id']?>">
                <input type="submit" class="btn btn-secondary" value="삭제하기" formaction="../welcome.php?page=predel&id=<?=$row['id']?>">
                <input type="button" class="btn btn-secondary" value="목록보기" onclick="location.href='../page/welcome_page.php?page=board_list_page.php&pg=1'">
              </td>
            </tr>
        </table>
      </form>
      </div>
    </div>
  </div>
