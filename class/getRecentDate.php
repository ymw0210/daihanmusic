<?php
//최신글 표시함수
class getRecentDate extends PDO {

  // N 표시 기간(음수로 지정)
  private $date;
  private $timestamp;
  private $date_div;

  public function __construct() {

  }

  public function getRecectReturn($date){
    //new 표시 기간 설정
    $timestamp = strtotime($date . " days");
    $date_div = date("Y-m-d", $timestamp);

    global $db;
    $return_query = 'SELECT date FROM daihan.return_list2 ORDER BY date DESC LIMIT 1';

    //데이터베이스 최신글 date 가져오기
    $result = $db->query($return_query);
    $date = $result->fetch(PDO::FETCH_ASSOC);

    if ($date['date'] >= $date_div) {

      return $new = '<span class="badge badge-pill badge-danger">N</span>';

    } else {

     return $new = "";

    }

  }

  public function getRecectBoard($date){

    //new 표시 기간 설정
    $timestamp = strtotime($date . " days");
    $date_div = date("Y-m-d", $timestamp);

    global $db;
    $board_query = 'SELECT date FROM daihan.board ORDER BY date DESC LIMIT 1';

    //데이터베이스 최신글 date 가져오기
    $result = $db->query($board_query);
    $date = $result->fetch(PDO::FETCH_ASSOC);

    if ($date['date'] >= $date_div) {

      return $new = '<span class="badge badge-pill badge-danger">N</span>';

    } else {

      return $new = "";

    }

  }

  public function getRecectPost($date){

    //new 표시 기간 설정
    $timestamp = strtotime($date . " days");
    $date_div = date("Y-m-d", $timestamp);

    global $db;
    $board_query = 'SELECT date FROM daihan.return_post ORDER BY date DESC LIMIT 1';

    //데이터베이스 최신글 date 가져오기
    $result = $db->query($board_query);
    $date = $result->fetch(PDO::FETCH_ASSOC);

    if ($date['date'] >= $date_div) {

      return $new = '<span class="badge badge-pill badge-danger">N</span>';

    } else {

      return $new = "";

    }

  }

}

 ?>
