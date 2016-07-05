<?php
/*
 [UCenter Home] (C) 2007-2008 Comsenz Inc.
 $Id: cp_topic.php 12436 2009-06-25 09:07:38Z liguode $
 */

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

$MODULE_NAME = "SPACE_FORUM";

//检查信息
$tid = empty($_GET['tid'])?0:intval($_GET['tid']);
$op = empty($_GET['op'])?'':$_GET['op'];

include_once(S_ROOT.'./source/function_thread.php');
include_once(S_ROOT.'./source/function_bbcode.php');

if($_GET['op'] == 'newthread') {

	if( empty($_SGLOBAL['supe_uid']) ){
		showmessage("to_login");
	}
	
	$thread = array();
	$thread['uid'] = $_SGLOBAL['supe_uid'];
	$thread['username'] = $_SGLOBAL['supe_username'];
	
	$post = array();
	$post['uid'] = $_SGLOBAL['supe_uid'];
	$post['username'] = $_SGLOBAL['supe_username'];
	
	
	if( !empty($_GET[threadclassid]) ){
		$thread[threadclassid] = $_GET[threadclassid];
		
		if( $thread[threadclassid] == FORUM_XILIJUPING_CLASSID){
			$topicid = $_GET[topicid];
			if( !empty($topicid) ){
				include_once(S_ROOT.'./source/function_topic.php');
				$topic = loadtopicbyid($topicid);
				if( !empty($topic) ){
					$topic = topicsingleformmapper($topic);
					$thread[subject] = "评".$topic[subject].":";
					$post[message] = "<br/><br/><br/>收听链接：<a href='space.php?do=topic&topicid=1003228' target='_blank'>http://www.echodrama.com/space.php?do=topic&topicid=1003228</a><br/>";
				}
			}
		}
	}
	
	//发起话题
	$threadclasslist = listthreadclassbymtagid(FORUM_TAGID);
	
	//获取相册
	$albums = getalbums($_SGLOBAL['supe_uid']);
	
	include template('cp_forum');
}
elseif( $_GET['op'] == 'editthread' ){
	//http://www.echodrama.com/cp.php?ac=thread&op=edit&pid=43&tagid=8
	
	if( empty($_SGLOBAL['supe_uid']) ){
		showmessage("to_login");
	}
	
	$thread = loadthreadbyid($tid);
	if( empty($thread) ){
		showmessage('mtag_thread_not_exist');
	}
	
	$post = loadthreadmainpostbyid($tid);
	if( empty($post) ){
		showmessage('posting_does_not_exist');
	}
	
	if( $_GET['selectop'] == "admineditthread"){
		if( empty($_SGLOBAL['supe_uid']) || empty($_SGLOBAL['forum_admin']) ){
			showmessage('no_privilege');			
		}
	}
	elseif( $_GET['selectop'] == "editthread"){
		if( empty($thread['uid']) ) {
			showmessage('no_privilege');	
		}

		if( $thread['uid']!=$_SGLOBAL['supe_uid'] ){
			showmessage('no_privilege');
		}
	}
	else{
		showmessage('no_privilege');
	}
	
	$thread = threadformmapper($thread);
	$post = postformmapper($post);
	
	//发起话题
	$threadclasslist = listthreadclassbymtagid(FORUM_TAGID);
	
	//获取相册
	$albums = getalbums($_SGLOBAL['supe_uid']);
	
	include template('cp_forum');
}
elseif( $_GET['op'] == 'savethread' ){
	
	//create
	//验证码
	if(checkperm('seccode') && !ckseccode($_POST['seccode'])) {
		showmessage('incorrect_code');
	}
	//判断是否操作太快
	$waittime = interval_check('post');
	if($waittime > 0) {
		showmessage('operating_too_fast','',1,array($waittime));
	}
	
	if( empty($_SGLOBAL['supe_uid']) ){
		showmessage("to_login");
	}
	
	$threadclassid = $_POST['threadclassid'];
	if(empty($threadclassid)){
		showmessage('mtag_thread_threadclassid_empty');
	}
		
	//create/edit thread and priviliege validation 
	if(empty($tid)) {
		$thread = array();
		$thread['tagid'] = FORUM_TAGID;
	} 
	else {
		//edit
		$thread = loadthreadbyid($tid);
		if(empty($thread)) {
			showmessage('mtag_thread_not_exist');
		}
		
		if( $_GET['selectop'] == "admineditthread"){
			if( empty($_SGLOBAL['supe_uid']) || empty($_SGLOBAL['forum_admin']) ){
				showmessage('no_privilege');
			}
		}
		elseif( $_GET['selectop'] == "editthread"){
			if( $thread['uid']!=$_SGLOBAL['supe_uid'] ){
				showmessage('no_privilege');
			}
		}
		else{
			showmessage('no_privilege');
		}
	}
	
	$poster_uid = $_SGLOBAL['supe_uid'];
	$poster_username = $_SGLOBAL['supe_username'];
	
	$subject = getstr($_POST['subject'], 80, 1, 1, 1);
	if(strlen($subject) < 2) showmessage('mtag_thread_subject_not_too_little');
	
	$label = $_POST['label'];
	if( empty($label) ) {
		showmessage('mtag_thread_label_empty');
	}
	
	$_POST['message'] = checkhtml($_POST['message']); 
	$_POST['message'] = getstr($_POST['message'], 0, 1, 0, 1, 0, 1);
	$_POST['message'] = preg_replace("/\<div\>\<\/div\>/i", '', $_POST['message']);	
	$message = $_POST['message'];
	
	//没有填写任何东西
	$ckmessage = preg_replace("/(\<div\>|\<\/div\>|\s)+/is", '', $message);
	if(strlen($message) < 2) {
		showmessage('content_is_not_less_than_four_characters');
	}
	
	//添加slashes
	$message = addslashes($message);
	
	//标题图片
	$titlepic = '';
	
	//获取上传的图片
	$uploads = array();
	if(!empty($_POST['picids'])) {
		$picids = array_keys($_POST['picids']);
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('pic')." WHERE picid IN (".simplode($picids).") AND uid='$_SGLOBAL[supe_uid]'");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			if(empty($titlepic) && $value['thumb']) {
				$titlepic = $value['filepath'].'.thumb.jpg';
			}
			$uploads[$_POST['picids'][$value['picid']]] = $value;
		}
		if(empty($titlepic) && $value) {
			$titlepic = $value['filepath'];
		}
	}
	
	//插入文章
	if($uploads) {
		preg_match_all("/\<img\s.*?\_uchome\_localimg\_([0-9]+).+?src\=\"(.+?)\"/i", $message, $mathes);
		if(!empty($mathes[1])) {
			$searchs = $idsearchs = array();
			$replaces = array();
			foreach ($mathes[1] as $key => $value) {
				if(!empty($mathes[2][$key]) && !empty($uploads[$value])) {
					$searchs[] = $mathes[2][$key];
					$idsearchs[] = "_uchome_localimg_$value";
					$replaces[] = pic_get($uploads[$value]['filepath'], $uploads[$value]['thumb'], 0, 0);
					unset($uploads[$value]);
				}
			}
			if($searchs) {
				$message = str_replace($searchs, $replaces, $message);
				$message = str_replace($idsearchs, 'uchomelocalimg[]', $message);
			}
		}
		//未插入文章
		foreach ($uploads as $value) {
			$picurl = pic_get($value['filepath'], $value['thumb'], 0, 0);
			$message .= "<div class=\"uchome-message-pic\"><img src=\"$picurl\"><p>$value[title]</p></div>";
		}
	}
	
	
	if(empty($_POST['tid'])) {
		
		$setarr = array(
			'tagid' => FORUM_TAGID,
			'uid' => $poster_uid,
			'username' => $poster_username,
			'dateline' => $_SGLOBAL['timestamp'],
			'threadclassid' => $threadclassid,
			'subject' => $subject,
			'repaste' => $_POST['repaste'],
			'label' => $label,
			'lastpost' => $_SGLOBAL['timestamp'],
			'lastauthor' => $poster_username,
			'lastauthorid' => $poster_uid
		);
		
//		if( $threadclassid == FORUM_JISHUJIAOLIU_CLASSID){
//			
//		}
//		elseif( $threadclassid == FORUM_ZIYUANHUZHU_CLASSID){
//			
//		}
//		elseif( $threadclassid == FORUM_XILIJUPING_CLASSID){
//			if( !empty($_POST['xljp_producttype']) && !empty($_POST['xljp_productname']) ){
//				$setarr['xljp_producttype'] = $_POST['xljp_producttype'];
//				$setarr['xljp_productname'] = $_POST['xljp_productname'];
//				$setarr['xljp_productid'] = $_POST['xljp_productid'];
//			}
//			else{
//				$setarr['xljp_producttype'] = null;
//				$setarr['xljp_productname'] = null;
//				$setarr['xljp_productid'] = null;
//			}
//		}
//		elseif( $threadclassid == FORUM_QIZUIBASHE_CLASSID){
//			
//		}
		
		$tid = inserttable('mtag_thread', $setarr, 1);
		$thread['tid']=$tid;
		$psetarr = array(
			'tagid' => FORUM_TAGID,
			'tid' => $tid,
			'uid' => $poster_uid,
			'username' => $poster_username,
			'ip' => getonlineip(),
			'dateline' => $_SGLOBAL['timestamp'],
			'message' => $message,
			'isthread' => 1
		);
		//添加
		inserttable('post', $psetarr);
		
		//统计
		updatestat('thread');
	
		//积分
//		$reward = getreward('publishthread', 0);
//		$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit+$reward[credit], experience=experience+$reward[experience] WHERE uid='$_SGLOBAL[supe_uid]'");

	} 
	else {
		$tid = $_POST['tid'];
		
		$setarr = array(
			'subject' => $subject,
			'threadclassid' => $threadclassid,
			'repaste' => $_POST['repaste'],
			'label' => $label
		);
		
//		if( $threadclassid == FORUM_JISHUJIAOLIU_CLASSID){
//			
//		}
//		elseif( $threadclassid == FORUM_ZIYUANHUZHU_CLASSID){
//			
//		}
//		elseif( $threadclassid == FORUM_XILIJUPING_CLASSID){
//			if( !empty($_POST['xljp_producttype']) && !empty($_POST['xljp_productname']) ){
//				$setarr['xljp_producttype'] = $_POST['xljp_producttype'];
//				$setarr['xljp_productname'] = $_POST['xljp_productname'];
//				$setarr['xljp_productid'] = $_POST['xljp_productid'];
//			}
//			else{
//				$setarr['xljp_producttype'] = null;
//				$setarr['xljp_productname'] = null;
//				$setarr['xljp_productid'] = null;
//			}
//		}
//		elseif( $threadclassid == FORUM_QIZUIBASHE_CLASSID){
//			
//		}
//		
		updatetable('mtag_thread', $setarr, array('tid'=>$_POST['tid']));

		if( $_GET['selectop'] == "admineditthread"){
			$psetarr = array(
				'message' => $message
			);
		}
		else{
			$psetarr = array(
				'ip' => getonlineip(),
				'dateline' => $_SGLOBAL['timestamp'],
				'message' => $message
			);
			
			if(checkperm('edittrail')) {
				$message = $message.saddslashes(cplang('thread_edit_trail', array($poster_username, sgmdate('Y-m-d H:i:s'))));
				$psetarr['message'] = $message;
			}
		}
		updatetable('post', $psetarr, array('tid'=>$_POST['tid'], 'isthread'=>'1'));
	}
	
	updatesystemthreadlabel($tid, $label);
	
	//更新缓存
	$thread=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "thread", "loadthreadbyid", array($tid), 3600, true);
	$mainpost=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "threadmainpost", "loadthreadmainpostbyid", array($tid), 3600, true);
		
	if( empty($_POST['return']) ){
		showmessage('do_success', $_SGLOBAL[refer]);
	}
	else{
		showmessage('do_success', $_POST['return']);
	}
}
elseif($_GET['op'] == 'deletethread') {

	include_once(S_ROOT.'./source/function_delete.php');
	$thread = loadthreadbyid($tid);
	if( empty($thread) ){
		showmessage('mtag_thread_not_exist');
	}
	
	if( $thread[uid] == $_SGLOBAL['supe_uid'] ){
		if( $thread['replynum']>0 ) {
			showmessage('no_privilege');	
		}
	}
	elseif( $_SGLOBAL['forum_admin'] == 1 ){
	
	}
	else{
		showmessage('no_privilege');
	}
	
	deletethread($thread);
	
	//更新缓存
	$thread=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "thread", "loadthreadbyid", array($tid), 3600, true);
	
	showmessage('do_success', "space.php?do=forum", 0);
}
elseif( $_GET['op'] == 'hotthread' ){
	$thread = loadthreadbyid($tid);
	if( empty($thread) ){
		showmessage('mtag_thread_not_exist');
	}
	
	if( empty($thread['uid']) ) {
		showmessage('no_privilege');	
	}
	
	if( ($thread['uid'] != $_SGLOBAL['supe_uid']) && ($_SCOOKIE['hotcold_tid'] != $thread['tid']) ) {
		$_SGLOBAL['db']->query("UPDATE ".tname('mtag_thread')." SET hot=hot+1 WHERE tid='$thread[tid]'");
		ssetcookie('hotcold_tid', $tid);
	}
	
	$thread=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "thread", "loadthreadbyid", array($tid), 3600, true);
	$mainpost=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "threadmainpost", "loadthreadmainpostbyid", array($tid), 3600, true);
	
	showmessage('ajax_param', '', 0, array($_GET['op']));
}
elseif( $_GET['op'] == 'coldthread' ){
	$thread = loadthreadbyid($tid);
	if( empty($thread) ){
		showmessage('mtag_thread_not_exist');
	}
	
	if( empty($thread['uid']) ) {
		showmessage('no_privilege');	
	}
	
	//check permission
	if( ($thread['uid'] != $_SGLOBAL['supe_uid']) && ($_SCOOKIE['hotcold_tid'] != $thread['tid']) ) {
		$_SGLOBAL['db']->query("UPDATE ".tname('mtag_thread')." SET cold=cold+1 WHERE tid='$thread[tid]'");
		ssetcookie('hotcold_tid', $tid);
	}
	
	$thread=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "thread", "loadthreadbyid", array($tid), 3600, true);
	$mainpost=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "threadmainpost", "loadthreadmainpostbyid", array($tid), 3600, true);
	
	showmessage('ajax_param', '', 0, array($_GET['op']));
}
elseif( $_GET['op'] == 'bookmarkthread' ){
	$thread = loadthreadbyid($tid);
	if( empty($thread) ){
		showmessage('mtag_thread_not_exist');
	}
	
	if( empty($thread['uid']) ) {
		showmessage('no_privilege');	
	}
	
	if($_GET['tobookmark']==0){
		//取消收藏
		$tuSql = "DELETE FROM ".tname('mtag_thread_user')." WHERE tid=$tid and uid=$_SGLOBAL[supe_uid]";
		$_SGLOBAL['db']->query($tuSql);
		
	}else if($_GET['tobookmark']==1){
		//加入收藏
		$tuSql = "SELECT COUNT(id) FROM ".tname('mtag_thread_user')." WHERE tid=$tid and uid=$_SGLOBAL[supe_uid]";
		$tuCount = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($tuSql), 0);
		if($tuCount<=0){
			$threaduser = Array();
			$threaduser['id'] = null;
			$threaduser['uid'] = $_SGLOBAL['supe_uid'];
			$threaduser['tid'] = $tid;
			$threaduser['username'] = $_SGLOBAL['supe_username'];
			$threaduser['dateline'] = $_SGLOBAL['timestamp'];
			inserttable("mtag_thread_user", $threaduser);
		}
	}else{
		showMessage("no action");	
	}
	
	showMessage('do_success', "space.php?do=forum&view=viewall&tid=$tid", 0);
}
elseif($_GET['op'] == 'newpost') {
	$thread = loadthreadbyid($tid);
	if( empty($thread) ){
		showmessage('mtag_thread_not_exist');
	}
	
	include template('cp_form');
} 
elseif($_GET['op'] == 'replypost') {
	
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('post')." WHERE pid='$_GET[pid]'");
	if(!$relatedpost = $_SGLOBAL['db']->fetch_array($query)) {
		showmessage('posting_does_not_exist');
	}

	if( $relatedpost['deleteflag']==1){
		showmessage("posting_relatedpost_be_deleted");
	}
	
	$relatedpost['origin_message'] = $relatedpost['message'];
	
	$relatedpost['message'] = preg_replace("/\<div class=\"quote\"\>\<span class=\"q\"\>.*?\<\/span\>\<\/div\>/is", '', $relatedpost['message']);
	//移除编辑记录
	$relatedpost['message'] = preg_replace("/<ins class=\"modify\".+?<\/ins>/is", '',$relatedpost['message']);
	
	$relatedpost['message'] = html2bbcode($relatedpost['message']);//显示用
		
	$thread = loadthreadbyid($relatedpost['tid']);
	if( empty($thread) ){
		showmessage('mtag_thread_not_exist');
	}
	include template('cp_forum');
} 
elseif($_GET['op'] == 'editpost') {
	
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('post')." WHERE pid='$_GET[pid]'");
	if(!$post = $_SGLOBAL['db']->fetch_array($query)) {
		showmessage('posting_does_not_exist');
	}
	
	if( $_GET['selectop'] == "admineditpost"){
		if( empty($_SGLOBAL['supe_uid']) || empty($_SGLOBAL['forum_admin']) ){
			showmessage('no_privilege');			
		}
	}
	elseif( $_GET['selectop'] == "editpost"){
		if( empty($post['uid']) ) {
			showmessage('no_privilege');	
		}
		
		if( empty($_SGLOBAL['supe_uid']) || $post[uid]!=$_SGLOBAL['supe_uid'] ){
			showmessage('no_privilege');
		}
	}
	else{
		showmessage('no_privilege');
	}
	
	$thread = loadthreadbyid($post['tid']);
	if( empty($thread) ){
		showmessage('mtag_thread_not_exist');
	}
	
	$post['message'] = html2bbcode($post['message']);//显示用
	include template('cp_forum');
} 
elseif($_GET['op'] == 'deletepost') {

	$post = loadpostbyid($_GET['pid']);
	if(empty($post)) {
		showmessage('posting_does_not_exist');
	}
	if( $post['deleteflag']==1){
		showmessage("posting_be_deleted");
	}
	
	if( empty($_SGLOBAL['supe_uid']) ) {
		showmessage('no_privilege');	
	}
	
	if( $post['uid']!=$_SGLOBAL['supe_uid'] ) {
		
	}
	elseif( $_SGLOBAL['forum_admin'] == 1 ){
	
	}
	else{
		showmessage('no_privilege');
	}
	
	$_SGLOBAL['db']->query("UPDATE ".tname("post")." SET deleteflag=2 WHERE pid='$post[pid]'");
	
	//更新统计数据
	$updatethreadsql = "UPDATE ".tname('mtag_thread')."	SET replynum=(SELECT count(*) FROM ".tname('post')." WHERE tid = '$thread[tid]' AND isthread = 0 ), lastpost='$_SGLOBAL[timestamp]', lastauthor='$_SGLOBAL[supe_username]', lastauthorid='$_SGLOBAL[supe_uid]'	WHERE tid='$thread[tid]'";
	$_SGLOBAL['db']->query($updatethreadsql);
		
	$thread=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "thread", "loadthreadbyid", array($post[tid]), 3600, true);
	$mainpost=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "threadmainpost", "loadthreadmainpostbyid", array($post[tid]), 3600, true);
	
	showmessage('do_success', $_SGLOBAL[refer]);
}
elseif($_GET['op'] == 'hidepost') {

	$post = loadpostbyid($_GET['pid']);
	if(empty($post)) {
		showmessage('posting_does_not_exist');
	}
	if( $post['deleteflag']==1){
		showmessage("posting_be_deleted");
	}
	
	if( empty($_SGLOBAL['supe_uid']) ) {
		showmessage('no_privilege');	
	}
	
	if( $_SGLOBAL['forum_admin'] == 1 ){
	
	}
	else{
		showmessage('no_privilege');
	}
	
	$_SGLOBAL['db']->query("UPDATE ".tname("post")." SET deleteflag=1 WHERE pid='$post[pid]'");
	
	$thread=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "thread", "loadthreadbyid", array($post[tid]), 3600, true);
	$mainpost=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "threadmainpost", "loadthreadmainpostbyid", array($post[tid]), 3600, true);
	
	showmessage('do_success', $_SGLOBAL[refer]);
}
elseif( $_GET['op'] == 'savepost' ){
	
	$postid = $_GET['pid'];
	//create
	//验证码
	if(checkperm('seccode') && !ckseccode($_POST['seccode'])) {
		showmessage('incorrect_code');
	}
	
	//判断是否操作太快
	$waittime = interval_check('post');
	if($waittime > 0) {
		showmessage('operating_too_fast','',1,array($waittime));
	}
	
	$thread = loadthreadbyid($_POST['tid']);
	if(empty($thread)) {
		showmessage('mtag_thread_not_exist');
	}
	
	if( empty($postid) ) {
		$post = array();
	} 
	else {
		//edit
		$post = loadpostbyid($postid);
		if(empty($post)) {
			showmessage('posting_does_not_exist');
		}
		
		if( $post['deleteflag']==1){
			showmessage("posting_be_deleted");
		}
		
		if( $_POST['selectop'] == "admineditpost"){
			if( empty($_SGLOBAL['supe_uid']) || empty($_SGLOBAL['forum_admin']) ){
				showmessage('no_privilege');
			}
		}
		elseif( $_POST['selectop'] == "editpost"){
			if( empty($_SGLOBAL['supe_uid']) || $_SGLOBAL['supe_uid']!=$post['uid'] ){
				showmessage('no_privilege');
			}
		}
		else{
			showmessage('no_privilege');
		}
	}

	$poster_uid = 0;
	$poster_username = "";
	
	if( empty($_POST['fakemark']) ){
		if( empty($_SGLOBAL['supe_uid']) ){
			showmessage('no_privilege');
		}
		$poster_uid = $_SGLOBAL['supe_uid'];
		$poster_username = $_SGLOBAL['supe_username'];
	}
	else{
		if( empty($_POST['username']) ){
			showmessage('username_empty');
		}
			
		$poster_uid = 0;
		$poster_username = $_POST['username'];
	}
	
	//评论处理
	$message = $_POST['message'];

	$message = getstr($message, 0, 1, 1, 1, 2, 1);
	if(strlen($message) < 2) {
		showmessage('content_is_not_less_than_four_characters');
	}
	
	//摘要
	$summay = getstr($message, 150, 1, 1);
	
	//引用回复
	if(!empty($_POST['relatedpid'])){
		$relatedpost = loadpostbyid($_POST['relatedpid']);
		if(empty($relatedpost)) {
			showmessage("posting_relatedpost_does_not_exist");
		}
	
		if( $relatedpost['deleteflag']==1){
			showmessage("posting_relatedpost_be_deleted");
		}
		
		$relatedpost['message'] = strip_tags($relatedpost['message']);
		$relatedpost['message'] = preg_replace("/\<div class=\"quote\"\>\<span class=\"q\"\>.*?\<\/span\>\<\/div\>/is", '', $relatedpost['message']);
		//移除编辑记录
		$relatedpost['message'] = preg_replace("/<ins class=\"modify\".+?<\/ins>/is", '',$relatedpost['message']);
		$relatedpost['message'] = html2bbcode($relatedpost['message']);//显示用
		$message = addslashes("<div class=\"quote\"><span class=\"q\"><b>".$relatedpost['username']."</b>: ".getstr($relatedpost['message'], 150, 0, 0, 0, 2, 1).'</span></div>').$message;
	}
	
	if(empty($postid)) {
		
		$querynumbersql="select max(p.number) maxnumber from ".tname('post')." p where p.tid='$thread[tid]'";
		$querynumber = $_SGLOBAL['db']->query($querynumbersql);
		$queryresult = $_SGLOBAL['db']->fetch_array($querynumber);
		$number = $queryresult['maxnumber'];
		$number = $number + 1;
		
		$setarr = array(
			'tagid' => FORUM_TAGID,
			'tid' => $thread['tid'],
			'uid' => $poster_uid,
			'username' => $poster_username,
			'ip' => getonlineip(),
			'deleteflag' => 0,
			'number' => $number,
			'dateline' => $_SGLOBAL['timestamp'],
			'message' => $message
		);
		$pid = inserttable('post', $setarr, 1);
		
		//更新统计数据
		$updatethreadsql = "UPDATE ".tname('mtag_thread')."	SET replynum=(SELECT count(*) FROM ".tname('post')." WHERE tid = '$thread[tid]' AND isthread = 0 ), lastpost='$_SGLOBAL[timestamp]', lastauthor='$_SGLOBAL[supe_username]', lastauthorid='$_SGLOBAL[supe_uid]'	WHERE tid='$thread[tid]'";
		$_SGLOBAL['db']->query($updatethreadsql);
		
		//消息通知
		$noticeuidarray = array();
			
		$querymembersql="SELECT DISTINCT mtu.uid FROM ".tname("mtag_thread_user")." mtu WHERE mtu.tid=$thread[tid] AND mtu.uid!=$_SGLOBAL[supe_uid]";
		$query = $_SGLOBAL['db']->query($querymembersql);
		while ($member = $_SGLOBAL['db']->fetch_array($query)) {
			notification_add($member['uid'], 'mtag_post_new', "在帖子<a href=\"space.php?do=forum&view=viewall&tid=$thread[tid]\" target=\"_blank\">$thread[subject]</a>中留言了。");
		}
	} 
	else {
		//edit
		if( $_POST['selectop'] == "admineditpost"){
			$psetarr = array(
				'ip' => getonlineip(),
				'dateline' => $_SGLOBAL['timestamp'],
				'message' => $message
			);
		}
		else{
			$psetarr = array(
				'message' => $message
			);
		}
		updatetable('post', $psetarr, array('pid'=>$postid));
	}
	
	//统计
	updatestat('post');
	if( empty($_POST['return']) ){
		showmessage('do_success', $_SGLOBAL[refer]);
	}
	else{
		showmessage('do_success', $_POST['return']);
	}
}
elseif($_GET['op'] == 'loadpost') {
	$postid = empty($_GET['postid'])?0:intval($_GET['postid']);
	
	if($postid) {
		$postidsql = "pid='$postid' AND";
		$ajax_edit = 1;
	} else {
		$postidsql = '';
		$ajax_edit = 0;
	}

	//评论
	$list = array();
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('post')." WHERE $postidsql 1=1 ORDER BY dateline DESC LIMIT 0,1");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$list[] = $value;
	}
	
	include template('cp_post');
}
elseif($_GET['op'] == 'setdisplayportal') {

	if( $_SGLOBAL['forum_admin'] == 1 ){
	
	}
	else{
		showmessage('no_privilege');
	}
		
	$thread = loadthreadbyid($tid);
	if(empty($thread)) {
		showmessage('mtag_thread_not_exist');
	}
	
	displayportalthreads($thread['tagid'], array($thread['tid']), 1);
	
	//更新缓存
	$thread=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "thread", "loadthreadbyid", array($tid), 3600, true);
	
	showmessage('do_success');
} 
elseif($_GET['op'] == 'canceldisplayportal') {
		
	if( $_SGLOBAL['forum_admin'] == 1 ){
	
	}
	else{
		showmessage('no_privilege');
	}
	
	$thread = loadthreadbyid($tid);
	if(empty($thread)) {
		showmessage('mtag_thread_not_exist');
	}
	
	displayportalthreads($thread['tagid'], array($thread['tid']), 0);
	
	//更新缓存
	$thread=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "thread", "loadthreadbyid", array($tid), 3600, true);
	
	showmessage('do_success');
}
elseif($_GET['op'] == 'setdigest') {

	if( $_SGLOBAL['forum_admin'] == 1 ){
	
	}
	else{
		showmessage('no_privilege');
	}
		
	$thread = loadthreadbyid($tid);
	if(empty($thread)) {
		showmessage('mtag_thread_not_exist');
	}
	
	digestthreads($thread['tagid'], array($thread['tid']), 1);
	
	//更新缓存
	$thread=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "thread", "loadthreadbyid", array($tid), 3600, true);
	
	showmessage('do_success');
} 
elseif($_GET['op'] == 'canceldigest') {
		
	if( $_SGLOBAL['forum_admin'] == 1 ){
	
	}
	else{
		showmessage('no_privilege');
	}
	
	$thread = loadthreadbyid($tid);
	if(empty($thread)) {
		showmessage('mtag_thread_not_exist');
	}
	
	digestthreads($thread['tagid'], array($thread['tid']), 0);
	
	//更新缓存
	$thread=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "thread", "loadthreadbyid", array($tid), 3600, true);
	
	showmessage('do_success');
} 
elseif($_GET['op'] == 'settop') {

	if( $_SGLOBAL['forum_admin'] == 1 ){
	
	}
	else{
		showmessage('no_privilege');
	}

	$thread = loadthreadbyid($tid);
	if(empty($thread)) {
		showmessage('mtag_thread_not_exist');
	}
	
	topthreads(FORUM_TAGID, array($thread['tid']), 1);

	//更新缓存
	//置顶帖
	$systemthreadlist=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "systemthreadlist", "queryforumsystemthread", array(FORUM_TAGID), 86400, true);
	$thread=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "thread", "loadthreadbyid", array($tid), 3600, true);
	
	showmessage('do_success');
} 
elseif($_GET['op'] == 'canceltop') {

	if( $_SGLOBAL['forum_admin'] == 1 ){
	
	}
	else{
		showmessage('no_privilege');
	}

	$thread = loadthreadbyid($tid);
	if(empty($thread)) {
		showmessage('mtag_thread_not_exist');
	}
	
	topthreads(FORUM_TAGID, array($thread['tid']), 0);
	
	//更新缓存
	//置顶帖
	$systemthreadlist=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "systemthreadlist", "queryforumsystemthread", array(FORUM_TAGID), 86400, true);
	$thread=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "thread", "loadthreadbyid", array($tid), 3600, true);
	
	showmessage('do_success');
} 
elseif($_GET['op'] == 'setbottom') {

	if( $_SGLOBAL['forum_admin'] == 1 ){
	
	}
	else{
		showmessage('no_privilege');
	}

	$thread = loadthreadbyid($tid);
	if(empty($thread)) {
		showmessage('mtag_thread_not_exist');
	}
	
	bottomthreads(FORUM_TAGID, array($thread['tid']), 1);

	//更新缓存
	//置底帖
	$thread=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "thread", "loadthreadbyid", array($tid), 3600, true);
	
	showmessage('do_success');
} 
elseif($_GET['op'] == 'cancelbottom') {

	if( $_SGLOBAL['forum_admin'] == 1 ){
	
	}
	else{
		showmessage('no_privilege');
	}

	$thread = loadthreadbyid($tid);
	if(empty($thread)) {
		showmessage('mtag_thread_not_exist');
	}
	
	bottomthreads(FORUM_TAGID, array($thread['tid']), 0);
	
	//更新缓存
	//置底帖
	$thread=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "thread", "loadthreadbyid", array($tid), 3600, true);
	
	showmessage('do_success');
} 
elseif($_GET['op'] == 'querythreadclassbytagid_ajax') {
	
	$threadclasslist=listthreadclassbymtagid(FORUM_TAGID);
	
	include_once template("querythreadclassbytagid_ajax");
} 

//屏蔽html
function checkhtml($html) {
	$html = stripslashes($html);
	if(!checkperm('allowhtml')) {
		
		preg_match_all("/\<([^\<]+)\>/is", $html, $ms);

		$searchs[] = '<';
		$replaces[] = '&lt;';
		$searchs[] = '>';
		$replaces[] = '&gt;';
		
		if($ms[1]) {
			$allowtags = 'img|a|font|div|table|tbody|caption|tr|td|th|br|p|b|strong|i|u|em|span|ol|ul|li|blockquote|object|param|embed';//允许的标签
			$ms[1] = array_unique($ms[1]);
			foreach ($ms[1] as $value) {
				$searchs[] = "&lt;".$value."&gt;";
				$value = shtmlspecialchars($value);
				$value = str_replace(array('\\','/*'), array('.','/.'), $value);
				$value = preg_replace(array("/(javascript|script|eval|behaviour|expression)/i", "/(\s+|&quot;|')on/i"), array('.', ' .'), $value);
				if(!preg_match("/^[\/|\s]?($allowtags)(\s+|$)/is", $value)) {
					$value = '';
				}
				$replaces[] = empty($value)?'':"<".str_replace('&quot;', '"', $value).">";
			}
		}
		$html = str_replace($searchs, $replaces, $html);
	}
	$html = addslashes($html);
	
	return $html;
}


?>