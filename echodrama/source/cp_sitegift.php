<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: cp_task.php 12804 2009-07-21 03:27:31Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}
if(empty($_POST[sitegifttime])){
	showmessage("site_had_got_gift");//您已经领取过此次红包了	
}

$credit = 0;
$query = $_SGLOBAL['db']->query('SELECT * FROM '.tname('usergift')." WHERE uid='$_SGLOBAL[supe_uid]'");
$usergift = $_SGLOBAL['db']->fetch_array($query);

if(empty($usergift)) {
	$usergift = array();
	$usergift['uid']=$_SGLOBAL['supe_uid'];
	$usergift['username']=$_SGLOBAL['supe_username'];
	$usergift['credit']=20;
	$usergift['dateline']=$_SGLOBAL['timestamp'];
	$usergift['lastpost']=$_SGLOBAL['timestamp'];
	
	inserttable("usergift", $usergift);
}
else{	
	//判断是否操作太快
	$lastpost = $usergift['lastpost'];
	$currentpost = $_SGLOBAL['timestamp'];
	if( ($currentpost - $lastpost) > 10){
		$credit = 20;
		$_SGLOBAL['db']->query("UPDATE ".tname('usergift')." SET credit=credit+$credit, lastpost = '$currentpost' WHERE uid='$_SGLOBAL[supe_uid]'");
	}
	else{
		showmessage("site_had_got_gift");//您已经领取过此次红包了	
	}
}

if(!empty($credit)){
	$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit+$credit WHERE uid='$_SGLOBAL[supe_uid]'");
}
showmessage("site_got_gift");	