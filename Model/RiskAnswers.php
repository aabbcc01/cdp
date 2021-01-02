<?php
require_once '../cdp/Encode.php';
function getUserData($params){
	//DBの接続情報
	require_once '../cdp/DbManager.php';

	//DBコネクタを生成
    $db=getDb();
    
    $industry=[];
    if(!empty($params['industry'])){
        $sql=$db->prepare('SELECT company_id FROM v_companies_industries where industry like :industry');
        $ind=strval(($_REQUEST['industry']));
        $sql->bindvalue(":industry",'%'.$ind.'%',PDO::PARAM_STR);
        $sql->execute();

        //$industry=$sql->fetch(PDO::FETCH_ASSOC);
        
        while($row=$sql->fetch(PDO::FETCH_ASSOC)){
            $industry[]='company_id='.$row['company_id'];
        }
        //print_r($industry);
    }
     
    $where=[];
	if(!empty($params['comp-name'])){
        $sql=$db->prepare('SELECT company_name FROM v_answers where company_name like :name');
        $compName=strval(($_REQUEST['comp-name']));
        
        $sql->bindvalue(":name",'%'.$compName.'%',PDO::PARAM_STR);
        $sql->execute();
       
        $comp_name=$sql->fetch(PDO::FETCH_ASSOC);
      //  print_r($comp_name['company_name']);
       // $comp_name=$sql->fetch(PDO::FETCH_ASSOC);
        $where[] = 'company_name='."'".$comp_name['company_name']."'"; //文字列は' ' でくくらないとエラーになる点に注意。
       // print_r($where);
    }
   
	if(!empty($params['value_chain'])){
        $sql=$db->prepare('SELECT value_chain FROM v_answers where value_chain=:vc_type');
        //$vc='%'.strval(($_REQUEST['value_chain'])).'%';
        $vc=strval(($_REQUEST['value_chain']));
        
        $sql->bindvalue(':vc_type',$vc,PDO::PARAM_STR);
        $sql->execute();

        $value_chain=$sql->fetch(PDO::FETCH_ASSOC);
		$where[] = 'value_chain='."'".$value_chain['value_chain']."'";
     }
    if(!empty($params['impact'])){
        $sql=$db->prepare('SELECT Magnitude_of_impact FROM risk_answers where Magnitude_of_impact =:impact');
        $impact=strval(($_REQUEST['impact']));
       // print($impact);
        $sql->bindvalue(':impact',$impact,PDO::PARAM_STR);
        $sql->execute();

        $impact=$sql->fetch(PDO::FETCH_ASSOC);
		$where[] = 'Magnitude_of_impact='."'".$impact['Magnitude_of_impact']."'";
    }
    
     if($industry){
        $industrySql=implode(' OR ',$industry);
        $sql=$db->prepare('select * from v_answers where ' . $industrySql);
      
        if($where){
       
            $whereSql = implode(' AND ', $where);
           // print_r('$whereSql= '.$whereSql);
    
            $sql =$db->prepare('select * from v_answers where '.'(' .$industrySql.')'.' AND '.$whereSql);
        }elseif(!$industry){
            $sql =$db->prepare('select * from v_answers');
        }

    }else{
        if($where){
        $whereSql = implode(' AND ', $where);
       // print_r('$whereSql= '.$whereSql);
		$sql =$db->prepare('select * from v_answers where ' .$whereSql);
        }else{
            $sql =$db->prepare('select * from v_answers');
        }
    
     }
       
    //SQL文を実行する
	$sql->execute();
    
    //print_r($sql);

	$result = [];
	while($row = $sql->fetch(PDO::FETCH_ASSOC)){
		$result[] = $row;
    }
   
	return $result;
}

