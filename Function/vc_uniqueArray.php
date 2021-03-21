<?php

function vc_uniqueArray($data,$tog){

    $tmp=[];
    $uniqueArray = [];      
    foreach ($data as $value){

        if($tog==1){
        $unique_number=$value['year'].$value['company_id'].$value['tr_ph'].$value['vc_type'].$value['type'].
        $value['d_type'];
        }elseif($tog==2){ /* $tog==2はグラフ用' */
            $unique_number=$value['year'].$value['ind_type'].$value['tr_ph'].$value['vc_type'].$value['type']
        ;}elseif($tog==3){
            $unique_number=$value['ind_type'];
        }
        
        if (!in_array($unique_number, $tmp)) {
            $unique_number=$unique_number;

            $tmp[] = $unique_number;

            $uniqueArray[] = $value;
         }  

    }

    return $uniqueArray;







}

?>