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
	include_once(S_ROOT.'./source/function_t_sina.php');
	
	//���а� - ���ݵ���� �� ��/��/�� ��������
	$currentweek = getCurrentWeek();
	$dispyear = substr($currentweek, 0, 4);
	$dispmonth = substr($currentweek, 4, 2);
	$dispweek = substr($currentweek, 6, 2);
	
	//��XX�ܷ��������а���ʾ�ڵ�ǰ��Ȼ�ܵĹ㲥���������ߵ�8����Ʒ��
	$topic_view_weekly_sql = "SELECT SUM(tsw.viewnum) as dispnum, t.* FROM ".tname('topic')." t, ".tname('topic_static_weekly')." tsw ";
	$topic_view_weekly_sql .= " WHERE t.topicid=tsw.topicid and tsw.week LIKE '".$dispyear."__".$dispweek."' AND t.type='single' and t.auditstate=2 AND t.protalforbidden=0 ";
	$topic_view_weekly_sql .= " GROUP BY tsw.topicid ";
	$topic_view_weekly_sql .= " ORDER BY SUM(tsw.viewnum) DESC LIMIT 0,5";
	$topic_view_weekly_list = querytopic($topic_view_weekly_sql);
	
	$message = "��".$dispweek."�ܵ�������а� ϣ������ܹ�ϲ��~ ";
	$index=1;
	$topitem = null;
	foreach($topic_view_weekly_list as $value){
		if($index==1){
			$topitem = $value;
		}
		$str = $index . $value[subject] . " " . $value[productclasstype] . " http://www.echodrama.com/space.php?do=topic&topicid=" . $value[topicid] . " "; 
		$message .= $str;
		$index++;
	}

	$fileopen = fopen("c:/topcirank.log","a+");
	fwrite($fileopen,$message);
	fclose($fileopen);
		
	sendtopicmessagetosina($message);
	
	$topicrecommand = Array();
	$topicrecommand['topicid'] = $topitem['topicid'];
	$topicrecommand['startdate'] = $_SGLOBAL['timestamp'];
	inserttable("topic_recommand", $topicrecommand);
}
?>