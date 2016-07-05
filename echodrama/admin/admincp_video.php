<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: admincp_blog.php 9233 2008-10-28 06:21:44Z liguode $
*/

if(!defined('IN_UCHOME') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

//权限
if(!checkperm('managevideo')) {
	cpmessage('no_authority_management_operation');
}

$_GET['op'] = empty($_GET['op'])?'list':$_GET['op'];
$_GET['subop'] = empty($_GET['subop'])?'manage':$_GET['subop'];
$videoid = empty($_GET['videoid'])?0:intval($_GET['videoid']);
$view = empty($_GET['view']) ? "all": $_GET['view'];

include_once(S_ROOT.'./data/data_videoproductclass.php');
include_once(S_ROOT.'./source/function_video.php');
include_once(S_ROOT.'./source/function_cp.php');

if($_GET['op'] == 'batchdelete') {
	//删除
	if(deletevideos($_GET['ids'])) {
		showmessage('do_success', $_SGLOBAL[refer]);
	} else {
		cpmessage('choose_to_delete_the_columns_video'); // 请选择要删除的视频
	}
} 
elseif($_GET['op'] == 'manage') {
	if(empty($videoid)) {
		showmessage("video_does_not_exist");
	}
	$video=loadvideobyid($videoid);
	//视频不存在
	if(empty($video)) {
		showmessage('video_does_not_exist');
	}
	
	if(empty($_POST['formhash'])) {
		$video=videoformmapper($video);
		$videolabellist=listvideolabel();
	}
	else{
		if($_GET['subop']=='save'){
			$video['subject'] = $_POST['subject'];
			$video['product']=$_POST['product'];
			$video['message']=$_POST['message'];
			$video['productclassid'] = intval($_POST['productclassid']);
			$video['label'] = shtmlspecialchars(trim($_POST['label']));
			$video['club'] = $_POST['club'];
			$video['clubtagid'] = $_POST['clubtagid'];
			$video['provider'] = $_POST['provider'];
			$video['captionsmaker'] = $_POST['captionsmaker'];
			$video['linesmaker'] = $_POST['linesmaker'];
			$video['director'] = $_POST['director'];
			$video['producer'] = $_POST['producer'];
			$video['cast'] = $_POST['cast'];
			$video['effector'] = $_POST['effector'];
			$video['photographer'] = $_POST['photographer'];
			$video['producedate'] = sstrtotime($_POST['producedate']);
			$video['lastpost'] = $_SGLOBAL['timestamp'];
					
			if(empty($video['subject'])){
				showmessage('video_subject_empty');
			}elseif(empty($video['product'])){
				showmessage('video_product_empty');
			}elseif(empty($video['message'])){
				showmessage('video_message_empty');
			}elseif(empty($video['productclassid'])){
				showmessage('video_productclassid_empty');
			}elseif(empty($video['club'])){
				showmessage('video_club_empty');
			}

			if(empty($video['videoid'])) {
				$video['videoid'] = inserttable('video', $video, 1);
			}else{
				//更新
				updatetable('video', $video, array('videoid'=>$video['videoid']));
			}	
	
			updatevideolabel($video['label']);
			updatevideospace($video['uid'],$video['videoid']);
			//产生feed
			if($_POST['makefeed']) {
				include_once(S_ROOT.'./source/function_feed.php');
				feed_publish($video['videoid'], 'videoid');
			}
	
			showmessage('do_success', $_POST[referlink], 1);
		}
		elseif($_GET['subop']=='delete'){
			$ids=array();
			$ids[]=0;
			$ids[]=$video[videoid];
			deletevideos($ids);
			
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

	$mpurl = 'admincp.php?ac=video';
	$list = array();
	$multi = '';
	
	$intkeys = array('productclassid','videoid');
	$strkeys = array();
	$likekeys = array('subject','club');
	$results = getwheres($intkeys, $strkeys, $randkeys, $likekeys, 'v.');
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
		$csql = "SELECT COUNT(*) FROM ".tname('video')." v WHERE 1=1 and $wheresql";
		$qsql = "SELECT * FROM ".tname('video')." v WHERE 1=1 and $wheresql order by v.videoid DESC LIMIT $start,$perpage";
	}
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($csql), 0);
	if($count) {
		$list=queryvideo($qsql);
		
		//显示分页
		$multi = multi($count, $perpage, $page, $mpurl);
	}
	
	$managebatch = checkperm('managebatch');
	$allowbatch = true;
	$actives = array($view => ' class="active"');
}

?>