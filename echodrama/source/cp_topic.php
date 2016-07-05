<?php
/*
 [UCenter Home] (C) 2007-2008 Comsenz Inc.
 $Id: cp_topic.php 12436 2009-06-25 09:07:38Z liguode $
 */

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

$MODULE_NAME = "SPACE_TOPIC";

//检查信息
$topicid = empty($_GET['topicid'])?0:intval($_GET['topicid']);
$topicforecastid = empty($_GET['topicforecastid'])?0:intval($_GET['topicforecastid']);
$op = empty($_GET['op'])?'':$_GET['op'];

include_once(S_ROOT.'./data/data_productclass.php');
include_once(S_ROOT.'./data/data_topicauditclass.php');
include_once(S_ROOT.'./source/function_topic.php');
include_once(S_ROOT.'./source/function_cp.php');

if($_GET['op'] == 'newforecast') {
	$topicforecast=array();
	
	$nav_list = array();
	$nav_item = array();
	$nav_item['url'] = "space.php?do=topic"; $nav_item['dispname'] = "广播剧场";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "space.php?do=topic&view=forecast"; $nav_item['dispname'] = "广播剧预告列表";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "cp.php?ac=topic&op=new"; $nav_item['dispname'] = "提交广播剧预告";
	$nav_list[] = $nav_item;

	$helplink_list = array();
	$helplink_item = array();
	$helplink_item['url'] = "space.php?do=thread&tid=463"; $helplink_item['dispname'] = "广播剧预告帮助";
	$helplink_list[] = $helplink_item;
	
	include_once template("cp_topicforecast");
}
elseif($_GET['op'] == 'editforecast') {
	
	submitcheck('topicsubmit');
	
	if(empty($topicforecastid)) {
		showmessage("topicforecast_does_not_exist"); // 广播剧预告不存在或者已被删除
	}
	
	$topicforecast = loadtopicforecastbyid($topicforecastid);
	if(empty($topicforecast)) {
		showmessage("topicforecast_does_not_exist"); // 广播剧预告不存在或者已被删除
	}
	
	$topicforecast = topicforecastformmapper($topicforecast);
	
	if($topicforecast['uid'] != $_SGLOBAL['supe_uid']){
		showmessage('no_privilege');// 您目前没有权限进行此操作
	}
	
	$nav_list = array();
	$nav_item = array();
	$nav_item['url'] = "space.php?do=topic"; $nav_item['dispname'] = "广播剧场";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "space.php?do=topic&view=forecast"; $nav_item['dispname'] = "广播剧预告列表";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "cp.php?ac=topic&op=editforecast&topicforecastid=$topicforecast[topicforecastid]"; $nav_item['dispname'] = "编辑广播剧预告";
	$nav_list[] = $nav_item;
	
	$helplink_list = array();
	$helplink_item = array();
	$helplink_item['url'] = "space.php?do=thread&tid=463"; $helplink_item['dispname'] = "广播剧预告帮助";
	$helplink_list[] = $helplink_item;
	
	include_once template("cp_topicforecast");
}
else if($_GET['op'] == 'saveforecast') {

	submitcheck('topicsubmit');
	
	if(empty($_SGLOBAL['supe_uid'])){
		showmessage('no_privilege');// 您目前没有权限进行此操作
	}
	
	if( empty($topicforecastid) ) {
		$topicforecast=array();
		$topicforecast['topicforecastid'] = null;
		$topicforecast['uid'] = $_SGLOBAL['supe_uid'];
		$topicforecast['username'] = $_SGLOBAL['supe_username'];
		$topicforecast['dateline'] = $_SGLOBAL['timestamp'];
	}
	else{
		$topicforecast=loadtopicforecastbyid($topicforecastid);
		//广播剧预告不存在
		if(empty($topicforecast)) {
			showmessage('topicforecast_does_not_exist');
		}

		if($topicforecast['uid'] != $_SGLOBAL['supe_uid']){
			showmessage('no_privilege');// 您目前没有权限进行此操作
		}
	}
		
	$topicforecast['subject'] = $_POST['subject'];
	$topicforecast['label'] = $_POST['label'];
	$topicforecast['message'] = $_POST['message'];
	$topicforecast['productclassid'] = $_POST['productclassid'];
	$topicforecast['club'] = $_POST['club'];
	$topicforecast['clubtagid'] = $_POST['clubtagid'];
	$topicforecast['director'] = $_POST['director'];
	$topicforecast['producer'] = $_POST['producer'];
	$topicforecast['cehua'] = $_POST['cehua'];
	$topicforecast['yuanzhu'] = $_POST['yuanzhu'];
	$topicforecast['writer'] = $_POST['writer'];
	$topicforecast['cast'] = $_POST['cast'];
	$topicforecast['effector'] = $_POST['effector'];
	$topicforecast['photographer'] = $_POST['photographer'];
	$topicforecast['producedate'] = sstrtotime($_POST['producedate']);
	$topicforecast['lastpost'] = $_SGLOBAL['timestamp'];

	//检查输入
	if(empty($topicforecast['uid'])){
		showmessage('topic_uid_empty');
	} elseif(empty($topicforecast['username'])){
		showmessage('topic_username_empty');
	} elseif(empty($topicforecast['subject'])) {
		showmessage('topic_subject_empty');
	} elseif(empty($topicforecast['message'])) {
		showmessage('topic_message_empty');
	} elseif(empty($topicforecast['productclassid'])) {
		showmessage('topic_productclassid_empty');
	} elseif(empty($topicforecast['club'])) {
		showmessage('topic_club_empty');
	}
	
	if( empty($topicforecastid) ) {
		inserttable("topic_forecast", $topicforecast);
		
		//发送通知给管理员
		$adminusersql="SELECT s.uid FROM ysys_space s WHERE 1=1 AND s.groupid=1 ORDER BY s.uid";
		$query = $_SGLOBAL['db']->query($adminusersql);
		$list=array();
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			notification_add($value[uid],"topicforecast_confirm","有新的广播剧预告发布： $topicforecast[subject] ",0);
		}
		
		//消耗积分200 并发送消息给上传者
		updatetopicreward($_SGLOBAL['supe_uid'], 'topicforecast_new');
		
		$topicforecast[producedatedisp] = $topicforecast['producedate']?sgmdate('Y-m-d', $topicforecast['producedate']):'';
		notification_add($_SGLOBAL['supe_uid'],"topicforecast_confirm","请于$topicforecast[producedatedisp] 按时发布该剧： $topicforecast[subject] ",0);
	}
	else{
		updatetable('topic_forecast', $topicforecast, array('topicforecastid'=>$topicforecastid));
	}
	
	showmessage('do_success', "space.php?do=topic&view=forecast", 0);
}
else if($_GET['op'] == 'deleteforecast') {
	//删除广播剧预告
	if(deletetopicforecasts(array($topicforecastid))) {
		showmessage('do_success', "space.php?do=topic&view=forecast", 0);
	} else {
		showmessage('failed_to_delete_operation');
	}
}
elseif($_GET['op'] == 'jointopicforecast') {
	if(empty($topicforecastid)) {
		showmessage("topicforecast_does_not_exist"); 
	}
	
	$topicforecast=loadtopicforecastbyid($topicforecastid);
	//广播剧预告不存在
	if(empty($topicforecast)) {
		showmessage('topicforecast_does_not_exist');
	}
	
	$topicforecast = topicforecastformmapper($topicforecast);
	
	//AJAX CALL
	$_SGLOBAL['jointopicforecast'] = 1;
	
	if($_GET['tojoin']==0){
		//取消关注
		$tfuSql = "DELETE FROM ".tname('topic_forecast_user')." WHERE topicforecastid=$topicforecastid and uid=$_SGLOBAL[supe_uid]";
		$_SGLOBAL['db']->query($tfuSql);
	}
	else if($_GET['tojoin']==1){
		//加入关注
		$tfuSql = "SELECT COUNT(id) FROM ".tname('topic_forecast_user')." WHERE topicforecastid=$topicforecastid and uid=$_SGLOBAL[supe_uid]";
		$tfuCount = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($tfuSql), 0);
		if($tfuCount<=0){
			$topicforecastuser = Array();
			$topicforecastuser['id'] = null;
			$topicforecastuser['uid'] = $_SGLOBAL['supe_uid'];
			$topicforecastuser['topicforecastid'] = $topicforecastid;
			$topicforecastuser['username'] = $_SGLOBAL['supe_username'];
			$topicforecastuser['dateline'] = $_SGLOBAL['timestamp'];
			inserttable("topic_forecast_user", $topicforecastuser);
		}
	}
	else{
		showMessage("no action");	
	}
	
	$update_join_sql="UPDATE ".tname('topic_forecast')." SET joinnum = (SELECT COUNT(id) FROM ".tname('topic_forecast_user')." WHERE topicforecastid=$topicforecastid ) where topicforecastid=$topicforecastid";
	$_SGLOBAL['db']->query($update_join_sql);

	showmessage('ajax_param', '', 0, array($topicforecast['topicforecastid'], $topicforecast['subject'], $topicforecast['producedatedisp']));
}
elseif($_GET['op'] == 'viewtopicforcastjoin') {
	if(empty($topicforecastid)) {
		showmessage("topicforecast_does_not_exist"); 
	}
	
	$topicforecast=loadtopicforecastbyid($topicforecastid);
	//广播剧预告不存在
	if(empty($topicforecast)) {
		showmessage('topicforecast_does_not_exist');
	}
	
	//AJAX CALL
	$_SGLOBAL['jointopicforecast'] = 1;
	
	//关注状态
	$tfuSql = "SELECT COUNT(id) FROM ".tname('topic_forecast_user')." WHERE topicforecastid=$topicforecastid and uid=$_SGLOBAL[supe_uid]";
	$joinedflag = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($tfuSql), 0);
	
	include_once template("space_topicforecast_join");
	
}
elseif($op == 'topicforecastcalendar') {//任务列表日历

	$match = array();
	if(!$_GET['month'] && preg_match("/^(\d{4}-\d{1,2})/", $_GET['date'], $match)) {
		$_GET['month'] = $match[1];
	}
	if(preg_match("/^(\d{4})-(\d{1,2})$/", $_GET['month'], $match)){
		$year = intval($match[1]);
		$month = intval($match[2]);
	} else {
		$year = intval(sgmdate("Y"));
		$month = intval(sgmdate("m"));
	}
	if($month==12) {
		$nextmonth = ($year + 1)."-"."1";
		$premonth = $year."-11";
	} elseif ($month==1) {
		$nextmonth = $year."-2";
		$premonth = ($year-1)."-12";
	} else {
		$nextmonth = $year."-".($month+1);
		$premonth = $year."-".($month-1);
	}

	$daystart = mktime(0,0,0,$month,1,$year);
	$datestr = sgmdate('Y-m-d', $daystart);
	$daystart = sstrtotime($datestr);
	
	$week = sgmdate("w",$daystart);//本月第一天是周几: 0-6
	$dayscount = sgmdate("t",$daystart);//本月天数
	$dayend = mktime(0,0,$dayscount,$month,$dayscount,$year);
	$datestr = sgmdate('Y-m-d', $dayend);
	$dayend = sstrtotime($datestr);
	
	$days = array();
	for($i=1; $i<=$dayscount; $i++) {
		$days[$i] = array("count"=>0, "topicforecasts"=>array(), "class"=>'');
	}

	$wheresql="";

	//本月任务
	$topicforecasts = array();
	
	$qsql = "SELECT tf.* FROM ".tname("topic_forecast")." tf WHERE tf.invalid = 0 AND tf.producedate <= $dayend AND tf.producedate >= $daystart $wheresql ORDER BY tf.producedate";
	$query = $_SGLOBAL['db']->query( $qsql );
	while($value=$_SGLOBAL['db']->fetch_array($query)) {
		$value = topicforecastformmapper($value);
		$day = intval(sgmdate('d', $value['producedate']));
		
		$days[$day]['topicforecasts'][] = $value;
		$days[$day]['count'] += 1;
		$days[$day]['class'] = " on_link";
	}
	unset($topicforecasts);

	if($month == intval(sgmdate("m")) && $year == intval(sgmdate("Y"))) {
		$d = intval(sgmdate("j"));
		$days[$d]['class'] = "on_today";
	}

	if($_GET['date']) {
		$t = sstrtotime($_GET['date']);
		if($month == intval(sgmdate("m",$t)) && $year == intval(sgmdate("Y",$t))) {
			$d = intval(sgmdate("j",$t));
			$days[$d]['class'] = "on_select";
		}
	}

	//链接
	$url = $_GET['url'] ? preg_replace("/date=[\d\-]+/", '', $_GET['url']) : "space.php?do=topic&view=forecast";
	include_once template("cp_topicforecast_calendar_ajax");
}
elseif($_GET['op'] == 'newfromforecast') {
	$topicforecast=loadtopicforecastbyid($topicforecastid);
	//广播剧预告不存在
	if(empty($topicforecast)) {
		showmessage('topicforecast_does_not_exist');
	}
	
	$topicforecast = topicforecastformmapper($topicforecast);
	
	$topic=array();
	$topic['type']='single';
	$topic['uid'] = $_SGLOBAL['supe_uid'];
	$topic['username'] = $_SGLOBAL['supe_username'];
	$topic['dateline'] = $_SGLOBAL['timestamp'];
	$topic['lastpost'] = $_SGLOBAL['timestamp'];
	//广播剧属性复制
	$topic['subject'] = $topicforecast['subject'];
	$topic['label'] = $topicforecast['label'];
	$topic['message'] = $topicforecast['message'];
	$topic['productclassid'] = $topicforecast['productclassid'];
	$topic['club'] = $topicforecast['club'];
	$topic['clubtagid'] = $topicforecast['clubtagid'];
	$topic['director'] = $topicforecast['director'];
	$topic['producer'] = $topicforecast['producer'];
	$topic['cehua'] = $topicforecast['cehua'];
	$topic['yuanzhu'] = $topicforecast['yuanzhu'];
	$topic['writer'] = $topicforecast['writer'];
	$topic['cast'] = $topicforecast['cast'];
	$topic['effector'] = $topicforecast['effector'];
	$topic['photographer'] = $topicforecast['photographer'];
	$topic['producedate'] = $topicforecast['producedatedisp'];
	
	include_once template("cp_topic");
}
elseif($_GET['op'] == 'new') {
	$topic=array();
	$topic['type']='single';
	$topicadditioninfo = array();
	
	$nav_list = array();
	$nav_item = array();
	$nav_item['url'] = "space.php?do=topic"; $nav_item['dispname'] = "广播剧场";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "space.php?do=topic&view=forecast"; $nav_item['dispname'] = "广播剧列表";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "cp.php?ac=topic&&op=new"; $nav_item['dispname'] = "提交新广播剧";
	$nav_list[] = $nav_item;
	
	$helplink_list = array();
	$helplink_item = array();
	$helplink_item['url'] = "space.php?do=thread&tid=488"; $helplink_item['dispname'] = "广播剧上传注意事项";
	$helplink_list[] = $helplink_item;
	
	include_once template("cp_topic");
}
elseif($_GET['op'] == 'edit') {
	
	submitcheck('topicsubmit');
	
	if(empty($topicid)) {
		showmessage("topic_does_not_exist"); // 广播剧不存在或者已被删除
	}
	
	$topic=topicsingleformmapper(loadtopicsinglebyid($topicid));
	//广播剧不存在
	if(empty($topic)) {
		showmessage('topic_does_not_exist');
	}
	
	if($topic['auditstate']==2){
		showmessage('topic_under_verify');// 此广播剧已被审核
	}
	
	if($topic['uid'] != $_SGLOBAL['supe_uid']){
		showmessage('no_privilege');// 您目前没有权限进行此操作
	}

	$topicadditioninfo = querytopicadditioninfobytopic($topicid);
	
	$nav_list = array();
	$nav_item = array();
	$nav_item['url'] = "space.php?do=topic"; $nav_item['dispname'] = "广播剧场";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "space.php?do=topic&view=forecast"; $nav_item['dispname'] = "广播剧列表";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "cp.php?ac=topic&op=edit&topicid=$topic[topicid]"; $nav_item['dispname'] = "编辑广播剧";
	$nav_list[] = $nav_item;
	
	$helplink_list = array();
	$helplink_item = array();
	$helplink_item['url'] = "space.php?do=thread&tid=488"; $helplink_item['dispname'] = "广播剧上传注意事项";
	$helplink_list[] = $helplink_item;
	
	include_once template("cp_topic");
}
else if($_GET['op'] == 'save') {

	submitcheck('topicsubmit');
	
	if($topicid<=0) {
		$topicid=array();
		$topic['topicid'] = null;
		$topic['uid'] = $_SGLOBAL['supe_uid'];
		$topic['username'] = $_SGLOBAL['supe_username'];
		$topic['dateline'] = $_SGLOBAL['timestamp'];
		$topic['type'] = $_POST['type'];
		$topic['pic'] = $_FILES['pic'];
		$topic['product'] = $_POST['product'];

		$topicadditioninfo = array();
	}
	else{
		$topic=loadtopicbyid($topicid);
		//广播剧不存在
		if(empty($topic)) {
			showmessage('topic_does_not_exist');
		}

		if($topic['auditstate']==2){
			showmessage('topic_under_verify');// 此广播剧已被审核
		}
		
		if($topic['uid'] != $_SGLOBAL['supe_uid']){
			showmessage('no_privilege');// 您目前没有权限进行此操作
		}

		$topicadditioninfo = querytopicadditioninfobytopic($topicid);
	}

	$topic['singtonalbum'] = 0;
	$topic['label'] = $_POST['label'];
	
	$topic['audiotype'] = $_POST['audiotype'];
	$topic['audioplayerpathtype'] = $_POST['audioplayerpathtype'];
	$topic['audioplayerpath_tudou'] = $_POST['audioplayerpath_tudou'];
	$topic['audiodownloadpathtype'] = $_POST['audiodownloadpathtype'];
	$topic['audiodownloadpath_rayfile'] = $_POST['audiodownloadpath_rayfile'];
	$topic['audiodownloadpath_115'] = $_POST['audiodownloadpath_115'];
	$topic['audiodownloadpath_zhongzhuan'] = $_POST['audiodownloadpath_zhongzhuan'];
	
	$topic['subject'] = $_POST['subject'];
	$topic['productclassid'] = $_POST['productclassid'];
	$topic['club'] = $_POST['club'];
	$topic['clubtagid'] = $_POST['clubtagid'];
	$topic['director'] = $_POST['director'];
	$topic['producer'] = $_POST['producer'];
	$topic['cehua'] = $_POST['cehua'];
	$topic['yuanzhu'] = $_POST['yuanzhu'];
	$topic['writer'] = $_POST['writer'];
	$topic['cast'] = $_POST['cast'];
	$topic['effector'] = $_POST['effector'];
	$topic['photographer'] = $_POST['photographer'];
	$topic['propagandizer'] = $_POST['propagandizer'];
	$topic['producedate'] = sstrtotime($_POST['producedate']);
	$topic['lastpost'] = $_SGLOBAL['timestamp'];

	$topicadditioninfo['message'] = $_POST['message'];
	$topicadditioninfo['weiboflag'] = $_POST['weiboflag'];
	if( $_POST['weiboflag']==1 ){
		$topicadditioninfo['weibomsg'] = $_POST['weibomsg'];
	}else{
		$topicadditioninfo['weibomsg'] = "";
	}
	
	//检查输入
	if(empty($topic['uid'])){
		showmessage('topic_uid_empty');
	} elseif(empty($topic['username'])){
		showmessage('topic_username_empty');
	} elseif(empty($topic['subject'])) {
		showmessage('topic_subject_empty');
	} elseif(empty($topicadditioninfo['message'])) {
		showmessage('topic_message_empty');
	} elseif(empty($topic['productclassid'])) {
		showmessage('topic_productclassid_empty');
	} elseif(empty($topic['club'])) {
		showmessage('topic_club_empty');
	}
	
	//audiotype
	if($topic['audiotype']==1){
		if(empty($topic['product'])) {
			showmessage('topic_product_empty1');
		} 
	}
	elseif($topic['audiotype']==2){
		if(empty($topic['audioplayerpath_tudou'])){
			showmessage('topic_audioplayerpath_tudou_empty');
		}
		if(empty($topic['audiodownloadpath_rayfile']) && empty($topic['audiodownloadpath_115']) && empty($topic['audiodownloadpath_zhongzhuan'])){
			showmessage('topic_audiodownloadpath_empty');
		}
	}else{
		showmessage('topic_audiotype_empty');
	}
	
	if(empty($topicid)) {
		if(!empty($topic['pic'])){
			$topic['pic']=topicPic_save($topic['pic']);
		}
		
		//默认图片
		$picPath=$_SC['attachdir'].'./'.$topic['pic'];
		if(!is_file($picPath)){
			$picpath=getfilepath("jpg",true);
			copy("image/notopicpic.jpg",$_SC['attachdir'].'./'.$picpath); 
			$topic['pic'] = $picpath;
		}
		
		if($topic['audiotype']==1){
			if(!empty($topic['product'])){
				$topic['product']=mp3_save($topic['product'],'topic');
			}
		}

		$topicid = inserttable("topic", $topic, 1);
		$topicadditioninfo['topicid'] = $topicid;
		inserttable("topic_additioninfo", $topicadditioninfo, 1);
	
		//rename topic file
		if($topic['audiotype']==1){
			batchupdateproductpath($topicid, $topicid, '');
		}
		
		updatetopicreward($topic['uid'],'topic_new');
		
		$adminusersql="SELECT s.uid FROM ".tname("space")." s WHERE 1=1 AND s.groupid=1 ORDER BY s.uid";
		$query = $_SGLOBAL['db']->query($adminusersql);
		$list=array();
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			notification_add($value[uid],"topic_admin_audit","开工了，开工了，去审核广播剧 $topic[subject] ",0);
		}
		
	}else{
		updatetable('topic', $topic, array('topicid'=>$topicid));
		$topicid = $topic[topicid];
		$topicadditioninfo['topicid'] = $topicid;
		updatetable('topic_additioninfo', $topicadditioninfo, array('topicid'=>$topicid));
	}
	
	updatesystemtopiclabel($topic);
	
	//广播剧预告处理
	if(!empty($_POST['topicforecastid'])){
		//奖励积分100 并发送消息给上传者
		updatetopicreward($_SGLOBAL['supe_uid'], 'topicforecast_post');
		
		notification_add($_SGLOBAL['supe_uid'],"topicforecast_confirm","你按时发布: $topic[subject],额外获得了100积分奖励。 ",0);
		
		//移动comment评论
		$commentsql="UPDATE ".tname("comment")." SET idtype = 'topicid' WHERE id = $_POST[topicforecastid] AND idtype = 'topicforecastid'";
		$query = $_SGLOBAL['db']->query($commentsql);
		
		//标识删除该剧的预告
		$deletetopicforecastsql="UPDATE ".tname("topic_forecast")." SET invalid = 1, topicid = $topicid WHERE topicforecastid = $_POST[topicforecastid]";
		$query = $_SGLOBAL['db']->query($deletetopicforecastsql);
	}
	
	//更新缓存
	$topic=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "topic", "loadtopicbyid", array($topicid), 3600, true);
	$topicadditioninfo=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "topicadditioninfo", "querytopicadditioninfobytopic", array($topicid), 3600, true);
	
	internal_mail('MAIL_TOPIC_AUDITOR', $topic['subject'], "请审核<a href='http://www.echodrama.com/admincp.php?ac=topic&op=manage&subop=manage&topicid=$topic[topicid]' target='_blank'>$topic[subject]</a>");
				
	showmessage('do_success', "space.php?do=topic&topicid=$topicid", 0);
} 
else if($_GET['op'] == 'download') {
	if(empty($topicid)) {
		showmessage("topic_does_not_exist");
	}
	
	$topic=loadtopicbyid($topicid);
	//广播剧不存在
	if(empty($topic)) {
		showmessage('topic_does_not_exist');
	}

	$updateddownloadtopicids=$topicid;
	$topicalbumlist=loadalbumlistbyitem($topicid);
	foreach($topicalbumlist as $value) {
		$updateddownloadtopicids=$updateddownloadtopicids.",".$value['topicid'];
	}
	$qsql="UPDATE ".tname("topic")." t SET t.downloadnum=t.downloadnum+1 WHERE t.topicid in ($updateddownloadtopicids)";
	$_SGLOBAL['db']->query($qsql);
	
	$qsql="UPDATE ".tname("space")." s SET s.topicdownloadnum=s.topicdownloadnum+1 WHERE s.uid=$_SGLOBAL[supe_uid]";
	$_SGLOBAL['db']->query($qsql);
	
	showmessage('ajax_param', '', 0, array());
} 
elseif($_GET['op'] == 'share') {
	if(empty($topicid)) {
		showmessage("topic_does_not_exist"); 
	}
	$topic=loadtopicbyid($topicid);
	//广播剧不存在
	if(empty($topic)) {
		showmessage('topic_does_not_exist');
	}
	
	//AJAX CALL
	$_SGLOBAL['inajax'] = 1;
	
	if($_GET['toshare']==0){
		//取消收藏
		$tuSql = "DELETE FROM ".tname('topicuser')." WHERE topicid=$topicid and uid=$_SGLOBAL[supe_uid]";
		$_SGLOBAL['db']->query($tuSql);
		
	}else if($_GET['toshare']==1){
		//加入收藏
		$tuSql = "SELECT COUNT(id) FROM ".tname('topicuser')." WHERE topicid=$topicid and uid=$_SGLOBAL[supe_uid]";
		$tuCount = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($tuSql), 0);
		if($tuCount<=0){
			$topicuser = Array();
			$topicuser['id'] = null;
			$topicuser['uid'] = $_SGLOBAL['supe_uid'];
			$topicuser['topicid'] = $topicid;
			$topicuser['username'] = $_SGLOBAL['supe_username'];
			$topicuser['dateline'] = $_SGLOBAL['timestamp'];
			inserttable("topicuser", $topicuser);
		}
	}else{
		showMessage("no action");	
	}
	
	updatetopicspace($_SGLOBAL['supe_uid'], $topicid);
	
	$updateShareSql="UPDATE ".tname('topic')." SET joinnum = (SELECT COUNT(id) FROM ".tname('topicuser')." WHERE topicid=$topicid ) where topicid=$topicid";
	$_SGLOBAL['db']->query($updateShareSql);

	showmessage('ajax_param', '', 0, array($tuCount,$_GET['toshare']));
}
elseif($_GET['op'] == 'settopiclabel') {
	//AJAX CALL
	$_SGLOBAL['inajax'] = 1;
	
	if(empty($topicid)) {
		showmessage("topic_does_not_exist"); 
	}
	
	$topic=loadtopicbyid($topicid);
	//广播剧不存在
	if(empty($topic)) {
		showmessage('topic_does_not_exist');
	}
	
	$delete_existtopiclabel_sql="DELETE FROM ".tname('topiclabel')." WHERE topicid='$topicid' AND uid='$_SGLOBAL[supe_uid]'";
	$_SGLOBAL['db']->query($delete_existtopiclabel_sql);
	
	$topiclabel = array();
	$topiclabel['topicid']=$topicid;
	$topiclabel['uid']= $_SGLOBAL['supe_uid'];
	$topiclabel['username']= $_SGLOBAL['supe_username'];
	$topiclabel['label']=$_GET['topiclabel'];
	$topicpoll['postdate']=$_SGLOBAL['timestamp'];;
	inserttable("topiclabel", $topiclabel);
	
	showmessage('ajax_param', '', 0, array($_GET['topicid'], $_GET['topiclabel']));
}
elseif($_GET['op'] == 'removetopiclabel') {
	if(empty($topicid)) {
		showmessage("topic_does_not_exist"); 
	}
	
	$topic=loadtopicbyid($topicid);
	//广播剧不存在
	if(empty($topic)) {
		showmessage('topic_does_not_exist');
	}
	
	//AJAX CALL
	$_SGLOBAL['inajax'] = 1;
	
	$remove_topiclabel_sql.="DELETE FROM ".tname('topiclabel')." where topicid='$topicid' AND uid='$_SGLOBAL[supe_uid]'";
	$_SGLOBAL['db']->query($remove_topiclabel_sql);
	showmessage('ajax_param', '', 0, array($_GET['topicid'], $_GET['topiclabel']));
}
elseif($_GET['op'] == 'viewtopiclabel') {
	if(empty($topicid)) {
		showmessage("topic_does_not_exist"); 
	}
	
	$topic=loadtopicbyid($topicid);
	//广播剧不存在
	if(empty($topic)) {
		showmessage('topic_does_not_exist');
	}
	
	//广播剧标签
	$topiclabel_list = loadtopiclabelbytopicid($topic[topicid]);
	
	$topiclabel_latest_sql = "SELECT tl.* FROM ".tname('topiclabel')." tl WHERE tl.topicid='$topicid' AND tl.uid>0 ORDER BY tl.lastpost DESC LIMIT 0, 10";
	$topiclabel_lastest_list = querytopiclabel($topiclabel_latest_sql);
	
	$topiclabel_me_sql = "SELECT tl.label FROM ".tname('topiclabel')." tl WHERE tl.topicid='$topicid' AND uid='$_SGLOBAL[supe_uid]' ORDER BY tl.lastpost DESC";
	$topiclabel_me_list = querytopiclabel($topiclabel_me_sql);
	
	include_once template("space_topic_label");
}
elseif($_GET['op'] == 'poll') {
	if(empty($topicid)) {
		showmessage("topic_does_not_exist"); 
	}
	
	$topic=loadtopicbyid($topicid);
	//广播剧不存在
	if(empty($topic)) {
		showmessage('topic_does_not_exist');
	}
	
	$userip=getonlineip();
	$topicpollsql= "SELECT * FROM ".tname('topicpoll')." tp WHERE tp.topicid=$topicid and ( tp.uid='$_SGLOBAL[supe_uid]' OR tp.userip='$userip' )";
	$topicpoll = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($topicpollsql));
	if( !empty($topicpoll) ){
		return;
	}
	
	//AJAX CALL
	$_SGLOBAL['inajax'] = 1;
	
	$topicpoll = array();
	$topicpoll['topicid']=$topicid;
	$topicpoll['uid']= $_SGLOBAL['supe_uid'];
	$topicpoll['username']= $_SGLOBAL['supe_username'];
	$topicpoll['userip']=getonlineip();
	$topicpoll['pollvalue']=$_GET['topicpollvalue'];
	$topicpoll['polldateline']=$_SGLOBAL['timestamp'];;
	inserttable("topicpoll", $topicpoll);
	
	$updatepollinforSql="  UPDATE ".tname('topic')." ";
	$updatepollinforSql.=" SET poll_".$topicpoll['pollvalue']." = (SELECT COUNT(topicpollid) FROM ".tname('topicpoll')." WHERE topicid=$topicid AND pollvalue='$topicpoll[pollvalue]' )";
	$updatepollinforSql.=" where topicid=$topicid";
	$_SGLOBAL['db']->query($updatepollinforSql);
	
	showmessage('ajax_param', '', 0, array($_GET['topicid'], $_GET['topicpollvalue']));
}
elseif($_GET['op'] == 'viewpoll') {
	if(empty($topicid)) {
		showmessage("topic_does_not_exist"); 
	}
	
	$topic=loadtopicbyid($topicid);
	//广播剧不存在
	if(empty($topic)) {
		showmessage('topic_does_not_exist');
	}
	
	if($topic['type']=='single'){
		$topic=topicsingleformmapper($topic);
	}elseif($topic['type']=='album'){
		$topic=topicalbumformmapper($topic);
	}
	
	include_once template("space_topic_poll");
}
elseif($_GET['op'] == 'delete') {
	//删除
	if(deletetopics(array($topicid))) {
		
		updatetopicspace($_SGLOBAL['supe_uid']);
	
		showmessage('do_success', $_POST['referlink']);
	} else {
		showmessage('failed_to_delete_operation');
	}
}
elseif($_GET['op'] == 'newtopicattachment') {
	
	if(empty($topicid)) {
		showmessage("topic_does_not_exist"); 
	}
	
	$topic=loadtopicbyid($topicid);
	//广播剧不存在
	if(empty($topic)) {
		showmessage('topic_does_not_exist');
	}
	
	if($topic['type']=='single'){
		$topic=topicsingleformmapper($topic);
	}elseif($topic['type']=='album'){
		$topic=topicalbumformmapper($topic);
	}
	
	$topicattachment=array();
	
	$nav_list = array();
	$nav_item = array();
	$nav_item['url'] = "space.php?do=topic"; $nav_item['dispname'] = "广播剧场";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "space.php?do=topic&view=single"; $nav_item['dispname'] = "广播剧列表";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "space.php?do=topic&topicid=$topic[topicid]"; $nav_item['dispname'] = "$topic[subject]";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "cp.php?ac=topic&op=newtopicattachment&topicid=$topic[topicid]"; $nav_item['dispname'] = "广播剧相关资源";
	$nav_list[] = $nav_item;
	
	$helplink_list = array();
	$helplink_item = array();
	$helplink_item['url'] = "space.php?do=thread&tid=401"; $helplink_item['dispname'] = "广播剧相关资源帮助";
	$helplink_list[] = $helplink_item;
	
	include_once(S_ROOT.'./data/data_attachmentclass.php');

	include_once template("cp_topicattachment");
}
elseif($_GET['op'] == 'savetopicattachment') {

	submitcheck('topicsubmit');
	
	if($topicid != $_POST['topicid']){
		showmessage('no_privilege');// 您目前没有权限进行此操作
	}
	
	$topic=loadtopicbyid($topicid);
	//广播剧不存在
	if(empty($topic)) {
		showmessage('topic_does_not_exist');
	}
	
	$topicattachment=array();
	$topicattachment['topicid'] = $topicid;
	$topicattachment['uid'] = $_SGLOBAL['supe_uid'];
	$topicattachment['username'] = $_SGLOBAL['supe_username'];
	$topicattachment['dateline'] = $_SGLOBAL['timestamp'];
	$topicattachment['auditstate'] = 0;
	
	$topicattachment['subject'] = $_POST['subject'];
	$topicattachment['attachmentclassid'] = $_POST['attachmentclassid'];
	$topicattachment['message'] = $_POST['message'];
	$topicattachment['attachment'] = $_POST['attachment'];
	
	//检查输入
	if(empty($topicattachment['uid'])){
		showmessage('topicattachment_uid_empty');
	} elseif(empty($topicattachment['username'])){
		showmessage('topicattachment_username_empty');
	} elseif(empty($topicattachment['subject'])) {
		showmessage('topicattachment_subject_empty');
	} elseif(empty($topicattachment['message'])) {
		showmessage('topicattachment_message_empty');
	} elseif(empty($topicattachment['attachment'])) {
		showmessage('topicattachment_attachment_empty');
	} elseif(empty($topicattachment['attachmentclassid'])) {
		showmessage('topicattachment_attachmentclassid_empty');
	}
	
	if( $topicattachment['attachmentclassid'] == 6 ){
		//外联资源
	}
	else{
		if(!empty($topicattachment['attachment'])){
			$topicattachment['attachment']=topic_attachment_save($topicattachment['attachment']);
		}
	}

	$topicattachmentid = inserttable("topicattachment", $topicattachment, 1);
		
//	updatetopicreward($topic['uid'],'topic_new');
		
	$adminusersql="SELECT s.uid FROM ".tname("space")." s WHERE 1=1 AND s.groupid=1 ORDER BY s.uid";
	$query = $_SGLOBAL['db']->query($adminusersql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		notification_add($value[uid],"topic_admin_audit","开工了，开工了，去审核广播剧《<a href=\"space.php?do=topic&topicid=$topicid\" target=\"_blank\">$topic[subject]</a>》- 相关资源《$topicattachment[subject]》。",0);
	}
		
	showmessage('do_success', "space.php?do=topic&topicid=$topicid", 0);
}
elseif($_GET['op'] == 'audittopicattachment') {

	submitcheck('topicsubmit');
	
	if($_SGLOBAL['administrator']!=1){
		showmessage('no_privilege');// 您目前没有权限进行此操作
	}
	
	$topic=loadtopicbyid($topicid);
	//广播剧不存在
	if(empty($topic)) {
		showmessage('topic_does_not_exist');
	}
	
	$topicattachment=loadtopicattachmentbyid($_GET['topicattachmentid']);
	//广播剧相关资源不存在
	if(empty($topicattachment)) {
		showmessage('topicattachment_does_not_exist');
	}
	
	if($topicattachment['topicid']!=$topic['topicid']){
		showmessage('no_privilege');// 您目前没有权限进行此操作
	}
	
	if($_GET['auditstate'] == 1) {
	//	notification_add($value[uid],"topic_admin_audit","你提供的广播剧<a href=\"space.php?do=topic&topicid=$topicid\" target=\"_blank\">$topic[subject]</a> - 相关资源《$topicattachment[subject]》，被审核退回并删除<br/>原因：$_POST[auditmessage]。",0);
		notification_add($value[uid],"topic_admin_audit","你提供的广播剧<a href=\"space.php?do=topic&topicid=$topicid\" target=\"_blank\">$topic[subject]</a> - 相关资源《$topicattachment[subject]》，被审核退回并删除，请和管理员联系。",0);
		
		deletetopicattachment($topicattachment['topicattachmentid']);
	}
	if($_GET['auditstate'] == 2) {
	//	$updateauditstatesql=" UPDATE ".tname('topicattachment')." SET subject = '$_POST[topicattachmentsubject]', auditstate = 2 WHERE topicattachmentid=$topicattachment[topicattachmentid]";
		$updateauditstatesql=" UPDATE ".tname('topicattachment')." SET auditstate = 2 WHERE topicattachmentid=$topicattachment[topicattachmentid]";
		$_SGLOBAL['db']->query($updateauditstatesql);
		notification_add($value[uid],"topic_admin_audit","你提供的广播剧<a href=\"space.php?do=topic&topicid=$topicid\" target=\"_blank\">$topic[subject]</a> - 相关资源《$topicattachment[subject]》，已审核通过。",0);
	}
	
	//更新缓存
	//相关资源
	$topicattachment_list=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "topicattachmentlist", "querytopicattachmentbytopicid", array($topic[topicid]), 1800, true);
			
	showmessage('do_success', "space.php?do=topic&topicid=$topicid", 0);
}
elseif($_GET['op'] == 'querymds') {
		
	//处理搜索
	include_once(S_ROOT.'./source/function_admincp.php');
	//所有的广播剧
	$intkeys = array('productclassid');
	$strkeys = array();
	//TODO 日期查询有问题
	$randkeys = array(array('sstrtotime','producedate'), array('intval','viewnum'), array('intval','replynum'), array('intval','hot'));
	$likekeys = array('subject','club','director','writer','cast','producer');
	$results = getwheres($intkeys, $strkeys, $randkeys, $likekeys, 't.');
	
	$wherearr = $results['wherearr'];
	$mpurl="cp.php?ac=topic&op=querymds&widget=".$_GET['widget']."&id=".$_GET['id'];
	$mpurl .= '&'.implode('&', $results['urls']);
	
	$wheresql = empty($wherearr)?'1':implode(' AND ', $wherearr);

	$perpage = 8;
	$page = empty($_GET['page'])?1:intval($_GET['page']);
	$mpurl .= '&perpage='.$perpage;
		
	if($page<1) $page = 1;
	$start = ($page-1)*$perpage;
	//检查开始数
	ckstart($start, $perpage);

	//显示分页
	$csql = "SELECT COUNT(*) FROM ".tname('topic')." t WHERE t.type='single' and t.auditstate=2 and $wheresql";
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($csql), 0);

	$qsql = "SELECT * FROM ".tname('topic')." t WHERE t.type='single' and t.auditstate=2 and $wheresql order by t.dateline desc LIMIT $start,$perpage";
	
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($csql), 0);
	if($count) {
		
		$list=querytopic($qsql);
		
		//显示分页
		$multi = multi($count, $perpage, $page, $mpurl);
	}
	
	include_once template("cp_topic_query_list");
}
elseif($_GET['op'] == 'querytopicalbummds') {
		
	//处理搜索
	include_once(S_ROOT.'./source/function_admincp.php');
	//所有的广播剧
	$intkeys = array('productclassid');
	$strkeys = array();
	//TODO 日期查询有问题
	$randkeys = array(array('sstrtotime','producedate'), array('intval','viewnum'), array('intval','replynum'), array('intval','hot'));
	$likekeys = array('subject','club','director','writer','cast','producer');
	$results = getwheres($intkeys, $strkeys, $randkeys, $likekeys, 't.');
	
	$wherearr = $results['wherearr'];
	$mpurl="cp.php?ac=topic&op=querymds&widget=".$_GET['widget']."&id=".$_GET['id'];
	$mpurl .= '&'.implode('&', $results['urls']);
	
	$wheresql = empty($wherearr)?'1':implode(' AND ', $wherearr);

	$perpage = 8;
	$page = empty($_GET['page'])?1:intval($_GET['page']);
	$mpurl .= '&perpage='.$perpage;
		
	if($page<1) $page = 1;
	$start = ($page-1)*$perpage;
	//检查开始数
	ckstart($start, $perpage);

	//显示分页
	$csql = "SELECT COUNT(*) FROM ".tname('topic')." t WHERE ( t.type='album' OR (t.type='single' AND t.singtonalbum=1) ) and $wheresql";
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($csql), 0);

	$qsql = "SELECT * FROM ".tname('topic')." t WHERE ( t.type='album' OR (t.type='single' AND t.singtonalbum=1) ) and $wheresql order by t.dateline desc LIMIT $start,$perpage";
	
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($csql), 0);
	if($count) {
		
		$list=querytopic($qsql);
		
		//显示分页
		$multi = multi($count, $perpage, $page, $mpurl);
	}
	
	include_once template("cp_topic_query_list");
}
elseif($_GET['op'] == 'loadtopicsinglebyid_ajax') {
	if(empty($topicid)) {
		showmessage("topic_does_not_exist");
	}
	$topic=loadtopicsinglebyid($topicid);
	//广播剧不存在
	if(empty($topic)) {
		showmessage('topic_does_not_exist');
	}
	$topic=topicsingleformmapper($topic);
	showmessage('ajax_param', '', 0, array($topic['topicid'],$topic['subject'],$topic['productclassid'],$topic['productclassname'],$topic['clubtagid'],$topic['club']));
}
elseif($_GET['op'] == 'loadtopicalbumbyid_ajax') {
	if(empty($topicid)) {
		showmessage("topic_does_not_exist");
	}
	$topic=loadtopicalbumbyid($topicid);
	//广播剧专辑不存在
	if(empty($topic)) {
		showmessage('topicalbum_does_not_exist');
	}
	
	$topic=topicalbumformmapper($topic);
	showmessage('ajax_param', '', 0, array($topic['topicid'],$topic['subject'],$topic['productclassid'],$topic['productclassname'],$topic['clubtagid'],$topic['club']));
}


?>