<?php
//require_once '../cdp3/Encode.php';
function getCDP($params){
	//DBの接続情報
    require_once '../cdp3/DbManager.php';
   
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

     if(isset($params['chapter']) && is_array($params['chapter'])){
        $chapter=[];

          foreach($params['chapter'] as $val){
            $chapter[]=$val;
         } 
         $chapterid=implode(',',$chapter);
     }else{$chapterid='';}

      if(isset($params['question'])  && is_array($params['question'])){
          $question=[];
          foreach($params['question'] as $val){
            $question[]= $val;
          }
          $qid=implode(',',$question);          
      }else{$qid='';}
    
     if(!empty($params['value_chain'])){
        $vc_type=[];
          foreach($params['value_chain'] as $val){
            $vc_type[]= $val;
         } 
         $vctype=implode(',',$vc_type);
     }else{$vctype='';} 
       
        /* $Sql の最終形態：は(year IN (x,y) AND company_id IN (x,y) )
         AND (chapter_id IN (x,y) OR question_id IN (x,y) OR vc_type IN (x,y) )    */  
    $sql=$db->prepare('CALL sp_answer(:year,:compid,:chapterid,:questionid,:vctype)');
    $sql->bindValue(':year',$year);
    $sql->bindValue(':compid',$compid);
    $sql->bindValue(':chapterid',$chapterid);
    $sql->bindValue(':questionid',$qid);
    $sql->bindValue(':vctype',$vctype);

	$sql->execute(); 

	$result = [];
	while($row = $sql->fetch(PDO::FETCH_ASSOC)){
		$result[] = $row;
    };
   
	return $result;  
}

