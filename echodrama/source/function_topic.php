<?php
/*
 [UCenter Home] (C) 2007-2008 Comsenz Inc.
 $Id: function_delete.php 13001 2009-08-05 06:18:06Z zhengqingpeng $
 */

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

// 查询广播剧标签
function querytopiclabel($topiclabelsql){
	global $_SGLOBAL, $_SC;

	$topiclabellist = array();
	$query = $_SGLOBAL['db']->query($topiclabelsql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$topiclabellist[] = $value;
	}
	return $topiclabellist;
}

// 查询广播剧标签 - 特殊处理
function loadtopiclabelbytopicid($topicid){
	global $_SGLOBAL, $_SC;

	$topiclabelsql= "SELECT tl.label, count(tl.id) AS labelweight FROM ".tname('topiclabel')." tl WHERE tl.topicid=$topicid GROUP BY tl.label";
	
	$topiclabellist = array();
	$minweight = 9999;
	$maxweight = 0;
	$totalweight = 0;
	$query = $_SGLOBAL['db']->query($topiclabelsql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$totalweight = $totalweight + $value['labelweight'];
		if($maxweight < $value['labelweight']){
			$maxweight = $value['labelweight'];
		}
		elseif($minweight > $value['labelweight']){
			$minweight = $value['labelweight'];
		}
		$topiclabellist[] = $value;
	}
	$topiclabellist = buildlabel($topiclabellist, $minweight, $maxweight, $totalweight, 3);
	return $topiclabellist;
}

function updatesystemtopiclabel($topic){
	global $_SGLOBAL, $_SC;
	
	$delete_existtopiclabel_sql="DELETE FROM ".tname('topiclabel')." WHERE topicid='$topic[topicid]' AND uid='0'";
	$_SGLOBAL['db']->query($delete_existtopiclabel_sql);
	
	$topiclabelarray=split('/',$topic[label]);
	foreach($topiclabelarray as $labelitem){
		$topiclabel = array();
		$topiclabel['topicid']=$topic[topicid];
		$topiclabel['uid']= 0;
		$topiclabel['username']= '';
		$topiclabel['label']= trim($labelitem);
		$topiclabel['lastpost']=$_SGLOBAL['timestamp'];;
		inserttable("topiclabel", $topiclabel);
	}
}

// 查询广播剧预告
function loadtopicforecastbyid($topicforecastid){
	global $_SGLOBAL, $_SC;
	 
	$qsql="SELECT tf.* FROM ".tname("topic_forecast")." tf WHERE tf.topicforecastid=$topicforecastid";

	$query = $_SGLOBAL['db']->query($qsql);
	$value = $_SGLOBAL['db']->fetch_array($query);

	return $value;
}

// 查询广播剧预告
function querytopicforecast($querysql){
	global $_SGLOBAL, $_SC;
	$list=array();
	$query = $_SGLOBAL['db']->query($querysql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$list[] = topicforecastformmapper($value);
	}
	return $list;
}

// 广播剧预告映射
function topicforecastformmapper($topicforecast){
	global $_SGLOBAL, $_SC;
	include_once(S_ROOT.'./data/data_productclass.php');
	
	$topicforecast['typename']='广播剧发布预告';
	$topicforecast['producedatedisp'] = $topicforecast['producedate']?sgmdate('Y-m-d', $topicforecast['producedate']):'';
	$topicforecast['datelinedisp'] = $topicforecast['dateline']?sgmdate('Y-m-d', $topicforecast['dateline']):'';
		
	$topicforecast['productclassname']=$_SGLOBAL['productclass'][$topicforecast['productclassid']]['classname'];
		
	$group="";
	if(!empty($topicforecast[director])){
		$group.="导演:$topicforecast[director]&nbsp;";
	}
	if(!empty($topicforecast[producer])){
		$group.="监制:$topicforecast[producer]&nbsp;";
	}
	if(!empty($topicforecast[cehua])){
		$group.="策划:$topicforecast[cehua]&nbsp;";
	}
	if(!empty($topicforecast[yuanzhu])){
		$group.="原著:$topicforecast[yuanzhu]&nbsp;";
	}
	if(!empty($topicforecast[writer])){
		$group.="编剧:$topicforecast[writer]&nbsp;";
	}
	if(!empty($topicforecast[effector])){
		$group.="后期:$topicforecast[effector]&nbsp;";
	}
	if(!empty($topicforecast[photographer])){
		$group.="美工:$topicforecast[photographer]&nbsp;";
	}
	$topicforecast['group']= $group;
	
	return $topicforecast;
}

//删除广播剧预告
function deletetopicforecasts($topicforecastids, $deletemessage) {
	global $_SGLOBAL, $_SC;

	include_once(S_ROOT.'./source/function_cp.php');

	//数据
	$list = array();
	$managetopic = checkperm('managetopic');
	$qsql="SELECT * FROM ".tname('topic_forecast')." WHERE topicforecastid IN (".simplode($topicforecastids).")";
	$list=querytopicforecast($qsql);

	foreach($list as $value) {
		if(empty($value)){
			continue;
		}

		$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE idtype='topicforecastid' and id=$value[topicforecastid]");
		$_SGLOBAL['db']->query("DELETE FROM ".tname('topic_forecast_user')." WHERE topicforecastid=$value[topicforecastid]");
		$_SGLOBAL['db']->query("DELETE FROM ".tname('topic_forecast')." WHERE topicforecastid=$value[topicforecastid]");
		
		
		//消耗积分100 并发送消息给上传者
		updatetopicreward($value['uid'], 'topicforecast_discard');
		$notification="</br>抱歉，你上传的广播剧预告&nbsp;编号$value[topicforecastid]&nbsp;剧名&nbsp;$value[subject]&nbsp;已被删除,系统自动扣除你100积分。";
		
		notification_add($value[uid],"topicforecast_confirm",$notification,0);
	}

	return true;
}

// 查询广播剧预告关注用户
function querytopicforecastuserlist($topicid){
	global $_SGLOBAL, $_SC;

	$qsql = "SELECT tfu.* FROM ".tname('topic_forecast_user')." tfu, ".tname('topic_forecast')." tf WHERE tf.topicid = '$topicforecastid' AND tf.topicforecastid = tfu.topicforecastid";
	$topicforecastuserlist = array();
	$query = $_SGLOBAL['db']->query($qsql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$topicforecastuserlist[] = $value;
	}
	return $topiclabellist;
}

// 每周推荐广播剧查询
//TODO should be delete 
function loadtodaytopicrecommand(){
	global $_SGLOBAL, $_SC;
	 
	$topicrecommandsql="SELECT tr.* FROM ".tname('topic_recommand')." tr WHERE tr.startdate<".$_SGLOBAL[timestamp]." ORDER BY tr.startdate desc LIMIT 0,1";
	$topicrecommandquery = $_SGLOBAL['db']->query($topicrecommandsql);
	$topicrecommand = $_SGLOBAL['db']->fetch_array($topicrecommandquery);
	if(!empty($topicrecommand))
	$topic=topicsingleformmapper(loadtopicsinglebyid($topicrecommand['topicid']));
	return $topic;
}

function loadtodaytopicrecommandlist($loadnum){
	global $_SGLOBAL, $_SC;
	 
	$topicrecommandsql="SELECT t.* FROM ".tname('topic')." t, ".tname('topic_recommand')." tr WHERE t.topicid = tr.topicid AND t.protalforbidden=0 ORDER BY tr.startdate desc LIMIT 0,$loadnum";
	$list = querytopic($topicrecommandsql);
	
	return $list;
}


// 七天内广播剧查询
function querynewtopiclist(){
	global $_SGLOBAL, $_SC;
	 
	$timestamp = $_SGLOBAL['timestamp'] - 24*3600*7;
	$qsql="SELECT t.* FROM ".tname("topic")." t WHERE t.dateline>=$timestamp";
	$list = querytopic($qsql);

	return $list;
}



function queryrecommand($querysql){
	global $_SGLOBAL, $_SC;
	 
	include_once(S_ROOT.'./data/data_productclass.php');

	$list=array();

	$query = $_SGLOBAL['db']->query($querysql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($value["startdate"]>$_SGLOBAL[timestamp]){
			$value["future"]=1;
		}else{
			$value["future"]=0;
		}
		$value['productclassname']=$_SGLOBAL['productclass'][$value['productclassid']]['classname'];

		$list[] = $value;
	}
	return $list;
}

function loadtopicrecommandbyid($topcirecommandid){
	global $_SGLOBAL, $_SC;
	
	$qsql="SELECT tc.* FROM ".tname("topic_recommand")." tc WHERE tc.topicrecommandid=$topcirecommandid";
	$query = $_SGLOBAL['db']->query($qsql);
	$value = $_SGLOBAL['db']->fetch_array($query);	
	
	return $value;
}

//topicadditioninfo
function querytopicadditioninfobytopic($topicid){
	global $_SGLOBAL, $_SC;
	
	$qsql="SELECT tai.* FROM ".tname("topic_additioninfo")." tai WHERE tai.topicid = $topicid";
	
	$query = $_SGLOBAL['db']->query($qsql);
	$topicadditioninfo = $_SGLOBAL['db']->fetch_array($query);	

	if( empty($topicadditioninfo) ) {
		$topicadditioninfo = array();
	}

	return $topicadditioninfo;
}

//犀利剧评
function querytopicthreadbytopicid($topicid){
	global $_SGLOBAL, $_SC;
	
	$qsql="SELECT thread.* FROM ".tname("mtag_thread")." thread, ".tname("topic_thread")." topicthread  WHERE topicthread.threadid = thread.tid AND topicthread.topicid = $topicid";
	$list=array();

	$query = $_SGLOBAL['db']->query($qsql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$list[] = $value;
	}
	return $list;
}

//相关资源
function querytopicattachmentbytopicid($topicid){
	global $_SGLOBAL, $_SC;
	
	$qsql="SELECT ta.* FROM ".tname("topicattachment")." ta WHERE ta.topicid=$topicid";
	$list=array();

	$query = $_SGLOBAL['db']->query($qsql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$list[] = topicattachmentformmapper($value);
	}
	return $list;
}

function loadtopicattachmentbyid($topicattachmentid){
	global $_SGLOBAL, $_SC;
	
	$qsql="SELECT ta.* FROM ".tname("topicattachment")." ta WHERE ta.topicattachmentid=$topicattachmentid";
	$query = $_SGLOBAL['db']->query($qsql);
	$value = $_SGLOBAL['db']->fetch_array($query);	
	
	return $value;
}

function topicattachmentformmapper($topicattachment){
	global $_SGLOBAL, $_SC;
	
	include_once(S_ROOT.'./data/data_attachmentclass.php');
	
	$topicattachment['attachmentclassname'] = $_SGLOBAL['attachmentclass'][$topicattachment['attachmentclassid']]['classname'];
	$topicattachment['attachmentclassimagepath'] = $_SGLOBAL['attachmentclass'][$topicattachment['attachmentclassid']]['imagepath'];
	
	$topicattachment['datelinedisp'] = $topicattachment['dateline']?sgmdate('Y-m-d', $topicattachment['dateline']):'';
	
	if( $topicattachment['attachmentclassid'] == 6){
		$topicattachment['attachmentfilepath']= $topicattachment['attachment'];
	}
	else{
		$topicattachment['attachmentfilepath']= $_SC['attachdir'].'./'.$topicattachment['attachment'];
	}	
	return $topicattachment;
}

function deletetopicattachment($topicattachmentid) {
	global $_SGLOBAL, $_SC;

	include_once(S_ROOT.'./source/function_cp.php');

	//数据
	$topicattachment = loadtopicattachmentbyid($topicattachmentid);

	if(empty($topicattachment)){
		return;
	}
	
	$topicattachment = topicattachmentformmapper($topicattachment);

	if(file_exists($topicattachment['attachmentfilepath'])){
		unlink($topicattachment['attachmentfilepath']);
	}
	
	$_SGLOBAL['db']->query("DELETE FROM ".tname('topicattachment')." WHERE topicattachmentid=$topicattachmentid");
	return true;
}

// 完结专辑关联广播剧查询
function loadalbumitemlist($topicalbumid){
	global $_SGLOBAL, $_SC;

	$qsql="SELECT t.* FROM ".tname("topic")." t, ".tname("topic_album")." ta WHERE t.type='single' and t.auditstate=2 and t.topicid=ta.topicid and ta.topicalbumid=$topicalbumid";
	$list=array();

	$query = $_SGLOBAL['db']->query($qsql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$list[] = topicsingleformmapper($value);
	}
	return $list;
}

function loadalbumlistbyitem($topicid){
	global $_SGLOBAL, $_SC;

	$qsql="SELECT t.* FROM ".tname("topic")." t, ".tname("topic_album")." ta WHERE t.type='album' and t.topicid=ta.topicalbumid and ta.topicid = $topicid";
	$list=array();

	$query = $_SGLOBAL['db']->query($qsql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$list[] = topicalbumformmapper($value);
	}
	return $list;
}

// 完结专辑查询
function queryalbum($querysql){
	global $_SGLOBAL, $_SC;
	 
	$list=array();

	$query = $_SGLOBAL['db']->query($querysql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$list[] = topicalbumformmapper($value);
	}
	return $list;
}

// 查询
function loadtopicbyid($topicid){
	global $_SGLOBAL, $_SC;
	 
	$qsql="SELECT t.* FROM ".tname("topic")." t WHERE t.topicid=$topicid";
	$query = $_SGLOBAL['db']->query($qsql);
	$value = $_SGLOBAL['db']->fetch_array($query);

	return $value;
}

// 完结专辑查询
function loadtopicalbumbyid($topicalbumid){
	global $_SGLOBAL, $_SC;
	 
	$qsql="SELECT t.* FROM ".tname("topic")." t WHERE t.topicid=$topicalbumid";
	$query = $_SGLOBAL['db']->query($qsql);
	$value = $_SGLOBAL['db']->fetch_array($query);
	if( $value['type'] == 'album' ){
		return $value;
	}
	else if( $value['type'] == 'single' && $value['singtonalbum']==1 ){
		return $value;
	}
	return;
}

// 查询广播剧
function loadtopicsinglebyid($topicid){
	global $_SGLOBAL, $_SC;
	 
	$qsql="SELECT t.* FROM ".tname("topic")." t WHERE t.type='single' and t.topicid=$topicid";

	$query = $_SGLOBAL['db']->query($qsql);
	$value = $_SGLOBAL['db']->fetch_array($query);

	return $value;
}

// 查询广播剧
function querytopic($querysql){
	global $_SGLOBAL, $_SC;

	include_once(S_ROOT.'./data/data_productclass.php');
	$list=array();

	$query = $_SGLOBAL['db']->query($querysql);
	$index=0;
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$value['index']= $index;
		if($value['type']=='single'){
			$list[] = topicsingleformmapper($value);
		}else if($value['type']=='album'){
			$list[] = topicalbumformmapper($value);
		}

		$index++;
	}
	return $list;
}

// 完结广播剧专辑映射
function topicalbumformmapper($topicalbum){
	global $_SGLOBAL, $_SC;
	include_once(S_ROOT.'./data/data_productclass.php');
	
	if( $value['type'] == 'single' && $value['singtonalbum']==1 ){
		return topicsingleformmapper($topicalbum);
	}
	
	$topicalbum['typename']='完结专辑';
	//$topicalbum['dispnumber']=$_SGLOBAL['productclass'][$topicalbum['productclassid']]['typename'].'-A-'.str_pad($topicalbum['number']."", 4, "0", STR_PAD_LEFT);
	$topicalbum['dispnumber']=$_SGLOBAL['productclass'][$topicalbum['productclassid']]['typename'].'-A-'.$topicalbum['topicid'];
	$topicalbum['subjectlimit'] = getstr($topicalbum['subject'], 30, 0, 0, 0, 0, -1);
	
	$topicalbum['pic'] = $_SC['attachdir'].'./'.$topicalbum['pic'];
	$topicalbum['pic_mobile'] = '../'.$topicalbum['pic'];
	$topicalbum['picthumb'] = $topicalbum['pic'].'.thumb.jpg';
	$topicalbum['picthumb_mobile'] = '../'.$topicalbum['picthumb'];
		
	$topicalbum['picexists']=is_file($topicalbum['pic']);
	$topicalbum['picgenthumbexists'] = $topicalbum['picthumb'];
	if($topicalbum['picgenthumbexists']){
		$data = getimagesize($topicalbum['pic']);
		if( $data[0]<200 && $data[1]<200){
			$topicalbum['picgenthumbvalid']=0;
		}
		else{
			$topicalbum['picgenthumbvalid']=1;
		}
	}
	else{
		$topicalbum['picgenthumbvalid']=0;
	}

	if(!is_file($topicalbum['picthumb'])){
		$topicalbum['picthumb'] = $topicalbum['pic'];
	}
//	$topic['picthumb'] = $topic['pic'];
	if($topicalbum['picexists']){
		$data = getimagesize($topicalbum['pic']);
		if( $data[0]<570 && $data[1]<570){
			$topicalbum['picresizable']=0;
		}
		else{
			$topicalbum['picresizable']=1;
		}
	}
	else{
		$topicalbum['picresizable']=1;
	}
	
	$topicalbum['producedate'] = $topicalbum['producedate']?sgmdate('Y-m-d', $topicalbum['producedate']):'';
	$topicalbum['lastpost'] = $topicalbum['lastpost']?sgmdate('Y-m-d', $topicalbum['lastpost']):'';
	$topicalbum['dateline'] = $topicalbum['dateline']?sgmdate('Y-m-d', $topicalbum['dateline']):'';
	$topicalbum['endtime'] = $topicalbum['endtime']?sgmdate('Y-m-d', $topicalbum['endtime']):'';
	$topicalbum['productclassname']=$_SGLOBAL['productclass'][$topicalbum['productclassid']]['classname'];
	$topicalbum['productclasstype']=$_SGLOBAL['productclass'][$topicalbum['productclassid']]['typename'];

	$topicalbum['pollnum']=$topicalbum['poll_1']+$topicalbum['poll_2']+$topicalbum['poll_3']+$topicalbum['poll_4']+$topicalbum['poll_5'];
	if($topicalbum['pollnum']>0){
		$topicalbum['pollsum']=$topicalbum['poll_1']+$topicalbum['poll_2']*2+$topicalbum['poll_3']*3+$topicalbum['poll_4']*4+$topicalbum['poll_5']*5;
		$topicalbum['pollavg']=round($topicalbum['pollsum']/$topicalbum['pollnum']);
		$topicalbum['polllevel']=round($topicalbum['pollavg']*2,0)*5;
		$topicalbum['poll_1_rate']=round($topicalbum['poll_1']*100/$topicalbum['pollnum'],1);
		$topicalbum['poll_2_rate']=round($topicalbum['poll_2']*100/$topicalbum['pollnum'],1);
		$topicalbum['poll_3_rate']=round($topicalbum['poll_3']*100/$topicalbum['pollnum'],1);
		$topicalbum['poll_4_rate']=round($topicalbum['poll_4']*100/$topicalbum['pollnum'],1);
		$topicalbum['poll_5_rate']=round($topicalbum['poll_5']*100/$topicalbum['pollnum'],1);
	}
	
	return $topicalbum;
}

function topicsingleformmapper($topic){
	global $_SGLOBAL, $_SC;

	include_once(S_ROOT.'./data/data_productclass.php');
	 
	$topic['typename']='广播剧';
	$topic['dispnumber']=$_SGLOBAL['productclass'][$topic['productclassid']]['typename'].'-S-'.$topic['topicid'];
	$topic['subjectlimit'] = getstr($topic['subject'], 24, 0, 0, 0, 0, -1);

	//原图
	$topic['picpath'] = $topic['pic'];
	$topic['picthumbpath'] = $topic['pic'].'.thumb.jpg';
	
	$topic['pic'] = $_SC['attachdir'].'./'.$topic['pic'];
	$topic['pic_mobile'] = '../'.$topic['pic'];
	//缩略图 225*300
	$topic['picthumb'] = $topic['pic'].'.thumb.jpg';
	$topic['picthumb_mobile'] = '../'.$topic['picthumb'];
	//首页展示 400*265
	$topic['picrecommand'] = $topic['pic'].'.recommand.jpg';
	$topic['picrecommand_mobile'] = '../'.$topic['picrecommand'];
	
	
	$topic['picexists']=is_file($topic['pic']);
	
	//这块逻辑可以考虑删除
	$topic['picgenthumbexists'] = $topic['picthumb'];
	if($topic['picgenthumbexists']){
		$data = getimagesize($topic['pic']);
		if( $data[0]<200 && $data[1]<200){
			$topic['picgenthumbvalid']=0;
		}
		else{
			$topic['picgenthumbvalid']=1;
		}
	}
	else{
		$topic['picgenthumbvalid']=0;
	}

	if(!is_file($topic['picthumb'])){
		$topic['picthumb'] = $topic['pic'];
	}
//	$topic['picthumb'] = $topic['pic'];

	//广播剧显示界面图片调整
	if($topic['picexists']){
		$data = getimagesize($topic['pic']);
		if( $data[0]<570 && $data[1]<570){
			$topic['picresizable']=0;
		}
		else{
			$topic['picresizable']=1;
		}
	}
	else{
		$topic['picresizable']=1;
	}
	$topic['producedate'] = $topic['producedate']?sgmdate('Y-m-d', $topic['producedate']):'';
	$topic['lastpost'] = $topic['lastpost']?sgmdate('Y-m-d', $topic['lastpost']):'';
	$topic['dateline'] = $topic['dateline']?sgmdate('Y-m-d', $topic['dateline']):'';
	$topic['endtime'] = $topic['endtime']?sgmdate('Y-m-d', $topic['endtime']):'';
	$topic['productclassname']=$_SGLOBAL['productclass'][$topic['productclassid']]['classname'];
	$topic['productclasstype']=$_SGLOBAL['productclass'][$topic['productclassid']]['typename'];
	$topic['auditdate'] = $topic['auditdate']?sgmdate('Y-m-d', $topic['auditdate']):'';

	$group="";
	if(!empty($topic[director])){
		$group.="导演:$topic[director] ";
	}
	if(!empty($topic[producer])){
		$group.="监制:$topic[producer] ";
	}
	if(!empty($topic[cehua])){
		$group.="策划:$topic[cehua] ";
	}
	if(!empty($topic[yuanzhu])){
		$group.="原著:$topic[yuanzhu] ";
	}
	if(!empty($topic[writer])){
		$group.="编剧:$topic[writer] ";
	}
	if(!empty($topic[effector])){
		$group.="后期:$topic[effector] ";
	}
	if(!empty($topic[photographer])){
		$group.="美工:$topic[photographer] ";
	}
	if(!empty($topic[propagandizer])){
		$group.="宣传:$topic[propagandizer] ";
	}
	
	$topic['group']= $group;
	
	$topic['hint'] = $topic[subject].'&#10';
	$topic['hint'] .=$topic[productclassname].',由'.$topic[club].'发布&#10';
	$topic['hint'] .='CAST :&#10'.$topic[cast].'&#10';
	$topic['hint'] .='STAFF:&#10'.$topic[group].'&#10';
	$topic['hint'] .='发布时间:'.$topic[producedate];
			
	$topic['productpath']= $_SC['attachdir'].'./'.$topic['product'];
	$topic['productexists']=true;
	
	if( $topic['remoteid']=='1' ){
		if( $topic['topicid']>=1000000 && $topic['topicid']<=1000999){
			$topic['mp3path']="http://s2.shaowei.info:8000/attachment/topic/topic_$topic[topicid].mp3";
		}
		elseif( $topic['topicid']>=1001000 && $topic['topicid']<=1001999){
			$topic['mp3path']="http://s3.shaowei.info:8000/attachment/topic/topic_$topic[topicid].mp3";
		}
		elseif( $topic['topicid']>=1002000 && $topic['topicid']<=1002999){
			$topic['mp3path']="http://s4.shaowei.info:8000/attachment/topic/topic_$topic[topicid].mp3";
		}
	}
	else{
		//	$topic['mp3path']= $_SC['attachdir'].'./'.urlencode(iconv("gb2312", "UTF-8", $topic['product']));
		$topic['mp3path']= $_SC['attachdir'].'./'.$topic['product'];	
	}

	if(!empty($topic['kugoupath'])){
		if( $topic['topicid']>=1000200 && $topic['topicid']<=1000299){
			$topic['kugoupathdisp'] = "http://disk.kugou.com/player/0/2/0/0/default/520/".$topic['kugoupath']."/mini.swf";
		}
		else if( $topic['topicid']>=1000300 && $topic['topicid']<=1000399){
			$topic['kugoupathdisp'] = "http://disk.kugou.com/player/0/7/0/0/default/520/".$topic['kugoupath']."/mini.swf";
		}
		else if( $topic['topicid']>=1000500 && $topic['topicid']<=1000599){
			$topic['kugoupathdisp'] = "http://disk.kugou.com/player/0/7/0/0/default/520/".$topic['kugoupath']."/mini.swf";
		}
		else if( $topic['topicid']>=1000600 && $topic['topicid']<=1000699){
			$topic['kugoupathdisp'] = "http://disk.kugou.com/player/0/0/0/0/default/520/".$topic['kugoupath']."/mini.swf";
		}
		else if( $topic['topicid']>=1000700 && $topic['topicid']<=1000799){
			$topic['kugoupathdisp'] = "http://disk.kugou.com/player/0/9/0/0/default/520/".$topic['kugoupath']."/mini.swf";
		}
		else if( $topic['topicid']>=1000800 && $topic['topicid']<=1000899){
			$topic['kugoupathdisp'] = "http://disk.kugou.com/player/0/3/0/0/default/520/".$topic['kugoupath']."/mini.swf";
		}
		else if( $topic['topicid']>=1000900 && $topic['topicid']<=1000999){
			$topic['kugoupathdisp'] = "http://disk.kugou.com/player/0/7/0/0/default/520/".$topic['kugoupath']."/mini.swf";
		}
		else if( $topic['topicid']>=1001000 && $topic['topicid']<=1001099){
			$topic['kugoupathdisp'] = "http://disk.kugou.com/player/0/5/0/0/default/520/".$topic['kugoupath']."/mini.swf";
		}
		else if( $topic['topicid']>=1001100 && $topic['topicid']<=1001199){
			$topic['kugoupathdisp'] = "http://disk.kugou.com/player/0/2/0/0/default/520/".$topic['kugoupath']."/mini.swf";
		}
		else if( $topic['topicid']>=1001200 && $topic['topicid']<=1001299){
			$topic['kugoupathdisp'] = "http://disk.kugou.com/player/0/1/0/0/default/520/".$topic['kugoupath']."/mini.swf";
		}
		else if( $topic['topicid']>=1001300 && $topic['topicid']<=1001399){
			$topic['kugoupathdisp'] = "http://disk.kugou.com/player/0/8/0/0/default/520/".$topic['kugoupath']."/mini.swf";
		}
		else if( $topic['topicid']>=1001400 && $topic['topicid']<=1001499){
			$topic['kugoupathdisp'] = "http://disk.kugou.com/player/0/3/0/0/default/520/".$topic['kugoupath']."/mini.swf";
		}
		else if( $topic['topicid']>=1001500 && $topic['topicid']<=1001599){
			$topic['kugoupathdisp'] = "http://disk.kugou.com/player/0/5/0/0/default/520/".$topic['kugoupath']."/mini.swf";
		}
		else if( $topic['topicid']>=1001600 && $topic['topicid']<=1001699){
			$topic['kugoupathdisp'] = "http://disk.kugou.com/player/0/4/0/0/default/520/".$topic['kugoupath']."/mini.swf";
		}
		else if( $topic['topicid']>=1001700 && $topic['topicid']<=1001799){
			$topic['kugoupathdisp'] = "http://disk.kugou.com/player/0/4/0/0/default/520/".$topic['kugoupath']."/mini.swf";
		}
		else if( $topic['topicid']>=1001800 && $topic['topicid']<=1001899){
			$topic['kugoupathdisp'] = "http://disk.kugou.com/player/0/6/0/0/default/520/".$topic['kugoupath']."/mini.swf";
		}
		else if( $topic['topicid']>=1001900 && $topic['topicid']<=1001999){
			$topic['kugoupathdisp'] = "http://disk.kugou.com/player/0/6/0/0/default/520/".$topic['kugoupath']."/mini.swf";
		}
		else if( $topic['topicid']>=1002000 && $topic['topicid']<=1002099){
			$topic['kugoupathdisp'] = "http://disk.kugou.com/player/0/4/0/0/default/520/".$topic['kugoupath']."/mini.swf";
		}
		else if( $topic['topicid']>=1002100 && $topic['topicid']<=1002199){
			$topic['kugoupathdisp'] = "http://disk.kugou.com/player/0/7/0/0/default/520/".$topic['kugoupath']."/mini.swf";
		}
		else{
			$topic['kugoupathdisp'] = "http://disk.kugou.com/player/0/2/0/0/default/520/".$topic['kugoupath']."/mini.swf";
		}
		
	}
	
	$topic['pollnum']=$topic['poll_1']+$topic['poll_2']+$topic['poll_3']+$topic['poll_4']+$topic['poll_5'];
	if($topic['pollnum']>0){
		$topic['pollsum']=$topic['poll_1']+$topic['poll_2']*2+$topic['poll_3']*3+$topic['poll_4']*4+$topic['poll_5']*5;
		$topic['pollavg']=round($topic['pollsum']/$topic['pollnum'],1);
		$topic['polllevel']=round($topic['pollavg']*2,0)*5;
		$topic['poll_1_rate']=round($topic['poll_1']*100/$topic['pollnum'],1);
		$topic['poll_2_rate']=round($topic['poll_2']*100/$topic['pollnum'],1);
		$topic['poll_3_rate']=round($topic['poll_3']*100/$topic['pollnum'],1);
		$topic['poll_4_rate']=round($topic['poll_4']*100/$topic['pollnum'],1);
		$topic['poll_5_rate']=round($topic['poll_5']*100/$topic['pollnum'],1);
	}
	realname_set($topic['uid'], $topic['username']);

	return $topic;
}

function topicmembersearchitemformmapper($topic){
	global $_SGLOBAL, $_SC;
//http://www.echodrama.com/space.php?subject=&label=&club=&director=&writer=&producer=&effector=&cast=&productclassid=-1
//&orderby=t.replydateline+DESC&ac=topic&do=topic&view=single&searchsubmit=%CB%D1%CB%F7
	$commonsearchparam="space.php?do=topic&ac=topic&view=single&showfiler=1";
	if(!empty($topic[cast])){
		$topiccastarray=split('/',$topic[cast]);
		foreach($topiccastarray as $castitem){
			$castitem = trim($castitem);
			$cast_searchitem .= "<a title=\"查询{$castitem}配音的其他作品\" href=\"$commonsearchparam&cast=$castitem\" target=\"_blank\">$castitem</a>/";
		}
		$topic['cast_searchitem'] = substr($cast_searchitem,0,-1);
	}
	if(!empty($topic[producer])){
		$topicproducerarray=split('/',$topic[producer]);
		foreach($topicproducerarray as $produceritem){
			$produceritem = trim($produceritem);
			$producer_searchitem .= "<a title=\"查询{$produceritem}监制的其他作品\" href=\"$commonsearchparam&producer=$produceritem\" target=\"_blank\">$produceritem</a>/";
		}
		$topic['producer_searchitem'] = substr($producer_searchitem,0,-1);
	}
	if(!empty($topic[writer])){
		$topicwriterarray=split('/',$topic[writer]);
		foreach($topicwriterarray as $writeritem){
			$writeritem = trim($writeritem);
			$writer_searchitem .= "<a title=\"查询{$writeritem}编剧的其他作品\" href=\"$commonsearchparam&writer=$writeritem\" target=\"_blank\">$writeritem</a>/";
		}
		$topic['writer_searchitem'] = substr($writer_searchitem,0,-1);
	}
	if(!empty($topic[effector])){
		$topiceffectorarray=split('/',$topic[effector]);
		foreach($topiceffectorarray as $effectoritem){
			$effectoritem = trim($effectoritem);
			$effector_searchitem .= "<a title=\"查询{$effectoritem}制作的其他作品\" href=\"$commonsearchparam&effector=$effectoritem\" target=\"_blank\">$effectoritem</a>/";
		}
		$topic['effector_searchitem'] = substr($effector_searchitem,0,-1);
	}
	if(!empty($topic[director])){
		$topicdirectorarray=split('/',$topic[director]);
		foreach($topicdirectorarray as $directoritem){
			$directoritem = trim($directoritem);
			$director_searchitem .= "<a title=\"查询{$directoritem}执导的其他作品\" href=\"$commonsearchparam&director=$directoritem\" target=\"_blank\">$directoritem</a>/";
		}
		$topic['director_searchitem'] = substr($director_searchitem,0,-1);
	}
	if(!empty($topic[cehua])){
		$topiccehuaarray=split('/',$topic[cehua]);
		foreach($topiccehuaarray as $cehuaitem){
			$cehuaitem = trim($cehuaitem);
			$cehua_searchitem .= "<a title=\"查询{$cehuaitem}策划的其他作品\" href=\"$commonsearchparam&cehua=$cehuaitem\" target=\"_blank\">$cehuaitem</a>/";
		}
		$topic['cehua_searchitem'] = substr($cehua_searchitem,0,-1);
	}	
	if(!empty($topic[photographer])){
		$topicphotographerarray=split('/',$topic[photographer]);
		foreach($topicphotographerarray as $photographeritem){
			$photographeritem = trim($photographeritem);
			$photographer_searchitem .= "<a title=\"查询{$photographeritem}涂鸦的其他作品\" href=\"$commonsearchparam&photographer=$photographeritem\" target=\"_blank\">$photographeritem</a>/";
		}
		$topic['photographer_searchitem'] = substr($photographer_searchitem,0,-1);
	}
	if(!empty($topic[propagandizer])){
		$topicpropagandizerarray=split('/',$topic[propagandizer]);
		foreach($topicpropagandizerarray as $propagandizeritem){
			$propagandizeritem = trim($propagandizeritem);
			$propagandizer_searchitem .= "<a title=\"查询{$propagandizeritem}宣传的其他作品\" href=\"$commonsearchparam&propagandizer=$propagandizeritem\" target=\"_blank\">$propagandizeritem</a>/";
		}
		$topic['propagandizer_searchitem'] = substr($propagandizer_searchitem,0,-1);
	}
	
	
	return $topic;
}

function topicmemberweiboitemformmapper($topic){
	global $_SGLOBAL, $_SC;

	if(!empty($topic[cast])){
		$topiccastarray=split('/',$topic[cast]);
		$index=1;
		foreach($topiccastarray as $castitem){
			if(empty($castitem)) break;
			
			if( $index <= 10){
				$cast_10_weiboitem .= $castitem.",";
				$cast_15_weiboitem .= $castitem.",";
				$cast_all_weiboitem .= $castitem.",";
			}
			elseif( $index <= 15){
				$cast_15_weiboitem .= $castitem.",";
				$cast_all_weiboitem .= $castitem.",";
			}
			else{
				$cast_all_weiboitem .= $castitem.",";
			}
			$index = $index+1;
		}
		$topic['cast_10_weiboitem'] = substr($cast_10_weiboitem,0,-1);
		$topic['cast_15_weiboitem'] = substr($cast_15_weiboitem,0,-1);
		$topic['cast_all_weiboitem'] = substr($cast_all_weiboitem,0,-1);
		$topic['cast_weiboitem'] = $topic['cast_all_weiboitem'];
	}
	
	$group="";
	if(!empty($topic[director])){
		$topicdirectorarray=split('/',$topic[director]);
		foreach($topicdirectorarray as $directoritem){
			if(!empty($directoritem)) $director_weiboitem .= $directoritem.",";
		}
		$group.="导演:".substr($director_weiboitem,0,-1).",";
	}
	if(!empty($topic[producer])){
		$topicproducerarray=split('/',$topic[producer]);
		foreach($topicproducerarray as $produceritem){
			if(!empty($produceritem)) $producer_weiboitem .= $produceritem.",";
		}
		
		if($producer_weiboitem == $director_weiboitem){
			
		}
		else{
			$group.="监制:".substr($producer_weiboitem,0,-1).",";
		}
	}
	if(!empty($topic[cehua])){
		$topiccehuaarray=split('/',$topic[cehua]);
		foreach($topiccehuaarray as $cehuaitem){
			if(!empty($cehuaitem)) $cehua_weiboitem .= $cehuaitem.",";
		}
		if($cehua_weiboitem == $director_weiboitem){
			
		}
		else if($cehua_weiboitem == $producer_weiboitem){
			
		}
		else{
			$group.="策划:".substr($cehua_weiboitem,0,-1).",";
		}
		
	}
	if(!empty($topic[writer])){
		$topicwriterarray=split('/',$topic[writer]);
		foreach($topicwriterarray as $writeritem){
			if(!empty($writeritem)) $writer_weiboitem .= $writeritem.",";
		}
		$group.="编剧:".substr($writer_weiboitem,0,-1).",";
	}
	if(!empty($topic[effector])){
		$topiceffectorarray=split('/',$topic[effector]);
		foreach($topiceffectorarray as $effectoritem){
			$effector_weiboitem .= $effectoritem.",";
		}
		$group.="后期:".substr($effector_weiboitem,0,-1).",";
	}	
	if(!empty($topic[photographer])){
		$topicphotographerarray=split('/',$topic[photographer]);
		foreach($topicphotographerarray as $photographeritem){
			if(!empty($photographeritem))  $photographer_weiboitem .= $photographeritem.",";
		}
		$group.="美工:".substr($photographer_weiboitem,0,-1).",";
	}	

//	if(!empty($topic[yuanzhu])){
//		$group.="原著:$topic[yuanzhu] ";
//	}
	$topic['group_weiboitem'] = $group;
	
	return $topic;
}


//删除广播剧
function deletetopics($topicids, $deletemessage) {
	global $_SGLOBAL, $_SC;

	include_once(S_ROOT.'./source/function_cp.php');

	//数据
	$list = array();
	$managetopic = checkperm('managetopic');
	$qsql="SELECT * FROM ".tname('topic')." WHERE topicid IN (".simplode($topicids).")";
	$list=querytopic($qsql);

	foreach($list as $value) {
		if(empty($value)){
			continue;
		}

		if(file_exists($value['productpath'])){
			unlink($value['productpath']);
		}
		$picpath=pic_get($value['pic'], 0, $value['remote']);
		if(file_exists($picpath)){
			unlink($picpath);
		}
		$thumbpath=$picpath.'.thumb.jpg';
		if(file_exists($thumbpath)){
			unlink($thumbpath);
		}
		$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE idtype='topicid' and id=$value[topicid]");
		$_SGLOBAL['db']->query("DELETE FROM ".tname('topicuser')." WHERE topicid=$value[topicid]");
		$_SGLOBAL['db']->query("DELETE FROM ".tname('topic_recommand')." WHERE topicid=$value[topicid]");
		$_SGLOBAL['db']->query("DELETE FROM ".tname('topicpoll')." WHERE topicid=$value[topicid]");
		$_SGLOBAL['db']->query("DELETE FROM ".tname('topic_album')." WHERE topicid=$value[topicid]");
		$_SGLOBAL['db']->query("DELETE FROM ".tname('topic_thread')." WHERE topicid=$value[topicid]");
		$_SGLOBAL['db']->query("DELETE FROM ".tname('topic_static_weekly_2011')." WHERE topicid=$value[topicid]");
		$_SGLOBAL['db']->query("DELETE FROM ".tname('topic_static_weekly_2012')." WHERE topicid=$value[topicid]");
		$_SGLOBAL['db']->query("DELETE FROM ".tname('topiclabel')." WHERE topicid=$value[topicid]");
		
		$_SGLOBAL['db']->query("DELETE FROM ".tname('topic_additioninfo')." WHERE topicid=$value[topicid]");
		$_SGLOBAL['db']->query("DELETE FROM ".tname('topic')." WHERE topicid=$value[topicid]");
		$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE idtype='topicid' AND id=$value[topicid]");

		updatetopicspace($value['uid']);
		updatetopicreward($value['uid'],'topic_delete');

		$notification="</br>抱歉，你上传的广播剧&nbsp;编号$value[topicid]&nbsp;剧名&nbsp;$value[subject]&nbsp;已被删除。";
		if(!empty($deletemessage)){
			$notification=$notification."</br>删除理由：".$deletemessage;
		}
		notification_add($value[uid],"topic_delete",$notification,0);
	}

	return true;
}

function batchupdateproductpath($fromtopicid,$totopicid, $topicprefix){
	global $_SGLOBAL,$_SC;
	 
	include_once(S_ROOT.'./source/function_cp.php');

	//数据
	$managetopic = checkperm('managetopic');

	$qsql="SELECT * FROM ".tname('topic')." WHERE topicid >= $fromtopicid AND topicid<=$totopicid";
	$query = $_SGLOBAL['db']->query($qsql);
	while ($topic = $_SGLOBAL['db']->fetch_array($query)) {
	
		if($topic['audiotype']!=1){
			continue;
		}
		
		$product = $topic['product'];
		$productpath = $_SC['attachdir'].'./'.$topic['product'];

		
		$newproduct = "/topic/".$topicprefix.$topic['topicid'].".mp3";
		$newproductpath = $_SC['attachdir'].'./'.$newproduct;
		
		if(!is_file($productpath)){
			continue;
		}
		
		if($productpath == $newproductpath){
			continue;
		}
		
		
		if(empty($newproduct)) {
			showmessage('topic_product_empty');
		} 
		
		if(is_file($newproductpath)){
			showmessage('topic_product_exists');
		}
		
			
		rename($productpath,$newproductpath);
			
		$updateSql="UPDATE ".tname('topic')." SET product = '$newproduct' where topicid=$topic[topicid]";
		$_SGLOBAL['db']->query($updateSql);
	}
	return true;	
}

// 审核广播剧
function audittopics($topicids, $auditstate){
	global $_SGLOBAL,$_SC;
	 
	include_once(S_ROOT.'./source/function_cp.php');

	//数据
	$managetopic = checkperm('managetopic');
	$qsql="SELECT * FROM ".tname('topic')." WHERE topicid IN (".simplode($topicids).")";
	$query = $_SGLOBAL['db']->query($qsql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$value['auditstate'] = $auditstate;
		$value['auditdate'] = $_SGLOBAL['timestamp'];
		$value['auditmessage'] = $value['auditmessage']."</br></br>".$_SGLOBAL['supe_username'].":</br>无审核意见";
		$value['replydateline'] = $_SGLOBAL['timestamp'];
		
		$updateSql="UPDATE ".tname('topic')." SET auditstate = '$value[auditstate]', auditdate='$value[auditdate]', auditmessage='$value[auditmessage]' where topicid=$value[topicid]";
		$_SGLOBAL['db']->query($updateSql);
		//updatetable('topic', $value, array('topicid'=>$value[topicid]));

		$auditstatevalue=$_SGLOBAL[topicauditclass][$value[auditstate]][classname];
		$auditdatevalue=sgmdate('Y-m-d', $value[auditdate]);
		$auditmessage = $value[auditmessage];
		$notification="你上传的广播剧&nbsp;编号$value[topicid]&nbsp;剧名&nbsp;<a target='_blank' href='space.php?do=topic&topicid=$value[topicid]'>$value[subject]</a> ".$auditstatevalue."。 </br> 审核时间 </br> $auditdatevalue </br> 审核批注 </br> $auditmessage";
			
		if($value['auditstate']==1){
			//审核未通过
			notification_add($value[uid],"topic_audit","</br>抱歉，".$notification,0);
		}elseif($value['auditstate']==2){
			//审核通过
			notification_add($value[uid],"topic_audit","</br>您好，".$notification,0);
				
			//产生动态
			include_once(S_ROOT.'./source/function_feed.php');
			feed_publish($value['topicid'], 'topicid', 0);
		}
	}
	return true;
}

// 整理thumb
function genpicthumbs($topicids){
	global $_SGLOBAL,$_SC;
	 
	include_once(S_ROOT.'./source/function_cp.php');

	//数据
	$managetopic = checkperm('managetopic');
	if(count($topicids)>1){
		$qsql="SELECT * FROM ".tname('topic')." WHERE topicid IN (".simplode($topicids).")";
	}else{
		$qsql="SELECT * FROM ".tname('topic')." WHERE topicid = '$topicids'";
	}
	$query = $_SGLOBAL['db']->query($qsql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {

		$picpath = pic_get($value['pic'], 0, $value['remote']);
		$thumbpath = $picpath.'.thumb.jpg';

		if(file_exists($thumbpath)){
			unlink($thumbpath);
		}

		makethumb($picpath);
	}
	return true;
}

function updatetopicspace($uid,$topicid){
	global $_SGLOBAL, $_SC;

	//更新用户所收藏的广播剧统计
	$sql="update ".tname('space')." s set s.topicnum=(select count(tu.topicid) from ".tname('topicuser')." tu where tu.uid=$uid) where s.uid=$uid";
	$_SGLOBAL['db']->query($sql);


	//更新该广播剧所有的收藏用户统计
	if(!empty($topicid)){
		$sql="update ".tname('topic')." t set t.joinnum=(select count(tu.uid) from ".tname('topicuser')." tu where tu.topicid=$topicid) where t.topicid=$topicid";
		$query = $_SGLOBAL['db']->query($sql);
	}
}

function updatetopicreward($uid, $action){
	global $_SGLOBAL,$_SC;

	//积分 $action, $update=1, $uid=0, $needle='', $setcookie = 1
	$reward = getreward($action, 1, $uid);
}

// 同步广播剧
function buildtopicmessage($topic, $withLink = true){
	
	include_once(S_ROOT.'./source/function_cvweibo.php');
	
	$num = 0;
	$maxlen = 140;
	
	$cast_10_weiboitem = "";
	$cast_15_weiboitem = "";
	$cast_all_weiboitem = "";
	$group_weiboitem = "";
	$group_array = array();

	if(!empty($topic[cast])){
		$topiccastarray=split('/',$topic[cast]);
		$index=1;
		foreach($topiccastarray as $castitem){
			if(empty($castitem)) break;
			
			$castitem = trim($castitem);
			$castitem = cvmapper($castitem);
			if( $index <= 10){
				$cast_10_weiboitem .= $castitem.",";
				$cast_15_weiboitem .= $castitem.",";
				$cast_all_weiboitem .= $castitem.",";
			}
			elseif( $index <= 15){
				$cast_15_weiboitem .= $castitem.",";
				$cast_all_weiboitem .= $castitem.",";
			}
			else{
				$cast_all_weiboitem .= $castitem.",";
			}
			$index = $index+1;
		}
		$cast_10_weiboitem = substr($cast_10_weiboitem,0,-1);
		$cast_15_weiboitem = substr($cast_15_weiboitem,0,-1);
		$cast_all_weiboitem = substr($cast_all_weiboitem,0,-1);
	}
	
	if(!empty($topic[director])){
		$topicdirectorarray=split('/',$topic[director]);
		foreach($topicdirectorarray as $directoritem){
			if(empty($directoritem)) break;
			
			$directoritem = trim($directoritem);
			$directoritem = cvmapper($directoritem);
			
			$group_array[$directoritem] = $directoritem;
		}
	}
	if(!empty($topic[producer])){
		$topicproducerarray=split('/',$topic[producer]);
		foreach($topicproducerarray as $produceritem){
			if(empty($produceritem)) break;
			
			$produceritem = trim($produceritem);
			$produceritem = cvmapper($produceritem);
			
			$group_array[$produceritem] = $produceritem;
		}
	}
	if(!empty($topic[cehua])){
		$topiccehuaarray=split('/',$topic[cehua]);
		foreach($topiccehuaarray as $cehuaitem){
			if(empty($cehuaitem)) break;
			
			$cehuaitem = trim($cehuaitem);
			$cehuaitem = cvmapper($cehuaitem);
			
			$group_array[$cehuaitem] = $cehuaitem;
		}
	}
	if(!empty($topic[writer])){
		$topicwriterarray=split('/',$topic[writer]);
		foreach($topicwriterarray as $writeritem){
			if(empty($writeritem)) break;
			
			$writeritem = trim($writeritem);
			$writeritem = cvmapper($writeritem);
			
			$group_array[$writeritem] = $writeritem;
		}
	}
	if(!empty($topic[effector])){
		$topiceffectorarray=split('/',$topic[effector]);
		foreach($topiceffectorarray as $effectoritem){
			if(empty($effectoritem)) break;
			
			$effectoritem = trim($effectoritem);
			$effectoritem = cvmapper($effectoritem);
	
			$group_array[$effectoritem] = $effectoritem;
		}
	}	
	if(!empty($topic[photographer])){
		$topicphotographerarray=split('/',$topic[photographer]);
		foreach($topicphotographerarray as $photographeritem){
			if(empty($photographeritem)) break;
			
			$photographeritem = trim($photographeritem);
			$photographeritem = cvmapper($photographeritem);
			
			$group_array[$photographeritem] = $photographeritem;
		}
	}
	if(!empty($topic[propagandizer])){
		$topicpropagandizerarray=split('/',$topic[propagandizer]);
		foreach($topicpropagandizerarray as $propagandizeritem){
			if(empty($propagandizeritem)) break;
			
			$propagandizeritem = trim($propagandizeritem);
			$propagandizeritem = cvmapper($propagandizeritem);
			
			$group_array[$propagandizeritem] = $propagandizeritem;
		}
	}	
	
	$subject_len = strlen($topic['subject']);
	$productclassname_len = strlen($topic['productclassname']);
	$club_len = strlen($topic['club']);
	$cast_len = strlen($cast_all_weiboitem);
	$group_len = strlen($group_weiboitem);
		
	if($topic['club']=='个人剧'){
		$text_title = $topic['productclassname']."-".$topic['subject'].";";
		$text_title_len = strlen($text_title);
	}
	else{
		$text_title = $topic['club']."发布:".$topic['productclassname']."-".$topic['subject'].";";
		$text_title_len = strlen($text_title);
	}
		
	if($withLink){
		$text_link = "收听链接:http://www.echodrama.com/space.php?do=topic&topicid=".$topic['topicid']." ";
		$text_link_len = 15;
	}
	else{
		$text_link = "";
		$text_link_len = 0;
	}

	foreach($group_array as $groupitem){
		$group_weiboitem .= $groupitem.",";
	} 
	
	$text_staff = "STAFF:".$group_weiboitem;
	$text_staff_len = strlen($text_staff);
		
	$text_cast_10 = "CAST:".$cast_10_weiboitem;
	$text_cast_10_len = strlen($text_cast_10);
		
	$text_cast_15 = "CAST:".$cast_15_weiboitem;
	$text_cast_15_len = strlen($text_cast_15);
		
	$text_cast_all = "CAST:".$cast_all_weiboitem;
	$text_cast_all_len = strlen($text_cast_all);
		
	$lenupdated = ceil( ($text_title_len + $text_link_len + $text_staff_len + $text_cast_all_len) / 2);
	if( ($maxlen - $lenupdated) > 0 ){
		$type=1;
		$text = $text_title . $text_link . $text_staff . $text_cast_all;
	}
	else
	{
		$lenupdated = ceil( ($text_title_len + $text_link_len + $text_staff_len + $text_cast_15_len) / 2);
		if( ($maxlen - $lenupdated) > 0 ){
			$type=2;
			$text = $text_title . $text_link . $text_staff . $text_cast_15;
		}
		else{
			$lenupdated = ceil( ($text_title_len + $text_link_len + $text_staff_len + $text_cast_10_len) / 2);
			if( ($maxlen - $lenupdated) > 0 ){
				$type=3;
				$text = $text_title . $text_link . $text_staff . $text_cast_10;
				$debug = $text_title_len ."-". $text_link_len ."-". $text_staff_len ."-". $text_cast_10_len;
			}
			else{
				$debug = $text_title_len ."-". $text_link_len ."-". $text_staff_len ."-". $text_cast_10_len;
				$type=4;
				$text = $text_title . $text_link;
			}
		}
	}
	
	return $text;		
}

function cnSubstr($str) {  
	$arr = array();
	
	$strlen = strlen($str);
		
	for($i = 0; $i < $strlen; $i++) {  
		if(ord(substr($str, $i, 1)) > 0xa0) {  
			$arr[] = substr($str, $i, 2);  
			$i++;  
		} else {  
			$arr[] = substr($str, $i, 1);  
		}  
	}  
	return $arr;  
}  

function buildtopicquantum() {
	global $_SGLOBAL, $_SC;
	
	$_SGLOBAL['db']->query("DELETE FROM ".tname('topic_quantum'));
	
	// 1=> subject 2=> label
	$topiclist = array();
	
	$topic_sql = "SELECT t.topicid, t.subject FROM ".tname('topic')." t WHERE t.type='single' and t.auditstate=2 ORDER BY t.topicid";
	$query = $_SGLOBAL['db']->query($topic_sql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$quantum = array();
		$chararray = cnSubstr($value[subject]);
		
		foreach($chararray as $charitem) {
			if($charitem==" " || $charitem=="《" || $charitem=="》" || $charitem=="'" || $charitem=="\\"){
				continue;
			}
			$quantum[$charitem] = 1;
		}
		$topiclist[$value['topicid']] = $quantum;
	}
	
	//广播剧标签
	$topiclabel_hot_sql="SELECT tl.topicid, tl.label FROM ".tname('topiclabel')." tl ORDER BY tl.topicid";
	$query = $_SGLOBAL['db']->query($topiclabel_hot_sql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$quantum = $topiclist[$value[topicid]];
		if(empty($quantum)){
			continue;
		}
		
		$quantum[$value['label']] = 2;
	}

	foreach($topiclist as $topicid => $quantum) {
		foreach($quantum as $quantumItem => $type) {
			if(empty($quantumItem)){
				continue;
			}
		
			$_SGLOBAL['db']->query("INSERT INTO ".tname('topic_quantum')." VALUES($topicid, '$quantumItem', $type)");
		}
	}
}

function batchupdatequantum($fromtopicid, $totopicid) {
	global $_SGLOBAL, $_SC;
	// 1=> subject 2=> label
	$topiclist = array();
	
	$qsql="SELECT * FROM ".tname('topic')." WHERE topicid >= $fromtopicid AND topicid<=$totopicid AND t.type='single' AND t.auditstate=2 ORDER BY t.topicid";
	$query = $_SGLOBAL['db']->query($qsql);
	while ($topic = $_SGLOBAL['db']->fetch_array($query)) {
		$topiclist[] = $topic;
	}
	
	foreach($topiclist as $topic) {
		$quantumCount = 0;
		
		$qsql="SELECT count(tq.quantum) AS quantumCount FROM ".tname('topic_quantum')." tq WHERE tq.topicid =  $topic[topicid]) ";
		$query = $_SGLOBAL['db']->query($qsql);
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			$quantumCount = $value[quantumCount];
		}	
		
		$quantumrelationlist = array();
		
		$qsql = "SELECT tq.topicid AS topicid, count(tq.quantum) AS relaquantumCount FROM ".tname('topic_quantum')." tq ";
		$qsql .= "WHERE tq.topicid != $topic[topicid] AND tq.quantum in ";
		$qsql .= " (SELECT tq1.quantum FROM ".tname('topic_quantum')." tq1 WHERE tq1.topicid =  $topic[topicid]) ";
		$qsql .= " GROUP BY tq.topicid";
		$query = $_SGLOBAL['db']->query($qsql);
		while ($item = $_SGLOBAL['db']->fetch_array($query)) {
			$relaquantumCount = $item[relaquantumCount];
			
			$level = $relaquantumCount / $quantumCount;
			if( $level <= 0.6 ) {
				continue;
			}
			
			$quantumrelation = array();
			$quantumrelation[topicid] = $topic[topicid];
			$quantumrelation[relatedtopicid] = $item[topicid];
			$quantumrelation[level] = $level;
			
			$quantumrelationlist[] = $quantumrelation;
		}	

		foreach($quantumrelationlist as $item) {
			inserttable("topic_quantum_relation", $item);
		}
	}
}


function batchupdateproducttype($fromtopicid,$totopicid){
	global $_SGLOBAL,$_SC;
	 
	include_once(S_ROOT.'./source/function_cp.php');

	//数据
	$managetopic = checkperm('managetopic');

	$topicimportlist = array();
	
	$qsql="SELECT * FROM ".tname('topic_import')." WHERE topicid >= $fromtopicid AND topicid<=$totopicid";
	$query = $_SGLOBAL['db']->query($qsql);
	while ($topicimport = $_SGLOBAL['db']->fetch_array($query)) {
	
		$topicimportlist[] = $topicimport;
	}
	
	foreach($topicimportlist as $topicimport) {
		$downloadtype = 1;
		if(!empty($topicimport[audiodownloadpath_rayfile])) {
			$downloadtype = 1;
		}elseif(!empty($topicimport[audiodownloadpath_115])) {
			$downloadtype = 2;
		}elseif(!empty($topicimport[audiodownloadpath_zhongzhuan])) {
			$downloadtype = 3;
		}
		
		$updateSql="UPDATE ".tname('topic')." SET audiotype = 2, ";
		$updateSql.=" audioplayerpathtype = 1, audioplayerpath_tudou = '$topicimport[audioplayerpath_tudou]', ";
		$updateSql.=" audiodownloadpathtype=$downloadtype, audiodownloadpath_rayfile='$topicimport[audiodownloadpath_rayfile]', ";
		$updateSql.=" audiodownloadpath_115='$topicimport[audiodownloadpath_115]', audiodownloadpath_zhongzhuan='$topicimport[audiodownloadpath_zhongzhuan]' ";
		$updateSql.=" where topicid=$topicimport[topicid] AND audiotype = 1 ";
		$_SGLOBAL['db']->query($updateSql);
	}
	return true;	
}
?>