<?php

function countVC($ro,$u_vc,$d_str){

$nums_vc=[];
$count_vc=[];

if($ro==1){
    for($i=1;$i<3;$i++){
        foreach($u_vc[1][$i] as $arr_1){
            foreach($arr_1 as $arr_2){
                foreach($arr_2 as $arr_3){
                    if($arr_3!==$d_str){
                        $nums_vc[1][$i][intval($arr_3['vc_type'])][]=$arr_3['vc_type'];
                    }
                }
            }
        }
    }
}elseif($ro==2){
    
    foreach($u_vc[2][0] as $arr_1){
        foreach($arr_1 as $arr_2){

            foreach($arr_2 as $arr_3){
                if($arr_3!==$d_str){
                    $nums_vc[2][0][intval($arr_3['vc_type'])][]=$arr_3['vc_type'];
                }
            }
            
        }
    }

    
}
for($i=1;$i<6;$i++){
    $count_vc[1][1][$i]=count(array_keys($nums_vc[1][1][$i]));
    $count_vc[1][2][$i]=count(array_keys($nums_vc[1][2][$i]));
    $count_vc[2][0][$i]=count(array_keys($nums_vc[2][0][$i]));
}


return $count_vc;

}

?>