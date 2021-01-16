<?php
require_once '../cdp3/Encode.php';
function getCDP($params){
	//DBの接続情報
	require_once '../cdp3/DbManager.php';

	//DBコネクタを生成
    $db=getDb();
    
  /*   $industry=[];
    if(isset($params['industry']) && is_array($params['industry'])){
        $sql=$db->prepare('SELECT company_id FROM v_companies_industries where industry like :industry');
        $ind=strval(($_REQUEST['industry']));
        $sql->bindvalue(":industry",'%'.$ind.'%',PDO::PARAM_STR);
        $sql->execute();

        //$industry=$sql->fetch(PDO::FETCH_ASSOC);
        
        while($row=$sql->fetch(PDO::FETCH_ASSOC)){
            $industry[]='company_id='.$row['company_id'];
        }
        //print_r($industry);
    } */
     
    $where=[];
	/* if(isset($params['company']) && is_array($params['company'])){
        $sql=$db->prepare('SELECT company FROM v_table where company = :name');
        $compName=strval(($_GET['company']));
        
        $sql->bindvalue(":name",'%'.$compName.'%',PDO::PARAM_STR);
        $sql->execute();
       
        $comp_name=$sql->fetch(PDO::FETCH_ASSOC);
      //  print_r($comp_name['company']);
       // $comp_name=$sql->fetch(PDO::FETCH_ASSOC);
        $where[] = 'company='."'".$comp_name['company']."'"; //文字列は' ' でくくらないとエラーになる点に注意。
       // print_r($where);
    } */

    if(isset($params['company']) && is_array($params['company'])){
        $company=[];
    
        // $company[]= のところはcompany = "Taisei" のようになる。
          foreach($params['company'] as $key=>$val){
            $company[]='company = '.'"'.$val.'"'; 
         }  

        /*  for($i=0; $i < count($params); $i++){
            $company[]='company = '.'"'.$params.[$i].'"'; 
         }; */
       
        $comp=implode(' OR ',$company); 
      
        $sql=$db->prepare('SELECT * FROM v_table where '.$comp);
        $sql->execute();

        while($row=$sql->fetch(PDO::FETCH_ASSOC)){
                $where[]=$row;
        }
        
        return $where;
        
    }   

     //return $params;
    return print_r($params);
   
	/* if(!empty($params['value_chain'])){
        $sql=$db->prepare('SELECT value_chain FROM v_table where value_chain=:vc_type');
        //$vc='%'.strval(($_REQUEST['value_chain'])).'%';
        $vc=strval(($_REQUEST['value_chain']));
        
        $sql->bindvalue(':vc_type',$vc,PDO::PARAM_STR);
        $sql->execute();

        $value_chain=$sql->fetch(PDO::FETCH_ASSOC);
		$where[] = 'value_chain='."'".$value_chain['value_chain']."'";
     } */

 
      /*   if($where){
        $whereSql = implode(' AND ', $where);
       // print_r('$whereSql= '.$whereSql);
		$sql =$db->prepare('select * from v_table where ' .$whereSql);
        }else{
            $sql =$db->prepare('select * from v_table');
        };
       
    //SQL文を実行する
	$sql->execute(); */
    
    //print_r($sql);

	/* $result = [];
	while($row = $sql->fetch(PDO::FETCH_ASSOC)){
		$result[] = $row;
    };
   
	return $result; */
}

