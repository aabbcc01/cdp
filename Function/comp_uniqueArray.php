<?php

function comp_uniqueArray($data){

        $tmp=[];
        $uniqueArray = [];          
       
        foreach ($data as $value){

            $comp_year=$value['company_id'].'_'.$value['year'];
            
            if (!in_array($comp_year, $tmp)) {
                //$comp_year=$value['company_id'].'_'.$value['year'];
                $comp_year=$comp_year;
                $tmp[] = $comp_year;

                $uniqueArray[] = $value;
             }  

        }

        return $uniqueArray;

}
            

?>