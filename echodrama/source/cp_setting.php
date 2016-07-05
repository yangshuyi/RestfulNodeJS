<?php
/*
 [UCenter Home] (C) 2007-2008 Comsenz Inc.
 $Id: cp_profile.php 13149 2009-08-13 03:11:26Z liguode $
 */

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

$op = empty($_GET['op'])?'':$_GET['op'];

if( $op == 'savesetting') {
	if(submitcheck('settingsubmit')) {
	
		$setarr = array(
				'loginsucessforwardflag' => intval($_POST['loginsucessforwardflag']),
				'introflag' => intval($_POST['introflag']),
				'notificationflag' => intval($_POST['notificationflag']),
				't_sina_flag' => intval($_POST['t_sina_flag']),
				't_sina_username' => $_POST['t_sina_username'],
				't_sina_password' => $_POST['t_sina_password'],
				't_kaixin001_flag' => intval($_POST['t_kaixin001_flag']),
				't_kaixin001_username' => $_POST['t_kaixin001_username'],
				't_kaixin001_password' => $_POST['t_kaixin001_password'],
				'mobilequantityflag' => $_POST['mobilequantityflag'],
		);
	
		updatetable('space', $setarr, array('uid'=>$_SGLOBAL['supe_uid']));
	
		$url = 'cp.php?ac=profile&op=setting';
		showmessage('update_on_successful_individuals', $url, 1);
	}
}
else if( $op == 't_sina_testconnection') {
	//http://yangsh/cp.php?ac=setting&op=t_sina_testconnection&t_sina_username=zhuawaking@gmail.com&t_sina_password=superman
	include_once(S_ROOT.'./source/function_t_sina.php');
	
	$username = $_GET['t_sina_username'];
	$password = $_GET['t_sina_password'];
	
	$messagetext = testconnectiontosina($username, $password);
		
	showmessage('ajax_param', '', 0, array($messagetext));
}
else if( $op == 't_kaixin001_testconnection') {
	//http://yangsh/cp.php?ac=setting&op=t_sina_testconnection&t_sina_username=zhuawaking@gmail.com&t_sina_password=superman
	include_once(S_ROOT.'./source/function_t_kaixin001.php');
	
	$username = $_GET['t_kaixin001_username'];
	$password = $_GET['t_kaixin001_password'];
	
	$messagetext = testconnectiontokaixin001($username, $password);
		
	showmessage('ajax_param', '', 0, array($messagetext));
}

$nav_list = array();
$nav_item = array();
$nav_item['url'] = "cp.php?ac=profile"; $nav_item['dispname'] = "个人设置";
$nav_list[] = $nav_item;

$nav_item = array();
$nav_item['url'] = "cp.php?ac=setting"; $nav_item['dispname'] = "个性化设置";
$nav_list[] = $nav_item;

include template("cp_setting");

?>