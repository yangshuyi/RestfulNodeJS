<?php
/*
 [UCenter Home] (C) 2007-2008 Comsenz Inc.
 $Id: space_thread.php 13210 2009-08-20 07:09:06Z liguode $
 */

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}
$MODULE_NAME = "SPACE_FORUM";

//页面模块
$site_module_actives = array('space_forum' => ' class="portalmenuli-sel"');

$page = empty($_GET['page'])?1:intval($_GET['page']);
$threadid = empty($_GET['tid'])?0:intval($_GET['tid']);

if(empty($threadid)){
	$_GET['view'] = empty($_GET['view']) ? "listall" : $_GET['view'];
}
else{
	$_GET['view'] = empty($_GET['view']) ? "viewall" : $_GET['view'];
}

@include_once(S_ROOT.'./data/data_profield.php');
@include_once(S_ROOT.'./source/function_mtag.php');
@include_once(S_ROOT.'./source/function_thread.php');

//表态分类
@include_once(S_ROOT.'./data/data_click.php');
$clicks = empty($_SGLOBAL['click']['tid'])?array():$_SGLOBAL['click']['tid'];

$today = getCurrentDate();
$yesterday = $today - 86400;

if( $_GET['view']=='listall' ){
	
	$perpage = 30;
	$start = ($page-1)*$perpage;
		
	//检查开始数
	ckstart($start, $perpage);
	
	$theurl = "space.php?do=forum&view=$_GET[view]";
	$wheresql = "";
	$ordersql = "";
		
	if( $searchkey = stripsearchkey($_GET['searchkey']) ) {
	   $wheresql .= "AND ( mt.subject LIKE '%$searchkey%' OR mt.label LIKE '%$searchkey%' )";
	   $theurl .= "&searchkey=$searchkey";
	}
		
	if( !empty($_GET['threadclassid']) ) {
	   $wheresql .= " AND mt.threadclassid = '$_GET[threadclassid]' ";
	   $theurl .= "&threadclassid=$_GET[threadclassid]";
	}
		
	if(empty($_GET['becheck'])){
		$_GET['normal']="on";
		$_GET['close']="";
		$_GET['digest']="on";
		$_GET['displayorder']="on";
	}
		
	$subwheresql=" 1=2 ";
	if($_GET['normal']=="on") {
		$subwheresql .= " OR (mt.close = '0' AND mt.digest = '0' AND mt.displayorder = '0') ";
	   	$theurl .= "&normal=on";
	}
	if($_GET['close']=="on") {
		$subwheresql .= " OR mt.close = '1' ";
		$theurl .= "&close=on";
	}	
	if($_GET['digest']=="on") {
		$subwheresql .= " OR mt.digest = '1' ";
		$theurl .= "&digest=on";
	}		
	if($_GET['displayorder']=="on") {
		$subwheresql .= " OR mt.displayorder = '1' ";
		$theurl .= "&displayorder=on";
	}
		
	$wheresql.= " AND ( $subwheresql )";
		  
	if($_GET['orderby']=="datelineasc") {
		$ordersql .= " mt.dateline asc ";
	   	$theurl .= "&orderby=datelineasc";
	}
	else if($_GET['orderby']=="datelinedesc") {
		$ordersql .= " mt.dateline desc ";
	   	$theurl .= "&orderby=datelinedesc";
	}	
	else if($_GET['orderby']=="viewnumasc") {
		$ordersql .= " mt.viewnum asc ";
	   	$theurl .= "&orderby=viewnumasc";
	}	
	else if($_GET['orderby']=="viewnumdesc") {
		$ordersql .= " mt.viewnum desc ";
	   	$theurl .= "&orderby=viewnumdesc";
	}	
	else if($_GET['orderby']=="lastpostasc") {
		$ordersql .= " mt.lastpost asc ";
	   	$theurl .= "&orderby=lastpostasc";
	}	
	else if($_GET['orderby']=="lastpostdesc") {
		$ordersql .= " mt.lastpost desc ";
	   	$theurl .= "&orderby=lastpostdesc";
	}
	else{
		$ordersql .= " mt.lastpost desc ";
	   	$theurl .= "&orderby=lastpostdesc";
	}	
	
	$threadlist = array();
	$count = 0;
		
	$csql="SELECT COUNT(mt.tid) AS count FROM ".tname('mtag_thread')." mt WHERE mt.tagid='".FORUM_TAGID."' $wheresql";
	$qsql="SELECT mt.*, mtc.classname AS threadclassname FROM ".tname('mtag_thread')." mt ";
	$qsql.=" LEFT OUTER JOIN ".tname('mtag_threadclass')." mtc ON mt.tagid=mtc.tagid AND mt.threadclassid=mtc.classid ";
	$qsql.=" WHERE mt.tagid='".FORUM_TAGID."' AND mt.displayorder!=1 $wheresql ";
	$qsql.=" ORDER BY mt.keepbottom ASC, $ordersql ";
	$qsql.=" LIMIT $start,$perpage";
		
	$count = $_SGLOBAL['db']->cachequery($MODULE_NAME, $csql, true, 3600);
	$count = $count['count'];
	if($count) {
		$threadlist = $_SGLOBAL['db']->cachequery($MODULE_NAME, $qsql, false, $page == 1?0:1800);
		foreach($threadlist as &$value){
			$value = threadformmapper($value);
		}
		unset($value);   
		//分页
		$multi = multi($count, $perpage, $page, $theurl);
	}
	
	//置顶帖
	$systemthreadlist=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "systemthreadlist", "queryforumsystemthread", array(FORUM_TAGID), 3600);
	
	//帖子类型
	$threadclasslist=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "threadclasslist", "listthreadclassbymtagid", array(FORUM_TAGID), 86400);

	//今天帖子数
	$today = getCurrentDate();
	$todaythreadcount_sql = "SELECT COUNT(*) AS count FROM ".tname('mtag_thread')." mt WHERE mt.tagid='".FORUM_TAGID."' AND mt.dateline>=$today";
	$todaythreadcount = $_SGLOBAL['db']->cachequery($MODULE_NAME, $todaythreadcount_sql, true, 3600);
	$todaythreadcount = $todaythreadcount['count'];
	
	//总帖子数
	$threadcount_sql = "SELECT COUNT(*) AS count FROM ".tname('mtag_thread')." mt WHERE mt.tagid='".FORUM_TAGID."'";
	$threadcount = $_SGLOBAL['db']->cachequery($MODULE_NAME, $threadcount_sql, true, 3600);
	$threadcount = $threadcount['count'];
	
	$_TPL['css'] = 'forum';
	$searchengine_description='游泳池-帖子列表：';
	if(!empty($threadlist)){
		foreach($threadlist as $value) {
			$searchengine_description.=$value['subject'].",";
		}
	}
	
	include_once template("space_forum");
}
elseif( $_GET['view']=='listuser' ){
	
	$perpage = 30;
	$start = ($page-1)*$perpage;
		
	//检查开始数
	ckstart($start, $perpage);
	
	$theurl = "space.php?do=forum&view=$_GET[view]";
	$wheresql = "";
	$ordersql = "";
		
	if( $searchkey = stripsearchkey($_GET['searchkey']) ) {
		$wheresql .= "AND ( mt.subject LIKE '%$searchkey%' OR mt.label LIKE '%$searchkey%' )";
		$theurl .= "&searchkey=$searchkey";
	}
		  
	if($_GET['orderby']=="datelineasc") {
		$ordersql .= " mt.dateline asc ";
	   	$theurl .= "&orderby=datelineasc";
	}
	else if($_GET['orderby']=="datelinedesc") {
		$ordersql .= " mt.dateline desc ";
	   	$theurl .= "&orderby=datelinedesc";
	}	
	else if($_GET['orderby']=="viewnumasc") {
		$ordersql .= " mt.viewnum asc ";
	   	$theurl .= "&orderby=viewnumasc";
	}	
	else if($_GET['orderby']=="viewnumdesc") {
		$ordersql .= " mt.viewnum desc ";
	   	$theurl .= "&orderby=viewnumdesc";
	}	
	else if($_GET['orderby']=="lastpostasc") {
		$ordersql .= " mt.lastpost asc ";
	   	$theurl .= "&orderby=lastpostasc";
	}	
	else if($_GET['orderby']=="lastpostdesc") {
		$ordersql .= " mt.lastpost desc ";
	   	$theurl .= "&orderby=lastpostdesc";
	}
	else{
		$ordersql .= " mt.lastpost desc ";
	   	$theurl .= "&orderby=lastpostdesc";
	}
	
	$threadlist = array();
	$count = 0;
		
	$csql="SELECT COUNT(*) AS count FROM ".tname('mtag_thread')." mt , ".tname('mtag_thread_user')." mtu ";
	$csql.=" WHERE mt.tagid='".FORUM_TAGID."' AND mtu.tid=mt.tid AND mtu.uid='$_SGLOBAL[supe_uid]' $wheresql";
	
	$qsql="SELECT mt.*, mtc.classname AS threadclassname ";
	$qsql.=" FROM ".tname('mtag_thread')." mt";
	$qsql.=" INNER JOIN ".tname('mtag_thread_user')." mtu ON mtu.tid=mt.tid AND mtu.uid='$_SGLOBAL[supe_uid]' ";
	$qsql.=" LEFT OUTER JOIN ".tname('mtag_threadclass')." mtc ON mt.tagid=mtc.tagid AND mt.threadclassid=mtc.classid ";
	$qsql.=" WHERE mt.tagid='".FORUM_TAGID."' $wheresql ";
	$qsql.=" ORDER BY $ordersql ";
	$qsql.=" LIMIT $start,$perpage";
		
	$count = $_SGLOBAL['db']->cachequery($MODULE_NAME, $csql, true, 3600);
	$count = $count['count'];
	if($count) {
		$threadlist = $_SGLOBAL['db']->cachequery($MODULE_NAME, $qsql, false, $page == 1?0:1800);
		foreach($threadlist as &$value){
			$value = threadformmapper($value);
		}
		unset($value);   
		//分页
		$multi = multi($count, $perpage, $page, $theurl);
	}
	
	$_TPL['css'] = 'forum';
	$searchengine_description='游泳池-我发布的帖子：';
	if(!empty($threadlist)){
		foreach($threadlist as $value) {
			$searchengine_description.=$value['subject'].",";
		}
	}
	
	include_once template("space_forum");
}
elseif( $_GET['view']=='listme' ){
	
	$perpage = 30;
	$start = ($page-1)*$perpage;
		
	//检查开始数
	ckstart($start, $perpage);
	
	$theurl = "space.php?do=forum&view=$_GET[view]";
	$wheresql = "";
	$ordersql = "";
		
	if( $searchkey = stripsearchkey($_GET['searchkey']) ) {
		$wheresql .= "AND ( mt.subject LIKE '%$searchkey%' OR mt.label LIKE '%$searchkey%' ";
		$theurl .= "&searchkey=$searchkey";
	}
		  
	if($_GET['orderby']=="datelineasc") {
		$ordersql .= " mt.dateline asc ";
	   	$theurl .= "&orderby=datelineasc";
	}
	else if($_GET['orderby']=="datelinedesc") {
		$ordersql .= " mt.dateline desc ";
	   	$theurl .= "&orderby=datelinedesc";
	}	
	else if($_GET['orderby']=="viewnumasc") {
		$ordersql .= " mt.viewnum asc ";
	   	$theurl .= "&orderby=viewnumasc";
	}	
	else if($_GET['orderby']=="viewnumdesc") {
		$ordersql .= " mt.viewnum desc ";
	   	$theurl .= "&orderby=viewnumdesc";
	}	
	else if($_GET['orderby']=="lastpostasc") {
		$ordersql .= " mt.lastpost asc ";
	   	$theurl .= "&orderby=lastpostasc";
	}	
	else if($_GET['orderby']=="lastpostdesc") {
		$ordersql .= " mt.lastpost desc ";
	   	$theurl .= "&orderby=lastpostdesc";
	}
	else{
		$ordersql .= " mt.lastpost desc ";
	   	$theurl .= "&orderby=lastpostdesc";
	}	
	
	$threadlist = array();
	$count = 0;
		
	$csql="SELECT COUNT(*) AS count FROM ".tname('mtag_thread')." mt WHERE mt.tagid='".FORUM_TAGID."' AND mt.uid='$_SGLOBAL[supe_uid]' $wheresql";
	$qsql="SELECT mt.*, mtc.classname AS threadclassname FROM ".tname('mtag_thread')." mt ";
	$qsql.=" LEFT OUTER JOIN ".tname('mtag_threadclass')." mtc ON mt.tagid=mtc.tagid AND mt.threadclassid=mtc.classid ";
	$qsql.=" WHERE mt.tagid='".FORUM_TAGID."' AND mt.uid='$_SGLOBAL[supe_uid]' $wheresql ";
	$qsql.=" ORDER BY $ordersql ";
	$qsql.=" LIMIT $start,$perpage";
		
	$count = $_SGLOBAL['db']->cachequery($MODULE_NAME, $csql, true, 3600);
	$count = $count['count'];
	if($count) {
		$threadlist = $_SGLOBAL['db']->cachequery($MODULE_NAME, $qsql, false, $page == 1?0:1800);
		foreach($threadlist as &$value){
			$value = threadformmapper($value);
		}
		unset($value);   
		//分页
		$multi = multi($count, $perpage, $page, $theurl);
	}
	//$threadclasslist=listthreadclassbymtagid($forum_spam_tagid);
	
	$_TPL['css'] = 'forum';
	$searchengine_description='游泳池-我关注的帖子：';
	if(!empty($threadlist)){
		foreach($threadlist as $value) {
			$searchengine_description.=$value['subject'].",";
		}
	}
	include_once template("space_forum");
}
elseif( $_GET['view']=='viewposter' || $_GET['view']=='viewall' ){
	
	if( empty($threadid) ){
		showmessage('mtag_thread_not_exist');
	}
	
	//话题
	$thread=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "thread", "loadthreadbyid", array($threadid), 3600);
	if(empty($thread)) {
		showmessage('mtag_thread_not_exist');
	}
	$thread = threadformmapper($thread);
	
	$mainpost=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "threadmainpost", "loadthreadmainpostbyid", array($thread['tid']), 3600);
	$mainpost = postformmapper($mainpost);
	
	if( $thread['threadclassid'] == FORUM_JISHUJIAOLIU_CLASSID ) {
		if( empty($_SGLOBAL['forum_admin_FORUM_JISHUJIAOLIU_CLASSID']) ){
			$_SGLOBAL['forum_admin'] = 0;
		}
	}
	if( $thread['threadclassid'] == FORUM_ZIYUANHUZHU_CLASSID ) {
		if( empty($_SGLOBAL['forum_admin_FORUM_ZIYUANHUZHU_CLASSID']) ){
			$_SGLOBAL['forum_admin'] = 0;
		}
	}
	if( $thread['threadclassid'] == FORUM_XILIJUPING_CLASSID ) {
		if( empty($_SGLOBAL['forum_admin_FORUM_XILIJUPING_CLASSID']) ){
			$_SGLOBAL['forum_admin'] = 0;
		}
	}
	if( $thread['threadclassid'] == FORUM_QIZUIBASHE_CLASSID ) {
		if( empty($_SGLOBAL['forum_admin_FORUM_QIZUIBASHE_CLASSID']) ){
			$_SGLOBAL['forum_admin'] = 0;
		}
	}
	
	//传输关注/取消关注信息
	$mainpost['threaduserid'] = $thread['threaduserid'];
	
	//处理视频标签
	$mainpost['message'] = thread_bbcode($mainpost['message']);
	
	$psql = "";
	if( $_GET['view']=='viewposter' ){
		$psql = " ( (uid != 0 OR uid != null) AND uid='$thread[uid]' ) AND ";
	}
	
	$csql = "SELECT count(*) AS count FROM ".tname('post')." WHERE $psql tid='$thread[tid]' AND deleteflag!=2 AND isthread='0'";
	$count = $_SGLOBAL['db']->cachequery($MODULE_NAME, $csql, true);
	$count = $count['count'];
	
	$perpage = 30;
	//分页
	if(intval($_GET['page'])<1){
		$page=intval($count/$perpage) + 1;
		$start = ($count - $perpage)>0?($count - $perpage):0;
	}
	else{
		$page = intval($_GET['page']);
		$start = ($page-1)*$perpage;
	}
		
	//检查开始数
	ckstart($start, $perpage);
	
	$qsql = "SELECT * FROM ".tname('post')." WHERE $psql tid='$thread[tid]' AND isthread='0' AND deleteflag!=2 ORDER BY number LIMIT $start,$perpage";
	$postlist=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "postlist", "querypost", array($qsql), $page == intval( ($count-1)/$perpage )+1?0:1800);
	
	//分页
	$multi = multi($count, $perpage, $page, "space.php?do=forum&tid=$threadid");
	
	//关注/取消
	//访问统计
	//TODO need to research
	if($_SCOOKIE['view_tid'] != $threadid) {
		$_SGLOBAL['db']->query("UPDATE ".tname('mtag_thread')." SET viewnum=viewnum+1 WHERE tid='$threadid'");
		ssetcookie('view_tid', $threadid);
	}
		
	$canhotcoldthread=($thread['uid'] != $_SGLOBAL['supe_uid']) && ($_SCOOKIE['hotcold_tid'] != $threadid);
	
	$_TPL['css'] = 'forum';
	$searchengine_description=$thread['subject'].":".getstr(strip_tags($mainpost['message']), 40, 0, 0, 0, 0, -1);
	include_once template("space_forum");
}

?>