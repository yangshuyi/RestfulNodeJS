<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: function_delete.php 13001 2009-08-05 06:18:06Z zhengqingpeng $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

function getusertodotask($uid){
	global $_SGLOBAL, $_SC;
	
	$qsql="SELECT t.* FROM ".tname('task')." t WHERE t.available=1 AND t.taskid NOT IN ( SELECT ut.taskid FROM ".tname('usertask')." ut WHERE ut.uid = $uid ) ORDER BY taskid DESC ";
	$query = $_SGLOBAL['db']->query($qsql);
	$list=array();
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$value['imagepath'] = empty($value['image'])?'image/task.gif':$value['image'];
			
		$list[] = $value;
	}
	
	return $list;
}
?>