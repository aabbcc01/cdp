<?php
if(!empty($_GET['chart'])){
   //Chartを作成する場合
   if($_GET['chart']==1){
    require_once('chart.php');} else{
      require_once('chart_vc.php');
    }
  //  require_once('chart_opp.php'); 
   
} else{
    require_once('result.php');
}
 

?>