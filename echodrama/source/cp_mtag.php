<?php
/*
 [UCenter Home] (C) 2007-2008 Comsenz Inc.
 $Id: cp_mtag.php 13223 2009-08-24 01:53:27Z liguode $
 */

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

include_once(S_ROOT.'./data/data_profield.php');
include_once(S_ROOT.'./source/function_mtag.php');
include_once(S_ROOT.'./source/function_thread.php');
include_once(S_ROOT.'./source/function_resume.php');

$_GET['op'] = empty($_GET['op'])?'new':$_GET['op'];

if($_GET['op'] == 'new') {
	//创建新群组
	if(!checkperm('allowmtag')) {
		ckspacelog();
		showmessage('no_privilege');
	}

	//实名认证
	ckrealname('thread');

	//视频认证
	ckvideophoto('thread');

	//新用户见习
	cknewuser();

	//提交
	if(submitcheck('textsubmit')) {

		//自由输入
		$_POST['tagname'] = $tagname = getstr($_POST['tagname'], 40, 1, 1, 1);
		$_POST['fieldid'] = $fieldid = intval($_POST['fieldid']);

		$profield = $_SGLOBAL['profield'][$fieldid];
		if(empty($profield) || $profield['formtype'] != 'text') {
			showmessage('mtag_fieldid_does_not_exist');
		}
		if(strlen($tagname) < 2) {
			showmessage('mtag_tagname_error');
		}

		if(!empty($_POST['joinmode'])) {
			//二次确认
			$mtag = mtag_join('tagname', stripslashes($tagname), $fieldid);
			if(empty($mtag)) {
				showmessage('mtag_join_error');
			} else {
				$url = "space.php?uid=$_SGLOBAL[supe_uid]&do=mtag&tagid=$mtag[tagid]";
				showmessage('join_success', $url, 0);
			}
		} else {
			//寻找
			$newtagname = stripslashes($_POST['tagname']);
			$findmtag = $likemtags = array();
			$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('mtag')." WHERE tagname='$tagname' AND fieldid='$fieldid'");
			if(!$findmtag = $_SGLOBAL['db']->fetch_array($query)) {
				$key = stripsearchkey($_POST['tagname']);
				//找相似的
				$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('mtag')." WHERE tagname LIKE '%$key%' ORDER BY membernum DESC LIMIT 0,20");
				while ($value = $_SGLOBAL['db']->fetch_array($query)) {
					$likemtags[] = $value;
				}
			} else {
				if(empty($findmtag['pic'])) $findmtag['pic'] = 'image/nologo.jpg';
			}
			$_GET['op'] = 'confirm';
			include template("cp_mtag");
			exit();
		}
	} elseif(submitcheck('choicesubmit')) {

		$mtags = array();
		foreach ($_POST['tagname'] as $fieldid => $values) {
			$profield = $_SGLOBAL['profield'][$fieldid];
			if($profield['formtype'] == 'multi') {
				if($values && is_array($values)) {
					foreach ($values as $value) {
						$s = stripslashes($value);
						if(in_array($s, $profield['choice'])) {
							if($mtag = mtag_join('tagname', $s, $fieldid)) {
								$mtags[] = $mtag;
							}
						}
					}
				}
			} elseif($profield['formtype'] == 'select') {
				$s = stripslashes($values);
				if(in_array($s, $profield['choice'])) {
					if($mtag = mtag_join('tagname', $s, $fieldid)) {
						$mtags[] = $mtag;
					}
				}
			} else {
				continue;
			}
		}
		if(empty($mtags)) {
			showmessage('do_success', 'cp.php?ac=mtag');
		} else {
			$_GET['op'] = 'multiresult';
			include template("cp_mtag");
			exit();
		}
	}

	//已经加入的
	$existmtag = array();
	$query = $_SGLOBAL['db']->query("SELECT mtag.tagname, mtag.fieldid FROM ".tname('mtagmember')." main
		LEFT JOIN ".tname('mtag')." mtag ON mtag.tagid=main.tagid
		WHERE main.uid='$_SGLOBAL[supe_uid]'");
	while($value = $_SGLOBAL['db']->fetch_array($query)) {
		$existmtag[$value['fieldid']][] = $value['tagname'];
	}
	include template("cp_mtag");
}
else if($_GET['op'] == 'create') {

	submitcheck('topicsubmit');

	$mtag=array();
	$mtag['tagid'] = null;
	$mtag['tagname'] = trim($_POST['tagname']);
	$mtag['fieldid'] = $_POST['fieldid'];
	$mtag['announcement'] = $_POST['announcement'];
	$mtag['tagstate'] = 2;//已审核
	$mtag['creatorid'] = $_SGLOBAL['supe_uid'];
	$mtag['creatorname'] = $_SGLOBAL['supe_username'];
	$mtag['dateline'] = sstrtotime($_POST['dateline']);

	//检查输入
	if(empty($mtag['tagname'])){
		showmessage('mtag_tagname_empty');
	} elseif(empty($mtag['fieldid'])){
		showmessage('mtag_fieldid_empty');
	} elseif(empty($mtag['announcement'])) {
		showmessage('mtag_announcement_empty');
	}elseif(empty($mtag['dateline'])) {
		showmessage('mtag_announcement_empty');
	}

	$user=queryuserbyid($mtag['creatorid']);

	$mtag['realname'] = $user['name'];
	$existmtaglist = loadmtaglistbytagname($mtag['tagname']);
	if(count($existmtaglist)>0) {
		showmessage('mtag_name_exist');
	}

	if($mtag['fieldid']==1){
		//club
		$mtag['membernum']=1;

	}else if($mtag['fieldid']==2){
		//topic
		$mtag['membernum']=1;

	}else if($mtag['fieldid']==3){
		//cv
		$mtag['membernum']=1;

	}else if($mtag['fieldid']==4){
		//七嘴八舌
		$mtag['membernum']=1;

	}else if($mtag['fieldid']==5){
		//工作室
		$mtag['membernum']=1;

	}else {
		showmessage('mtag_fieldid_unidentitied');
	}
	savemtag($mtag);

	showmessage('apply_submit_success', "space.php?do=mtag", 3);

} elseif($_GET['op'] == 'manage') {

	//显示
	if(empty($_GET['subop'])) {
		$_GET['subop'] = 'index';
	}

	//检查当前用户权限
	$tagid = empty($_GET['tagid'])?0:intval($_GET['tagid']);
	$mtag = loadmtagbyid($tagid);
	if(empty($mtag)){
		showmessage('mtag_not_exist');
	}elseif($mtag['tagstate']==0 || $mtag['tagstate']==1){
		showmessage('mtag_state_not_auditpass');
	}

	$managemtag = 0;

	$membergrade=checkmembergrade($mtag['tagid'], $_SGLOBAL['supe_uid']);

	$privilege = false;
	if($membergrade >= 8) {
		$privilege =true;
	}

	if( $membergrade>=1 && $_GET['subop'] == 'task'){
		$privilege =true;
	}
	
	if( $membergrade>=1 && $_GET['subop'] == 'deletetask'){
		$privilege =true;
	}

	if(!$privilege){
		showmessage('no_privilege');
	}

	$actives = array($_GET['subop'] => ' class="active"');
	
	//编辑用户
	if($_GET['subop'] == 'index') {
		if(empty($_POST['formhash'])) {
			//display
			$mtag = mtagformmapper($mtag);
		}
		else{
			$mtag['message']=$_POST['message'];
			$mtag['announcement']=$_POST['announcement'];

			if($mtag['fieldid']==1){
				//club

			}
			elseif($mtag['fieldid']==2){
				//topic
				$mtag['relatedclubtagid']=$_POST['relatedclubtagid'];
				$mtag['relatedclubtagname']=$_POST['relatedclubtagname'];
			}
			elseif($mtag['fieldid']==3){
				//cv

			}elseif($mtag['fieldid']==4){
				//group

			}
			$mtag['announcement']=$_POST['announcement'];

			if(empty($mtag['announcement'])){
				showmessage('mtag_announcement_empty');
			}

			savemtag($mtag);

			showmessage('do_success', "cp.php?ac=mtag&op=manage&tagid=$tagid&subop=index");
		}
		
		include_once template("cp_mtag_manage_index");
		exit();
	}
	elseif($_GET['subop'] == 'pic') {
		//display
		$mtag = mtagformmapper($mtag);
		
		include_once template("cp_mtag_manage_pic");
		exit();
	}
	elseif($_GET['subop'] == 'picadd') {
		$mtag['pic']=$_FILES['pic'];
		if(empty($mtag['pic'])){
			showmessage('mtag_pic_empty');
		}

		//TODO need refactor
		$mtag['pic']=topicPic_save($mtag['pic']);
		//savemtag($mtag);
		$_SGLOBAL['db']->query("UPDATE ".tname("mtag")." SET pic='$mtag[pic]' where tagid=$tagid");

		showmessage('do_success', "cp.php?ac=mtag&op=manage&tagid=$tagid&subop=pic");
	}
	elseif($_GET['subop'] == 'picdel') {

		//TODO need refactor
		if(!empty($mtag['pic'])){
			unlink($_SC['attachdir'].'./'.$mtag['pic']);
		}

		$_SGLOBAL['db']->query("UPDATE ".tname("mtag")." SET pic='' where tagid=$tagid");
		
		showmessage('do_success', "cp.php?ac=mtag&op=manage&tagid=$tagid&subop=pic");
	}
	elseif($_GET['subop'] == 'handover') {
		if(empty($_POST['formhash'])) {
			//display
			$mtag = mtagformmapper($mtag);
			$membersql="SELECT mm.* FROM ".tname('mtagmember')." mm WHERE mm.tagid = '$mtag[tagid]' and mm.membergradeid=8 and mm.uid!=0 ORDER BY mm.dateline";
			$secondmemberlist=array();
			$query = $_SGLOBAL['db']->query($membersql);
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				$secondmemberlist[]=$value;
			}
		}
		else{
			//recheck
			if($mtag[creatorid]!=$_SGLOBAL['supe_uid']){
				showmessage('no_privilege');
			}

			$oldcreatorid = $mtag[creatorid];
			$newcreatorid=$_POST['creatorid'];
				
			$membergrade=checkmembergrade($mtag[tagid], $mtag[creatorid]);
			if($membergrade!=9){
				showmessage('mtag_member_gradeid_error');
			}

			$membergrade=checkmembergrade($mtag[tagid], $newcreatorid);
			if($membergrade!=8){
				showmessage('mtag_member_gradeid_error');
			}
				
			if( empty($newcreatorid) || $newcreatorid==0 ){
				showmessage('mtag_member_creatorid_error');
			}
			$newcreator=queryuserbyid($newcreatorid);

			$mtag['creatorid']=$newcreatorid;
			$mtag['creatorname']=$newcreator['username'];
			$mtag['realname']=$newcreator['name'];
			savemtag($mtag);
			$_SGLOBAL['db']->query("UPDATE ".tname("mtagmember")." SET membergradeid=8 where tagid=$tagid and uid=$oldcreatorid");
			$_SGLOBAL['db']->query("UPDATE ".tname("mtagmember")." SET membergradeid=9 where tagid=$tagid and uid=$newcreatorid");
				
			notification_add($oldcreatorid,"mtag_manage","群组内部通知</br>您将 <a href=\"space.php?do=mtag&tagid=$mtag[tagid]\">$mtag[tagname]</a> 群组的群主移交给 $newcreator[name] 。",0);
			notification_add($newcreatorid,"mtag_manage","群组内部通知</br>您已被任命为 <a href=\"space.php?do=mtag&tagid=$mtag[tagid]\">$mtag[tagname]</a> 群组的群主。",0);
				
			showmessage('do_success', "cp.php?ac=mtag&op=manage&tagid=$tagid&subop=index");
		}
		
		include_once template("cp_mtag_manage_handover");
		exit();
	}
	elseif($_GET['subop'] == 'advertisements') {
		
		include_once(S_ROOT.'./source/function_advertisement.php');
		
		//display
		$mtag = mtagformmapper($mtag);

		//分页
		$perpage = 30;
		$start = empty($_GET['start'])?0:intval($_GET['start']);
		$advertisementlist = array();
		$count = 0;

		$mpurl = "cp.php?ac=mtag&op=manage&tagid=$mtag[tagid]&subop=advertisements";
				
		//检索
		$wheresql = " 1=1 ";
		//$_GET['key'] = stripsearchkey($_GET['key']);
		//if($_GET['key']) {
		//	$wheresql .= " AND mtm.realname LIKE '%$_GET[key]%' ";
		//	$mpurl .= "&key=$_GET[key]";
		//}
		//if($_GET['uid']) {
		//	$wheresql = $wheresql." AND mtm.uid = '$_GET[uid]' ";
		//	$mpurl .= "&uid=$_GET[uid]";
		//}

		//检查开始数
		$page = empty($_GET['page'])?1:intval($_GET['page']);
		if($page<1) $page = 1;
		$start = ($page-1)*$perpage;
		ckstart($start, $perpage);

		$csql="SELECT count(*) FROM ".tname('advertisement')." a ";
		$csql .= " WHERE a.tagid='$tagid' AND $wheresql ";
		$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($csql), 0);
				
		if($count) {
			$querysql = "SELECT a.* ";
			$querysql = $querysql." FROM ".tname('advertisement')." a ";
			$querysql = $querysql." WHERE a.tagid='$tagid' AND $wheresql ORDER BY a.fromdate DESC LIMIT $start,$perpage";
			$query = $_SGLOBAL['db']->query($querysql);
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				$value = advertisementformmapper($value);
				$value = calculateadvertisementstatus($value);
				$advertisementlist[] = $value;
			}

			$multi = multi($count, $perpage, $page, $mpurl);
		}
		
		include_once template("cp_mtag_manage_advertisements");
		exit();
	}
	elseif($_GET['subop'] == 'advertisement') {

		include_once(S_ROOT.'./source/function_advertisement.php');
		include_once(S_ROOT.'./data/data_advertisementitemclass.php');
		include_once(S_ROOT.'./data/data_advertisementlocationclass.php');
		
		$advertisementid = $_GET['advertisementid'];
		$_GET['atomop'] = empty($_GET['atomop'])?'editheader':$_GET['atomop'];

		if($_GET['atomop'] == 'editheader') {
			$mtag = mtagformmapper($mtag);
			if( empty($advertisementid) ) {
				$advertisement = array();
			}
			else {
				$advertisement = queryadvertisementbyid( $advertisementid );
				if( $advertisement[uid] != $_SGLOBAL['supe_uid'] && $membergrade < 8 ){
					showmessage('no_privilege');
				}
			}
		}
		else if($_GET['atomop'] == 'saveheader') {
			$advertisement = null;
			if( empty($advertisementid) ) {
				$advertisement = array();
				$advertisement['close'] = 1;
				$advertisement['uid'] = $_SGLOBAL['supe_uid'];
				$advertisement['username'] = $_SGLOBAL['supe_username'];
				$advertisement['tagid'] = $tagid;
			}
			else{
				$advertisement=loadadvertisementbyid($advertisementid);
				if(empty($advertisement)){
					showmessage('adverisement_not_exist');
				}
				if( $advertisement[uid] != $_SGLOBAL['supe_uid'] && $membergrade < 8 ){
					showmessage('no_privilege');
				}
				$advertisement['close'] = $_POST['close'];
			}
 			
			$advertisement['location'] = $_POST['location'];
			$advertisement['subject'] = $_POST['subject'];
			$advertisement['description'] = $_POST['description'];
			$advertisement['fromdate'] = sstrtotime($_POST['fromdate']);
			$advertisement['todate'] = sstrtotime($_POST['todate']);
			$advertisement['lastpost'] = $_SGLOBAL['timestamp'];
			
			if(empty($advertisement['tagid'])){
				showmessage('mtag_id_empty');
			}else if(empty($advertisement['location'])){
				showmessage('advertisement_location_empty');
			}else if(empty($advertisement['subject'])){
				showmessage('advertisement_subject_empty');
			}else if(empty($advertisement['description'])){
				showmessage('advertisement_description_empty');
			}else if(empty($advertisement['fromdate'])){
				showmessage('advertisement_fromdate_empty');
			}else if(empty($advertisement['todate'])){
				showmessage('advertisement_todate_empty');
			}else if( ($advertisement['todate']) < ($advertisement['fromdate']) ){
				showmessage('advertisement_fromdatetodate');
			}

			if(empty($advertisementid)){
				$advertisementid = inserttable('advertisement', $advertisement, 1);
			}else{
				$advertisementid = $advertisement['advertisementid'];
				updatetable('advertisement', $advertisement, array('advertisementid'=>$advertisement['advertisementid']));
			}
			
			//TODO need to improve
			//consumerecredit($tagid, $uid, "购买站内宣传作品的展示位", $updatecredit);
			
			$_POST['nextstep'] = empty($_POST['nextstep'])?"return":$_POST['nextstep'];
			if( $_POST['nextstep']=="return" )
			{
				if( $_GET['return'] = 'cpmtagadvertisements') {
					showmessage('do_success', "cp.php?ac=mtag&op=manage&subop=advertisements&tagid=$tagid");
				}
				else{
					showmessage('do_success', "cp.php?ac=mtag&op=manage&subop=tasks&tagid=$tagid");
				}
			}
			else if( $_POST['nextstep']=="selectitemclass" )
			{
				if( $_GET['return'] = 'cpmtagadvertisement') {
					showmessage('do_success', "cp.php?ac=mtag&op=manage&subop=advertisement&atomop=selectitemclass&tagid=$tagid&advertisementid=$advertisementid&return=$_GET[return]");
				}
				else{
					showmessage('do_success', "cp.php?ac=mtag&op=manage&subop=advertisement&atomop=selectitemclass&tagid=$tagid&advertisementid=$advertisementid&return=$_GET[return]");
				}
			}
			else if( $_POST['nextstep']=="edititem" )
			{
				if( $_GET['return'] = 'cpmtagadvertisement') {
					showmessage('do_success', "cp.php?ac=mtag&op=manage&subop=advertisement&atomop=edititem&tagid=$tagid&advertisementid=$advertisementid&return=$_GET[return]");
				}
				else{
					showmessage('do_success', "cp.php?ac=mtag&op=manage&subop=advertisement&atomop=edititem&tagid=$tagid&advertisementid=$advertisementid&return=$_GET[return]");
				}
			}
		}
		elseif($_GET['atomop'] == 'selectitemclass') {
			$mtag = mtagformmapper($mtag);
			if( empty($advertisementid) ) {
				showmessage('advertisement_id_empty');
			}
			
			$advertisement = queryadvertisementbyid( $advertisementid );
			if( $advertisement[uid] != $_SGLOBAL['supe_uid'] && $membergrade < 8 ){
				showmessage('no_privilege');
			}
			
			$item=array();
			$item['tab_index'] = count($advertisement['itemlist'])+1;	
		}
		elseif($_GET['atomop'] == 'newitemwithclass') {
			$advertisement = queryadvertisementbyid( $advertisementid );
			if( $advertisement[uid] != $_SGLOBAL['supe_uid'] && $membergrade < 8 ){
				showmessage('no_privilege');
			}
			
			$item = array();
			if( count($advertisement['itemlist']) <= 0) {
				$item['tab_index'] = 1;	
				$item['tab_name'] = "首页页签";
				$item['tab_classid'] = $_POST['tab_classid'];
				$item['tab_classname'] = $_SGLOBAL['advertisementitemclass'][$item['tab_classid']]['classname'];
			}
			else{
				$item['tab_index'] = count($advertisement['itemlist'])+1;	
				$item['tab_name'] = "页签";
				$item['tab_classid'] = $_POST['tab_classid'];
				$item['tab_classname'] = $_SGLOBAL['advertisementitemclass'][$item['tab_classid']]['classname'];
			}
			
			if( empty($item['tab_classid']) ){
				showmessage('advertisement_item_tab_classid_empty');
			}
			
			$advertisement['itemlist'][] = $item;
			
		}
		elseif($_GET['atomop'] == 'edititem') {
			$itemid = empty($_GET['itemid'])?"":$_GET['itemid'];
			$mtag = mtagformmapper($mtag);
			if( empty($advertisementid) ) {
				showmessage('advertisement_id_empty');
			}
			
			$advertisement = queryadvertisementbyid( $advertisementid );
			if( $advertisement[uid] != $_SGLOBAL['supe_uid'] && $membergrade < 8 ){
				showmessage('no_privilege');
			}
			
			$item = null;
			foreach($advertisement['itemlist'] as $value){
				if($value['itemid'] == $itemid){
					$item = $value;
					break;
				}
			}
			
			if( empty($item) ){
				$item = $advertisement['itemlist'][0];
			}
		}
		elseif($_GET['atomop'] == 'saveitem') {
			$itemid = empty($_GET[itemid])?"":$_GET[itemid];
			
			$item = null;
			if( empty($itemid) ){
				$item = array();
				$item['advertisementid'] = $advertisementid;
				$item['tagid'] = $tagid;
				$item['tab_classid'] = $_POST['tab_classid'];
			}
			else{
				$item = loadadvertisementitembyid( $advertisementid, $itemid );
				
				if( empty($item) ){
					showmessage('advertisement_item_not_exist');
				}
			}
			
			$item['tab_name'] = $_POST['tab_name'];
			if( empty($item['tab_name']) ){
				showmessage('advertisement_item_tab_name_empty');
			}
			
			if( empty($item['tab_classid']) ){
				showmessage('advertisement_item_tab_classid_empty');
			}
			else{
				if( $item['tab_classid'] == 1 ){
					//首页海报
					$item['tab_index'] = 1;
					if(empty($item['pic'])){
						$item['pic'] = $_POST['pic'];
						if( empty($item['pic']) ){
							showmessage('advertisement_item_pic_empty');
						}
						
						$item['pic']=mtag_attachment_save($item['pic'], $tagid);
						
						if( empty($item['pic']) ){
							showmessage('advertisement_item_pic_empty');
						}
					}
					$item['link'] = $_POST['link'];
				}
				elseif( $item['tab_classid'] == 2 ){
					//首页视频
					$item['tab_index'] = 1;
					$item['video'] = $_POST['video'];
					if( empty($item['video']) ){
						showmessage('advertisement_item_video_empty');
					}
				}
				elseif( $item['tab_classid'] == 3 ){
					//次页广播剧链接及介绍
					$item['tab_index'] = 1;
					if(empty($itemid)){
						$tempadvertisement = queryadvertisementbyid($advertisementid);
						$item['tab_index'] = count($tempadvertisement['itemlist'])+1;
					}
					else{
						$item['tab_index'] = $_POST['tab_index'];
					}
					
					if( $item['tab_index'] <=1 ){
						showmessage('advertisement_item_tab_index_error');
					}
					
					$item['relatedtopicid'] = $_POST['relatedtopicid'];
					if( empty($item['relatedtopicid']) ){
						showmessage('advertisement_item_relatedtopicid_empty');
					}
					
					$item['message'] = $_POST['message'];
					if( empty($item['message']) ){
						showmessage('advertisement_item_message_empty');
					}
				}
				elseif( $item['tab_classid'] == 4 ){
					//次页视频
					$item['tab_index'] = 1;
					if(empty($itemid)){
						$tempadvertisement = queryadvertisementbyid($advertisementid);
						$item['tab_index'] = count($tempadvertisement['itemlist'])+1;
					}
					else{
						$item['tab_index'] = $_POST['tab_index'];
					}
					
					if( $item['tab_index'] <=1 ){
						showmessage('advertisement_item_tab_index_error');
					}
					
					$item['video'] = $_POST['video'];
				}
				elseif( $item['tab_classid'] == 5 ){
					//群组链接及介绍
					$item['tab_index'] = 1;
					if(empty($itemid)){
						$tempadvertisement = queryadvertisementbyid($advertisementid);
						$item['tab_index'] = count($tempadvertisement['itemlist'])+1;
					}
					else{
						$item['tab_index'] = $_POST['tab_index'];
					}
					
					if( $item['tab_index'] <=1 ){
						showmessage('advertisement_item_tab_index_error');
					}
					
					$item['relatedmtagid'] = $_POST['relatedmtagid'];
					if( empty($item['relatedmtagid']) ){
						showmessage('advertisement_item_relatedmtagid_empty');
					}
					
					$item['message'] = $_POST['message'];
					if( empty($item['message']) ){
						showmessage('advertisement_item_message_empty');
					}
				}
				elseif( $item['tab_classid'] == 6 ){
					//次页广播剧专辑链接及介绍
					$item['tab_index'] = 1;
					if(empty($itemid)){
						$tempadvertisement = queryadvertisementbyid($advertisementid);
						$item['tab_index'] = count($tempadvertisement['itemlist'])+1;
					}
					else{
						$item['tab_index'] = $_POST['tab_index'];
					}
					
					if( $item['tab_index'] <=1 ){
						showmessage('advertisement_item_tab_index_error');
					}
					
					$item['relatedtopicalbumid'] = $_POST['relatedtopicalbumid'];
					if( empty($item['relatedtopicalbumid']) ){
						showmessage('advertisement_item_pic_empty');
					}
					
					$item['message'] = $_POST['message'];
					if( empty($item['message']) ){
						showmessage('advertisement_item_message_empty');
					}
				}
				elseif( $item['tab_classid'] == 99 ){
					//自定义页面
					$item['tab_index'] = 1;
					if(empty($itemid)){
						$tempadvertisement = queryadvertisementbyid($advertisementid);
						$item['tab_index'] = count($tempadvertisement['itemlist'])+1;
					}
					else{
						$item['tab_index'] = $_POST['tab_index'];
					}
					
					if( $item['tab_index'] <=1 ){
						showmessage('advertisement_item_tab_index_error');
					}
					
					$item['message'] = $_POST['message'];
					if( empty($item['message']) ){
						showmessage('advertisement_item_message_empty');
					}
				}
			}
		
			if(empty($itemid)){
				$itemid = inserttable("advertisement_item", $item, 1);
			}
			else{
				updatetable('advertisement_item', $item, array('itemid'=>$itemid));
			}
			
			$_POST['nextstep'] = empty($_POST['nextstep'])?"return":$_POST['nextstep'];
			if( $_POST['nextstep']=="return" )
			{
				if( $_GET['return'] = 'cpmtagadvertisement') {
					showmessage('do_success', "cp.php?ac=mtag&op=manage&subop=advertisement&tagid=$tagid&advertisementid=$advertisementid");
				}
				else{
					showmessage('do_success', "cp.php?ac=mtag&op=manage&subop=tasks&tagid=$tagid&advertisementid=$advertisementid");
				}
			}
			else if( $_POST['nextstep']=="selectitemclass" )
			{
				if( $_GET['return'] = 'cpmtagadvertisement') {
					showmessage('do_success', "cp.php?ac=mtag&op=manage&subop=advertisement&atomop=selectitemclass&tagid=$tagid&advertisementid=$advertisementid&return=$_GET[return]");
				}
				else{
					showmessage('do_success', "cp.php?ac=mtag&op=manage&subop=advertisement&atomop=selectitemclass&tagid=$tagid&advertisementid=$advertisementid&return=$_GET[return]");
				}
			}
			else if( $_POST['nextstep']=="edititem" )
			{
				if( $_GET['return'] = 'cpmtagadvertisement') {
					showmessage('do_success', "cp.php?ac=mtag&op=manage&subop=advertisement&atomop=edititem&&tagid=$tagid&advertisementid=$advertisementid&itemid=$itemid");
				}
				else{
					showmessage('do_success', "cp.php?ac=mtag&op=manage&subop=advertisement&atomop=edititem&&tagid=$tagid&advertisementid=$advertisementid&itemid=$itemid");
				}
			}
		}
		elseif($_GET['atomop'] == 'delitempic') {
			$itemid = empty($_GET[itemid])?"":$_GET[itemid];
			        
			$item = loadadvertisementitembyid( $advertisementid, $itemid );
			if( empty($item) ){
				showmessage('advertisement_item_not_exist');
			}
			
			$item = advertisementitemformmapper($item);
			
			unlink($item['picpath']);
			$_SGLOBAL['db']->query( "UPDATE ".tname( "advertisement_item" )." SET pic = null where itemid=$item[itemid]" );
			
			$_POST['nextstep'] = empty($_POST['nextstep'])?"return":$_POST['nextstep'];
			if( $_POST['nextstep']=="return" )
			{
				if( $_GET['return'] = 'cpmtagadvertisementedititem') {
					showmessage('do_success', "cp.php?ac=mtag&op=manage&subop=advertisement&atomop=edititem&&tagid=$tagid&advertisementid=$advertisementid&itemid=$itemid");
				}
				else{
					showmessage('do_success', "cp.php?ac=mtag&op=manage&subop=advertisement&atomop=edititem&&tagid=$tagid&advertisementid=$advertisementid&itemid=$itemid");
				}
			}
		}
		elseif($_GET['atomop'] == 'preview') {
			$mtag = mtagformmapper($mtag);
			if( empty($advertisementid) ) {
				showmessage('advertisement_id_empty');
			}
			
			$advertisement = queryadvertisementbyid( $advertisementid );
			if( $advertisement[uid] != $_SGLOBAL['supe_uid'] && $membergrade < 8 ){
				showmessage('no_privilege');
			}
		}
		
		include_once template("cp_mtag_manage_advertisement");
		exit();
	}
	elseif($_GET['subop'] == 'memberclass') {

		if(empty($_POST['formhash'])) {
			//display
			$mtag = mtagformmapper($mtag);
			$memberclasslist=listmemberclassbymtagid($mtag['tagid']);
		}else{
			//save edit
			$classidarray=$_POST['classid'];
			$classnamearray=$_POST['classname'];
			$systemflagarray=$_POST['systemflag'];
			$displayorderarray=$_POST['displayorder'];

			updatememberclass($mtag['tagid'], $classidarray, $classnamearray, $systemflagarray, $displayorderarray);
			showmessage('do_success', "cp.php?ac=mtag&op=manage&tagid=$tagid&subop=members");
		}
		
		include_once template("cp_mtag_manage_memberclass");
		exit();
	}
	elseif($_GET['subop'] == 'members') {

		if(empty($_POST['formhash'])) {
			//display
			$mtag = mtagformmapper($mtag);
			//分页
			$perpage = 30;
			$start = empty($_GET['start'])?0:intval($_GET['start']);
			$memberlist = array();
			$count = 0;

			$mpurl = "cp.php?ac=mtag&op=manage&subop=members&tagid=$mtag[tagid]";
				
			//检索
			$wheresql = ' 1=1 ';
			$_GET['key'] = stripsearchkey($_GET['key']);
			if($_GET['key']) {
				$wheresql = $wheresql." AND mm.username LIKE '%$_GET[key]%' ";
				$mpurl .= "&key=$_GET[key]";
			}
			if($_GET['memberclassid']) {
				$wheresql = $wheresql." AND mm.memberclassid = '$_GET[memberclassid]' ";
				$mpurl .= "&memberclassid=$_GET[memberclassid]";
			}
			if($_GET['membergradeid']) {
				$wheresql = $wheresql." AND mm.membergradeid = '$_GET[membergradeid]' ";
				$mpurl .= "&membergradeid=$_GET[membergradeid]";
			}

			//检查开始数
			$page = empty($_GET['page'])?1:intval($_GET['page']);
			if($page<1) $page = 1;
			$start = ($page-1)*$perpage;
			ckstart($start, $perpage);

			$csql="SELECT count(*) FROM ".tname('mtagmember')." mm ";
			$csql .= " LEFT OUTER JOIN ".tname('mtag_memberclass')." mmc ON mm.memberclassid = mmc.classid AND mm.tagid=mmc.tagid ";
			$csql .= " LEFT OUTER JOIN ".tname('mtag_membergrade')." mmg ON mm.membergradeid = mmg.classid ";
			$csql .= " WHERE mm.tagid='$tagid' AND $wheresql ";
			$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($csql), 0);
				
			if($count) {
				$querysql = "SELECT mm.*, mmc.classname AS memberclassname, mmg.classname AS membergradename, s.ip AS uip ";
				$querysql .= " FROM ".tname('mtagmember')." mm ";
				$querysql .= " LEFT OUTER JOIN ".tname('mtag_memberclass')." mmc ON mm.memberclassid = mmc.classid AND mm.tagid=mmc.tagid ";
				$querysql .= " LEFT OUTER JOIN ".tname('mtag_membergrade')." mmg ON mm.membergradeid = mmg.classid ";
				$querysql .= " LEFT OUTER JOIN ".tname('session')." s ON mm.uid=s.uid AND s.magichidden != 1";
				$querysql .= " WHERE mm.tagid='$tagid' AND $wheresql ORDER BY mmc.displayorder, mm.membergradeid DESC LIMIT $start,$perpage";
				$query = $_SGLOBAL['db']->query($querysql);
				while ($value = $_SGLOBAL['db']->fetch_array($query)) {
					$memberlist[] = $value;
				}

				realname_get();

				$multi = multi($count, $perpage, $page, $mpurl);
			}
			$memberclasslist=listmemberclassbymtagid($mtag['tagid']);
			$membergradelist=listmembergrade();
		}else{
		}
		
		include_once template("cp_mtag_manage_members");
		exit();
	}
	elseif($_GET['subop'] == 'deletemember') {
		$memberid = $_POST['memberid'];
		if(empty($memberid)){
			showmessage('mtag_member_not_exist');
		}

		$member=loadmemberbyid($tagid, $memberid);
		if(empty($member)){
			showmessage('mtag_member_not_exist');
		}

		$_SGLOBAL['db']->query("DELETE FROM ".tname('mtagmember')." WHERE tagid='$tagid' and memberid='$memberid'");

		//更新群组统计
		$_SGLOBAL['db']->query("UPDATE ".tname("mtag")." SET membernum=(select count(*) from ".tname('mtagmember')." mm where mm.tagid=$tagid) where tagid='$tagid'");

		if(!empty($member['uid'])){
			notification_add($member['uid'],"mtag_manage","群组内部通知</br>您已被 <a href=\"space.php?do=mtag&tagid=$mtag[tagid]\">$mtag[tagname]</a> 群组除名 。",0);
		}

		showmessage('do_success', "cp.php?ac=mtag&op=manage&tagid=$tagid&subop=members");
	}
	elseif($_GET['subop'] == 'member') {
		$tagid = $_GET['tagid'];
		$memberid = $_GET['memberid'];

		if(empty($_POST['formhash'])) {
			$mtag = mtagformmapper($mtag);
			$member=querymemberbyid($tagid, $memberid);

			$memberclasslist=listmemberclassbymtagid($tagid);
			$membergradelist=listmembergrade();
		}else{
			$member=null;
			$notificationflag=false;
			if(empty($memberid)){
				$member=array();
				$member['dateline']=$_SGLOBAL['timestamp'];
				$notificationflag = true;
			}else{
				$member=loadmemberbyid($tagid, $memberid);
				if(empty($member)){
					showmessage('mtag_member_not_exist');
				}
				if($member['uid']!=$_POST['uid']){
					if($member[membergradeid] == 9 ){
						showmessage('mtag_member_iscreator_error');
					}
					
					$notificationflag = true;
				}
			}
			$member['tagid']=$tagid;
			$member['uid']=$_POST['uid'];
			$member['username']=$_POST['username'];
			$member['realname']=$_POST['realname'];
			$member['memberclassid']=$_POST['memberclassid'];
			$member['introduce']=$_POST['introduce'];
			$member['membergradeid']=$_POST['membergradeid'];

			if(!empty($member['uid'])){
				$user = queryuserbyid($member[uid]);
				if(!empty($user)){
					$member['uid']=$user['uid'];
					$member['username']=$user['username'];
					$member['realname']=empty($user['name'])?$user['username']:$user['name'];
				}else{
					$member['uid']="";
					$member['username']="";
					$notificationflag = false;
				}
			}

			if(empty($member['tagid'])){
				showmessage('mtag_id_empty');
			}else if(empty($member['realname'])){
				showmessage('mtag_member_realname_empty');
			}else if(empty($member['memberclassid'])){
				showmessage('mtag_member_classid_empty');
			}else if(empty($member['membergradeid'])){
				showmessage('mtag_member_gradeid_empty');
			}
				
			//showmessage("a".$member['introduce']."b");
			if( $member['introduce']=="<br>" && !empty($member['uid'])){
				$qsql="SELECT r.* FROM ".tname("resume")." r WHERE r.uid=$member[uid]";
				$query = $_SGLOBAL['db']->query($qsql);
				$value = $_SGLOBAL['db']->fetch_array($query);
				if( !empty($value) ){
					$member['introduce'] = $value['introduce'];
				}
			}

			$cvtag=loadrelatedcvtag($member['uid']);
			if(empty($cvtag)){
				$member['usertagid']=0;
			}else{
				$member['usertagid']=$cvtag['tagid'];
			}
				
			if(empty($memberid)){
				inserttable('mtagmember', $member);
			}else{
				updatetable('mtagmember', $member, array('memberid'=>$member['memberid']));
			}

			//更新群组统计
			$_SGLOBAL['db']->query("UPDATE ".tname("mtag")." SET membernum=(select count(*) from ".tname('mtagmember')." mm where mm.tagid=$tagid) where tagid='$tagid'");

			if($notificationflag){
				notification_add($member['uid'],"mtag_manage","群组内部通知</br>您已成为 <a href=\"space.php?do=mtag&tagid=$mtag[tagid]\">$mtag[tagname]</a> 群组的成员 。",0);
			}

			showmessage('do_success', "cp.php?ac=mtag&op=manage&subop=members&tagid=$tagid");
		}
		include_once template("cp_mtag_manage_member");
		exit();
	}
	elseif($_GET['subop'] == 'products') {
			
		include_once(S_ROOT.'./data/data_producttype.php');
		include_once(S_ROOT.'./data/data_productclass.php');
		include_once(S_ROOT.'./data/data_coverproductclass.php');
		include_once(S_ROOT.'./data/data_videoproductclass.php');
			
		if(empty($_POST['formhash'])) {
			//display
			$mtag = mtagformmapper($mtag);
			//分页
			$perpage = 30;
			$start = empty($_GET['start'])?0:intval($_GET['start']);
			$topiclist = array();
			$count = 0;
				
			$mpurl = "cp.php?ac=mtag&op=manage&tagid=$mtag[tagid]&subop=products";
				
			//检索
			$wheresql = ' 1=1 ';
			$_GET['key'] = stripsearchkey($_GET['key']);
			if($_GET['key']) {
				$wheresql .= " AND mp.productname LIKE '%$_GET[key]%' ";
				$mpurl .= "&key=$_GET[key]";
			}
			if(!empty($_GET['producttype'])) {
				$wheresql = $wheresql." AND mp.producttype = '$_GET[producttype]' ";
				$mpurl .= "&producttype=$_GET[producttype]";

				if(!empty($_GET['productclassid'])) {
					if($_GET['producttype'] == 1 ){
						$wheresql = $wheresql." AND t.productclassid = '$_GET[productclassid]' ";
					}
					elseif($_GET['producttype'] == 2 ){
						$wheresql = $wheresql." AND c.productclassid = '$_GET[productclassid]' ";
					}
					elseif($_GET['producttype'] == 3 ){
						$wheresql = $wheresql." AND v.productclassid = '$_GET[productclassid]' ";
					}
					$mpurl .= "&productclassid=$_GET[productclassid]";
				}
			}

			//检查开始数
			$page = empty($_GET['page'])?1:intval($_GET['page']);
			if($page<1) $page = 1;
			$start = ($page-1)*$perpage;
			ckstart($start, $perpage);

			$csql="SELECT count(*) FROM ".tname('mtagproduct')." mp ";
			$csql .= " LEFT OUTER JOIN ".tname('topic')." t ON mp.productid = t.topicid AND mp.producttype = 1 ";
			$csql .= " LEFT OUTER JOIN ".tname('cover')." c ON mp.productid = c.coverid AND mp.producttype = 2 ";
			$csql .= " LEFT OUTER JOIN ".tname('video')." v ON mp.productid = v.videoid AND mp.producttype = 3 ";
			$csql .= " WHERE mp.tagid='$tagid' AND $wheresql";
			$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($csql), 0);
				
			if($count) {
				$querysql = "SELECT mp.*, t.productclassid AS topicproductclassid, c.productclassid AS coverproductclassid, v.productclassid AS videoproductclassid, ";
				$querysql .= " t.producedate AS topicproducedate, c.producedate AS coverproducedate, v.producedate AS videoproducedate ";
				$querysql .= " FROM ".tname('mtagproduct')." mp ";
				$querysql .= " LEFT OUTER JOIN ".tname('topic')." t ON mp.productid = t.topicid AND mp.producttype = 1 ";
				$querysql .= " LEFT OUTER JOIN ".tname('cover')." c ON mp.productid = c.coverid AND mp.producttype = 2 ";
				$querysql .= " LEFT OUTER JOIN ".tname('video')." v ON mp.productid = v.videoid AND mp.producttype = 3 ";
				$querysql .= " WHERE mp.tagid='$tagid' AND $wheresql ORDER BY mp.productname LIMIT $start,$perpage";
				$query = $_SGLOBAL['db']->query($querysql);
				while ($value = $_SGLOBAL['db']->fetch_array($query)) {
					$value['producttypename'] = $_SGLOBAL['producttype'][$value['producttype']]['classname'];
					if( $value['producttype'] == 1 ){
						$value['productclassname'] = $_SGLOBAL['productclass'][$value['topicproductclassid']]['classname'];
						$value['dispproducedate'] = $value['topicproducedate']?sgmdate('Y-m-d',$value['topicproducedate']):'';
						$value['producturl'] = "space.php?do=topic&topicid=$value[productid]";
						$value['newurl'] = "cp.php?ac=topic&op=new";
					}
					elseif( $value['producttype'] == 2 ){
						$value['productclassname'] = $_SGLOBAL['coverproductclass'][$value['coverproductclassid']]['classname'];
						$value['dispproducedate'] = $value['coverproducedate']?sgmdate('Y-m-d',$value['coverproducedate']):'';
						$value['producturl'] = "space.php?do=cover&coverid=$value[productid]";
						$value['newurl'] = "cp.php?ac=cover&op=new";
					}
					elseif( $value['producttype'] == 3 ){
						$value['productclassname'] = $_SGLOBAL['videoproductclass'][$value['videoproductclassid']]['classname'];
						$value['dispproducedate'] = $value['videoproducedate']?sgmdate('Y-m-d',$value['videoproducedate']):'';
						$value['producturl'] = "space.php?do=video&videoid=$value[productid]";
						$value['newurl'] = "cp.php?ac=video&op=new";
					}
						
					$productlist[] = $value;
				}

				realname_get();

				$multi = multi($count, $perpage, $page, $mpurl);
			}
		}else{
		}
		
		include_once template("cp_mtag_manage_products");
		exit();
	}
	elseif($_GET['subop'] == 'deleteproduct') {

		$itemid = $_POST['itemid'];
		if(empty($itemid)){
			showmessage('mtag_product_not_exist');
		}
		$item=loadmtagproductitembyid($tagid, $itemid);
		if(empty($item)){
			showmessage('mtag_product_not_exist');
		}

		$_SGLOBAL['db']->query("DELETE FROM ".tname('mtagproduct')." WHERE tagid='$tagid' and itemid='$itemid'");

		//更新群组统计
		$_SGLOBAL['db']->query("UPDATE ".tname("mtag")." SET productnum=(select count(*) from ".tname('mtagproduct')." mp where mp.tagid=$tagid) where tagid='$tagid'");

		showmessage('do_success', "cp.php?ac=mtag&op=manage&subop=products&tagid=$tagid");
	}
	elseif($_GET['subop'] == 'product') {

		include_once(S_ROOT.'./data/data_producttype.php');

		$tagid = $_GET['tagid'];
		$itemid = $_GET['itemid'];

		if(empty($_POST['formhash'])) {
			$mtag = mtagformmapper($mtag);
			if( empty($itemid) ) {
				$item = array();
			}
			else {
				$item = querymtagproductitembyid($tagid, $itemid);
			}
			$fansgradelist=listmembergrade();
		}else{
			$item = null;
			if(empty($itemid)){
				$item=array();
				$item['dateline']=$_SGLOBAL['timestamp'];
			}else{
				$item=loadmtagproductitembyid($tagid, $itemid);
				if(empty($item)){
					showmessage('mtag_product_not_exist');
				}
			}
			$item['tagid']=$tagid;
			$item['producttype']=$_POST['producttype'];
			$item['productid']=$_POST['productid'];
			$item['productname']=$_POST['productname'];
			$item['introduce']=$_POST['introduce'];

			if(empty($item['tagid'])){
				showmessage('mtag_id_empty');
			}else if(empty($item['producttype'])){
				showmessage('mtag_product_type_empty');
			}else if(empty($item['productname'])){
				showmessage('mtag_product_name_empty');
			}

			if(empty($itemid)){
				inserttable('mtagproduct', $item);
			}else{
				updatetable('mtagproduct', $item, array('itemid'=>$item['itemid']));
			}

			//更新群组统计
			$_SGLOBAL['db']->query("UPDATE ".tname("mtag")." SET productnum=(select count(*) from ".tname('mtagproduct')." mp where mp.tagid=$tagid) where tagid='$tagid'");

			showmessage('do_success', "cp.php?ac=mtag&op=manage&subop=products&tagid=$tagid");
		}
		
		include_once template("cp_mtag_manage_product");
		exit();
	}
	elseif($_GET['subop'] == 'taskclass') {

		if(empty($_POST['formhash'])) {
			//display
			$mtag = mtagformmapper($mtag);
			$taskclasslist = listtaskclass( $tagid );
		}else{
			//save edit
			$classidarray = $_POST['classid'];
			$classnamearray = $_POST['classname'];
			$displayorderarray = $_POST['displayorder'];

			updatetaskclass($mtag['tagid'], $classidarray, $classnamearray, $displayorderarray);
			showmessage('do_success', "cp.php?ac=mtag&op=manage&subop=tasks&tagid=$tagid");
		}
		
		include_once template("cp_mtag_manage_taskclass");
		exit();
	}
	elseif($_GET['subop'] == 'tasks') {

		include_once(S_ROOT.'./data/data_mtagtaskimptclass.php');

		if(empty($_POST['formhash'])) {
			//display
			$mtag = mtagformmapper($mtag);
			//分页
			$perpage = 30;
			$start = empty($_GET['start'])?0:intval($_GET['start']);
			$tasklist = array();
			$count = 0;

			$mpurl = "cp.php?ac=mtag&op=manage&tagid=$mtag[tagid]&subop=tasks";
				
			//检索
			$wheresql = " 1=1 ";
			$_GET['key'] = stripsearchkey($_GET['key']);
			if($_GET['key']) {
				$wheresql .= " AND mtm.realname LIKE '%$_GET[key]%' ";
				$mpurl .= "&key=$_GET[key]";
			}
			if($_GET['uid']) {
				$wheresql = $wheresql." AND mtm.uid = '$_GET[uid]' ";
				$mpurl .= "&uid=$_GET[uid]";
			}

			//检查开始数
			$page = empty($_GET['page'])?1:intval($_GET['page']);
			if($page<1) $page = 1;
			$start = ($page-1)*$perpage;
			ckstart($start, $perpage);

			$csql="SELECT count(*) FROM ".tname('mtagtask')." mt ";
			$csql .= " LEFT OUTER JOIN ".tname('mtag_taskclass')." mtc ON mt.classid = mtc.classid ";
			$csql .= " WHERE mt.tagid='$tagid' AND $wheresql ";
			$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($csql), 0);
				
			if($count) {
				$querysql = "SELECT mt.*, mtc.classname taskclassname ";
				$querysql = $querysql." FROM ".tname('mtagtask')." mt ";
				$querysql = $querysql." LEFT OUTER JOIN ".tname('mtag_taskclass')." mtc ON mt.classid = mtc.classid ";
				$querysql = $querysql." WHERE mt.tagid='$tagid' AND $wheresql ORDER BY mt.dateline DESC LIMIT $start,$perpage";
				$query = $_SGLOBAL['db']->query($querysql);
				while ($value = $_SGLOBAL['db']->fetch_array($query)) {
					$value = taskformmapper($value);
					$tasklist[] = $value;
				}

				realname_get();

				$multi = multi($count, $perpage, $page, $mpurl);
			}

			$taskclasslist=listtaskclass($tagid);
		}
		
		include_once template("cp_mtag_manage_tasks");
		exit();
	}
	elseif($_GET['subop'] == 'closetask') {

		$taskid = $_GET['taskid'];
		if(empty($taskid)){
			showmessage('mtag_task_not_exist');
		}
		$task=querytaskbyid($tagid, $taskid);
		if(empty($task)){
			showmessage('mtag_task_not_exist');
		}
		
		if( $task[uid] != $_SGLOBAL['supe_uid'] && $membergrade < 8 ){
			showmessage('no_privilege');
		}

		$_SGLOBAL['db']->query("UPDATE ".tname('mtagtask')." SET CLOSE=1 WHERE tagid='$tagid' and taskid='$taskid'");
		
		if( $_GET['return'] = 'spacemtagtask') {
			showmessage('do_success', "space.php?do=mtag&view=tasks&tagid=$tagid");
		}
		else if( $_GET['return'] = 'cpmtagtask') {
			showmessage('do_success', "cp.php?ac=mtag&op=manage&subop=tasks&tagid=$tagid");
		}
		else{
			showmessage('do_success', "cp.php?ac=mtag&op=manage&subop=tasks&tagid=$tagid");
		}
	}
	elseif($_GET['subop'] == 'unclosetask') {

		$taskid = $_GET['taskid'];
		if(empty($taskid)){
			showmessage('mtag_task_not_exist');
		}
		$task=querytaskbyid($tagid, $taskid);
		if(empty($task)){
			showmessage('mtag_task_not_exist');
		}
		
		if( $task[uid] != $_SGLOBAL['supe_uid'] && $membergrade < 8 ){
			showmessage('no_privilege');
		}

		$_SGLOBAL['db']->query("UPDATE ".tname('mtagtask')." SET CLOSE=0 WHERE tagid='$tagid' and taskid='$taskid'");
		
		if( $_GET['return'] = 'spacemtagtask') {
			showmessage('do_success', "space.php?do=mtag&view=tasks&tagid=$tagid");
		}
		else if( $_GET['return'] = 'cpmtagtask') {
			showmessage('do_success', "cp.php?ac=mtag&op=manage&subop=tasks&tagid=$tagid");
		}
		else{
			showmessage('do_success', "cp.php?ac=mtag&op=manage&subop=tasks&tagid=$tagid");
		}
	}
	elseif($_GET['subop'] == 'deletetask') {

		$taskid = $_GET['taskid'];
		if(empty($taskid)){
			showmessage('mtag_task_not_exist');
		}
		$task=querytaskbyid($tagid, $taskid);
		if(empty($task)){
			showmessage('mtag_task_not_exist');
		}
		
		if( $task[uid] != $_SGLOBAL['supe_uid'] && $membergrade < 8 ){
			showmessage('no_privilege');
		}

		$_SGLOBAL['db']->query("DELETE FROM ".tname('mtagtask')." WHERE tagid='$tagid' and taskid='$taskid'");
		$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE idtype='mtagtaskid' and id=$task[taskid]");
		
		//更新群组统计
	//	$_SGLOBAL['db']->query("UPDATE ".tname("mtag")." SET productnum=(select count(*) from ".tname('mtagproduct')." mp where mp.tagid=$tagid) where tagid='$tagid'");
		
		if( $_GET['return'] = 'spacemtagtask') {
			showmessage('do_success', "space.php?do=mtag&view=tasks&tagid=$tagid");
		}
		else if( $_GET['return'] = 'cpmtagtask') {
			showmessage('do_success', "cp.php?ac=mtag&op=manage&subop=tasks&tagid=$tagid");
		}
		else{
			showmessage('do_success', "cp.php?ac=mtag&op=manage&subop=tasks&tagid=$tagid");
		}
	}
	elseif($_GET['subop'] == 'task') {

		include_once(S_ROOT.'./data/data_mtagtaskimptclass.php');

		$taskid = $_GET['taskid'];
		$_GET['atomop'] = empty($_GET['atomop'])?'taskinfo':$_GET['atomop'];

		if($_GET['atomop'] == 'taskinfo') {
			if(empty($_POST['formhash'])) {
				$mtag = mtagformmapper($mtag);
				if( empty($taskid) ) {
					$task = array();
				}
				else {
					$task = querytaskbyid( $tagid, $taskid );
					if( $task[uid] != $_SGLOBAL['supe_uid'] && $membergrade < 8 ){
						showmessage('no_privilege');
					}
				}
				$taskclasslist=listtaskclass( $tagid );
			}
			else{
				$task = null;
				if(empty($taskid)){
					$task=array();
					$task['dateline']=$_SGLOBAL['timestamp'];
				}else{
					$task=loadtaskbyid($tagid, $taskid);
					if(empty($task)){
						showmessage('mtag_task_not_exist');
					}
					if( $task[uid] != $_SGLOBAL['supe_uid'] && $membergrade < 8 ){
						showmessage('no_privilege');
					}
				}
				$task['tagid'] = $tagid;
				$task['uid'] = $_SGLOBAL['supe_uid'];
				$task['username'] = $_SGLOBAL['supe_username'];
				$task['subject'] = $_POST['subject'];
				$task['description'] = $_POST['description'];
				$task['classid'] = $_POST['classid'];
				$task['starttime'] = sstrtotime($_POST['starttime']);
				$task['endtime'] = sstrtotime($_POST['endtime']);
				$task['importance'] = $_POST['importance'];
				$task['lastpost']=$_SGLOBAL['timestamp'];

				if(empty($task['tagid'])){
					showmessage('mtag_id_empty');
				}else if(empty($task['subject'])){
					showmessage('mtag_task_subject_empty');
				}else if(empty($task['classid'])){
					showmessage('mtag_task_classid_empty');
				}else if(empty($task['importance'])){
					showmessage('mtag_task_importance_empty');
				}else if(empty($task['starttime'])){
					showmessage('mtag_task_starttime_empty');
				}else if(empty($task['endtime'])){
					showmessage('mtag_task_endtime_empty');
				}else if($task['starttime']>=$task['endtime']){
					showmessage('mtag_task_starttime_should_before_endtime');
				}else if(empty($_POST['nextstep'])){
					showmessage('mtag_task_nextstep_empty');
				}

				if(empty($taskid)){
					$taskid = inserttable('mtagtask', $task, 1);
				}else{
					$taskid = $task['taskid'];
					updatetable('mtagtask', $task, array('taskid'=>$task['taskid']));
				}

				if( $_POST['nextstep']=="return" )
				{
					if( $_GET['return'] = 'spacemtagtask') {
						showmessage('do_success', "space.php?do=mtag&view=tasks&tagid=$tagid");
					}
					else if( $_GET['return'] = 'cpmtagtask') {
						showmessage('do_success', "cp.php?ac=mtag&op=manage&subop=tasks&tagid=$tagid");
					}
					else{
						showmessage('do_success', "cp.php?ac=mtag&op=manage&subop=tasks&tagid=$tagid");
					}
				}
				else if( $_POST['nextstep']=="taskmember" )
				{
					showmessage('do_success', "cp.php?ac=mtag&op=manage&subop=task&atomop=taskmember&tagid=$tagid&taskid=$taskid&return=$_GET[return]");
				}
				else{
					if( $_GET['return'] = 'spacemtagtask') {
						showmessage('do_success', "space.php?do=mtag&view=tasks&tagid=$tagid");
					}
					else if( $_GET['return'] = 'cpmtagtask') {
						showmessage('do_success', "cp.php?ac=mtag&op=manage&subop=tasks&tagid=$tagid");
					}
					else{
						showmessage('do_success', "cp.php?ac=mtag&op=manage&subop=tasks&tagid=$tagid");
					}
				}
			}
		}
		elseif($_GET['atomop'] == 'taskmember') {
			$task = loadtaskbyid( $tagid, $taskid );
			$memberidarr = explode(',', $task['members']);
			$memberidarr_flip = array();
			foreach($memberidarr as $memberid) {
				$memberidarr_flip[$memberid]=1;
			}

			if(empty($_POST['formhash'])) {
				$mtag = mtagformmapper($mtag);
				if( empty($taskid) ) {
					$task = array();
				}
				else {
					$task = querytaskbyid( $tagid, $taskid );
				}
				$members=array();
					
				$memberclasslist=listmemberclassbymtagid($mtag['tagid']);
				foreach($memberclasslist as $memberclass) {
					$memberlist = querymemberbyclass($mtag['tagid'], $memberclass['classid']);
					$newmemberlist = array();
					foreach($memberlist as $member) {
						if( $memberidarr_flip[$member['memberid']] > 0 ) {
							$member['checked'] = 1;
						} else {
							$member['checked'] = 0;
						}
						$newmemberlist[] = $member;
					}
					$members[$memberclass['classid']]=$newmemberlist;
				}
			}
			else{
				$memberids = empty($_POST['memberids'])?array():$_POST['memberids'];

				$_SGLOBAL['db']->query("UPDATE ".tname('mtagtask')." SET members=',".implode(',', $memberids).",' , membernum = '".count($memberids)."' WHERE taskid='$taskid'");

				//通知
				$note = "群组内部通知</br>";
				$note .= "你在<a href=\"space.php?do=mtag&tagid=$tagid\" target=\"_blank\">".$mtag[tagname]."群组</a>";
				$note .= "有新的<a href=\"space.php?do=mtag&view=task&tagid=$tagid&taskid=$taskid\" target=\"_blank\">成员任务</a>啦，请及时回复。<br/>";
				$note .= $task[subject];
				$memberuidarray = array();
				foreach($memberids as $memberid) {
					if( $memberidarr_flip[$memberid] > 0 ) {

					}
					else {
						$member = loadmemberbyid($tagid, $memberid);
						if( !empty($member) && !($memberuidarray[$member['uid']]>0) ){
							notification_add($member['uid'], 'mtag_task', $note);
							$memberuidarray[$member['uid']]=1;
						}
					}
				}

				if( $_POST['nextstep']=="return" ){
					if( $_GET['return'] = 'spacemtagtask') {
						showmessage('do_success', "space.php?do=mtag&view=tasks&tagid=$tagid");
					}
					else if( $_GET['return'] = 'cpmtagtask') {
						showmessage('do_success', "cp.php?ac=mtag&op=manage&subop=tasks&tagid=$tagid");
					}
					else{
						showmessage('do_success', "cp.php?ac=mtag&op=manage&subop=tasks&tagid=$tagid");
					}
				}
				else {
					if( $_GET['return'] = 'spacemtagtask') {
						showmessage('do_success', "space.php?do=mtag&view=tasks&tagid=$tagid");
					}
					else if( $_GET['return'] = 'cpmtagtask') {
						showmessage('do_success', "cp.php?ac=mtag&op=manage&subop=tasks&tagid=$tagid");
					}
					else{
						showmessage('do_success', "cp.php?ac=mtag&op=manage&subop=tasks&tagid=$tagid");
					}
				}
			}
		}
		
		include_once template("cp_mtag_manage_task");
		exit();
	}
	elseif($_GET['subop'] == 'fans') {

		if(empty($_POST['formhash'])) {
			//display
			$mtag = mtagformmapper($mtag);
			//分页
			$perpage = 30;
			$start = empty($_GET['start'])?0:intval($_GET['start']);
			$fanslist = array();
			$count = 0;

			$mpurl = "cp.php?ac=mtag&op=manage&tagid=$mtag[tagid]&subop=fans";
				
			//检索
			$wheresql = ' mf.deleteflag=0 ';
			$_GET['key'] = stripsearchkey($_GET['key']);
			if($_GET['key']) {
				$wheresql .= " AND mf.username LIKE '%$_GET[key]%' ";
				$mpurl .= "&key=$_GET[key]";
			}
			if($_GET['fansgradeid']) {
				$wheresql .= " AND mf.fansgradeid = '$_GET[fansgradeid]' ";
				$mpurl .= "&fansgradeid=$_GET[fansgradeid]";
			}

			//检查开始数
			$page = empty($_GET['page'])?1:intval($_GET['page']);
			if($page<1) $page = 1;
			$start = ($page-1)*$perpage;
			ckstart($start, $perpage);

			$csql = "SELECT mf.*, mfg.classname fansgradename ";
			$csql .= " FROM ".tname('mtagfans')." mf ";
			$csql .= " LEFT OUTER JOIN ".tname('mtag_fansgrade')." mfg ON mf.fansgradeid = mfg.classid ";
			$csql .= " WHERE mf.tagid='$tagid' AND $wheresql";
			$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($csql), 0);
				
			if($count) {
				$querysql = "SELECT mf.*, mfg.classname fansgradename ";
				$querysql = $querysql." FROM ".tname('mtagfans')." mf ";
				$querysql = $querysql." LEFT OUTER JOIN ".tname('mtag_fansgrade')." mfg ON mf.fansgradeid = mfg.classid ";
				$querysql = $querysql." WHERE mf.tagid='$tagid' AND $wheresql LIMIT $start,$perpage";
				$query = $_SGLOBAL['db']->query($querysql);
				while ($value = $_SGLOBAL['db']->fetch_array($query)) {
					$fanslist[] = $value;
					$count++;
				}

				realname_get();

				$multi = multi($count, $perpage, $page, $mpurl);
			}
				
			$fansgradelist=listfansgrade();
		}else{
			$uid=$_POST['uid'];
			if(empty($uid)){
				showmessage('user_does_not_exist');
			}else{
				$fans=loadfansbyuserid($tagid, $uid);
				if(empty($fans)){
					showmessage('user_does_not_exist');
				}
			}

			$fans['fansgradeid']=$_POST['fansgradeid'];
			if(empty($fans['fansgradeid'])){
				showmessage('mtag_fans_gradeid_empty');
			}

			updatetable('mtagfans', $fans, array('tagid'=>$fans['tagid'],'uid'=>$fans['uid']));

			$start = empty($_GET['start'])?0:intval($_GET['start']);
			showmessage('do_success', "cp.php?ac=mtag&op=manage&tagid=$mtag[tagid]&subop=fans&key=$_GET[key]");
		}
		
		include_once template("cp_mtag_manage_fans");
		exit();
	}
	elseif($_GET['subop'] == 'threadclass') {

		if(empty($_POST['formhash'])) {
			//display
			$mtag = mtagformmapper($mtag);
			$threadclasslist=listthreadclassbymtagid($mtag['tagid']);
		}else{
			//save edit
			$classidarray=$_POST['classid'];
			$classnamearray=$_POST['classname'];
			$displayorderarray=$_POST['displayorder'];

			updatethreadclass($mtag['tagid'], $classidarray, $classnamearray, $displayorderarray);
			showmessage('do_success', "cp.php?ac=mtag&op=manage&tagid=$tagid&subop=threads");
		}
		
		include_once template("cp_mtag_manage_threadclass");
		exit();
	}
	elseif($_GET['subop'] == 'threads') {
		$tagid = $_GET['tagid'];

		if(empty($_POST['formhash'])) {
			//display
			$mtag = mtagformmapper($mtag);
			//分页
			$perpage = 30;
			$start = empty($_GET['start'])?0:intval($_GET['start']);
			$threadlist = array();
			$count = 0;

			$mpurl = "cp.php?ac=mtag&op=manage&subop=threads&tagid=$mtag[tagid]";
				
			//检索
			$wheresql = ' 1=1 ';
			$_GET['key'] = stripsearchkey($_GET['key']);
			if($_GET['key']) {
				$wheresql .= " AND mt.subject LIKE '%$_GET[key]%' ";
				$mpurl .= "&key=$_GET[key]";
			}
			if(!empty($_GET['tid'])) {
				$wheresql = $wheresql." AND mt.threadclassid = '$_GET[tid]' ";
				$mpurl .= "&tid=$_GET[tid]";
			}
			if(!empty($_GET['subject'])) {
				$wheresql = $wheresql." AND mt.subject like '%$_GET[subject]%' ";
				$mpurl .= "&subject=$_GET[subject]";
			}
			if(!empty($_GET['uid'])) {
				$wheresql = $wheresql." AND mt.uid = '$_GET[uid]' ";
				$mpurl .= "&uid=$_GET[uid]";
			}
			if($_GET['digest']>0) {
				$wheresql = $wheresql." AND mt.digest = '$_GET[digest]' ";
				$mpurl .= "&digest=$_GET[digestd]";
			}
			if($_GET['displayorder']>0) {
				$wheresql = $wheresql." AND mt.displayorder = '$_GET[displayorder]' ";
				$mpurl .= "&displayorder=$_GET[displayorder]";
			}
			if($_GET['close']>0) {
				$wheresql = $wheresql." AND mt.close = '$_GET[close]' ";
				$mpurl .= "&close=$_GET[close]";
			}

			//检查开始数
			$page = empty($_GET['page'])?1:intval($_GET['page']);
			if($page<1) $page = 1;
			$start = ($page-1)*$perpage;
			ckstart($start, $perpage);

			$csql = "SELECT mt.*, mtc.classname threadclassname ";
			$csql .= " FROM ".tname('mtag_thread')." mt ";
			$csql .= " LEFT OUTER JOIN ".tname('mtag_threadclass')." mtc ON mt.threadclassid = mtc.classid ";
			$csql .= " WHERE mt.tagid='$tagid' AND $wheresql";
			$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($csql), 0);
				
			if($count) {
				$querysql = "SELECT mt.*, mtc.classname threadclassname ";
				$querysql = $querysql." FROM ".tname('mtag_thread')." mt ";
				$querysql = $querysql." LEFT OUTER JOIN ".tname('mtag_threadclass')." mtc ON mt.threadclassid = mtc.classid ";
				$querysql = $querysql." WHERE mt.tagid='$tagid' AND $wheresql ORDER BY mt.lastpost DESC LIMIT $start,$perpage";
				$query = $_SGLOBAL['db']->query($querysql);
				while ($value = $_SGLOBAL['db']->fetch_array($query)) {
					$value = threadformmapper($value);
					$threadlist[] = $value;
					$count++;
				}

				realname_get();

				$multi = multi($count, $perpage, $page, $mpurl);
			}
			$threadclasslist=listthreadclassbymtagid($tagid);
		}
		else{
			$_POST['mpurl'] = "cp.php?ac=mtag&op=manage&tagid=$mtag[tagid]&subop=threads&key=$_GET[key]";
			if($_POST['optype'] == 'delete') {
				include_once(S_ROOT.'./source/function_delete.php');
				if(!empty($_POST['ids'])) {

					deletethreads($tagid, $_POST['ids']);

					//更新群组统计
					$_SGLOBAL['db']->query("UPDATE ".tname("mtag")." SET threadnum=(select count(*) from ".tname('mtag_thread')." mt where mt.tagid=$tagid) where tagid='$tagid'");
					showmessage('do_success', "cp.php?ac=mtag&op=manage&tagid=$mtag[tagid]&subop=threads&key=$_GET[key]");
				} else {
					showmessage('do_success', "cp.php?ac=mtag&op=manage&tagid=$mtag[tagid]&subop=threads&key=$_GET[key]");
				}
			}
			elseif($_POST['optype'] == 'digest') {
				include_once(S_ROOT.'./source/function_thread.php');
				if(!empty($_POST['ids']) && digestthreads($tagid, $_POST['ids'], $_POST['digestv'])) {
					showmessage('do_success', $_POST['mpurl']);
				} else {
					showmessage('choosing_to_operate_the_thread', $_POST['mpurl']);
				}
			} 
			elseif($_POST['optype'] == 'top') {
				include_once(S_ROOT.'./source/function_thread.php');
				if(!empty($_POST['ids']) && topthreads($tagid, $_POST['ids'], $_POST['topv'])) {
					showmessage('do_success', $_POST['mpurl']);
				} else {
					showmessage('choosing_to_operate_the_thread', $_POST['mpurl']);
				}
			} 
			elseif($_POST['optype'] == 'close') {
				include_once(S_ROOT.'./source/function_thread.php');
				if(!empty($_POST['ids']) && closethreads($tagid, $_POST['ids'], $_POST['topv'])) {
					showmessage('do_success', $_POST['mpurl']);
				} else {
					showmessage('choosing_to_operate_the_thread', $_POST['mpurl']);
				}
			} else {
				showmessage('choice_batch_action');
			}
				
			showmessage('do_success', $_POST['mpurl']);
		}
		
		include_once template("cp_mtag_manage_threads");
		exit();
	}
	
	//TODO need to delete
	include_once template("cp_mtag");
}
elseif($_GET['op'] == 'deletemember'){
	$tagid = $_GET['tagid'];
	$mtag = loadmtagbyid($tagid);
	if(empty($mtag)){
		showmessage('mtag_not_exist');
	}elseif($mtag['tagstate']==0 || $mtag['tagstate']==1){
		showmessage('mtag_state_not_auditpass');
	}
	
	$memberid = $_GET['memberid'];
	if(empty($memberid)){
		showmessage('mtag_member_not_exist');
	}
	$member=loadmemberbyid($tagid, $memberid);
	if(empty($member)){
		showmessage('mtag_member_not_exist');
	}
	
	if($member['uid']!=$_SGLOBAL[supe_uid]){
		showmessage('no_privilege');
	}
	
	$membergrade=checkmembergrade($mtag[tagid], $_SGLOBAL[supe_uid]);
	if($membergrade>=8){
		showmessage('mtag_member_quit_grade_error');
	}

	$_SGLOBAL['db']->query("DELETE FROM ".tname('mtagmember')." WHERE tagid='$tagid' and memberid='$memberid'");

	//更新群组统计
	$_SGLOBAL['db']->query("UPDATE ".tname("mtag")." SET membernum=(select count(*) from ".tname('mtagmember')." mm where mm.tagid=$tagid) where tagid='$tagid'");

	notification_add($mtag['creatorid'],"mtag_manage","群组内部通知</br>群组成员&nbsp;<a href=\"space.php?uid=$member[uid]\">".$member[username]."[".$member[username]."]</a>已退出 <a href=\"space.php?do=mtag&tagid=$mtag[tagid]\">$mtag[tagname]</a> 群组。",0);
	
	showmessage('do_success', "space.php?do=mtag&tagid=$tagid&view=members");
}
elseif($_GET['op'] == 'editmemberintroduce') {
	$tagid = empty($_GET['tagid'])?0:intval($_GET['tagid']);
	$mtag = loadmtagbyid($tagid);
	if(empty($mtag)){
		showmessage('mtag_not_exist');
	}elseif($mtag['tagstate']==0 || $mtag['tagstate']==1){
		showmessage('mtag_state_not_auditpass');
	}

	$memberid = $_GET['memberid'];
	$member=loadmemberbyid($tagid, $memberid);
	if(empty($member)){
		showmessage('mtag_member_not_exist');
	}

	if($member['uid']!=$_SGLOBAL[supe_uid]){
		showmessage('no_privilege');
	}

	if(submitcheck('formhash')) {
		$introduce = $_POST['introduce'];

		$_SGLOBAL['db']->query("UPDATE ".tname('mtagmember')." SET introduce = '$introduce' WHERE memberid = $memberid");
		showmessage('do_success', "space.php?do=mtag&view=members&tagid=$tagid", 0);
	}
	else {
		$mtag = mtagformmapper( $mtag );
		$member = querymemberbyid($tagid, $memberid);
	}

	include_once template("cp_mtag");
}
elseif($op == 'taskcalendar') {//任务列表日历

	$tagid = empty($_GET['tagid'])?0:intval($_GET['tagid']);
	$mtag = loadmtagbyid($tagid);
	if(empty($mtag)){
		showmessage('mtag_not_exist');
	}elseif($mtag['tagstate']==0 || $mtag['tagstate']==1){
		showmessage('mtag_state_not_auditpass');
	}

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
		$days[$i] = array("count"=>0, "tasks"=>array(), "class"=>'');
	}

	$wheresql="";
	if(!empty($_GET['classid'])) {
		$wheresql = $wheresql." AND mt.classid = '$_GET[classid]' ";
	}

	if(isset($_GET['viewme']) && $_GET['viewme']=="0") {
	}
	else{
		$usermemberlist = querymemberbyuid($tagid, $_SGLOBAL['supe_uid']);
		$subwheresql = " mt.uid = $_SGLOBAL[supe_uid]";
		foreach($usermemberlist as $member){
			$subwheresql .= " OR (mt.members like '%,$member[memberid],%')";
		}
		$wheresql = $wheresql." AND ( $subwheresql )";
	}

	//本月任务
	$tasks = array();
//	showmessage($dayscount);
	$qsql = "SELECT mt.* FROM ".tname("mtagtask")." mt WHERE mt.tagid = $tagid AND mt.starttime <= $dayend AND mt.endtime >= $daystart $wheresql ORDER BY mt.taskid DESC";
//		showmessage($qsql);
	$query = $_SGLOBAL['db']->query( $qsql );
	while($value=$_SGLOBAL['db']->fetch_array($query)) {
//		showmessage(intval(date("j", $value['starttime'])));
//		$start = $value['starttime'] < $daystart ? 1 : intval(date("j", $value['starttime']));
//		$end = $value['endtime'] > $dayend ? $dayscount : intval(date("j", $value['endtime']));
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

	//链接
	$url = $_GET['url'] ? preg_replace("/date=[\d\-]+/", '', $_GET['url']) : "space.php?do=mtag&view=tasks&tagid=$tagid";
	include_once template("cp_mtag_manage_tasks_calendar_ajax");
}
elseif($_GET['op'] == 'join') {
	//TODO need be delete
	$tagid = empty($_GET['tagid'])?0:intval($_GET['tagid']);
	if(submitcheck('joinsubmit')) {
		$mtag = mtag_join('tagid', $tagid);
		if(empty($mtag)) {
			showmessage('mtag_join_error');
		} else {
			showmessage('join_success', "space.php?uid=$_SGLOBAL[supe_uid]&do=mtag&tagid=$mtag[tagid]", 0);
		}
	}
}
elseif($_GET['op'] == 'out') {
	//TODO need be delete
	$tagid = empty($_GET['tagid'])?0:intval($_GET['tagid']);
	$mtag = $tagid?getmtag($tagid):array();

	if(submitcheck('outsubmit')) {
		//对私密群组进行验证
		if(($mtag['joinperm'] > 0 || $mtag['viewperm'] > 0) && $mtag['grade'] == 9) {
			//验证是否还有主群组
			$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('mtagmember')." WHERE tagid='$tagid' AND grade='9'"), 0);
			if($count < 2) {
				showmessage('failure_to_withdraw_from_group');
			}
		}
		if($mtag['status'] != -9) {
			mtag_out($mtag, array($_SGLOBAL['supe_uid']));//退出
		}
		showmessage('do_success', "space.php?do=mtag");
	}
}
elseif($_GET['op'] == 'injectcredit') {

	$tagid = empty($_GET['tagid'])?0:intval($_GET['tagid']);
	$mtag = $tagid?getmtag($tagid):array();

	if(submitcheck('injectcreditsubmit')) {
		$credit = intval($_POST['credit']);
		if($credit<=0){
			showmessage('mtag_injectcredit_creditinvalid');
		}
		
		if( $_SGLOBAL[member][credit] < $credit){
			showmessage('mtag_injectcredit_creditrunlow');
		} 
		
		injectcredit($tagid, $_SGLOBAL['supe_uid'], "捐助资金", $credit);
		showmessage('do_success');
	}
	else{
		include_once template("cp_mtag_injectcredit");
	}
}
elseif($_GET['op'] == 'querymds') {

	//处理搜索
	include_once(S_ROOT.'./source/function_admincp.php');

	$mpurl="cp.php?ac=mtag&op=querymds&widget=".$_GET['widget']."&id=".$_GET['id'];
	$mpurl .= '&'.implode('&', $results['urls']);

	$wheresql = ' m.tagstate >= 2 ';

	if($_GET['tagid']) {
		$wheresql = $wheresql." AND m.tagid = '$_GET[tagid]' ";
		$mpurl .= '&tagid='.$_GET['tagid'];
	}

	if($_GET['tagname']) {
		$wheresql = $wheresql." AND m.tagname like '%$_GET[tagname]%' ";
		$mpurl .= '&tagname='.$_GET['tagname'];
	}

	if(!empty($_GET['lockfieldid'])){
		$wheresql = $wheresql." AND m.fieldid in ( $_GET[lockfieldid] ) ";
		$mpurl .= '&lockfieldid='.$_GET['lockfieldid'];
	}
	else{
		if($_GET['fieldid']) {
			$wheresql = $wheresql." AND m.fieldid = '$_GET[fieldid]' ";
			$mpurl .= '&fieldid='.$_GET['fieldid'];
		}
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
	$csql = "SELECT COUNT(*) FROM ".tname('mtag')." m WHERE $wheresql";
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($csql), 0);

	$qsql = "SELECT m.* FROM ".tname('mtag')." m WHERE $wheresql order by m.tagid LIMIT $start,$perpage";
	$list=querymtag($qsql);

	//显示分页
	$multi = multi($count, $perpage, $page, $mpurl);

	include_once template("cp_mtag_query_list");
}
elseif($_GET['op'] == 'loadmtagbyid_ajax') {
	$tagid = $_GET['tagid'];
	if(empty($tagid)) {
		showmessage("mtag_not_exist");
	}
	$mtag=loadmtagbyid($tagid);
	//群组不存在
	if(empty($mtag)) {
		showmessage('mtag_not_exist');
	}

	$lockfieldid = $_GET['lockfieldid'];
	if(!empty($lockfieldid)){
		$lockfieldidarray = split(',',$lockfieldid);
		$found = false;
		foreach($lockfieldidarray as $fielditem){
			if($mtag[fieldid] == $fielditem){
				$found = true;
			}
		}

		if(!$found){
			showmessage('mtag_not_exist');
		}
	}


	$mtag = mtagformmapper($mtag);
	showmessage('ajax_param', '', 0, array($mtag['tagid'],$mtag['tagname'],$mtag['fieldid'],$mtag['fieldname']));
}
elseif($_GET['op'] == 'checkmtagbytagname_ajax') {
	$tagname = $_GET['tagname'];
	if(empty($tagname)) {
		showmessage("mtag_name_empty");
	}
	$mtaglist=loadmtaglistbytagname(trim($tagname));

	showmessage('ajax_param', '', 0, array($tagname,count($mtaglist)));
}


function note_apply($sqlarr) {
	global $_SGLOBAL;

	$fieldsql = $comma = '';
	if(is_array($sqlarr)) {
		$uids = array();
		$valsql = '(';
		foreach($sqlarr as $key => $value) {
			$uids[] = $value['uid'];
			foreach($value as $vkey => $val) {
				if($key == 0) {
					$fieldsql .= $comma.$vkey;
				}
				$valsql .= $comma.'\''.$val.'\'';
				$comma = ', ';
			}
			if(count($sqlarr)-1 > $key) {
				$valsql .= '), (';
				$comma = '';
			}
		}
		$valsql .= ')';
		$_SGLOBAL['db']->query('insert into '.tname('notification').' ('.$fieldsql.') values '.$valsql);
		$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET notenum=notenum+1 WHERE uid IN (".simplode($uids).")");
	}
}

?>