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

	<table class="columns">
		<thead><tr><th>Year</th><th>Company</th><th>Chapter</th>
		<th>question</th><th>question_id</th><th>CDP Response</th></tr></thead>
        <?php foreach($CdpData as $row): ?>
				<tr>
					<td><?php echo htmlspecialchars($row['year']) ?></td>
                    <td><?php echo htmlspecialchars($row['company']) ?></td>
					<td><?php echo htmlspecialchars($row['chapter_id']) ?></td>
					<td><?php echo htmlspecialchars($row['question']) ?></td>
					<td><?php echo htmlspecialchars($row['question_id']) ?></td>
                    <td><?php echo htmlspecialchars($row['answer_1']) ?></td>
					<td><?php echo htmlspecialchars($row['answer_2']) ?></td>
					<td><?php echo htmlspecialchars($row['answer_3']) ?></td>
				</tr>
		<?php endforeach; ?>

    </table>

<?php else: ?>
	<p class="alert alert-danger">検索対象は見つかりませんでした。</p>
<?php endif; ?>

</body>
</html>