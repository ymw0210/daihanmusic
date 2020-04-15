<?php
include("SEED128.php");

$seed = new SEED128();

$key = ""; //인증키
$sec_key = ""; //보안키
$track_key = ""; //택배조회 키
$regdata = "&regData=";

//우체국 고객번호
$custNo_regdata = ""; //memberId=daihanmusic2
$custNo_encryptStr = $seed->getEncryptData($sec_key, $custNo_regdata);
$url1 = "http://ship.epost.go.kr/api.GetCustNo.jparcel?key={$key}{$regdata}{$custNo_encryptStr}"; //custNo xml 리턴
$result1 = file_get_contents($url1); //url 컨텐츠 저장
$xml1 = simplexml_load_string($result1); //컨텐츠 xml object로 저장
$custNo = "custNo=".trim($xml1->custNo); //0004445999

//계약승인번호
$apprNo_encryptStr = $seed->getEncryptData($sec_key, $custNo);
$url2 = "http://ship.epost.go.kr/api.GetApprNo.jparcel?key={$key}{$regdata}{$apprNo_encryptStr}";
$result2 = file_get_contents($url2);
$xml2 = simplexml_load_string($result2);
$row2 = $xml2->contractInfo;

$apprNo = "apprNo=" . trim($row2->apprNo); //4032680564
$payTypeCd = "payTypeCd=" . trim($row2->payTypeCd); //12
$payTypeNm = "payTypeNm=" . trim($row2->payTypeNm); //후납
$postNm = "postNm=" . trim($row2->postNm); //경기광주

//공급지정보 조회
$url3 = "http://ship.epost.go.kr/api.GetOfficeInfo.jparcel?key={$key}{$regdata}{$apprNo_encryptStr}"; //custNo xml 리턴
$result3 = file_get_contents($url3);
$xml3 = simplexml_load_string($result3);
$row3 = $xml3->officeInfo['1'];
$officeSer = "officeSer=" . trim($row3->officeSer); //200174951
$officeNm = "officeNm=" . trim($row3->officeNm); //대한음악사(02)
$officeZip = "officeZip=" . trim($row3->officeZip); //12771
$officeAddr = "officeAddr=" . trim($row3->officeAddr); //경기도 광주시 오포읍 문형산안길 6-5 (신현리) 가동 1층 대한음악사
$officeTelno = "officeTelno=" . trim($row3->officeTelno); //031-8022-9918
$contactNm = "contactNm=" . trim($row3->contactNm); //대한음악사



 ?>
