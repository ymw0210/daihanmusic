<?php
  include('..\session.php');
  include('..\phpexcel\Classes\PHPExcel.php'); // 엑셀 라이브러리 import
  if (isset($_POST['checked'])){
      $select_id = $_POST['checked'];
      $selected = implode(" OR id=", $select_id);

      $query = "SELECT * FROM $dbName WHERE id= $selected ORDER BY id";

    //set the desired name of the excel file
    $fileName = date('Y-m-d') . '_환불일지';

    // Create new PHPExcel object
    $objPHPExcel = new PHPExcel();

    // Set document properties
    $objPHPExcel->getProperties()->setCreator("Me")->setLastModifiedBy("Me")->setTitle("My Excel Sheet")->setSubject("My Excel Sheet")->setDescription("Excel Sheet")->setKeywords("Excel Sheet")->setCategory("Me");


    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex(0);

    // Add column headers
    $objPHPExcel->getActiveSheet()
    			->setCellValue('A1', '접수날짜')
    			->setCellValue('B1', '사유')
    			->setCellValue('C1', '환불금액')
    			->setCellValue('D1', '예금주')
          ->setCellValue('E1', '은행')
          ->setCellValue('F1', '계좌번호')
          ->setCellValue('G1', '주문번호')
    ;

    $ii = 2;
    foreach ($db->query($query) as $info){
      $objPHPExcel->getActiveSheet()->setCellValue('A'.$ii, $info['date']);
      $objPHPExcel->getActiveSheet()->setCellValue('B'.$ii, $info['reason']);
      $objPHPExcel->getActiveSheet()->setCellValue('C'.$ii, $info['return_money']);
      $objPHPExcel->getActiveSheet()->setCellValue('D'.$ii, dec($info['account_name']));
      $objPHPExcel->getActiveSheet()->setCellValue('E'.$ii, dec($info['bank']));
      $objPHPExcel->getActiveSheet()->setCellValue('F'.$ii, dec($info['account']));
      $objPHPExcel->getActiveSheet()->setCellValue('G'.$ii, $info['order_number']);

      $ii +=1;

    }

    $objPHPExcel -> getActiveSheet() -> getColumnDimension("A") -> setWidth(13);
    $objPHPExcel -> getActiveSheet() -> getColumnDimension("B") -> setWidth(35);
    $objPHPExcel -> getActiveSheet() -> getColumnDimension("C") -> setWidth(10);
    $objPHPExcel -> getActiveSheet() -> getColumnDimension("D") -> setWidth(10);
    $objPHPExcel -> getActiveSheet() -> getColumnDimension("E") -> setWidth(10);
    $objPHPExcel -> getActiveSheet() -> getColumnDimension("F") -> setWidth(15);
    $objPHPExcel -> getActiveSheet() -> getColumnDimension("G") -> setWidth(20);
    $objPHPExcel -> getActiveSheet() -> getStyle('A1:A'. $ii) -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel -> getActiveSheet() -> getStyle('C1:C'. $ii) -> getNumberFormat() -> setFormatCode("#,##0");
    $objPHPExcel -> getActiveSheet() -> getStyle('C1:G'. $ii) -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel -> getActiveSheet() -> getStyle('G1:G'. $ii) -> getNumberFormat() -> setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
    $objPHPExcel -> getActiveSheet() -> getStyle('F1:F'. $ii) -> getNumberFormat() -> setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
    $objPHPExcel -> getActiveSheet() -> getStyle('A1:G'. ($ii-1)) -> getBorders() -> getAllBorders() -> setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

    // Set worksheet title
    $objPHPExcel->getActiveSheet()->setTitle($fileName);

    //save the file to the server (Excel2007)

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('.\\' . $fileName . '.xlsx'); // 저장될 파일 위치

    // 파일 다운로드 구현

    function mb_basename($path) { return end(explode('/',$path)); }

    function utf2euc($str) { return iconv("UTF-8","cp949//IGNORE", $str); }

    function is_ie() {

    if(!isset($_SERVER['HTTP_USER_AGENT']))return false;

    if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false) return true; // IE8

    if(strpos($_SERVER['HTTP_USER_AGENT'], 'Windows NT 6.1') !== false) return true; // IE11

    return false;

    }

    $filepath = './' . $fileName . '.xlsx';

    $filesize = filesize($filepath);

    $filename = mb_basename($filepath);

    if( is_ie() ) $filename = utf2euc($filename);


    header("Pragma: public");

    header("Expires: 0");

    header("Content-Type: application/octet-stream");

    header("Content-Disposition: attachment; filename=\"$filename\"");

    header("Content-Transfer-Encoding: binary");

    header("Content-Length: $filesize");

    ob_clean();

    flush();

    readfile($filepath);

    unlink($filepath); // 생성된 excel 파일 삭제
  } else {
    $query = "SELECT * FROM $dbName ORDER BY id";

  //set the desired name of the excel file
  $fileName = date('Y-m-d') . '_환불일지';

  // Create new PHPExcel object
  $objPHPExcel = new PHPExcel();

  // Set document properties
  $objPHPExcel->getProperties()->setCreator("Me")->setLastModifiedBy("Me")->setTitle("My Excel Sheet")->setSubject("My Excel Sheet")->setDescription("Excel Sheet")->setKeywords("Excel Sheet")->setCategory("Me");


  // Set active sheet index to the first sheet, so Excel opens this as the first sheet
  $objPHPExcel->setActiveSheetIndex(0);

  // Add column headers
  $objPHPExcel->getActiveSheet()
        ->setCellValue('A1', '접수날짜')
        ->setCellValue('B1', '사유')
        ->setCellValue('C1', '환불금액')
        ->setCellValue('D1', '예금주')
        ->setCellValue('E1', '은행')
        ->setCellValue('F1', '계좌번호')
        ->setCellValue('G1', '주문번호')
  ;

  $ii = 2;
  foreach ($db->query($query) as $info){
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$ii, $info['date']);
    $objPHPExcel->getActiveSheet()->setCellValue('B'.$ii, $info['name'] . ' - ' . $info['reason']);
    $objPHPExcel->getActiveSheet()->setCellValue('C'.$ii, $info['return_money']);
    $objPHPExcel->getActiveSheet()->setCellValue('D'.$ii, dec($info['account_name']));
    $objPHPExcel->getActiveSheet()->setCellValue('E'.$ii, dec($info['bank']));
    $objPHPExcel->getActiveSheet()->setCellValue('F'.$ii, dec($info['account']));
    $objPHPExcel->getActiveSheet()->setCellValue('G'.$ii, $info['order_number']);

    $ii +=1;

  }

  $objPHPExcel -> getActiveSheet() -> getColumnDimension("A") -> setWidth(13);
  $objPHPExcel -> getActiveSheet() -> getColumnDimension("B") -> setWidth(35);
  $objPHPExcel -> getActiveSheet() -> getColumnDimension("C") -> setWidth(10);
  $objPHPExcel -> getActiveSheet() -> getColumnDimension("D") -> setWidth(10);
  $objPHPExcel -> getActiveSheet() -> getColumnDimension("E") -> setWidth(10);
  $objPHPExcel -> getActiveSheet() -> getColumnDimension("F") -> setWidth(15);
  $objPHPExcel -> getActiveSheet() -> getColumnDimension("G") -> setWidth(20);
  $objPHPExcel -> getActiveSheet() -> getStyle('A1:A'. $ii) -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $objPHPExcel -> getActiveSheet() -> getStyle('C1:C'. $ii) -> getNumberFormat() -> setFormatCode("#,##0");
  $objPHPExcel -> getActiveSheet() -> getStyle('C1:G'. $ii) -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $objPHPExcel -> getActiveSheet() -> getStyle('G1:G'. $ii) -> getNumberFormat() -> setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
  $objPHPExcel -> getActiveSheet() -> getStyle('F1:F'. $ii) -> getNumberFormat() -> setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
  $objPHPExcel -> getActiveSheet() -> getStyle('A1:G'. ($ii-1)) -> getBorders() -> getAllBorders() -> setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

  // Set worksheet title
  $objPHPExcel->getActiveSheet()->setTitle($fileName);

  //save the file to the server (Excel2007)

  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
  $objWriter->save('.\\' . $fileName . '.xlsx'); // 저장될 파일 위치

  // 파일 다운로드 구현

  function mb_basename($path) { return end(explode('/',$path)); }

  function utf2euc($str) { return iconv("UTF-8","cp949//IGNORE", $str); }

  function is_ie() {

  if(!isset($_SERVER['HTTP_USER_AGENT']))return false;

  if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false) return true; // IE8

  if(strpos($_SERVER['HTTP_USER_AGENT'], 'Windows NT 6.1') !== false) return true; // IE11

  return false;

  }

  $filepath = './' . $fileName . '.xlsx';

  $filesize = filesize($filepath);

  $filename = mb_basename($filepath);

  if( is_ie() ) $filename = utf2euc($filename);


  header("Pragma: public");

  header("Expires: 0");

  header("Content-Type: application/octet-stream");

  header("Content-Disposition: attachment; filename=\"$filename\"");

  header("Content-Transfer-Encoding: binary");

  header("Content-Length: $filesize");

  ob_clean();

  flush();

  readfile($filepath);

  unlink($filepath); // 생성된 excel 파일 삭제
  }
    ?>
