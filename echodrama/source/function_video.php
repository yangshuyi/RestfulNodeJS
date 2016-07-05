<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: function_repaste.php 13245 2009-08-25 02:01:40Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

// 查询广播剧标签
function queryvideolabel($videolabelsql){
	global $_SGLOBAL, $_SC;

	$videolabellist = array();
	$query = $_SGLOBAL['db']->query($videolabelsql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$videolabellist[] = $value;
	}
	return $videolabellist;
}

// 查询广播剧标签 - 特殊处理
function loadvideolabelbyvideoid($videoid){
	global $_SGLOBAL, $_SC;

	$videolabelsql= "SELECT vl.label, count(vl.id) AS labelweight FROM ".tname('videolabel')." vl WHERE vl.videoid=$videoid GROUP BY vl.label";
	
	$videolabellist = array();
	$minweight = 9999;
	$maxweight = 0;
	$totalweight = 0;
	$query = $_SGLOBAL['db']->query($videolabelsql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$totalweight = $totalweight + $value['labelweight'];
		if($maxweight < $value['labelweight']){
			$maxweight = $value['labelweight'];
		}
		elseif($minweight > $value['labelweight']){
			$minweight = $value['labelweight'];
		}
		$videolabellist[] = $value;
	}
	$videolabellist = buildlabel($videolabellist, $minweight, $maxweight, $totalweight, 3);
	return $videolabellist;
}

function updatesystemvideolabel($video){
	global $_SGLOBAL, $_SC;
	
	$delete_existvideolabel_sql="DELETE FROM ".tname('videolabel')." WHERE videoid='$video[videoid]' AND uid='0'";
	$_SGLOBAL['db']->query($delete_existvideolabel_sql);
	
	$videolabelarray=split('/',$video[label]);
	foreach($videolabelarray as $labelitem){
		$videolabel = array();
		$videolabel['videoid']=$video[videoid];
		$videolabel['uid']= 0;
		$videolabel['username']= '';
		$videolabel['label']=$labelitem;
		$videolabel['lastpost']=$_SGLOBAL['timestamp'];;
		inserttable("videolabel", $videolabel);
	}
}

function queryvideo($querysql){
	global $_SGLOBAL, $_SC;
	
	$list=array();

	$query = $_SGLOBAL['db']->query($querysql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$list[] = videoformmapper($value);
	}
	return $list;
}

function loadvideobyid($videoid){
	global $_SGLOBAL, $_SC;
	
	$qsql="SELECT c.* FROM ".tname("video")." c WHERE c.videoid='$videoid'";
	$query = $_SGLOBAL['db']->query($qsql);
	$value = $_SGLOBAL['db']->fetch_array($query);
	
	return $value;
}

function videoformmapper($video){
	global $_SGLOBAL, $_SC;

	include_once(S_ROOT.'./data/data_videoproductclass.php');
	$video['productclassname']=$_SGLOBAL['videoproductclass'][$video['productclassid']]['classname'];
	
	$video['dispproducedate'] = sgmdate('Y-m-d', $video['producedate']);
	$video['displastpost'] = sgmdate('Y-m-d', $video['lastpost']);
	$video['dispdateline'] = sgmdate('Y-m-d', $video['dateline']);
	
	$group="";
	if(!empty($video[director])){
		$group.="导演:$video[director]&nbsp;";
	}
	if(!empty($video[producer])){
		$group.="监制:$video[producer]&nbsp;";
	}
	if(!empty($video[provider])){
		$group.="片源:$video[provider]&nbsp;";
	}
	if(!empty($video[captionsmaker])){
		$group.="字幕:$video[captionsmaker]&nbsp;";
	}
	if(!empty($video[linesmaker])){
		$group.="台词整理:$video[linesmaker]&nbsp;";
	}
	if(!empty($video[effector])){
		$group.="后期制作:$video[effector]&nbsp;";
	}
	if(!empty($video[photographer])){
		$group.="美工:$video[photographer]&nbsp;";
	}
	$video['group']= $group;
	
	$video['hint'] = $video[subject].'&#10';
	$video['hint'] .=$video[productclassname].',由'.$video[club].'发布&#10';
	$video['hint'] .='CAST :&#10'.$video[cast].'&#10';
	$video['hint'] .='STAFF:&#10'.$video[group].'&#10';
	$video['hint'] .='发布时间:'.$video[producedate];
	
	$video['pollnum']=$video['poll_1']+$video['poll_2']+$video['poll_3']+$video['poll_4']+$video['poll_5'];
	if($video['pollnum']>0){
		$video['pollsum']=$video['poll_1']+$video['poll_2']*2+$video['poll_3']*3+$video['poll_4']*4+$video['poll_5']*5;
		$video['pollavg']=round($video['pollsum']/$video['pollnum'],1);
		$video['polllevel']=round($video['pollavg']*2,0)*5;
		$video['poll_1_rate']=round($video['poll_1']*100/$video['pollnum'],1);
		$video['poll_2_rate']=round($video['poll_2']*100/$video['pollnum'],1);
		$video['poll_3_rate']=round($video['poll_3']*100/$video['pollnum'],1);
		$video['poll_4_rate']=round($video['poll_4']*100/$video['pollnum'],1);
		$video['poll_5_rate']=round($video['poll_5']*100/$video['pollnum'],1);
	}
	
	return $video;
}

//删除视频
function deletevideos($videoids, $deletemessage) {
	global $_SGLOBAL, $_SC;

	include_once(S_ROOT.'./source/function_cp.php');
	
	//数据
	$list = array();
	$qsql="SELECT * FROM ".tname('video')." WHERE videoid IN (".simplode($videoids).")";
	$list=queryvideo($qsql);
		
	foreach($list as $video) {
		if(empty($video)){
			continue;
		}
		$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE id = $video[videoid] AND idtype='videoid'");
		$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE id = $video[videoid] AND idtype='videoid'");
		$_SGLOBAL['db']->query("DELETE FROM ".tname('clickuser')." WHERE id = $video[videoid] AND idtype='videoid'");
		$_SGLOBAL['db']->query("DELETE FROM ".tname('videopoll')." WHERE videoid=$video[videoid]");
		$_SGLOBAL['db']->query("DELETE FROM ".tname('videouser')." WHERE videoid=$video[videoid]");
		$_SGLOBAL['db']->query("DELETE FROM ".tname('video')." WHERE videoid = $video[videoid]");
				
		updatevideospace($video['uid']);
		updatevideoreward($video['uid'],'video_delete');
		
		if(!empty($deletemessage)){
			$notification="</br>抱歉，你上传的视频&nbsp;编号$video[videoid]&nbsp;作品名&nbsp;$video[subject]&nbsp;已被删除。";
			if(!empty($deletemessage)){
				$notification=$notification."</br>删除理由：".$deletemessage;
			}
			notification_add($video[uid],"video_delete",$notification,0);
		}
	}
	return ;
}


function updatevideospace($uid,$videoid){
	global $_SGLOBAL, $_SC;
	
	//更新用户所f发布的视频统计
	$sql="update ".tname('space')." s set s.videonum=(select count(c.videoid) from ".tname('video')." c where c.uid=$uid) where s.uid=$uid";
	$_SGLOBAL['db']->query($sql);
}

function updatevideoreward($uid, $action){
	global $_SGLOBAL,$_SC;
    
	//积分 $action, $update=1, $uid=0, $needle='', $setcookie = 1
	$reward = getreward($action, 1, $uid);
}

//视频标签处理
function video_bbcode($message) {
	$message = preg_replace("/\[flash\=?(media|real)*\](.+?)\[\/flash\]/ie", "video_flash('\\2', '\\1')", $message);
	return $message;
}
//视频
function video_flash($swf_url, $type='') {
	$width = '510';
	$height = '390';
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

