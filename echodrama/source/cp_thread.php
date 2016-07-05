<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: cp_thread.php 13245 2009-08-25 02:01:40Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}
include_once(S_ROOT.'./source/function_mtag.php');
include_once(S_ROOT.'./source/function_thread.php');

$_GET['op'] = empty($_GET['op'])?'newthread':$_GET['op'];
$threadid = $_GET['tid'];

include_once(S_ROOT.'./source/function_bbcode.php');
include_once(S_ROOT.'./source/function_blog.php');
if( $_GET['op'] == 'newthread' ) {

	//发起话题
	$tagid = empty($_GET['tagid'])?0:intval($_GET['tagid']);

	if($tagid) {
		$mtag = ckmtagmember($tagid);
		
		$fansgrade = checkfansgrade($tagid, $_SGLOBAL['supe_uid']);
		
		//是否允许发
		if($fansgrade < 4 && $fansgrade > 0 ) {
			showmessage('no_privilege');
		}
	}
	else{
		//我关注的群组列表
		$mtaglist = listtagbyfansgrademaintainthread($_SGLOBAL['supe_uid']);
	}
	
	include template('cp_thread');
}
elseif( $_GET['op'] == 'editthread' ){
	//http://www.echodrama.com/cp.php?ac=thread&op=edit&pid=43&tagid=8

	$thread = loadthreadbyid($threadid);
	if( empty($thread) ){
		showmessage('mtag_thread_not_exist');
	}
	
	$post = loadthreadmainpostbyid($threadid);
	if( empty($post) ){
		showmessage('posting_does_not_exist');
	}
	
	$mtag = ckmtagmember($thread['tagid']);
	$fansgrade = checkfansgrade($mtag['tagid'], $_SGLOBAL['supe_uid']);
	$membergrade = checkmembergrade($mtag['tagid'], $_SGLOBAL['supe_uid']);
	
	//check permission
	if($fansgrade < 4 && $fansgrade > 0 ) {
		showmessage('no_privilege');
	}
	
	if( $thread['uid'] != $_SGLOBAL['supe_uid']){
		showmessage('no_privilege');
	}
	
	$thread = threadformmapper($thread);
	$post = postformmapper($post);
	$mtag = mtagformmapper($mtag);
	$tagid = $mtag['tagid'];

	include template('cp_thread');
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
	
	//create/edit thread
	if(empty($threadid)) {
		$thread = array();
		$thread['tagid'] = $_POST['tagid'];
	} 
	else {
		//edit
		$thread = loadthreadbyid($threadid);
		if(empty($thread)) {
			showmessage('mtag_thread_not_exist');
		}
	}
	
	//检查权限
	$mtag = ckmtagmember($thread['tagid']);

	//是否允许发
	$fansgrade = checkfansgrade($thread['tagid'], $_SGLOBAL['supe_uid']);
	if($fansgrade < 4 && $fansgrade > 0 ) {
		showmessage('no_privilege');
	}

	$subject = getstr($_POST['subject'], 80, 1, 1, 1);
	if(strlen($subject) < 2) showmessage('mtag_thread_subject_not_too_little');
	
	$threadclassid = $_POST['threadclassid'];
	if($threadclassid=="-1"){
		showmessage('mtag_thread_threadclassid_empty');
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
	
	if(empty($_POST['tid'])) {
		
		$setarr = array(
			'tagid' => $thread['tagid'],
			'uid' => $_SGLOBAL['supe_uid'],
			'username' => $_SGLOBAL['supe_username'],
			'dateline' => $_SGLOBAL['timestamp'],
			'threadclassid' => $threadclassid,
			'subject' => $subject,
			'lastpost' => $_SGLOBAL['timestamp'],
			'lastauthor' => $_SGLOBAL['supe_username'],
			'lastauthorid' => $_SGLOBAL['supe_uid']
		);

		$threadid = inserttable('mtag_thread', $setarr, 1);
		$thread['tid']=$threadid;
		$psetarr = array(
			'tagid' => $thread['tagid'],
			'tid' => $threadid,
			'uid' => $_SGLOBAL['supe_uid'],
			'username' => $_SGLOBAL['supe_username'],
			'ip' => getonlineip(),
			'dateline' => $_SGLOBAL['timestamp'],
			'message' => $message,
			'isthread' => 1
		);
		//添加
		inserttable('post', $psetarr);
		
		//统计
		updatestat('thread');
		
		//更新用户统计
		if(empty($space['threadnum'])) {
			$space['threadnum'] = getcount('mtag_thread', array('uid'=>$space['uid']));
			$threadnumsql = "threadnum=".$space['threadnum'];
		} else {
			$threadnumsql = 'threadnum=threadnum+1';
		}
		
		//消息通知
		$noticeuidarray = array();
		
		$querymembersql="SELECT DISTINCT mm.uid FROM ".tname("mtagmember")." mm WHERE mm.tagid=$mtag[tagid] AND mm.uid!=$_SGLOBAL[supe_uid]";
		$query = $_SGLOBAL['db']->query($querymembersql);
		while ($member = $_SGLOBAL['db']->fetch_array($query)) {
			$member_uid = $member['uid'];
			if( empty($noticeuidarray[$member_uid]) ){
				$noticeuidarray[$member_uid] = "1";
				notification_add($member_uid, 'mtag_thread_new', "在群组<a href=\"space.php?do=mtag&tagid=$mtag[tagid]\" >$mtag[tagname]</a>中发布了新话题<br/><a href=\"space.php?do=thread&tid=$threadid\" >$subject</a>");
			}
		}
		
		$queryfanssql="SELECT DISTINCT mf.uid FROM ".tname("mtagfans")." mf WHERE mf.deleteflag=0 AND mf.fansgradeid>1 AND mf.tagid=$mtag[tagid] AND mf.uid!=$_SGLOBAL[supe_uid]";
		$query = $_SGLOBAL['db']->query($queryfanssql);
		while ($fans = $_SGLOBAL['db']->fetch_array($query)) {
			$fans_uid = $fans['uid'];
			if( empty($noticeuidarray[$fans_uid]) ){
				$noticeuidarray[$fans_uid] = "1";
				notification_add($fans_uid, 'mtag_thread_new', "在群组<a href=\"space.php?do=mtag&tagid=$mtag[tagid]\" >$mtag[tagname]</a>中发布了新话题<br/><a href=\"space.php?do=thread&tid=$threadid\" >$subject</a>");
			}
		}	
		
		//积分
		$reward = getreward('publishthread', 0);
		$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit+$reward[credit], experience=experience+$reward[experience] WHERE uid='$_SGLOBAL[supe_uid]'");

	} else {
		$setarr = array(
			'subject' => $subject
		);
		updatetable('mtag_thread', $setarr, array('tid'=>$_POST['tid']));

		$psetarr = array(
			'ip' => getonlineip(),
			'message' => $message
		);
		if(checkperm('edittrail')) {
			$message = $message.saddslashes(cplang('thread_edit_trail', array($_SGLOBAL['supe_username'], sgmdate('Y-m-d H:i:s'))));
			$psetarr['message'] = $message;
		}
		updatetable('post', $psetarr, array('tid'=>$_POST['tid'], 'isthread'=>1));
	}
	
	//更新群组统计
	$_SGLOBAL['db']->query("UPDATE ".tname("mtag")." SET threadnum=(select count(*) from ".tname('mtag_thread')." mt where mt.tagid=$thread[tagid]) where tagid=$thread[tagid]");
	
	//事件
	if($_POST['makefeed']) {
		include_once(S_ROOT.'./source/function_feed.php');
		feed_publish($threadid, 'tid', empty($_POST['tid'])?1:0);
	}
	showmessage('do_success', "space.php?do=mtag&tagid=$thread[tagid]&view=threads", 0);
}
elseif($_GET['op'] == 'deletethread') {

	include_once(S_ROOT.'./source/function_delete.php');
	$thread = loadthreadbyid($threadid);
	if( empty($thread) ){
		showmessage('mtag_thread_not_exist');
	}
	
	//check permission
	$membergrade = checkmembergrade($thread['tagid'], $_SGLOBAL['supe_uid']);
	if($membergrade < 8){
		showmessage('no_privilege');
	}
	
	deletethread($thread);
	showmessage('do_success', "space.php?do=mtag&tagid=$thread[tagid]&view=threads", 0);
}
elseif( $_GET['op'] == 'hotthread' ){
	$thread = loadthreadbyid($threadid);
	if( empty($thread) ){
		showmessage('mtag_thread_not_exist');
	}
	
	//check permission
	$fansgrade = checkfansgrade($thread['tagid'], $_SGLOBAL['supe_uid']);
	if($fansgrade < 4){
		showmessage('no_privilege');
	}
	
	if( ($thread['uid'] != $_SGLOBAL['supe_uid']) && ($_SCOOKIE['hotcold_tid'] != $thread['tid']) ) {
		$_SGLOBAL['db']->query("UPDATE ".tname('mtag_thread')." SET hot=hot+1 WHERE tid='$thread[tid]'");
		ssetcookie('hotcold_tid', $threadid);
	}
	showmessage('do_success', "space.php?do=thread&tid=$thread[tid]", 0);
}
elseif( $_GET['op'] == 'coldthread' ){
	$thread = loadthreadbyid($threadid);
	if( empty($thread) ){
		showmessage('mtag_thread_not_exist');
	}
	
	//check permission
	$fansgrade = checkfansgrade($thread['tagid'], $_SGLOBAL['supe_uid']);
	if($fansgrade < 4){
		showmessage('no_privilege');
	}
	
	if( ($thread['uid'] != $_SGLOBAL['supe_uid']) && ($_SCOOKIE['hotcold_tid'] != $thread['tid']) ) {
		$_SGLOBAL['db']->query("UPDATE ".tname('mtag_thread')." SET cold=cold+1 WHERE tid='$thread[tid]'");
		ssetcookie('hotcold_tid', $threadid);
	}
	showmessage('do_success', "space.php?do=thread&tid=$thread[tid]", 0);
}
elseif($_GET['op'] == 'reply') {
	
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('post')." WHERE pid='$_GET[pid]'");
	if(!$post = $_SGLOBAL['db']->fetch_array($query)) {
		showmessage('posting_does_not_exist');
	}
	
	include template('cp_post');
	
} 
elseif($_GET['op'] == 'editpost') {
	
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('post')." WHERE pid='$_GET[pid]'");
	if(!$post = $_SGLOBAL['db']->fetch_array($query)) {
		showmessage('posting_does_not_exist');
	}
	
	$post['message'] = html2bbcode($post['message']);//显示用
	include template('cp_post');
} 
elseif($_GET['op'] == 'deletepost') {

	include_once(S_ROOT.'./source/function_delete.php');

	$post = loadpostbyid($_GET['pid']);
	if(empty($post)) {
		showmessage('posting_does_not_exist');
	}
	if( $post['deleteflag']==1){
		showmessage("posting_be_deleted");
	}
	
	$mtag = ckmtagmember($post['tagid']);
	$membergrade = checkmembergrade($post['tagid'], $_SGLOBAL['supe_uid']);
	if( ($membergrade >= 8) || ( $post['uid']==$_SGLOBAL['supe_uid'] && !empty($post['uid'])) ) {
	}
	else{
		showmessage('no_privilege');
	}

	if(submitcheck('deletesubmit')) {
		$_SGLOBAL['db']->query("UPDATE ".tname("post")." SET deleteflag=1 WHERE pid='$post[pid]'");
		showmessage('do_success', "space.php?do=thread&tid=$thread[tid]",1);
	}
	else{
		include template('cp_post');
	}
}
elseif( $_GET['op'] == 'savepost' ){
	if(!checkperm('allowpost')) {
		ckspacelog();
		showmessage('no_privilege');
	}
		
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
	
	//评论处理
	$message = $_POST['message'];
	
	//处理网络图片
	if(!empty($_POST['pics'])) {
		foreach($_POST['pics'] as $key => $pic) {
			$picurl = picurl_get($pic);
			if(!empty($picurl)) {
				$message .= "\n[img]".$picurl."[/img]";
			}
		}
	}

	$message = getstr($message, 0, 1, 1, 1, 2);
	if(strlen($message) < 2) {
		showmessage('content_is_not_less_than_four_characters');
	}
	
	//摘要
	$summay = getstr($message, 150, 1, 1);
	
	//区分 闲聊区/话题区
	if( $_POST['tid'] == 0 ){
		$thread = array();//fake thread
		$thread['tid'] = 0;
		$thread['tagid'] = $_POST['tagid'];
	}
	else{
		$thread = loadthreadbyid($_POST['tid']);
		if(empty($thread)) {
			showmessage('mtag_thread_not_exist');
		}
	}
		
	$notification_type = null;
	$notification_uids = array();

	
	if(empty($pid)) {
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
	}
	
	//检查权限
	$mtag = ckmtagmember($thread['tagid']);
	
	//是否允许发
	$fansgrade = checkfansgrade($thread['tagid'], $_SGLOBAL['supe_uid']);
	if($fansgrade < 3 && $fansgrade > 0 ) {
		showmessage('no_privilege');
	}
	
	$membergrade = checkmembergrade($post['tagid'], $_SGLOBAL['supe_uid']);
	
	//引用回复
	if(!empty($_POST['relatedpid'])){
		$relatedpost = loadpostbyid($_POST['relatedpid']);
		if(empty($relatedpost)) {
			showmessage("posting_relatedpost_does_not_exist");
		}
	
		if( $relatedpost['deleteflag']==1){
			showmessage("posting_relatedpost_be_deleted");
		}
		

		$relatedpost['message'] = preg_replace("/\<div class=\"quote\"\>\<span class=\"q\"\>.*?\<\/span\>\<\/div\>/is", '', $relatedpost['message']);
		//移除编辑记录
		$relatedpost['message'] = preg_replace("/<ins class=\"modify\".+?<\/ins>/is", '',$relatedpost['message']);
		$relatedpost['message'] = html2bbcode($relatedpost['message']);//显示用
		$message = addslashes("<div class=\"quote\"><span class=\"q\"><b>".$relatedpost['username']."</b>: ".getstr($relatedpost['message'], 150, 0, 0, 0, 2, 1).'</span></div>').$message;
		
		$notification_type = "mtag_post_reply";
		$notification_uids[] = $relatedpost[uid];
	}
	
	if(empty($pid)) {
		$querynumbersql="select max(p.number) maxnumber from ".tname('post')." p where p.tid='$thread[tid]' AND p.tagid='$thread[tagid]'";
		$querynumber = $_SGLOBAL['db']->query($querynumbersql);
		$queryresult = $_SGLOBAL['db']->fetch_array($querynumber);
		$number = $queryresult['maxnumber'];
		$number = $number + 1;
		
		$setarr = array(
			'tagid' => intval($thread['tagid']),
			'tid' => $thread['tid'],
			'uid' => $_SGLOBAL['supe_uid'],
			'username' => $_SGLOBAL['supe_username'],
			'ip' => getonlineip(),
			'deleteflag' => 0,
			'number' => $number,
			'dateline' => $_SGLOBAL['timestamp'],
			'message' => $message
		);
		$pid = inserttable('post', $setarr, 1);
		
		//更新统计数据
		$_SGLOBAL['db']->query("UPDATE ".tname('mtag_thread')."	SET replynum=(SELECT count(*) FROM ".tname('post')." WHERE tid = '$thread[tid]' AND isthread = 0 ), lastpost='$_SGLOBAL[timestamp]', lastauthor='$_SGLOBAL[supe_username]', lastauthorid='$_SGLOBAL[supe_uid]'	WHERE tid='$thread[tid]'");
		
		//更新群组统计
		$_SGLOBAL['db']->query("UPDATE ".tname("mtag")." SET postnum=(SELECT count(*) FROM ".tname('post')." WHERE tagid = '$thread[tagid]' AND isthread = 0), experience = experience+1 WHERE tagid='$thread[tagid]'");
	} 
	else {
		//edit
		$psetarr = array(
			'ip' => getonlineip(),
			'message' => $message
		);
		updatetable('post', $psetarr, array('tid'=>$_POST['tid'], 'isthread'=>0));
	}

	//消息通知
	$noticeuidarray = array();
		
	$querymembersql="SELECT DISTINCT mm.uid FROM ".tname("mtagmember")." mm WHERE mm.tagid=$mtag[tagid] AND mm.uid!=$_SGLOBAL[supe_uid]";
	$query = $_SGLOBAL['db']->query($querymembersql);
	while ($member = $_SGLOBAL['db']->fetch_array($query)) {
		$member_uid = $member['uid'];
		if( empty($noticeuidarray[$member_uid]) ){
			$noticeuidarray[$member_uid] = "1";
			//区分 闲聊区/话题区
			if( $_POST['tid'] == 0 ){
				notification_add($member_uid, 'mtag_post_new', "在群组<a href=\"space.php?do=mtag&tagid=$mtag[tagid]\" >$mtag[tagname]</a>中留言了。");
			}
			else{
				notification_add($member_uid, 'mtag_post_new', "在群组<a href=\"space.php?do=mtag&tagid=$mtag[tagid]\" >$mtag[tagname]</a>中，回复了话题<br/><a href=\"space.php?do=thread&tid=$thread[tid]\" >$thread[subject]</a>");
			}
		}
	}
	
	$queryfanssql="SELECT DISTINCT mf.uid FROM ".tname("mtagfans")." mf WHERE mf.deleteflag=0 AND mf.fansgradeid>1 AND mf.tagid=$mtag[tagid] AND mf.uid!=$_SGLOBAL[supe_uid]";
	$query = $_SGLOBAL['db']->query($queryfanssql);
	while ($fans = $_SGLOBAL['db']->fetch_array($query)) {
		$fans_uid = $fans['uid'];
		if( empty($noticeuidarray[$fans_uid]) ){
			$noticeuidarray[$fans_uid] = "1";
			//区分 闲聊区/话题区
			if( $_POST['tid'] == 0 ){
				notification_add($fans_uid, 'mtag_post_new', "在群组<a href=\"space.php?do=mtag&tagid=$mtag[tagid]\" >$mtag[tagname]</a>中留言了。");
			}
			else{
				notification_add($fans_uid, 'mtag_post_new', "在群组<a href=\"space.php?do=mtag&tagid=$mtag[tagid]\" >$mtag[tagname]</a>中，回复了话题<br/><a href=\"space.php?do=thread&tid=$thread[tid]\" >$thread[subject]</a>");
			}
		}
	}
	
	//统计
	updatestat('post');

	//跳转
//	showmessage('do_success', "space.php?uid=$_SGLOBAL[supe_uid]&do=thread&tid=$tid&pid=$pid", 0);
	
	//区分 闲聊区/话题区
	if( $_POST['tid'] == 0 ){
		showmessage('do_success', "space.php?do=mtag&tagid=$mtag[tagid]",1);
	}
	else{
		showmessage('do_success', "space.php?do=thread&tid=$thread[tid]",1);
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
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('post')." WHERE $postidsql uid='$_SGLOBAL[supe_uid]' ORDER BY dateline DESC LIMIT 0,1");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		
		$fansgrade = checkfansgrade($value['tagid'], $_SGLOBAL['supe_uid']);
		$membergrade = checkmembergrade($value['tagid'], $_SGLOBAL['supe_uid']);
	
		$list[] = $value;
	}
	
	
	include template('cp_post');
}
elseif($_GET['op'] == 'setdigest') {

	$thread = loadthreadbyid($threadid);
	if(empty($thread)) {
		showmessage('mtag_thread_not_exist');
	}
		
	digestthreads($thread['tagid'], array($thread['tid']), 1);
	
	showmessage('do_success');
} 
elseif($_GET['op'] == 'canceldigest') {

	$thread = loadthreadbyid($threadid);
	if(empty($thread)) {
		showmessage('mtag_thread_not_exist');
	}
		
	digestthreads($thread['tagid'], array($thread['tid']), 0);
	
	showmessage('do_success');
} 
elseif($_GET['op'] == 'settop') {

	$thread = loadthreadbyid($threadid);
	if(empty($thread)) {
		showmessage('mtag_thread_not_exist');
	}
	
	topthreads($thread['tagid'], array($thread['tid']), 1);
	
	showmessage('do_success');
} 
elseif($_GET['op'] == 'canceltop') {

	$thread = loadthreadbyid($threadid);
	if(empty($thread)) {
		showmessage('mtag_thread_not_exist');
	}
	
	topthreads($thread['tagid'], array($thread['tid']), 0);
	
	showmessage('do_success');
} 
elseif($_GET['op'] == 'querythreadclassbytagid_ajax') {
	
	$threadclasslist=array();
	if(!empty($_GET['tagid'])){
		$threadclasslist=listthreadclassbymtagid($_GET['tagid']);
	}
	include_once template("querythreadclassbytagid_ajax");
} 

//判读是否是组员
function ckmtagmember($tagid) {
	global $_SGLOBAL, $_SCONFIG, $event, $userevent;

	include_once(S_ROOT.'./source/function_mtag.php');
	$mtag=loadmtagbyid($tagid);
	if(empty($mtag)){
		showmessage('mtag_not_exist');
	}elseif($mtag['tagstate']==0 || $mtag['tagstate']==1){
		showmessage('mtag_state_not_auditpass');
	}
	
	$mtag = mtagformmapper($mtag);
	return $mtag;
}

?>