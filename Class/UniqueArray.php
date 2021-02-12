<?php

class UniqueArray {

    public $forComp;

    public function unique(){

        $tmp=[];
        $uniqueArray = [];          
       
        foreach ($this->forComp as $value){

            $comp_year=$value['company_id'].'_'.$value['year'];
            
            if (!in_array($comp_year, $tmp)) {
                $comp_year=$value['company_id'].'_'.$value['year'];
                $tmp[] = $comp_year;

                $uniqueArray[] = $value;
             }  

        }

        return $uniqueArray;

    }
            
}
?>