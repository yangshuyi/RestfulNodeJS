<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: admincp_blog.php 9233 2008-10-28 06:21:44Z liguode $
*/

if(!defined('IN_UCHOME') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

//权限
if(!checkperm('managetopic')) {
	cpmessage('no_authority_management_operation');
}

$topicalbumid = empty($_GET['topicalbumid'])?0:intval($_GET['topicalbumid']);
$_GET['op'] = empty($_GET['op'])?'list':$_GET['op'];
$_GET['subop'] = isset($_GET['subop'])?$_GET['subop']:'manage';

include_once(S_ROOT.'./source/function_topic.php');
include_once(S_ROOT.'./data/data_productclass.php');
include_once(S_ROOT.'./source/function_cp.php');

if($_GET['op'] == 'new') {
	submitcheck('topicsubmit');
	
	$topicalbum = array();
	$topicalbum['type']='album';
	
	$topicadditioninfo = array();
		
} 
elseif($_GET['op'] == 'manage') {

	submitcheck('topicsubmit');
	
	if(!$topicalbumid) {
		showmessage("topic_album_does_not_exist");
	}
	$topicalbum=loadtopicalbumbyid($topicalbumid);
	
	if(empty($topicalbum)) {
		showmessage('topic_album_does_not_exist');
	}
	
	if(empty($_POST['formhash'])) {
		$topicalbum=topicalbumformmapper($topicalbum);
		$topicadditioninfo = querytopicadditioninfobytopic($topicalbumid);
	}
	else{
		if( $_GET['subop'] == 'deletepic' ){
			$picpath=pic_get($topicalbum['pic'], 0, $topicalbum['remote']);
			if(file_exists($picpath)){
				unlink($picpath);
			}
			$thumbpath=$picpath.'.thumb.jpg';
			if(file_exists($thumbpath)){
				unlink($thumbpath);
			}
				
			$updateSql="UPDATE ".tname('topic')." SET pic = '' where topicid=$topicalbumid";
			$_SGLOBAL['db']->query($updateSql);
		}
		else if( $_GET['subop'] == 'uploadpic' ){
			$picpath = $_FILES['newpic'];
			
			if(empty($picpath)){
				showmessage("topic_pic_empty");
			}
			
			$picpath=topicPic_save($picpath);
			
			//默认图片
			$picPath=$_SC['attachdir'].'./'.$picpath;
			if(!is_file($picPath)){
				$picpath=getfilepath("jpg",true);
				copy("image/notopicpic.jpg",$_SC['attachdir'].'./'.$picpath); 
			}
			
			$updateSql="UPDATE ".tname('topic')." SET pic = '$picpath' where topicid=$topicalbumid";
			$_SGLOBAL['db']->query($updateSql);
		}
		showmessage('do_success', "/admincp.php?ac=topicalbum&op=manage&subop=process&topicalbumid=$topicalbumid", 1);
	}
}
elseif($_GET['op'] == 'delete') {

	submitcheck('topicsubmit');
	
	if(!$topicalbumid) {
		showmessage("topic_album_does_not_exist");
	}
	$topicalbum=loadtopicalbumbyid($topicalbumid);
	if(empty($topicalbum)) {
		showmessage('topic_album_does_not_exist');
	}
	
	$topicalbum = topicalbumformmapper($topicalbum);
	if(file_exists($topicalbum['pic'])){
		unlink($topicalbum['pic']);
	}
	
	$_SGLOBAL['db']->query("DELETE FROM ".tname('topic_album')." WHERE topicalbumid=$topicalbum[topicid]");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('topic')." WHERE topicid=$topicalbum[topicid]");
	
	showmessage('do_success', $_POST['referlink'], 1);

} 
elseif($_GET['op'] == 'save') {

	submitcheck('topicsubmit');

	// 检查权限
	//		if(!$allowmanage){
	//			showmessage("no_privilege_edit_event");
	//		}
	if(empty($topicalbumid)) {
		// 新广播剧
		$topicalbum=array();
		$topicalbum['topicid'] = null;
		$topicalbum['type'] = 'album';
		$topicalbum['dateline'] = $_SGLOBAL['timestamp'];
		$topicalbum['pic'] = $_FILES['pic'];
		
		$topicadditioninfo = array();
	}
	else{
		$topicalbum=loadtopicalbumbyid($topicalbumid);
		
		if(empty($topicalbum)) {
			showmessage('topic_album_does_not_exist');
		}
		
		$topicadditioninfo = querytopicadditioninfobytopic($topicalbumid);
	}
	
	$topicalbum['subject'] = $_POST['subject'];
	$topicalbum['label'] = $_POST['label'];
	$topicalbum['productclassid'] = $_POST['productclassid'];
	$topicalbum['club'] = $_POST['club'];
	$topicalbum['director'] = $_POST['director'];
	$topicalbum['producer'] = $_POST['producer'];
	$topicalbum['cehua'] = $_POST['cehua'];
	$topicalbum['yuanzhu'] = $_POST['yuanzhu'];
	$topicalbum['writer'] = $_POST['writer'];
	$topicalbum['cast'] = $_POST['cast'];
	$topicalbum['effector'] = $_POST['effector'];
	$topicalbum['photographer'] = $_POST['photographer'];
	$topicalbum['producedate'] = sstrtotime($_POST['producedate']);
	$topicalbum['lastpost'] = $_SGLOBAL['timestamp'];

	$topicadditioninfo['message'] = $_POST['message'];
	
	//检查输入
	if(empty($topicalbum['subject'])) {
		showmessage('topic_album_subject_empty');
	} elseif(empty($topicadditioninfo['message'])) {
		showmessage('topic_album_message_empty');
	} elseif(empty($topicalbum['productclassid'])) {
		showmessage('topic_album_productclassid_empty');
	} elseif(empty($topicalbum['club'])) {
		showmessage('topic_album_club_empty');
	}
	
	if(empty($topicalbumid)) {
		if(!empty($topicalbumid['pic'])){
			showmessage('topic_album_pic_empty');
		}
		$topicalbum['pic']=topicPic_save($topicalbum['pic']);
		
		//默认图片
		$picPath=$_SC['attachdir'].'./'.$topicalbum['pic'];
		if(!is_file($picPath)){
			$picpath=getfilepath("jpg",true);
			copy("image/nopic.gif",$_SC['attachdir'].'./'.$picpath); 
			$topicalbum['poster'] = $picpath;
		}
	}
	//save topic album
	if(empty($topicalbumid)) {
		$topicalbumid=inserttable("topic", $topicalbum, 1);
		$topicalbum['topicid']=$topicalbumid;
		
		generatenumber($topicalbum);
	}else{
		updatetable('topic', $topicalbum, array('topicid'=>$topicalbumid));
	}
	
	//refresh topic
	if(!empty($topicalbumid)) {
		$sql="DELETE FROM ".tname('topic_album')." WHERE topicalbumid=$topicalbumid";
		$_SGLOBAL['db']->query($sql);
	}
	
	$topicids = $_POST['topicids'];
	$topicidarray = split(',',$topicids);
	$index=0;
	foreach($topicidarray as $topicid){
		if(empty($topicid)){
			continue;
		}
		$topic=loadtopicbyid($topicid);
		
		if($topic) {
			$topicalbum_topic=array();
			$topicalbum_topic['topicalbumid']=$topicalbumid;
			$topicalbum_topic['topicid']=$topic['topicid'];
			$topicalbum_topic['index']=$index;
			$index++;
			
			inserttable("topic_album", $topicalbum_topic);
		}	
	}
	
	updatesystemtopiclabel($topic);

	showmessage('do_success', $_POST['referlink'], 1);
	
}
elseif($_GET['op'] == 'saveorders') {
	// 搜索
	$orders=$_POST['orders'];
	$orderarray= explode(',', $orders);
	$number=1;
	foreach($orderarray as $topicalbumid) {
		if(empty($topicalbumid)){
			continue;
		}
		$updateSql="UPDATE ".tname('topic')." SET number = '$number' where topicid='$topicalbumid' and type='album' ";
		$_SGLOBAL['db']->query($updateSql);
		$number=$number+1;
	}
	showmessage('do_success', "admincp.php?ac=topicalbum&op=order&view=order", 1);
}
elseif($_GET['op'] == 'list') {
	// 搜索
	
	$page = empty($_GET['page'])?1:intval($_GET['page']);
	if($page<1) $page = 1;
	
	$perpage = 50;
	$start = ($page-1)*$perpage;
	
	//处理搜索
	include_once(S_ROOT.'./source/function_admincp.php');

	$mpurl = 'admincp.php?ac=topicalbum';
	$list = array();
	$multi = '';

	//所有的广播剧
	$intkeys = array('productclassid');
	$strkeys = array();
	//TODO 日期查询有问题
	$randkeys = array(array('sstrtotime','producedate'), array('intval','viewnum'), array('intval','replynum'), array('intval','hot'));
	$likekeys = array('subject','club','director','writer','cast','producer','effector','photographer');
	$results = getwheres($intkeys, $strkeys, $randkeys, $likekeys, 't.');
	$wherearr = $results['wherearr'];
	$mpurl .= '&'.implode('&', $results['urls']);
		
	$wheresql = empty($wherearr)?'1':implode(' AND ', $wherearr);

	$page = empty($_GET['page'])?1:intval($_GET['page']);
	$mpurl .= '&perpage='.$perpage;
		
	if($page<1) $page = 1;
	$start = ($page-1)*$perpage;

	//检查开始数
	ckstart($start, $perpage);
	
	//显示分页
	$csql = "SELECT COUNT(*) FROM ".tname('topic')." t WHERE t.type='album' and $wheresql";
	$qsql = "SELECT * FROM ".tname('topic')." t WHERE t.type='album' and $wheresql order by t.dateline DESC LIMIT $start,$perpage";
	
	//print($csql);
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($csql), 0);
	
	if($count) {
		$list=queryalbum($qsql);
		
		//显示分页
		$multi = multi($count, $perpage, $page, $mpurl);
	}
	
	$actives = array('album' => ' class="active"');
}
elseif($_GET['op'] == 'order') {

	$topicalbumsql="SELECT t.* FROM ".tname('topic')." t WHERE t.type='album' ORDER BY t.number";
	$topicalbumlist = queryalbum($topicalbumsql);
	
	$actives = array('order' => ' class="active"');
}

?>