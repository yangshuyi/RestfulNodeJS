<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_feed.php 12432 2009-06-25 07:31:34Z xupeng $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

$toneid = empty($_GET['toneid'])?0:intval($_GET['toneid']);
$view = isset($_GET['view']) ? $_GET['view'] : "all";

$page = empty($_GET['page'])?1:intval($_GET['page']);
if($page<1) $page = 1;

$perpage = 10;
$start = ($page-1)*$perpage;

$managetone = checkperm('managetone');

// 获取声线类型信息
include_once(S_ROOT.'./data/data_toneclass.php');

include_once(S_ROOT.'./source/function_tone.php');
		
if(empty($toneid)) {
	//list
	
	//处理搜索
	include_once(S_ROOT.'./source/function_admincp.php');
		
	$mpurl='space.php?do=tone';
	$list = array();
	$multi = '';

	$_GET[label]=trim($_GET[label]);
	if(!empty($_GET['uid'])){
		$user = queryuserbyid($_GET['uid']);
		$_GET['username']=$user['username'];
	}
		
	//所有声线
	$intkeys = array('uid', 'classid');
	$strkeys = array();
	$randkeys = array();
	$likekeys = array();
	$results = getwheres($intkeys, $strkeys, $randkeys, $likekeys, 't.');
		
	$wherearr = $results['wherearr'];
	$mpurl .= '&'.implode('&', $results['urls']);
		
	$wheresql = empty($wherearr)?'1':implode(' AND ', $wherearr);
	
	if(!empty($_GET[label])){
		$wheresql.= " AND (t.label like '%/$_GET[label]/%' OR t.label like '$_GET[label]/%' )";
		$mpurl .= "&label=$_GET[label]";
	}
	
	$orderbysql=" ORDER BY ";
	if(!empty($_GET[orderby])){
		$orderbysql.= $_GET[orderby];
		$mpurl .= "&orderby=$_GET[orderby]";
	}
	else{
		$orderbysql.= "t.dateline DESC";
	}
	
	$page = empty($_GET['page'])?1:intval($_GET['page']);
	$mpurl .= "&view=$view&perpage=".$perpage;
		
	if($page<1) $page = 1;
	$start = ($page-1)*$perpage;
	//检查开始数
	ckstart($start, $perpage);
	
	if($view == 'me') {
		$userid='';
		if(empty($_GET['uid'])){
			$userid=$_SGLOBAL[supe_uid];
		}else{
			$userid=$_GET['uid'];
		}
		
		$csql = "SELECT COUNT(*) FROM ".tname('tone')." t WHERE t.uid='$userid' and $wheresql";
		$qsql = "SELECT * FROM ".tname('tone')." t WHERE t.uid='$userid' and $wheresql $orderbysql LIMIT $start,$perpage";
	} 
	else if($view == 'all') {
		$csql = "SELECT COUNT(*) FROM ".tname('tone')." t WHERE 1=1 and $wheresql";
		$qsql = "SELECT * FROM ".tname('tone')." t WHERE 1=1 and $wheresql $orderbysql LIMIT $start,$perpage";
	} 
	else if($view == 'share') {
		$csql = "SELECT COUNT(t.toneid) FROM ".tname('tone')." t, ".tname('toneuser')." tu WHERE tu.toneid=t.toneid and tu.uid = $_SGLOBAL[supe_uid] and $wheresql";
		$qsql = "SELECT t.* FROM ".tname('tone')." t, ".tname('toneuser')." tu WHERE tu.toneid=t.toneid and tu.uid = $_SGLOBAL[supe_uid] and $wheresql $orderbysql LIMIT $start,$perpage";
	}
	$actives = array($view => ' class="active"');

	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($csql), 0);
	if($count) {
		$query = $_SGLOBAL['db']->query($qsql);
		$list=querytone($qsql);
		
		//显示分页
		$multi = multi($count, $perpage, $page, $mpurl);
	}
	
	realname_get();
	
//	$classid=$_GET['classid'];
//	$type=$_GET['type'];

	//声线标签
	$hottonelabellist=listhottonelabel();

	//hot tone list
	$hottonelistsql = "SELECT t.* FROM ".tname('tone')." t WHERE 1=1 order by t.viewnum desc LIMIT 0,10";
	$hottonelist=querytone($hottonelistsql);
	
	$_TPL['css'] = 'tone';
	$searchengine_description='声线列表：';
	foreach($list as $value) {
		$searchengine_description.=$value['username'].",";
	}
	
	$nav_list = array();
	$nav_item = array();
	$nav_item['url'] = "space.php?do=tone"; $nav_item['dispname'] = "声线基地";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	if($view == 'all') {
		$nav_item['url'] = "space.php?do=tone&view=all"; $nav_item['dispname'] = "声线库列表";
	}
	elseif($view == 'me') {
		$nav_item['url'] = "space.php?do=tone&view=me"; $nav_item['dispname'] = "我的声线库";
	}
	elseif($view == 'share') {
		$nav_item['url'] = "space.php?do=tone&view=share"; $nav_item['dispname'] = "我的收藏列表";
	} 
	$nav_list[] = $nav_item;
	
	include_once template('space_tone_list');
} 
else {
	//view
	$qsql="SELECT t.* FROM ".tname('tone')." t WHERE t.toneid=$toneid";
	$list=querytone($qsql);
	//广播剧不存在
	if(empty($list)) {
		showmessage('tone_does_not_exist');
	}
	$tone = $list[0];
	
	//是否被收藏
	$shareSql= "SELECT COUNT(*) FROM ".tname('toneuser')." tu WHERE tu.toneid=$toneid and tu.uid=$_SGLOBAL[supe_uid]";
	$inShare = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($shareSql), 0);
				
	//是否已评级
	$userip=getonlineip(0);
	$tonepollsql= "SELECT * FROM ".tname('tonepoll')." tp WHERE tp.toneid=$toneid and ( tp.uid='$_SGLOBAL[supe_uid]' OR tp.userip='$userip' )";
	$query = $_SGLOBAL['db']->query($tonepollsql);
	$tonepoll = $_SGLOBAL['db']->fetch_array($query);
	
	//评论
	$perpage = 30;
	$perpage = mob_perpage($perpage);
	
	$start = ($page-1)*$perpage;

	//检查开始数
	ckstart($start, $perpage);

	//评论

//TODO 只看该用户？
//		$cid = empty($_GET['cid'])?0:intval($_GET['cid']);
//		$csql = $cid?"cid='$cid' AND":'';
	$csql = "SELECT count(*) FROM ".tname('comment')." WHERE id=$toneid AND idtype='toneid'";
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($csql), 0);
	$tone['replynum']=$count;
	 
	$commentlist = array();
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('comment')." WHERE id=$toneid AND idtype='toneid' ORDER BY dateline LIMIT $start,$perpage");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		realname_set($value['authorid'], $value['author']);//实名
		$commentlist[] = $value;
	}

	//分页
	$multi = multi($count, $perpage, $page, "space.php?do=$do&toneid=$toneid", '', 'content');

	//访问统计
	if( ($tone['uid']!=$_SGLOBAL['supe_uid']) && ($tone['toneid']!=$_SCOOKIE['view_toneid']) ) {
		ssetcookie('view_toneid', $tone['toneid']);

		$_SGLOBAL['db']->query("UPDATE ".tname('tone')." SET viewnum=viewnum+1 WHERE toneid='$tone[toneid]'");
		inserttable('log', array('id'=>$value['uid'], 'idtype'=>'uid'));//延迟更新
	}

	//声线标签
	$hottonelabellist=listhottonelabel();
	
	//hot tone list
	$hottonelistsql = "SELECT t.* FROM ".tname('tone')." t WHERE 1=1 order by t.viewnum desc LIMIT 0,10";
	$hottonelist=querytone($hottonelistsql);
	
	//该用户的其他声线
	$othertonelistsql = "SELECT t.* FROM ".tname('tone')." t WHERE uid='$tone[uid]' order by t.viewnum desc LIMIT 0,10";
	$othertonelist=querytone($othertonelistsql);

	
	//实名
	realname_get();

	$sub_actives = array($_GET['view'] => ' style="font-weight:bold;"');
	$_TPL['css'] = 'tone';
	$searchengine_description="个人声线：".$tone['username'].",".$tone['classname'].",标签:".$tone['labeldisplay'];
	
	$nav_list = array();
	$nav_item = array();
	$nav_item['url'] = "space.php?do=tone"; $nav_item['dispname'] = "声线基地";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "space.php?do=tone&view=all"; $nav_item['dispname'] = "声线库列表";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "space.php?do=tone&toneid=$tone[toneid]"; $nav_item['dispname'] = "声线编号[$tone[toneid]]";
	$nav_list[] = $nav_item;
	
	include_once template("space_tone_view");
}

?>