<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: admincp_blog.php 9233 2008-10-28 06:21:44Z liguode $
*/

if(!defined('IN_UCHOME') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

//权限
if(!checkperm('managetone')) {
	cpmessage('no_authority_management_operation');
}

$_GET['op'] = empty($_GET['op'])?'list':$_GET['op'];
$_GET['subop'] = empty($_GET['subop'])?'manage':$_GET['subop'];
$toneid = empty($_GET['toneid'])?0:intval($_GET['toneid']);

include_once(S_ROOT.'./source/function_tone.php');
include_once(S_ROOT.'./source/function_cp.php');

if($_GET['op'] == 'batchdelete') {
	//删除
//	if(deletetones($_POST['ids'])) {
//		showmessage('do_success', $_POST['mpurl']);
//	} else {
//		cpmessage('choose_to_delete_the_columns_tone'); // 请选择要删除的声线
//	}
} 
elseif($_GET['op'] == 'batchrename') {
	//批量重名
	if(renametones($_POST['ids'])) {
		showmessage('do_success', $_POST['mpurl']);
	} else {
		cpmessage('choose_to_rename_the_columns_tone'); // 请选择要审核的声线
	}
} 
elseif($_GET['op'] == 'delete') {
	
	submitcheck('tonesubmit');
	
	//删除
//	if(empty($toneid)) {
//		showmessage("tone_does_not_exist");
//	}
//	$tone=loadtonesinglebyid($toneid);
//	//声线不存在
//	if(empty($tone)) {
//		showmessage('tone_does_not_exist');
//	}
//	
//	$deletemessage = $_POST['auditmessage'];
//	
//	if(deletetones(array($toneid), $deletemessage)) {
//		showmessage('do_success', $_POST['referlink']);
//	} else {
//		showmessage('failed_to_delete_operation');
//	}
} 
elseif($_GET['op'] == 'list') {
	// 搜索
	
	$page = empty($_GET['page'])?1:intval($_GET['page']);
	if($page<1) $page = 1;
	
	$perpage = 30;
	$start = ($page-1)*$perpage;
	
	//处理搜索
	include_once(S_ROOT.'./source/function_admincp.php');

	$mpurl = 'admincp.php?ac=tone';
	$list = array();
	$multi = '';
	
	//$intkeys = array('productclassid');
	//$strkeys = array();
	//TODO 日期查询有问题
	//$randkeys = array(array('sstrtotime','producedate'), array('intval','viewnum'), array('intval','replynum'), array('intval','hot'));
	//$likekeys = array('subject','club','director','writer','cast','producer','effector','photographer');
	//$results = getwheres($intkeys, $strkeys, $randkeys, $likekeys, 't.');
	//$wherearr = $results['wherearr'];
	$wheresql = empty($wherearr)?'1':implode(' AND ', $wherearr);
	
	$page = empty($_GET['page'])?1:intval($_GET['page']);
	if($page<1) $page = 1;
	$start = ($page-1)*$perpage;
	//检查开始数
	ckstart($start, $perpage);
	
	$mpurl .= '&'.implode('&', $results['urls']);
	$mpurl .= '&perpage='.$perpage;
	$mpurl .= '&view='.$view;
	
	$csql = "SELECT COUNT(*) FROM ".tname('tone')." t WHERE $wheresql";
	$qsql = "SELECT * FROM ".tname('tone')." t WHERE $wheresql order by dateline DESC LIMIT $start,$perpage";
	
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($csql), 0);
	if($count) {
		$list=querytone($qsql);
		
		//显示分页
		$multi = multi($count, $perpage, $page, $mpurl);
	}
	
	$managebatch = checkperm('managebatch');
	$allowbatch = true;
	$actives = array($view => ' class="active"');
}

?>