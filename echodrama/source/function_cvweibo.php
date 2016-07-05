<?php
/*
 [UCenter Home] (C) 2007-2008 Comsenz Inc.
 $Id: function_delete.php 13001 2009-08-05 06:18:06Z zhengqingpeng $
 */

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

function cvmapper($name){
	
	$name = trim($name);
	return $name;
	
//	$name = trim($name);
//	$list = cachequerycvweibomap(true);
//	$url = $list[$name];
//	
//	if(empty($url)) return $name;
//	
//	return $url;
}

function cachequerycvweibomap($forceload = false){
	global $_SGLOBAL, $_SC;
	$MODULE_CVWEIBO_NAME = "CVWEIBO";
	
	$list = $_SGLOBAL['db']->cacheobj($MODULE_CVWEIBO_NAME, "cvweibomap", "querycvweibomap", array(), $forceload==true?0:86400);
	return $list;
}

function querycvweibomap(){
	global $_SGLOBAL, $_SC;
	
	$list=array(); 
	$querysql = "SELECT * FROM ".tname("cvweibo")." c WHERE c.status=1 ORDER BY c.name";
	$query = $_SGLOBAL['db']->query($querysql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$list[$value[name]] = "@".$value[weibo];
	}
	
	return $list;
}

function querycvweibo($querysql){
	global $_SGLOBAL, $_SC;
	 
	$list=array();

	$query = $_SGLOBAL['db']->query($querysql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$value = cvweiboformmapper($value);
		$list[] = $value;
	}
	return $list;
}

function loadcvweibobyid($id){
	global $_SGLOBAL, $_SC;
	
	$qsql="SELECT c.* FROM ".tname("cvweibo")." c WHERE c.id=$id";
	$query = $_SGLOBAL['db']->query($qsql);
	$value = $_SGLOBAL['db']->fetch_array($query);	
	
	return $value;
}

function querycvweibobyname($id, $name){
	global $_SGLOBAL, $_SC;
	
	if(empty($id)){
		$qsql="SELECT c.* FROM ".tname("cvweibo")." c WHERE c.name='$name'";
	}
	else{
		$qsql="SELECT c.* FROM ".tname("cvweibo")." c WHERE c.name='$name' AND c.id!=$id";
	}
	
	$query = $_SGLOBAL['db']->query($qsql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$value = cvweiboformmapper($value);
		$list[] = $value;
	}
	return $list;
}

function cvweiboformmapper($cvweibo){
	global $_SGLOBAL, $_SC;

	if($cvweibo[status]==0){
		$cvweibo[statusdispname] = "½ûÓÃ";
	}else if($cvweibo[status]==1){
		$cvweibo[statusdispname] = "Õý³£";
	}
	
	return $cvweibo;
}

?>