<?php

//データ取得ロジックを呼び出す
require_once('./Model/CdpAnswer.php');
require_once('./Model/ChartData.php');
require('style.css');

print 'Opp!';
 $CdpData = getCDP($_GET); //answersの取得。getCDPはCdpAnswer.php内に定義
$chartData = getChartData($CdpData);  












 ?>