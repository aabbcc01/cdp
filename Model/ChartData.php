<?php
require_once '../cdp/Encode.php';

//$CdpData = getUserData($_REQUEST); //answersの取得

function getChartData($params){
	
    //DBの接続情報
    require_once '../cdp/DbManager.php';
    //DBコネクタを生成
    $db=getDb();
    
   
     
    if(isset($params['comp_id']) && is_array($params['comp_id'])){

        $comp_id=[];
    
        // $comp_id[]= のところはcompany_id = 21のようになる。
          foreach($params['comp_id'] as $key=>$val){
            $comp_id[]=$val;
         }  
       
         //sql用の変数。company_id=xx OR company_id=xx ...
        $compid=implode(',',$comp_id);
        $compidSql='company_id IN ('.$compid.') ';
        $year_comp[]=$compidSql;
    }    



    foreach($params['comp_id'] as $row){
        $sql=$db->prepare('SELECT company,identifier,value_chain,Time_horizon,Likelihood,
        impact,description,fig_TMHZ,fig_likelihood,fig_impact 
        FROM v_fig_chart where company_id=:comp_id');
        $id=strval($row['comp_id']);
        $sql->bindvalue(":comp_id",$id,PDO::PARAM_STR);
        $sql->execute();
        
    }$result = [];
	while($chart = $sql->fetch(PDO::FETCH_ASSOC)){
		$result[] = $chart;
    };
   
    return $result;   
    
}

