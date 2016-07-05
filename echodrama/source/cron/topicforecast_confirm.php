<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: log.php 11425 2009-03-05 05:11:17Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//һ�δ���ĸ�������ֹ��ʱ�� ����5����
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
		//���Ļ���100 ��������Ϣ���ϴ���
		updatetopicreward($value['uid'], 'topicforecast_discard');
		notification_add($value['uid'],"topicforecast_confirm","���ź�����Ĺ㲥��Ԥ��û���� $value[producedatedisp] ��ʱ����,ϵͳ�Զ��۳���100���֡�<br/>���´ΰ�ʱ����������",0);
		
		//��ʶɾ���þ��Ԥ��
		$deletetopicforecastsql="UPDATE ".tname("topic_forecast")." SET invalid = 1 WHERE topicforecastid = $value[topicforecastid]";
		$query = $_SGLOBAL['db']->query($deletetopicforecastsql);
	}
	
	$topicforecast_current_sql = "SELECT tf.* FROM ".tname('topic_forecast')." tf WHERE tf.producedate > $cutofftime AND tf.producedate < $nextcutofftime";
	$topicforecast_current_list = querytopicforecast($topicforecast_current_sql);
	foreach($topicforecast_current_list as $value){
		//������Ϣ���ϴ��߽���ȷ��
		notification_add($value['uid'],"topicforecast_confirm","��Ĺ㲥��Ԥ��<a href='space.php?do=topicid&topicforecastid=$value[topicforecastid]' target='_blank'>$value[subject]</a>���ڽ��쵽�ڣ���׼ʱ������",0);
	}
}
?>