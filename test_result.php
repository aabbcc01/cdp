<?php
session_start() ;
/* if($_SERVER["REQUEST_METHOD"] != "POST"){
	// ブラウザからHTMLページを要求された場合
	$no_login_url = "index.php";

		echo 'Oops! invalid access is detected!  ';
	    //header("Location: {$no_login_url}");
	    exit;
} */

//データ取得ロジックを呼び出す
require_once('./Model/CdpAnswer.php');
require_once('./Class/UniqueArray.php');
require('style.css');
//重複を除いた企業名の表示
/* $comp_db = getCDP($_REQUEST);
if($comp_db){
    print_r($comp_db); 
}else{print 'var_dump($comp_db)= '; var_dump($comp_db);}


?>
 */ 
function getGET($param){
    if(isset($param['industry']) && is_array($param['industry'])){
        print_r($param);
		echo '<br>';
		print_r($param['industry']); 
		echo '<br>';
		print_r($param['chapter']);
		echo '<br>';
		print_r($param['company']);
        echo '<br>';
		print_r($param['value_chain']);
		echo '<br>';
		print_r($_SESSION['comp_6']);
    }
    

};

echo getGET($_POST);

 ?>
</body>
</html>