<?php
require_once '../cdp3/Encode.php';
function getChartData($params,$table){
	//DBの接続情報
    require_once '../cdp3/DbManager.php';
   
	//DBコネクタを生成
    $db=getDb();
    
    $where=[];
    $year_comp_vctype=[];

    if(isset($params['year']) && is_array($params['year'])){
        $year=[];
        foreach($params['year'] as $key=>$val){
            $year[]=$val;
        }
        //sql用の変数。
        $year=implode(',',$year);
        $yearSql='year IN ('.$year.') ';
        $year_comp_vctype[]=$yearSql;
    }

    if(isset($params['comp_id']) && is_array($params['comp_id'])){
        $comp_id=[];
    
        // $comp_id[]= のところはcompany_id = 21のようになる。
          foreach($params['comp_id'] as $key=>$val){
            $comp_id[]=$val;
         }  
         //sql用の変数。company_id=xx OR company_id=xx ...
        $compid=implode(',',$comp_id);
        $compidSql='company_id IN ('.$compid.') ';
        $year_comp_vctype[]=$compidSql;
    } 
    
    if(!empty($params['value_chain'])){
        $vc_type=[];
    
        // value_cahin_id[]= のところはvc_type = 21のようになる。
          foreach($params['value_chain'] as $key=>$val){
            $vc_type[]= $val;
         } 
         //sql用の変数。
         $vctype=implode(',',$vc_type);
         $vctypeSql='vc_type IN ('.$vctype.') ';
         $year_comp_vctype[]=$vctypeSql;
     } 

    // (A AND B) のsqlを作成： (year IN (2020,2019,20xx,...) AND company_id IN (14,15,...) AND vc_type ID (1,2,...))
    if(!empty($year_comp_vctype)){
        $year_comp_vctypeSql=implode(' AND ',$year_comp_vctype);
        $where[]='('.$year_comp_vctypeSql.')';
    }

    if(!empty($year_comp_vctype)){
        /* $whereSql の最終形態：は(year IN (x,y) AND company_id IN (x,y) 
         AND vc_type IN (x,y) )    */  
        $whereSql = implode(' AND ', $where);
       // print_r('$whereSql= '.$whereSql."<br>");
        $sql =$db->prepare('select * from '.$table.' where '.'(' .$whereSql.') order by year desc,company,identifier asc');

    }else{
        //全てのチェックボックスにチェックがされていない場合：全件検索
        $sql =$db->prepare('select * from '.$table.' order by year desc,company,identifier asc');
    }
   
    //SQL文を実行する
	$sql->execute(); 
    
    //print_r($sql);

	  $result = [];
	while($row = $sql->fetch(PDO::FETCH_ASSOC)){
		$result[] = $row;
    };
   
	return $result;  
}

