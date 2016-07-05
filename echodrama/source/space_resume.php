<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_index.php 12256 2009-05-27 03:57:32Z liguode $
*/
if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//实名认证
if($space['namestatus']) {
	include_once(S_ROOT.'./source/function_cp.php');
	ckrealname('viewspace');
}

include_once(S_ROOT.'./data/data_jobclass.php');
include_once(S_ROOT.'./source/function_resume.php');
		
$userid='';
if(empty($_GET['uid'])){
	$userid=$_SGLOBAL[supe_uid];
}else{
	$userid=$_GET['uid'];
}
		
if($_GET['op'] == 'current') {
	$mpurl="space.php?uid=$userid&do=resume&op=current";
		
	$perpage=5;
	$page = empty($_GET['page'])?1:intval($_GET['page']);
	if($page<1) $page = 1;
	$start = ($page-1)*$perpage;
	//检查开始数
	ckstart($start, $perpage);
		
	$countquerysql="SELECT count(rh.resumehistoryid) FROM ".tname('resumehistory')." rh WHERE rh.currentflag=1 and rh.uid='$userid'";
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($countquerysql), 0);
	if($count) {
		$currentquerysql="SELECT rh.* FROM ".tname('resumehistory')." rh ";
		$currentquerysql.=" WHERE rh.currentflag=1 and rh.uid='$userid'";
		$currentquerysql.=" ORDER BY rh.producttype, rh.productname LIMIT $start,$perpage";
		$resumecurrentlist=queryresumehistory($currentquerysql);
			
		$multi = multi($count, $perpage, $page, $mpurl, "space_resume_current_content");
	}
	include_once template("space_resume_current_ajax");
} 
elseif($_GET['op'] == 'history') {
	$mpurl="space.php?uid=$userid&do=resume&op=history";
	
	$perpage=5;
	$page = empty($_GET['page'])?1:intval($_GET['page']);
	if($page<1) $page = 1;
	$start = ($page-1)*$perpage;
	//检查开始数
	ckstart($start, $perpage);
	
	$countquerysql="SELECT count(rh.resumehistoryid) FROM ".tname('resumehistory')." rh WHERE rh.currentflag=0 and rh.uid='$userid'";
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($countquerysql), 0);
	if($count) {
		$historyquerysql="SELECT rh.* FROM ".tname('resumehistory')." rh ";
		$historyquerysql.=" WHERE rh.currentflag=0 and rh.uid='$userid'";
		$historyquerysql.=" ORDER BY rh.producttype, rh.productname LIMIT $start,$perpage";
		$resumehistorylist=queryresumehistory($historyquerysql);
		
		$multi = multi($count, $perpage, $page, $mpurl, "space_resume_history_content");
	}
	include_once template("space_resume_history_ajax");
}
elseif($_GET['op'] == 'space') {
	$querysql="SELECT r.* FROM ".tname('resume')." r where r.uid='$userid'";
	$query = $_SGLOBAL['db']->query($querysql);
	$resume = $_SGLOBAL['db']->fetch_array($query);
	
	$jobname="";
	if($resume['jobid']){
		$arr=explode(',',$resume['jobid']);
		foreach ($arr as $classid) {
			$jobname=$jobname.$_SGLOBAL['jobclass'][$classid]['classname']." ";
		}
	}
	$resume['jobname']=$jobname;
			
	include_once(S_ROOT.'./source/function_resume.php');
	$currentquerysql="SELECT rh.* FROM ".tname('resumehistory')." rh ";
	$currentquerysql.=" WHERE rh.currentflag=1 and rh.uid='$userid'";
	$currentquerysql.=" ORDER BY rh.producttype, rh.productname ";
	$resumecurrentlist=queryresumehistory($currentquerysql);
	
	$historyquerysql="SELECT rh.* FROM ".tname('resumehistory')." rh ";
	$historyquerysql.=" WHERE rh.currentflag=0 and rh.uid='$userid'";
	$historyquerysql.=" ORDER BY rh.producttype, rh.productname ";
	$resumehistorylist=queryresumehistory($historyquerysql);
	
	$_TPL['css'] = 'space';
	include_once template("space_index_module");
}


?>
