<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_feed.php 12432 2009-06-25 07:31:34Z xupeng $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}
$MODULE_NAME = "SPACE_TOPIC";

$topicid = empty($_GET['topicid'])?0:intval($_GET['topicid']);
$topicforecastid = empty($_GET['topicforecastid'])?0:intval($_GET['topicforecastid']);
$_GET['view'] = empty($_GET['view']) ? "single" : $_GET['view'];
$view = $_GET['view'];

$page = empty($_GET['page'])?1:intval($_GET['page']);
if($page<1) $page = 1;

$perpage = empty($_GET['perpage'])?10:intval($_GET['perpage']);
$start = ($page-1)*$perpage;
include_once(S_ROOT.'./data/data_productclass.php');
include_once(S_ROOT.'./data/data_topicauditclass.php');
include_once(S_ROOT.'./source/function_topic.php');
		
if(empty($topicid) && empty($topicforecastid)) {
	//list
	
	//��������
	include_once(S_ROOT.'./source/function_admincp.php');
		
	$mpurl="space.php?do=topic&uid=$uid";
	$list = array();
	$multi = '';
	
	$intkeys = array('productclassid');
	$strkeys = array();
	//TODO ���ڲ�ѯ������
	$randkeys = array(array('sstrtotime','producedate'), array('intval','viewnum'), array('intval','replynum'), array('intval','hot'));
	$likekeys = array('subject','club','director','cehua', 'writer','cast','producer','effector','photographer','propagandizer');
	$results = getwheres($intkeys, $strkeys, $randkeys, $likekeys, 't.');
	$wherearr = $results['wherearr'];
	$wheresql = empty($wherearr)?'1':implode(' AND ', $wherearr);
	
	
	$page = empty($_GET['page'])?1:intval($_GET['page']);
	if($page<1) $page = 1;
	$start = ($page-1)*$perpage;
	//��鿪ʼ��
	ckstart($start, $perpage);
	
	$mpurl .= '&'.implode('&', $results['urls']);
	$mpurl .= '&perpage='.$perpage;
	$mpurl .= '&view='.$view;
	
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
	
	if($view == 'me') {
		//�ҷ����Ĺ㲥��
		$csql = "SELECT COUNT(*) AS count FROM ".tname('topic')." t WHERE t.type='single' and t.uid='$_SGLOBAL[supe_uid]' and t.auditstate<2 and $wheresql";
		$qsql = "SELECT * FROM ".tname('topic')." t WHERE t.type='single' and t.uid='$_SGLOBAL[supe_uid]' and t.auditstate<2 and $wheresql $orderbysql LIMIT $start,$perpage";
	} 
	else if($view == 'single') {
		//������˹��Ĺ㲥��
		$csql = "SELECT COUNT(*) AS count FROM ".tname('topic')." t WHERE t.type='single' and t.auditstate=2 and $wheresql";
		$qsql = "SELECT * FROM ".tname('topic')." t WHERE t.type='single' and t.auditstate=2 and $wheresql $orderbysql LIMIT $start,$perpage";
	} 
	else if($view == 'album') {
		//����ר��
		$csql = "SELECT COUNT(*) AS count FROM ".tname('topic')." t WHERE ( t.type='album' OR (t.type='single' AND t.singtonalbum=1) ) and $wheresql";
		$qsql = "SELECT * FROM ".tname('topic')." t WHERE ( t.type='album' OR (t.type='single' AND t.singtonalbum=1) ) and $wheresql $orderbysql LIMIT $start,$perpage";
	} 
	else if($view == 'forecast') {
		//���й㲥��Ԥ�� ����wheresql
		$cutofftime = getCurrentDate() - 60*60;
		$csql = "SELECT COUNT(*) AS count FROM ".tname('topic_forecast')." tf WHERE tf.invalid = 0 AND tf.producedate>=$cutofftime ";
		$qsql = "SELECT * FROM ".tname('topic_forecast')." tf WHERE tf.invalid = 0 AND tf.producedate>=$cutofftime ORDER BY tf.producedate LIMIT $start,$perpage";
	} 
	else if($view == 'share') {
		//�ҵ��ղ�
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
		if($view == 'forecast'){
			$list=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "topicforecastlist", "querytopicforecast", array($qsql), $page == 1?60:1800);
		}
		else{
			$list=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "topiclist", "querytopic", array($qsql), $page == 1?60:1800);
		}
		
		//��ʾ��ҳ
		$multi = multi($count, $perpage, $page, $mpurl);
	}
	$actives = array($view => ' class="active"');
	
	realname_get();
	
	//�㲥���ǩ
	$topiclabel_hot_sql="SELECT tl.label AS label, count(tl.id) AS num FROM ".tname('topiclabel')." tl WHERE 1=1 GROUP BY tl.label ORDER BY num desc LIMIT 0,18";
	$topiclabel_hot_list=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "topiclabelhotlist", "querytopiclabel", array($topiclabel_hot_sql), 86400);

	//�㲥��-Ӧ�����Ƽ�
	$curofftime = getCurrentDate() - 2592000; //���1�����������ľ�
	$popuplistsql= "SELECT t.* FROM ".tname('topic')." t WHERE t.auditstate=2 and dateline > $curofftime order by t.replynum desc LIMIT 0,8";
	$popuptopiclist=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "popuptopiclist", "querytopic", array($popuplistsql), 86400);
	
	$_TPL['css'] = 'topic';
	$searchengine_description='�㲥���б�';
	if(!empty($list)){
		foreach($list as $value) {
			$searchengine_description.=$value['subject'].",";
		}
	}
	$nav_list = array();
	$nav_item = array();
	$nav_item['url'] = "space.php?do=topic"; $nav_item['dispname'] = "�㲥�糡";
	$nav_list[] = $nav_item;
	
	$helplink_list = array();
	
	$helplink_item = array();
	$helplink_item['url'] = "space.php?do=thread&tid=463"; $helplink_item['dispname'] = "�㲥��Ԥ�����";
	$helplink_list[] = $helplink_item;
	
	$helplink_item = array();
	$helplink_item['url'] = "space.php?do=thread&tid=488"; $helplink_item['dispname'] = "�㲥���ϴ�ע������";
	$helplink_list[] = $helplink_item;
	
	if($view == 'me') {
		//�ҷ����Ĺ㲥��
		$nav_item = array();
		$nav_item['url'] = "space.php?do=topic&view=me"; $nav_item['dispname'] = "����˵Ĺ㲥��";
		$nav_list[] = $nav_item;
	} 
	else if($view == 'single') {
		//������˹��Ĺ㲥��
		$nav_item = array();
		$nav_item['url'] = "space.php?do=topic&view=single"; $nav_item['dispname'] = "�㲥���б�";
		$nav_list[] = $nav_item;
	} 
	else if($view == 'album') {
		//����ר��
		$nav_item = array();
		$nav_item['url'] = "space.php?do=topic&view=album"; $nav_item['dispname'] = "���ר���б�";
		$nav_list[] = $nav_item;
	
		$helplink_item = array();
		$helplink_item['url'] = "space.php?do=thread&tid=475"; $helplink_item['dispname'] = "���㲥������ ";
		$helplink_list[] = $helplink_item;
	} 
	else if($view == 'forecast') {
		//���й㲥��Ԥ�� ����wheresql
		$nav_item = array();
		$nav_item['url'] = "space.php?do=topic&view=forecast"; $nav_item['dispname'] = "�㲥��Ԥ���б�";
		$nav_list[] = $nav_item;
	} 
	else if($view == 'share') {
		//�ҵ��ղ�
		$nav_item = array();
		$nav_item['url'] = "space.php?do=topic&view=share"; $nav_item['dispname'] = "�ҵ��ղ��б�";
		$nav_list[] = $nav_item;
	}
	
	include_once template('space_topic_list');
} 
else if( !empty($topicid) ) {
	//view
	$topic=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "topic", "loadtopicbyid", array($topicid), 3600);
	$topicadditioninfo=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "topicadditioninfo", "querytopicadditioninfobytopic", array($topicid), 3600);
	
	//�㲥�粻����
	if(empty($topic)) {
		showmessage('topic_does_not_exist');
	}
	
	if($topic['type']=='single'){
		$topic=topicsingleformmapper($topic);
	}elseif($topic['type']=='album'){
		$topic=topicalbumformmapper($topic);
		$itemlist=loadalbumitemlist($topicid);
		$itemcount=count($itemlist);
	}
	
	$topic = topicmembersearchitemformmapper($topic);
	
	if( !empty($_SGLOBAL[supe_uid]) ) {
		//�Ƿ��ղ�
		$shareSql= "SELECT COUNT(*) FROM ".tname('topicuser')." tu WHERE tu.topicid=$topicid and tu.uid=$_SGLOBAL[supe_uid]";
		$inShare = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($shareSql), 0);
	
		//�Ƿ�������
		$userip=getonlineip(0);
		$topicpollsql= "SELECT * FROM ".tname('topicpoll')." tp WHERE tp.topicid=$topicid and ( tp.uid='$_SGLOBAL[supe_uid]' OR tp.userip='$userip' )";
		$query = $_SGLOBAL['db']->query($topicpollsql);
		$topicpoll = $_SGLOBAL['db']->fetch_array($query);
	
		//�㲥���ǩ - �����õı�ǩ
		$topiclabel_me_sql = "SELECT tl.label FROM ".tname('topiclabel')." tl WHERE tl.topicid='$topicid' AND uid='$_SGLOBAL[supe_uid]' ORDER BY tl.lastpost DESC";
		$topiclabel_me_list = querytopiclabel($topiclabel_me_sql);
	}

	if(!empty($topicadditioninfo) && ($topicadditioninfo[weiboflag]==1) ){
		$weibomessage = $topicadditioninfo[weibomsg];
	}else{
		$weibomessage = buildtopicmessage($topic, false);
	}
	
	
	//���ܸ���Ȥ�Ĺ㲥��
	$othertopicqsql="select t.* from ".tname('topic')." t, ".tname('topic_album')." ta ";
	$othertopicqsql.="where ta.topicid=t.topicid and ta.topicalbumid in ";
	$othertopicqsql.=" (select topicalbumid from ".tname('topic_album')." where topicid ='$topic[topicid]') ";
	$othertopicqsql.=" and ta.topicid != '$topic[topicid]'";
	$othertopicqsql.=" order by ta.index";
	$othertopiclist=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "othertopiclist", "querytopic", array($othertopicqsql), 86400);
	
	//�㲥���ǩ
	$topiclabel_list=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "topiclabellist", "loadtopiclabelbytopicid", array($topic[topicid]), 1800);
	
	$topiclabel_latest_sql = "SELECT tl.* FROM ".tname('topiclabel')." tl WHERE tl.topicid='$topicid' AND tl.uid>0 ORDER BY tl.lastpost DESC LIMIT 0, 10";
	$topiclabel_lastest_list=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "topiclabellastestlist", "querytopiclabel", array($topiclabel_latest_sql), 1800);
	
	//�����Դ
	$topicattachment_list=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "topicattachmentlist", "querytopicattachmentbytopicid", array($topic[topicid]), 1800);

	//Ϭ������
	$topicthread_list=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "topicthreadlist", "querytopicthreadbytopicid", array($topic[topicid]), 1800);
	
	//����
	$perpage = 30;
	$perpage = mob_perpage($perpage);
	$start = ($page-1)*$perpage;
	ckstart($start, $perpage);
	$commentlist = array();
	
	$csql = "SELECT count(*) AS count FROM ".tname('comment')." WHERE id=$topicid AND idtype='topicid'";
	$count = $_SGLOBAL['db']->cachequery($MODULE_NAME, $csql, true);
	$count = $count['count'];
	
	$topic['replynum']=$count;
		 
	if($count>0){
		$qsql = "SELECT * FROM ".tname('comment')." WHERE id=$topicid AND idtype='topicid' ORDER BY dateline LIMIT $start,$perpage";
		$commentlist = $_SGLOBAL['db']->cachequery($MODULE_NAME, $qsql, false, $page == intval( ($count-1)/$perpage )+1?0:1800);

		//��ҳ
		$multi = multi($count, $perpage, $page, "space.php?do=$do&topicid=$topicid", '', 'content');
	}
	

	//����ͳ��
	if( ($topic['topicid']!=$_SCOOKIE['view_topicid']) ) {
		ssetcookie('view_topicid', $topic['topicid']);
		
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
	}


	$sub_actives = array($_GET['view'] => ' style="font-weight:bold;"');
	$_TPL['css'] = 'topic';
	$searchengine_description = $weibomessage;
	$userdefined_headertitle = $weibomessage;
	
	$nav_list = array();
	$nav_item = array();
	$nav_item['url'] = "space.php?do=topic"; $nav_item['dispname'] = "�㲥�糡";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	if($topic['type']=='single'){
		$nav_item['url'] = "space.php?do=topic&view=single"; $nav_item['dispname'] = "�㲥���б�";
	}
	elseif($topic['type']=='album'){
		$nav_item['url'] = "space.php?do=topic&view=album"; $nav_item['dispname'] = "���ר���б�";
	} 
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "space.php?do=topic&topicid=$topic[topicid]"; $nav_item['dispname'] = "$topic[subject]";
	$nav_list[] = $nav_item;
	
	include_once template("space_topic_view");
}
else if( !empty($topicforecastid) ) {
	//view
	$topicforecast=loadtopicforecastbyid($topicforecastid);
	//�㲥��Ԥ�治����
	if(empty($topicforecast)) {
		showmessage('topicforecast_does_not_exist');
	}
	
	$topicforecast=topicforecastformmapper($topicforecast);
	
	if( !empty($_SGLOBAL[supe_uid]) ) {
		//��ע״̬
		$tfuSql = "SELECT COUNT(id) FROM ".tname('topic_forecast_user')." WHERE topicforecastid=$topicforecastid and uid=$_SGLOBAL[supe_uid]";
		$joinedflag = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($tfuSql), 0);
	}
	
	//����
	$perpage = 30;
	$perpage = mob_perpage($perpage);
	$start = ($page-1)*$perpage;
	ckstart($start, $perpage);
	$commentlist = array();
	
	$csql = "SELECT count(*) FROM ".tname('comment')." WHERE id=$topicforecastid AND idtype='topicforecastid'";
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($csql), 0);
	$topicforecast['replynum']=$count;
		 
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('comment')." WHERE id=$topicforecastid AND idtype='topicforecastid' ORDER BY dateline LIMIT $start,$perpage");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		realname_set($value['authorid'], $value['author']);//ʵ��
		$commentlist[] = $value;
	}
	
	//��ҳ
	$multi = multi($count, $perpage, $page, "space.php?do=$do&topicforecastid=$topicforecastid", '', 'content');

	//����ͳ��
	if( ($topicforecast['topicforecastid']!=$_SCOOKIE['view_topicforecastid']) ) {
		ssetcookie('view_topicforecastid', $topicforecast['topicforecastid']);
		
		$_SGLOBAL['db']->query("UPDATE ".tname('topic_forecast')." SET viewnum=viewnum+1 WHERE topicforecastid='$topicforecast[topicforecastid]'");
	}


	$sub_actives = array($_GET['view'] => ' style="font-weight:bold;"');
	$_TPL['css'] = 'topic';
	$searchengine_description=$topicforecast['typename'].":".$topicforecast['subject'].",".$topicforecast['productclassname'].",��".$topicforecast['club']."����,CAST:".$topicforecast['cast'].",STAFF:".$topicforecast['group'];
	

	$nav_list = array();
	$nav_item = array();
	$nav_item['url'] = "space.php?do=topic"; $nav_item['dispname'] = "�㲥�糡";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "space.php?do=topic&view=single"; $nav_item['dispname'] = "�㲥��Ԥ���б�";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "space.php?do=topic&topicforecastid=$topicforecast[topicforecastid]"; $nav_item['dispname'] = "$topicforecast[subject]";
	$nav_list[] = $nav_item;

	$searchengine_description=$topicforecast['typename'].":".$topicforecast['subject'].",".$topicforecast['productclassname'].",��".$topicforecast['club']."����,CAST:".$topicforecast['cast'].",STAFF:".$topicforecast['group'];
	include_once template("space_topicforecast_view");
}
?>