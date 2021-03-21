<?php
function make_html($toggle,$u_vc,$i,$tp,$d_str,$cvc){
    echo '<tr><th>上流(調達) ',$cvc[1],'件','</th><th>直接操業 ',$cvc[2],'件','</th><th>下流(市場・需要) ',$cvc[3],'件','</th><th colspan="2">その他 ',$cvc[4],'件','</th></thead> ';
        if(isset($u_vc[$i][$tp])){
            foreach($u_vc[$i][$tp] as $arr_1){
                echo '<tr>';
                    if(isset($arr_1)){
                        foreach($arr_1 as $key=>$arr_2){
                            if($arr_2!==$d_str){

                            echo '<td><a href="#',$toggle,'_',$arr_2['year'],$arr_2['ind_type'],$arr_2['tr_ph'],$arr_2['vc_type'],$arr_2['type'],'">
                                 ',$arr_2['year'],' ',$arr_2['company'],'<br>',
                                 $toggle,' type : ', $arr_2['type_term'],'<br>','Driver: ',$arr_2['driver_20'],
                                 $arr_2['driver_19'],'</a></td>';
 
                            }elseif($key !==4){  
                                /* 値が初期値d_strのままで、かつ、インベストメントチェーン(vc_type=4)の時は<td>を作成
                                しない。 */
                                echo '<td> </td>';
                            }
                        }
                    }else{
                        echo '<tr><td colspan="4"> No information</td></tr>';
                    }
                echo '</tr>';
            }
        }else{
            echo '<tr><td colspan="4"> No information</td></tr>';
        }
    }
    ?>