<?php
function getGET($param){
    if(isset($param['industry']) && is_array($param['industry'])){
        print_r($param);
        echo '<br>';
        print_r($param['company']);
        echo '<br>';
        print_r($param['industry']);
        echo '<br>';
        print_r($param['value_chain']);
    }
    

};

echo getGET($_GET);

?>