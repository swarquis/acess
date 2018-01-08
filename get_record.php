<?php 
//header('Content-Type:text/html;charset=utf-8');
//error_reporting(E_ALL^E_WARNING^E_NOTICE);
$dbfile = 'E:/access/BlLib.mdb';

$Uid = '';
$pageSize = 25;

function get_field($field_name){
	return iconv('utf-8','gbk',$field_name);
}

/*function show($page,$where=''){
	try {

		$offset = ($page-1)*$pageSize;

	    $dbh = new PDO("odbc:Driver={Microsoft Access Driver (*.mdb)};Dbq=E:/access/BlLib.mdb;");
;

	    $sql = 'SELECT * from ziliao '.$where.' LIMIT '.$offset.','.$pageSize.'';
    foreach($dbh->query($sql) as $row){
    	echo $row[get_field('序列号')].'<br/>';
    	echo $row[get_field('姓名')].'<br/>';
    	
    }
    $re = $dbh->query($sql);
    return $re;
    //$dbh = null;
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    
}*/
}


//分页
function page($page){
	try {
		
	    $dbh = new PDO("odbc:Driver={Microsoft Access Driver (*.mdb)};Dbq=".$dbfile);
	    $sql = 'SELECT COUNT(*) from ziliao '.$where.' LIMIT '.$offset.','.$pageSize.'';
/*    foreach($dbh->query($sql) as $row){
    	echo $row[get_field('序列号')].'<br/>';
    	echo $row[get_field('姓名')].'<br/>';
    	
    }*/
	    $total = $dbh->query($sql);
	    $totalRecord = $total[0];
    //$dbh = null;
	} catch (PDOException $e) {
	    print "Error!: " . $e->getMessage() . "<br/>";
	    
	}
	$totalPage = ceil($tatalRecord/$pageSize);
	$start = $page - 4;
	$end = $page + 5;
	if($start < 1){
		$start = 1;
	}
	if($end > $totalPage){
		$end = $totalPage;
	}

	$res = "当前第{$page}页/共{$totalPage}页";
	for($i=$start; $i <= $end; $i++){
		if($i == 1){
			$res .= '<a href="index1.php?page=1">第一页</a>';
		}
		$res .= '<a href="index1.php?page={$i}" >第{$i}页</a>';	
		if($i == $totalPage){
			$res .= '<a href="index1.php?page={$totalPage}" >最后一页</a>';
		}
	}
	return $res;

}


 ?>