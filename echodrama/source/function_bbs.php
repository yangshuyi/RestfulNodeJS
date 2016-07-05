<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: function_delete.php 13001 2009-08-05 06:18:06Z zhengqingpeng $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

function convert($tid){
	global $_SGLOBAL, $_SC;
	
	$announcement_fid = 37;
	$forumid = $announcement_fid;
	$qsql = "SELECT t.* FROM ".tnamebbs('threads')." t WHERE t.fid = '$forumid' and t.tid='$tid' ORDER BY t.dateline";
    $query = $_SGLOBAL['bbsdb']->query($qsql);
    
    $thread_list=array();
   	while ($value = $_SGLOBAL['bbsdb']->fetch_array($query)) {
   		$thread = array();
   		$thread[tid] = null;
   		$thread[tagid] = 8; //应声虫
   		$thread[threadclassid] = 40; //虫虫小喇叭
   		$thread[subject] = $value[subject];
   		$thread[magiccolor] = 0;
   		$thread[magicegg] = 0;
   		$thread[uid] = $value[authorid];
   		$thread[username] = $value[author];
   		$thread[dateline] = $value[dateline];
   		$thread[viewnum] = $value[views];
   		$thread[replynum] = $value[replys];
   		$thread[lastpost] = $value[lastpost];
   		$thread[lastauthor] = $value[lastposter];
   		$thread[lastauthorid] = 0;
   		$thread[displayorder] = 0;
   		$thread[digest] = 0;
   		$thread[close] = 0;
   		$thread[hot] = 0;
   		$thread[cold] = 0;
   		
   		$thread[tid] = inserttable("mtag_thread", $thread, 1);
   		$thread_list[] = $thread;
	}
	
	
	foreach($thread_list as $thread){
		$qsql = "SELECT p.* FROM ".tnamebbs('posts')." p WHERE p.tid = '$tid' ORDER BY p.dateline";
	    $query = $_SGLOBAL['bbsdb']->query($qsql);
	    
	    $post_list=array();
		$number = 0;
	    while ($value = $_SGLOBAL['bbsdb']->fetch_array($query)) {
	   		$post = array();
	   		$post[pid] = null;
	   		$post[tagid] = $thread[tagid];
	   		$post[tid] = $thread[tid];
	   		$post[fakeflag] = 0;
	   		$post[uid] = $value[authorid];
	   		$post[username] = $value[author];
	   		$post[number] = count($post_list);
	   		$post[fakename] = "";
	   		$post[deleteflag] = 0;
	   		$post[ip] = $value[useip];
	   		$post[dateline] = $value[dateline];
	   		$post[message] = $value[message];
	   		$post[isthread] = $value[first];
	   		$post[isthread] = $value[first];
	   		$post[isthread] = $value[first];
	   		$post[hotuser] = null;
	   		
	   		$post[pid] = inserttable("post", $post, 1);
	   		
	   		$post_list[] = $post;
	   	}
	}
	
}
function querybbs_announcement_topone($forumid){
	global $_SGLOBAL, $_SC;
	
	$typeid=62;
	
	$qsql = "SELECT t.*, p.message AS message FROM ".tnamebbs('threads')." t, ".tnamebbs('posts')." p WHERE t.fid = '$forumid' AND t.tid = p.tid AND t.typeid=$typeid AND p.first=1 ORDER BY t.dateline DESC LIMIT 0,1";
    $query = $_SGLOBAL['bbsdb']->query($qsql);
  	$announcement = $_SGLOBAL['bbsdb']->fetch_array($query);
	$announcement = threadformmapper($announcement);
	
	return $announcement;
}

function querybbs_announcement_list($forumid){
	global $_SGLOBAL, $_SC;
	
	$typeid=62;
	
	$list=array();
	$qsql = "SELECT t.*, p.message AS message FROM ".tnamebbs('threads')." t, ".tnamebbs('posts')." p WHERE t.fid = '$forumid' AND t.tid = p.tid AND t.typeid=$typeid AND p.first=1 ORDER BY t.dateline DESC LIMIT 0,10";
    $query = $_SGLOBAL['bbsdb']->query($qsql);
   	while ($value = $_SGLOBAL['bbsdb']->fetch_array($query)) {
   		$value = threadformmapper($value);
		$list[] = $value;
	}
	
	return $list;
}

function threadformmapper($value){
	$value['datelinedisp'] = sgmdate('Y-m-d', $value['dateline']);
	return $value;
}
// 查询thread
function querythread($querysql){
    global $_SGLOBAL, $_SC;
    
	//include_once(S_ROOT.'./source/function_admincp.php');
    $list=array();
	$query = $_SGLOBAL['bbsdb']->query($querysql);
	while ($value = $_SGLOBAL['bbsdb']->fetch_array($query)) {
		$value['subjectlimit'] = getstr($value['subject'], 70, 0, 0, 0, 0, -1);
		$value['lastpost'] = sgmdate('Y-m-d', $value['lastpost']);
		$value['dateline'] = sgmdate('Y-m-d', $value['dateline']);
		if(empty($value['author'])){
			$value['author']="游客";
		}
		$list[] = $value;
	}
	
	return $list;
}

//member check
function checkbbsmemberexist($uid){
    global $_SGLOBAL, $_SC;
    
    $qsql = "SELECT * FROM ".tnamebbs('member')." m WHERE m.uid='$uid'";
    $query = $_SGLOBAL['bbsdb']->query($qsql);
	while ($value = $_SGLOBAL['bbsdb']->fetch_array($query)) {
		return true;
	}
	
	return false;
}
?>