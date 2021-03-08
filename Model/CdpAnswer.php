<?php
//require_once '../cdp3/Encode.php';
function getCDP($params){
	//DBの接続情報
    require_once '../cdp3/DbManager.php';
   

	//DBコネクタを生成
    $db=getDb();
    
    $where=[];
    $year_comp=[];

    if(isset($params['year']) && is_array($params['year'])){

        $year=[];
        foreach($params['year'] as $key=>$val){
            $year[]=$val;
        }
        //sql用の変数。
        $year=implode(',',$year);
        $yearSql='year IN ('.$year.') ';
        $year_comp[]=$yearSql;
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
        $year_comp[]=$compidSql;
    }      

    // (A AND B) のsqlを作成： (year IN (2020,2019,20xx,...) AND company_id IN (14,15,...) )
    if(!empty($year_comp)){
        $year_compSql=implode(' AND ',$year_comp);
        $where[]='('.$year_compSql.')';
    }

    $chapter_question=[];

     if(isset($params['chapter']) && is_array($params['chapter'])){
        $chapter=[];
    
        // $chapter[]= のところはchapter_id = 21のようになる。
          foreach($params['chapter'] as $key=>$val){
            $chapter[]=$val;
         } 
         //sql用の変数。
         $chapterid=implode(',',$chapter);
         $chapteridSql='chapter_id IN ('.$chapterid.') ';
         $chapter_question[]=$chapteridSql;
     } 

      if(isset($params['question'])  && is_array($params['question'])){
          $question=[];
          foreach($params['question'] as $key=>$val){
            $question[]= $val;
          }
          $qid=implode(',',$question);
          $qidSql='question_id IN ('.$qid.') ';
          $chapter_question[]=$qidSql;
          
      }
    
     if(!empty($params['value_chain'])){
        $vc_type=[];
    
        // value_cahin_id[]= のところはvalue_chain_type = 21のようになる。
          foreach($params['value_chain'] as $key=>$val){
            $vc_type[]= $val;
         } 
         //sql用の変数。
         $vctype=implode(',',$vc_type);
         $vctypeSql='value_chain_type IN ('.$vctype.') ';
         $chapter_question[]=$vctypeSql;
     } 

     // (A AND B) のsqlを作成：
     if(!empty($chapter_question)){
         $chapter_questionSql=implode(' OR ',$chapter_question);
        $where[]='('.$chapter_questionSql.')';
    }

     
         if(!empty($year_comp) && !empty($chapter_question)){
        /* $whereSql の最終形態：は(year IN (x,y) AND company_id IN (x,y) )
         AND (chapter_id IN (x,y) OR question_id IN (x,y) OR value_chain_type IN (x,y) )    */  
        $whereSql = implode(' AND ', $where);
       // print_r('$whereSql= '.$whereSql."<br>");
        $sql =$db->prepare('select * from v_table where '.'(' .$whereSql.')'.' ORDER BY id');

        }elseif(empty($year_comp) && empty($chapter_question)){
            //全てのチェックボックスにチェックがされていない場合：全件検索
            $sql =$db->prepare('select * from v_table');
        }else{
            if(!empty($year_compSql)){
                $a=$year_compSql;
            }elseif(!empty($chapter_questionSql)){
                $a=$chapter_questionSql;
            }
            $whereSql = $a;
           //　print_r('$whereSql= '.$whereSql."<br>");
            $sql =$db->prepare('select * from v_table where '.'(' .$whereSql.')'.' ORDER BY id');
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

