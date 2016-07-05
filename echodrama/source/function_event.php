<?php
/*
 [UCenter Home] (C) 2007-2008 Comsenz Inc.
 $Id: function_delete.php 13001 2009-08-05 06:18:06Z zhengqingpeng $
 */

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//招募查询
function queryevent($querysql){
	global $_SGLOBAL, $_SC;
       
	include_once(S_ROOT.'./data/data_eventtype.php');
	include_once(S_ROOT.'./data/data_jobclass.php');
    $list=array();
	
	$query = $_SGLOBAL['db']->query($querysql);

	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		//TODO need more refactor
		$value["typename"]=$_SGLOBAL["eventtype"][$value["typeid"]]["classname"];
		$value['poster'] = pic_get($value['poster'], $value['thumb'], $value['remote']);
		$value['lastpost'] = sgmdate('Y-m-d', $value['lastpost']);
		$value['dateline'] = sgmdate('Y-m-d', $value['dateline']);
		$value['endtime'] = $value['endtime']?sgmdate('Y-m-d', $value['endtime']):'';
		$value['message'] = $value['message'];
		$value['messagelimit'] = getstr($value['message'], 200, 0, 0, 0, 0, -1);
		
			//招募职位分类
		$classname="";
		if($value['classid']){
			$arr=explode(',',$value['classid']);
			foreach ($arr as $classid) {
				$classname=$classname.$_SGLOBAL['jobclass'][$classid]['classname']." ";
			}
		}
		$value['classname']=$classname;
	
		$list[] = $value;
	}
	
	return $list;
}

?>