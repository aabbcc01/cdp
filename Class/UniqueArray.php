<?php

class UniqueArray {

    public $forComp;

    public function unique(){

        $tmp=[];
        $uniqueArray = [];              
        foreach ($this->forComp as $value){

            if (!in_array($value['company_id'], $tmp)) {
                $tmp[] = $value['company_id'];
                $uniqueArray[] = $value;
             }  

        }

        return $uniqueArray;

    }
            
}
?>