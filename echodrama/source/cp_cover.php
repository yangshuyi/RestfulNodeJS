<?php
/*
 [UCenter Home] (C) 2007-2008 Comsenz Inc.
 $Id: cp_repaste.php 13026 2009-08-06 02:17:33Z liguode $
 */

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//检查信息
$coverid = empty($_GET['coverid'])?0:intval($_GET['coverid']);
$op = empty($_GET['op'])?'':$_GET['op'];

include_once(S_ROOT.'./data/data_coverproductclass.php');
include_once(S_ROOT.'./source/function_cover.php');

if( $_GET['op'] == 'new' ) {
	$cover=array();
	
	$nav_list = array();
	$nav_item = array();
	$nav_item['url'] = "space.php?do=cover"; $nav_item['dispname'] = "乐虫翻唱";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "space.php?do=cover&view=all"; $nav_item['dispname'] = "翻唱库";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "cp.php?ac=cover&op=new"; $nav_item['dispname'] = "添加新翻唱";
	$nav_list[] = $nav_item;
	
	include_once template("cp_cover");
}
elseif( $_GET['op'] == 'edit' ) {
	
	submitcheck('coversubmit');
	
	if(empty($coverid)) {
		showmessage("cover_does_not_exist"); // 翻唱不存在或者已被删除
	}
	
	$cover=loadcoverbyid($coverid);
	
	//翻唱不存在
	if(empty($cover)) {
		showmessage('cover_does_not_exist');
	}
	
	$cover=coverformmapper($cover);
	
	if($cover['uid'] != $_SGLOBAL['supe_uid']){
		showmessage('no_privilege');// 您目前没有权限进行此操作
	}

	$nav_list = array();
	$nav_item = array();
	$nav_item['url'] = "space.php?do=cover"; $nav_item['dispname'] = "乐虫翻唱";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "space.php?do=cover&view=all"; $nav_item['dispname'] = "翻唱库";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "cp.php?ac=cover&op=edit&coverid=$cover[coverid]"; $nav_item['dispname'] = "编辑翻唱";
	$nav_list[] = $nav_item;
	
	include_once template("cp_cover");
}
elseif( $_GET['op'] == 'save' ) {

	if($coverid<=0) {
		$cover = array();
		$cover['dateline']=$_SGLOBAL['timestamp'];
		$cover['uid'] = $_SGLOBAL['supe_uid'];
		$cover['username'] = $_SGLOBAL['supe_username'];
	} else {
		$cover=loadcoverbyid($coverid);
		//翻唱不存在
		if(empty($cover)) {
			showmessage('cover_does_not_exist');
		}
	}

	if(!checkperm('allowcover')) {
		ckspacelog();
		showmessage('no_authority_to_add_cover');
	}

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
		updatecoverreward($cover['uid'],'cover_add');
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
	
	showmessage('do_success', "space.php?do=cover&view=me", 0);
	
} 
elseif($_GET['op'] == 'delete') {
	$cover=loadcoverbyid($coverid);
	//删除
	if(empty($cover)) {
		showmessage('cover_does_not_exist');
	}
		
	if(!checkperm('managecover')) {
		showmessage('no_privilege');
	}

	$ids=array();
	$ids[]=$cover[coverid];
	deletecovers($ids);

	showmessage('do_success', "space.php?do=cover&view=me");

} 
elseif($_GET['op'] == 'share') {
	if(empty($coverid)) {
		showmessage("cover_does_not_exist"); 
	}
	$cover=loadcoverbyid($coverid);
	//翻唱不存在
	if(empty($cover)) {
		showmessage('cover_does_not_exist');
	}
	
	//AJAX CALL
	$_SGLOBAL['inajax'] = 1;
	
	if($_GET['toshare']==0){
		//取消收藏
		$tuSql = "DELETE FROM ".tname('coveruser')." WHERE coverid=$coverid and uid=$_SGLOBAL[supe_uid]";
		$_SGLOBAL['db']->query($tuSql);
		
	}else if($_GET['toshare']==1){
		//加入收藏
		$tuSql = "SELECT COUNT(id) FROM ".tname('coveruser')." WHERE coverid=$coverid and uid=$_SGLOBAL[supe_uid]";
		$tuCount = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($tuSql), 0);
		if($tuCount<=0){
			$coveruser = Array();
			$coveruser['id'] = null;
			$coveruser['uid'] = $_SGLOBAL['supe_uid'];
			$coveruser['coverid'] = $coverid;
			$coveruser['username'] = $_SGLOBAL['supe_username'];
			$coveruser['dateline'] = $_SGLOBAL['timestamp'];
			inserttable("coveruser", $coveruser);
		}
	}else{
		showMessage("no action");	
	}
	
	$sql="update ".tname('cover')." c set c.joinnum=(select count(cu.uid) from ".tname('coveruser')." cu where cu.coverid=$coverid) where c.coverid=$coverid";
	$_SGLOBAL['db']->query($sql);
	
	
//	$updateShareSql="UPDATE ".tname('cover')." SET joinnum = (SELECT COUNT(id) FROM ".tname('coveruser')." WHERE coverid=$coverid ) where coverid=$coverid";
//	$_SGLOBAL['db']->query($updateShareSql);
//	showmessage($updateShareSql);
	
//	print("<obj toshare='$toshare' tuCount='$tuCount'></obj><ajax>");
//	exit();
	showmessage('ajax_param', '', 0, array($tuCount,$_GET['toshare']));
	
}
elseif($_GET['op'] == 'poll') {
	if(empty($coverid)) {
		showmessage("cover_does_not_exist"); 
	}
	
	$cover=loadcoverbyid($coverid);
	//翻唱不存在
	if(empty($cover)) {
		showmessage('cover_does_not_exist');
	}
	
	$userip=getonlineip();
	$coverpollsql= "SELECT * FROM ".tname('coverpoll')." tp WHERE tp.coverid=$coverid and ( tp.uid='$_SGLOBAL[supe_uid]' OR tp.userip='$userip' )";
	$coverpoll = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($coverpollsql));
	if( !empty($coverpoll) ){
		return;
	}
	
	//AJAX CALL
	$_SGLOBAL['inajax'] = 1;
	
	$coverpoll = array();
	$coverpoll['coverid']=$coverid;
	$coverpoll['uid']= $_SGLOBAL['supe_uid'];
	$coverpoll['username']= $_SGLOBAL['supe_username'];
	$coverpoll['userip']=getonlineip();
	$coverpoll['pollvalue']=$_GET['coverpollvalue'];
	$coverpoll['polldateline']=$_SGLOBAL['timestamp'];;
	inserttable("coverpoll", $coverpoll);
	
	$updatepollinforSql="  UPDATE ".tname('cover')." ";
	$updatepollinforSql.=" SET poll_".$coverpoll['pollvalue']." = (SELECT COUNT(coverpollid) FROM ".tname('coverpoll')." WHERE coverid=$coverid AND pollvalue='$coverpoll[pollvalue]' )";
	$updatepollinforSql.=" where coverid=$coverid";
	$_SGLOBAL['db']->query($updatepollinforSql);
	
	showmessage('ajax_param', '', 0, array($_GET['coverid'], $_GET['coverpollvalue']));
}
elseif($_GET['op'] == 'viewpoll') {
	if(empty($coverid)) {
		showmessage("cover_does_not_exist"); 
	}
	
	$cover=loadcoverbyid($coverid);
	//翻唱不存在
	if(empty($cover)) {
		showmessage('cover_does_not_exist');
	}
	
	$cover=coverformmapper($cover);
	
	include_once template("space_cover_poll");
}
elseif($_GET['op'] == 'invite') {
	//邀请
	$cover=loadcoverbyid($coverid);
	//声线不存在
	if(empty($cover)) {
		showmessage('cover_does_not_exist');
	}
	if($cover['uid'] != $_SGLOBAL['supe_uid']){
		showmessage('no_privilege');// 您目前没有权限进行此操作
	}
	
	$uidarr = explode(',', $cover['invite']);
	//反转数组
	$newuid = array_flip($uidarr);
	if(submitcheck('invitesubmittype')) {
		
		if($_POST["invitesubmittype"]==1){ //invite target
			$ids = empty($_POST['ids'])?array():$_POST['ids'];
		}
		elseif($_POST['invitesubmittype']==2){ //invite all
			$friendsql="SELECT * FROM ".tname('friend')." WHERE uid='$cover[uid]' AND status='1'";
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
				$_SGLOBAL['db']->query("UPDATE ".tname('cover')." SET invite='".implode(',', $newinvite)."' WHERE coverid='$coverid'");
			}
			//通知
			$cover = coverformmapper($cover);
			$note = "邀请你一起欣赏他/她的翻唱作品<a href=\"space.php?do=cover&coverid=$cover[coverid]\" target=\"_blank\"> $cover[subject]</a>";
			foreach($ids as $key => $uid) {
				if($uid && $uid != $_SGLOBAL['supe_uid']) {
					notification_add($uid, 'coverinvite', $note);
				}
			}
		}
		showmessage('do_success', "cp.php?ac=cover&op=invite&coverid=$cover[coverid]&group=$_GET[group]&page=$_GET[page]&start=$_GET[start]", 1);
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
		
	$csql = "SELECT COUNT(*) FROM ".tname('friend')." WHERE uid='$cover[uid]' AND status='1' $sql";
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($csql), 0);
	$fuids = array();
	if($count) {
		$friendsql="SELECT * FROM ".tname('friend')." WHERE uid='$cover[uid]' AND status='1' $sql ORDER BY num DESC, dateline DESC LIMIT $start,$perpage";
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
		
	$multi = multi($count, $perpage, $page, "cp.php?ac=cover&op=invite&coverid=$cover[coverid]&group=$_GET[group]");
	
	include_once template("cp_cover");
} 
elseif($_GET['op'] == 'querymds') {
		
	//处理搜索
	include_once(S_ROOT.'./source/function_admincp.php');
	
	$wheresql = "";
	$mpurl="cp.php?ac=cover&op=querymds";
	
	if($_GET['coverid']) {
		$wheresql = $wheresql." AND v.coverid = '$_GET[coverid]' ";
		$mpurl .= '&coverid='.$_GET['coverid'];
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
	$csql = "SELECT COUNT(*) FROM ".tname('cover')." v WHERE 1=1 $wheresql";
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($csql), 0);

	$qsql = "SELECT * FROM ".tname('cover')." v WHERE 1=1 $wheresql order by v.dateline desc LIMIT $start,$perpage";
	
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($csql), 0);
	if($count) {
		
		$list=querycover($qsql);
		
		//显示分页
		$multi = multi($count, $perpage, $page, $mpurl);
	}
	
	include_once template("cp_cover_query_list");
}
elseif($_GET['op'] == 'loadcoverbyid_ajax') {
	if(empty($coverid)) {
		showmessage("cover_does_not_exist");
	}
	$cover=loadcoverbyid($coverid);
	//翻唱不存在
	if(empty($cover)) {
		showmessage('cover_does_not_exist');
	}
	$cover=coverformmapper($cover);
	showmessage('ajax_param', '', 0, array($cover['coverid'],$cover['subject'],$cover['productclassid'],$cover['productclassname'],$cover['clubtagid'],$cover['club']));
} 
?>