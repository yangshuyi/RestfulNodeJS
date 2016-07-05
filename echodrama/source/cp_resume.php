<?php
/*
 [UCenter Home] (C) 2007-2008 Comsenz Inc.
 $Id: cp_profile.php 13149 2009-08-13 03:11:26Z liguode $
 */

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

$resumeid = empty($_GET['resumeid'])?0:intval($_GET['resumeid']);
$resumehistoryid = empty($_GET['resumehistoryid'])?0:intval($_GET['resumehistoryid']);
$op = empty($_GET['op'])?'':$_GET['op'];
$cat_actives = array($_GET['op'] => ' class="active"');

include_once(S_ROOT.'./data/data_jobclass.php');
include_once(S_ROOT.'./data/data_producttype.php');
include_once(S_ROOT.'./source/function_resume.php');

if($_GET['op'] == 'maintain') {

	$mainquerysql="SELECT r.* FROM ".tname('resume')." r where r.uid='".$_SGLOBAL['supe_uid']."'";
	$mainquery = $_SGLOBAL['db']->query($mainquerysql);
	$resume = $_SGLOBAL['db']->fetch_array($mainquery);

	$nav_list = array();
	$nav_item = array();
	$nav_item['url'] = "cp.php?ac=profile"; $nav_item['dispname'] = "个人设置";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "cp.php?ac=resume&op=maintain"; $nav_item['dispname'] = "个人简介";
	$nav_list[] = $nav_item;
		
	$nav_item = array();
	$nav_item['url'] = "cp.php?ac=resume&op=maintain"; $nav_item['dispname'] = "自我介绍";
	$nav_list[] = $nav_item;
	
	include template("cp_resume");
}
elseif($_GET['op'] == 'save') {

	$querysql="SELECT r.* FROM ".tname('resume')." r where r.resumeid='".$resumeid."' ";
	$query = $_SGLOBAL['db']->query($querysql);
	$resume = $_SGLOBAL['db']->fetch_array($query);
	if($resume){
		//do check
		if($resume["uid"]!=$_SGLOBAL['supe_uid']){
			showmessage('no_privilege');
		}
			
	}else{
		//create new resume
		$resume=array();
		$resume['uid'] = $_SGLOBAL['supe_uid'];
		$resume['username'] = $_SGLOBAL['supe_username'];
		$resume['replynum'] = 0;
	}

	$resume['club'] = $_POST['club'];
	$resume['clubtagid'] = $_POST['clubtagid'];
	$resume['jobid'] = $_POST['jobid'];
	$resume['introduce'] = $_POST['introduce'];

	//检查输入
	if(empty($resume['uid'])){
		showmessage('resume_uid_empty');
	} elseif(empty($resume['jobid'])){
		showmessage('resume_jobid_empty');
	} elseif(empty($resume['club'])){
		showmessage('resume_club_empty');
	} elseif(empty($resume['introduce'])){
		showmessage('resume_introduce_empty');
	}

	if(empty($resume['resumeid'])){
		inserttable("resume", $resume);
	}else{
		updatetable('resume', $resume, array('resumeid'=>$resumeid));
	}

	showmessage('do_success', "cp.php?ac=resume&op=maintain", 1);
}
elseif($_GET['op'] == 'current') {

	$currentquerysql="SELECT rh.* FROM ".tname('resumehistory')." rh where rh.currentflag=1 and rh.uid='".$_SGLOBAL['supe_uid']."' order by rh.producttype, rh.productname";
	$currentlist=queryresumehistory($currentquerysql);
		
	$nav_list = array();
	$nav_item = array();
	$nav_item['url'] = "cp.php?ac=profile"; $nav_item['dispname'] = "个人设置";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "cp.php?ac=resume&op=maintain"; $nav_item['dispname'] = "个人简介";
	$nav_list[] = $nav_item;
		
	$nav_item = array();
	$nav_item['url'] = "cp.php?ac=resume&op=current"; $nav_item['dispname'] = "目前状态";
	$nav_list[] = $nav_item;
	
	include template("cp_resume");
}
elseif($_GET['op'] == 'addcurrent') {

	$currentquerysql="SELECT rh.* FROM ".tname('resumehistory')." rh where rh.currentflag=1 and rh.uid='".$_SGLOBAL['supe_uid']."' order by rh.producttype, rh.productname";
	$currentlist=queryresumehistory($currentquerysql);
	
	$nav_list = array();
	$nav_item = array();
	$nav_item['url'] = "cp.php?ac=profile"; $nav_item['dispname'] = "个人设置";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "cp.php?ac=resume&op=maintain"; $nav_item['dispname'] = "个人简介";
	$nav_list[] = $nav_item;
		
	$nav_item = array();
	$nav_item['url'] = "cp.php?ac=resume&op=current"; $nav_item['dispname'] = "目前状态";
	$nav_list[] = $nav_item;
		
	$nav_item = array();
	$nav_item['url'] = "cp.php?ac=resume&op=addcurrent"; $nav_item['dispname'] = "添加目前状态";
	$nav_list[] = $nav_item;
		
	include template("cp_resume");
}
elseif($_GET['op'] == 'toeditcurrent') {
	
	$querysql="SELECT rh.* FROM ".tname('resumehistory')." rh where rh.currentflag=1 and rh.resumehistoryid='".$resumehistoryid."' ";
	$resumehistorys=queryresumehistory($querysql);
	if(count($resumehistorys)<=0){
		showmessage('no_privilege');
	}
	$resumecurrent=$resumehistorys[0];
	//do check
	if($resumecurrent["uid"]!=$_SGLOBAL['supe_uid']){
		showmessage('no_privilege');
	}
	
	$currentquerysql="SELECT rh.* FROM ".tname('resumehistory')." rh where rh.currentflag=1 and rh.uid='".$_SGLOBAL['supe_uid']."' order by rh.producttype, rh.productname";
	$currentlist=queryresumehistory($currentquerysql);
	
	$nav_list = array();
	$nav_item = array();
	$nav_item['url'] = "cp.php?ac=profile"; $nav_item['dispname'] = "个人设置";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "cp.php?ac=resume&op=maintain"; $nav_item['dispname'] = "个人简介";
	$nav_list[] = $nav_item;
		
	$nav_item = array();
	$nav_item['url'] = "cp.php?ac=resume&op=current"; $nav_item['dispname'] = "目前状态";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "cp.php?ac=resume&op=toeditcurrent"; $nav_item['dispname'] = "编辑目前状态";
	$nav_list[] = $nav_item;
	
	include template("cp_resume");
}
elseif($_GET['op'] == 'savecurrent') {

	$querysql="SELECT rh.* FROM ".tname('resumehistory')." rh where rh.currentflag=1 and rh.resumehistoryid='".$_POST['resumehistoryid']."' ";
	$query = $_SGLOBAL['db']->query($querysql);
	$resumehistory = $_SGLOBAL['db']->fetch_array($query);
	if($resumehistory){
		//do check
		if($resumehistory["uid"]!=$_SGLOBAL['supe_uid']){
			showmessage('no_privilege');
		}
			
	}else{
		//create new resumehistory
		$resumehistory=array();
		$resumehistory['uid'] = $_SGLOBAL['supe_uid'];
		$resumehistory['username'] = $_SGLOBAL['supe_username'];
		$resumehistory['replynum'] = 0;
	}
	
	$resumehistory['currentflag'] = 1;
	$resumehistory['fromdate'] = sstrtotime($_POST['fromdate']);
	$resumehistory['producttype'] = $_POST['producttype'];
	$resumehistory['productid'] = 0;
	$resumehistory['productname'] = $_POST['productname'];
	$resumehistory['club'] = $_POST['club'];
	$resumehistory['clubtagid'] = $_POST['clubtagid'];
	$resumehistory['jobid'] = $_POST['jobid'];
	$resumehistory['introduce'] = $_POST['introduce'];

	//检查输入
	if(empty($resumehistory['uid'])){
		showmessage('resume_uid_empty');
	} elseif(empty($resumehistory['jobid'])){
		showmessage('resume_jobid_empty');
	} elseif(empty($resumehistory['club'])){
		showmessage('resume_club_empty');
	} elseif(empty($resumehistory['introduce'])){
		showmessage('resume_introduce_empty');
	} elseif(empty($resumehistory['producttype'])){
		showmessage('resume_introduce_empty');
	} elseif(empty($resumehistory['productname'])){
		showmessage('resume_productname_empty');
	}
	

	if(empty($resumehistory['resumehistoryid'])){
		inserttable("resumehistory", $resumehistory);
	}else{
		updatetable('resumehistory', $resumehistory, array('resumehistoryid'=>$resumehistory['resumehistoryid']));
	}

	showmessage('do_success', "cp.php?ac=resume&op=current", 1);
}
elseif($_GET['op'] == 'deletecurrent') {
	if(!empty($_POST['resumehistoryid'])){
		$_SGLOBAL['db']->query("DELETE FROM ".tname('resumehistory')." WHERE currentflag=1 and resumehistoryid=".$_POST['resumehistoryid']);
	}
	showmessage('do_success', "cp.php?ac=resume&op=current", 1);
}
elseif($_GET['op'] == 'history') {

	$historyquerysql="SELECT rh.* FROM ".tname('resumehistory')." rh where rh.currentflag=0 and rh.uid='".$_SGLOBAL['supe_uid']."' order by rh.producttype, rh.productname";
	$historylist=queryresumehistory($historyquerysql);
	
	$nav_list = array();
	$nav_item = array();
	$nav_item['url'] = "cp.php?ac=profile"; $nav_item['dispname'] = "个人设置";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "cp.php?ac=resume&op=maintain"; $nav_item['dispname'] = "个人简介";
	$nav_list[] = $nav_item;
		
	$nav_item = array();
	$nav_item['url'] = "cp.php?ac=resume&op=history"; $nav_item['dispname'] = "我的成就";
	$nav_list[] = $nav_item;
		
	include template("cp_resume");
}
elseif($_GET['op'] == 'addhistory') {

	$historyquerysql="SELECT rh.* FROM ".tname('resumehistory')." rh where rh.currentflag=0 and rh.uid='".$_SGLOBAL['supe_uid']."' order by rh.producttype, rh.productname";
	$historylist=queryresumehistory($historyquerysql);
	
	$nav_list = array();
	$nav_item = array();
	$nav_item['url'] = "cp.php?ac=profile"; $nav_item['dispname'] = "个人设置";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "cp.php?ac=resume&op=maintain"; $nav_item['dispname'] = "个人简介";
	$nav_list[] = $nav_item;
		
	$nav_item = array();
	$nav_item['url'] = "cp.php?ac=resume&op=history"; $nav_item['dispname'] = "我的成就";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "cp.php?ac=resume&op=addhistory"; $nav_item['dispname'] = "添加我的成就";
	$nav_list[] = $nav_item;
	
	include template("cp_resume");
}
elseif($_GET['op'] == 'toedithistory') {
	
	$querysql="SELECT rh.* FROM ".tname('resumehistory')." rh where rh.currentflag=0 and rh.resumehistoryid='".$resumehistoryid."' ";
	$resumehistorys=queryresumehistory($querysql);
	if(count($resumehistorys)<=0){
		showmessage('no_privilege');
	}
	$resumehistory=$resumehistorys[0];
	//do check
	if($resumehistory["uid"]!=$_SGLOBAL['supe_uid']){
		showmessage('no_privilege');
	}
		
	$historyquerysql="SELECT rh.* FROM ".tname('resumehistory')." rh where rh.currentflag=0 and rh.uid='".$_SGLOBAL['supe_uid']."' order by rh.producttype, rh.productname";
	$historylist=queryresumehistory($historyquerysql);
	
	$nav_list = array();
	$nav_item = array();
	$nav_item['url'] = "cp.php?ac=profile"; $nav_item['dispname'] = "个人设置";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "cp.php?ac=resume&op=maintain"; $nav_item['dispname'] = "个人简介";
	$nav_list[] = $nav_item;
		
	$nav_item = array();
	$nav_item['url'] = "cp.php?ac=resume&op=history"; $nav_item['dispname'] = "我的成就";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "cp.php?ac=resume&op=toedithistory"; $nav_item['dispname'] = "编辑我的成就";
	$nav_list[] = $nav_item;
	
	include template("cp_resume");
}elseif($_GET['op'] == 'savehistory') {

	$querysql="SELECT rh.* FROM ".tname('resumehistory')." rh where rh.currentflag=0 and rh.resumehistoryid='".$_POST['resumehistoryid']."' ";
	$query = $_SGLOBAL['db']->query($querysql);
	$resumehistory = $_SGLOBAL['db']->fetch_array($query);
	if($resumehistory){
		//do check
		if($resumehistory["uid"]!=$_SGLOBAL['supe_uid']){
			showmessage('no_privilege');
		}
			
	}else{
		//create new resumehistory
		$resumehistory=array();
		$resumehistory['uid'] = $_SGLOBAL['supe_uid'];
		$resumehistory['username'] = $_SGLOBAL['supe_username'];
		$resumehistory['replynum'] = 0;
	}

	$resumehistory['currentflag'] = 0;
	$resumehistory['producttype'] = $_POST['producttype'];
	$resumehistory['productid'] = $_POST['productid'];
	$resumehistory['productname'] = $_POST['productname'];
	$resumehistory['jobid'] = $_POST['jobid'];
	$resumehistory['introduce'] = $_POST['introduce'];
	$resumehistory['club'] = $_POST['club'];
	$resumehistory['clubtagid'] = $_POST['clubtagid'];	
	
	//检查输入
	if(empty($resumehistory['uid'])){
		showmessage('resume_uid_empty');
	} elseif(empty($resumehistory['producttype'])){
		showmessage('resume_producttype_empty');
	} elseif(empty($resumehistory['productname'])){
		showmessage('resume_productcname_empty');
	} elseif(empty($resumehistory['jobid'])){
		showmessage('resume_jobid_empty');
	} elseif(empty($resumehistory['club'])){
		showmessage('resume_club_empty');
	} elseif(empty($resumehistory['introduce'])){
		showmessage('resume_introduce_empty');
	}

	if(empty($resumehistory['resumehistoryid'])){
		inserttable("resumehistory", $resumehistory);
	}else{
		updatetable('resumehistory', $resumehistory, array('resumehistoryid'=>$resumehistory['resumehistoryid']));
	}

	showmessage('do_success', "cp.php?ac=resume&op=history", 1);
}
elseif($_GET['op'] == 'deletehistory') {
	if(!empty($_POST['resumehistoryid'])){
		$_SGLOBAL['db']->query("DELETE FROM ".tname('resumehistory')." WHERE currentflag=0 and resumehistoryid=".$_POST['resumehistoryid']);
	}
	showmessage('do_success', "cp.php?ac=resume&op=history", 1);
} 
elseif($_GET['op'] == 'querymds') {
		
	//处理搜索
	include_once(S_ROOT.'./source/function_admincp.php');
	
	$mpurl="cp.php?ac=resume&op=querymds&widget=".$_GET['widget']."&id=".$_GET['id'];
	
	$wheresql = ' 1=1 ';
	if($_GET['uid']) {
		$wheresql = $wheresql." AND s.uid = '$_GET[uid]' ";
	}
	if($_GET['username']) {
		$wheresql = $wheresql." AND s.username like '%$_GET[username]%' ";
	}
	if($_GET['realname']) {
		$wheresql = $wheresql." AND s.name like '%$_GET[realname]%' ";
	}
	
	$perpage = 8;
	$page = empty($_GET['page'])?1:intval($_GET['page']);
	$mpurl .= '&perpage='.$perpage;
		
	if($page<1) $page = 1;
	$start = ($page-1)*$perpage;
	//检查开始数
	ckstart($start, $perpage);

	//显示分页
	$csql = "SELECT COUNT(*) FROM ".tname('space')." s WHERE $wheresql";
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($csql), 0);

	//TODO need to upgrade to phrase 3
	$qsql = "SELECT s.*, r.club, r.jobid FROM ".tname('space')." s left outer join ".tname('resume')." r on s.uid=r.uid WHERE $wheresql order by s.uid LIMIT $start,$perpage";
	$query = $_SGLOBAL['db']->query($qsql);
	$list=array();
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$jobname="";
		if($value['jobid']){
			$arr=explode(',',$value['jobid']);
			foreach ($arr as $classid) {
				$jobname=$jobname.$_SGLOBAL['jobclass'][$classid]['classname']." ";
			}
		}
		$value['jobname']=$jobname;
		$list[] = $value;
	}
	//显示分页
	$multi = multi($count, $perpage, $page, $mpurl);
	
	include_once template("cp_resume_query_list");
}
elseif($_GET['op'] == 'loadresumebyid_ajax') {
	if(empty($_GET['uid'])) {
		showmessage("user_does_not_exist");
	}
	
	$value = queryuserbyid($_GET['uid']);
	
	//用户不存在
	if(empty($value)) {
		showmessage('user_does_not_exist');
	}
	$jobname="";
	if($value['jobid']){
		$arr=explode(',',$value['jobid']);
		foreach ($arr as $classid) {
			$jobname=$jobname.$_SGLOBAL['jobclass'][$classid]['classname']." ";
		}
	}
	$value['jobname']=$jobname;
	showmessage('ajax_param', '', 0, array($value['uid'],$value['username'],$value['name'],$value['club'],$value['jobid'],$value['jobname']));
}
elseif($_GET['op'] == 'queryuserbysql_ajax') {
	$qsql=$_GET['queryusersql'];
	$query = $_SGLOBAL['db']->query($qsql);
	$list=array();
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$list[] = $value;
	}
	include_once template("cp_user_id_query_list");
}
?>