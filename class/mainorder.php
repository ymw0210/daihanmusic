<?php
//디렉토리 리스트 받아오는 함수
   function getCurrentFileList($dir){
       $valid_formats = array("xlsx","xls");
       $handle = opendir($dir); // 디렉토리의 핸들을 얻어옴
       // 지정한 디렉토리에 있는 디렉토리와 파일들의 이름을 배열로 읽어들임
       $R = array(); // 결과 담을 변수 생성

       while ($filename = readdir($handle)) {
           $except_filename = substr( $filename, 0, 2 );
           if($filename == '.' || $filename == '..' || $except_filename == '~$') continue;

           $filepath = $dir.'/'.$filename;

           if(is_file($filepath)){ // 파일인 경우에만
               $getExt = pathinfo($filename, PATHINFO_EXTENSION); // 파일 확장자 구하기
               if(in_array($getExt, $valid_formats)){
                    $sort = explode(' ', $filename);
                    //$arr_sort = change_key($sort, 2, 'name');

                   array_push($R,$sort); // 파일이름만 선택하여 배열에 넣는다.
               }
           }
       }
       closedir($handle);
       //sort($R); // 가나다순으로 정렬하기 위해
       return $R;
   }


//메인오더 클래스
class MainorderClass {
  private $file;

  function __construct($file)
  {
     $this->file = $file;

  }




  //메인오더 파일명과 확장자 구분
  public function real_filename() {

    $explode = explode('.', $this->file);
    $count = count($explode);
    $ex = end($explode);
    $filename ='';

    for ($i=0; $i < $count-1; $i++) {

      $filename = $filename . $explode[$i] . '.';

    }

    $real_name = substr($filename, 0, -1);

    return array('realname' => $real_name, 'ex' => $ex);

  }

  public function del_check() {

    $explode = explode('.', $this->file);
    $ex = end($explode);
    $filename ='';

    $explode_check = explode('-', $this->file);

    $filename = trim($explode_check[0]) . "." . $ex;

    return $filename;

  }

  //메인오더 ok, cancel, Restricted 검사
  public function check_value() {
    $result = '';
    $search_ok = "ok";
    $search_cancel = "Cancel";
    $search_restricted = "Restricted";
    $ok_check = strstr($this->file, $search_ok);
    $cancel_check = strstr($this->file, $search_cancel);
    $restricte_check = strstr($this->file, $search_restricted);

    if ($ok_check != false) {

      $result = 'ok';

    } elseif ($cancel_check != false) {

      $result = 'Cancel';

    } elseif ($restricte_check != false) {

      $result = 'Restricted';

    } else {

      $result = 'no_value';

    }

    return $result;

  }

}


?>
