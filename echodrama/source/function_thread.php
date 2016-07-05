<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: function_delete.php 13001 2009-08-05 06:18:06Z zhengqingpeng $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

function listthreadclassbymtagid($tagid){
	global $_SGLOBAL, $_SC;

	$querysql="SELECT * FROM ".tname('mtag_threadclass')." mtc WHERE mtc.tagid = '$tagid' ORDER BY mtc.displayorder";
	$list=array();
	$query = $_SGLOBAL['db']->query($querysql);
	$index=1;
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$value['displayorder']=$index;
		$containthreadlist=querythreadbythreadclassid($tagid, $value['classid']);
		if(count($containthreadlist)>0){
			$value['state']=1;
			$value['statename']="已含话题";
			$value['statesize']=count($containthreadlist);
		}else{
			$value['state']=0;
			$value['statename']="未含话题";
		}
		$index=$index+1;
		$list[]=$value;
	}
	return $list;
}

function updatethreadclass($tagid, $classidarray, $classnamearray, $displayorderarray) {
	global $_SGLOBAL, $_SC;

	$deleteprevioussql="DELETE FROM ".tname('mtag_threadclass')." WHERE tagid = '$tagid'";
	$query = $_SGLOBAL['db']->query($deleteprevioussql);

	for ($i=0;$i<count($classidarray);$i++){
		$threadclass=array();
		$threadclass['tagid'] = $tagid;
		if($classidarray[$i]!="0"){
			$threadclass['classid'] = $classidarray[$i];
		}
		$threadclass['classname'] = $classnamearray[$i];
		$threadclass['displayorder'] = $displayorderarray[$i];
		inserttable('mtag_threadclass', $threadclass);
	}
}

function querythreadbythreadclassid($tagid, $threadclassid){
	global $_SGLOBAL, $_SC;

	$querysql = "SELECT * FROM ".tname('mtag_thread')." mt ";
	$querysql .= " WHERE mt.tagid = '$tagid' and mt.threadclassid='$threadclassid' ";
	$querysql .= " ORDER BY mt.displayorder DESC, mt.dateline DESC";
	
	return querymtagthread($querysql);
}

function queryforumsystemthread($tagid){
	global $_SGLOBAL, $_SC;
	
	$qsql="SELECT mt.* FROM ".tname('mtag_thread')." mt ";
	$qsql.=" WHERE mt.tagid='".FORUM_TAGID."' AND mt.displayorder=1 ";
	$qsql.=" ORDER BY mt.dateline ";
	
	return querymtagthread($qsql);
}
	
// 查询
function querymtagthread($qsql){
	global $_SGLOBAL, $_SC;
       
	$query = $_SGLOBAL['db']->query($qsql);
	$list=array();
	
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$value = threadformmapper($value);
		$list[]=$value;
	}
	return $list;
}

function loadthreadbyid($threadid){
	global $_SGLOBAL, $_SC;
       
	$qsql="SELECT mt.*, mtc.classname AS threadclassname, mtu.uid AS threaduserid  FROM ".tname("mtag_thread")." mt ";
	$qsql.=" LEFT OUTER JOIN ".tname("mtag_thread_user")." mtu ON mt.tid=mtu.tid AND mtu.uid=$_SGLOBAL[supe_uid] AND mtu.uid!=0 ";
	$qsql.=" LEFT OUTER JOIN ".tname("mtag_threadclass")." mtc ON mt.threadclassid=mtc.classid AND mt.tagid=mtc.tagid ";
	$qsql.=" WHERE mt.tid=$threadid";
	$query = $_SGLOBAL['db']->query($qsql);
	$value = $_SGLOBAL['db']->fetch_array($query);
	
	return $value;
}

function loadthreadmainpostbyid($threadid){
	global $_SGLOBAL, $_SC;
       
	$qsql="SELECT p.* FROM ".tname("post")." p WHERE p.tid=$threadid AND p.isthread=1";
	
	$query = $_SGLOBAL['db']->query($qsql);
	$value = $_SGLOBAL['db']->fetch_array($query);
	
	return $value;
}

function querypost($qsql) {
	global $_SGLOBAL;
	
	$list=array();
	$query = $_SGLOBAL['db']->query($qsql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$value = postformmapper($value);
		$list[] = $value;
	}
	
	return $list;
}

function loadpostbyid($postid){
	global $_SGLOBAL, $_SC;
       
	$qsql="SELECT p.* FROM ".tname("post")." p WHERE p.pid=$postid";
	$query = $_SGLOBAL['db']->query($qsql);
	$value = $_SGLOBAL['db']->fetch_array($query);
	
	return $value;
}


function updatesystemthreadlabel($tid, $labels){
	global $_SGLOBAL, $_SC;
	
	$delete_existthreadlabel_sql="DELETE FROM ".tname('mtag_threadlabel')." WHERE tid='$tid' AND uid='0'";
	$_SGLOBAL['db']->query($delete_existthreadlabel_sql);
	
	$threadlabelarray=split('/',$labels);
	foreach($threadlabelarray as $labelitem){
		$mtagthreadlabel = array();
		$mtagthreadlabel['tid']=$tid;
		$mtagthreadlabel['uid']= 0;
		$mtagthreadlabel['username']= '';
		$mtagthreadlabel['label']=$labelitem;
		$mtagthreadlabel['lastpost']=$_SGLOBAL['timestamp'];;
		inserttable("mtag_threadlabel", $mtagthreadlabel);
	}
}


function threadformmapper($thread){
	global $_SGLOBAL, $_SC;

	$thread['subjectlimit'] = getstr($thread['subject'], 50, 0, 0, 0, 0, -1);
	$thread['datelinedisp'] = sgmdate('Y-m-d', $thread['dateline']);
	$thread['datelinetimedisp'] = sgmdate('Y-m-d h:i', $thread['dateline']);
	$thread['lastpostdisp'] = sgmdate('Y-m-d', $thread['lastpost']);
	$thread['lastposttimedisp'] = sgmdate('Y-m-d h:i', $thread['lastpost']);
				
	$prefix="";
	if($thread['digest']==1){
		$thread['digestname'] = "精华帖";
		$prefix=$prefix."[精]";
	}else{
		$thread['digestname'] = "";
	}

	if($thread['displayorder']==1){
		$thread['displayordername'] = "置顶帖";
		$prefix=$prefix."[顶]";
	}else{
		$thread['displayordername'] = "";
	}

	if($thread['close']==1){
		$thread['closename'] = "已关闭";
		$prefix=$prefix."[封]";
	}else{
		$thread['closename'] = "";
	}
	
	if($thread['repaste']==1){
		$thread['repastename'] = "转帖";
		$prefix=$prefix."[转]";
	}else{
		$thread['repastename'] = "";
	}
					
	$thread['prefix'] = $prefix;
	
	$postpagenum = ( $thread['replynum'] / 30 ) + 1;
	$postpagelinker = "";
	if($postpagenum>=2) {
		$postpagelinker .= "&nbsp;[";
		for($postpageindex=1;$postpageindex<=$postpagenum;$postpageindex++) {
			$postpagelinker .= "&nbsp;<a href=\"space.php?do=forum&tid=$thread[tid]&page=$postpageindex\" target=\"_blank\">$postpageindex</a>&nbsp;";
		}
		$postpagelinker .= "]&nbsp;";
	}
	$thread['postpagelinker'] = $postpagelinker;
	return $thread;
}

function postformmapper($post){
	global $_SGLOBAL, $_SC;

	//移除编辑记录
	$post['message'] = preg_replace("/<ins class=\"modify\".+?<\/ins>/is", '',$post['message']);
	
	realname_set($value['uid'], $value['username']);
	

	return $post;
}


//话题首页显示
function displayportalthreads($tagid, $tids, $v) {
	global $_SGLOBAL;
	
	if( $tagid != FORUM_TAGID ) {
		$mtag = loadmtagbyid($tagid);
		if(empty($mtag)){
			showmessage('mtag_not_exist');
		}
		$membergrade = checkmembergrade($tagid, $_SGLOBAL['supe_uid']);
		if($membergrade < 8) {
			showmessage('no_privilege');
		}
	}
	else{
		if( $_SGLOBAL['forum_admin'] != 1 ) {
			return array();
		}
	}
	
	if(empty($v)) {
		$wheresql = " AND t.displayportal='1'";
		$v = 0;
	} else {
		$wheresql = " AND t.displayportal='0'";
		$v = 1;
	}
	
	$newtids = $threads = array();
	$allowmanage = checkperm('managethread');
	//showmessage("SELECT t.* FROM ".tname('mtag_thread')." t WHERE t.tagid='$tagid' AND t.tid IN (".simplode($tids).") $wheresql");
	$query = $_SGLOBAL['db']->query("SELECT t.* FROM ".tname('mtag_thread')." t WHERE t.tagid='$tagid' AND t.tid IN (".simplode($tids).") $wheresql");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$newtids[] = $value['tid'];
	}
	
	//数据
	if($newtids) {
		$_SGLOBAL['db']->query("UPDATE ".tname('mtag_thread')." SET displayportal='$v' WHERE tid IN (".simplode($newtids).")");
	}

	return $threads;
}

//话题精华
function digestthreads($tagid, $tids, $v) {
	global $_SGLOBAL;
	
	if( $tagid != FORUM_TAGID ) {
		$mtag = loadmtagbyid($tagid);
		if(empty($mtag)){
			showmessage('mtag_not_exist');
		}
		$membergrade = checkmembergrade($tagid, $_SGLOBAL['supe_uid']);
		if($membergrade < 8) {
			showmessage('no_privilege');
		}
	}
	else{
		if( $_SGLOBAL['forum_admin'] != 1 ) {
			return array();
		}
	}
	
	if(empty($v)) {
		$wheresql = " AND t.digest='1'";
		$v = 0;
	} else {
		$wheresql = " AND t.digest='0'";
		$v = 1;
	}
	
	$newtids = $threads = array();
	$allowmanage = checkperm('managethread');
	//showmessage("SELECT t.* FROM ".tname('mtag_thread')." t WHERE t.tagid='$tagid' AND t.tid IN (".simplode($tids).") $wheresql");
	$query = $_SGLOBAL['db']->query("SELECT t.* FROM ".tname('mtag_thread')." t WHERE t.tagid='$tagid' AND t.tid IN (".simplode($tids).") $wheresql");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$newtids[] = $value['tid'];
		$threads[] = $value;
	
		if($v==0){
			if( $tagid != $forum_spam_tagid ) {
				notification_add($member['uid'],"thread","</br>您发表在 $mtag[title] 群组的话题 $value[subject] 已被设为精华帖 。",0);
			}
			else{
				notification_add($member['uid'],"thread","</br>您的帖子<a href=\"space.php?do=forum&view=viewall&tid=$value[tid]\" target=\"_blank\">$value[subject]</a>已被设为精华帖 。",0);
			}
		}
	}
	
	//数据
	if($newtids) {
		$_SGLOBAL['db']->query("UPDATE ".tname('mtag_thread')." SET digest='$v' WHERE tid IN (".simplode($newtids).")");
	}

	
	return $threads;
}


//话题置顶
function topthreads($tagid, $tids, $v) {
	global $_SGLOBAL;
	
	if( $tagid != FORUM_TAGID ) {
		$mtag = getmtag($tagid);
		if($mtag['grade']<8) {
			return array();
		}
	}
	else{
		if( $_SGLOBAL['forum_admin'] != 1 ) {
			return array();
		}
	}
	
	if(empty($v)) {
		$wheresql = " AND t.displayorder='1'";
		$v = 0;
	} else {
		$wheresql = " AND t.displayorder='0'";
		$v = 1;
	}
	
	$newtids = $threads = array();
	$query = $_SGLOBAL['db']->query("SELECT t.* FROM ".tname('mtag_thread')." t WHERE t.tagid='$tagid' AND t.tid IN (".simplode($tids).") $wheresql");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$newtids[] = $value['tid'];
		$threads[] = $value;
	}
	
	//数据
	if($newtids) {
		$_SGLOBAL['db']->query("UPDATE ".tname('mtag_thread')." SET displayorder='$v' WHERE tid IN (".simplode($newtids).")");
	}

	return $threads;
}

//话题置底
function bottomthreads($tagid, $tids, $v) {
	global $_SGLOBAL;
	
	if(empty($v)) {
		$wheresql = " AND t.keepbottom='1'";
		$v = 0;
	} else {
		$wheresql = " AND t.keepbottom='0'";
		$v = 1;
	}
	
	$newtids = $threads = array();
	$query = $_SGLOBAL['db']->query("SELECT t.* FROM ".tname('mtag_thread')." t WHERE t.tagid='$tagid' AND t.tid IN (".simplode($tids).") $wheresql");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$newtids[] = $value['tid'];
		$threads[] = $value;
	}
	
	//数据
	if($newtids) {
		$_SGLOBAL['db']->query("UPDATE ".tname('mtag_thread')." SET keepbottom='$v' WHERE tid IN (".simplode($newtids).")");
	}

	return $threads;
}

//话题关闭
function closethreads($tagid, $tids, $v) {
	global $_SGLOBAL;
	
	if( $tagid != $forum_spam_tagid ) {
		$mtag = getmtag($tagid);
		if($mtag['grade']<8) {
			return array();
		}
	}
	else{
		if( $_SGLOBAL['forum_admin'] != 1 ) {
			return array();
		}
	}
	
	if(empty($v)) {
		$wheresql = " AND t.close='1'";
		$v = 0;
	} else {
		$wheresql = " AND t.close='0'";
		$v = 1;
	}
	$newtids = $threads = array();
	$query = $_SGLOBAL['db']->query("SELECT t.* FROM ".tname('mtag_thread')." t WHERE t.tagid='$tagid' AND t.tid IN (".simplode($tids).") $wheresql");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$newtids[] = $value['tid'];
		$threads[] = $value;
	}
	
	//数据
	if($newtids) {
		$_SGLOBAL['db']->query("UPDATE ".tname('mtag_thread')." SET close='$v' WHERE tid IN (".simplode($newtids).")");
	}

	return $threads;
}

function deletethread($thread) {
	global $_SGLOBAL, $_SC;
	
	//delete thread label
	$deletethreadlabelsql="DELETE FROM ".tname('mtag_threadlabel')." WHERE tid='$thread[tid]'";
	$_SGLOBAL['db']->query($deletethreadlabelsql);
	
	//delete thread user
	$deletethreadusersql="DELETE FROM ".tname('mtag_thread_user')." WHERE tid='$thread[tid]'";
	$_SGLOBAL['db']->query($deletethreadusersql);
	
	//delete post
	$deletepostsql="DELETE FROM ".tname('post')." WHERE tid='$thread[tid]'";
	$_SGLOBAL['db']->query($deletepostsql);
	
	//delete thread
	$deletethreadsql="DELETE FROM ".tname('mtag_thread')." WHERE tid='$thread[tid]'";
	$_SGLOBAL['db']->query($deletethreadsql);
	
	
	//update mtag
	if( !empty($thread[tagid]) ) {
		$updatetagsql="UPDATE ".tname("mtag")." SET ";
		$updatetagsql.=" threadnum=(select count(*) from ".tname('mtag_thread')." mt where mt.tagid=$thread[tagid]), ";
		$updatetagsql.=" postnum=(select count(*) from ".tname('post')." p where p.tagid=$thread[tagid]) ";
		$updatetagsql.=" where tagid='$thread[tagid]'";
		
		$_SGLOBAL['db']->query($updatetagsql);
	}
}


		

//视频标签处理
function thread_bbcode($message) {
	$message = preg_replace("/\[flash\=?(media|real)*\](.+?)\[\/flash\]/ie", "thread_flash('\\2', '\\1')", $message);
	return $message;
}
//视频
function thread_flash($swf_url, $type='') {
	$width = '570';
	$height = '400';
	if ($type == 'media') {
		$html = '<object classid="clsid:6bf52a52-394a-11d3-b153-00c04f79faa6" width="'.$width.'" height="'.$height.'">
			<param name="autostart" value="0">
			<param name="url" value="'.$swf_url.'">
			<embed autostart="false" src="'.$swf_url.'" type="video/x-ms-wmv" width="'.$width.'" height="'.$height.'" controls="imagewindow" console="cons"></embed>
			</object>';
	} elseif ($type == 'real') {
		$html = '<object classid="clsid:cfcdaa03-8be4-11cf-b84b-0020afbbccfa" width="'.$width.'" height="'.$height.'">
			<param name="autostart" value="0">
			<param name="src" value="'.$swf_url.'">
			<param name="controls" value="Imagewindow,controlpanel">
			<param name="console" value="cons">
			<embed autostart="false" src="'.$swf_url.'" type="audio/x-pn-realaudio-plugin" width="'.$width.'" height="'.$height.'" controls="controlpanel" console="cons"></embed>
			</object>';
	} else {
		$html = '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="'.$width.'" height="'.$height.'">
			<param name="movie" value="'.$swf_url.'">
			<param name="WMode" value="Transparent">
			<param name="allowscriptaccess" value="always">
			<embed wmode="transparent" src="'.$swf_url.'" type="application/x-shockwave-flash" width="'.$width.'" height="'.$height.'" allowfullscreen="true" allowscriptaccess="always"></embed>
			</object>';
	}
	return $html;
}


?>