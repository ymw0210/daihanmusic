<?php
include('..\config.php');
	$page_set = 10; // 한페이지 줄수
	$block_set = 5; // 한페이지 블럭수

	$query = "SELECT count(id) as total FROM daihan.board";
	$result = mysqli_query($db_board, $query);
	$row = mysqli_fetch_array($result);

	$total = $row['total']; // 전체글수

	$total_page = ceil($total / $page_set); // 총페이지수(올림함수)
	$total_block = ceil($total_page / $block_set); // 총블럭수(올림함수)

	$page = ($_GET['page'])?$_GET['page']:1;


	$block = ceil ($page / $block_set); // 현재블럭(올림함수)

	$limit_idx = ($page - 1) * $page_set; // limit시작위치

	// 현재페이지 쿼리
	$query = "SELECT id FROM daihan.board ORDER BY id DESC LIMIT $limit_idx, $page_set";
	$result = mysqli_query($db_board, $query);
	$rows = mysqli_num_rows($result);
	echo "<pre>";
	while ($row = mysqli_fetch_array($result)) {
	echo $row['id']."\n";
	}
	echo "</pre>";

	// 페이지번호 & 블럭 설정
	$first_page = (($block - 1) * $block_set) + 1; // 첫번째 페이지번호
	$last_page = min ($total_page, $block * $block_set); // 마지막 페이지번호

	$prev_page = $page - 1; // 이전페이지
	$next_page = $page + 1; // 다음페이지

	$prev_block = $block - 1; // 이전블럭
	$next_block = $block + 1; // 다음블럭

	// 이전블럭을 블럭의 마지막으로 하려면...
$prev_block_page = $prev_block * $block_set; // 이전블럭 페이지번호
// 이전블럭을 블럭의 첫페이지로 하려면...
//$prev_block_page = $prev_block * $block_set - ($block_set - 1);
$next_block_page = $next_block * $block_set - ($block_set - 1); // 다음블럭 페이지번호
$PHP_SELF = "../page/board_list_page_test.php";
	// 페이징 화면

	echo ($prev_page > 0) ? "<a href='$PHP_SELF?page=$prev_page'>[prev]</a> " : "[prev] ";
	echo ($prev_block > 0) ? "<a href='$PHP_SELF?page=$prev_block_page'>...</a> " : "... ";

	for ($i=$first_page; $i<=$last_page; $i++) {
	echo ($i != $page) ? "<a href='$PHP_SELF?page=$i'>$i</a> " : "<b>$i</b> ";
	}

	echo ($next_block <= $total_block) ? "<a href='$PHP_SELF?page=$next_block_page'>...</a> " : "... ";
	echo ($next_page <= $total_page) ? "<a href='$PHP_SELF?page=$next_page'>[next]</a>" : "[next]";


	?>
    <div class="text-center">
      <ul class="pagination">
        <li><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">4</a></li>
      </ul>
    </div>
		<div>
    	<button type="button" class="btn btn-secondary pull-right" onclick="location.href='../page/welcome_page.php?page=board_write_page.php'">글쓰기</button>
		</div>
