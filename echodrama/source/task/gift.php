<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: gift.php 12841 2009-07-23 02:01:57Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

if($_SGLOBAL['supe_uid']) {
	
	$task['done'] = 1;//�������
	
	$bloglist = array();
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('blog')." WHERE hot>='3' AND friend='0' ORDER BY dateline DESC LIMIT 0,20");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		realname_set($value['uid'], $value['username']);
		$bloglist[] = $value;
	}
	realname_get();
	
	if(empty($bloglist)){
		return;
	}
	
	$task['result'] = '<p>��������һ�� �������ռǵ����� �����ɣ�</p>';
	$task['result'] .= '<br><ul class="line_list">';
	
	foreach ($bloglist as $value) {
		$task['result'] .= "<li><a href=\"space.php?uid=$value[uid]\" target=\"_blank\"><strong>".$_SN[$value['uid']]."</strong></a>��<a href=\"space.php?uid=$value[uid]&do=blog&id=$value[blogid]\" target=\"_blank\">$value[subject]</a> <span class=\"gray\">($value[hot]���Ƽ�)</span></li>";
	}
	$task['result'] .= '</ul>';
	
} else {
	
	$task['guide'] = '';
}

?>