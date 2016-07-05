<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: log.php 11425 2009-03-05 05:11:17Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//一次处理的个数，防止超时。 早上5点做
execute();

function execute(){
	global $_SGLOBAL, $_SC;
	include_once(S_ROOT.'./source/function_topic.php');
	include_once(S_ROOT.'./source/function_cp.php');
	
	$cutofftime = getCurrentDate() - 60*60;
	$nextcutofftime = $cutofftime+60*60*24;
	$topicforecast_previous_sql = "SELECT tf.* FROM ".tname('topic_forecast')." tf WHERE tf.invalid = 0 AND tf.producedate <= $cutofftime";
	$topicforecast_previous_list = querytopicforecast($topicforecast_previous_sql);
	foreach($topicforecast_previous_list as $value){
		//消耗积分100 并发送消息给上传者
		updatetopicreward($value['uid'], 'topicforecast_discard');
		notification_add($value['uid'],"topicforecast_confirm","很遗憾，你的广播剧预告没有于 $value[producedatedisp] 按时发布,系统自动扣除你100积分。<br/>请下次按时发布！！！",0);
		
		//标识删除该剧的预告
		$deletetopicforecastsql="UPDATE ".tname("topic_forecast")." SET invalid = 1 WHERE topicforecastid = $value[topicforecastid]";
		$query = $_SGLOBAL['db']->query($deletetopicforecastsql);
	}
	
	$topicforecast_current_sql = "SELECT tf.* FROM ".tname('topic_forecast')." tf WHERE tf.producedate > $cutofftime AND tf.producedate < $nextcutofftime";
	$topicforecast_current_list = querytopicforecast($topicforecast_current_sql);
	foreach($topicforecast_current_list as $value){
		//发送消息给上传者进行确认
		notification_add($value['uid'],"topicforecast_confirm","你的广播剧预告<a href='space.php?do=topicid&topicforecastid=$value[topicforecastid]' target='_blank'>$value[subject]</a>将在今天到期，请准时发布。",0);
	}
}
?>