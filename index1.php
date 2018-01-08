<?php 
//include './get_record.php';
error_reporting(E_ALL^E_WARNING^E_NOTICE);
header('Content-Type:text/html;charset=utf-8');
session_start();
$dbfile = 'E:/access/BlLib.mdb';
$pageSize = 25;

function get_field($field_name){
	return iconv('utf-8','gbk',$field_name);
}
$nameField = get_field('姓名');
if($_POST){
	$keyword = $_POST['keywords']?$_POST['keywords']:'';
	$page = $_REQUEST['page']?$_REQUEST['page']:1;
	
	//$keyword = $_SESSION['keywords']?$_SESSION['keywords']:'';
	$keyword = get_field(trim($keyword));
	$_SESSION['keyword'] = $keyword;
	//var_dump($keyword);
	//$nameField = get_field('姓名');
	if($_SESSION['keyword']){
		$where = "WHERE ".$nameField." Like "."'%".$_SESSION['keyword']."%'";

		//var_dump($where);
	}
	
	
}else{
	//echo $_SESSION['keyword'];
	//$_SESSION['keyword'] = get_field(trim($_SESSION['keyword']));
	$page = $_GET['page']?$_GET['page']:1;
	if($_SESSION['keyword']){
		$where = "WHERE ".$nameField." Like "."'%".$_SESSION['keyword']."%'";

		//var_dump($where);
	}
}
	try {

		//$offset = ($page-1)*$pageSize;

	    $dbh = new PDO("odbc:Driver={Microsoft Access Driver (*.mdb)};Dbq=".$dbfile);
	    //echo $page;
	    $sql1 = "SELECT * FROM (
	    	SELECT TOP ".$pageSize." * FROM (
    		SELECT TOP ".$pageSize*($page)." * FROM ziliao ".$where." ORDER BY ".get_field('序列号')." ASC
			)
			ORDER BY ".get_field('序列号')." DESC
			)
			ORDER BY ".get_field('序列号')." ASC";
	    //echo $sql1;
	    $sql2 = 'SELECT COUNT(*) as totalrecord from ziliao '.$where;
	    $total = $dbh->query($sql2);
		if(!$total){
	    	echo "<p class='text-danger'>未找到结果</p>";

	    	echo "<meta http-equiv=refresh content=1;url=index1.php />";
	    	die;
	    }
	    $res1 = $total->fetch(PDO::FETCH_ASSOC); 

	    $totalRecord = $res1['totalrecord']; 
	    //print_r($res['totalrecord']);
	    //$totalRecord = $total[0];
/*    foreach($dbh->query($sql) as $row){
    	echo $row[get_field('序列号')].'<br/>';
    	echo $row[get_field('姓名')].'<br/>';
    	
    }*/
    $re = $dbh->query($sql1);
    if(!$re){
    	echo "<p class='text-danger'>未找到结果</p>";
    	echo "<meta http-equiv=refresh content=1;url=index1.php />";
    	die;
    }
    //var_dump($re);
    //$dbh = null;
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    
}

	$totalPage = ceil($totalRecord/$pageSize);
	$start = $page - 4;
	$end = $page + 5;
	if($start <= 1){
		$start = 1;
		if($totalPage > 10){
			$end = $start + 9;
		}
		//$end = 10;
	}

	if($end >= $totalPage){
		$end = $totalPage;
		//$start = $end-10;
	}

	$res .= "当前第".$page."页/共".$totalPage."页";
		$res .= '<a href="index1.php?page=1">第1页</a>';
	for($i=$start; $i <= $end; $i++){
	if($i != 1 && $i != $totalPage){
		$res .= '<a href="index1.php?page='.$i.'" >第'.$i.'页</a>';		
	}	
		
	}
	$res .= '<a href="index1.php?page='.$totalPage.'" >尾页</a>';
	



 ?>
<!DOCTYPE html>
<html>
<head>
	
		<meta charset='utf-8' >
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
	    <title>B超查询</title>
	    <!-- Bootstrap -->
	    <link href="./static/css/bootstrap.min.css" rel="stylesheet">
	    <script src="./static/js/jquery-2.0.3.min.js"></script>
		<script src="./static/js/bootstrap.min.js"></script>
		<style>
			
			.container{padding-bottom:10px;}
			.page>a{margin-left:20px;}
			hr{color:black;size:2px;}
			td{border:1px solid black}
		</style>
</head>
<body>
	
	<div class="container" style="width:860px">
		<div class="h1 text-center" style="border:1px solid black;"><p style="margin:10px auto">B超信息查询</p></div>
		<div class="row" style="width:860px;margin:0px;position:absolute;top:80px;">
			<div class="text-info" style="border:1px solid black;margin-right:30px;height:30px"><span style="position:relative;top:5px">点击<span class="text-warning" >姓名</span>查看B超影像</span></div>
			<div class="row col-md-12 " style="width:860px;position:absolute;top:0px;right:30px">
				
				<form action="index1.php" method="post" class="text-right" >
						<input type="text" name="keywords" value="<?php echo iconv('gbk','utf-8',$_SESSION['keyword']) ?>" placeholder="输入病人姓名"/>
						<input type="submit" class="button btn-success" style="color:black" value="查询">
				</form>
			</div>
		</div>
	
		<!-- <table class="table table-bordered table-hover text-center" style="margin-top:10px;"> -->
		<table class="table table-hover" style="text-align:center;margin-top:30px">
			<tr class="text-info" style="background-color:#abcdef;font-weight:bold">
				<td>序列号</td>
				<td>姓名</td>
				<td>性别</td>
				<td>年龄</td>
				<td>住院号</td>
				<td>床号</td>
				<!-- <td>超声所见</td> -->
				<td>诊断结果</td>
				<td>图片数</td>
			</tr>
			<?php  foreach($re as $record): ?>
				<tr>
					<td><?php echo iconv('gbk','utf-8',$record[get_field('序列号')]) ?></td>
					<td><a href="viewpic.php?id=<?php echo iconv('gbk','utf-8',$record[get_field('序列号')]) ?>"><?php echo iconv('gbk','utf-8',$record[get_field('姓名')]) ?></a></td>
					<td><?php echo iconv('gbk','utf-8',$record[get_field('性别')]) ?></td>
					<td><?php echo iconv('gbk','utf-8',$record[get_field('年龄')]) ?></td>
					<td style=""><?php echo iconv('gbk','utf-8',$record[get_field('住院号')]) ?></td>
					<td><?php echo iconv('gbk','utf-8',$record[get_field('床号')]) ?></td>
				<!-- 	<td><a href="viewpic/php"><?php //echo iconv('gbk','utf-8//IGNORE',$record[get_field('超声所见')]) ?></a></td> -->
					<td class="col-md-6"><?php echo iconv('gbk','utf-8',$record[get_field('诊断结果')]) ?></td>
					<td><?php echo iconv('gbk','utf-8',$record[get_field('图片数')]) ?></td>
					
				</tr>
			<?php $i++; endforeach; ?>
		</table>
		<div class="page row col-md-12 text-center">
			<?php echo $res; ?>
			<form action="" method="post">
				<input type="text" name="page" placeholder="跳转到多少页"/>
				<input type="submit" class="button btn-success" style="color:black" value="跳转到">
			</form>
		</div>
	</div>
	
</body>
</html>
