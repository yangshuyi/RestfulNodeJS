<?php
/*
 [UCenter Home] (C) 2007-2008 Comsenz Inc.
 $Id: function_delete.php 13001 2009-08-05 06:18:06Z zhengqingpeng $
 */

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}


function listradio(){
	global $_SGLOBAL, $_SC;

	$querysql="SELECT r.* FROM ".tname('radio')." r ORDER BY r.starttime";
	
	return queryradio($querysql);
}

function listseperateradio(){
	global $_SGLOBAL, $_SC;

	$list=array();
	$historylist=array();
	$futurelist=array();

	$querysql="SELECT r.* FROM ".tname('radio')." r ORDER BY r.starttime";
	$query = $_SGLOBAL['db']->query($querysql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		
		$value = radioformmapper($value); 
		
		if( $value['endtime'] < $_SGLOBAL['timestamp']) {
			$historylist[] = $value;
		}
		else {
			$futurelist[] = $value;
		}
	}

	$list['history'] = $historylist;
	$list['future'] = $futurelist;

	return $list;
}

function queryradiochatting($qsql){
	global $_SGLOBAL, $_SC;

	$list=array();
	$query = $_SGLOBAL['db']->query($qsql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$list[] = $value;
	}
	return $list;
}

function queryradio($qsql){
	global $_SGLOBAL, $_SC;

	$list=array();
	$query = $_SGLOBAL['db']->query($qsql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$value = radioformmapper($value);
		$list[] = $value;
	}
	return $list;
}

function loadradiobyid($rid){
	global $_SGLOBAL, $_SC;
	 
	$qsql="SELECT r.* FROM ".tname("radio")." r WHERE r.rid=$rid";
	$query = $_SGLOBAL['db']->query($qsql);
	$value = $_SGLOBAL['db']->fetch_array($query);

	return $value;
}


function radioformmapper($value){
	global $_SGLOBAL, $_SC;

	$value['starttimedisp'] = $value['starttime']?sgmdate('Y-m-d H:i', $value['starttime']):'';
	$value['endtimedisp'] = $value['endtime']?sgmdate('Y-m-d H:i', $value['endtime']):'';
	$value['datelinedisp'] = $value['dateline']?sgmdate('Y-m-d', $value['dateline']):'';
	
	if( $value['endtime'] < $_SGLOBAL['timestamp']) {
		$value['state'] = "-1";
	}
	else if( $value['starttime'] > $_SGLOBAL['timestamp']) {
		$value['state'] = "1";
	}
	else {
		$value['state'] = "0";
	}
	
	$value['filepath']= $_SC['attachdir'].'./'.$value['file'];
	
	return $value;
}

//É¾³ý
function deleteradios($rids) {
	global $_SGLOBAL, $_SC;

	include_once(S_ROOT.'./source/function_cp.php');

	//Êý¾Ý
	$list = array();
	$manageradio = checkperm('manageradio');
	$qsql="SELECT * FROM ".tname('radio')." WHERE rid IN (".simplode($rids).")";
	$list=queryradio($qsql);

	foreach($list as $value) {
		if(empty($value)){
			continue;
		}

		if(file_exists($value['file'])){
			unlink($value['file']);
		}
		
		$_SGLOBAL['db']->query("DELETE FROM ".tname('radio_chatting')." WHERE rid=$value[rid]");
		$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE idtype='radioid' AND id=$value[rid]");
		$_SGLOBAL['db']->query("DELETE FROM ".tname('radio')." WHERE rid=$value[rid]");
	}

	return true;
}


?>