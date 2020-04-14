<?php


try {
    $name = '';
    $pw = '';
    $db = new PDO('mysql:host=', $name, $pw); //mySQL conneting

} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}


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


include("class/mainorder.php");

include("class/pagenation.php");

include("class/calander.php");

include("class/getRecentDate.php");

include("class/post.php");
?>
