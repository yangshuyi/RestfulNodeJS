<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: admincp_blog.php 9233 2008-10-28 06:21:44Z liguode $
*/

if(!defined('IN_UCHOME') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

//权限
if(!checkperm('manageradio')) {
	cpmessage('no_authority_management_operation');
}

$_GET['op'] = empty($_GET['op'])?'list':$_GET['op'];
$rid = empty($_GET['rid'])?0:intval($_GET['rid']);

include_once(S_ROOT.'./source/function_radio.php');
include_once(S_ROOT.'./source/function_cp.php');

if($_GET['op'] == 'new') {
	
	$radio=array();
	
}
else if($_GET['op'] == 'edit') {
	
	if(empty($rid)) {
		showmessage("radio_does_not_exist");
	}
	
	$radio = loadradiobyid($rid);
	$radio = radioformmapper($radio);
}
else if($_GET['op'] == 'save') {
	
	submitcheck('radiosubmit');
	
	$radio=loadradiobyid($rid);
	
	if(empty($radio)){
		$radio = array();
	}
		
	$radio['subject'] = $_POST['subject'];
	$radio['message'] = $_POST['message'];
	$radio['starttime'] = sstrtotime($_POST['starttime']);
	$radio['endtime'] = sstrtotime($_POST['endtime']);
	$radio['dateline'] = $_SGLOBAL['timestamp'];
		
	if(empty($radio['rid'])){
		$radio['file'] = $_POST['file'];
		$radio['file'] = mp3_save($radio['file'],'radio');
	}
	
	//检查输入
	if(empty($radio['subject'])){
		showmessage('radio_subject_empty');
	} elseif(empty($radio['starttime'])) {
		showmessage('radio_starttime_empty');
	} elseif(empty($radio['endtime'])) {
		showmessage('radio_endtime_empty');
	} elseif(empty($radio['file']) && empty($radio['rid'])) {
		showmessage('radio_file_empty');
	}
		
	if(empty($radio['rid'])){
		$rid = inserttable("radio", $radio, 1);
	}
	else{
		updatetable('radio', $radio, array('rid'=>$radio['rid']));
	}
	
	//产生动态
	if(!empty($_POST[makefeed])){
		include_once(S_ROOT.'./source/function_feed.php');
		feed_publish($rid, 'radioid', 0);
	}	
	
	showmessage('do_success', "/admincp.php?ac=radio&op=list", 1);
}
else if($_GET['op'] == 'synradio') {
	if(!$rid) {
		showmessage("radio_does_not_exist");
	}
	
	submitcheck('radiosubmit');
	
	synradio($rid);
		
	showmessage('do_success', "/admincp.php?ac=radio&op=list", 1);
		
} 
else if($_GET['op'] == 'synchattings') {
	if(!$rid) {
		showmessage("radio_does_not_exist");
	}
	
	submitcheck('radiosubmit');
	
	synchattings($rid);
		
	showmessage('do_success', "/admincp.php?ac=radio&op=list", 1);
		
} 
elseif($_GET['op'] == 'delete') {
	
	submitcheck('radiosubmit');
	
	//删除
	if(empty($rid)) {
		showmessage("radio_does_not_exist");
	}
	$radio=loadradiobyid($rid);
	//电台节目不存在
	if(empty($radio)) {
		showmessage('radio_not_exist');
	}
	
	if(deleteradios(array($rid))) {
		showmessage('do_success', "/admincp.php?ac=radio&op=list", 1);
	} 
	else {
		showmessage('failed_to_delete_operation');
	}
} 
elseif($_GET['op'] == 'list') {
	// 搜索
	
	$page = empty($_GET['page'])?1:intval($_GET['page']);
	if($page<1) $page = 1;
	
	$perpage = 30;
	$start = ($page-1)*$perpage;
	
	//处理搜索
	include_once(S_ROOT.'./source/function_admincp.php');

	$mpurl = 'admincp.php?ac=radio';
	$list = array();
	$multi = '';
	
	
	$page = empty($_GET['page'])?1:intval($_GET['page']);
	if($page<1) $page = 1;
	$start = ($page-1)*$perpage;
	//检查开始数
	ckstart($start, $perpage);
	
	$mpurl .= '&perpage='.$perpage;
	$wheresql = "1=1";
	
	$csql = "SELECT COUNT(*) FROM ".tname('radio')." r WHERE  $wheresql";
	$qsql = "SELECT * FROM ".tname('radio')." r WHERE $wheresql order by starttime DESC LIMIT $start,$perpage";
	
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($csql), 0);
	
	if($count) {
		$list=queryradio($qsql);
		
		//显示分页
		$multi = multi($count, $perpage, $page, $mpurl);
	}
}

?>