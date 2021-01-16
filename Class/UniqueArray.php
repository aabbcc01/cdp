<?php

class UniqueArray {

    public $forComp;

    public function unique(){

        $tmp=[];
        $uniqueArray = [];              
        foreach ($this->forComp as $value){

            if (!in_array($value['company'], $tmp)) {
                $tmp[] = $value['company'];
                $uniqueArray[] = $value;
             }  

        }

        return $uniqueArray;

    }
            
}
?>