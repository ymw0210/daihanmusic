<?php
  $id = $_GET['no'];
  $password_check = htmlspecialchars($_POST['password_check']);

  $query = "SELECT title, content, id, fileup, password FROM daihan.board WHERE id = $id";
  $result = $db->query($query);
  $row = $result->fetch(PDO::FETCH_ASSOC);

  if(dec($row['password']) == $password_check) {

?>
  <div class="row">
   <div class="col-md-2"></div>
   <div class="col-md-8">
    <h2 class="text-center">수 정</h2><p></p>
      <form action="" method="post" enctype="multipart/form-data">
        <div class="table table-responsive">
         <table class="table table-striped">
           <tr>
             <th class="success">글번호</th>
             <td><?=$row['id']?><input type="hidden" name="id" value="<?=$row['id']?>"></td>
           </tr>
           <tr>
             <td>제목</td>
             <td><input type="text"  class="form-control" name="title" value="<?=htmlspecialchars($row['title'])?>"></td>
           </tr>
           <tr>
             <td>첨부 파일</td>
             <td><input type="file"  class="form-control" name="fileup" value="<?=$row['fileup']?>"></td>
           </tr>
           <tr>
             <td>비밀번호</td>
             <td><input type="password"  class="form-control" name="password" required></td>
           </tr>

           <tr>
             <td>글내용</td>
             <td><textarea rows="10" cols="50" class="form-control" name="content"><?=htmlspecialchars($row['content'])?></textarea></td>
           </tr>
           <tr>
             <td colspan="2"  class="text-center">
               <input type="submit" value="수정" class="btn btn-secondary" formaction="../data/process_board.php?mode=modify">
               <input type="reset" value="초기화" class="btn btn-secondary">
               <input type="button"  class="btn btn-secondary" onclick="location.href='../welcome.php?page=board&pg=1'" value="목록보기">
             </td>
           </tr>

         </table>
       </div>
     </form>
    </div>
  </div>
<?php
 } else {
  echo '<script language="javascript">';
    echo 'alert("비밀번호가 틀립니다."); location.href="../welcome.php?page=board_view&no=' . $id . '"';
    echo '</script>';
}
?>
