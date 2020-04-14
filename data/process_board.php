<?php
include('..\session.php');

switch ($_GET['mode']) {
  case 'insert':
  $title = htmlspecialchars($_POST['title']);
  $ec_pw = ec(htmlspecialchars($_POST['password']));
  $content = htmlspecialchars($_POST['content']);

  $tmpfile = $_FILES['fileup']['tmp_name'];
  $name = $_FILES['fileup']['name'];
  $file_ex = explode('.', $name);
  $ext = strtolower(end($file_ex));
  $filename = iconv("UTF-8", "EUC-KR",$name);
  $folder = "../upload/".$filename;
  $noallowed_ext = array('php','html','js');
  // 확장자 확인
  if( in_array($ext, $noallowed_ext) ) {
    echo '<script language="javascript">';
      echo 'alert("허용되지 않은 확장자입니다."); location.href="../welcome.php?page=board.php&pg=1"';
      echo '</script>';
  } else {

    $result = move_uploaded_file($tmpfile,$folder);

    $query = "INSERT INTO daihan.board
    (title, content, fileup, author, date, hit, password)
    VALUES
    ( :title, :content, :name, :login_session, NOW() , 0, :ec_pw)";
    $stmt = $db->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $stmt->execute(array(
        ':title'=>$title,
        ':content'=>$content,
        ':name'=>$name,
        ':login_session'=>$login_session,
        ':ec_pw'=>$ec_pw
      ));

      $count = $stmt->rowCount();

      if($count>0){
        echo '<script language="javascript">';
        echo 'alert("저장이 완료되었습니다."); location.href="../welcome.php?page=board.php&pg=1"';
        echo '</script>';

        } else {
          echo "<script>alert('오류가 발생하였습니다. 담당자에게 문의해주세요.')\;</script>";
        }
}
    break;

  case 'modify':
    $id = $_POST['id'];
    $query = "SELECT id, password FROM daihan.board WHERE id = :id";
    $stmt = $db->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $stmt->execute(array(':id'=>$id));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $title = htmlspecialchars($_POST['title']);
    $password = htmlspecialchars($_POST['password']);
    $tmpfile =  $_FILES['fileup']['tmp_name'];
    $name = $_FILES['fileup']['name'];
    $file_ex = explode('.', $name);
    $ext = strtolower(end($file_ex));
    $filename = iconv("UTF-8", "EUC-KR",$name);
    $folder = "../upload/".$filename;
    $noallowed_ext = array('php','html','js');
    $content = htmlspecialchars($_POST['content']);

    if(dec($row['password']) != $password){
        echo '<script language="javascript">';
        echo 'alert("패스워드가 틀립니다."); location.href="../welcome.php?page=board_view&no=' . $row['id'] . '"';
        echo '</script>';
    } else if ( in_array($ext, $noallowed_ext) ){
        echo '<script language="javascript">';
        echo 'alert("허용되지 않은 확장자입니다."); location.href="../welcome.php?page=board_view&no=' . $row['id'] . '"';
        echo '</script>';
    } else {
      $result = move_uploaded_file($tmpfile,$folder);

      $query = "UPDATE daihan.board SET
        title = :title,
        fileup = :name,
        content = :content
        WHERE id = :id";
      $stmt = $db->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
      $stmt->execute(array(
        ':title'=>$title,
        ':name'=>$name,
        ':content'=>$content,
        ':id'=>$id
      ));

       $count = $stmt->rowCount();

       if($count>0){
         echo '<script language="javascript">';
         echo 'alert("저장이 완료되었습니다."); location.href="../welcome.php?page=board_view&no=' . $row['id'] . '"';
         echo '</script>';

         } else {
           echo "<script>alert('오류가 발생하였습니다. 담당자에게 문의해주세요.')\;</script>";
         }
    }
    break;

  case 'delete':
  $id = $_POST['id'];
  $password_check = htmlspecialchars($_POST['password_check']);
  $query = "SELECT password, fileup FROM daihan.board WHERE id = :id";
  $stmt = $db->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
  $stmt->execute(array(':id'=>$id));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  if(dec($row['password']) == $password_check){

  unlink("../upload/{$row['fileup']}");
  $query = "DELETE FROM daihan.board WHERE id = :id";
  $stmt = $db->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
  $stmt->execute(array(':id'=>$id));

  $count = $stmt->rowCount();

  if($count>0){
    echo '<script language="javascript">';
    echo 'alert("삭제되었습니다."); location.href="../welcome.php?page=board&pg=1"';
    echo '</script>';

    } else {
      echo "<script>alert('오류가 발생하였습니다. 담당자에게 문의해주세요.')\;</script>";
    }
  } else {
    echo '<script language="javascript">';
      echo 'alert("비밀번호가 틀립니다."); location.href="../welcome.php?page=board_view&no=' . $id . '"';
      echo '</script>';
  }
    break;
}


?>
