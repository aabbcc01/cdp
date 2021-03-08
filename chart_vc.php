<html>
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script src="https://code.jquery.com/jquery-1.12.4.min.js" type="text/javascript"></script>
        <script src="js/scrollbtn.js"></script> 
	</head>
<body>

<?php

    //データ取得ロジックを呼び出す
    require_once('./Model/CdpAnswer.php');
    require_once('./Model/ChartData.php');
    require_once('./Class/UniqueArray_VC.php');
    //require('css/style.css');
    require('css/c2_table.css');
    require('css/scrollbtn.css');
    //　table用のmake_html関数を用意しておく。  
    require('./Function/vcTable.php');

 ?>
 <?php for($i=1; $i<3; $i++):  $toggle= $i==1 ?'Risk':'Opp'; $title= $i==1 ? 'C2.3a Risk':'C2.4a Opp';?>
    <?php
        $table=$i==1 ?'v_fig_chart_r ':'v_fig_chart_o'; 
        $chartData = getChartData($_GET,$table);  
        //重複を除いた企業名の表示
        $unique_array_vc= new UniqueArrayVC;
        $unique_array_vc->forComp=$chartData;
        $u_vcid=$unique_array_vc->unique();
    ?>

 <!--テーブル用の配列を準備。格納するデータは重複無し-->
 <?php    $u_vc=[];
	
	foreach($u_vcid as $row){
		
        $arr=array('year'=>intval($row['year']),'comp_id'=>intval($row['company_id']),'company'=>$row['company'],
        'risk_opp'=>intval($row['risk_opp']),'value_chain'=>$row['value_chain'],
        'vc_type'=>intval($row['vc_type']),'tr_ph'=>intval($row['tr_ph']),'r_type'=>intval($row['r_type']),
        'rd_type'=>intval($row['rd_type']),'o_type'=>intval($row['o_type']),'od_type'=>intval($row['od_type']),
        'type'=>$row['type'],'driver_20'=>$row['driver_20'],'driver_19'=>$row['driver_19']);

        $ro=$arr['risk_opp'];
        $trph=$arr['tr_ph'];
        $vctype=$arr['vc_type'];
        $d_str=' ';

        for($n=0;$n<count($u_vcid);$n++){           
            for($count_vctype=1; $count_vctype<6; $count_vctype++){
                if(!isset($u_vc[$ro][$trph][$n][$count_vctype]) ){
                    $u_vc[$ro][$trph][$n][$count_vctype]=$d_str;  
                }             
            }  
            if ($u_vc[$ro][$trph][$n][$vctype]==$d_str){
                $u_vc[$ro][$trph][$n][$vctype]=$arr;
                ksort($u_vc[$ro][$trph][$n]);
                break ;
            }  
        }     
    }
 /*  var_dump($u_vc);  */
/* echo count($u_vc[2]);  */
?> 

<div class="back-ground">
   <div id="vc_results">
        <?php if($i==1):?>
            
            <?php for($tp=1;$tp<=3;$tp++):
                if ($tp==1){$tog_tp='移行リスク';}
                elseif($tp==2){$tog_tp='物理的リスク';}
                else{$tog_tp='その他';} 
            ?>
                <table> 
                    <thead><tr><th colspan="5"><?= $tog_tp;?>&nbsp バリューチェーンごとの分類</th></tr>
                    <?php make_html($toggle,$u_vc,$i,$tp,$d_str);?>
                </table>
            <?php endfor;?>

        <?php elseif($i==2):?>

            <table> 
                <thead><tr><th colspan="5">機会 バリューチェーンごとの分類</th></tr>
                <?php make_html($toggle,$u_vc,$i,0,$d_str);?>
            </table>

        <?php endif;?>

  
  </div>


	<p class="alert alert-success">該当件数(No information 除く): <?= count($chartData),' 件'; ?></p>
    
<?php endfor;?>    

<p id="topbutton">
    <a href="#top" onclick="$('html,body').animate({ scrollTop: 0 }); return false;"> ▲ </a>
</p>

<div>
</body>
</html>