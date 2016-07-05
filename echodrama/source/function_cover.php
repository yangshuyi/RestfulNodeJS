<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: function_repaste.php 13245 2009-08-25 02:01:40Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

function listhotcoverlabel(){
	global $_SGLOBAL, $_SC;

	$list=array();
	$querysql="SELECT cl.* FROM ".tname('coverlabel')." cl ORDER BY cl.joinnum desc LIMIT 0,10";
	$query = $_SGLOBAL['db']->query($querysql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$obj=array();
		$obj['classid'] = $value['classid'];
		$obj['classname'] = $value['classname'];
		$list[] = $obj;
	}
	return $list;
}

function listcoverlabel(){
	global $_SGLOBAL, $_SC;

	//include_once(S_ROOT.'./source/function_admincp.php');
	$list=array();
	$querysql="SELECT cl.* FROM ".tname('coverlabel')." cl ORDER BY cl.joinnum desc";
	$query = $_SGLOBAL['db']->query($querysql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$obj=array();
		$obj['classid'] = $value['classid'];
		$obj['classname'] = $value['classname'];
		$list[] = $obj;
	}
	return $list;
}


function updatecoverlabel($labelparam){
	global $_SGLOBAL, $_SC;

	if(empty($labelparam)){
		return;
	}
	$labelparam="/".$labelparam;
	
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
		$querysql="SELECT cl.* FROM ".tname('coverlabel')." cl where cl.classname='".$labelitem."' ";
		$query = $_SGLOBAL['db']->query($querysql);
		$coverlabel = $_SGLOBAL['db']->fetch_array($query);
		if(! $coverlabel){
			$coverlabel=Array();
			$coverlabel["classname"]=$labelitem;
			$coverlabel["joinnum"]=1;
			inserttable("coverlabel", $coverlabel);
		}else{
			$coverlabel["joinnum"]=$coverlabel["joinnum"]+1;
			updatetable('coverlabel', $coverlabel, array('classid'=>$coverlabel["classid"]));
		}
	}
	
//	$checkedlabelparam=substr($checkedlabelparam,0,strlen($checkedlabelparam)-1);
	
	return $checkedlabelparam;
}

function querycover($querysql){
	global $_SGLOBAL, $_SC;
	
	$list=array();

	$query = $_SGLOBAL['db']->query($querysql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$list[] = coverformmapper($value);
	}
	return $list;
}

function loadcoverbyid($coverid){
	global $_SGLOBAL, $_SC;
	
	$qsql="SELECT c.* FROM ".tname("cover")." c WHERE c.coverid='$coverid'";
	$query = $_SGLOBAL['db']->query($qsql);
	$value = $_SGLOBAL['db']->fetch_array($query);
	
	return $value;
}

function coverformmapper($cover){
	global $_SGLOBAL, $_SC;

	include_once(S_ROOT.'./data/data_coverproductclass.php');
	$cover['productclassname']=$_SGLOBAL['coverproductclass'][$cover['productclassid']]['classname'];
	
	$cover['dispproducedate'] = sgmdate('Y-m-d', $cover['producedate']);
	$cover['displastpost'] = sgmdate('Y-m-d', $cover['lastpost']);
	$cover['dispdateline'] = sgmdate('Y-m-d', $cover['dateline']);
	
	$cover['pollnum']=$cover['poll_1']+$cover['poll_2']+$cover['poll_3']+$cover['poll_4']+$cover['poll_5'];
	if($cover['pollnum']>0){
		$cover['pollsum']=$cover['poll_1']+$cover['poll_2']*2+$cover['poll_3']*3+$cover['poll_4']*4+$cover['poll_5']*5;
		$cover['pollavg']=round($cover['pollsum']/$cover['pollnum'],1);
		$cover['polllevel']=round($cover['pollavg']*2,0)*5;
		$cover['poll_1_rate']=round($cover['poll_1']*100/$cover['pollnum'],1);
		$cover['poll_2_rate']=round($cover['poll_2']*100/$cover['pollnum'],1);
		$cover['poll_3_rate']=round($cover['poll_3']*100/$cover['pollnum'],1);
		$cover['poll_4_rate']=round($cover['poll_4']*100/$cover['pollnum'],1);
		$cover['poll_5_rate']=round($cover['poll_5']*100/$cover['pollnum'],1);
	}
	return $cover;
}

//删除翻唱
function deletecovers($coverids, $deletemessage) {
	global $_SGLOBAL, $_SC;
	
	include_once(S_ROOT.'./source/function_cp.php');
	
	//数据
	$list = array();
	$qsql="SELECT * FROM ".tname('cover')." WHERE coverid IN (".simplode($coverids).")";
	$list=querycover($qsql);
		
	foreach($list as $value) {
		if(empty($value)){
			continue;
		}
		$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE id = $value[coverid] AND idtype='coverid'");
		$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE id = $value[coverid] AND idtype='coverid'");
		$_SGLOBAL['db']->query("DELETE FROM ".tname('clickuser')." WHERE id = $value[coverid] AND idtype='coverid'");
		$_SGLOBAL['db']->query("DELETE FROM ".tname('coverpoll')." WHERE coverid=$value[coverid]");
		$_SGLOBAL['db']->query("DELETE FROM ".tname('coveruser')." WHERE coverid=$value[coverid]");
		$_SGLOBAL['db']->query("DELETE FROM ".tname('cover')." WHERE coverid = $value[coverid]");
				
		updatecoverspace($value['uid']);
		updatecoverreward($value['uid'],'cover_delete');
		
		if(!empty($deletemessage)){
			$notification="</br>抱歉，你上传的翻唱&nbsp;编号$value[coverid]&nbsp;作品名&nbsp;$value[subject]&nbsp;已被删除。";
			if(!empty($deletemessage)){
				$notification=$notification."</br>删除理由：".$deletemessage;
			}
			notification_add($value[uid],"cover_delete",$notification,0);
		}
	}
	
	return true;
}

function updatecoverspace($uid,$coverid){
	global $_SGLOBAL, $_SC;
	
	//更新用户所f发布的翻唱统计
	$sql="update ".tname('space')." s set s.covernum=(select count(c.coverid) from ".tname('cover')." c where c.uid=$uid) where s.uid=$uid";
	$_SGLOBAL['db']->query($sql);
}

function updatecoverreward($uid, $action){
	global $_SGLOBAL,$_SC;
    
	//积分 $action, $update=1, $uid=0, $needle='', $setcookie = 1
	$reward = getreward($action, 1, $uid);
}

//视频标签处理
function cover_bbcode($message) {
	$message = preg_replace("/\[flash\=?(media|real)*\](.+?)\[\/flash\]/ie", "cover_flash('\\2', '\\1')", $message);
	return $message;
}
//视频
function cover_flash($swf_url, $type='') {
	$width = '570';
	$height = '400';
	if ($type == 'media') {
		$html = '<object classid="clsid:6bf52a52-394a-11d3-b153-00c04f79faa6" width="'.$width.'" height="'.$height.'">
			<param name="autostart" value="0">
			<param name="url" value="'.$swf_url.'">
			<embed autostart="false" src="'.$swf_url.'" type="video/x-ms-wmv" width="'.$width.'" height="'.$height.'" controls="imagewindow" console="cons"></embed>
			</object>';
	} elseif ($type == 'real') {
		$html = '<object classid="clsid:cfcdaa03-8be4-11cf-b84b-0020afbbccfa" width="'.$width.'" height="'.$height.'">
			<param name="autostart" value="0">
			<param name="src" value="'.$swf_url.'">
			<param name="controls" value="Imagewindow,controlpanel">
			<param name="console" value="cons">
			<embed autostart="false" src="'.$swf_url.'" type="audio/x-pn-realaudio-plugin" width="'.$width.'" height="'.$height.'" controls="controlpanel" console="cons"></embed>
			</object>';
	} else {
		$html = '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="'.$width.'" height="'.$height.'">
			<param name="movie" value="'.$swf_url.'">
			<param name="WMode" value="Transparent">
			<param name="allowscriptaccess" value="always">
			<embed wmode="transparent" src="'.$swf_url.'" type="application/x-shockwave-flash" width="'.$width.'" height="'.$height.'" allowfullscreen="true" allowscriptaccess="always"></embed>
			</object>';
	}
	return $html;
}
?>
