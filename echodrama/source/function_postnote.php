<?php
/*
 [UCenter Home] (C) 2007-2008 Comsenz Inc.
 $Id: function_delete.php 13001 2009-08-05 06:18:06Z zhengqingpeng $
 */

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}


function loadpostnotebyid($postnoteid){
	global $_SGLOBAL, $_SC;

	$querysql = "SELECT * FROM ".tname('postnote')." pn WHERE pn.postnoteid='$postnoteid'";
	$query = $_SGLOBAL['db']->query($querysql);
	$value = $_SGLOBAL['db']->fetch_array($query);
	return $value;
}

function querypostnotebyid($sql){
	global $_SGLOBAL, $_SC;

	$list=array();
	$query = $_SGLOBAL['db']->query($sql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$list[] = postnoteformmapper($value);
	}
	return $list[0];
}

function postnoteformmapper( $value ) {
	global $_SGLOBAL, $_SC;
		
	include_once(S_ROOT.'./data/data_mtagtaskimptclass.php');
	
	$value['importancename'] = $_SGLOBAL['mtagtaskimptclass'][$value['importance']]['classname'];
	$value['notedatedisp'] = $value['notedate']?sgmdate('Y-m-d',$value['notedate']):'';
				
	return $value;
}



?>