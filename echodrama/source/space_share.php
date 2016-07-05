<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_share.php 13206 2009-08-20 02:31:30Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//分页

$page = empty($_GET['page'])?1:intval($_GET['page']);
if($page<1) $page=1;
$id = empty($_GET['id'])?0:intval($_GET['id']);

if($id) {

	//读取
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('share')." WHERE sid='$id' AND uid='$space[uid]'");
	$share = $_SGLOBAL['db']->fetch_array($query);
	//不存在
	if(empty($share)) {
		showmessage('share_does_not_exist');
	}
	$share = mkshare($share);
	
	//评论
	$perpage = 50;
	$start = ($page-1)*$perpage;

	//检查开始数
	ckstart($start, $perpage);
	
	$list = array();
	$cid = empty($_GET['cid'])?0:intval($_GET['cid']);
	$csql = $cid?"cid='$cid' AND":'';
	
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('comment')." WHERE $csql id='$id' AND idtype='sid'"),0);
	if($count) {
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('comment')." WHERE $csql id='$id' AND idtype='sid' ORDER BY dateline LIMIT $start,$perpage");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			realname_set($value['authorid'], $value['author']);
			$list[] = $value;
		}
	}
	
	//分页
	$multi = multi($count, $perpage, $page, "space.php?uid=$share[uid]&do=share&id=$id", '', 'comment_ul');
	
	realname_get();
	
	$tpl_title = getstr($share['title_template'], 0, 0, 0, 0, 0, -1);

	//访问统计
	if( ($share['sid']!=$_SCOOKIE['view_sid']) ) {
		ssetcookie('view_sid', $share['sid']);
		
		$uip=getonlineip(0);
		$qsql="SELECT sa.* FROM ".tname("session_all")." sa WHERE sa.ip='$uip'";
		$query = $_SGLOBAL['db']->query($qsql);
		$session_sa = $_SGLOBAL['db']->fetch_array($query);
		if( !empty($session_sa)) {
			if(strstr($session_sa[shareids], $share['sid'])) {
			
			}
			else{
				$session_sa[shareids] .= ",".$share['sid'];
				$_SGLOBAL['db']->query("UPDATE ".tname('session_all')." SET shareids='$session_sa[shareids]' WHERE ip='$uip'");
				$_SGLOBAL['db']->query("UPDATE ".tname('share')." SET viewnum=viewnum+1 WHERE sid='$share[sid]'");
			}
		}
	}
	
	include_once template("space_share_view");
	
} else {
	
	if(empty($_GET['view']) && ($space['friendnum']<$_SCONFIG['showallfriendnum'])) {
		$_GET['view'] = 'all';//默认显示
	}
	
	$perpage = 20;
	
	//检查开始数
	$start = ($page-1)*$perpage;
	ckstart($start, $perpage);
	
	//处理查询
	$f_index = '';
	if($_GET['view']=='all') {
		//大家的
		$wheresql = "1";
		$theurl = "space.php?uid=$space[uid]&do=$do&view=all";
		$actives = array('all'=>' class="active"');		
	} elseif(empty($space['feedfriend'])) {
		$wheresql = "uid='$space[uid]'";
		$theurl = "space.php?uid=$space[uid]&do=$do&view=me";
		$actives = array('me'=>' class="active"');
	} else {
		$wheresql = "uid IN ($space[feedfriend])";
		$theurl = "space.php?uid=$space[uid]&do=$do&view=we";
		$f_index = 'USE INDEX(dateline)';
		$actives = array('we'=>' class="active"');
	}
	
	//类型
	if($_GET['type']) {
		$sub_actives = array('type_'.$_GET['type'] => ' class="on"');
		$wheresql .= " AND type='$_GET[type]'";
	} else {
		$sub_actives = array('type_all' => ' class="on"');
	}
	
	$list = array();
	
	$sid = empty($_GET['sid'])?0:intval($_GET['sid']);
	$sharesql = $sid?"sid='$sid' AND":'';
	
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('share')." WHERE $sharesql $wheresql"),0);
	
	//更新统计
	if(empty($sharesql) && $wheresql == "uid='$space[uid]'" && $space['sharenum'] != $count) {
		updatetable('space', array('sharenum' => $count), array('uid'=>$space['uid']));
	}
	
	if($count) {
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('share')." $f_index
			WHERE $sharesql $wheresql
			ORDER BY dateline DESC
			LIMIT $start,$perpage");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			realname_set($value['uid'], $value['username']);
			$value = mkshare($value);
			$list[] = $value;
		}
	}
	
	//分页
	$multi = multi($count, $perpage, $page, $theurl."&type=$_GET[type]");
	
	realname_get();
	
	include_once template("space_share_list");
}

?>