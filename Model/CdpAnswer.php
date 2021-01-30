<?php
require_once '../cdp3/Encode.php';
function getCDP($params){
	//DBの接続情報
	require_once '../cdp3/DbManager.php';

	//DBコネクタを生成
    $db=getDb();
    
    $where=[];
    if(isset($params['year']) && is_array($params['year'])){

        $year=[];
        foreach($params['year'] as $key=>$val){
            $year[]=$val;
        }
        //sql用の変数。
        $year=implode(',',$year);
        $yearSql='year IN ('.$val.') ';
        $where[]=$yearSql;
       
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
        $where[]=$compidSql;
    }   
   

     if(!empty($params['chapter'])){
        $chapter=[];
    
        // $chapter[]= のところはchapter_id = 21のようになる。
          foreach($params['chapter'] as $key=>$val){
            $chapter[]=$val;
         } 
         //sql用の変数。
         $chapterid=implode(',',$chapter);
         $chapteridSql='chapter_id IN ('.$chapterid.') ';
         $where[]=$chapteridSql;
     } 
/* 
     if(isset($params['question']) && is_array($params['question'])){
         $question=[];
        foreach($params['question'] as $key=>$val){
            $question[]=$val;
         } 
         //sql用の変数。
         $questionid=implode(',',$question);
         $questionidSql='question_id IN ('.$questionid.') ';
         $where[]=$questionidSql;
     }
      print_r($question); */
      if(isset($params['question'])){
          $question=[];
          foreach($params['question'] as $key=>$val){
            $question[]= $val;
          }
          $qid=implode(',',$question);
          $qidSql='question_id IN ('.$qid.') ';
          $where[]=$qidSql;
          
      }
      print_r($qidSql);

     if(!empty($params['value_chain'])){
        $vc_id=[];
    
        // value_cahin_id[]= のところはvalue_chain_id = 21のようになる。
          foreach($params['value_chain'] as $key=>$val){
            $vc_id[]= $val;
         } 
         //sql用の変数。
         $vcid=implode(',',$vc_id);
         $vcidSql='value_chain_id IN ('.$vcid.') ';
         $where[]=$vcidSql;
     } 

    
         if($where){
        $whereSql = implode(' AND ', $where);
       // print_r('$whereSql= '.$whereSql);
		$sql =$db->prepare('select year,company_id,company,chapter_id,question,question_id,answer_1, answer_2, answer_3, answer_4, answer_5, answer_6
        from v_table where ' .$whereSql);
        }else{
            $sql =$db->prepare('select * from v_table');
        }; 

       
    //SQL文を実行する
	$sql->execute(); 
    
    //print_r($sql);

	  $result = [];
	while($row = $sql->fetch(PDO::FETCH_ASSOC)){
		$result[] = $row;
    };
   
	return $result;  
}

