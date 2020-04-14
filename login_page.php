<?php
   include("config.php");
   session_start();

   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form

      $myusername = htmlspecialchars($_POST['username']);
      $mypassword = htmlspecialchars($_POST['password']);
      $stmt = $db->prepare("SELECT * FROM $dbName WHERE userid = :userid");
      $stmt->bindParam(':userid', $myusername);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $hash_password  = $row['userpw'];

      if(password_verify($mypassword, $hash_password)) { // 비밀번호가 일치하는지 비교합니다.
        $_SESSION['login_user'] = $myusername;

      header("location: ..\welcome.php?page=welcome");
      } else {


      $error = "Your Login Name or Password is invalid";
      }

/*
      if($count == 1) {
         $_SESSION['login_user'] = $myusername;

         header("location: ..\page\welcome_page.php");
      }else {
         $error = "Your Login Name or Password is invalid";
      }
   }
 */}
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
        <?=$error?>
      </div>
      <p class="mt-5 mb-3 text-muted">© 2019</p>
   </body>

</html>
