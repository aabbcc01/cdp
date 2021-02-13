<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script src="https://code.jquery.com/jquery-1.12.4.min.js" type="text/javascript"></script>
	<script src="js/scrollbtn.js"></script> 
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
require('scrollbtn.css');
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
		
		$comps["${i}"][]=array('year'=>$row['year'],'company'=>$row['company'],'company_id'=>$row['company_id']);
		$c++;
		if($c%3===0){$i++;}

	} 
	?>
	<!-- <?php print_r($comps);?> -->
    <table id="u_comps" > 
			<thead><tr><th colspan="3">該当企業：（<?= count($u_compid) ?> 件)</th></tr>
		   </thead>
		  
		  <!--  <tr> <td><?php print_r($comps) ?></td></tr> -->
		   <?php foreach($comps as $arr_1): ?>
				
				<tr>
				<?php foreach($arr_1 as $arr_2):?>

						<td>
						<?php if(isset($arr_2['company_id'])):?>
							<a href="#<?= htmlspecialchars($arr_2['company_id']); ?>">						
							<font color="black"><?= htmlspecialchars($arr_2['year']),' ',
							'<i>',htmlspecialchars($arr_2['company']),'</i>'; ?></font><a>
						<?php endif;?>
						</td>

				<?php endforeach;?>
				
			   </tr>

			<?php endforeach; ?>

    </table>
    
	<p class="alert alert-success"><?= count($CdpData) ?>件見つかりました。</p>

	<?php

		class Table {
			function border(int $border){
				if(intval($border)===1){
					return " border";
				}
			}
			function colspan(int $colnum,int $n){
				if($colnum ===$n){
					$result=7-$colnum;
					return $result;
				}
			}
			function setUnderb(int $header,string $answer){
				if(preg_match('/^C[0-9]/',$answer) ||
				preg_match('/^C-C/',$answer) AND $header===1){
					return " set-underb";
				}
			}
		}

		function make_td(int $header,int $border,int $colnum,string $answer,int $n){
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
			<thead id="<?=htmlspecialchars($u_row['company_id']); ?>">

				<tr>
					<th colspan="6">CDP Response</th>
				</tr>

				<tr>
							
					<th>Year: <?= htmlspecialchars($u_row['year']) ?></th>
					<th colspan="5">Company: <?= htmlspecialchars($u_row['company']) ?></th>
							
				</tr>
			</thead>

			<?php foreach($CdpData as $row): ?>
				
				<?php if (intval($u_row['company_id'])===intval($row['company_id'])):?>

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

<p id="topbutton">
    <a href="#top" onclick="$('html,body').animate({ scrollTop: 0 }); return false;"> ▲ </a>
</p>

</body>
</html>