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
    <table id="u_comps" > 
			<thead><tr><th>該当企業：（<?php echo count($u_compid) ?> 件)</th></tr>
   		</thead>
			<?php foreach($u_compid as $row): ?>
					<tr class="results">
						<td><?= htmlspecialchars($row['company']) ?></td>
					</tr>
			<?php endforeach; ?>

    </table>
    
	<p class="alert alert-success"><?php echo count($CdpData) ?>件見つかりました。</p>

	<table id="results">
	
	<?php foreach($u_compid as $u_row): ?>
		<thead>
		<tr>
			<th colspan="6">CDP Response</th>
		</tr>
		<tr >
					
					<th>Year: <?php echo htmlspecialchars($u_row['year']) ?></th>
					<th colspan="5">Company: <?php echo htmlspecialchars($u_row['company']) ?></th>
					
		</tr>
		</thead>
		<?php foreach($CdpData as $row): ?>
			
			<?php if (intval($row['company_id'])==intval($u_row['company_id'])):?>

				<?php if(intval($row['header'])==1):?>
				<tr class="results">
					<td	colspan="6" class="<?php if(preg_match('/^C[0-9]/',$row['answer_1']) ||
					preg_match('/^C-C/',$row['answer_1']) ):
						?> set-underb<?php endif; ?>">
					<span class="<?= header_.$row['header']?>">
							<?php echo htmlspecialchars($row['answer_1']) ?>
					</span>
					</td>
				</tr>
				<?php endif;?>

				<?php if(intval($row['header'])!==1):?>

					<tr class="results">
					
						<td class="<?= header_.$row['header']?> <?php if(intval($row['border'])==1):?>border<?php endif;?>"
							colspan="<?php if($row['answer_2']=="" && $row['answer_3']==""
							&& $row['answer_4']=="" && $row['answer_5']=="" && $row['answer_6']==""):?>6<?php endif;?>"
						>

							<span class="<?= header_.$row['header']?>">
								<?php echo htmlspecialchars($row['answer_1']) ?>
							</span>
						</td>
		
						<?php $chap_id=intval($row['chapter_id']); ?>

								<?php if($row['answer_2']!=="" || ($row['answer_3']!=="")) :?>
									<td class="<?= header_.$row['header']?> <?php if(intval($row['border'])==1
									AND $row['answer_2']!=="" || ($row['answer_3']!=="")):?>border<?php endif;?>"
									
									colspan="<?php if($row['answer_3']=="" && $row['answer_4']==""
									&& $row['answer_5']=="" && $row['answer_6']=="" 
									AND $chap_id<10):?>5<?php endif;?>">
											
											<span class="<?= header_.$row['header']?>">
												<?= htmlspecialchars($row['answer_2']) ?>
											</span>
									</td>
								<?php endif;?>
								
									<?php if($row['answer_3']!=="" ):?>
										<td class="<?= header_.$row['header']?> <?php if(intval($row['border'])==1
										&& $row['answer_3']!==""):?>border<?php endif;?>"
										
										colspan="<?php if($row['answer_4']=="" && $row['answer_5']==""
										&& $row['answer_6']=="" AND $chap_id<10):?>4<?php endif;?>">

											<span class="<?= header_.$row['header']?>">
												<?= htmlspecialchars($row['answer_3']) ?>
											</span>
										</td>
									<?php endif;?>

									<?php if($row['answer_4']!=="" ):?>
										<td class="<?= header_.$row['header']?> <?php if(intval($row['border'])==1
										&& $row['answer_4']!==""):?>border<?php endif;?>"
										
										colspan="<?php if($row['answer_5']=="" && $row['answer_6']==""
										AND $chap_id<10):?>3<?php endif;?>" >
												
												<span class="<?= header_.$row['header']?>">
													<?= htmlspecialchars($row['answer_4']) ?>
												</span>
										</td>
									<?php endif;?>
									

									<?php if($row['answer_5']!=="" ):?>
										<td class="<?= header_.$row['header']?> <?php if(intval($row['border'])==1
										&& $row['answer_5']!==""):?>border<?php endif;?>">

												<span class="<?= header_.$row['header']?>">
													<?php echo htmlspecialchars($row['answer_5']) ?>
												</span>
										</td>
									<?php endif; ?>
							

									<?php if($row['answer_6']!==""):?>
										<td class="<?= header_.$row['header']?> <?php if(intval($row['border'])==1
										&& $row['answer_6']!==""):?>border<?php endif;?>">

												<span class="<?= header_.$row['header']?>">
													<?php echo htmlspecialchars($row['answer_6']) ?>
												</span>
										</td>
									<?php endif;?>
					</tr>	
				<?php endif; ?>	
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