<?php
if(!empty($_GET['chart'])){
    print 'hello'.'<br>';
    print_r($_GET['chart']);
	/* require_once('./Model/ChartData.php');
	$chartData = getChartData($CdpData); */
} else{
    require_once('./result2.php');
}
 

?>