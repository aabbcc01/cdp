<?php

function vc_condition($u_row,$row):bool{

    return (

        $u_row['year']==$row['year'] 
        && intval($u_row['ind_type'])===intval($row['ind_type']) 
        && intval($u_row['vc_type'])===intval($row['vc_type'])
        && intval($u_row['tr_ph'])===intval($row['tr_ph']) 
        && intval($u_row['type'])===intval($row['type'])
        
    );

}



?>