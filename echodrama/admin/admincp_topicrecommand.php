<?php
/*
 [UCenter Home] (C) 2007-2008 Comsenz Inc.
 $Id: admincp_blog.php 9233 2008-10-28 06:21:44Z liguode $
 */

if(!defined('IN_UCHOME') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$topicrecommandid = empty($_GET['topicrecommandid'])?0:intval($_GET['topicrecommandid']);
$_GET['op'] = empty($_GET['op'])?'manage':$_GET['op'];

//权限
if(!checkperm('managetopic')) {
	cpmessage('no_authority_management_operation');
}
include_once(S_ROOT.'./source/function_topic.php');

if($_GET['op'] == 'save') {

	submitcheck('topicsubmit');

	// 检查权限
	//		if(!$allowmanage){
	//			showmessage("no_privilege_edit_event");
	//		}

	if($topicrecommandid==null){
		// 新广播剧
		$topicrecommand = Array();
	}
	else{
		$topicrecommand = loadcommandbyid($topicrecommandid);
		//广播剧推荐不存在
		if(empty($topicrecommand)) {
			showmessage('topic_recommand_does_not_exist');
		}
	}
	
	$topicrecommand['topicid'] = $_GET['topicid'];
	$topicrecommand['startdate'] = sstrtotime($_GET['startdate']);

	//检查输入
	if(empty($topicrecommand['topicid'])){
		showmessage('topic_recommand_topic_empty');
	} elseif(empty($topicrecommand['startdate'])){
		showmessage('topic_recommand_startdate_empty');
	}


	$qsql="SELECT t.* FROM ".tname("topic")." t WHERE t.auditstate=2 and t.topicid=$topicrecommand[topicid]";
	$list=querytopic($qsql);
	//广播剧不存在
	if(empty($list)) {
		showmessage('topic_does_not_exist');
	}

	if($topicrecommandid==null){
		inserttable("topic_recommand", $topicrecommand);
	}else{
		updatetable('topic_recommand', $topicrecommand, array('topicrecommandid'=>$topicrecommandid));
	}
	showmessage('do_success', "admincp.php?ac=topicrecommand", 0);

} elseif($_GET['op'] == 'delete') {

	submitcheck('topicsubmit');

	// 检查权限
	//		if(!$allowmanage){
	//			showmessage("no_privilege_edit_event");
	//		}

	if( empty($topicrecommandid) ){
		showmessage('topic_recommand_does_not_exist');
	}
	
	$topicrecommand = loadtopicrecommandbyid($topicrecommandid);
	if(empty($topicrecommand)) {
		showmessage('topic_recommand_does_not_exist');
	}
	
	$sql="DELETE FROM ".tname('topic_recommand')." WHERE topicrecommandid=$topicrecommandid";
	$_SGLOBAL['db']->query($sql);
	
	showmessage('do_success', "admincp.php?ac=topicrecommand", 0);

} 
elseif($_GET['op'] == 'createtopicrank') {

	submitcheck('topicsubmit');
	
	$_GET['subop'] = empty($_GET['subop'])?'loginsina':$_GET['subop'];
	
	$sina = array();
	$sina['oauth_token'] = empty($_GET['oauth_token'])?$_POST['oauth_token']:$_GET['oauth_token'];
	$sina['oauth_token_secret'] = empty($_GET['oauth_token_secret'])?$_POST['oauth_token_secret']:$_GET['oauth_token_secret'];
	$sina['oauth_verifier'] = empty($_GET['oauth_verifier'])?$_POST['oauth_verifier']:$_GET['oauth_verifier'];
	$sina['lastkey_oauth_token'] = empty($_GET['lastkey_oauth_token'])?$_POST['lastkey_oauth_token']:$_GET['lastkey_oauth_token'];
	$sina['lastkey_oauth_token_secret'] = empty($_GET['lastkey_oauth_token_secret'])?$_POST['lastkey_oauth_token_secret']:$_GET['lastkey_oauth_token_secret'];
	
	if($_GET['subop'] == 'loginsina') {
		include_once(S_ROOT.'./source/function_t_sina_oauth.php');
		
		$sina = connecttosina("admincp.php?ac=topicrecommand&op=createtopicrank&subop=tocreatetopicrank");
	}
	else if($_GET['subop'] == 'tocreatetopicrank') {
		include_once(S_ROOT.'./source/function_t_sina_oauth.php');
		include_once(S_ROOT.'./source/function_topic.php');
	
	
		$currentweek = getCurrentWeek();
		$dispyear = substr($currentweek, 0, 4);
		$dispmonth = substr($currentweek, 4, 2);
		$dispweek = substr($currentweek, 6, 2);

		$topicStaticWeeklyTableName = tname("topic_static_weekly_".$dispyear);
	
		//XX周访问量排行榜：显示在当前周的广播剧访问量最高的8部作品。
		$topic_view_weekly_sql = "SELECT SUM(tsw.viewnum) as dispnum, t.* FROM ".tname('topic')." t, $topicStaticWeeklyTableName tsw ";
	
		if( $dispmonth == 12 && $dispweek == 52 ){
			// 20111252 + 20120152
			$topic_view_weekly_sql .= " WHERE t.topicid=tsw.topicid and (tsw.week LIKE '".$dispyear."1252' OR tsw.week LIKE '". ($dispyear+1) ."0152') AND t.type='single' and t.auditstate=2 AND t.protalforbidden=0 ";
		}
		else if( $dispmonth == 1 && $dispweek == 52 ){
			// 20120152 + 20111252
			$topic_view_weekly_sql .= " WHERE t.topicid=tsw.topicid and (tsw.week LIKE '".$dispyear."0152' OR tsw.week LIKE '". ($dispyear-1) ."1252') AND t.type='single' and t.auditstate=2 AND t.protalforbidden=0 ";
		}
		else{
			$topic_view_weekly_sql .= " WHERE t.topicid=tsw.topicid and tsw.week LIKE '".$dispyear."__".$dispweek."' AND t.type='single' and t.auditstate=2 AND t.protalforbidden=0 ";
		}

		$topic_view_weekly_sql .= " GROUP BY tsw.topicid ";
		$topic_view_weekly_sql .= " ORDER BY SUM(tsw.viewnum) DESC LIMIT 0,5";
		$topic_view_weekly_list = querytopic($topic_view_weekly_sql);
	
		
		$message = "第".$dispweek."周点击量排行榜 希望大家能够喜欢~ ";
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

		$weibo_message = $message;
		$topic = $topitem;
		
		$topicrecommand = Array();
		$topicrecommand['topicid'] = $topitem[topicid];
		$topicrecommand['startdate'] = $_SGLOBAL['timestamp'];
		inserttable("topic_recommand", $topicrecommand);
		
		$sina = confirmstatus($sina);
	}
	else if($_GET['subop'] == 'createtopicrank') {
		include_once(S_ROOT.'./source/function_t_sina_oauth.php');
		
		$sina['weibo_message'] = $_POST['weibo_message'];
		sendtopicmessagetosina($sina);
		
		showmessage('do_success', "admincp.php?ac=topicrecommand", 0);
	}
} 
elseif($_GET['op'] == 'manage') {
	// 搜索

	//list

	//处理搜索
	include_once(S_ROOT.'./source/function_admincp.php');

	$qsql="SELECT tr.topicrecommandid, tr.startdate, t.* FROM ".tname("topic")." t, ".tname("topic_recommand")." tr WHERE t.topicid=tr.topicid order by tr.startdate";

	$list=queryrecommand($qsql);
}

?>