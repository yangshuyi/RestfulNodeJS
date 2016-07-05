<?php
/*
 [UCenter Home] (C) 2007-2008 Comsenz Inc.
 $Id: function_delete.php 13001 2009-08-05 06:18:06Z zhengqingpeng $
 */

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

function testconnectiontokaixin001($username, $password){
	global $_SGLOBAL, $_SC;
	
	include_once S_ROOT.'./uc_client/client.php';
	
	$postdata="email=$username&password=$password&remember=1&from=kx&refuid=0&refcode=&bind=&gotourl=&login=+%E7%99%BB+%E5%BD%95+";
	$loginresult = uc_fopen2('http://wap.kaixin001.com/home/?id=', 500000, $postdata, '', TRUE, '', 20);
	///home/state.php?verify=69767672_69767672_1284960751_8635bf92c98e0f27c8d3b45efa4cd477_kx
	$startpos = strpos($loginresult,'/home/index.php',1);
	$startpos = strpos($loginresult,'">',$startpos)+2;
	
	$endpos = strpos($loginresult,'</a>',$startpos);
	
	$dispname = substr($loginresult, $startpos, $endpos - $startpos); 
	$screen_name = iconv("utf-8","gb2312",$dispname);
	$fileopen = fopen("c:/t_kaixin001.log","a+");
	fwrite($fileopen,$postdata."->".$screen_name);
	fclose($fileopen);
	
	return "你的开心网用户名为[".$screen_name."]";	
}

function sendmessagetokaixin001($uid, $message){
	global $_SGLOBAL, $_SC;
	
	$list=array();
	$querysql="SELECT s.* FROM ".tname('space')." s WHERE s.uid = '$uid' ";
	$query = $_SGLOBAL['db']->query($querysql);
	$userspace = $_SGLOBAL['db']->fetch_array($query);
	
	if( empty($userspace) || $userspace['t_kaixin001_flag'] != 1) {
		return;
	}
	
	$username = $userspace['t_kaixin001_username'];
	$password = $userspace['t_kaixin001_password'];
		
	include_once S_ROOT.'./uc_client/client.php';
	$ucsynlogin = uc_user_synlogin($setarr['uid']);
	
	$postdata="email=$username&password=$password&remember=1&from=kx&refuid=0&refcode=&bind=&gotourl=&login=+%E7%99%BB+%E5%BD%95+";
	$loginresult = uc_fopen2('http://wap.kaixin001.com/home/?id=', 500000, $postdata, '', TRUE, '', 20);
	///home/state.php?verify=69767672_69767672_1284960751_8635bf92c98e0f27c8d3b45efa4cd477_kx
	$startpos = strpos($loginresult,'/home/state.php',1);
	$endpos = strpos($loginresult,'"',$startpos);
	$statewriteurl = substr($loginresult, $startpos, $endpos - $startpos); 
	
	//http://wap.kaixin001.com/home/state_submit.php?verify=69767672_69767672_1284960652_21cd454175698d545406c6874159ac22_kx
	$statewriteurl = str_replace('state.php', 'state_submit.php', $statewriteurl );
	
	$fileopen = fopen("c:/t_kaixin001.log","a+");
	fwrite($fileopen,$postdata." -> ".$statewriteurl);
	fclose($fileopen);
		
	$postdata="state=".$message;
	$recordpostresult = uc_fopen2('http://wap.kaixin001.com'.$statewriteurl, 500000, $postdata, '', TRUE, '', 20);
	
	$fileopen = fopen("c:/t_kaixin001.log","a+");
	fwrite($fileopen,$postdata." -> ".$statewriteurl);
	fclose($fileopen);
}


?>