<?php
header('Content-Type:text/html;charset=utf-8');
$mdb = "D:/filepath.mdb";
set_time_limit(0);
try{  
    $db = new PDO("odbc:Driver={Microsoft Access Driver (*.mdb)};Dbq=D:\\crydj.mdb;");  
    //echo "Connected\n";  
} catch (Exception $e) {  
    echo "Failed:".$e->getMessage();  
}  
$days = array();
for($i=1; $i <= 12; $i++){
	$day = cal_days_in_month(CAL_GREGORIAN, $i, 2017);
	$days[$i] = range(1, $day);
}
//var_dump($days);//2-d  m-d
for($month=1; $month<=12; $month++){
	for($day=1; $day<=count($days[$month]); $day++){
		$sql = "select count(*) from crydj where datepart('yyyy',rysj) = 2017 and datepart('m',rysj) = ".$month." and datepart('d',rysj) = ".$day."";
		//echo $sql;die;
		$rs = $db->query($sql);
		
		//$rs = $db->query("select count(*) from crydj");
		/*print "<pre>";     
		print_r($rs->fetchall()[0]);     
		print "</pre>"; */
		//print_r($rs->fetchall()[0]); 
		$result[$month][$day] = $rs->fetchall()[0][0];

	}
}

for($month=1; $month<=12; $month++){
	for($day=1; $day<=count($days[$month]); $day++){
		$sql2 = "select count(*) from crydj where datepart('yyyy',cysj) = 2017 and datepart('m',cysj) = ".$month." and datepart('d',cysj) = ".$day."";
		//echo $sql;die;
		$rs2 = $db->query($sql2);
		
		//$rs = $db->query("select count(*) from crydj");
		/*print "<pre>";     
		print_r($rs->fetchall()[0]);     
		print "</pre>"; */
		//print_r($rs->fetchall()[0]); 
		$result2[$month][$day] = $rs2->fetchall()[0][0];

	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
</head>
<body style="">
	<?php for($month=1; $month<=12; $month++): ?>
	<table cellpadding="0" cellspacing="0" border=1 bgcolor="#7FC9FF" width=40% style="text-align:center;margin:auto;font-weight:bold">
		<h4 style="text-align:center"><?php echo "2017年".$month."月记录" ?></h4>
		<tr style="background-color:#abcdef">
			<td>入院人数</td>
			<td>时间</td>
			<td>出院人数</td>
		</tr>
		
			<?php for($day=1; $day<=count($days[$month]); $day++): ?>
		<tr>
			<td><?php echo $result[$month][$day] ?></td>
			<td><?php echo $month."月-".$day."日" ?></td>
			<td><?php echo $result2[$month][$day] ?></td>
		</tr>
			<?php endfor; ?>
	</table>
	<hr>
	<?php endfor; ?>
	
</body>
</html>