<?php 
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
    require_once './DbManager.php';
    require_once './Encode.php';
    require_once './Function/verifyUser.php';
    require_once './Function/vc_condition.php';
    verifyUser($_SESSION['user'],getDb());
?>
<html>
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/c2_table.css">
        <link rel="stylesheet" href="css/scrollbtn.css">
        <script src="https://code.jquery.com/jquery-1.12.4.min.js" type="text/javascript"></script>
        <script src="js/scrollbtn.js"></script> 
	</head>
<body>

<?php

    
    require_once('./Model/CdpAnswer.php');
    require_once('./Model/ChartData.php');
  
    //　table用のmake_html関数を用意しておく。  
    require_once('./Function/vcTable.php');
    require_once('./Function/CountVC.php');
    require_once('./Function/vc_uniqueArray.php');
    require_once('./Function/getSearchCriteria.php');
    $indType=getSearchCriteria($_GET); //検索条件で指定された産業タイプを取得
 ?>
 <h3  style="text-align:center" ><?=$indType;?></h2>
<?php for($i=1; $i<3; $i++):  $toggle= $i==1 ?'Risk':'Opp'; $title= $i==1 ? 'C2.3a Risk':'C2.4a Opp';?>
    <?php
        $table=$i==1 ?'v_cht_risk ':'v_cht_opportunity'; 
        $stored_procedure='sp_cht_vc';
        $chartData = getChartData($_GET,$stored_procedure,$table);  
   
        //重複を除いた企業名の表示
        $u_vcid=vc_uniqueArray($chartData,1);
       
    ?>

    <!--テーブル用の配列を準備。格納するデータは重複無し-->
    <?php    $u_vc=[];
	
	foreach($u_vcid as $row){
		
        $ro=intval($row['risk_opp']);
        $trph=intval($row['tr_ph']);
        $vctype=intval($row['vc_type']);
        $d_str=' ';

        for($n=0;$n<count($u_vcid);$n++){           
            for($count_vctype=1; $count_vctype<6; $count_vctype++){
                if(!isset($u_vc[$ro][$trph][$n][$count_vctype]) ){
                    $u_vc[$ro][$trph][$n][$count_vctype]=$d_str;  
                }             
            }  
            if ($u_vc[$ro][$trph][$n][$vctype]==$d_str){
                $u_vc[$ro][$trph][$n][$vctype]=$row;
                ksort($u_vc[$ro][$trph][$n]);
                break ;
            }  
        }     
    }
     /*  var_dump($u_vc);  */
    /* echo count($u_vc[2]);  */
    ?> 
    <?php if(!empty($chartData)):?>
        <div class="back-ground">
        <div id="vc_results">
                <?php if($i==1):?>
                    
                    <?php for($tp=1;$tp<=3;$tp++):
                        if ($tp==1){$tog_tp='移行リスク';}
                        elseif($tp==2){$tog_tp='物理的リスク';}
                        else{$tog_tp='その他';} 
                    ?>
                        <table > 
                            <thead>
                            <tr><th colspan="4">C2.3a&nbsp:&nbsp<?= $tog_tp;?>&nbsp バリューチェーンごとの分類</th></tr>
                            <?php
                            $cvc=CountVC($u_vcid,$tp);
                            make_html($toggle,$u_vc,$i,$tp,$d_str,$cvc);?>
                        </table>
                    <?php endfor;?>

                <?php elseif($i==2):?>

                    <table> 
                        <thead><tr><th colspan="4">C2.4a&nbsp:&nbsp機会 バリューチェーンごとの分類</th></tr>
                        <?php 
                        $cvc=CountVC($u_vcid,0);
                        make_html($toggle,$u_vc,$i,0,$d_str,$cvc);?>
                    </table>
                    <br>
                <?php endif;?>
        
            </div>
    <?php else:?>
        <p class="alert alert-danger"><?= $toggle;?>&nbsp検索対象は見つかりませんでした。</p>
    <?php endif;?>
<?php endfor;?>    

<!-- ここからはグラフ関連 -->

<?php for($i=0; $i<2; $i++):  $toggle= $i==0 ?'Risk':'Opp'; $title= $i==0 ? 'C2.3a Risk':'C2.4a Opp';?>
    <?php
        $table=$i==0 ?'v_cht_risk ':'v_cht_opportunity'; 
        $stored_procedure='sp_cht_vc';
        $chartData = getChartData($_GET,$stored_procedure,$table);  
        //重複を除いた企業名の表示
        $u_vcid=vc_uniqueArray($chartData,2);
    ?>
    <?php if(!empty($chartData)):?>
        <?php $c=0; foreach($u_vcid as $u_row):?>
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                <script type="text/javascript">
                    // Load Charts and the corechart package.
                    google.charts.load('current', {'packages':['corechart']});
                    // Draw the bubble chart when Charts is loaded.
                    google.charts.setOnLoadCallback(Chart_<?= $toggle,'_',$c ; ?>);
                    function Chart_<?= $toggle,'_',$c ; ?>() {

                        // Create the data table .
                        var data = new google.visualization.arrayToDataTable([
                    
                        ['company','Magnitude of Impact', 'Likelihood', 'Time horizons'],
                        <?php if(!empty($chartData)):?> //note: if $chartData is empty, "foreach" doesn't loop it. 
                            
                            <?php foreach($chartData as $row): ?>
                                
                                <?php if (vc_condition($u_row,$row)) : ?>
                            
                                    ["<?=$row['company'],' ',$row['identifier'];?>",<?=$row['fig_impact'];?> ,
                                    <?=$row['fig_likelihood'];?>,<?=$row['fig_TMHZ'];?>],
                                
                                <?php elseif(!in_array($u_row['vc_type'],array_column($chartData,'vc_type'))):?> 
                                
                                    ['No information',0,0,0],
                                    <?php break;?>
                                <?php endif; ?>  

                            <?php endforeach;?>
                        
                        <?php elseif(empty($chartData)): ?>
                            
                            ['No information',0,0,0],
                        
                        <?php endif;?>
                        
                    ]);

                    var options = {
                        title: ' <?= $u_row['year']," ｜ CDP回答分析 ",$title,"｜",ucfirst($u_row['industry']),"｜",$u_row['value_chain'],"｜",$u_row['type_term'];?>',
                        hAxis: {title: 'Magnitude of Impact',minValue:0, maxValue:7,minorGridlines:{count:0},
                        ticks: [{v:1, f:'Unknown'}, {v:2, f:'Low'},{v:3, f:'Mid-Low'},{v:4, f:'Midium'},{v:5, f:'Mid-high'},{v:6, f:'High'},{v:7, f:''}],},
                        vAxis: {title: 'Likelihood',
                        ticks: [{v:1, f:'Unknown'},{v:2, f:'0-1%'}, {v:3, f:'0-10%'},{v:4, f:'0-33%'},{v:5, f:'33-66%'},
                        {v:6, f:'50-100%'},{v:7, f:'66-100%'},{v:8, f:'90-100%'},{v:9, f:'99-100%'},{v:10, f:''}] ,
                        minorGridlines:{count:0},minValue:0, maxValue:10,},
                        colorAxis: {minValue:1,maxValue:5,colors: ['yellow', 'red']},
                        bubble: { textStyle:{fontName:'Meiryo UI', fontSize: 11,auraColor: 'none'},ignoreBounds:true,},
                        legend:{position:'none',alignment:'center'},
                        tooltip: {isHtml: true,ignoreBounds:false},
                        sizeSize:{maxValue:1},
                        fontName:'Meiryo UI',
                        };
                    
                        // Instantiate and draw the chart .
                        var chart = new google.visualization.BubbleChart(document.getElementById('Chart_<?= $toggle,'_',$c ; ?>'));
                        chart.draw(data, options);
                    }
                
            </script>   
    
            <!-- Table and divs that hold the bubble charts  -->
            <div id="<?=$toggle,'_',htmlspecialchars($u_row['year']),htmlspecialchars($u_row['ind_type']),
            htmlspecialchars($u_row['tr_ph']),htmlspecialchars($u_row['vc_type']),htmlspecialchars($u_row['type']);?>"></div>
            <div id="Chart_<?= $toggle,'_',$c ; ?>" style="height: 88%;margin-left:0;margin-right:0;"></div></td>
            <br>
            <div id="c2_exp" >
                <table >
            
                <?php if(!empty($chartData)):?>   

                    <?php foreach($chartData as $row): ?>
                        
                        <?php if ( in_array($u_row['vc_type'],array_column($chartData,'vc_type')) 
                            && vc_condition($u_row,$row)):?>            
                        
                            <tr class="header_2">
                                <td><?= $row['year'],' ',$row['company'];?></td>
                                <td><?=ucfirst($u_row['industry']);?></td>
                                <td width="70"><?= $row['identifier'];?></td>
                                <td width="230"><?= 'Value chain: ',$row['value_chain'];?></td>               
                                <td width="220"><?= 'Time horizon: ',$row['Time_horizon'];?></td>
                                <td style="font-size : 13px;" class="<?='font_',$row['max_vc'];?>">[インパクト: <?= $row['impact'],'] [',$row['Likelihood'],': ',$row['fig2_likelihood'];?>]</td>

                            </tr>

                            <?php if($row['year']==2020 && preg_match('/^Risk/',$row['identifier'])){$ro_driver=$row['driver_20'];} else{$ro_driver=$row['driver_19'];}?>
                            <tr>
                                <td colspan="2"><font color="#82246f"><b><?=$toggle;?> type:</b> </font><?=$row['type_term'];?></td>
                                <td colspan="4"><font color="#82246f"><b> Primary climate-related &nbsp<?=strtolower($toggle);?> driver:</b> </font><?=$ro_driver;?></td>
                            </tr>
                            <tr><td colspan="6" ><font color="#82246f"><b>Company Specific Description :</b><br></font> <?= $row['description'];?></td></tr>
                            <tr><td colspan="6" ><font color="#82246f"><b>Explanation of financial impact figure :</b><br></font> <?= $row['fc_impact'];?></td></tr>
                            <tr height="100"><td colspan="6" valign="top" >Memo:</td> </tr>

                        <?php elseif(!in_array($u_row['vc_type'],array_column($chartData,'vc_type'))):?>   
                            
                            <tr class="header_2">
                                <td ><?= $u_row['year'],' ',$u_row['value_chain'];?></td>
                                <td ><?=$toggle;?></td><td>Value chain:</td><td>Time horizon:</td>
                                <td >[インパクト: ][確率]</td>
                            </tr>
                            <tr><td colspan="6" align="center">No information</td></tr>
                            
                            <?php break;?>
                        <?php endif;?>

                    <?php endforeach;?>

                <?php elseif(empty($chartData)):?>   
                    
                    <tr class="header_2">
                        <td ><?= $u_row['year'],' ',$u_row['value_chain'];?></td>
                        <td ><?=$toggle;?></td><td>Value chain:</td><td>Time horizon:</td>
                        <td>[インパクト: ][確率]</td>
                    </tr>
                    <tr><td colspan="6" align="center">No information</td></tr>

                <?php endif;?>

                </table>
                <br>
                </div>
        <?php $c++; endforeach;?> 
    <?php endif;?>
<?php endfor;?>    
<p id="topbutton">
    <a href="#top" onclick="$('html,body').animate({ scrollTop: 0 }); return false;"> ▲ </a>
</p>

<div>
</body>
</html>