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
$topicid = $_GET['topicid'];

include_once(S_ROOT.'./source/function_topic.php');
include_once(S_JSON_ROOT.'./function_topic.php');
		
//view
$topic=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "topic", "loadtopicbyid", array($topicid), 3600);
	
//广播剧不存在
if(empty($topic)) {
	showmessage_JSON('topic_does_not_exist');
}
	
if($topic['type']=='single'){
	$topic=topicsingleformmapper($topic);
}elseif($topic['type']=='album'){
	$topic=topicalbumformmapper($topic);
	$itemlist=loadalbumitemlist($topicid);
	$itemcount=count($itemlist);
}
	
$topicwithme = array();	
if( !empty($_SGLOBAL[supe_uid]) ) {
	//是否被收藏
	$shareSql= "SELECT COUNT(*) FROM ".tname('topicuser')." tu WHERE tu.topicid=$topicid and tu.uid=$_SGLOBAL[supe_uid]";
	$inShare = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($shareSql), 0);
	$topicwithme['share'] = $inShare;
	
	//是否已评级
	$userip=getonlineip(0);
	$topicpollsql= "SELECT * FROM ".tname('topicpoll')." tp WHERE tp.topicid=$topicid and ( tp.uid='$_SGLOBAL[supe_uid]' OR tp.userip='$userip' )";
	$query = $_SGLOBAL['db']->query($topicpollsql);
	$topicpoll = $_SGLOBAL['db']->fetch_array($query);
	$topicwithme['topicpoll'] = $topicpoll;
	
	//广播剧标签 - 我设置的标签
	$topiclabel_me_sql = "SELECT tl.label FROM ".tname('topiclabel')." tl WHERE tl.topicid='$topicid' AND uid='$_SGLOBAL[supe_uid]' ORDER BY tl.lastpost DESC";
	$topiclabel_me_list = querytopiclabel($topiclabel_me_sql);
	$topicwithme['topiclabellist'] = $topiclabel_me_list;
}

//可能感兴趣的广播剧
$othertopicqsql="select t.* from ".tname('topic')." t, ".tname('topic_album')." ta ";
$othertopicqsql.="where ta.topicid=t.topicid and ta.topicalbumid in ";
$othertopicqsql.=" (select topicalbumid from ".tname('topic_album')." where topicid ='$topic[topicid]') ";
$othertopicqsql.=" and ta.topicid != '$topic[topicid]'";
$othertopicqsql.=" order by ta.index";
$othertopiclist=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "othertopiclist", "querytopic", array($othertopicqsql), 86400);
	
//广播剧标签
$topiclabel_list=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "topiclabellist", "loadtopiclabelbytopicid", array($topic[topicid]), 1800);
	
$topiclabel_latest_sql = "SELECT tl.* FROM ".tname('topiclabel')." tl WHERE tl.topicid='$topicid' AND tl.uid>0 ORDER BY tl.lastpost DESC LIMIT 0, 10";
$topiclabel_lastest_list=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "topiclabellastestlist", "querytopiclabel", array($topiclabel_latest_sql), 1800);
	
//相关资源
$topicattachment_list=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "topicattachmentlist", "querytopicattachmentbytopicid", array($topic[topicid]), 1800);

//犀利剧评
$topicthread_list=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "topicthreadlist", "querytopicthreadbytopicid", array($topic[topicid]), 1800);
	
//评论
$commentlist = array();
	
$csql = "SELECT count(*) AS count FROM ".tname('comment')." WHERE id=$topicid AND idtype='topicid'";
$count = $_SGLOBAL['db']->cachequery($MODULE_NAME, $csql, true);
$count = $count['count'];
$topic['replynum']=$count;
		 
if($count>0){
	$qsql = "SELECT * FROM ".tname('comment')." WHERE id=$topicid AND idtype='topicid' ORDER BY dateline LIMIT 0,30";
	$commentlist30 = $_SGLOBAL['db']->cachequery($MODULE_NAME, $qsql, false, $page == intval( ($count-1)/30 )+1?0:1800);
}else{
	$commentlist30 = array();
}

//访问统计
$uip=getonlineip(0);
$qsql="SELECT sa.* FROM ".tname("session_all")." sa WHERE sa.ip='$uip'";
$query = $_SGLOBAL['db']->query($qsql);
$session_sa = $_SGLOBAL['db']->fetch_array($query);
if( !empty($session_sa)) {
	if(strstr($session_sa[topicids], $topic['topicid'])) {
	}
	else{
		$session_sa[topicids] .= ",".$topic['topicid'];
		$_SGLOBAL['db']->query("UPDATE ".tname('session_all')." SET topicids='$session_sa[topicids]' WHERE ip='$uip'");
			
		$_SGLOBAL['db']->query("UPDATE ".tname('topic')." SET viewnum=viewnum+1 WHERE topicid='$topic[topicid]'");
				
		$currentweek=getCurrentWeek();
		$dispyear = substr($currentweek, 0, 4);
		$topicStaticWeeklyTableName = tname("topic_static_weekly_".$dispyear);
	
		$weeklyqsql="SELECT * FROM $topicStaticWeeklyTableName WHERE topicid='$topic[topicid]' AND week='$currentweek'";
		$query = $_SGLOBAL['db']->query($weeklyqsql);
		$staticweekly = $_SGLOBAL['db']->fetch_array($query);
		if(empty($staticweekly)){
			$staticweekly=array();
			$staticweekly['topicid']=$topic[topicid];
			$staticweekly['week']=$currentweek;
			$staticweekly['viewnum']=1;
			inserttable("topic_static_weekly_".$dispyear, $staticweekly);
		}
		else{
			$_SGLOBAL['db']->query("UPDATE $topicStaticWeeklyTableName SET viewnum=viewnum+1 WHERE topicstaticweeklyid='$staticweekly[topicstaticweeklyid]'");
		}
	}
}

$topicdetail = topicsingledetailformmapper_JSON($topic, $topicwithme, $topiclabel_list, $topicattachment_list, $commentlist30);
		
returnObj_JSON( $topicdetail );
?>