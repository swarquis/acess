<?php 
$dbfile = 'E:/access/BlLib.mdb';
$dbh = new PDO("odbc:Driver={Microsoft Access Driver (*.mdb)};Dbq=".$dbfile);

 $sql = 'SELECT * from ziliao '.$where.' LIMIT '.$offset.','.$pageSize.'';
/*    foreach($dbh->query($sql) as $row){
    	echo $row[get_field('序列号')].'<br/>';
    	echo $row[get_field('姓名')].'<br/>';
    	
    }*/
    $re = $dbh->query($sql);
    var_dump($re);
    "SELECT * FROM (
SELECT TOP [$pageSize] * FROM (
    SELECT TOP [$pageSize * ($page + 1)] * FROM ziliao ".$where."
)
)"

<ul>
				<?php foreach($arr as $img): ?>
					<div class="h3"><?php echo $img ?></div>
					<li class="li"><img src="http://localhost/pic/<?php echo $id ?>/<?php echo $img ?>" alt=""></li>
					<hr style="size:10">
				<?php endforeach; ?>
			</ul>

 ?>