<?php
/*
 [UCenter Home] (C) 2007-2008 Comsenz Inc.
 $Id: function_delete.php 13001 2009-08-05 06:18:06Z zhengqingpeng $
 */

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

function listhottonelabel(){
	global $_SGLOBAL, $_SC;

	$list=array();
	$querysql="SELECT tl.* FROM ".tname('tonelabel')." tl ORDER BY tl.joinnum desc LIMIT 0,10";
	$query = $_SGLOBAL['db']->query($querysql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$list[] = $value;
	}
	return $list;
}

function listtonelabel(){
	global $_SGLOBAL, $_SC;

	$list=array();
	$querysql="SELECT tl.* FROM ".tname('tonelabel')." tl ORDER BY tl.joinnum desc";
	$query = $_SGLOBAL['db']->query($querysql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$obj=array();
		$obj['classid'] = $value['classid'];
		$obj['classname'] = $value['classname'];
		$list[] = $obj;
	}
	return $list;
}

function updateToneSpace($uid){
	global $_SGLOBAL, $_SC;
	
	//更新用户统计
	$sql="update ".tname('space')." s set s.tonenum=(select count(t.toneid) from ".tname('tone')." t where t.uid=$uid) where s.uid=$uid";
	$_SGLOBAL['db']->query($sql);
	
}

function updatetonereward($uid, $action){
	global $_SGLOBAL, $_SC;
	//积分 $action, $update=1, $uid=0, $needle='', $setcookie = 1
	$reward = getreward($action, 1, $uid);
	
}


function updatetonelabel($labelparam){
	global $_SGLOBAL, $_SC;

	if(empty($labelparam)){
		return;
	}
	$labels=split('/',$labelparam);
	$checkedlabels=array();
	$checkedlabelparam="";
	foreach($labels as $labelitem){
		if(!empty($labelitem)){
			$checkedlabels[$labelitem]=trim($labelitem);
		}
	}

	foreach($checkedlabels as $labelitem){
		$checkedlabelparam=$checkedlabelparam.$labelitem."/";
		$querysql="SELECT tl.* FROM ".tname('tonelabel')." tl where tl.classname='".$labelitem."' ";
		$query = $_SGLOBAL['db']->query($querysql);
		$tonelabel = $_SGLOBAL['db']->fetch_array($query);
		if(! $tonelabel){
			$tonelabel=Array();
			$tonelabel["classname"]=$labelitem;
			$tonelabel["joinnum"]=1;
			inserttable("tonelabel", $tonelabel);
		}else{
			$tonelabel["joinnum"]=$tonelabel["joinnum"]+1;
			updatetable('tonelabel', $tonelabel, array('classid'=>$tonelabel["classid"]));
		}
	}
	
//	$checkedlabelparam=substr($checkedlabelparam,0,strlen($checkedlabelparam)-1);
	
	return $checkedlabelparam;
}

function checkusertonecount($uid){
	global $_SGLOBAL, $_SC;
	
	$checktonecountsql="SELECT COUNT(*) AS tonecount FROM ".tname("tone")." t WHERE t.uid='$uid'";
	$query = $_SGLOBAL['db']->query($checktonecountsql);
	$value = $_SGLOBAL['db']->fetch_array($query);
	return $value['tonecount'];
}

function loadtonebyid($toneid){
	global $_SGLOBAL, $_SC;
	
	$qsql="SELECT t.* FROM ".tname("tone")." t WHERE t.toneid=$toneid";
	$query = $_SGLOBAL['db']->query($qsql);
	$value = $_SGLOBAL['db']->fetch_array($query);
	
	return $value;
}

function toneformmapper($value){
	global $_SGLOBAL, $_SC;
	
	include_once(S_ROOT.'./data/data_toneclass.php');
	
	$value['dateline'] = sgmdate('Y-m-d', $value['dateline']);
	$value['endtime'] = $value['endtime']?sgmdate('Y-m-d', $value['endtime']):'';
	$value['lastpost'] = sgmdate('Y-m-d', $value['lastpost']);
	
	$value['filepath']= $_SC['attachdir'].'./'.$value['file'];
	$value['fileexists']=is_file($value[filepath]);
	if(empty($value['remoteid']) || $value['remoteid']=='-1' ){
		$value['mp3path']= $_SC['attachdir'].'./'.$value['file'];
	}else{
		$fileext = fileextwithcase($value['file']);
		$value['mp3path']="http://tone$value[remoteid].googlecode.com/files/$value[toneid].$fileext";
	}
	
	
	$value['descriptionlimit'] = getstr($value['description'], 100, 0, 0, 0, 0, -1);
	$value['classname']=$_SGLOBAL['toneclass'][$value['classid']]['classname'];
	$value['labeldisplay']=$value['label'];
	realname_set($value['uid'], $value['username']);
	
	$value['pollnum']=$value['poll_1']+$value['poll_2']+$value['poll_3']+$value['poll_4']+$value['poll_5'];
	if($value['pollnum']>0){
		$value['pollsum']=$value['poll_1']+$value['poll_2']*2+$value['poll_3']*3+$value['poll_4']*4+$value['poll_5']*5;
		$value['pollavg']=$value['pollsum']/$value['pollnum'];
		$value['polllevel']=round($value['pollavg']*2,0)*5;
		$value['poll_1_rate']=round($value['poll_1']*100/$value['pollnum'],1);
		$value['poll_2_rate']=round($value['poll_2']*100/$value['pollnum'],1);
		$value['poll_3_rate']=round($value['poll_3']*100/$value['pollnum'],1);
		$value['poll_4_rate']=round($value['poll_4']*100/$value['pollnum'],1);
		$value['poll_5_rate']=round($value['poll_5']*100/$value['pollnum'],1);
	}
	
	return $value;
}

// 查询声线
function querytone($querysql){
	global $_SGLOBAL, $_SC;
	
	$list=array();

	$query = $_SGLOBAL['db']->query($querysql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$list[] = toneformmapper($value);
	}
	return $list;
}

function renametones($toneids){
	global $_SGLOBAL,$_SC;
	 
	include_once(S_ROOT.'./source/function_cp.php');

	//数据
	if(count($toneids)>1){
		$qsql="SELECT * FROM ".tname('tone')." WHERE toneid IN (".simplode($toneids).")";
	}else{
		$qsql="SELECT * FROM ".tname('tone')." WHERE toneid = '$toneids'";
	}
	$query = $_SGLOBAL['db']->query($qsql);
	while ($tone = $_SGLOBAL['db']->fetch_array($query)) {
		
		$file = $tone['file'];
		$filepath = $_SC['attachdir'].'./'.$tone['file'];

		$newfile = "/tone/".$tone['toneid'].".mp3";
		$newfilepath = $_SC['attachdir'].'./'.$newfile;
		
		if($filepath == $newfilepath){
			continue;
		}
		if(empty($newfilepath)) {
			showmessage('tone_file_empty');
		} 
		
		if(is_file($newfilepath)){
			showmessage('tone_file_exists');
		}
		
		if(!is_file($filepath)){
			showmessage('tone_file_not_exists');
		}
			
		rename($filepath,$newfilepath);
			
		$updateSql="UPDATE ".tname('tone')." SET file = '$newfile' where toneid=$tone[toneid]";
		$_SGLOBAL['db']->query($updateSql);
	}
	return true;	
}


//删除声线
function deletetones($toneids) {
	global $_SGLOBAL, $_SC;

	include_once(S_ROOT.'./source/function_cp.php');

	//数据
	$list = array();
	$managetone = checkperm('managetone');
	$qsql="SELECT * FROM ".tname('tone')." WHERE toneid IN (".simplode($toneids).")";
	$list=querytone($qsql);

	foreach($list as $value) {

		if(file_exists($value['filepath'])){
			unlink($value['filepath']);
		}

		$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE idtype='toneid' and id=$value[toneid]");
		$_SGLOBAL['db']->query("DELETE FROM ".tname('toneuser')." WHERE toneid=$value[toneid]");
		$_SGLOBAL['db']->query("DELETE FROM ".tname('tonepoll')." WHERE toneid=$value[toneid]");
		$_SGLOBAL['db']->query("DELETE FROM ".tname('tone')." WHERE toneid=$value[toneid]");
		$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE idtype='toneid' AND id=$value[toneid]");
		
		updatetonereward($value['uid'],'tone_delete');
	
	}

	return true;
}

?>