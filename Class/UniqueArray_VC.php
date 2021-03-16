<?php

class UniqueArrayVC {

    public $forComp;

    public function unique($tog){

        $tmp=[];
        $uniqueArray = [];          
       
        foreach ($this->forComp as $value){

            if($tog==1){
            $unique_number=$value['year'].$value['company_id'].$value['tr_ph'].$value['vc_type'].$value['type'].
            $value['d_type'];
            }elseif($tog==2){ /* $tog==2はグラフ用' */
                $unique_number=$value['year'].$value['tr_ph'].$value['vc_type'].$value['type']
            ;}
            
            if (!in_array($unique_number, $tmp)) {
                $unique_number=$unique_number;

                $tmp[] = $unique_number;

                $uniqueArray[] = $value;
             }  

        }

        return $uniqueArray;

    }
            
}
?>