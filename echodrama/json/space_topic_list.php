<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_feed.php 12432 2009-06-25 07:31:34Z xupeng $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}
$MODULE_NAME = "SPACE_TOPIC";

$_GET['view'] = empty($_GET['view']) ? "single" : $_GET['view'];

$page = empty($_GET['page'])?1:intval($_GET['page']);
if($page<1) $page = 1;

$perpage = empty($_GET['perpage'])?30:intval($_GET['perpage']);
$start = ($page-1)*$perpage;

include_once(S_ROOT.'./data/data_productclass.php');
include_once(S_ROOT.'./data/data_topicauditclass.php');
include_once(S_ROOT.'./source/function_topic.php');
include_once(S_ROOT.'./source/function_admincp.php');
include_once(S_JSON_ROOT.'./function_topic.php');
		
$list = array();

$mpurl="json/space.php?do=topic&uid=$uid";
$multi = '';
	
$intkeys = array('productclassid');
$strkeys = array();
//TODO 日期查询有问题
$randkeys = array(array('sstrtotime','producedate'), array('intval','viewnum'), array('intval','replynum'), array('intval','hot'));
$likekeys = array('subject','club','director','cehua', 'writer','cast','producer','effector','photographer','propagandizer');
$results = getwheres($intkeys, $strkeys, $randkeys, $likekeys, 't.');
$wherearr = $results['wherearr'];
$wheresql = empty($wherearr)?'1':implode(' AND ', $wherearr);

$page = empty($_GET['page'])?1:intval($_GET['page']);
if($page<1) $page = 1;

$start = ($page-1)*$perpage;
//检查开始数
ckstart($start, $perpage);
	
$mpurl .= '&'.implode('&', $results['urls']);
$mpurl .= '&perpage='.$perpage;
$mpurl .= '&view='.$_GET['view'];

$orderbysql=" ORDER BY ";
if(!empty($_GET[orderby])){
	$orderbysql.= $_GET[orderby];
	$mpurl .= "&orderby=$_GET[orderby]";
}
else{
	$orderbysql.= "t.replydateline DESC";
}
	
if(!empty($_GET['label'])){
	$wheresql.= " AND t.topicid IN (SELECT DISTINCT tl.topicid FROM ".tname('topiclabel')." tl WHERE tl.label='$_GET[label]')";
	$mpurl .= "&label=$_GET[label]";
}
	
if($_GET['view'] == 'single') {
	$csql = "SELECT COUNT(*) AS count FROM ".tname('topic')." t WHERE t.type='single' and t.auditstate=2 and $wheresql";
	$qsql = "SELECT * FROM ".tname('topic')." t WHERE t.type='single' and t.auditstate=2 and $wheresql $orderbysql LIMIT $start,$perpage";
} 
else if($view == 'album') {
	//所有专辑
	$csql = "SELECT COUNT(*) AS count FROM ".tname('topic')." t WHERE ( t.type='album' OR (t.type='single' AND t.singtonalbum=1) ) and $wheresql";
	$qsql = "SELECT * FROM ".tname('topic')." t WHERE ( t.type='album' OR (t.type='single' AND t.singtonalbum=1) ) and $wheresql $orderbysql LIMIT $start,$perpage";
} 
else if($view == 'forecast') {
	//所有广播剧预告 不用wheresql
	$cutofftime = getCurrentDate() - 60*60;
	$csql = "SELECT COUNT(*) AS count FROM ".tname('topic_forecast')." tf WHERE tf.invalid = 0 AND tf.producedate>=$cutofftime ";
	$qsql = "SELECT * FROM ".tname('topic_forecast')." tf WHERE tf.invalid = 0 AND tf.producedate>=$cutofftime ORDER BY tf.producedate LIMIT $start,$perpage";
} 
else if($view == 'share') {
	//我的收藏
	$userid='';
	if(empty($uid)){
		$userid=$_SGLOBAL[supe_uid];
	}else{
		$userid=$uid;
	}
	$csql = "SELECT COUNT(t.topicid) AS count FROM ".tname('topic')." t, ".tname('topicuser')." tu WHERE tu.topicid=t.topicid and tu.uid = '$userid' and $wheresql";
	$qsql = "SELECT t.* FROM ".tname('topic')." t, ".tname('topicuser')." tu WHERE tu.topicid=t.topicid and tu.uid = '$userid' and $wheresql $orderbysql LIMIT $start,$perpage";
}
	
$count = $_SGLOBAL['db']->cachequery($MODULE_NAME, $csql, true);
$count = $count['count'];
if($count>0) {
	$origin_list = array();
	
	if($view == 'forecast'){
		$origin_list=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "topicforecastlist", "querytopicforecast", array($qsql), $page == 1?60:1800);
	}
	else{
		$origin_list=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "topiclist", "querytopic", array($qsql), $page == 1?60:1800);
	}
	
	foreach($origin_list as $topic) {
		$list[] = topicformmapper_JSON($topic);
	}
	
}

$multi = multi_JSON($count, $perpage, $page, $mpurl, $list);

returnObj_JSON( $multi );
?>