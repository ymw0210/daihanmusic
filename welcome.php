<?php
   include('session.php');
   include('phpexcel\Classes\PHPExcel.php');

   //N표시 클래스 변수지정
   $getRecentDate = new getRecentDate();
   $return_new = $getRecentDate->getRecectReturn(-2);
   $board_new = $getRecentDate->getRecectBoard(-10);
   $post_new = $getRecentDate->getRecectPost(-3);

   //css, js파일 새로고침
   $t = mktime();

?>
<!DOCTYPE html>
   <head>

     <meta charset="utf-8">

     <title>Welcome </title>

     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
     <link rel="stylesheet" type="text/css" href="..\css\main.css?ver=<?=$t?>">
     <script type="text/javascript" src="..\css\jsfunction.js?ver=<?=$t?>"></script>
   </head>
   <style>

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
  span.badge-danger {
    margin-left: 0.2rem;
    font-size: 0.4rem;
    vertical-align: super;
  }
   </style>
   <body>
     <!-- 헤더시작 -->
     <?php include('common\header'); ?>
     <!-- 헤더 끝-->
     <!-- 본문 -->
     <div id="fadin">
       <?php
       $pg = isset($_GET['page']) && $_GET['page'] ? $_GET['page'] : null;
       switch ($pg) {
         case 'welcome':
           include('page\welcome_page_contents.php');
           break;

         case 'return':
           include('page\return_list_page.php');
           break;

         case 'return_insert':
           include('page\return_insert_page.php');
           break;

         case 'return_modify':
          include('page\return_modify_page.php');
           break;

         case 'vacation':
           include('page\vacation_page.php');
           break;

         case 'board':
           include('page\board_list_page.php');
           break;

         case 'board_write':
           include('page\board_write_page.php');
           break;

         case 'board_view':
           include('page\board_view_page.php');
           break;

         case 'board_modify':
           include('page\board_modify_page.php');
           break;

         case 'predel':
           include('page\predel.php');
           break;

         case 'pre_modify':
           include('page\pre_modify.php');
           break;

         case 'mainorder':
           include('page\mainorder.php');
           break;

         case 'return_search':
           include('page\return_list_search_page.php');
           break;

         case 'post':
           include('page\post_list_page.php');
           break;

         case 'post_insert':
           include('page\post_insert_page.php');
           break;

         case 'post_modify':
           include('page\post_modify_page.php');
           break;

         default:
           include('page\welcome_page_contents.php');
           break;
       }
       ?>
    </div>
  </div>
     <!-- 본문끝-->
     <!-- 하단-->
     <?php include('common\footer'); ?>
     <!-- 하단 끝 -->
   </body>
</html>
