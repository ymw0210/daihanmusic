<?php

//페이지 클래스 확장
   class Pagenation extends PDO {

     private $page_set; // 한페이지 줄수
     private $block_set; // 한페이지 블럭수


     public function __construct($page_set, $block_set) {
         $this->page_set = $page_set;
         $this->block_set = $block_set;
     }

     //페이징 데이타 arr로 출력
    public function getReturnPageData($query){
       global $db;

       $result = $db->query($query);
       $row = $result->fetch(PDO::FETCH_ASSOC);
       $total = $row['total']; // 전체글수

       $total_page = ceil($total / $this->page_set); // 총페이지수(올림함수)
       $total_block = ceil($total_page / $this->block_set); // 총블럭수(올림함수)

       $page = ($_GET['pg']) ? $_GET['pg'] : 1;
       $block = ceil($page/$this->block_set); // 현재블럭(올림함수)
       $limit_idx = ($page - 1) * $this->page_set; // limit시작위치

       $first_page = (($block - 1) * $this->block_set) + 1; // 첫번째 페이지번호
       $last_page = min ($total_page, $block * $this->block_set); // 마지막 페이지번호

       $prev_page = $page - 1; // 이전페이지
       $next_page = $page + 1; // 다음페이지

       $prev_block = $block - 1; // 이전블럭
       $next_block = $block + 1; // 다음블럭

       // 이전블럭을 블럭의 마지막으로 하려면...
       $prev_block_page = $prev_block * $this->block_set; // 이전블럭 페이지번호

       // 이전블럭을 블럭의 첫페이지로 하려면...
       //$prev_block_page = $prev_block * $block_set - ($block_set - 1);
       $next_block_page = $next_block * $this->block_set - ($this->block_set - 1); // 다음블럭 페이지번호
       $PHP_SELF = "../welcome.php?page=return";

       return array(
           "total" => $total,
           "page_set" => $this->page_set,
           "block_set" => $this->block_set,
           "total_page" => $total_page,
           "total_block" => $total_block,
           "block"=>$block,
           "limit_idx"=>$limit_idx,
           "first_page"=>$first_page,
           "last_page"=>$last_page,
           "prev_page"=>$prev_page,
           "next_page"=>$next_page,
           "prev_block_page"=>$prev_block_page,
           "next_block_page"=>$next_block_page,
           "PHP_SELF"=>$PHP_SELF,
           "page"=>$page
         );
       }


  public function getPostPageData($query){
     global $db;

     $result = $db->query($query);
     $row = $result->fetch(PDO::FETCH_ASSOC);
     $total = $row['total']; // 전체글수

     $total_page = ceil($total / $this->page_set); // 총페이지수(올림함수)
     $total_block = ceil($total_page / $this->block_set); // 총블럭수(올림함수)

     $page = ($_GET['pg']) ? $_GET['pg'] : 1;
     $block = ceil($page/$this->block_set); // 현재블럭(올림함수)
     $limit_idx = ($page - 1) * $this->page_set; // limit시작위치

     $first_page = (($block - 1) * $this->block_set) + 1; // 첫번째 페이지번호
     $last_page = min ($total_page, $block * $this->block_set); // 마지막 페이지번호

     $prev_page = $page - 1; // 이전페이지
     $next_page = $page + 1; // 다음페이지

     $prev_block = $block - 1; // 이전블럭
     $next_block = $block + 1; // 다음블럭

     // 이전블럭을 블럭의 마지막으로 하려면...
     $prev_block_page = $prev_block * $this->block_set; // 이전블럭 페이지번호

     // 이전블럭을 블럭의 첫페이지로 하려면...
     //$prev_block_page = $prev_block * $block_set - ($block_set - 1);
     $next_block_page = $next_block * $this->block_set - ($this->block_set - 1); // 다음블럭 페이지번호
     $PHP_SELF = "../welcome.php?page=post";

     return array(
         "total" => $total,
         "page_set" => $this->page_set,
         "block_set" => $this->block_set,
         "total_page" => $total_page,
         "total_block" => $total_block,
         "block"=>$block,
         "limit_idx"=>$limit_idx,
         "first_page"=>$first_page,
         "last_page"=>$last_page,
         "prev_page"=>$prev_page,
         "next_page"=>$next_page,
         "prev_block_page"=>$prev_block_page,
         "next_block_page"=>$next_block_page,
         "PHP_SELF"=>$PHP_SELF,
         "page"=>$page
       );
     }


public function getBoardPageData($query){
   global $db;

   $result = $db->query($query);
   $row = $result->fetch(PDO::FETCH_ASSOC);
   $total = $row['total']; // 전체글수

   $total_page = ceil($total / $this->page_set); // 총페이지수(올림함수)
   $total_block = ceil($total_page / $this->block_set); // 총블럭수(올림함수)

   $page = ($_GET['pg']) ? $_GET['pg'] : 1;
   $block = ceil($page/$this->block_set); // 현재블럭(올림함수)
   $limit_idx = ($page - 1) * $this->page_set; // limit시작위치

   $first_page = (($block - 1) * $this->block_set) + 1; // 첫번째 페이지번호
   $last_page = min ($total_page, $block * $this->block_set); // 마지막 페이지번호

   $prev_page = $page - 1; // 이전페이지
   $next_page = $page + 1; // 다음페이지

   $prev_block = $block - 1; // 이전블럭
   $next_block = $block + 1; // 다음블럭

   // 이전블럭을 블럭의 마지막으로 하려면...
   $prev_block_page = $prev_block * $this->block_set; // 이전블럭 페이지번호

   // 이전블럭을 블럭의 첫페이지로 하려면...
   //$prev_block_page = $prev_block * $block_set - ($block_set - 1);
   $next_block_page = $next_block * $this->block_set - ($this->block_set - 1); // 다음블럭 페이지번호
   $PHP_SELF = "../welcome.php?page=return";

   return array(
       "total" => $total,
       "page_set" => $this->page_set,
       "block_set" => $this->block_set,
       "total_page" => $total_page,
       "total_block" => $total_block,
       "block"=>$block,
       "limit_idx"=>$limit_idx,
       "first_page"=>$first_page,
       "last_page"=>$last_page,
       "prev_page"=>$prev_page,
       "next_page"=>$next_page,
       "prev_block_page"=>$prev_block_page,
       "next_block_page"=>$next_block_page,
       "PHP_SELF"=>$PHP_SELF,
       "page"=>$page
     );
   }
}

 ?>
