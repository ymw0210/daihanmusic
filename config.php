<?php


try {
    $name = '';
    $pw = '';
    $db = new PDO('mysql:host=', $name, $pw); //mySQL conneting

} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

/*
   define('DB_SERVER', '127.0.0.1:3306');
   define('DB_USERNAME', 'ymw0210');
   define('DB_PASSWORD', 'eogks8017');
   define('DATABASE_MEMBER', 'member');
   define('DATABASE_RETURN', 'return');
   define('DATABASE_VACATION', 'vacation');
   define('DATABASE_BOARD', 'board');
   $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DATABASE_MEMBER);
   $db_return = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DATABASE_RETURN);
   $db_vacation = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DATABASE_VACATION);
   $db_board = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DATABASE_BOARD);
*/

//암호화 함수
   function ec($ec_str) {
     $key = '';
     $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
     $iv = openssl_random_pseudo_bytes($ivlen);
     $ciphertext_raw = openssl_encrypt($ec_str, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
     $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
     $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
     return $ciphertext;
   }

//복호화 함수
   function dec($dec_str) {
     $key = '';
     $c = base64_decode($dec_str);
     $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
     $iv = substr($c, 0, $ivlen);
     $hmac = substr($c, $ivlen, $sha2len=32);
     $ciphertext_raw = substr($c, $ivlen+$sha2len);
     $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
     $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);

     if (hash_equals($hmac, $calcmac))//PHP 5.6+ timing attack safe comparison
     {
         return $original_plaintext;
     }
   }

//2차원 배열 정렬 : 정렬대상 array, 정렬 기준 key, 오름/내림차순
function arr_sort($array, $key, $sort='asc') {

    $keys = array();

    $vals = array();

    foreach ($array as $k=>$v) {

      $i = $v[$key].'.'.$k;

      $vals[$i] = $v;

      array_push($keys, $k);

    }

    unset($array);

    if ($sort=='asc') {

      ksort($vals);

    } else {

      krsort($vals);

    }

    $ret = array_combine($keys, $vals);

    unset($keys);

    unset($vals);

    return $ret;

  }


/*
  //배열 키값 체인지
  function change_key( $array, $old_key, $new_key ) {

    if( ! array_key_exists( $old_key, $array ) )
        return $array;

    $keys = array_keys( $array );
    $keys[ array_search( $old_key, $keys ) ] = $new_key;

    return array_combine( $keys, $array );
}


//배열로 문자열검색
function strposa($haystack, $needles=array(), $offset=0) {
        $chr = array();
        foreach($needles as $needle) {
                $res = strpos($haystack, $needle, $offset);
                if ($res !== false) $chr[$needle] = $res;
        }
        if(empty($chr)) return false;
        return min($chr);
}*/


include("class/mainorder.php");

include("class/pagenation.php");

include("class/calander.php");

include("class/getRecentDate.php");

include("class/post.php");
?>
