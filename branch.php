<?php
session_start();
require_once './DbManager.php';
require_once './Function/verifyUser.php';
$registrant=verifyUser($_SESSION['user'],getDb());

if(!empty($_GET['chart'])){
    //Chartを作成する場合
    if($_GET['chart']==1){
      require_once('chart.php');
    }else{
        require_once('chart_vc.php');
      }
   
} else{
    
  if(intval($registrant['per_key']) & 2){
    require_once('result.php');
  }else{
    echo 'Sorry you don\'t have permission to this page.';

  }
}
 

?>