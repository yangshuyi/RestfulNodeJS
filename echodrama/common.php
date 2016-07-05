<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: common.php 13217 2009-08-21 06:57:53Z liguode $
*/

@define('IN_UCHOME', TRUE);
define('D_BUG', '0');

D_BUG?error_reporting(7):error_reporting(0);
set_magic_quotes_runtime(0);

$_SGLOBAL = $_SCONFIG = $_SBLOCK = $_TPL = $_SCOOKIE = $_SN = $space = array();

//程序目录
define('S_ROOT', dirname(__FILE__).DIRECTORY_SEPARATOR);
define('MOBILE_ROOT', dirname(__FILE__).DIRECTORY_SEPARATOR.'mobile/');

//基本文件
include_once(S_ROOT.'./ver.php');
if(!@include_once(S_ROOT.'./config.php')) {
	header("Location: install/index.php");//安装
	exit();
}
include_once(S_ROOT.'./source/function_common.php');

//时间
$mtime = explode(' ', microtime());
$_SGLOBAL['timestamp'] = $mtime[1];
$_SGLOBAL['supe_starttime'] = $_SGLOBAL['timestamp'] + $mtime[0];

//GPC过滤
$magic_quote = get_magic_quotes_gpc();
if(empty($magic_quote)) {
	$_GET = saddslashes($_GET);
	$_POST = saddslashes($_POST);
}

//本站URL
if(empty($_SC['siteurl'])) $_SC['siteurl'] = getsiteurl();

//链接数据库
dbconnect();

//缓存文件
if(!@include_once(S_ROOT.'./data/data_config.php')) {
	include_once(S_ROOT.'./source/function_cache.php');
	config_cache();
	include_once(S_ROOT.'./data/data_config.php');
}
foreach (array('app', 'userapp', 'ad', 'magic') as $value) {
	@include_once(S_ROOT.'./data/data_'.$value.'.php');
}

//COOKIE
$prelength = strlen($_SC['cookiepre']);
foreach($_COOKIE as $key => $val) {
	if(substr($key, 0, $prelength) == $_SC['cookiepre']) {
		$_SCOOKIE[(substr($key, $prelength))] = empty($magic_quote) ? saddslashes($val) : $val;
	}
}

//启用GIP
if ($_SC['gzipcompress'] && function_exists('ob_gzhandler')) {
	ob_start('ob_gzhandler');
} else {
	ob_start();
}

//初始化
$_SGLOBAL['supe_uid'] = 0;
$_SGLOBAL['supe_username'] = '';
$_SGLOBAL['inajax'] = empty($_GET['inajax'])?0:intval($_GET['inajax']);
$_SGLOBAL['mobile'] = empty($_GET['mobile'])?'':trim($_GET['mobile']);
$_SGLOBAL['ajaxmenuid'] = empty($_GET['ajaxmenuid'])?'':$_GET['ajaxmenuid'];
$_SGLOBAL['refer'] = empty($_SERVER['HTTP_REFERER'])?'':$_SERVER['HTTP_REFERER'];
if(empty($_GET['m_timestamp']) || $_SGLOBAL['mobile'] != md5($_GET['m_timestamp']."\t".$_SCONFIG['sitekey'])) $_SGLOBAL['mobile'] = '';
	
//登录注册防灌水机
if(empty($_SCONFIG['login_action'])) $_SCONFIG['login_action'] = md5('login'.md5($_SCONFIG['sitekey']));
if(empty($_SCONFIG['register_action'])) $_SCONFIG['register_action'] = md5('register'.md5($_SCONFIG['sitekey']));

//整站风格
$_SCONFIG['template'] = 'default';

//处理REQUEST_URI
if(!isset($_SERVER['REQUEST_URI'])) {  
	$_SERVER['REQUEST_URI'] = $_SERVER['PHP_SELF'];
	if(isset($_SERVER['QUERY_STRING'])) $_SERVER['REQUEST_URI'] .= '?'.$_SERVER['QUERY_STRING'];
}
if($_SERVER['REQUEST_URI']) {
	$temp = urldecode($_SERVER['REQUEST_URI']);
	if(strexists($temp, '<') || strexists($temp, '"')) {
		$_GET = shtmlspecialchars($_GET);//XSS
	}
}

//判断用户登录状态
checkauth();
$_SGLOBAL['uhash'] = md5($_SGLOBAL['supe_uid']."\t".substr($_SGLOBAL['timestamp'], 0, 6));

$_SGLOBAL['visit_cutoff'] = 0;
$userip=getonlineip(0);
$serverip = UC_IP;
$qsql="SELECT sa.* FROM ".tname("session_all")." sa WHERE sa.ip='$userip'";
$query = $_SGLOBAL['db']->query($qsql);
$session_sa = $_SGLOBAL['db']->fetch_array($query);
if(empty($session_sa)){
	$_SGLOBAL['db']->query("insert into ".tname("session_all")."(ip, uid, username, serverip, actioncount, firstactivity, lastactivity) values('$userip','$_SGLOBAL[supe_uid]','$_SGLOBAL[username]', '$serverip', 1,'$_SGLOBAL[timestamp]','$_SGLOBAL[timestamp]')");
	$_SGLOBAL['visit_cutoff'] = 1;
}else{
	$_SGLOBAL['db']->query("update ".tname("session_all")." set uid = '$_SGLOBAL[supe_uid]', username = '$_SGLOBAL[username]',serverip = '$serverip', lastactivity='$_SGLOBAL[timestamp]', actioncount=actioncount+1 where ip='$userip'");
}
$_SGLOBAL['db']->query("delete from ".tname("session_all")." where lastactivity < '".($_SGLOBAL['timestamp']-1800)."'");

$_SGLOBAL['db']->query("delete from ".tname("notification")." where dateline < '".($_SGLOBAL['timestamp']-(28400*45))."'");


//系统cache读取 虫虫小喇叭 / 站点管理员信息
$returnarray = getSystemCache();
$site_announcement_thread_topitem = $returnarray['site_announcement_thread_topitem'];
$site_administrator_list = $returnarray['site_administrator_list'];
	
//insert into ysys_useractivity(uid)  select uid from ysys_space 
//if(!empty($_SGLOBAL['supe_uid'])){
//	$currentweek = getCurrentWeek();
//	$dispweek = substr($currentweek, 6, 2);
//	$_SGLOBAL['db']->query("update ".tname("useractivity")." ua set ua.week_$dispweek = ua.week_$dispweek+1 where ua.uid = '$_SGLOBAL[supe_uid]'");
//}

?>