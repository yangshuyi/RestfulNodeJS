<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: network.php 13003 2009-08-05 06:46:06Z liguode $
*/

include_once('./common.php');

$_GET['op'] = empty($_GET['op']) ? "viewbestscore" : $_GET['op'];

$fileopen = fopen("d:/tt.txt","a+");
fwrite($fileopen,$_SERVER['HTTP_USER_AGENT']."\n");
fclose($fileopen);


if($_GET['op']=="viewbestscore"){

	$bestscore_sql="SELECT r.* FROM rollingcard_record r ORDER BY r.score desc, r.date ASC LIMIT 0,5";

	$bestscorelist = array();
	$query = $_SGLOBAL['db']->query($bestscore_sql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$bestscorelist[] = $value;
	}
	
	$outputstr = "";
	foreach($bestscorelist as $value){
		$outputstr.="$value[username]|$value[score]|$value[date];";
	}
}
else if($_GET['op']=="addnewscore"){

	$record=array();
	$record['username']=$_GET['username'];
	$record['score']=$_GET['score'];
	$record['date']=sgmdate('Y-m-d', $_SGLOBAL['timestamp']);
	
	$_SGLOBAL['db']->query("INSERT INTO rollingcard_record (username, score, date) VALUES('$record[username]', $record[score], '$record[date]')");
}
?>
<?php
if($_GET['op']=="viewbestscore"){
?>
<?=$outputstr?>
<?php		
}
?>


