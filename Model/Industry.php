<?php
//industryタイプから企業名を取得
require_once '../Encode.php';
function byIndustry($params){
	//DBの接続情報
	require_once '../DbManager.php';

	//DBコネクタを生成
    $db=getDb();

    $industry=[];
    
    // $industry[]= のところはindustry = "chemical" のようになる。
     foreach($_GET as $key=>$val){
        $industry[]='ind_id = '.'"'.$val.'"'; 
     }  
   
    $ind=implode(' OR ',$industry); 
  
    $sql=$db->prepare('SELECT * FROM company_industry where '.$ind);
    $sql->execute();
       
    $result=[];
    while($row=$sql->fetch(PDO::FETCH_ASSOC)){
            $result[]=$row;
    }

    return $result;
        
}

