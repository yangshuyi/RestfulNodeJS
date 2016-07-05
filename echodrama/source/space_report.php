<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: admincp_report.php 12856 2009-07-23 07:16:45Z zhengqingpeng $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

include_once(S_ROOT.'./source/function_report.php');
	
//检查信息
$reportid = empty($_GET['reportid'])?0:intval($_GET['reportid']);
$_GET['view'] = $view = empty($_GET['view']) ? "needprocess":$_GET['view'];

if(empty($reportid)) {
	//处理搜索
	include_once(S_ROOT.'./source/function_admincp.php');
	
	$intkeys = array();
	if(!isset($_GET['status']) || $_GET['status'] == 1) {
		$_GET['num1'] = 1;
		$_GET['status'] = 1;
	} elseif($_GET['status'] == 0) {
		$_GET['num'] = 0;
		$intkeys = array('num');
	}
	
	$mpurl = 'space.php?do=report';
		
	$actives = array($_GET['status'] => ' class="active"');
	
	$page = empty($_GET['page'])?1:intval($_GET['page']);
	if($page<1) $page = 1;
	
	$perpage = empty($_GET['perpage'])?10:intval($_GET['perpage']);
	$start = ($page-1)*$perpage;
	
	//检查开始数
	ckstart($start, $perpage);
	
	$mpurl .= '&'.implode('&', $results['urls']);
	$mpurl .= '&perpage='.$perpage;
	$mpurl .= '&view='.$view;

	if(!empty($_GET['idtype'])){
		$mpurl .= '&idtyppe='.$_GET['idtype'];
		$wheresql .= " AND r.idtype='$_GET[idtype]'";
		
		$pro_actives = array($_GET['idtype'] => ' style="font-weight:bold;"');
	}else{
		$pro_actives = array('all' => ' style="font-weight:bold;"');
	}
	
	if(isset($_GET['processstate'])){
		$mpurl .= '&processstate='.$_GET['processstate'];
		$wheresql .= " AND r.processstate='$_GET[processstate]'";
		
		$processstate_actives = array($_GET['processstate'] => ' class="active"');
	}else{
		$processstate_actives = array('all' => ' class="active"');
	}
	
	if($view == 'needprocess') {
		//未处理的举报
		$csql = "SELECT COUNT(*) FROM ".tname('report')." r WHERE r.processstate!='4' $wheresql";
		$qsql = "SELECT r.* FROM ".tname('report')." r WHERE r.processstate!='4' $wheresql order by r.dateline DESC LIMIT $start,$perpage";
	} else if($view == 'me') {
		//我的举报
		$csql = "SELECT COUNT(*) FROM ".tname('report')." r WHERE r.userids like '%/$_SGLOBAL[supe_uid]/%' $wheresql";
		$qsql = "SELECT r.* FROM ".tname('report')." r WHERE r.userids like '%/$_SGLOBAL[supe_uid]/%' $wheresql order by r.dateline DESC LIMIT $start,$perpage";
	} else if($view == 'all') {
		//我的举报
		$csql = "SELECT COUNT(*) FROM ".tname('report')." r WHERE 1=1 $wheresql";
		$qsql = "SELECT r.* FROM ".tname('report')." r WHERE 1=1 $wheresql order by r.dateline DESC LIMIT $start,$perpage";
	}
	
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($csql), 0);
	if($count) {
		$query = $_SGLOBAL['db']->query($qsql);
		$list=queryreport($qsql);
		
		//显示分页
		$multi = multi($count, $perpage, $page, $mpurl);
	}
	$actives = array($view => ' class="active"');
	
	include_once template('space_report_list');
}
else{
	if($_GET['op']=="loadcomments"){
		$commentlist = array();
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('comment')." WHERE id=$reportid AND idtype='reportid' ORDER BY dateline");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			realname_set($value['authorid'], $value['author']);//实名
			$commentlist[] = $value;
		}
		include_once template('space_report_comments_ajax');
	}
	elseif($_GET['op']=="viewsingle"){
		$qsql = "SELECT r.* FROM ".tname('report')." r WHERE r.rid='$reportid' ";
		$query = $_SGLOBAL['db']->query($qsql);
		$list=queryreport($qsql);

		$activereportitemid = $reportid;
		
		$view = 'me';
		
		$actives = array($view => ' class="active"');

		include_once template('space_report_list');
	}
	
}
?>
