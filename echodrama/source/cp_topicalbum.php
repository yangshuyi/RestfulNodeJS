<?php
/*
 [UCenter Home] (C) 2007-2008 Comsenz Inc.
 $Id: cp_topic.php 12436 2009-06-25 09:07:38Z liguode $
 */

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//检查信息
$topicalbumid = empty($_GET['topicalbumid'])?0:intval($_GET['topicalbumid']);
$op = empty($_GET['op'])?'':$_GET['op'];

//获取作品类型信息
include_once(S_ROOT.'./data/data_productclass.php');

include_once(S_ROOT.'./source/function_topic.php');

if($_GET['op'] == 'listtopic') {
	
	$topiclist=array();
	
	if($topicalbumid) {
		$qsql="SELECT t.* FROM ".tname("topic")." t ,".tname("topic_album")." ta WHERE t.topicid=ta.topicid and ta.topicalbumid=$topicalbumid order by ta.index";
		$topiclist=querytopic($qsql);
	
		$topicids="";
		foreach($topiclist as $topic){
			$topicids=$topicids.",".$topic[topicid];
		}
	}
	include_once template("cp_topicalbum_topiclist_ajax");
	
}elseif($_GET['op'] == 'refreshtopic') {
	
	$topicids = $_GET['topicids'];
	$topicidarray = split(',',$topicids);
	$topiclist = array();
	foreach($topicidarray as $topicid){
		if(empty($topicid)){
			continue;
		}
		$topic=loadtopicsinglebyid($topicid);
		
		if(!$topic) {
			showmessage("topic_does_not_exist");
		}	
		$topiclist[]=topicsingleformmapper($topic);
	}
	
	include_once template("cp_topicalbum_topiclist_ajax");
}
?>