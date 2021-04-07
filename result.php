<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://code.jquery.com/jquery-1.12.4.min.js" type="text/javascript"></script>
	<script src="js/scrollbtn.js"></script> 
	</head>
<body>
<?php


//データ取得ロジックを呼び出す
require_once('./Model/CdpAnswer.php');
require_once('./Function/comp_uniqueArray.php');
require('css/style.css');
require('css/scrollbtn.css');

$CdpData = getCDP($_GET);


?> 

<div class="back-ground">

 	
	<?php if(isset($CdpData) && count($CdpData)): ?>
	<!-- 重複を除いた企業名に紐づくデータの取得 -->
	<?php $u_compid=comp_uniqueArray($CdpData);?>
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
						
							<a href="#<?= htmlspecialchars($arr_2['year']),htmlspecialchars($arr_2['company_id']); ?>">						
							<font color="black"><?= htmlspecialchars($arr_2['year']),' ',
							'<i>',htmlspecialchars($arr_2['company']),'</i>'; ?></font><a>
					
						</td>
						
				<?php endforeach;?>
				
			   </tr>

			<?php endforeach; ?>

    </table>
    
	<p class="alert alert-success"><?= count($CdpData) ?>件見つかりました。</p>

	<?php
		
		function border(int $border){
			$result= intval($border)===1 ? " border" : "";
			return $result;
		}

		function colspan(int $colnum,int $n){

			$result= $colnum ===$n ? 7-$colnum : 0;
			return $result;
		}

		function setUnderb($header,string $answer){
			if(preg_match('/^C[0-9]/',$answer) ||
			preg_match('/^C-C/',$answer) AND $header===1){
				return " set-underb";
			}else { return "";}
		}
		
		function make_td(int $header,string $border,int $colspan,string $setUnderb,string $answer){
			
			$h_answer=htmlspecialchars($answer); 
			$ret='<td class="header_'.$header.$border.$setUnderb.'" colspan='.$colspan.'>';
			$ret=$ret.'<span class="header_'.$header.'">'.$h_answer.'</span></td>';
			return $ret;

		}
	?>

	<table id="results" target="a">

		<?php foreach($u_compid as $u_row): ?>
			<thead id="<?=htmlspecialchars($u_row['year']),htmlspecialchars($u_row['company_id']); ?>">

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

								$border= border(intval($row['border']));
								$n=$i+1;
								$colspan=colspan(intval($row['colnum']),$n);
								$setUnderb=setUnderb($row['header'],$row["answer_${n}"]);

								$td= make_td(intval($row['header']),$border,$colspan,$setUnderb,$row["answer_${n}"]); 
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