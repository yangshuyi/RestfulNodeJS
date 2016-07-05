<?php
/*
 [UCenter Home] (C) 2007-2008 Comsenz Inc.
 $Id: cp_repaste.php 13026 2009-08-06 02:17:33Z liguode $
 */

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//检查信息
$videoid = empty($_GET['videoid'])?0:intval($_GET['videoid']);
$op = empty($_GET['op'])?'':$_GET['op'];

include_once(S_ROOT.'./data/data_videoproductclass.php');
include_once(S_ROOT.'./source/function_video.php');

if( $_GET['op'] == 'new' ) {
	$video=array();
	
	$nav_list = array();
	$nav_item = array();
	$nav_item['url'] = "space.php?do=video"; $nav_item['dispname'] = "视频映像";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "space.php?do=video&view=all"; $nav_item['dispname'] = "视频列表";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "cp.php?ac=video&op=new"; $nav_item['dispname'] = "添加新视频";
	$nav_list[] = $nav_item;
	
	include_once template("cp_video");
}
elseif( $_GET['op'] == 'edit' ) {
	
	submitcheck('videosubmit');
	
	if(empty($videoid)) {
		showmessage("video_does_not_exist"); // 视频不存在或者已被删除
	}
	
	$video=loadvideobyid($videoid);
	
	//视频不存在
	if(empty($video)) {
		showmessage('video_does_not_exist');
	}
	
	$video=videoformmapper($video);
	
	if($video['uid'] != $_SGLOBAL['supe_uid']){
		showmessage('no_privilege');// 您目前没有权限进行此操作
	}

	$nav_list = array();
	$nav_item = array();
	$nav_item['url'] = "space.php?do=video"; $nav_item['dispname'] = "视频映像";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "space.php?do=video&view=all"; $nav_item['dispname'] = "视频列表";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "cp.php?ac=video&op=edit&videoid=$video[videoid]"; $nav_item['dispname'] = "编辑翻唱";
	$nav_list[] = $nav_item;
	
	include_once template("cp_video");
}
elseif( $_GET['op'] == 'save' ) {

	if($videoid<=0) {
		$video = array();
		$video['dateline']=$_SGLOBAL['timestamp'];
		$video['uid'] = $_SGLOBAL['supe_uid'];
		$video['username'] = $_SGLOBAL['supe_username'];
	} else {
		$video=loadvideobyid($videoid);
		//视频不存在
		if(empty($video)) {
			showmessage('video_does_not_exist');
		}
	}

	if(!checkperm('allowvideo')) {
		ckspacelog();
		showmessage('no_authority_to_add_video');
	}

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
		updatevideoreward($video['uid'],'video_add');
	}else{
		//更新
		updatetable('video', $video, array('videoid'=>$video['videoid']));
	}	
	
	updatesystemvideolabel($topic);
	updatevideospace($video['uid'],$video['videoid']);
		
	//产生feed
	if($_POST['makefeed']) {
		include_once(S_ROOT.'./source/function_feed.php');
		feed_publish($video['videoid'], 'videoid');
	}
	
	showmessage('do_success', "space.php?do=video&view=me", 0);
	
} 
elseif($_GET['op'] == 'delete') {
	
	//删除
	$video=loadvideobyid($videoid);
	if(empty($video)) {
		showmessage('video_does_not_exist');
	}
		
	if(!checkperm('managevideo')) {
		showmessage('no_privilege');
	}
	$ids=array();
	$ids[]=$video[videoid];
	
	deletevideos($ids);

	showmessage('do_success', "space.php?do=video&view=me");

} 
elseif($_GET['op'] == 'share') {
	if(empty($videoid)) {
		showmessage("video_does_not_exist"); 
	}
	$video=loadvideobyid($videoid);
	//视频不存在
	if(empty($video)) {
		showmessage('video_does_not_exist');
	}
	
	//AJAX CALL
	$_SGLOBAL['inajax'] = 1;
	
	if($_GET['toshare']==0){
		//取消收藏
		$tuSql = "DELETE FROM ".tname('videouser')." WHERE videoid=$videoid and uid=$_SGLOBAL[supe_uid]";
		$_SGLOBAL['db']->query($tuSql);
		
	}else if($_GET['toshare']==1){
		//加入收藏
		$tuSql = "SELECT COUNT(id) FROM ".tname('videouser')." WHERE videoid=$videoid and uid=$_SGLOBAL[supe_uid]";
		$tuCount = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($tuSql), 0);
		if($tuCount<=0){
			$videouser = Array();
			$videouser['id'] = null;
			$videouser['uid'] = $_SGLOBAL['supe_uid'];
			$videouser['videoid'] = $videoid;
			$videouser['username'] = $_SGLOBAL['supe_username'];
			$videouser['dateline'] = $_SGLOBAL['timestamp'];
			inserttable("videouser", $videouser);
		}
	}else{
		showMessage("no action");	
	}
	
	$sql="update ".tname('video')." c set c.joinnum=(select count(cu.uid) from ".tname('videouser')." cu where cu.videoid=$videoid) where c.videoid=$videoid";
	$_SGLOBAL['db']->query($sql);
	
	
//	$updateShareSql="UPDATE ".tname('video')." SET joinnum = (SELECT COUNT(id) FROM ".tname('videouser')." WHERE videoid=$videoid ) where videoid=$videoid";
//	$_SGLOBAL['db']->query($updateShareSql);
//	showmessage($updateShareSql);
	
//	print("<obj toshare='$toshare' tuCount='$tuCount'></obj><ajax>");
//	exit();
	showmessage('ajax_param', '', 0, array($tuCount,$_GET['toshare']));
	
}
elseif($_GET['op'] == 'setvideolabel') {
	//AJAX CALL
	$_SGLOBAL['inajax'] = 1;
	
	if(empty($videoid)) {
		showmessage("video_does_not_exist"); 
	}
	
	$video=loadvideobyid($videoid);
	//视频不存在
	if(empty($video)) {
		showmessage('video_does_not_exist');
	}
	
	$delete_existvideolabel_sql="DELETE FROM ".tname('videolabel')." WHERE videoid='$videoid' AND uid='$_SGLOBAL[supe_uid]'";
	$_SGLOBAL['db']->query($delete_existvideolabel_sql);
	
	$videolabel = array();
	$videolabel['videoid']=$videoid;
	$videolabel['uid']= $_SGLOBAL['supe_uid'];
	$videolabel['username']= $_SGLOBAL['supe_username'];
	$videolabel['label']=$_GET['videolabel'];
	$videopoll['postdate']=$_SGLOBAL['timestamp'];;
	inserttable("videolabel", $videolabel);
	
	showmessage('ajax_param', '', 0, array($_GET['videoid'], $_GET['videolabel']));
}
elseif($_GET['op'] == 'removevideolabel') {
	if(empty($videoid)) {
		showmessage("video_does_not_exist"); 
	}
	
	$video=loadvideobyid($videoid);
	//视频不存在
	if(empty($video)) {
		showmessage('video_does_not_exist');
	}
	
	//AJAX CALL
	$_SGLOBAL['inajax'] = 1;
	
	$remove_videolabel_sql.="DELETE FROM ".tname('videolabel')." where videoid='$videoid' AND uid='$_SGLOBAL[supe_uid]'";
	$_SGLOBAL['db']->query($remove_videolabel_sql);
	showmessage('ajax_param', '', 0, array($_GET['videoid'], $_GET['videolabel']));
}
elseif($_GET['op'] == 'viewvideolabel') {
	if(empty($videoid)) {
		showmessage("video_does_not_exist"); 
	}
	
	$video=loadvideobyid($videoid);
	//视频不存在
	if(empty($video)) {
		showmessage('video_does_not_exist');
	}
	
	//广播剧标签
	$videolabel_list = loadvideolabelbyvideoid($video[videoid]);
	
	$videolabel_latest_sql = "SELECT vl.* FROM ".tname('videolabel')." vl WHERE vl.videoid='$videoid' AND vl.uid>0 ORDER BY vl.lastpost DESC LIMIT 0, 10";
	$videolabel_lastest_list = queryvideolabel($videolabel_latest_sql);
	
	$videolabel_me_sql = "SELECT vl.label FROM ".tname('videolabel')." vl WHERE vl.videoid='$videoid' AND uid='$_SGLOBAL[supe_uid]' ORDER BY vl.lastpost DESC";
	$videolabel_me_list = queryvideolabel($videolabel_me_sql);
	
	include_once template("space_video_view_sidebar_label");
}
elseif($_GET['op'] == 'poll') {
	if(empty($videoid)) {
		showmessage("video_does_not_exist"); 
	}
	
	$video=loadvideobyid($videoid);
	//视频不存在
	if(empty($video)) {
		showmessage('video_does_not_exist');
	}
	
	$userip=getonlineip();
	$videopollsql= "SELECT * FROM ".tname('videopoll')." tp WHERE tp.videoid=$videoid and ( tp.uid='$_SGLOBAL[supe_uid]' OR tp.userip='$userip' )";
	$videopoll = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($videopollsql));
	if( !empty($videopoll) ){
		return;
	}
	
	//AJAX CALL
	$_SGLOBAL['inajax'] = 1;
	
	$videopoll = array();
	$videopoll['videoid']=$videoid;
	$videopoll['uid']= $_SGLOBAL['supe_uid'];
	$videopoll['username']= $_SGLOBAL['supe_username'];
	$videopoll['userip']=getonlineip();
	$videopoll['pollvalue']=$_GET['videopollvalue'];
	$videopoll['polldateline']=$_SGLOBAL['timestamp'];;
	inserttable("videopoll", $videopoll);
	
	$updatepollinforSql="  UPDATE ".tname('video')." ";
	$updatepollinforSql.=" SET poll_".$videopoll['pollvalue']." = (SELECT COUNT(videopollid) FROM ".tname('videopoll')." WHERE videoid=$videoid AND pollvalue='$videopoll[pollvalue]' )";
	$updatepollinforSql.=" where videoid=$videoid";
	$_SGLOBAL['db']->query($updatepollinforSql);
	
	showmessage('ajax_param', '', 0, array($_GET['videoid'], $_GET['videopollvalue']));
}
elseif($_GET['op'] == 'viewpoll') {
	if(empty($videoid)) {
		showmessage("video_does_not_exist"); 
	}
	
	$video=loadvideobyid($videoid);
	//视频不存在
	if(empty($video)) {
		showmessage('video_does_not_exist');
	}
	
	$video=videoformmapper($video);
	
	include_once template("space_video_view_sidebar_poll");
}
elseif($_GET['op'] == 'invite') {
	//邀请
	$video=loadvideobyid($videoid);
	//声线不存在
	if(empty($video)) {
		showmessage('video_does_not_exist');
	}
	if($video['uid'] != $_SGLOBAL['supe_uid']){
		showmessage('no_privilege');// 您目前没有权限进行此操作
	}
	
	$uidarr = explode(',', $video['invite']);
	//反转数组
	$newuid = array_flip($uidarr);
	if(submitcheck('invitesubmittype')) {
		
		if($_POST["invitesubmittype"]==1){ //invite target
			$ids = empty($_POST['ids'])?array():$_POST['ids'];
		}
		elseif($_POST['invitesubmittype']==2){ //invite all
			$friendsql="SELECT * FROM ".tname('friend')." WHERE uid='$video[uid]' AND status='1'";
			$query = $_SGLOBAL['db']->query($friendsql);
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				$ids[] = $value['fuid'];
			}
		}
		if($ids) {
			//过滤已邀请的用户
			foreach($ids as $key => $uid) {
				if(isset($newuid[$uid])) {
					unset($ids[$key]);
				} else {
					$ids[$key] = intval($uid);
				}
			}
			
			//验证用户的真实性
			$query = $_SGLOBAL['db']->query("SELECT uid FROM ".tname('space')." WHERE uid IN (".simplode($ids).")");
			$ids = array();
			while($value = $_SGLOBAL['db']->fetch_array($query)) {
				$ids[$value['uid']] = $value['uid'];
			}
			//合并新数组
			$newinvite = array_merge($uidarr, $ids);
			
			//存入数据库
			if($newinvite) {
				$_SGLOBAL['db']->query("UPDATE ".tname('video')." SET invite='".implode(',', $newinvite)."' WHERE videoid='$videoid'");
			}
			//通知
			$video = videoformmapper($video);
			$note = "邀请你一起欣赏他/她的视频作品 <a href=\"space.php?do=video&videoid=$video[videoid]\" target=\"_blank\"> $video[subject]</a>";
			foreach($ids as $key => $uid) {
				if($uid && $uid != $_SGLOBAL['supe_uid']) {
					notification_add($uid, 'videoinvite', $note);
				}
			}
		}
		showmessage('do_success', "cp.php?ac=video&op=invite&videoid=$video[videoid]&group=$_GET[group]&page=$_GET[page]&start=$_GET[start]", 1);
	}
	
	//分页
	$perpage = 24;
	$page = empty($_GET['page'])?0:intval($_GET['page']);
	if($page<1) $page = 1;
	$start = ($page-1)*$perpage;
		
	//检查开始数
	ckstart($start, $perpage);
		
	$list = array();

	$wherearr = array();
	$_GET['group'] = isset($_GET['group'])?intval($_GET['group']):-1;
	if($_GET['group'] >= 0) {
		$wherearr[] = " gid='$_GET[group]'";
	}

	$sql = $wherearr ? 'AND'.implode(' AND ', $wherearr) : '';
		
	$csql = "SELECT COUNT(*) FROM ".tname('friend')." WHERE uid='$video[uid]' AND status='1' $sql";
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($csql), 0);
	$fuids = array();
	if($count) {
		$friendsql="SELECT * FROM ".tname('friend')." WHERE uid='$video[uid]' AND status='1' $sql ORDER BY num DESC, dateline DESC LIMIT $start,$perpage";
		$query = $_SGLOBAL['db']->query($friendsql);
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			realname_set($value['fuid'], $value['fusername']);
			$list[] = $value;
			$fuids[] = $value['fuid'];
		}
	}
	$invitearr = array();
	
	//已邀请
	foreach($uidarr as $key => $uid) {
		$invitearr[$uid] = $uid;
	}
	
	realname_get();
			
	//用户组
	$groups = getfriendgroup();
	$groupselect = array($_GET['group'] => ' selected');
		
	$multi = multi($count, $perpage, $page, "cp.php?ac=video&op=invite&videoid=$video[videoid]&group=$_GET[group]");
	include_once template("cp_video");
}
elseif($_GET['op'] == 'querymds') {
		
	//处理搜索
	include_once(S_ROOT.'./source/function_admincp.php');
	
	$wheresql = "";
	$mpurl="cp.php?ac=video&op=querymds";
	
	if($_GET['videoid']) {
		$wheresql = $wheresql." AND v.videoid = '$_GET[videoid]' ";
		$mpurl .= '&videoid='.$_GET['videoid'];
	}
	
 	if($_GET['subject']) {
		$wheresql = $wheresql." AND v.subject like '%$_GET[subject]%' ";
		$mpurl .= '&subject='.$_GET['subject'];
	}
	
  	if($_GET['productclassid']) {
		$wheresql = $wheresql." AND v.productclassid = '$_GET[productclassid]' ";
		$mpurl .= '&productclassid='.$_GET['productclassid'];
	}
	
 	if($_GET['widget']) {
		$mpurl .= '&widget='.$_GET['widget'];
	}
	
	$perpage = 8;
	$page = empty($_GET['page'])?1:intval($_GET['page']);
	$mpurl .= '&perpage='.$perpage;
		
	if($page<1) $page = 1;
	$start = ($page-1)*$perpage;
	//检查开始数
	ckstart($start, $perpage);

	//显示分页
	$csql = "SELECT COUNT(*) FROM ".tname('video')." v WHERE 1=1 $wheresql";
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($csql), 0);

	$qsql = "SELECT * FROM ".tname('video')." v WHERE 1=1 $wheresql order by v.dateline desc LIMIT $start,$perpage";
	
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($csql), 0);
	if($count) {
		
		$list=queryvideo($qsql);
		
		//显示分页
		$multi = multi($count, $perpage, $page, $mpurl);
	}
	
	include_once template("cp_video_query_list");
}
elseif($_GET['op'] == 'loadvideobyid_ajax') {
	if(empty($videoid)) {
		showmessage("video_does_not_exist");
	}
	$video=loadvideobyid($videoid);
	//视频不存在
	if(empty($video)) {
		showmessage('video_does_not_exist');
	}
	$video=videoformmapper($video);
	showmessage('ajax_param', '', 0, array($video['videoid'],$video['subject'],$video['productclassid'],$video['productclassname'],$video['clubtagid'],$video['club']));
} 


?>