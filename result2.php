<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
<body>
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
$u_compid=$unique_array->unique();

$CdpData = getCDP($_GET); //answersの取得

		
if(isset($_GET['charts'])){
	require_once('./Model/ChartData.php');
	$chartData = getChartData($CdpData);
} 
?>

<div class="back-ground">

 <!-- ③取得データを表示する  -->
<?php if(isset($CdpData) && count($CdpData)): ?>

	<!--重複なしで該当企業を表示-->
	<?php $c=1; $i=1; $comps=[];
	foreach($u_compid as $row){
		
		$comps["${i}"][]=$row['company'];
		$c++;
		if($c%3===0){$i++;}

	} 

	?>
    <table id="u_comps" > 
			<thead><tr><th colspan="3">該当企業：（<?php echo count($u_compid) ?> 件)</th></tr>
		   </thead>
		   <tr>
		  <!--  <td><?php print_r($comps) ?></td></tr> -->
		   <?php foreach($comps as $row): ?>
					<tr class="results">
					
					<?php if(isset($row[0])):?><td><?= htmlspecialchars($row[0]) ?></td><?php endif;?>
					<?php if(isset($row[1])):?><td><?= htmlspecialchars($row[1]) ?></td><?php endif;?>
						
					<?php if(isset($row[2])):?><td><?= htmlspecialchars($row[2]) ?></td><?php endif;?>
							
					
					</tr>
			<?php endforeach; ?>

    </table>
    
	<p class="alert alert-success"><?php echo count($CdpData) ?>件見つかりました。</p>

	<?php

		class Table {
			function border($border){
				if(intval($border)===1){
					return " border";
				}
			}
			function colspan($colnum,$n){
				if($colnum ===$n){
					$result=7-$colnum;
					return $result;
				}
			}
			function setUnderb($header,$answer){
				if(preg_match('/^C[0-9]/',$answer) ||
				preg_match('/^C-C/',$answer) AND $header===1){
					return " set-underb";
				}
			}
		}

		function make_td($header,$border,$colnum,$answer,$n){
			$table=new Table(); 
			$h_answer=htmlspecialchars($answer); 
			
			$html=<<<EOL
			<td class="header_{$header} {$table->border($border)} {$table->setUnderb($header,$answer)}" 
			colspan="{$table->colspan($colnum,$n)}">
														
			<span class="header_{$header}">
			{$h_answer}
			</span>
			</td>

			EOL;
			return $html;
		}
	?>

	<table id="results">
		
		<?php foreach($u_compid as $u_row): ?>
			<thead>

				<tr>
					<th colspan="6">CDP Response</th>
				</tr>

				<tr>
							
					<th>Year: <?php echo htmlspecialchars($u_row['year']) ?></th>
					<th colspan="5">Company: <?php echo htmlspecialchars($u_row['company']) ?></th>
							
				</tr>
			</thead>

			<?php foreach($CdpData as $row): ?>
				
				<?php if (intval($row['company_id'])===intval($u_row['company_id'])):?>

					<tr class="results">

						<?php for($i=0;$i<intval($row['colnum']);$i++) {
								$n=$i+1;
								$td= make_td(intval($row['header']),intval($row['border']),intval($row['colnum']),$row["answer_${n}"],$n); 
								echo $td;
								}
						?>

					</tr>	
					
				<?php endif; ?>

			<?php endforeach; ?>

		<?php endforeach; ?>

	</table>

<?php else: ?>
	<p class="alert alert-danger">検索対象は見つかりませんでした。</p>
<?php endif; ?>

</div>
</body>
</html>