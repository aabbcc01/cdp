<?php
if(!empty($_GET['chart'])){
   //Chartを作成する場合
    require_once('chart_risk.php');
    require_once('chart_opp.php'); 
   
} else{
    require_once('result2.php');
}
 

?>