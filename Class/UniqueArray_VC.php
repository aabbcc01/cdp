<?php

class UniqueArrayVC {

    public $forComp;

    public function unique(){

        $tmp=[];
        $uniqueArray = [];          
       
        foreach ($this->forComp as $value){

            $vc_type_driver=$value['risk_opp'].$value['tr_ph'].$value['vc_type'].$value['r_type'].
            $value['rd_type'].$value['o_type'].$value['od_type'].$value['company_id'].$value['year'];
            
            if (!in_array($vc_type_driver, $tmp)) {
                $vc_type_driver=$vc_type_driver;

                $tmp[] = $vc_type_driver;

                $uniqueArray[] = $value;
             }  

        }

        return $uniqueArray;

    }
            
}
?>