<?php

/* if($_SERVER["REQUEST_METHOD"] != "POST"){
	// ブラウザからHTMLページを要求された場合
	$no_login_url = "index.php";

		echo 'Oops! invalid access is detected!  ';
	    //header("Location: {$no_login_url}");
	    exit;
} */

//データ取得ロジックを呼び出す
require_once('./Model/CdpAnswer.php');
require_once('./Class/UniqueArray.php');
require('style.css');
//重複を除いた企業名の表示
$comp_db = getCDP($_GET);
$unique_array= new UniqueArray;
$unique_array->forComp=$comp_db;
$unique_name=$unique_array->unique();

$CdpData = getCDP($_GET); //answersの取得

		
if(isset($_GET['charts'])){
	require_once('./Model/ChartData.php');
	$chartData = getChartData($CdpData);
} 

 //③取得データを表示する 
   if(isset($CdpData) && count($CdpData)): ?>
		<table class="columns" >
			<thead><tr><th colspan="2">検索条件 </th></tr>
   		</thead>
			<tr>
				<td>Industry</td>
				<td><?php echo ($_GET['industry']) ?></td>
			</tr>
			<tr>
				<td>Value Chain</td>
				<td><?php echo ($_GET['value_chain']) ?></td>
			</tr>
			<tr>
				<td>Impact</td>
				<td><?php echo ($_GET['impact']) ?></td>
			</tr>
		</table>
		<p>
		<!--重複なしで該当企業を表示-->
		<table class="columns"> 
			<thead><tr><th>該当企業：（<?php echo count($unique_name) ?> 件)</th></tr>
   		</thead>
			<?php foreach($unique_name as $row): ?>
					<tr>
						<td><?php echo htmlspecialchars($row['company']) ?></td>
					</tr>
			<?php endforeach; ?>

		</table>

		<p class="alert alert-success"><?php echo count($CdpData) ?>件見つかりました。</p>
        
        <!--外側のloop-->
		<?php $counter=0;?>	
		<?php foreach($unique_name as $u_row ): ?>	
		<?php if (isset($_GET['charts'])):?>
		
			<!--Table and divs that hold the bubble charts-->
			<h2 class="menutitle">CDP回答内容分析 : C2.3a リスク: <?=$u_row['company'];?></h2>
        	<table class="columns">
				<tr>
				<td> <div id= <?="riskChart_".$counter;?> style="width: 1000px; height: 500px;"></div></td>
				</tr>
			</table>
				<?="name= "."riskChart_".$counter;?>
		<?php endif;?>
		<?php foreach($CdpData as $row): ?>	
			<?php if($u_row['company']===$row['company']):?>
			<table class="columns">
				 <thead>
					<tr >
						<th><?php echo htmlspecialchars($row['company']) ?></th>
						<th><?php echo htmlspecialchars($row['publish']) ?></th>
						<th><?php echo htmlspecialchars($row['Identifier']) ?></th>
						<th><?php echo htmlspecialchars($row['tr_or_ph']) ?></th>
						<th><?php echo "Value Chain: ".htmlspecialchars($row['value_chain']) ?></th>
						<th><?php echo "Impact: ". htmlspecialchars($row['Magnitude_of_impact']) ?></th>
						<th><?php echo "Likelihood: ".htmlspecialchars($row['Likelihood']) ?></th>
						<th><?php echo "Time Horizon: ".htmlspecialchars($row['time_horizon']) ?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
					<td colspan="8"><p class="title">Company specific description</p>
					<?php echo htmlspecialchars($row['Company_specific_description']) ?></td>
					</tr>
				   <tr>
					<td colspan="8"><p class="title">Description of response and explanation of cost calculation</p>
					<?php echo htmlspecialchars($row['Description_of_response_and_explanation_of_cost_calculation']) ?></td>
					</tr>
				</tbody>
			</table>
		<?php endif; ?>
			<p>
			
		<?php endforeach; ?>


</div>

	
	<?php $counter++; endforeach;?>

<?php else: ?>
	<p class="alert alert-danger">検索対象は見つかりませんでした。</p>
<?php endif; ?>

</body>
</html>