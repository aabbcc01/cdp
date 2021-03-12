<?php

function CountVC($data,$tr_ph){

    $count_vc=[];
    $upstream=0;
    $diop=0;
    $down=0;
    $other=0;
    foreach($data as $row){
        $vc_type=intval($row['vc_type']);
        $trph=intval($row['tr_ph']);

        if($vc_type===1 && $tr_ph===$trph ){
            $upstream++;
        }elseif($vc_type===2 && $tr_ph===$trph ){
            $diop++;
        }elseif($vc_type===3 && $tr_ph===$trph ){
            $down++;
        }elseif($vc_type===4 || $vc_type===5 and $tr_ph===$trph){
            $other++;
        }

    }
    $count_vc[1]=$upstream;
    $count_vc[2]=$diop;
    $count_vc[3]=$down;
    $count_vc[4]=$other;
    return $count_vc;
}

?>