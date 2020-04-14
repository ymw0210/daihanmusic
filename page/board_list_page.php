<style>
.sec01 {
  width: 80%;
}

</style>
<?php
$pagenation = new Pagenation(10, 5);

$query="SELECT count(id) as total FROM $dbName";

$pg_result = $pagenation->getBoardPageData($query);

// 현재페이지 쿼리
$query2 = "SELECT * FROM $dbName ORDER BY id DESC LIMIT ".$pg_result['limit_idx'].", ".$pg_result['page_set'];

?>
<div class="sec01">
<h2 class="sec01_title">직원게시판</h2>
	<table class="table table-striped table-bordered table-hover table-sm">
		<thead>
			<tr>
				<th width="8%;">번호</th>
				<th width="64%;">제목</th>
				<th width="10%;">작성자</th>
				<th width="10%;">작성일</th>
				<th width="8%;">조회</th>
			</tr>
		</thead>
	<tbody>

<?php
	foreach ($db->query($query2) as $row) {

		echo '<tr>' . '<td>' . htmlspecialchars($row['id']) . '</td>' .
		'<td class="text-left">' . '<a href="../welcome.php?page=board_view&no=' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['title']) . '</a></td>' .
		'<td>' . htmlspecialchars($row['author']) . '</td>' .
		'<td>' . htmlspecialchars($row['date']) . '</td>' .
		'<td>' . htmlspecialchars($row['hit']) . '</td>' .
		'</tr>';

	}

	echo '</tbody></table>';
	?>

 	<ul class="pagination justify-content-center">

	<?php
	echo ($pg_result['prev_page'] > 0) ?
	 "<li class='page-item'><a class='page-link' href='" . $pg_result['PHP_SELF'] . "&pg=" . $pg_result['prev_page'] . "'>Previous</a></li>" :
	 "<li class='page-item'><a class='page-link'>Previous</a></li>";

	 for ($i=$pg_result['first_page']; $i<=$pg_result['last_page']; $i++) {

	 echo ($i != $pg_result['page']) ?
	 "<li class='page-item'><a class='page-link' href='" . $pg_result['PHP_SELF'] . "&pg=$i'>$i</a></li> " :
	 "<li class='page-item active'><a class='page-link' href='" . $pg_result['PHP_SELF'] . "&pg=$i'><b>$i</b></a></li>";

	 }

	 echo ($pg_result['next_page'] <= $pg_result['total_page']) ?
	 "<li class='page-item'><a class='page-link' href='". $pg_result['PHP_SELF'] . "&pg=" . $pg_result['next_page'] . "'>Next</a></li>" :
	 "<li class='page-item'><a class='page-link'>Next</a></li>";
	 ?>

	</ul>
	<div class="bottom_btn">
		<button type="button" class="btn btn-secondary" onclick="location.href='../welcome.php?page=board_write'">글쓰기</button>
	</div>
