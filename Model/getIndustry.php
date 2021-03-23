<?php
require_once '../DbManager.php';
require_once '../Encode.php';
require_once 'Industry.php';


$company= byIndustry($_GET); //v_company_industryテーブルから企業名を取得

 print json_encode($company);

?>
