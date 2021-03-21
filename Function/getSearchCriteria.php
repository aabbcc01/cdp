<?php


function getSearchCriteria($params){

    if(isset($params['industry']) && is_array($params['industry'])){
        $ind=[];
        foreach($params['industry'] as $value){
            if($value==1){
                $ind[]= 'Auto mobile'; 
             }elseif($value==2){
                $ind[]='Chemical';
             }elseif($value==3){
                $ind[]='Construction';
             }elseif($value==4){
                $ind[]='Energy';
             }elseif($value==5){
                $ind[]='Food/Drink';
             }

        }
        $industry='産業タイプ ('.count($ind).' 業種) : '.implode('　',$ind);
        return $industry;
    }


}


?>