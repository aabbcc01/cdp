<?php
require_once '../DbManager.php';
require_once '../Encode.php';
require_once('./Industry.php');
/* require_once('./Class/UniqueArray.php'); */

$company= getUserData($_GET); //v_company_industryテーブルから企業名を取得
 /* foreach($company as $row){

  print '['.json_encode($row).']';
  
}  
 */
 print json_encode($company);

?>
