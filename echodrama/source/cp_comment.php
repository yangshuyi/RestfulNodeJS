<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: cp_comment.php 13000 2009-08-05 05:58:30Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

include_once(S_ROOT.'./source/function_bbcode.php');
include_once(S_ROOT.'./source/function_comment.php');

//共用变量
$tospace = $pic = $blog = $album = $share = $event = $poll = array();

if(submitcheck('commentsubmit')) {

	//判断是否发布太快
	$waittime = interval_check('post');
	if($waittime > 0) {
		showmessage('operating_too_fast','',1,array($waittime));
	}
	
	$idtype = $_POST['idtype'];
	$id = intval($_POST['id']);
	$cid = empty($_POST['cid'])?0:intval($_POST['cid']);
	$replypollvoteruid = intval($_POST['replypollvoteruid']);
	$message = $_POST['message'];
	savecomment($cid, $idtype, $id, $message, $replypollvoteruid, 0);
	
	showmessage($msg, $_POST['refer'], 0, $magvalues);
}

$cid = empty($_GET['cid'])?0:intval($_GET['cid']);

//编辑
if($_GET['op'] == 'edit') {

	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('comment')." WHERE cid='$cid' AND authorid='$_SGLOBAL[supe_uid]'");
	if(!$comment = $_SGLOBAL['db']->fetch_array($query)) {
		showmessage('no_privilege');
	}

	//提交编辑
	if(submitcheck('editsubmit')) {

		$message = getstr($_POST['message'], 0, 1, 1, 1, 2);
		if(strlen($message) < 2) showmessage('content_is_too_short');

		updatetable('comment', array('message'=>$message), array('cid'=>$comment['cid']));

		showmessage('do_success', $_POST['refer'], 0);
	}

	//bbcode转换
	$comment['message'] = html2bbcode($comment['message']);//显示用

} 
elseif($_GET['op'] == 'delete') {

	if(submitcheck('deletesubmit')) {
		include_once(S_ROOT.'./source/function_delete.php');
		if(deletecomments(array($cid))) {
			showmessage('do_success', $_POST['refer'], 0);
		} else {
			showmessage('no_privilege');
		}
	}

} 
elseif($_GET['op'] == 'reply') {

	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('comment')." WHERE cid='$cid'");
	if(!$comment = $_SGLOBAL['db']->fetch_array($query)) {
		showmessage('comments_do_not_exist');
	}

} 
elseif($_GET['op'] == 'replypollvoter') {

	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('space')." WHERE uid='$_GET[pollvoteruid]'");
	if(!$replypollvoter = $_SGLOBAL['db']->fetch_array($query)) {
		showmessage('user_does_not_exist');
	}
	$replypollvoter['pid'] = $_GET['pid'];
} 
else {

	showmessage('no_privilege');
}

include template('cp_comment');

?>