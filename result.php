<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script src="https://code.jquery.com/jquery-1.12.4.min.js" type="text/javascript"></script>
	<script src="js/scrollbtn.js"></script> 
	</head>
<body>
<?php


//データ取得ロジックを呼び出す
require_once('./Model/CdpAnswer.php');
require_once('./Function/comp_uniqueArray.php');
require('css/style.css');
require('css/scrollbtn.css');

$CdpData = getCDP($_GET);

print_r($CdpData);
?> 


</body>
</html>