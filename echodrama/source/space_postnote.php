<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_feed.php 12432 2009-06-25 07:31:34Z xupeng $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

	
$postnoteid = empty($_GET['postnoteid'])?0:intval($_GET['postnoteid']);

include_once(S_ROOT.'./source/function_postnote.php');
$view = isset($_GET['view']) ? $_GET['view'] : "postnotecalendar";

if(empty($postnoteid)) {
	
	if($view == 'postnotecalendar'){
		
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
			$days[$i] = array("count"=>0, "postnotes"=>array(), "tasks"=>array(), "class"=>'');
		}
		//本月贴士
		$postnotes = array();
		$qsql = "SELECT pn.* FROM ".tname("postnote")." pn WHERE ((pn.fromuid = $_SGLOBAL[supe_uid] AND $_SGLOBAL[supe_uid] = $_GET[uid]) OR (pn.fromuid = $_SGLOBAL[supe_uid] AND pn.uid = $_GET[uid]) OR (pn.uid = $_SGLOBAL[supe_uid] AND pn.fromuid = $_GET[uid])) AND pn.notedate <= $dayend AND pn.notedate >= $daystart ORDER BY pn.postnoteid DESC";
		//showmessage($qsql);
		$query = $_SGLOBAL['db']->query( $qsql );
		while($value=$_SGLOBAL['db']->fetch_array($query)) {
			$i = intval(sgmdate('d', $value['notedate']));
			$value = postnoteformmapper($value);
			$value['notification_type'] = 'postnote';
			$days[$i]['postnotes'][] = $value;
			$days[$i]['count'] += 1;
			$days[$i]['class'] = " on_link";
		}
		unset($postnotes);
	
		if($_SGLOBAL[supe_uid] == $_GET[uid]){
			//本月群组任务
			include_once(S_ROOT.'./source/function_mtag.php');
	
			$membersubsql = " 1=2 ";
			$membersql = "SELECT mm.* FROM ".tname('mtagmember')." mm WHERE mm.uid = $_SGLOBAL[supe_uid]";
			$query = $_SGLOBAL['db']->query( $membersql );
			while($member=$_SGLOBAL['db']->fetch_array($query)) {
				$membersubsql .= " OR (mt.members like '%,$member[memberid],%')";
			}
	
			$tasks = array();
			$qsql = "SELECT mt.* FROM ".tname("mtagtask")." mt LEFT OUTER JOIN ".tname("mtag")." m ON m.tagid = mt.tagid ";
			$qsql .= "WHERE mt.starttime <= $dayend AND mt.endtime >= $daystart AND ($membersubsql) ORDER BY mt.taskid DESC";
			$query = $_SGLOBAL['db']->query( $qsql );
			while($value=$_SGLOBAL['db']->fetch_array($query)) {
				$start = $value['starttime'] < $daystart ? 1 : intval(sgmdate('d', $value['starttime']));
				$end = $value['endtime'] > $dayend ? $dayscount : intval(sgmdate("d", $value['endtime']));
				for($i=$start; $i<=$end; $i++) {
					$value = taskformmapper($value);
					$days[$i]['tasks'][] = $value;
					$days[$i]['count'] += 1;
					$days[$i]['class'] = " on_link";
				}
			}
			unset($tasks);
		}
		
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
	
		include_once template("space_postnote_calendar_ajax");
	}
	else if(view == 'view'){
	//list

	}
} else {
	//view
	$postnote=loadpostnotebyid($postnoteid);
	if(empty($postnote)) {
		showmessage('postnote_does_not_exist');
	}
	
	$postnote=postnoteformmapper($postnote);
	$namemap = loadnamemap(array($postnote['uid'], $postnote['fromuid']));
		
	$postnote['username'] = $namemap[$postnote['uid']];
	$postnote['fromusername'] = $namemap[$postnote['fromuid']];
		
	$page = empty($_GET['page'])?1:intval($_GET['page']);
	if($page<1) $page = 1;
	
	//评论
	$perpage = 30;
	$perpage = mob_perpage($perpage);
	
	$start = ($page-1)*$perpage;

	//检查开始数
	ckstart($start, $perpage);

	//评论
	$csql = "SELECT count(*) FROM ".tname('comment')." WHERE id=$postnoteid AND idtype='postnoteid'";
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($csql), 0);
	$postnote['replynum']=$count;
	 
	$commentlist = array();
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('comment')." WHERE id=$postnoteid AND idtype='postnoteid' ORDER BY dateline LIMIT $start,$perpage");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		realname_set($value['authorid'], $value['author']);//实名
		$commentlist[] = $value;
	}
	include_once template("space_postnote_view");
}
?>