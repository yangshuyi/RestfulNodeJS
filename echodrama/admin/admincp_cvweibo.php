<?php
/*
 [UCenter Home] (C) 2007-2008 Comsenz Inc.
 $Id: admincp_blog.php 9233 2008-10-28 06:21:44Z liguode $
 */

if(!defined('IN_UCHOME') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$id = empty($_GET['id'])?0:intval($_GET['id']);
$_GET['op'] = empty($_GET['op'])?'list':$_GET['op'];

//权限
if(!checkperm('managetopic')) {
	cpmessage('no_authority_management_operation');
}

include_once(S_ROOT.'./source/function_cvweibo.php');

if($_GET['op'] == 'list') {
	
	$page = empty($_GET['page'])?1:intval($_GET['page']);
	if($page<1) $page = 1;
	
	$perpage = 30;
	$start = ($page-1)*$perpage;
	
	//处理搜索
	include_once(S_ROOT.'./source/function_admincp.php');

	$mpurl = 'admincp.php?ac=cvweibo';
	$list = array();
	$multi = '';
	
	$intkeys = array();
	$strkeys = array();
	$randkeys = array();
	$likekeys = array('name', 'weibo');
	$results = getwheres($intkeys, $strkeys, $randkeys, $likekeys, 'c.');
	$wherearr = $results['wherearr'];
	$wheresql = empty($wherearr)?'1':implode(' AND ', $wherearr);
	
	$orderbysql=" ORDER BY ";
	if(!empty($_GET[orderby])){
		$orderbysql.= $_GET[orderby];
		$mpurl .= "&orderby=$_GET[orderby]";
	}
	else{
		$orderbysql.= "c.id DESC";
	}
	
	$csql = "SELECT COUNT(c.id) AS count FROM ".tname('cvweibo')." c WHERE $wheresql";
	$qsql = "SELECT c.* FROM ".tname('cvweibo')." c WHERE $wheresql $orderbysql LIMIT $start,$perpage";
	
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($csql), 0);
	if($count) {
		$list=querycvweibo($qsql);
		
		//显示分页
		$multi = multi($count, $perpage, $page, $mpurl);
	}
}
else if($_GET['op'] == 'manage') {

	submitcheck('topicsubmit');

	if(empty($id)){
		
	}
	else{
		$cvweibo = loadcvweibobyid($id);
		//CV微博不存在
		if(empty($cvweibo)) {
			showmessage('cvweibo_does_not_exist');
		}
	}
} 
else if($_GET['op'] == 'save') {

	submitcheck('topicsubmit');

	if(empty($id)){
		// 新CV微博
		$cvweibo = Array();
	}
	else{
		$cvweibo = loadcvweibobyid($id);
		//CV微博不存在
		if(empty($cvweibo)) {
			showmessage('cvweibo_does_not_exist');
		}
	}
	
	$cvweibo['name'] = $_POST['name'];
	$cvweibo['weibo'] = $_POST['weibo'];
	$cvweibo['url'] = $_POST['url'];
	$cvweibo['status'] = $_POST['status'];
		
	//检查输入
	if(empty($cvweibo['name'])){
		showmessage('cvweibo_name_empty');
	} elseif(empty($cvweibo['weibo'])){
		showmessage('cvweibo_weibo_empty');
	} elseif(empty($cvweibo['url'])){
		showmessage('cvweibo_url_empty');
	}

	if(!empty($_POST['uid'])){
		$user = queryuserbyid($_POST['uid']);
		//用户不存在
		if(empty($user)) {
			showmessage('space_does_not_exist');
		}
		$cvweibo['uid'] = $user['uid'];
		$cvweibo['username'] = $user['username'];
	}

	if(empty($id)){
		inserttable("cvweibo", $cvweibo);
	}else{
		updatetable('cvweibo', $cvweibo, array('id'=>$id));
	}
	showmessage('do_success', "admincp.php?ac=cvweibo", 0);

} 
elseif($_GET['op'] == 'delete') {

	submitcheck('topicsubmit');

	if( empty($id) ){
		showmessage('cvweibo_does_not_exist');
	}
	
	$cvweibo = loadcvweibobyid($id);
	//CV微博不存在
	if(empty($cvweibo)) {
		showmessage('cvweibo_does_not_exist');
	}
	
	$sql="DELETE FROM ".tname('cvweibo')." WHERE id=$id";
	$_SGLOBAL['db']->query($sql);
	
	showmessage('do_success', "admincp.php?ac=cvweibo", 0);

} elseif($_GET['op'] == 'checkname') {

	submitcheck('topicsubmit');

	$name = $_GET['name'];
	if( empty($name) ){
		showmessage('cvweibo_name_empty');
	}
	
	$cvweibolist = querycvweibobyname($id, $name);
//	if(count($cvweibolist)>0){
//		$result = loadmessage("cvweibo_namecheck_failure");
//	}else{
//		$result = loadmessage("cvweibo_namecheck_ok");
//	}

	if(count($cvweibolist)>0){
		$result = "该CV名已存在";
	}else{
		$result = "该CV名还未被系统录入";
	}
	showmessage('ajax_param', '', 0, array($name,$result));
} else{
}

?>