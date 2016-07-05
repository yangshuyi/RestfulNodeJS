<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_mood.php 10314 2008-11-28 09:09:23Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//分页
$perpage = 20;
$page = empty($_GET['page'])?0:intval($_GET['page']);
if($page<1) $page=1;
$start = ($page-1)*$perpage;

//检查开始数
ckstart($start, $perpage);

$list = array();
$count = 0;

if($space['mood']) {
	$theurl = "space.php?uid=$space[uid]&do=mood";
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('space')." s WHERE s.mood='$space[mood]'"), 0);
	if($count) {
		$query = $_SGLOBAL['db']->query("SELECT s.*,sf.note,sf.sex FROM ".tname('space')." s
			LEFT JOIN ".tname('spacefield')." sf ON sf.uid=s.uid
			WHERE s.mood='$space[mood]'
			ORDER BY s.updatetime DESC LIMIT $start,$perpage");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			$value['isfriend'] = ($value['uid']==$space['uid'] || ($space['friends'] && in_array($value['uid'], $space['friends'])))?1:0;
			realname_set($value['uid'], $value['username'], $value['name'], $value['namestatus']);
			$list[] = $value;
		}
	}
	
	realname_get();
	
	//分页
	$multi = multi($count, $perpage, $page, $theurl);

}

$nav_list = array();
$nav_item = array();
$nav_item['url'] = "space.php?do=doing"; $nav_item['dispname'] = "无病呻吟";
$nav_list[] = $nav_item;

$nav_item = array();
$nav_item['url'] = "uid=$space[uid]&do=mood"; $nav_item['dispname'] = "同心情的朋友";
$nav_list[] = $nav_item;
	
include_once template("space_mood");

?>