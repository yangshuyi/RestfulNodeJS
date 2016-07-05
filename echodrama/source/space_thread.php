<?php
/*
 [UCenter Home] (C) 2007-2008 Comsenz Inc.
 $Id: space_thread.php 13210 2009-08-20 07:09:06Z liguode $
 */

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

$view = empty($_GET['view']) ? "thread" : $_GET['view'];

$threadid = empty($_GET['tid'])?0:intval($_GET['tid']);

@include_once(S_ROOT.'./data/data_profield.php');
@include_once(S_ROOT.'./source/function_mtag.php');
@include_once(S_ROOT.'./source/function_thread.php');

//表态分类
@include_once(S_ROOT.'./data/data_click.php');
$clicks = empty($_SGLOBAL['click']['tid'])?array():$_SGLOBAL['click']['tid'];

if( $view=='thread' ){
	
	if($threadid) {
		//话题
		$thread = loadthreadbyid($threadid);
		if(empty($thread)) {
			showmessage('mtag_thread_not_exist');
		}
	
		//群组信息
		$tagid = $thread['tagid'];
		$mtag = getmtagbyid($tagid);
		if(empty($mtag)){
			showmessage('mtag_not_exist');
		}elseif($mtag['tagstate']==0 || $mtag['tagstate']==1){
			showmessage('mtag_state_not_auditpass');
		}
		
		$mtag = mtagformmapper($mtag);
		
		//是否允许查看
		$fansgrade = checkfansgrade($tagid, $_SGLOBAL['supe_uid']);
		if($fansgrade < 2 && $fansgrade > 0 ) {
			showmessage('no_privilege');
		}
		
		$membergrade = checkmembergrade($tagid, $_SGLOBAL['supe_uid']);
	
		$perpage = 10;
		$count = $thread['replynum'];
		
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
	
		$mainpost = loadthreadmainpostbyid($thread['tid']);
		//$thread['content']['message'] = blog_bbcode($thread['content']['message']);
		$mainpost = postformmapper($mainpost);
		
		//处理视频标签
		$mainpost['message'] = thread_bbcode($mainpost['message']);
		
		$qsql = "SELECT * FROM ".tname('post')." WHERE $psql tid='$thread[tid]' AND deleteflag='0' AND isthread='0' ORDER BY number LIMIT $start,$perpage";
		$postlist = querypost($qsql);
	
		//分页
		$multi = multi($count, $perpage, $page, "space.php?&do=thread&tid=$threadid");
	
		//访问统计
		//TODO need to research
		if($_SCOOKIE['view_tid'] != $threadid) {
			$_SGLOBAL['db']->query("UPDATE ".tname('mtag_thread')." SET viewnum=viewnum+1 WHERE tid='$threadid'");
			inserttable('log', array('id'=>$space['uid'], 'idtype'=>'uid'));//延迟更新
			ssetcookie('view_tid', $threadid);
		}
		
		$canhotcoldthread=($thread['uid'] != $_SGLOBAL['supe_uid']) && ($_SCOOKIE['hotcold_tid'] != $threadid);
	
		//表态
		//TODO need to research
	//	$hash = md5($thread['uid']."\t".$thread['dateline']);
	//	$id = $thread['tid'];
	//	$idtype = 'tid';
	//
	//	foreach ($clicks as $key => $value) {
	//		$value['clicknum'] = $thread["click_$key"];
	//		$value['classid'] = mt_rand(1, 4);
	//		if($value['clicknum'] > $maxclicknum) $maxclicknum = $value['clicknum'];
	//		$clicks[$key] = $value;
	//	}
	
		//点评
	//	$clickuserlist = array();
	//	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('clickuser')."
	//		WHERE id='$id' AND idtype='$idtype'
	//		ORDER BY dateline DESC
	//		LIMIT 0,18");
	//	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
	//		realname_set($value['uid'], $value['username']);//实名
	//		$value['clickname'] = $clicks[$value['clickid']]['name'];
	//		$clickuserlist[] = $value;
	//	}
	
		//实名
		realname_get();
	
		$_TPL['css'] = 'thread';
		$searchengine_description=$mtag['tagname'].",".$mtag['fieldname'].",话题：".$thread['subject'];
		include_once template("space_thread_view");
	
	} 
	else {
		$page = empty($_GET['page'])?1:intval($_GET['page']);
		if($page<1) $page = 1;

		$perpage = 30;
		$start = ($page-1)*$perpage;
	
		//检查开始数
		ckstart($start, $perpage);
	
		if(!in_array($_GET['view'], array('hot','new','me', 'all'))) {
			$_GET['view'] = 'hot';
		}
	
		//话题列表
		$wheresql = $f_index = '';
		if($_GET['view'] == 'hot') {
			$minhot = $_SCONFIG['feedhotmin']<1?3:$_SCONFIG['feedhotmin'];
			$wheresql = "main.hot>='$minhot'";
	
			//热门群组
			if($page == 1) {
				$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('mtag')." mt ORDER BY mt.threadnum DESC LIMIT 0,6");
				while ($value = $_SGLOBAL['db']->fetch_array($query)) {
					$value['title'] = $_SGLOBAL['profield'][$value['fieldid']]['title'];
					if(empty($value['pic'])) $value['pic'] = 'image/nologo.jpg';
					$rlist[] = $value;
				}
			}
	
		} elseif($_GET['view'] == 'me')  {
			//自己的
			$wheresql = "main.uid='$space[uid]'";
		} else {
			$wheresql = "1";
			$f_index = 'USE INDEX (lastpost)';
		}
		$theurl = "space.php?uid=$space[uid]&do=thread&view=$_GET[view]";
		$actives = array($_GET['view']=>' class="active"');
	
		$list = array();
		$count = 0;
	
	
		//搜索
		if($searchkey = stripsearchkey($_GET['subject'])) {
			$wheresql = "main.subject LIKE '%$searchkey%'";
			$theurl .= "&subject=$_GET[searchkey]";
			cksearch($theurl);
		}
	
		if($wheresql) {
			$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('mtag_thread')." main WHERE $wheresql"),0);
	
			//更新统计
			if($wheresql == "main.uid='$space[uid]'" && $space['threadnum'] != $count) {
				updatetable('space', array('threadnum' => $count), array('uid'=>$space['uid']));
			}
	
			if($count) {
				$query = $_SGLOBAL['db']->query("SELECT main.*,field.tagname,field.membernum,field.fieldid,field.pic FROM ".tname('mtag_thread')." main $f_index
					LEFT JOIN ".tname('mtag')." field ON field.tagid=main.tagid WHERE $wheresql
					ORDER BY main.lastpost DESC
					LIMIT $start,$perpage");
				while ($value = $_SGLOBAL['db']->fetch_array($query)) {
					realname_set($value['uid'], $value['username']);
					realname_set($value['lastauthorid'], $value['lastauthor']);
					$value['tagname'] = getstr($value['tagname'], 20);
					$list[] = $value;
					if(empty($value['pic'])) {
						$value['pic'] = 'image/nologo.jpg';
					}
				}
			}
		}
	
		//分页
		$multi = multi($count, $perpage, $page, $theurl);
	
		//实名
		realname_get();
	
		$_TPL['css'] = 'thread';
		$searchengine_description="群组话题：";
		foreach($list as $value) {
			$searchengine_description.=$value['tagname']."-".$value['subject'].",";
		}
		include_once template("space_thread_list");
	}
}


//加载群组
function getmtagbyid($tagid) {
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