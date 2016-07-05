<?php
/*
 [UCenter Home] (C) 2007-2008 Comsenz Inc.
 $Id: function_delete.php 13001 2009-08-05 06:18:06Z zhengqingpeng $
 */

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

function listclublabel(){
	global $_SGLOBAL, $_SC;

	//include_once(S_ROOT.'./source/function_admincp.php');
	$list=array();
	$querysql="SELECT cl.* FROM ".tname('clublabel')." cl ORDER BY cl.joinnum desc";
	$query = $_SGLOBAL['db']->query($querysql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$obj=array();
		$obj['classid'] = $value['classid'];
		$obj['classname'] = $value['classname'];
		$list[] = $obj;
	}
	return $list;
}


// ²éÑ¯¼òÀú
function queryresumehistory($querysql){
	global $_SGLOBAL, $_SC;

	include_once(S_ROOT.'./data/data_producttype.php');
	$list=array();
	
	$query = $_SGLOBAL['db']->query($querysql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$value['fromdate'] = $value['fromdate']?sgmdate('Y-m-d', $value['fromdate']):'';
		$value['todate'] = $value['todate']?sgmdate('Y-m-d', $value['todate']):'';
		
		$value['producttypename'] = $_SGLOBAL['producttype'][$value['producttype']]['classname'];
		if($value['producttype']=="1"){
			$value['producturl'] = "space.php?do=topic&topicid=$value[productid]";
		}
		elseif($value['producttype']=="2"){
			$value['producturl'] = "space.php?do=cover&coverid=$value[productid]";
		}
		elseif($value['producttype']=="3"){
			$value['producturl'] = "space.php?do=video&videoid=$value[productid]";
		}
		
		realname_set($value['uid'], $value['username']);

		$jobname="";
		if($value['jobid']){
			$arr=explode(',',$value['jobid']);
			foreach ($arr as $classid) {
				$jobname=$jobname.$_SGLOBAL['jobclass'][$classid]['classname']." ";
			}
		}
		$value['jobname']=$jobname;
		
		$list[] = $value;
	}
	return $list;
}
?>