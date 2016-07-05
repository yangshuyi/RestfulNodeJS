<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: network.php 13003 2009-08-05 06:46:06Z liguode $
*/

include_once('./common.php');

//空间被锁定
if($_SGLOBAL['supe_uid']) {
	$space = getspace($_SGLOBAL['supe_uid']);
	
	if($space['flag'] == -1) {
		showmessage('space_has_been_locked');
	}
	
	//禁止访问
	if(checkperm('banvisit')) {
		ckspacelog();
		showmessage('you_do_not_have_permission_to_visit');
	}
}

include_once(S_ROOT.'./source/function_systemserializer.php');

//24 hour

$system_serializer_modulename = "PortalTopic_86400";
$system_serializer_cutofftime = $_SGLOBAL['timestamp'];
$system_serializer_array = loadSystemSerializerFromFile($system_serializer_modulename, $system_serializer_cutofftime, 86400);

//使用页面数据缓存
if( !empty($system_serializer_array) ){
	
	//广播剧标签
	$topiclabel_hot_list = $system_serializer_array['topiclabel_hot_list'];
	
	//每周推荐：显示前5个星期点击量最高的作品（每周1部，共5部轮回切换）。
	$topic_recommand_flashvar = $system_serializer_array['topic_recommand_flashvar'];
	
	//广播剧专辑：显示40部最新上传/整理的广播剧专辑/全一期作品。
	$topic_album_list = $system_serializer_array['topic_album_list'];
	
	//排行榜 - 根据点击量 按 周/月/总 进行排名
	$dispyear = $system_serializer_array['dispyear'];
	$dispmonth = $system_serializer_array['dispmonth'];
	$dispmonth_gbk = $system_serializer_array['dispmonth_gbk'];
	$dispweek = $system_serializer_array['dispweek'];

	//XX月访问量排行榜：显示在当前自然月的广播剧访问量最高的8部作品。
	$topic_view_monthly_list = $system_serializer_array['topic_view_monthly_list'];
	
	//XXXX年访问量排行榜：显示在当前自然年的广播剧访问量最高的8部作品。
	$topic_view_yearly_list = $system_serializer_array['topic_view_yearly_list'];
	
	//热评排行榜：显示在最近45天上传发布的，评论量最多的8部作品。
	$topic_reply_quarter_list = $system_serializer_array['topic_reply_quarter_list'];
	
	//收藏排行榜：显示在最近45天上传发布的，被用户收藏次数最多的8部作品。
	$topic_shared_quarter_list = $system_serializer_array['topic_shared_quarter_list'];
	
	//活跃度排行榜：显示在最近45天上传发布的，活跃度最高的8部作品。
	$topic_active_quarter_list = $system_serializer_array['topic_active_quarter_list'];
	
	//新成立群组：显示最近成立的，已超过5个粉丝关注的一个社团/工作室群组。
	$mtag_latest_list = $system_serializer_array['mtag_latest_list'];
	
	//最热门群组：显示成员数最多的一个社团/工作室群组。
	$mtag_hot_list = $system_serializer_array['mtag_hot_list'];
	
	//社团工作室：显示粉丝数最多的6个社团/工作室群组。
	$mtag_fans_list = $system_serializer_array['mtag_fans_list'];
	
	//社团推荐作品/公告 - 由广播剧社团/工作室 群组 用积分方式推荐自己的作品（目前构思中，牵涉到设置群组的资金池，群组的活跃经验值等）
	$advertisement = $system_serializer_array['advertisement'];
}
else{
	$system_serializer_array = array();
	
	include_once(S_ROOT.'./source/function_topic.php');
	include_once(S_ROOT.'./source/function_share.php');
	include_once(S_ROOT.'./source/function_mtag.php');
	include_once(S_ROOT.'./source/function_thread.php');
	include_once(S_ROOT.'./source/function_poll.php');
	include_once(S_ROOT.'./source/function_event.php');
	include_once(S_ROOT.'./source/function_advertisement.php');
	
	//广播剧标签
	$topiclabel_hot_sql="SELECT tl.label AS label, count(tl.id) AS num FROM ".tname('topiclabel')." tl WHERE tl.uid='0' GROUP BY tl.label ORDER BY num desc LIMIT 0,10";
	$topiclabel_hot_list = querytopiclabel($topiclabel_hot_sql);
	
	$system_serializer_array['topiclabel_hot_list'] = $topiclabel_hot_list;
	
	//每周推荐：显示前5个星期点击量最高的作品（每周1部，共5部轮回切换）。
	$topic_recommand_list = loadtodaytopicrecommandlist(5);
	$topic_recommand_pic.=$topic_recommand_list[0][picthumb]."|";
	$topic_recommand_url.="space.php?do=topic%26topicid=".$topic_recommand_list[0][topicid]."|";
	$topic_recommand_text.=$topic_recommand_list[0][subject]."|";
	$topic_recommand_pic.=$topic_recommand_list[1][picthumb]."|";
	$topic_recommand_url.="space.php?do=topic%26topicid=".$topic_recommand_list[1][topicid]."|";
	$topic_recommand_text.=$topic_recommand_list[1][subject]."|";
	$topic_recommand_pic.=$topic_recommand_list[2][picthumb]."|";
	$topic_recommand_url.="space.php?do=topic%26topicid=".$topic_recommand_list[2][topicid]."|";
	$topic_recommand_text.=$topic_recommand_list[2][subject]."|";
	$topic_recommand_pic.=$topic_recommand_list[3][picthumb]."|";
	$topic_recommand_url.="space.php?do=topic%26topicid=".$topic_recommand_list[3][topicid]."|";
	$topic_recommand_text.=$topic_recommand_list[3][subject]."|";
	$topic_recommand_pic.=$topic_recommand_list[4][picthumb];
	$topic_recommand_url.="space.php?do=topic%26topicid=".$topic_recommand_list[4][topicid];
	$topic_recommand_text.=$topic_recommand_list[4][subject];
	
	//$topic_recommand_flashvar = "config=5|0xffffff|0xFFA84E|60|0xffffff|0xFF7905|0x000000";
	$topic_recommand_flashvar = "pw=291&amp;ph=388&amp;sizes=14&amp;umcolor=16777215&amp;btnbg=13762561&amp;txtcolor=16777215&amp;txtoutcolor=0&amp;";
	$topic_recommand_flashvar.= "&urls=" . $topic_recommand_url;
	$topic_recommand_flashvar.= "&titles=" . $topic_recommand_text;
	$topic_recommand_flashvar.= "&imgs=" . $topic_recommand_pic;
	
	$system_serializer_array['topic_recommand_flashvar'] = $topic_recommand_flashvar;
	
	//广播剧专辑：显示20部最新上传/整理的广播剧专辑/全一期作品。
	$topic_album_sql = "SELECT t.* FROM ".tname('topic')." t WHERE ( t.type='album' OR (t.type='single' AND t.singtonalbum=1 AND t.auditstate=2 ) ) AND t.protalforbidden=0 ORDER BY t.dateline DESC LIMIT 0,20";
	//$topic_album_list = queryalbum($topic_album_sql);
	//$topic_album_sql = "SELECT t.* FROM ".tname('topic')." t WHERE ( t.type='single' AND t.singtonalbum=1 AND t.auditstate=2 ) AND t.protalforbidden=0 ORDER BY t.dateline DESC LIMIT 0,20";
	$topic_album_list = querytopic($topic_album_sql);
	
	
	$system_serializer_array['topic_album_list'] = $topic_album_list;
	
	//排行榜 - 根据点击量 按 周/月/总 进行排名
	$currentweek = getCurrentWeek();
	$dispyear = substr($currentweek, 0, 4);
	$dispmonth = substr($currentweek, 4, 2);
	$dispweek = substr($currentweek, 6, 2);
	
	switch ($dispmonth){
		case 1: $dispmonth_gbk = "一"; break;
		case 2: $dispmonth_gbk = "二"; break;
		case 3: $dispmonth_gbk = "三"; break;
		case 4: $dispmonth_gbk = "四"; break;
		case 5: $dispmonth_gbk = "五"; break;
		case 6: $dispmonth_gbk = "六"; break;
		case 7: $dispmonth_gbk = "七"; break;
		case 8: $dispmonth_gbk = "八"; break;
		case 9: $dispmonth_gbk = "九"; break;
		case 10: $dispmonth_gbk = "十"; break;
		case 11: $dispmonth_gbk = "十一"; break;
		case 12: $dispmonth_gbk = "十二"; break;
	}
	
	$system_serializer_array['dispyear'] = $dispyear;
	$system_serializer_array['dispmonth'] = $dispmonth;
	$system_serializer_array['dispmonth_gbk'] = $dispmonth_gbk;
	$system_serializer_array['dispweek'] = $dispweek;
	
	$topicStaticWeeklyTableName = tname("topic_static_weekly_".$dispyear);
	
	//XX月访问量排行榜：显示在当前自然月的广播剧访问量最高的8部作品。
	$topic_view_monthly_sql = "SELECT SUM(tsw.viewnum) as dispnum, t.* FROM ".tname('topic')." t, $topicStaticWeeklyTableName tsw ";
	$topic_view_monthly_sql .= " WHERE t.topicid=tsw.topicid and tsw.week LIKE '".$dispyear.$dispmonth."__"."' AND t.type='single' and t.auditstate=2 AND t.protalforbidden=0 ";
	$topic_view_monthly_sql .= " GROUP BY tsw.topicid ";
	$topic_view_monthly_sql .= " ORDER BY SUM(tsw.viewnum) DESC LIMIT 0,8";
	$topic_view_monthly_list = querytopic($topic_view_monthly_sql);
	
	$system_serializer_array['topic_view_monthly_list'] = $topic_view_monthly_list;
	
	//XXXX年访问量排行榜：显示在当前自然年的广播剧访问量最高的8部作品。
	$topic_view_yearly_sql = "SELECT SUM(tsw.viewnum) as dispnum, t.* FROM ".tname('topic')." t, $topicStaticWeeklyTableName tsw ";
	$topic_view_yearly_sql .= " WHERE t.topicid=tsw.topicid and tsw.week LIKE '".$dispyear."__"."__"."' AND t.type='single' and t.auditstate=2 AND t.protalforbidden=0 ";
	$topic_view_yearly_sql .= " GROUP BY tsw.topicid ";
	$topic_view_yearly_sql .= " ORDER BY SUM(tsw.viewnum) DESC LIMIT 0,8";
	$topic_view_yearly_list = querytopic($topic_view_yearly_sql);
	
	$system_serializer_array['topic_view_yearly_list'] = $topic_view_yearly_list;
	
	$curofftime = $_SGLOBAL['timestamp'] - 2592000*3; 
	
	//热评排行榜：显示在最近45天上传发布的，评论量最多的8部作品。
	$topic_reply_quarter_sql= "SELECT t.replynum AS dispnum, t.* FROM ".tname('topic')." t WHERE t.auditstate=2 AND t.protalforbidden=0 and t.dateline > $curofftime order by t.replynum desc LIMIT 0,8";
	$topic_reply_quarter_list = querytopic($topic_reply_quarter_sql);
	
	$system_serializer_array['topic_reply_quarter_list'] = $topic_reply_quarter_list;
	
	//收藏排行榜：显示在最近45天上传发布的，被用户收藏次数最多的8部作品。
	$topic_shared_quarter_sql= "SELECT count(tu.id) as dispnum, t.* FROM ".tname('topicuser')." tu LEFT OUTER JOIN ".tname('topic')." t ON tu.topicid =t.topicid WHERE tu.topicid IN (SELECT temp_t.topicid FROM ".tname('topic')." temp_t WHERE temp_t.auditstate=2 AND t.protalforbidden=0 and temp_t.dateline > $curofftime ) GROUP BY tu.topicid ORDER BY count(tu.id) DESC LIMIT 0,8";
	$topic_shared_quarter_list = querytopic($topic_shared_quarter_sql);
	
	$system_serializer_array['topic_shared_quarter_list'] = $topic_shared_quarter_list;
	
	//活跃度排行榜：显示在最近45天上传发布的，活跃度最高的8部作品。
	$topic_active_quarter_sql= "SELECT t.viewnum*1 + t.replynum*1 + t.downloadnum*1 + t.joinnum*2 + t.poll_5*2 + tl.topiclabelnum*2 AS dispnum, t.* ";
	$topic_active_quarter_sql .= " FROM ".tname('topic')." t "; 
	$topic_active_quarter_sql .= " LEFT OUTER JOIN (SELECT count(id) AS topiclabelnum, topicid FROM ".tname('topiclabel')." GROUP BY topicid) tl ON t.topicid=tl.topicid ";
	$topic_active_quarter_sql .= " WHERE t.auditstate=2 AND t.protalforbidden=0 and t.dateline > $curofftime ORDER BY dispnum DESC LIMIT 0,8";
	$topic_active_quarter_list = querytopic($topic_active_quarter_sql);
	
	$system_serializer_array['topic_active_quarter_list'] = $topic_active_quarter_list;
	
	//新成立群组：显示最近成立的，已超过5个粉丝关注的一个社团/工作室群组。
	$mtag_latest_sql="SELECT m.* FROM ".tname('mtag')." m WHERE m.tagstate>=2 AND (m.fieldid = 1 OR m.fieldid = 5) AND m.fansnum>5 ORDER BY m.dateline DESC LIMIT 0,1";
	$mtag_latest_list = querymtag($mtag_latest_sql);
	
	$system_serializer_array['mtag_latest_list'] = $mtag_latest_list;
	
	//最热门群组：显示成员数最多的一个社团/工作室群组。
	$mtag_hot_sql="SELECT m.* FROM ".tname('mtag')." m WHERE m.tagstate>=2 AND (m.fieldid = 1 OR m.fieldid = 5) ORDER BY m.membernum DESC LIMIT 0,1";
	$mtag_hot_list = querymtag($mtag_hot_sql);
	
	$system_serializer_array['mtag_hot_list'] = $mtag_hot_list;
	
	//社团工作室：显示粉丝数最多的6个社团/工作室群组。
	$mtag_fans_sql="SELECT m.* FROM ".tname('mtag')." m WHERE m.tagstate>=2 AND (m.fieldid = 1 OR m.fieldid = 5) ORDER BY m.fansnum DESC LIMIT 0,6";
	$mtag_fans_list = querymtag($mtag_fans_sql);
	
	$system_serializer_array['mtag_fans_list'] = $mtag_fans_list;
	
	//serialize
	saveSystemSerializerIntoFile( $system_serializer_modulename, $system_serializer_cutofftime, $system_serializer_array);
}


$system_serializer_modulename = "PortalTopic_3600";
$system_serializer_cutofftime = $_SGLOBAL['timestamp'];
$system_serializer_array = loadSystemSerializerFromFile($system_serializer_modulename, $system_serializer_cutofftime, 3600);

//使用页面数据缓存
if( !empty($system_serializer_array) ){
	//First Publish
	$topic_firstpublish_list = $system_serializer_array['topic_firstpublish_list'];
	
	//热评推荐：显示最近7天评论量最多的4部作品。
	$topic_sitejoin_list = $system_serializer_array['topic_sitejoin_list'];
	
	//XX周访问量排行榜：显示在当前周的广播剧访问量最高的8部作品。
	$topic_view_weekly_list = $system_serializer_array['topic_view_weekly_list'];

	//广播剧长评：显示游泳池模块中，犀利剧评最近回复过的17篇帖子。
	$thread_xilijuping_list = $system_serializer_array['thread_xilijuping_list'];
	
	//社团推荐作品/公告 - 由广播剧社团/工作室 群组 用积分方式推荐自己的作品（目前构思中，牵涉到设置群组的资金池，群组的活跃经验值等）
	$advertisement = $system_serializer_array['advertisement'];
	
	//招募：显示最新的6条招募信息。
	$event_latest_list = $system_serializer_array['event_latest_list'];
}
else{
	$system_serializer_array = array();
	
	include_once(S_ROOT.'./source/function_topic.php');
	include_once(S_ROOT.'./source/function_share.php');
	include_once(S_ROOT.'./source/function_mtag.php');
	include_once(S_ROOT.'./source/function_thread.php');
	include_once(S_ROOT.'./source/function_poll.php');
	include_once(S_ROOT.'./source/function_event.php');
	include_once(S_ROOT.'./source/function_advertisement.php');
	
	//First Publish
	$cutofftime = $_SGLOBAL['timestamp'] - 7776000; //最近3个月首发剧
	
	$topic_firstpublish_sql .= " SELECT t.* FROM ".tname('topic')." t WHERE t.auditstate=2 and t.firstpublish = 1 and dateline > $cutofftime order by t.dateline LIMIT 0,20";
	$topic_firstpublish_list = querytopic($topic_firstpublish_sql);
	
	$system_serializer_array['topic_firstpublish_list'] = $topic_firstpublish_list;

	//热评推荐：显示最近7天评论量最多的4部作品。
	$cutofftime = $_SGLOBAL['timestamp'] - 604800; //最近1周评论最多的剧
	$topicreplysql= "SELECT t.* FROM ".tname('topic')." t WHERE t.auditstate=2 AND t.protalforbidden=0 and dateline > $cutofftime order by t.replynum desc LIMIT 0,4";
	$topic_sitejoin_list = querytopic($topicreplysql);
	
	$system_serializer_array['topic_sitejoin_list'] = $topic_sitejoin_list;

	//排行榜 - 根据点击量 按 周/月/总 进行排名
	$currentweek = getCurrentWeek();
	$dispyear = substr($currentweek, 0, 4);
	$dispmonth = substr($currentweek, 4, 2);
	$dispweek = substr($currentweek, 6, 2);
	
	switch ($dispmonth){
		case 1: $dispmonth_gbk = "一"; break;
		case 2: $dispmonth_gbk = "二"; break;
		case 3: $dispmonth_gbk = "三"; break;
		case 4: $dispmonth_gbk = "四"; break;
		case 5: $dispmonth_gbk = "五"; break;
		case 6: $dispmonth_gbk = "六"; break;
		case 7: $dispmonth_gbk = "七"; break;
		case 8: $dispmonth_gbk = "八"; break;
		case 9: $dispmonth_gbk = "九"; break;
		case 10: $dispmonth_gbk = "十"; break;
		case 11: $dispmonth_gbk = "十一"; break;
		case 12: $dispmonth_gbk = "十二"; break;
	}
	
	$system_serializer_array['dispyear'] = $dispyear;
	$system_serializer_array['dispmonth'] = $dispmonth;
	$system_serializer_array['dispmonth_gbk'] = $dispmonth_gbk;
	$system_serializer_array['dispweek'] = $dispweek;

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
	$topic_view_weekly_sql .= " ORDER BY SUM(tsw.viewnum) DESC LIMIT 0,8";
	$topic_view_weekly_list = querytopic($topic_view_weekly_sql);
	
	$system_serializer_array['topic_view_weekly_list'] = $topic_view_weekly_list;

	//广播剧长评：显示游泳池模块中，犀利剧评最近回复过的17篇帖子。
	$thread_xilijuping_sql = "SELECT mt.* FROM ".tname('mtag_thread')." mt WHERE mt.tagid=".FORUM_TAGID." AND mt.threadclassid=".FORUM_XILIJUPING_CLASSID." ORDER BY mt.lastpost DESC LIMIT 0,17";
	$thread_xilijuping_list = querymtagthread($thread_xilijuping_sql);
	
	$system_serializer_array['thread_xilijuping_list'] = $thread_xilijuping_list;
	
	//社团推荐作品/公告 - 由广播剧社团/工作室 群组 用积分方式推荐自己的作品（目前构思中，牵涉到设置群组的资金池，群组的活跃经验值等）
	$advertisement_location_portal_topic = 1;
	$advertisement = displayadvertisementbylocation($advertisement_location_portal_topic);
	
	$system_serializer_array['advertisement'] = $advertisement;
	
	//招募：显示最新的6条招募信息。
	$event_latest_sql = "SELECT e.* FROM ".tname('event')." e where e.typeid<>5 ORDER BY e.dateline DESC LIMIT 0,6";
	$event_latest_list = queryevent($event_latest_sql);
	
	$system_serializer_array['event_latest_list'] = $event_latest_list;
	
	//serialize
	saveSystemSerializerIntoFile( $system_serializer_modulename, $system_serializer_cutofftime, $system_serializer_array);
}

$system_serializer_modulename = "PortalTopic_60";
$system_serializer_cutofftime = $_SGLOBAL['timestamp'];
$system_serializer_array = loadSystemSerializerFromFile($system_serializer_modulename, $system_serializer_cutofftime, 60);

//使用页面数据缓存
if( !empty($system_serializer_array) ){
	
	//新剧预告
	$topicforecast_latest_list = $system_serializer_array['topicforecast_latest_list'];
	
	//新剧罗列：显示10部最新上传并被审核通过的作品。
	$topic_latest_list = $system_serializer_array['topic_latest_list'];
}
else{
	$system_serializer_array = array();
	
	include_once(S_ROOT.'./source/function_topic.php');
	
	//新剧预告 当天之后-30天以前
	$cutofftime_from = getCurrentDate();
	$curofftime_to = $cutofftime_from + 2592000; 
	$topicforecast_latest_sql = " SELECT tf.*, tfu.uid as joinedflag FROM ".tname("topic_forecast")." tf LEFT OUTER JOIN ".tname('topic_forecast_user')." tfu ON tf.topicforecastid = tfu.topicforecastid AND tfu.uid='$_SGLOBAL[supe_uid]' WHERE tf.invalid = 0 AND tf.producedate>=$cutofftime_from AND tf.producedate<=$curofftime_to ORDER BY tf.producedate ";
	$topicforecast_latest_list = querytopicforecast($topicforecast_latest_sql);
	
	$system_serializer_array['topicforecast_latest_list'] = $topicforecast_latest_list;
	
	//新剧罗列：显示10部最新上传并被审核通过的作品。
	$topic_latest_sql = " SELECT t.* FROM ".tname("topic")." t WHERE t.type='single' AND t.auditstate=2 AND t.protalforbidden=0 ORDER BY t.dateline DESC LIMIT 0,10 ";
	$topic_latest_list = querytopic($topic_latest_sql);
	
	$system_serializer_array['topic_latest_list'] = $topic_latest_list;

	//serialize
	saveSystemSerializerIntoFile( $system_serializer_modulename, $system_serializer_cutofftime, $system_serializer_array);
}

//页面模块
$site_module_actives = array('portal_topic' => ' class="portalmenuli-sel"');

$_TPL['css'] = 'portal';

include_once template("portal_topic");
?>