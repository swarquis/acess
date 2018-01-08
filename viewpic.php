<?php 
error_reporting(E_ALL^E_WARNING^E_NOTICE);
header('Content-Type:text/html;charset=utf-8');
$id = $_GET['id'];
$dbfile = 'E:/access/BlLib.mdb';
function get_field($field_name){
	return iconv('utf-8','gbk',$field_name);
}
try{

	$dbh = new PDO("odbc:Driver={Microsoft Access Driver (*.mdb)};Dbq=".$dbfile);
	
	    //echo $page;
	$sql1 = "SELECT * FROM ziliao where ".get_field('序列号')."=".$id; 
	//var_dump($sql1);
	$exe = $dbh->query($sql1);
	$record = $exe->fetch(PDO::FETCH_ASSOC);
	//var_dump($res1);
	//echo 123;
}catch(PDOException $e){
	print "Error!: " . $e->getMessage() . "<br/>";
}
//echo $id;
$path = "D:/JyCsData/data/";
if(!file_exists($path)){
	echo "存储路径不存在，即将创建创建...";
	if(mkdir($path,777,true)){
		echo "文件夹创建成功";
	}
}


$viewDir = $path.$id;
if(!file_exists($viewDir)){
	$warning = "<p class='text-danger text-center h3'>该病人图像文件夹不存在</p>";
	//echo "<meta http-equiv=refresh Content=1;url=index1.php />";
}else{
	$handler = opendir($viewDir);

	while(($image = readdir($handler)) !== false){
	if($image != '.' && $image != '..'){
		$info = pathinfo($image);
		if(is_numeric($info['filename'])){
			$arr[] = $image;
		}
		
	}
}
}


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
		<link rel="stylesheet" href="./viewer/css/viewer.min.css">
		<style>
		* { margin: 0; padding: 0;}
		#dowebok { width: 700px; margin: 0 auto; font-size: 0;}
		#dowebok li { display: inline-block; width: 32%; margin-left: 1%; padding-top: 1%;}
		#dowebok li img { width: 100%;}
		.viewer-title{color:black;font-weight:bold;}
		hr{color:black;size:2px;}
		td{border:1px solid black}
		.container{margin-top:10px;}
</style>
 </head>
 <body>
 	<div class="container" style="width:860px">
 		<div class="h1 text-center " style="border:1px solid black;margin:0px"><p style="margin:10px"><?php echo iconv('gbk','utf-8',$record[get_field('姓名')]).'的B超记录' ?></p></div>
 		<table class="table table-hover text-center" style="margin:0px">
			<tr class="text-info" style="background-color:#abcdef;font-weight:bold">
				<td>序列号</td>
				<td>姓名</td>
				<td>性别</td>
				<td>年龄</td>
				<td>住院号</td>
				<td>床号</td>
				
				
				<td>图片数</td>
			</tr>
		
			
				<tr>
					<td><?php echo iconv('gbk','utf-8',$record[get_field('序列号')]) ?></td>
					<td><?php echo iconv('gbk','utf-8',$record[get_field('姓名')]) ?></td>
					<td><?php echo iconv('gbk','utf-8',$record[get_field('性别')]) ?></td>
					<td><?php echo iconv('gbk','utf-8',$record[get_field('年龄')]) ?></td>
					<td><?php echo iconv('gbk','utf-8',$record[get_field('住院号')]) ?></td>
					<td><?php echo iconv('gbk','utf-8',$record[get_field('床号')]) ?></td>
				<!-- 	<td><a href="viewpic/php"><?php //echo iconv('gbk','utf-8//IGNORE',$record[get_field('超声所见')]) ?></a></td> -->
					
					<td><?php echo iconv('gbk','utf-8',$record[get_field('图片数')]) ?></td>
					
				</tr>
				
			
		</table>
		<table class="table table-hover text-left" style="margin:0px">
			<tr>
				<td class="text-info" style="background-color:#abcdef;font-weight:bold">超声所见</td>
			</tr>
				<tr>
					<td><?php echo iconv('gbk','utf-8//IGNORE',$record[get_field('超声所见')]) ?></td>
				</tr>
		</table>
		<table class="table  table-hover text-left">
			<tr>
				<td class="text-info" style="background-color:#abcdef;font-weight:bold">诊断结果</td>
			</tr>
				<tr>
					<td><?php echo iconv('gbk','utf-8',$record[get_field('诊断结果')]) ?></td>
				</tr>
		</table>
		<p class="text-center text-info h4">点击图片放大</p>
		<?php echo $warning; ?>
		
			<div class="container">
			<ul id="dowebok">
				<?php foreach($arr as $img): ?>

				<li style=""><img style="color:black" data-original="http://localhost/pic/<?php echo $id ?>/<?php echo $img ?>" src="http://localhost/pic/<?php echo $id ?>/<?php echo $img ?>" alt="图片<?php echo $img ?>"></li>
				
				<?php endforeach; ?>
			</ul>
		</div>
 	</div>
 </body>
 <script src="./viewer/js/viewer.min.js"></script>
<script>
var viewer = new Viewer(document.getElementById('dowebok'), {
	url: 'data-original'
});
</script>
 </html>