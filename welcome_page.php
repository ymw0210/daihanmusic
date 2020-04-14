<?php
   include('..\session.php');
?>
<html>
   <head>

     <meta charset="utf-8">

     <title>Welcome </title>

     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
     <link rel="stylesheet" type="text/css" href="..\css\main.css">

   </head>
   <style>
   .list-group {
     width : 300px;
     margin: 1% auto;
   }
   #fadin {
    animation: fadein 0.5s;
    -moz-animation: fadein 0.5s; /* Firefox */
    -webkit-animation: fadein 0.5s; /* Safari and Chrome */
    -o-animation: fadein 0.5s; /* Opera */
  }
  @keyframes fadein {
    from {
        opacity:0;
    }
    to {
        opacity:1;
    }
  }
  @-moz-keyframes fadein { /* Firefox */
    from {
        opacity:0;
    }
    to {
        opacity:1;
    }
  }
  @-webkit-keyframes fadein { /* Safari and Chrome */
    from {
        opacity:0;
    }
    to {
        opacity:1;
    }
  }
  @-o-keyframes fadein { /* Opera */
    from {
        opacity:0;
    }
    to {
        opacity: 1;
    }
  }

   </style>
   <body>
     <!-- 헤더시작 -->
     <?php include('..\common\header'); ?>
     <!-- 헤더 끝-->
     <!-- 본문 -->
     <div id="fadin">
       <?php

       if(isset($_GET['page'])) {
         include($_GET['page']);
       } else {
         include('..\page\welcome_page_contents.php');
       }
       ?>
    </div>
     <!-- 본문끝-->
     <!-- 하단-->
     <?php include('..\common\footer'); ?>
     <!-- 하단 끝 -->
   </body>
</html>
