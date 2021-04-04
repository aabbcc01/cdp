<?php
require_once '../cdp/Encode.php';
function getChartData($params,$stored_procedure,$table){
	//DBの接続情報
    require_once '../cdp/DbManager.php';
   
	//DBコネクタを生成
    $db=getDb();

    if(isset($params['year']) && is_array($params['year'])){
        $year=[];
        foreach($params['year'] as $val){
            $year[]=$val;
        }
        $year=implode(',',$year);
    }else{$year='';}

    if(isset($params['comp_id']) && is_array($params['comp_id'])){
        $comp_id=[];
          foreach($params['comp_id'] as $val){
            $comp_id[]=$val;
         }  
        $compid=implode(',',$comp_id);
    }elseif(isset($params['industry'])){return;}
    else{$compid='';}      
    
    if(!empty($params['value_chain'])){
        $vc_type=[];
    
          foreach($params['value_chain'] as $val){
            $vc_type[]= $val;
         } 
         $vctype=implode(',',$vc_type);
     }else{$vctype='';} 

    $sql=$db->prepare('CALL '.$stored_procedure.'(:table,:year,:compid,:vctype)');
    $sql->bindValue(':table',$table);
    $sql->bindValue(':year',$year);
    $sql->bindValue(':compid',$compid);
    $sql->bindValue(':vctype',$vctype);
 
	$sql->execute(); 

	$result = [];
	while($row = $sql->fetch(PDO::FETCH_ASSOC)){
		$result[] = $row;
    };
   
	return $result;  
}

