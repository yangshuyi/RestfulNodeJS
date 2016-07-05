<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: cp.php 13003 2009-08-05 06:46:06Z liguode $
*/

//通用文件
include_once('./common.php');
include_once(S_ROOT.'./source/function_cp.php');
include_once(S_ROOT.'./source/function_magic.php');

//允许的方法
$acs = array('member','topic','tone','cover','video','tableinfo');

$ac = (empty($_GET['ac']) || !in_array($_GET['ac'], $acs))?'':$_GET['ac'];

if( $_SGLOBAL['member']['system']==-1 ) {
	//showmessage('no_privilege');
}

//权限判断
if(empty($_SGLOBAL['supe_uid'])) {
	if($_SERVER['REQUEST_METHOD'] == 'GET') {
		ssetcookie('_refer', rawurlencode($_SERVER['REQUEST_URI']));
	} else {
		ssetcookie('_refer', rawurlencode('static.php?ac='.$ac));
	}
	showmessage('to_login', 'do.php?ac='.$_SCONFIG['login_action']);
}

//获取空间信息
$space = getspace($_SGLOBAL['supe_uid']);
if(empty($space)) {
	showmessage('space_does_not_exist');
}

$_TPL['css'] = 'space';

//菜单
if( !empty($ac) )
{
	$actives = array($ac => ' class="active"');
	include_once(S_ROOT.'./static/static_'.$ac.'.php');
}
else{
	include_once template("static/static");
}
?>