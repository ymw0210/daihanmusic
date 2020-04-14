<?php
   include('config.php');
   session_start();

   $user_check = htmlspecialchars($_SESSION['login_user']);
   $query = "SELECT name FROM daihan.memberlist2 WHERE userid = :user_check";
   $stmt = $db->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
   $stmt->execute(array(':user_check'=>$user_check));

   $row = $stmt->fetch(PDO::FETCH_ASSOC);

   $login_session = $row['name'];

   if(!isset($_SESSION['login_user'])){
      header("location: ../login_page.php");
      die();
   }
?>
