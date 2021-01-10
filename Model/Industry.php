<?php
require_once '../Encode.php';
function getUserData($params){
	//DBの接続情報
	require_once '../DbManager.php';

	//DBコネクタを生成
    $db=getDb();

    $industry=[];
    
    // $industry[]= のところはindustry = "chemical" のようになる。
     foreach($_GET as $key=>$val){
        $industry[]='industry = '.'"'.$val.'"'; 
     }  
   
    $ind=implode(' OR ',$industry); 
  
    $sql=$db->prepare('SELECT company FROM v_company_industry where '.$ind);
    $sql->execute();
       
    $result=[];
    while($row=$sql->fetch(PDO::FETCH_ASSOC)){
            $result[]=$row;
    }

    return $result;
        
}

