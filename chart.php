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
    require_once('./Class/UniqueArray.php');
    //require('css/style.css');
    require('css/c2_table.css');
    require('css/scrollbtn.css');

    /* $CdpData = getCDP($_GET); */
    $CdpData = getChartData($_GET,'v_fig_chart');

    //重複を除いた企業名の表示
    $unique_array= new UniqueArray;
    $unique_array->forComp=$CdpData;
    $u_compid=$unique_array->unique();

 ?>
 <!--重複なしで該当企業を表示-->
 <?php $c=1; $i=1; $u_comps=[];
	
	foreach($u_compid as $row){
		
		$u_comps["${i}"][]=array('year'=>$row['year'],'company'=>$row['company'],'company_id'=>$row['company_id']);
		$c++;
		if($c%3===0){$i++;}

	} 
   
	?>
<div class="back-ground">
	<!-- <?php print_r($u_comps);?> -->
    <table id="u_comps" > 
			<thead><tr><th colspan="3">該当企業：（<?= count($u_compid) ?> 件)</th></tr>
		   </thead>
		  
		  <!--  <tr> <td><?php print_r($u_comps) ?></td></tr> -->
		   <?php foreach($u_comps as $arr_1): ?>
				
				<tr>
				<?php foreach($arr_1 as $arr_2):?>

						<td>
						    <?= htmlspecialchars($arr_2['year']),' ',htmlspecialchars($arr_2['company']),'：'; ?>
							<a href="#<?= 'Risk_',htmlspecialchars($arr_2['year']),htmlspecialchars($arr_2['company_id']); ?>">						
							<font color="black"></font>Risk &nbsp;</a>
                            <a href="#<?= 'Opp_',htmlspecialchars($arr_2['year']),htmlspecialchars($arr_2['company_id']); ?>">						
							<font color="black"></font>Opp</a>
						</td>
						
				<?php endforeach;?>
				
			   </tr>

			<?php endforeach; ?>

    </table>
    
	<p class="alert alert-success">該当件数(No information 除く): <?= count($CdpData),' 件'; ?></p>
    
<?php for($i=0; $i<2; $i++):  $toggle= $i==0 ?'Risk':'Opp'; $title= $i==0 ? 'C2.3a Risk':'C2.4a Opp';?>
    <?php $table=$i==0 ?'v_fig_chart_r ':'v_fig_chart_o'; $chartData = getChartData($_GET,$table);  ?>
<!-- <?php if($i==1){ if(empty($chartData)){print_r($chartData);};}?>  -->

    <?php $c=0; foreach($u_compid as $u_row):?>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                <script type="text/javascript">
                // Load Charts and the corechart package.
                google.charts.load('current', {'packages':['corechart']});
                // Draw the bubble chart when Charts is loaded.
                google.charts.setOnLoadCallback(Chart_<?= $toggle,'_',$c ; ?>);
                function Chart_<?= $toggle,'_',$c ; ?>() {

                    // Create the data table .
                    var data = new google.visualization.arrayToDataTable([
                   
                    ['Identifier','Magnitude of Impact', 'Likelihood', 'Time horizons',''],
                    <?php if(!empty($chartData)):?> //note: if $chartData is empty, "foreach" doesn't loop it. 
                        
                        <?php foreach($chartData as $row): ?>
                            
                            <?php if (intval($u_row['company_id'])===intval($row['company_id'])
                            && $u_row['year']===$row['year']): ?>
                        
                                ["<?=$row['identifier'],' ',$row['value_chain'];?>",<?=$row['fig_impact'];?> ,
                                <?=$row['fig_likelihood'];?>,<?=$row['fig_TMHZ'];?>,<?=$row['fig_impact'];?>],
                              
                            <?php elseif(!in_array($u_row['company_id'],array_column($chartData,'company_id'))):?> 
                               
                                ['No information',0,0,0,0],
                                <?php break;?>
                            <?php endif; ?>  

                        <?php endforeach;?>
                    
                    <?php elseif(empty($chartData)): ?>
                        
                        ['No information',0,0,0,0],
                     
                    <?php endif;?>
                    
                ]);

                var options = {
                    title: ' <?= $u_row['year']," ｜ CDP回答分析 ",$title,"｜",$u_row['company'];?>',
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
        <div id="<?=$toggle,'_',htmlspecialchars($u_row['year']),htmlspecialchars($u_row['company_id']);?>"></div>
        <div id="Chart_<?= $toggle,'_',$c ; ?>" style="width: 1200px; height: 500px;"></div></td>
        <br>
        <div id="c2_exp" >
            <table >
           
             <?php if(!empty($chartData)):?>   

                <?php foreach($chartData as $row): ?>
                    
                    <?php if ( in_array($u_row['company_id'],array_column($chartData,'company_id')) 
                        && intval($u_row['company_id'])===intval($row['company_id'])
                        && $u_row['year']===$row['year'] ):?>            
                    
                        <tr class="header_2">
                            <td><?= $row['year'],' ',$row['company'];?></td>
                            <td width="70"><?= $row['identifier'];?></td>
                            <td width="230"><?= 'Value chain: ',$row['value_chain'];?></td>               

                            <td width="220"><?= 'Time horizon: ',$row['Time_horizon'];?></td>
                            <td style="font-size : 13px;">[インパクト: <?= $row['impact'],'] [',$row['Likelihood'],': ',$row['fig2_likelihood'];?>]</td>

                        </tr>

                        <?php if($row['year']==2020 && preg_match('/^Risk/',$row['identifier'])){$ro_driver=$row['driver_20'];} else{$ro_driver=$row['driver_19'];}?>
                        <tr>
                            <td colspan="1"><font color="#82246f"><b><?=$toggle;?> type:</b> </font><?=$row['type'];?></td>
                            <td colspan="4"><font color="#82246f"><b> Primary climate-related &nbsp<?=strtolower($toggle);?> driver:</b> </font><?=$ro_driver;?></td>
                        </tr>
                    
                        <tr><td colspan="5" ><font color="#82246f"><b>Company Specific Description :</b><br></font> <?= $row['description'];?></td></tr>
                        <tr><td colspan="5" ><font color="#82246f"><b>Explanation of financial impact figure :</b><br></font> <?= $row['fc_impact'];?></td></tr>
                        <tr height="100"><td colspan="5" valign="top" >Memo:</td> </tr>

                   
                     <?php elseif(!in_array($u_row['company_id'],array_column($chartData,'company_id'))):?>   
                        
                        <tr class="header_2">
                            <td ><?= $u_row['year'],' ',$u_row['company'];?></td>
                            <td ><?=$toggle;?></td><td>Value chain:</td><td>Time horizon:</td>
                            <td>[インパクト: ][確率]</td>
                        </tr>
                        <tr><td colspan="5" align="center">No information</td></tr>
                         
                        <?php break;?>
                     <?php endif;?>

                <?php endforeach;?>

            <?php elseif(empty($chartData)):?>   
                
                <tr class="header_2">
                    <td ><?= $u_row['year'],' ',$u_row['company'];?></td>
                    <td ><?=$toggle;?></td><td>Value chain:</td><td>Time horizon:</td>
                    <td>[インパクト: ][確率]</td>
                </tr>
                <tr><td colspan="5" align="center">No information</td></tr>

            <?php endif;?>

            </table>
            <br>
            </div>
    <?php $c++; endforeach;?> 

<?php endfor;?>    

<p id="topbutton">
    <a href="#top" onclick="$('html,body').animate({ scrollTop: 0 }); return false;"> ▲ </a>
</p>

<div>
</body>
</html>