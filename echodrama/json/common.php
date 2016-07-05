<?php
@define('IN_UCHOME', TRUE);
$_SGLOBAL = $_SCONFIG = $_SBLOCK = $_TPL = $_SCOOKIE = $_SN = $space = array();

//程序目录
define('S_ROOT', dirname(__FILE__).DIRECTORY_SEPARATOR."../");
define('S_JSON_ROOT', dirname(__FILE__).DIRECTORY_SEPARATOR."../json/");

include_once(S_ROOT.'./source/function_common.php');
include_once(S_JSON_ROOT."./function_common.php");
include_once(S_ROOT.'./config.php');

$_SC['attachdir'] = '../attachment/';

//时间
$mtime = explode(' ', microtime());
$_SGLOBAL['timestamp'] = $mtime[1];

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

$encodeFlag = base64_decode($_GET['encodeFlagBase64']);
if( $encodeFlag=="TRUE" || $encodeFlag=="true"){
	$_SGLOBAL['encodeFlag'] = true;
}

$uid = empty($_GET[uid])?$_POST[uid]:$_GET[uid];
$passport = empty($_GET[passport])?$_POST[passport]:$_GET[passport];

if(!empty($uid) && !empty($passport)){
	$passportarray = array();
	$passportsql="SELECT * FROM ".tname('member')." WHERE uid='$uid' AND password='$passport'";
	$query = $_SGLOBAL['db']->query($passportsql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$passportarray[] = $value;
	}

	if( count($passportarray)==1 ){
		$_SGLOBAL[supe_uid] = $passportarray[0][uid];
		$_SGLOBAL[username] = $passportarray[0][username];
	}else{
		$_SGLOBAL[supe_uid] = '';
		$_SGLOBAL[username] = '';	
	}
}

    
?>