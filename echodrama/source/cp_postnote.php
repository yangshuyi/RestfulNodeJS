<?php
/*
 [UCenter Home] (C) 2007-2008 Comsenz Inc.
 $Id: cp_mtag.php 13223 2009-08-24 01:53:27Z liguode $
 */

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}


include_once(S_ROOT.'./data/data_mtagtaskimptclass.php');
include_once(S_ROOT.'./source/function_postnote.php');

$_GET['op'] = empty($_GET['op'])?'new':$_GET['op'];
$postnoteid = $_GET['postnoteid'];

if($_GET['op'] == 'manage') {
	$postnote = null;
	if(empty($postnoteid)){
		$postnote=array();
		$uid = $_GET['uid'];
		if(empty($uid)){
			showmessage('postnote_uid_empty');
		}
		
		$postnote['uid'] = $uid;
		$postnote['fromuid'] = $_SGLOBAL['supe_uid'];
		
		$postnote['dateline'] = $_SGLOBAL['timestamp'];
	}
	else{
		
		$postnote=loadpostnotebyid($postnoteid);
		if(empty($postnote)){
			showmessage('postnote_not_exist');
		}
		$postnote=postnoteformmapper($postnote);
		
		$uid = $_GET['uid'];
		if(empty($uid) || $uid!=$postnote[uid]){
			showmessage('no_privilege');
		}
		if( $postnote[uid] != $_SGLOBAL['supe_uid'] || $postnote[fromuid] != $_SGLOBAL['supe_uid'] ){
			showmessage('no_privilege');
		}
	}
	
	$namemap = loadnamemap(array($postnote['uid'], $postnote['fromuid']));
		
	$postnote['username'] = $namemap[$postnote['uid']];
	$postnote['fromusername'] = $namemap[$postnote['fromuid']];
	
	include_once template("cp_postnote");
}	
else if($_GET['op'] == 'save') {
	$postnote = null;
	if(empty($postnoteid)){
		$postnote=array();
		$postnote['dateline']=$_SGLOBAL['timestamp'];
	}
	else{
		$postnote=loadpostnotebyid($postnoteid);
		if(empty($postnote)){
			showmessage('postnote_not_exist');
		}
		if( $postnote[uid] != $_SGLOBAL['supe_uid'] || $postnote[fromuid] != $_SGLOBAL['supe_uid'] ){
			showmessage('no_privilege');
		}
	}

	
	$postnote['fromuid'] = $_POST['fromuid'];
	$postnote['uid'] = $_POST['uid'];
	
	$namemap = loadnamemap(array($postnote['uid'], $postnote['fromuid']));
		
	$postnote['username'] = $namemap[$postnote['uid']];
	$postnote['fromusername'] = $namemap[$postnote['fromuid']];
	
	$postnote['subject'] = $_POST['subject'];
	$postnote['description'] = $_POST['description'];
	$postnote['notedate'] = sstrtotime($_POST['notedate']);
	$postnote['importance'] = $_POST['importance'];
	
	if(empty($postnote['uid'])){
		showmessage('postnote_uid_empty');
	}if(empty($postnote['fromuid'])){
		showmessage('postnote_fromuid_empty');
	}else if(empty($postnote['subject'])){
		showmessage('postnote_subject_empty');
	}else if(empty($postnote['importance'])){
		showmessage('postnote_importance_empty');
	}else if(empty($postnote['description'])){
		showmessage('postnote_description_empty');
	}else if(empty($postnote['notedate'])){
		showmessage('postnote_notedate_empty');
	}
	
	if(empty($postnoteid)){
		$postnoteid = inserttable('postnote', $postnote, 1);
	}else{
		$postnoteid = $postnote['postnoteid'];
		updatetable('postnote', $postnote, array('postnoteid'=>$postnote['postnoteid']));
	}
	
	showmessage('do_success', "space.php?uid=$postnote[uid]", 0);
}
else if($_GET['op'] == 'delete') {
	
	$postnoteid = $_GET['postnoteid'];
	if(empty($postnoteid)){
		showmessage('postnote_not_exist');
	}

	$postnote=loadpostnotebyid($postnoteid);
	if(empty($postnote)){
		showmessage('postnote_not_exist');
	}
		
	if( $postnote[uid] != $_SGLOBAL['supe_uid'] || $postnote[fromuid] != $_SGLOBAL['supe_uid'] ){
		showmessage('no_privilege');
	}

	$_SGLOBAL['db']->query("DELETE FROM ".tname('postnote')." WHERE postnoteid='$postnoteid'");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE idtype='postnoteid' and id=$postnote[postnoteid]");
	showmessage('do_success', "space.php?uid=$postnote[uid]", 0);	
}
?>