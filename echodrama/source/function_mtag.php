<?php
/*
 [UCenter Home] (C) 2007-2008 Comsenz Inc.
 $Id: function_delete.php 13001 2009-08-05 06:18:06Z zhengqingpeng $
 */

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

function listtaskclass($tagid){
	global $_SGLOBAL, $_SC;

	$querysql = "SELECT mtc.*, count(mt.classid) AS taskcount FROM ".tname('mtag_taskclass')." mtc ";
	$querysql .= " LEFT OUTER JOIN ".tname('mtagtask')." mt ON mt.classid = mtc.classid AND mt.tagid = $tagid ";
	$querysql .= " WHERE mtc.tagid = $tagid GROUP BY mtc.classid ORDER BY mtc.displayorder";
	$list=array();
	$query = $_SGLOBAL['db']->query($querysql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if( $value['taskcount']>0 ){
			$value['state']=1;
			$value['statename']="已使用";
		}
		else{
			$value['state']=0;
			$value['statename']="未使用";
		}
		$list[]=$value;
	}
	return $list;
}

function updatetaskclass($tagid, $classidarray, $classnamearray, $displayorderarray) {
	global $_SGLOBAL, $_SC;

	$deleteprevioussql="DELETE FROM ".tname('mtag_taskclass')." WHERE tagid = '$tagid'";
	$query = $_SGLOBAL['db']->query($deleteprevioussql);

	for ($i=0;$i<count($classidarray);$i++){
		$taskclass=array();
		$taskclass['tagid'] = $tagid;
		if($classidarray[$i]!="0"){
			$taskclass['classid'] = $classidarray[$i];
		}
		$taskclass['classname'] = $classnamearray[$i];
		$taskclass['displayorder'] = $displayorderarray[$i];
		inserttable('mtag_taskclass', $taskclass);
	}
}

function loadtaskbyid($tagid, $taskid){
	global $_SGLOBAL, $_SC;

	$querysql = "SELECT * FROM ".tname('mtagtask')." mt WHERE mt.tagid='$tagid' AND mt.taskid='$taskid'";
	$query = $_SGLOBAL['db']->query($querysql);
	$value = $_SGLOBAL['db']->fetch_array($query);
	return $value;
}

function querytaskbyid($tagid, $taskid){
	global $_SGLOBAL, $_SC;

	$querysql = "SELECT mt.*, mtc.classname taskclassname ";
	$querysql .= " FROM ".tname('mtagtask')." mt ";
	$querysql .= " LEFT OUTER JOIN ".tname('mtag_taskclass')." mtc ON mt.classid = mtc.classid ";
	$querysql .= " WHERE mt.tagid='$tagid' and mt.taskid='$taskid' ";
	
	$list=array();
	$query = $_SGLOBAL['db']->query($querysql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$list[] = taskformmapper($value);
	}
	return $list[0];
}

function taskformmapper( $value ) {
	global $_SGLOBAL, $_SC;
		
	include_once(S_ROOT.'./data/data_mtagtaskimptclass.php');
	
	$value['importancename'] = $_SGLOBAL['mtagtaskimptclass'][$value['importance']]['classname'];
	$value['closedisp'] = empty($value['close'])?'开放中':'已关闭';
	$value['starttimedisp'] = $value['starttime']?sgmdate('Y-m-d',$value['starttime']):'';
	$value['endtimedisp'] = $value['endtime']?sgmdate('Y-m-d',$value['endtime']):'';
				
	return $value;
}


function listfansgrade(){
	global $_SGLOBAL, $_SC;

	$querysql="SELECT * FROM ".tname('mtag_fansgrade')." mfg ORDER BY mfg.displayorder";
	$list=array();
	$query = $_SGLOBAL['db']->query($querysql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$list[]=$value;
	}
	return $list;
}

function checkfansgrade($mtagid, $uid){
	global $_SGLOBAL, $_SC;

	$querysql="SELECT mf.fansgradeid AS fansgradeid FROM ".tname('mtagfans')." mf ";
	$querysql .=" WHERE mf.deleteflag=0 AND mf.tagid = '$mtagid' AND mf.uid='$uid'";

	$query = $_SGLOBAL['db']->query($querysql);
	$value = $_SGLOBAL['db']->fetch_array($query);

	return $value['fansgradeid']?$value['fansgradeid']:0;
}

function listtagbyfansgrademaintainthread($uid){
	global $_SGLOBAL, $_SC;

	$querysql="SELECT m.* FROM ".tname('mtag')." m, ".tname('mtagfans')." mf ";
	$querysql .=" WHERE m.tagid=mf.tagid AND m.tagstate>=2 AND mf.fansgradeid>=4 AND mf.deleteflag=0 AND mf.uid='$uid'";
	$querysql .=" ORDER BY m.fieldid, m.dateline";
	
	$list=array();
	$query = $_SGLOBAL['db']->query($querysql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$list[]=mtagformmapper($value);
	}
	return $list;
}

function listtagbyfansgrademaintainpost($uid){
	global $_SGLOBAL, $_SC;

	$querysql="SELECT m.* FROM ".tname('mtag')." m, ".tname('mtagfans')." mf ";
	$querysql .=" WHERE m.tagid=mf.tagid AND m.tagstate>=2 AND mf.fansgradeid>=3 AND mf.deleteflag=0 AND mf.uid='$uid'";
	$querysql .=" ORDER BY m.fieldid, m.dateline";
	
	$list=array();
	$query = $_SGLOBAL['db']->query($querysql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$list[]=mtagformmapper($value);
	}
	return $list;
}

function listtagbyfansgradeviewthread($uid){
	global $_SGLOBAL, $_SC;

	$querysql="SELECT m.* FROM ".tname('mtag')." m, ".tname('mtagfans')." mf ";
	$querysql .=" WHERE m.tagid=mf.tagid AND m.tagstate>=2 AND mf.fansgradeid>=2 AND mf.deleteflag=0 AND mf.uid='$uid'";
	$querysql .=" ORDER BY m.fieldid, m.dateline";
	
	$list=array();
	$query = $_SGLOBAL['db']->query($querysql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$list[]=mtagformmapper($value);
	}
	return $list;
}

function listmembergrade(){
	global $_SGLOBAL, $_SC;

	$querysql="SELECT * FROM ".tname('mtag_membergrade')." mmg ORDER BY mmg.displayorder";
	$list=array();
	$query = $_SGLOBAL['db']->query($querysql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$list[]=$value;
	}
	return $list;
}

function checkmembergrade($mtagid, $uid){
	global $_SGLOBAL, $_SC;

	$querysql="SELECT max(mmg.classid) AS classid FROM ".tname('mtagmember')." mm LEFT OUTER JOIN ".tname('mtag_membergrade')." mmg ON mm.membergradeid=mmg.classid WHERE mm.tagid = '$mtagid' AND mm.uid='$uid'";

	$query = $_SGLOBAL['db']->query($querysql);
	$value = $_SGLOBAL['db']->fetch_array($query);

	return $value['classid'];
}

function listmemberclassbymtagid($tagid){
	global $_SGLOBAL, $_SC;

	$querysql="SELECT * FROM ".tname('mtag_memberclass')." mmc WHERE mmc.tagid = '$tagid' ORDER BY mmc.displayorder";
	//showmessage($querysql);
	$list=array();
	$query = $_SGLOBAL['db']->query($querysql);
	$index=1;
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$value['displayorder']=$index;
		$containmemberlist=querymemberbymemberclassid($tagid, $value['classid']);
		if(count($containmemberlist)>0){
			$value['state']=1;
			$value['statename']="已含成员";
		}else{
			$value['state']=0;
			$value['statename']="未含成员";
		}
		$index=$index+1;
		$list[]=$value;
	}
	return $list;
}

function querymemberbyclass($tagid, $classid){
	global $_SGLOBAL, $_SC;

	$querysql="SELECT mm.*, mmg.classname as memebergradename, mmc.classname as memberclassname, s.ip as uip ";
	$querysql .= " FROM ".tname('mtagmember')." mm ";
	$querysql .= " LEFT OUTER JOIN ".tname('mtag_membergrade')." mmg ON mm.membergradeid=mmg.classid ";
	$querysql .= " LEFT OUTER JOIN ".tname('mtag_memberclass')." mmc ON mm.memberclassid=mmc.classid AND mm.tagid=mmc.tagid ";
	$querysql .= " LEFT OUTER JOIN ".tname('session')." s ON mm.uid=s.uid AND s.magichidden != 1";
	$querysql .= " WHERE mm.tagid = '$tagid' and mm.memberclassid='$classid' ORDER BY mm.dateline";
	$list=array();
	$query = $_SGLOBAL['db']->query($querysql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$list[]=$value;
	}
	return $list;
}

function queryothermemberclassidbymtagid($tagid){
	global $_SGLOBAL, $_SC;

	$querysql="SELECT * FROM ".tname('mtag_memberclass')." mmc WHERE mmc.tagid = '$tagid' and mmc.classname='其他' ORDER BY mmc.displayorder";
	$list=array();
	$query = $_SGLOBAL['db']->query($querysql);
	$value = $_SGLOBAL['db']->fetch_array($query);
	return $value['classid'];
}

function updatememberclass($tagid, $classidarray, $classnamearray, $systemflagarray, $displayorderarray) {
	global $_SGLOBAL, $_SC;

	$deleteprevioussql="DELETE FROM ".tname('mtag_memberclass')." WHERE tagid = '$tagid' AND systemflag=0";
	$query = $_SGLOBAL['db']->query($deleteprevioussql);

	//showmessage(simplode($displayorderarray));
	for ($i=0;$i<count($classidarray);$i++){
		if($systemflagarray[$i]==0){
			$memberclass=array();
			$memberclass['tagid'] = $tagid;
			if($classidarray[$i]!="0"){
				$memberclass['classid'] = $classidarray[$i];
			}
			$memberclass['classname'] = $classnamearray[$i];
			$memberclass['systemflag'] = 0;
			$memberclass['displayorder'] = $displayorderarray[$i];
			inserttable('mtag_memberclass', $memberclass);
		}else{
			$_SGLOBAL['db']->query("UPDATE ".tname("mtag_memberclass")." SET displayorder='$displayorderarray[$i]' where tagid='$tagid' and classid='$classidarray[$i]'");
		}
	}
}

function querymemberbymemberclassid($tagid, $memberclassid){
	global $_SGLOBAL, $_SC;

	$querysql="SELECT * FROM ".tname('mtagmember')." mm WHERE mm.tagid = '$tagid' and mm.memberclassid='$memberclassid'";
	$list=array();
	$query = $_SGLOBAL['db']->query($querysql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$list[]=$value;
	}
	return $list;
}

function querymemberbyuid($tagid, $uid){
	global $_SGLOBAL, $_SC;

	$querysql = "SELECT mm.*, mmc.classname memberclassname, mmg.classname membergradename ";
	$querysql = $querysql." FROM ".tname('mtagmember')." mm ";
	$querysql = $querysql." LEFT OUTER JOIN ".tname('mtag_memberclass')." mmc ON mm.memberclassid = mmc.classid AND mm.tagid=mmc.tagid ";
	$querysql = $querysql." LEFT OUTER JOIN ".tname('mtag_membergrade')." mmg ON mm.membergradeid = mmg.classid ";
	$querysql = $querysql." WHERE mm.tagid='$tagid' AND mm.uid='$uid'";

	$list=array();
	$query = $_SGLOBAL['db']->query($querysql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$list[]=$value;
	}
	return $list;
}

function querymemberbyid($tagid, $memberid){
	global $_SGLOBAL, $_SC;

	$querysql = "SELECT mm.*, mmc.classname memberclassname, mmg.classname membergradename ";
	$querysql = $querysql." FROM ".tname('mtagmember')." mm ";
	$querysql = $querysql." LEFT OUTER JOIN ".tname('mtag_memberclass')." mmc ON mm.memberclassid = mmc.classid AND mm.tagid=mmc.tagid ";
	$querysql = $querysql." LEFT OUTER JOIN ".tname('mtag_membergrade')." mmg ON mm.membergradeid = mmg.classid ";
	$querysql = $querysql." WHERE mm.tagid='$tagid' AND mm.memberid='$memberid'";

	$query = $_SGLOBAL['db']->query($querysql);
	$value = $_SGLOBAL['db']->fetch_array($query);
	return $value;
}

function loadmemberbyid($tagid, $memberid){
	global $_SGLOBAL, $_SC;

	$querysql = "SELECT * FROM ".tname('mtagmember')." mm WHERE mm.tagid='$tagid' AND mm.memberid='$memberid'";
	$query = $_SGLOBAL['db']->query($querysql);
	$value = $_SGLOBAL['db']->fetch_array($query);
	return $value;
}

function querymemberbyuser($tagid, $uid, $username){
	global $_SGLOBAL, $_SC;

	$wheresql="";
	if(!empty($uid)){
		$wheresql = $wheresql." AND mm.uid = '$uid'";
	}else if(!empty($username)){
		$wheresql = $wheresql." AND mm.username = '$username'";
	}else{
		return null;
	}

	$querysql = "SELECT mm.*, mmc.classname memberclassname, mmg.classname membergradename ";
	$querysql = $querysql." FROM ".tname('mtagmember')." mm ";
	$querysql = $querysql." LEFT OUTER JOIN ".tname('mtag_memberclass')." mmc ON mm.memberclassid = mmc.classid AND mm.tagid=mmc.tagid ";
	$querysql = $querysql." LEFT OUTER JOIN ".tname('mtag_membergrade')." mmg ON mm.membergradeid = mmg.classid ";
	$querysql = $querysql." WHERE mm.tagid='$tagid' $wheresql";

	$query = $_SGLOBAL['db']->query($querysql);
	$value = $_SGLOBAL['db']->fetch_array($query);
	return $value;
}

function loadfansbyuserid($tagid, $uid){
	global $_SGLOBAL, $_SC;

	$querysql = "SELECT * FROM ".tname('mtagfans')." mf WHERE mf.tagid='$tagid' AND mf.uid='$uid'";
	$query = $_SGLOBAL['db']->query($querysql);
	$value = $_SGLOBAL['db']->fetch_array($query);
	return $value;
}


function querymtagproductitem($qsql){
	global $_SGLOBAL, $_SC;
	
	$list = array();
	$query = $_SGLOBAL['db']->query($qsql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$list[]=$value;
	}
	return $list;
}

function loadmtagproductitembyid($tagid, $productitemid){
	global $_SGLOBAL, $_SC;

	$querysql = "SELECT * FROM ".tname('mtagproduct')." mp WHERE mp.tagid='$tagid' AND mp.itemid='$productitemid'";
	$query = $_SGLOBAL['db']->query($querysql);
	$value = $_SGLOBAL['db']->fetch_array($query);
	return $value;
}

function querymtagproductitembyid($tagid, $productitemid){
	global $_SGLOBAL, $_SC;

	$querysql = "SELECT mp.*, t.productclassid AS topicproductclassid, c.productclassid AS coverproductclassid, v.productclassid AS videoproductclassid, ";
	$querysql .= " t.producedate AS topicproducedate, c.producedate AS coverproducedate, v.producedate AS videoproducedate ";
	$querysql .= " FROM ".tname('mtagproduct')." mp ";
	$querysql .= " LEFT OUTER JOIN ".tname('topic')." t ON mp.productid = t.topicid AND mp.producttype = 1 ";
	$querysql .= " LEFT OUTER JOIN ".tname('cover')." c ON mp.productid = c.coverid AND mp.producttype = 2 ";
	$querysql .= " LEFT OUTER JOIN ".tname('video')." v ON mp.productid = v.videoid AND mp.producttype = 3 ";
	$querysql .= " WHERE mp.tagid='$tagid' and mp.itemid='$productitemid' ";
			
	$query = $_SGLOBAL['db']->query($querysql);
	$value = $_SGLOBAL['db']->fetch_array($query);
	
	$value['producttypename'] = $_SGLOBAL['producttype'][$value['producttype']]['classname'];
	if( $value['producttype'] == 1 ){
		$value['productclassname'] = $_SGLOBAL['productclass'][$value['topicproductclassid']]['classname'];
		$value['dispproductdate'] = sgmdate('Y-m-d',$value['topicproducedate']);
		$value['producturl'] = "space.php?do=topic&topicid=$value[productid]";
	}
	elseif( $value['producttype'] == 2 ){
		$value['productclassname'] = $_SGLOBAL['coverproductclass'][$value['coverproductclassid']]['classname'];
		$value['dispproductdate'] = sgmdate('Y-m-d',$value['coverproducedate']);
		$value['producturl'] = "space.php?do=cover&coverid=$value[productid]";
	}
	elseif( $value['producttype'] == 3 ){
		$value['productclassname'] = $_SGLOBAL['videoproductclass'][$value['videoproductclassid']]['classname'];
		$value['dispproductdate'] = sgmdate('Y-m-d',$value['videoproducedate']);
		$value['producturl'] = "space.php?do=video&videoid=$value[productid]";
	}
				
	return $value;
}

function loadrelatedcvtag($uid){
	global $_SGLOBAL, $_SC;

	$querysql = "SELECT m.* FROM ".tname('mtag')." m WHERE m.fieldid=3 AND m.creatorid='$uid'";
			
	$query = $_SGLOBAL['db']->query($querysql);
	$value = $_SGLOBAL['db']->fetch_array($query);
	return $value;
}

// 查询群组
function loadmtaglistbytagname($tagname){
	global $_SGLOBAL, $_SC;

	$tagname = trim($tagname);
	$querysql="SELECT mtag.* FROM ".tname('mtag')." mtag WHERE mtag.tagname = '$tagname'";
	$list=array();
	$query = $_SGLOBAL['db']->query($querysql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$list[]=$value;
	}

	return $list;
}

function loadmtagbyid($mtagid){
	global $_SGLOBAL, $_SC;

	$querysql="SELECT mtag.* FROM ".tname('mtag')." mtag WHERE mtag.tagid = '$mtagid'";

	$query = $_SGLOBAL['db']->query($querysql);
	$value = $_SGLOBAL['db']->fetch_array($query);

	return $value;
}

function querymtag($querysql){
	global $_SGLOBAL, $_SC;

	$list=array();
	$query = $_SGLOBAL['db']->query($querysql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$list[] = mtagformmapper($value);
	}
	return $list;
}

function mtagformmapper($mtag){
	global $_SGLOBAL, $_SC;

	include_once(S_ROOT.'./data/data_profield.php');
	include_once(S_ROOT.'./data/data_mtagstateclass.php');

	$mtag['tagnamelimit'] = getstr($mtag['tagname'], 20, 0, 0, 0, 0, -1);
	
	
	if(empty($mtag['pic'])) {
		$mtag['picpath'] = 'image/nologo.jpg';
		$mtag['picexists'] = false;
	}
	else{
		$mtag['picpath'] = $_SC['attachdir'].'./'.$mtag['pic'];
		$mtag['picexists'] = true;
	}

	$mtag['fieldname']=$_SGLOBAL['profield'][$mtag['fieldid']]['title'];
	$mtag['tagstatename'] = $_SGLOBAL['tagstatename'][$mtag['tagstate']]['classname'];

	$mtag['dateline'] = sgmdate('Y-m-d', $mtag['dateline']);

	$mtag['productnumdisplayvalue']= str_pad($mtag['productnum']."", 4, "0", STR_PAD_LEFT);
	$mtag['membernumdisplayvalue']= str_pad($mtag['membernum']."", 4, "0", STR_PAD_LEFT);
	$mtag['fansnumdisplayvalue']= str_pad($mtag['fansnum']."", 4, "0", STR_PAD_LEFT);
	$mtag['threadnumdisplayvalue']= str_pad($mtag['threadnum']."", 4, "0", STR_PAD_LEFT);
	$mtag['postnumdisplayvalue']= str_pad($mtag['postnum']."", 4, "0", STR_PAD_LEFT);
	
	$mtag['announcementlimit'] = getstr($mtag['announcement'], 100, 0, 0, 0, 0, -1);

	realname_set($mtag['creatorid'], $mtag['creatorname']);

	//成员级别
	//	$mtag['ismember'] = 0;
	//	$mtag['grade'] = -9;//-9 非成员 -2 申请 -1 禁言 0 普通 1 明星 8 副群主 9 群主
	//	$query = $_SGLOBAL['db']->query("SELECT grade FROM ".tname('mtagmember')." WHERE tagid='$id' AND uid='$_SGLOBAL[supe_uid]' LIMIT 1");
	//	if($value = $_SGLOBAL['db']->fetch_array($query)) {
	//		$mtag['grade'] = $value['grade'];
	//		$mtag['ismember'] = 1;
	//	}
	//	if($mtag['grade'] < 9 && checkperm('managemtag')) {
	//		$mtag['grade'] = 9;
	//	}
	//	$mtag['allowthread'] = $mtag['grade']>=0?1:$mtag['threadperm'];
	//	$mtag['allowpost'] = $mtag['grade']>=0?1:$mtag['postperm'];
	//	$mtag['allowview'] = ($mtag['viewperm'] && $mtag['grade'] < -1)?0:1;
	//
	//	$mtag['allowinvite'] = $mtag['grade']>=0?1:0;
	//	if($mtag['joinperm'] && $mtag['grade'] < 8) {
	//		$mtag['allowinvite'] = 0;
	//	}
	//
	//	if($mtag['close']) {
	//		$mtag['allowpost'] = $mtag['allowthread'] = 0;
	//	}
	return $mtag;
}

function savemtag($mtag){
	global $_SGLOBAL, $_SC;

	$new=empty($mtag['tagid']);

	//main table
	if($new) {
		$mtag['tagid'] = inserttable('mtag', $mtag, 1);
	}else{
		updatetable('mtag', $mtag, array('tagid'=>$mtag['tagid']));
	}

	//init member class by default
	if($new){
		if($mtag['fieldid']==1){
			//club
			$memberclassnamearray=array(
					'宣传部 - 负责人', '宣传部 - 成员', 
					'配音部 - 负责人', '配音部 - 成员', 
					'后期部 - 负责人', '后期部 - 成员', 
					'编导部 - 负责人', '编导部 - 成员', 
					'美工部 - 负责人', '美工部 - 成员', 
					'论坛 - 负责人');

		}
		elseif($mtag['fieldid']==2){
			//topic
			$memberclassnamearray=array('导演', '编剧', '后期', '美工');
		}
		elseif($mtag['fieldid']==3){
			//cv
			$memberclassnamearray=array();
		}
		elseif($mtag['fieldid']==4){
			$memberclassnamearray=array();
		}
		elseif($mtag['fieldid']==5){
			//group
			$memberclassnamearray=array(
					'宣传部 - 负责人', '宣传部 - 成员', 
					'配音部 - 负责人', '配音部 - 成员', 
					'后期部 - 负责人', '后期部 - 成员', 
					'编导部 - 负责人', '编导部 - 成员', 
					'美工部 - 负责人', '美工部 - 成员', 
					'论坛 - 负责人');
		}
		else{
			$memberclassnamearray=array();
		}

		$displayorder=1;
		foreach($memberclassnamearray as $memberclassname) {
			$memberclass=array();
			$memberclass['classname'] = $memberclassname;
			$memberclass['tagid'] = $mtag['tagid'];
			$memberclass['systemflag'] = 0;
			$memberclass['displayorder'] = $displayorder;
			inserttable('mtag_memberclass', $memberclass);

			$displayorder=$displayorder+1;
		}

		$memberclass=array();
		$memberclass['classname'] = '其他';
		$memberclass['tagid'] = $mtag['tagid'];
		$memberclass['systemflag'] = 1;
		$memberclass['displayorder'] = $displayorder;
		inserttable('mtag_memberclass', $memberclass);

		$othermemberclassid=queryothermemberclassidbymtagid($mtag['tagid']);

		$mtagmember=array();
		$mtagmember['tagid'] = $mtag['tagid'];
		$mtagmember['uid'] = $mtag['creatorid'];
		$mtagmember['username'] = $mtag['creatorname'];
		$mtagmember['realname'] = $mtag['realname'];
		$mtagmember['memberclassid'] = $othermemberclassid;
		$mtagmember['membergradeid'] = 9;

		inserttable('mtagmember', $mtagmember);
	}
	
	//init thread class by default
	if($new){
		
		$threadclassnamearray=array('公告', '讨论', '问题', '其他');
		
		$displayorder=1;
		foreach($threadclassnamearray as $threadclassname) {
			$threadclass=array();
			$threadclass['classname'] = $threadclassname;
			$threadclass['tagid'] = $mtag['tagid'];
			$threadclass['displayorder'] = $displayorder;
			inserttable('mtag_threadclass', $threadclass);

			$displayorder=$displayorder+1;
		}
	}
}

function querycreditlogbytagid($tagid){
	global $_SGLOBAL,$_SC;
	
	$qsql = "SELECT * FROM ".tname( "mtagcreditlog" )." WHERE tagid = $tagid";
	
	$list=querycreditlog($qsql);
	
	return $list;
}

function querycreditlog($qsql){
	global $_SGLOBAL,$_SC;
	
	$list=array();
	$query = $_SGLOBAL['db']->query($qsql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$list[] = creditlogmapper($value);
	}
	return $list;
}

function creditlogmapper($creditlog){
	$creditlog['datelinedisp'] = $creditlog['dateline']?sgmdate('Y-m-d h:s', $creditlog['dateline']):'';
	$creditlog['creditdisp'] = abs($creditlog['credit']);
	
	return $creditlog;
}

function injectcredit($tagid, $uid, $action, $credit){
	global $_SGLOBAL,$_SC;
	
	$mtag = loadmtagbyid($tagid);
	if(empty($mtag)){
		showmessage('mtag_not_exist');
	}elseif($mtag['tagstate']==0 || $mtag['tagstate']==1){
		showmessage('mtag_state_not_auditpass');
	}
	if($_SGLOBAL['member']['experience']<=500){
		showmessage('mtag_injectcredit_lessexperience');
	}
	
	if($credit<=0){
		showmessage('mtag_injectcredit_creditinvalid');
	}
	
	if( ($_SGLOBAL['member']['credit'] - $credit) <0 ){
		showmessage('mtag_injectcredit_creditrunlow');
	}
	
	$_SGLOBAL['member']['credit'] = $_SGLOBAL['member']['credit'] - $credit;
	$_SGLOBAL['db']->query( "UPDATE ".tname( "space" )." SET credit = credit - $credit where uid=".$_SGLOBAL['supe_uid'] );
	$_SGLOBAL['db']->query( "UPDATE ".tname( "mtag" )." SET credit = credit + $credit where tagid=$tagid" );
	
	$mtagcreditlog = array();
	$mtagcreditlog['tagid'] = $tagid;
	$mtagcreditlog['uid'] = $_SGLOBAL['supe_uid'];;
	$mtagcreditlog['username'] = $_SGLOBAL['supe_username'];
	$mtagcreditlog['actiontype'] = "注入";
	$mtagcreditlog['action'] = $action;
	$mtagcreditlog['credit'] = 1*$credit;
	$mtagcreditlog['dateline'] = $_SGLOBAL['timestamp'];
	
	inserttable('mtagcreditlog', $mtagcreditlog);
}

function consumerecredit($tagid, $uid, $action, $updatecredit){
	global $_SGLOBAL,$_SC;
	
	$_SGLOBAL['db']->query("UPDATE ".tname("mtag")." SET credit=credit - $updatecredit where tagid=$tagid");
	
	$mtagcreditlog = array();
	$mtagcreditlog['tagid'] = $tagid;
	$mtagcreditlog['uid'] = $_SGLOBAL['supe_uid'];;
	$mtagcreditlog['username'] = $_SGLOBAL['supe_username'];
	$mtagcreditlog['actiontype'] = "消费";
	$mtagcreditlog['action'] = $action;
	$mtagcreditlog['credit'] = -1*$updatecredit;
	$mtagcreditlog['dateline'] = $_SGLOBAL['timestamp'];
	
	inserttable('mtagcreditlog', $mtagcreditlog);
}


function updateattachmentlog($tagid, $action, $filepath, $message){
	global $_SGLOBAL,$_SC;
	
	//$_SGLOBAL['db']->query("UPDATE ".tname("mtag")." SET credit=credit - $updatecredit where tagid=$tagid");
	
	$mtagattachmentlog = array();
	$mtagattachmentlog['tagid'] = $tagid;
	$mtagattachmentlog['uid'] = $_SGLOBAL['supe_uid'];;
	$mtagattachmentlog['username'] = $_SGLOBAL['supe_username'];
	$mtagattachmentlog['credit'] = $action;
	$mtagattachmentlog['action'] = $action;
	$mtagattachmentlog['filepath'] = $filepath;
	$mtagattachmentlog['message'] = $message;
	$mtagattachmentlog['dateline'] = $_SGLOBAL['timestamp'];
	
	inserttable('mtagcreditlog', $mtagcreditlog);
}
?>