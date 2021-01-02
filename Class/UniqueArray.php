<?php

class UniqueArray {

    public $forComp;

    public function unique(){

        $tmp=[];
        $uniqueArray = [];
        foreach ($this->forComp as $value){

            if (!in_array($value['company_name'], $tmp)) {
                $tmp[] = $value['company_name'];
                $uniqueArray[] = $value;
             }  

        }

        return $uniqueArray;

    }
            
}
?>