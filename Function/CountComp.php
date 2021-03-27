<?php

function CountComp($data){

    $count_comp=[];
    
    $risk=0;
    $opp=0;
    $other=0;
    
    foreach($data as $row){

        $ro=intval($row['risk_opp']);
        if($ro===1){
            $risk++;
        }elseif($ro===2){
            $opp++;
        }

    }
    $count_comp[1]=$risk;
    $count_comp[2]=$opp;

    return $count_comp;
}

?>