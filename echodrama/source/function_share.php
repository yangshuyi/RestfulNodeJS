<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: function_repaste.php 13245 2009-08-25 02:01:40Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}


// ²éÑ¯
function loadsharebyid($shareid){
	global $_SGLOBAL, $_SC;
	 
	$qsql="SELECT t.* FROM ".tname("share")." s WHERE s.sid=$shareid";
	$query = $_SGLOBAL['db']->query($qsql);
	$value = $_SGLOBAL['db']->fetch_array($query);

	return $value;
}


// ²éÑ¯
function queryshare($querysql){
	global $_SGLOBAL, $_SC;

	$list=array();

	$query = $_SGLOBAL['db']->query($querysql);
	$index=0;
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$list[] = shareformmapper($value);
	}
	return $list;
}

function shareformmapper($share){
	global $_SGLOBAL, $_SC;
	 
	$share['datelinedisp'] = $share['dateline']?sgmdate('Y-m-d', $topicalbum['dateline']):'';
	$share['auditstatedisp'] = $share['auditstate']==1?'ÍÆ¼ö':'';
	return $share;
}

?>
