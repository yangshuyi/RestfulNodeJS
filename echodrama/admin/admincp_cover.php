<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: admincp_blog.php 9233 2008-10-28 06:21:44Z liguode $
*/

if(!defined('IN_UCHOME') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

//权限
if(!checkperm('managecover')) {
	cpmessage('no_authority_management_operation');
}

$_GET['op'] = empty($_GET['op'])?'list':$_GET['op'];
$_GET['subop'] = empty($_GET['subop'])?'manage':$_GET['subop'];
$coverid = empty($_GET['coverid'])?0:intval($_GET['coverid']);
$view = empty($_GET['view']) ? "all": $_GET['view'];

include_once(S_ROOT.'./data/data_coverproductclass.php');
include_once(S_ROOT.'./source/function_cover.php');
include_once(S_ROOT.'./source/function_cp.php');

if($_GET['op'] == 'batchdelete') {
	//删除
	if(deletecovers($_GET['ids'])) {
		showmessage('do_success', $_SGLOBAL[refer]);
	} else {
		cpmessage('choose_to_delete_the_columns_cover'); // 请选择要删除的翻唱
	}
} 
elseif($_GET['op'] == 'manage') {
	if(empty($coverid)) {
		showmessage("cover_does_not_exist");
	}
	$cover=loadcoverbyid($coverid);
	//翻唱不存在
	if(empty($cover)) {
		showmessage('cover_does_not_exist');
	}
	
	if(empty($_POST['formhash'])) {
		$cover=coverformmapper($cover);
		$coverlabellist=listcoverlabel();
	}
	else{
		if($_GET['subop']=='save'){
			$cover['subject'] = $_POST['subject'];
			$cover['product']=$_POST['product'];
			$cover['message']=$_POST['message'];
			$cover['productclassid'] = intval($_POST['productclassid']);
			$cover['label'] = shtmlspecialchars(trim($_POST['label']));
			$cover['club'] = $_POST['club'];
			$cover['clubtagid'] = $_POST['clubtagid'];
			$cover['originwordwriter'] = $_POST['originwordwriter'];
			$cover['originmelodywriter'] = $_POST['originmelodywriter'];
			$cover['originsinger'] = $_POST['originsinger'];
			$cover['wordwriter'] = $_POST['wordwriter'];
			$cover['singer'] = $_POST['singer'];
			$cover['effector'] = $_POST['effector'];
			$cover['photographer'] = $_POST['photographer'];
			$cover['producedate'] = sstrtotime($_POST['producedate']);
			$cover['lastpost'] = $_SGLOBAL['timestamp'];
			if($_POST['originmelodyflag']) {
				$cover['originmelodyflag'] = 1;
			}else{
				$cover['originmelodyflag'] = 0;
			}
			if($_POST['originwordflag']) {
				$cover['originwordflag'] = 1;
			}else{
				$cover['originwordflag'] = 0;
			}	

			if(empty($cover['subject'])){
				showmessage('cover_subject_empty');
			}elseif(empty($cover['product'])){
				showmessage('cover_product_empty');
			}elseif(empty($cover['message'])){
				showmessage('cover_message_empty');
			}elseif(empty($cover['productclassid'])){
				showmessage('cover_productclassid_empty');
			}elseif(empty($cover['club'])){
				showmessage('cover_club_empty');
			}
			
			if(empty($cover['coverid'])) {
				$cover['coverid'] = inserttable('cover', $cover, 1);
			}else{
				//更新
				updatetable('cover', $cover, array('coverid'=>$cover['coverid']));
			}	
	
			updatecoverlabel($cover['label']);
			updatecoverspace($cover['uid'],$cover['coverid']);
			//产生feed
			if($_POST['makefeed']) {
				include_once(S_ROOT.'./source/function_feed.php');
				feed_publish($cover['coverid'], 'coverid');
			}
	
			showmessage('do_success', $_POST[referlink], 1);
		}
		elseif($_GET['subop']=='delete'){
			$ids=array();
			$ids[]=0;
			$ids[]=$cover[coverid];
			deletecovers($ids);
			
			showmessage('do_success', $_POST[referlink], 1);
		}
	}	
} 
elseif($_GET['op'] == 'list') {
	// 搜索
	
	$page = empty($_GET['page'])?1:intval($_GET['page']);
	if($page<1) $page = 1;
	
	$perpage = 30;
	$start = ($page-1)*$perpage;
	
	//处理搜索
	include_once(S_ROOT.'./source/function_admincp.php');

	$mpurl = 'admincp.php?ac=cover';
	$list = array();
	$multi = '';
	
	$intkeys = array('productclassid','coverid');
	$strkeys = array();
	$likekeys = array('subject','club');
	$results = getwheres($intkeys, $strkeys, $randkeys, $likekeys, 'c.');
	$wherearr = $results['wherearr'];
	$wheresql = empty($wherearr)?'1':implode(' AND ', $wherearr);
	
	$page = empty($_GET['page'])?1:intval($_GET['page']);
	if($page<1) $page = 1;
	$start = ($page-1)*$perpage;
	//检查开始数
	ckstart($start, $perpage);
	
	$mpurl .= '&'.implode('&', $results['urls']);
	$mpurl .= '&perpage='.$perpage;
	$mpurl .= '&view='.$view;
	
	if($view == 'all') {
		$csql = "SELECT COUNT(*) FROM ".tname('cover')." c WHERE 1=1 and $wheresql";
		$qsql = "SELECT * FROM ".tname('cover')." c WHERE 1=1 and $wheresql order by c.coverid DESC LIMIT $start,$perpage";
	}
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($csql), 0);
	if($count) {
		$list=querycover($qsql);
		
		//显示分页
		$multi = multi($count, $perpage, $page, $mpurl);
	}
	
	$managebatch = checkperm('managebatch');
	$allowbatch = true;
	$actives = array($view => ' class="active"');
}

?>