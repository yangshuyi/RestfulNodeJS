<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: do_login.php 13210 2009-08-20 07:09:06Z liguode $
*/
if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

$username = trim($_POST['username']);
$password = $_POST['password'];
	
if(empty($_POST['username'])) {
	showmessage_JSON('users_were_not_empty_please_re_login');
}
		
//同步获取用户源
if(!$passport = getpassport($username, $password)) {
	showmessage_JSON('login_failure_please_re_login');
}
		
$setarr = array(
	'uid' => $passport['uid'],
	'username' => addslashes($passport['username']),
	'password' => md5("$passport[uid]|$_SGLOBAL[timestamp]")//本地密码随机生成
);

include_once(S_ROOT.'./source/function_space.php');

//开通空间
//$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('space')." WHERE uid='$setarr[uid]'");
//if(!$space = $_SGLOBAL['db']->fetch_array($query)) {
//	showmessage_JSON('space_does_not_exist');
//}

$space = getspace($setarr[uid]);
if( empty($space) ){
	showmessage_JSON('space_does_not_exist');
}

$passportarray = array();
$passportsql="SELECT * FROM ".tname('member')." WHERE uid='$setarr[uid]'";
$query = $_SGLOBAL['db']->query($passportsql);
while ($value = $_SGLOBAL['db']->fetch_array($query)) {
	$passportarray[] = $value;
}

$passport = '';
if( count($passportarray)==1 ){
	$_SGLOBAL[supe_uid] = $passportarray[0][uid];
	$_SGLOBAL[username] = $passportarray[0][username];
	$passport = $passportarray[0]['password'];
}else{
	showmessage_JSON('login_failure_please_re_login');
}

$space['sex'] = $space['sex']=='1'?lang('man'):($space['sex']=='2'?lang('woman'):'');

$qsql="SELECT r.club, r.clubtagid, r.jobid, r.introduce FROM ".tname('resume')." r WHERE r.uid='$space[uid]'";
$resume = $_SGLOBAL['db']->cachequery($MODULE_NAME, $qsql, true, 1800);
if(!empty($resume)) {
	$space['club'] = $resume['club'];
	$space['clubtagid'] = $resume['clubtagid'];
	$space['jobid'] = $resume['jobid'];
	$space['introduce'] = $resume['introduce'];
	
	$jobname="";
	if($space['jobid']){
		$arr=explode(',',$space['jobid']);
		include_once(S_ROOT.'./data/data_jobclass.php');
		foreach ($arr as $classid) {
			if(empty($classid)){
				continue;
			}
			$jobname=$jobname.$_SGLOBAL['jobclass'][$classid]['classname']." ";
		}
	}
	$space['jobname']=$jobname;
}


$space_JSON = spaceformmapper_JSON($space, true, $passport);
returnObj_JSON($space_JSON);
?>