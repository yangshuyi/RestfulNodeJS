<?php
/*
 [UCenter Home] (C) 2007-2008 Comsenz Inc.
 $Id: function_delete.php 13001 2009-08-05 06:18:06Z zhengqingpeng $
 */

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

function loadtopadvertisementbylocation($locationid) {
	global $_SGLOBAL, $_SC;

	//只显示 第一
	//$qsql = "SELECT a.* FROM ".tname('advertisement')." a where a.location='".$locationid."' AND a.close = 0 ORDER BY a.credit DESC ";
	$qsql = "SELECT a.* FROM ".tname('advertisement')." a where a.location='".$locationid."' AND a.close = 0 ORDER BY a.lastpost DESC ";
	$query = $_SGLOBAL['db']->query($qsql);
	$advertisement = $_SGLOBAL['db']->fetch_array($query);
	return $advertisement;
}

function displayadvertisementbylocation($locationid) {
	global $_SGLOBAL, $_SC;

	$advertisement = loadtopadvertisementbylocation($locationid);
	if( empty($advertisement) ){
		return;
	}

	$advertisement = advertisementformmapper($advertisement);
	$advertisement = calculateadvertisementstatus($advertisement);

	$qsql = "SELECT ai.* FROM ".tname('advertisement_item')." ai where ai.advertisementid = '$advertisement[advertisementid]' ORDER BY ai.tab_index ASC";
	$query = $_SGLOBAL['db']->query($qsql);
	$advertisementitemlist = array();
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$advertisementitemlist[] = advertisementitemformmapper($value);
	}

	$advertisement['itemlist'] = $advertisementitemlist;

	return $advertisement;
}

function queryadvertisementbyid($advertisementid) {
	global $_SGLOBAL, $_SC;

	$qsql = "SELECT a.* FROM ".tname('advertisement')." a where a.advertisementid = $advertisementid ";
	$query = $_SGLOBAL['db']->query($qsql);
	$advertisement = $_SGLOBAL['db']->fetch_array($query);
	if( empty($advertisement) ){
		return;
	}

	$advertisement = advertisementformmapper($advertisement);

	$qsql = "SELECT ai.* FROM ".tname('advertisement_item')." ai where ai.advertisementid = '$advertisementid' ORDER BY ai.tab_index ASC";
	$query = $_SGLOBAL['db']->query($qsql);
	$advertisementitemlist = array();
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$value = advertisementitemformmapper($value);
		$advertisementitemlist[] = $value;
	}

	$advertisement['itemlist'] = $advertisementitemlist;

	return $advertisement;
}

function calculateadvertisementstatus($advertisement){
	global $_SGLOBAL, $_SC;

	if( !empty($advertisement['close']) ){
		$advertisement['statusdisp'] = "已关闭";
		$advertisement['statusnote'] = "如要使用，请手工开启该宣传～";
	}
	else{
		$topadvertisement = loadtopadvertisementbylocation($advertisement[location]);
		if( !empty($topadvertisement) ){
			if($advertisement['advertisementid'] == $topadvertisement['advertisementid']){
				$advertisement['statusdisp'] = "展示中";
				$advertisement['statusnote'] = "正在展示中。。。";
			}
			else{
				$advertisement['statusdisp'] = "未被展示";
				$advertisement['statusnote'] = "你的宣传被其他作品比下去啦，请增加你宣传的权重值～";
			}
		}
		else{
			$advertisement['statusdisp'] = "展示中";
			$advertisement['statusnote'] = "正在展示中。。。";
		}
	}
	return $advertisement;
}

function loadadvertisementbyid($advertisementid){
	global $_SGLOBAL, $_SC;

	$qsql="SELECT a.* FROM ".tname("advertisement")." a WHERE a.advertisementid=$advertisementid";
	$query = $_SGLOBAL['db']->query($qsql);
	$value = $_SGLOBAL['db']->fetch_array($query);

	return $value;
}

function loadadvertisementitembyid($advertisementid, $itemid){
	global $_SGLOBAL, $_SC;

	$qsql="SELECT ai.* FROM ".tname("advertisement_item")." ai WHERE ai.advertisementid=$advertisementid AND ai.itemid=$itemid";
	$query = $_SGLOBAL['db']->query($qsql);
	$value = $_SGLOBAL['db']->fetch_array($query);

	return $value;
}

function advertisementformmapper($advertisement){
	global $_SGLOBAL, $_SC;

	$advertisement['fromdatedisp'] = sgmdate('Y-m-d', $advertisement['fromdate']);
	$advertisement['todatedisp'] = sgmdate('Y-m-d', $advertisement['todate']);
	$advertisement['lastpostdisp'] = sgmdate('Y-m-d', $advertisement['lastpost']);
	return $advertisement;
}

function advertisementitemformmapper($advertisementitem){
	global $_SGLOBAL, $_SC;

	include_once(S_ROOT.'./data/data_advertisementitemclass.php');

	$advertisementitem['tab_classname'] = $_SGLOBAL['advertisementitemclass'][$advertisementitem['tab_classid']]['classname'];

	if( !empty($advertisementitem['pic']) ) {
		$advertisementitem['picpath'] = $_SC['attachdir'].'./'.$advertisementitem['pic'];
	}
	
	if( !empty($advertisementitem['video']) ) {
		$swfindex=stripos($advertisementitem['video'],".swf");
		$mp3index=stripos($advertisementitem['video'],".mp3");
		$wmaindex=stripos($advertisementitem['video'],".wma");
		if($swfindex>0){
			$advertisementitem['videopath'] = mtag_adventisement_bbcode("[flash]".$advertisementitem['video']."[/flash]");
		}
		elseif($mp3index>0){
			$advertisementitem['videopath'] = mtag_adventisement_bbcode("[flash=media]".$advertisementitem['video']."[/flash]");
		}
		elseif($wmaindex>0){
			$advertisementitem['videopath'] = mtag_adventisement_bbcode("[flash=real]".$advertisementitem['video']."[/flash]");
		}
		else{
			$advertisementitem['videopath'] = $advertisementitem['video'];
		}
	}

	//次页广播剧链接及介绍
	if($advertisementitem['tab_classid'] == 3 && !empty($advertisementitem['relatedtopicid'])){
		include_once(S_ROOT.'./source/function_topic.php');

		$topic = loadtopicbyid($advertisementitem['relatedtopicid']);
		if( !empty($topic) && $topic['type']=='single'){
			$topic = topicsingleformmapper($topic);
			$advertisementitem['topic'] = $topic;
		}
	}

	//次页视频
	if($advertisementitem['tab_classid'] == 4 && !empty($advertisementitem['relatedvideoid'])){
		include_once(S_ROOT.'./source/function_video.php');

		$video = loadvideobyid($advertisementitem['relatedvideoid']);
		if( !empty($video) ){
			$video = videoformmapper($video);
			$advertisementitem['video'] = $video;
		}
	}

	//群组链接及介绍
	if($advertisementitem['tab_classid'] == 5 && !empty($advertisementitem['relatedmtagid'])){
		include_once(S_ROOT.'./source/function_mtag.php');

		$mtag = loadmtagbyid($advertisementitem['relatedmtagid']);
		if( !empty($mtag) ){
			$mtag = mtagformmapper($mtag);
			$advertisementitem['mtag'] = $mtag;
		}
	}

	//广播剧专辑链接及介绍
	if($advertisementitem['tab_classid'] == 6 && !empty($advertisementitem['relatedtopicalbumid'])){
		include_once(S_ROOT.'./source/function_topic.php');

		$topicalbum = loadtopicalbumbyid($advertisementitem['relatedtopicalbumid']);
		if( !empty($topicalbum) ){
			$topicalbum=topicalbumformmapper($topicalbum);
			$itemlist=loadalbumitemlist($topicid);
			$topicalbum['itemlist']=$itemlist;
			$advertisementitem['topicalbum'] = $topicalbum;
		}
	}
	return $advertisementitem;
}

//视频标签处理
function mtag_adventisement_bbcode($message) {
	$message = preg_replace("/\[flash\=?(media|real)*\](.+?)\[\/flash\]/ie", " mtag_adventisement_flash('\\2', '\\1')", $message);
	return $message;
}

//视频
function  mtag_adventisement_flash($swf_url, $type='') {
	$width = '100%';
	$height = '100%';
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