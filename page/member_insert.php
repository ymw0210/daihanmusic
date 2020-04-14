<?php
/*
  include("config.php");

   session_start();
    //멤버 가입 비밀번호 암호화
   // 회원가입 화면에서 입력받은 비밀번호를 가져옵니다
       $user_passwd = $_POST['password'];
       $user_id = $_POST['username'];

   // 비밀번호를 암호화 합니다
       $encrypted_passwd = password_hash($user_passwd, PASSWORD_DEFAULT);
       $db = mysqli_connect('127.0.0.1:3306','ymw0210','eogks8017','daihan');
   // 비밀번호를 DB 에 저장합니다
       $query = " INSERT INTO daihan.memberlist2 ( name, userid, userpw ) VALUES ( '최성윤', '$user_id', '$encrypted_passwd') ";
       $result = mysqli_query($db,$query);
       var_dump($result);


      if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form

      $myusername = mysqli_real_escape_string($db,$_POST['username']);
      $mypassword = mysqli_real_escape_string($db,$_POST['password']);

      $sql = "SELECT id FROM memberlist WHERE userid = '$myusername' and userpw = AES_DECRYPT(userpw,SHA2('key',512))";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
      $active = $row['active'];

      $count = mysqli_num_rows($result);

      if($count == 1) {
         $_SESSION['login_user'] = $myusername;

         header("location: ..\page\welcome_page.php");
      }else {
         $error = "Your Login Name or Password is invalid";
      }
   }
   */
?>
<html>

   <head>

      <meta charset="utf-8">

      <title>Daihan Music</title>


      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

      <style>

         .form-signin {
           width: 300px;
           margin: 1% auto;
         }

      </style>

   </head>
   <body class="text-center">
      <form class="form-signin" action = "" method = "post">
        <img class="mb-4" src="..\img\logo300.jpg" alt="" width="200px" height="">
        <label for="inputEmail" class="sr-only">User ID</label>
        <input type="text" id="inputText" class="form-control" placeholder="User ID"name = "username" required="" autofocus="">
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" name = "password" required="">
        <button class="btn btn-lg btn-dark btn-block" type="submit" value = "Login">Sign in</button>
      </form>
      <div style = "font-size:11px; color:#cc0000; margin:10px auto;">
        <?php echo $error; ?>
      </div>
      <p class="mt-5 mb-3 text-muted">© 2019</p>
   </body>
</html>
