<?php
/*
 [UCenter Home] (C) 2007-2008 Comsenz Inc.
 $Id: cp_repaste.php 13026 2009-08-06 02:17:33Z liguode $
 */

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//检查信息
$repasteid = empty($_GET['repasteid'])?0:intval($_GET['repasteid']);
$op = empty($_GET['op'])?'':$_GET['op'];

$repaste = array();
if($repasteid) {
	$query = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('repaste')." b
		LEFT JOIN ".tname('repastefield')." bf ON bf.repasteid=b.repasteid 
		WHERE b.repasteid='$repasteid'");
	$repaste = $_SGLOBAL['db']->fetch_array($query);
}

//权限检查
if(empty($repaste)) {
	if(!checkperm('allowrepaste')) {
		ckspacelog();
		showmessage('no_authority_to_add_repaste');
	}

} else {

	if($_SGLOBAL['supe_uid'] != $repaste['uid'] && !checkperm('managerepaste')) {
		showmessage('no_authority_operation_of_the_log');
	}
}

include_once(S_ROOT.'./data/data_repasteclass.php');
include_once(S_ROOT.'./source/function_repaste.php');

//添加编辑操作
if( $_GET['op'] == 'save' ) {

	if(empty($repaste['repasteid'])) {
		$repaste = array();
		$repaste['dateline']=$_SGLOBAL['timestamp'];
		$repaste['uid'] = $_SGLOBAL['supe_uid'];
		$repaste['username'] = $_SGLOBAL['supe_username'];
	} else {
		if(empty($repaste)) {
			showmessage('repaste_does_not_exist');
		}
	}

	if(!checkperm('allowrepaste')) {
		ckspacelog();
		showmessage('no_authority_to_add_repaste');
	}

	$repaste['classid'] = intval($_POST['classid']);
	$repaste['subject'] = $_POST['subject'];
	$repaste['url'] = $_POST['url'];
	$repaste['message']=$_POST['message'];
	$repaste['tag'] = shtmlspecialchars(trim($_POST['tag']));
	$repaste['tag'] = getstr($repaste['tag'], 500, 1, 1, 1);	//语词屏蔽

	if(empty($repaste['classid'])){
		showmessage('repaste_classid_empty');
	}elseif(empty($repaste['subject'])){
		showmessage('repaste_subject_empty');
	}elseif(empty($repaste['message'])){
		showmessage('repaste_message_empty');
	}


	//内容
	if($_SGLOBAL['mobile']) {
		//TODO need support
		$_POST['message'] = getstr($_POST['message'], 0, 1, 0, 1, 1);
	} else {
		$_POST['message'] = checkhtml($_POST['message']);
		$_POST['message'] = getstr($_POST['message'], 0, 1, 0, 1, 0, 1);
		$_POST['message'] = preg_replace(array(
				"/\<div\>\<\/div\>/i",
				"/\<a\s+href\=\"([^\>]+?)\"\>/i"
				), array(
				'',
				'<a href="\\1" target="_blank">'
				), $_POST['message']);
	}
	$message = $_POST['message'];
	//添加slashes
	$message = addslashes($message);

	save($repaste);
	
	showmessage('do_success', "space.php?do=repaste&view=me", 0);
	
} elseif($_GET['op'] == 'delete') {
	//删除
	if(empty($repaste)) {
		showmessage('repaste_does_not_exist');
	}
		
	if(!checkperm('managerepaste')) {
		showmessage('no_privilege');
	}

	deleterepaste($repaste);

	showmessage('do_success', "space.php?do=repaste&view=me");

} elseif($_GET['op'] == 'goto') {

	$id = intval($_GET['id']);
	$uid = $id?getcount('repaste', array('repasteid'=>$id), 'uid'):0;

	showmessage('do_success', "space.php?uid=$uid&do=repaste&id=$id", 0);

} elseif($_GET['op'] == 'edithot') {
	
	if(empty($repaste)) {
		showmessage('repaste_does_not_exist');
	}
	
	//权限
	if(!checkperm('managerepaste')) {
		showmessage('no_privilege');
	}

	if(submitcheck('hotsubmit')) {
		$_POST['hot'] = intval($_POST['hot']);
		updatetable('repaste', array('hot'=>$_POST['hot']), array('repasteid'=>$repaste['repasteid']));
		if($_POST['hot']>0) {
			include_once(S_ROOT.'./source/function_feed.php');
			feed_publish($repaste['repasteid'], 'repasteid');
		} else {
			updatetable('feed', array('hot'=>$_POST['hot']), array('id'=>$repaste['repasteid'], 'idtype'=>'repasteid'));
		}

		showmessage('do_success', "space.php?uid=$repaste[uid]&do=repaste&id=$repaste[repasteid]", 0);
	}

} else {
	//添加编辑
	$tags = empty($repaste['tag'])?array():unserialize($repaste['tag']);
	$repaste['tag'] = implode(' ', $tags);

	$repaste['target_names'] = '';

	$repaste['message'] = str_replace('&amp;', '&amp;amp;', $repaste['message']);
	$repaste['message'] = shtmlspecialchars($repaste['message']);

	$allowhtml = checkperm('allowhtml');

	//好友组
	$groups = getfriendgroup();

	//参与热点
	$topic = array();
	$topicid = $_GET['topicid'] = intval($_GET['topicid']);
	if($topicid) {
		$topic = topic_get($topicid);
	}
	if($topic) {
		$actives = array('repaste' => ' class="active"');
	}

	//菜单激活
	$menuactives = array('space'=>' class="active"');
}

include_once template("cp_repaste");

?>