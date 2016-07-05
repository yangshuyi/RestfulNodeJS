<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: function_repaste.php 13245 2009-08-25 02:01:40Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}


// ²éÑ¯
function loadpollbyid($pollid){
	global $_SGLOBAL, $_SC;
	 
	$qsql="SELECT t.* FROM ".tname("poll")." s WHERE s.sid=$pollid";
	$query = $_SGLOBAL['db']->query($qsql);
	$value = $_SGLOBAL['db']->fetch_array($query);

	return $value;
}


// ²éÑ¯
function querypoll($querysql){
	global $_SGLOBAL, $_SC;

	$list=array();

	$query = $_SGLOBAL['db']->query($querysql);
	$index=0;
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$list[] = pollformmapper($value);
	}
	return $list;
}

function pollformmapper($poll){
	global $_SGLOBAL, $_SC;
	 
	$poll['datelinedisp'] = $poll['dateline']?sgmdate('Y-m-d', $topicalbum['dateline']):'';
	//$poll['auditstatedisp'] = $poll['auditstate']==1?'ÍÆ¼ö':'';
	return $poll;
}

?>
