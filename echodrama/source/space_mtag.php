<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_mtag.php 13083 2009-08-10 09:35:23Z xupeng $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

@include_once(S_ROOT.'./data/data_profield.php');
@include_once(S_ROOT.'./source/function_mtag.php');
@include_once(S_ROOT.'./source/function_thread.php');

$page = empty($_GET['page'])?1:intval($_GET['page']);
if($page<1) $page=1;
$id = empty($_GET['id'])?0:intval($_GET['id']);
$tagid = empty($_GET['tagid'])?0:intval($_GET['tagid']);
$fieldid = empty($_GET['fieldid'])?0:intval($_GET['fieldid']);

if( !empty($id) ) {
	$perpage = 20;
	$start = ($page-1)*$perpage;
	
	//检查开始数
	ckstart($start, $perpage);
	
	//栏目
	$list = array();
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('mtag')." WHERE fieldid='$id'"),0);
	if($count) {
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('mtag')." WHERE fieldid='$id' ORDER BY membernum DESC LIMIT $start,$perpage");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			if(empty($value['pic'])) {
				$value['pic'] = 'image/nologo.jpg';
			}
			$list[] = $value;
		}
	}
	
	//分页
	$multi = multi($count, $perpage, $page, "space.php?uid=$space[uid]&do=mtag&id=$id");

	$fieldtitle = $_SGLOBAL['profield'][$id]['title'];
	
	$sub_actives = array($id => ' class="active"');
	$fieldids = array($id => ' selected');

	$_TPL['css'] = 'thread';
	$searchengine_description=$value['tagname'].",".$value['fieldname']."群组,签名：".$value['message'];
	
	$nav_list = array();
	$nav_item = array();
	$nav_item['url'] = "space.php?do=mtag"; $nav_item['dispname'] = "我的圈子";
	$nav_list[] = $nav_item;
	
	include_once template("space_mtag_field");
} 
elseif( !empty($tagid) ) {
	if(empty($_GET['view'])) $_GET['view'] = 'index';
	$actives = array($_GET['view'] => ' class="active"');
	
	//指定的群组
	$mtag = loadmtagbyid($tagid);
	if(empty($mtag['tagid'])){
		showmessage('mtag_not_exist');
	}
	$mtag = mtagformmapper( $mtag );
	$membergrade = checkmembergrade($tagid, $_SGLOBAL['supe_uid']);
	$fansgrade = checkfansgrade($tagid, $_SGLOBAL['supe_uid']);
	
	$nav_list = array();
	$nav_item = array();
	$nav_item['url'] = "space.php?do=mtag"; $nav_item['dispname'] = "我的圈子";
	$nav_list[] = $nav_item;
		
	$nav_item = array();
	$nav_item['url'] = "space.php?do=mtag&view=all&fieldid=$mtag[fieldid]"; $nav_item['dispname'] = $mtag[fieldname];
	$nav_list[] = $nav_item;
		
	$nav_item = array();
	$nav_item['url'] = "space.php?do=mtag&tagid=$mtag[tagid]"; $nav_item['dispname'] = $mtag[tagname];
	$nav_list[] = $nav_item;
		
	if($_GET['view'] == 'index') {
		//资金池
		$qsql = "SELECT * FROM ".tname('mtagcreditlog')." WHERE tagid='$tagid' AND actiontype='注入' ORDER BY dateline DESC LIMIT 0,8";
		$creditloglist = querycreditlog($qsql);
		
		//新来的粉丝
		$latestfanslist = array();
		$qsql = "SELECT mf.*, s.ip AS userip, s.magichidden AS usermagichidden ";
		$qsql .= " FROM ".tname('mtagfans')." mf LEFT OUTER JOIN ".tname('session')." s ON s.uid=mf.uid ";
		$qsql .= " WHERE tagid='$tagid' AND deleteflag='0' AND fansgradeid=4 ORDER BY dateline DESC LIMIT 0,12";
		
		$query = $_SGLOBAL['db']->query($qsql);
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			$latestfanslist[] = $value;
		}
		
		//群组闲聊区
		$csql = "SELECT COUNT(*) FROM ".tname('post')." WHERE tagid='$tagid' AND tid='0' AND deleteflag='0' AND isthread='0' ";
		$discussionpostcount = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($csql), 0);
		if($discussionpostcount) {
			
			$perpage = 10;
			$count = $discussionpostcount;
		
			//分页
			if(intval($_GET['page'])<1){
				$page=intval($count/$perpage) + 1;
				$start = ($count - $perpage)>0?($count - $perpage):0;
			}
			else{
				$page = intval($_GET['page']);
				$start = ($page-1)*$perpage;
			}
		
			$qsql = "SELECT * FROM ".tname('post')." WHERE tagid='$tagid' AND tid='0' AND deleteflag='0' AND isthread='0' ORDER BY number LIMIT $start,$perpage";
			$discussionpostlist=querypost($qsql);
		
			$mpurl="space.php?do=mtag&view=index&tagid=$tagid";
			
			//显示分页
			$multi = multi($discussionpostcount, $perpage, $page, $mpurl);
		}
		
		$searchengine_description=$mtag['tagname'].",".$mtag['fieldname'].",签名：".$mtag['message'];
				
		$nav_item = array();
		$nav_item['url'] = "space.php?do=mtag&tagid=$mtag[tagid]&view=index"; $nav_item['dispname'] = "首页";
		$nav_list[] = $nav_item;
			
		include_once template("space_mtag_index");
	} 
	elseif($_GET['view'] == 'creditlog') {
		//资金池
		$creditloglist = querycreditlogbytagid($tagid);
		
		$searchengine_description=$mtag['tagname'].",".$mtag['fieldname'].",签名：".$mtag['message'].",群组资金额度：".$mtag['credit'];
		
		$nav_item = array();
		$nav_item['url'] = "space.php?do=mtag&tagid=$mtag[tagid]&view=creditlog"; $nav_item['dispname'] = "资金捐助情况";
		$nav_list[] = $nav_item;
	
		include_once template("space_mtag_creditlog");
	}
	elseif($_GET['view'] == 'members') {
		$members=array();
		
		$memberclasslist=listmemberclassbymtagid($mtag['tagid']);
		$membernames = "";
		foreach($memberclasslist as $memberclass) {
			$memberlist = querymemberbyclass($mtag['tagid'], $memberclass['classid']);
			$membernames.=$memberclass['classname'].":";
			foreach($memberlist as $member) {
				$membernames.=$member['realname'].",";
			}
			$members[$memberclass['classid']]=$memberlist;
		}
		
		$searchengine_description=$mtag['tagname'].",".$mtag['fieldname'].",成员：".$membernames;
		
		$nav_item = array();
		$nav_item['url'] = "space.php?do=mtag&tagid=$mtag[tagid]&view=members"; $nav_item['dispname'] = "成员列表";
		$nav_list[] = $nav_item;
	
		include_once template("space_mtag_members");
	} 
	elseif($_GET['view'] == 'products') {
		include_once(S_ROOT.'./data/data_producttype.php');
		include_once(S_ROOT.'./data/data_productclass.php');
		include_once(S_ROOT.'./data/data_coverproductclass.php');
		include_once(S_ROOT.'./data/data_videoproductclass.php');
				
		//分页
		$perpage = 30;
		$topiclist = array();
		$count = 0;
	
		$mpurl = "space.php?do=mtag&tagid=$tagid&view=products";
		
		//检索
		$wheresql = ' 1=1 ';
		$_GET['key'] = stripsearchkey($_GET['key']);
		if($_GET['key']) {
			$wheresql = $wheresql." AND mp.productname LIKE '%$_GET[key]%' ";
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
		
		if($_GET['orderby']=="productnameasc") {
			$ordersql .= " mp.productname asc ";
		   	$theurl .= "&orderby=productnameasc";
		}
		else if($_GET['orderby']=="productnamedesc") {
			$ordersql .= " mp.productname desc ";
		   	$theurl .= "&orderby=productnamedesc";
		}	
		else if($_GET['orderby']=="producedateasc") {
			$ordersql .= " producedate asc ";
		   	$theurl .= "&orderby=producedateasc";
		}	
		else if($_GET['orderby']=="producedatedesc") {
			$ordersql .= " producedate desc ";
		   	$theurl .= "&orderby=producedatedesc";
		}
		else{
			$ordersql .= " producedate desc ";
		   	$theurl .= "&orderby=producedatedesc";
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
			$querysql .= " CASE mp.producttype ";
			$querysql .= "   WHEN 1 THEN t.producedate ";
			$querysql .= "   WHEN 2 THEN c.producedate ";
			$querysql .= "   WHEN 3 THEN v.producedate ";
			$querysql .= " END  AS producedate";
			$querysql .= " FROM ".tname('mtagproduct')." mp ";
			$querysql .= " LEFT OUTER JOIN ".tname('topic')." t ON mp.productid = t.topicid AND mp.producttype = 1 ";
			$querysql .= " LEFT OUTER JOIN ".tname('cover')." c ON mp.productid = c.coverid AND mp.producttype = 2 ";
			$querysql .= " LEFT OUTER JOIN ".tname('video')." v ON mp.productid = v.videoid AND mp.producttype = 3 ";
			$querysql .= " WHERE mp.tagid='$tagid' AND $wheresql ORDER BY $ordersql LIMIT $start,$perpage";
			$query = $_SGLOBAL['db']->query($querysql);
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				$value['producttypename'] = $_SGLOBAL['producttype'][$value['producttype']]['classname'];
				$value['producedatedisp'] = empty($value['producedate'])?"":sgmdate('Y-m-d',$value['producedate']);
				
				if( $value['producttype'] == 1 ){
					$value['productclassname'] = $_SGLOBAL['productclass'][$value['topicproductclassid']]['classname'];
					$value['producturl'] = "space.php?do=topic&topicid=$value[productid]";
				}
				elseif( $value['producttype'] == 2 ){
					$value['productclassname'] = $_SGLOBAL['coverproductclass'][$value['coverproductclassid']]['classname'];
					$value['producturl'] = "space.php?do=cover&coverid=$value[productid]";
				}
				elseif( $value['producttype'] == 3 ){
					$value['productclassname'] = $_SGLOBAL['videoproductclass'][$value['videoproductclassid']]['classname'];
					$value['producturl'] = "space.php?do=video&videoid=$value[productid]";
				}
				
				$productlist[] = $value;
			}
	
			realname_get();
			
			$multi = multi($count, $perpage, $page, $mpurl);
		}
		
		$searchengine_description=$mtag['tagname'].",".$mtag['fieldname'].",作品列表：";
		foreach($productlist as $value) {
			$searchengine_description.=$value['subject'].",";
		}
		
		$nav_item = array();
		$nav_item['url'] = "space.php?do=mtag&tagid=$mtag[tagid]&view=products"; $nav_item['dispname'] = "作品列表";
		$nav_list[] = $nav_item;
	
		include_once template("space_mtag_products");
	} 
	elseif ($_GET['view'] == 'events') {
		
		$perpage = 10;
		$eventlist = array();
		$mpurl = "space.php?uid=$space[uid]&do=mtag&tagid=$tagid&view=event";

		// 获取招募职位信息
		@include_once(S_ROOT.'./data/data_jobclass.php');
		// 获取招募类型信息
		@include_once(S_ROOT.'./data/data_eventtype.php');
		
		$wheresql = "";
		if(!empty($_GET['typeid'])){
			$wheresql.="AND e.typeid='$_GET[typeid]'";
			$mpurl.="typeid=$_GET[typeid]";
		}
		if(!empty($_GET['classid'])){
			$wheresql.="AND e.classid='$_GET[classid]'";
			$mpurl.="classid=$_GET[classid]";
		}
		
		//检查开始数
		$page = empty($_GET['page'])?1:intval($_GET['page']);
		if($page<1) $page = 1;
		$start = ($page-1)*$perpage;
		ckstart($start, $perpage);

		$csql="SELECT * FROM ".tname("event")." e WHERE e.tagid='$tagid' $wheresql";
		$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($csql), 0);
		
		if($count) {
			$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname("event")." e WHERE e.tagid='$tagid' $wheresql ORDER BY starttime DESC LIMIT $start, $perpage");
			while($value=$_SGLOBAL['db']->fetch_array($query)) {
				if($value['poster']){
					$value['pic'] = pic_get($value['poster'], $value['thumb'], $value['remote']);
				} else {
					$value['pic'] = 'image/event/default.jpg';		
				}
				
				//招募分类
				$classname="";
				if($value['classid']){
					$arr=explode(',',$value['classid']);
					foreach ($arr as $classid) {
						$classname=$classname.$_SGLOBAL['jobclass'][$classid]['classname']." ";
					}
				}
				$value['classname']=$classname;
					
				$eventlist[] = $value;
			}
			//分页
			$multi = multi($eventnum, $perpage, $page, $mpurl);
		}
		
		$searchengine_description=$mtag['tagname'].",".$mtag['fieldname'].",招募活动列表：";
		foreach($eventlist as $value) {
			$searchengine_description.=$value['title'].",";
		}
		
		$nav_item = array();
		$nav_item['url'] = "space.php?do=mtag&tagid=$mtag[tagid]&view=events"; $nav_item['dispname'] = "招募列表";
		$nav_list[] = $nav_item;
	
		include_once template("space_mtag_events");
	} 
	elseif($_GET['view'] == 'tasks') {
		include_once(S_ROOT.'./data/data_mtagtaskimptclass.php');
				
		//分页
		$perpage = 10;
		$tasklist = array();
		$count = 0;
	
		$mpurl = "space.php?do=mtag&view=tasks&tagid=$tagid";
			
		//检索
		$wheresql = ' 1=1 ';
//		$_GET['key'] = stripsearchkey($_GET['key']);
//		if($_GET['key']) {
//			$wheresql = $wheresql." AND mp.productname LIKE '%$_GET[key]%' ";
//			$mpurl .= "&key=$_GET[key]";
//		}

		if(!empty($_GET['close'])) {
			$wheresql = $wheresql." AND mt.close = '$_GET[close]' ";
			$mpurl .= "&close=$_GET[close]";
		}else{
			$wheresql = $wheresql." AND mt.close = '0' ";
			$mpurl .= "&close=0";
		}
		
		if(!empty($_GET['classid'])) {
			$wheresql = $wheresql." AND mt.classid = '$_GET[classid]' ";
			$mpurl .= "&classid=$_GET[classid]";
		}
		
		if(!empty($_GET['date'])) {
			$date = sstrtotime($_GET['date']);
			$wheresql = $wheresql." AND mt.starttime <= $date AND mt.endtime >= $date ";
			$mpurl .= "&date=$_GET[date]";
		}
		
		if(isset($_GET['viewme']) && $_GET['viewme']=="0") {
			$mpurl .= "&viewme=0";
		}
		else{
			$usermemberlist = querymemberbyuid($tagid, $_SGLOBAL['supe_uid']);
			$subwheresql = " mt.uid = $_SGLOBAL[supe_uid]";
			foreach($usermemberlist as $member){
				$subwheresql .= " OR (mt.members like '%,$member[memberid],%')";
			}
			$wheresql = $wheresql." AND ( $subwheresql )";
			$_GET['viewme'] = 1;
			$mpurl .= "&viewme=1";
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
		//	showmessage($csql);
		if($count) {
			$uidarray = array();
			$querysql = "SELECT mt.*, mtc.classname taskclassname ";
			$querysql = $querysql." FROM ".tname('mtagtask')." mt ";
			$querysql = $querysql." LEFT OUTER JOIN ".tname('mtag_taskclass')." mtc ON mt.classid = mtc.classid ";
			$querysql = $querysql." WHERE mt.tagid='$tagid' AND $wheresql ORDER BY mt.dateline LIMIT $start,$perpage";
			
			$query = $_SGLOBAL['db']->query($querysql);
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				$value = taskformmapper($value);
				$uidarray[] = $value['uid'];
				$tasklist[] = $value;
			}
	
			$realnamemap = loadrealnamemap($uidarray);
			
			$multi = multi($count, $perpage, $page, $mpurl);
		}
		$taskclasslist=listtaskclass($tagid);
		
		$_TPL['css'] = 'thread';
		$searchengine_description=$mtag['tagname'].",".$mtag['fieldname']."群组,群组任务列表：";
		foreach($taskclasslist as $value) {
			$searchengine_description.=$value['subject'].",";
		}
		
		$nav_item = array();
		$nav_item['url'] = "space.php?do=mtag&tagid=$mtag[tagid]&view=tasks"; $nav_item['dispname'] = "成员任务列表";
		$nav_list[] = $nav_item;
	
		include_once template("space_mtag_tasks");
	} 
	elseif($_GET['view'] == 'task') {
		include_once(S_ROOT.'./data/data_mtagtaskimptclass.php');
		
		$mtag = mtagformmapper($mtag);
		
		$taskid = $_GET['taskid'];
		if( empty($taskid) ) {
			showmessage('mtag_task_not_exist');
		}
		$task = querytaskbyid( $tagid, $taskid );
		if(empty($task)){
			showmessage('mtag_task_not_exist');
		}
		
		$realnamemap = loadrealnamemap(array($task['uid']));
					
		$memberquerysql = "SELECT mm.*, mmc.classname AS memberclassname, s.ip AS uip ";
		$memberquerysql .= " FROM ".tname('mtagmember')." mm ";
		$memberquerysql .= " LEFT OUTER JOIN ".tname('mtag_memberclass')." mmc ON mm.memberclassid = mmc.classid AND mm.tagid=mmc.tagid ";
		$memberquerysql .= " LEFT OUTER JOIN ".tname('session')." s ON mm.uid=s.uid AND s.magichidden != 1";
		$memberquerysql .= " WHERE mm.tagid='$tagid' AND mm.memberid in (0$task[members]0) ORDER BY mmc.displayorder,memberid";
		$query = $_SGLOBAL['db']->query($memberquerysql);
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			$memberlist[] = $value;
		}
		
		//评论
		$perpage = 30;
		$perpage = mob_perpage($perpage);
		$start = ($page-1)*$perpage;
		ckstart($start, $perpage);
		$commentlist = array();
		
		$csql = "SELECT count(*) FROM ".tname('comment')." WHERE id=$taskid AND idtype='mtagtaskid'";
		$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($csql), 0);
		$task['replynum']=$count;
			 
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('comment')." WHERE id=$taskid AND idtype='mtagtaskid' ORDER BY dateline LIMIT $start,$perpage");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			realname_set($value['authorid'], $value['author']);//实名
			$commentlist[] = $value;
		}
		
		//分页
		$multi = multi($count, $perpage, $page, "space.php?do=mtag&view=task&tagid=$tagid&taskid=$taskid", '', 'content');
			
		$_TPL['css'] = 'thread';
		$searchengine_description=$mtag['tagname'].",".$mtag['fieldname']."群组,群组任务：".$value['subject'];
		
		$nav_item = array();
		$nav_item['url'] = "space.php?do=mtag&tagid=$mtag[tagid]&view=tasks"; $nav_item['dispname'] = "成员任务列表";
		$nav_list[] = $nav_item;
	
		$nav_item = array();
		$nav_item['url'] = "space.php?do=mtag&tagid=$mtag[tagid]&view=task&taskid=$task[taskid]"; $nav_item['dispname'] = "$task[subject]";
		$nav_list[] = $nav_item;
	
		include_once template("space_mtag_task");
	} 
	elseif($_GET['view'] == 'threads') {
		
		$perpage = 30;
		$start = ($page-1)*$perpage;
		
		//检查开始数
		ckstart($start, $perpage);
		$theurl = "space.php?uid=$space[uid]&do=mtag&tagid=$tagid&view=$_GET[view]";

		$wheresql = "";
		
		if($searchkey = stripsearchkey($_GET['searchkey'])) {
		   $wheresql .= "AND mt.subject LIKE '%$searchkey%' ";
		   $theurl .= "&searchkey=$_GET[searchkey]";
		}
		
		if(!empty($_GET['threadclassid'])) {
		   $wheresql .= " AND mt.threadclassid = '$_GET[threadclassid]' ";
		   $theurl .= "&threadclassid=$_GET[threadclassid]";
		}
		
		if(empty($_GET['becheck'])){
			$_GET['normal']="on";
			$_GET['close']="";
			$_GET['digest']="on";
			$_GET['displayorder']="on";
		}
		
		$subwheresql=" 1=2 ";
		if($_GET['normal']=="on") {
			$subwheresql .= " OR (mt.close = '0' AND mt.digest = '0' AND mt.displayorder = '0') ";
		   $theurl .= "&normal=on";
		}
		if($_GET['close']=="on") {
			$subwheresql .= " OR mt.close = '1' ";
			$theurl .= "&close=on";
		}	
		if($_GET['digest']=="on") {
			$subwheresql .= " OR mt.digest = '1' ";
			$theurl .= "&digest=on";
		}		
		if($_GET['displayorder']=="on") {
			$subwheresql .= " OR mt.displayorder = '1' ";
			$theurl .= "&displayorder=on";
		}
		
		$wheresql.= " AND ( $subwheresql )";
		  
		$list = array();
		$count = 0;
		
		$csql="SELECT COUNT(*) FROM ".tname('mtag_thread')." mt WHERE mt.tagid='$tagid' $wheresql";
		$qsql="SELECT mt.*, mtc.classname AS threadclassname FROM ".tname('mtag_thread')." mt ";
		$qsql.=" LEFT OUTER JOIN ".tname('mtag_threadclass')." mtc ON mt.tagid=mtc.tagid AND mt.threadclassid=mtc.classid ";
		$qsql.=" WHERE mt.tagid='$tagid' $wheresql ";
		$qsql.=" ORDER BY mt.displayorder DESC, mt.lastpost DESC ";
		$qsql.=" LIMIT $start,$perpage";
		
		$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($csql),0);
		if($count) {
			$query = $_SGLOBAL['db']->query($qsql);
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				$value = threadformmapper($value);
				$list[] = $value;
			}
			
			//分页
			$multi = multi($count, $perpage, $page, $theurl);
	
			realname_get();
		}
		$threadclasslist=listthreadclassbymtagid($tagid);
		
		$_TPL['css'] = 'thread';
		$searchengine_description=$mtag['tagname'].",".$mtag['fieldname']."群组,话题列表：";
		foreach($list as $value) {
			$searchengine_description.=$value['subject'].",";
		}

		$nav_item = array();
		$nav_item['url'] = "space.php?do=mtag&tagid=$mtag[tagid]&view=threads"; $nav_item['dispname'] = "讨论区";
		$nav_list[] = $nav_item;
	
		include_once template("space_mtag_threads");
	}
	elseif($_GET['view'] == 'join') {
		if(empty($_SGLOBAL['supe_uid'])){
			showmessage('no_privilege');
		}
		
		$fans=loadfansbyuserid($tagid, $_SGLOBAL['supe_uid']);
		if(empty($fans)){
			$fans=array();
			$fans['tagid']=$tagid;
			$fans['uid'] = $_SGLOBAL['supe_uid'];
			$fans['username'] = $_SGLOBAL['supe_username'];
			$fans['deleteflag']=0;
			$fans['dateline']=$_SGLOBAL['timestamp'];
			$fans['level']=1;
			$fans['fansgradeid']=4;//普通会员
			
			inserttable("mtagfans", $fans);
		}
		else{
			if($fans['deleteflag']==1){
				$fans['deleteflag']=0;
				updatetable('mtagfans', $fans, array('tagid'=>$fans['tagid'], 'uid'=>$fans['uid']));
			}
		}
		
		//更新群组统计
		$_SGLOBAL['db']->query("UPDATE ".tname("mtag")." SET fansnum=(select count(*) from ".tname('mtagfans')." mf where mf.deleteflag=0 and mf.tagid=$tagid) where tagid='$tagid'");
					
		showmessage('do_success', "space.php?do=mtag&tagid=$tagid&view=index");
	}
	elseif($_GET['view'] == 'unjoin') {
		$fans=loadfansbyuserid($tagid, $_SGLOBAL['supe_uid']);
	
		if(!empty($fans)){
			if($fans['deleteflag']==0){
				$fans['deleteflag']=1;
				updatetable('mtagfans', $fans, array('tagid'=>$fans['tagid'], 'uid'=>$fans['uid']));
			}
		}
		
		$_SGLOBAL['db']->query("UPDATE ".tname("mtag")." SET fansnum=(select count(*) from ".tname('mtagfans')." mf where mf.deleteflag=0 and mf.tagid=$tagid) where tagid='$tagid'");
		
		showmessage('do_success', "space.php?do=mtag&tagid=$tagid&view=index");
	}
} 
else {
	$theurl = "space.php?do=mtag";
	
	if(empty($_GET['view'])) $_GET['view'] = 'all';
	
	if(!in_array($_GET['view'], array('me', 'all', 'member'))) $_GET['view'] = 'all';
	
	$theurl .= "&view=$_GET[view]";
	$actives = array($_GET['view'] => ' class="active"');
		
	//排序
	if (!in_array($_GET['orderby'], array('threadnum', 'postnum', 'membernum', 'fansnum'))) {
		$_GET['orderby'] = 'fansnum';
	} else {
		$theurl .= "&orderby=$_GET[orderby]";
	}
	$orderbyarr = array($_GET['orderby'] => ' style="font-weight:bold;"');
	
	//查询
	$wheresql=" AND m.tagstate>=2 ";
	$_GET['fieldid'] = intval($_GET['fieldid']);
	if($_GET['fieldid']) {
		$wheresql .= " AND m.fieldid='$_GET[fieldid]'";
		$theurl .= "&fieldid=$_GET[fieldid]";
		
		$pro_actives = array($_GET['fieldid'] => ' style="font-weight:bold;"');
	} else {
		$pro_actives = array('all' => ' style="font-weight:bold;"');
	}

	if($searchkey = stripsearchkey($_GET['searchkey'])) {
		$wheresql .= " AND m.tagname LIKE '%$_GET[searchkey]%'";
		$theurl .= "&searchkey=$_GET[searchkey]";
	}
	$list = array();
	$multi = '';
	$count = 0;
	
	$perpage = 20;
	$page = intval($_GET['page']);
	if($page < 1) $page = 1;
	$start = ($page-1)*$perpage;

	if($_GET['view'] == 'me') {
		$userid="";
		if(empty($_GET['uid'])){
			$userid=$_SGLOBAL['supe_uid'];
		}else{
			$userid=$_GET['uid'];
		}
		
		$csql = "SELECT COUNT(m.tagid) FROM ".tname('mtag')." m ";
		$csql = $csql." LEFT OUTER JOIN ".tname('mtagfans')." mf ON m.tagid=mf.tagid AND mf.deleteflag=0 ";
		$csql = $csql." WHERE mf.uid='$userid' $wheresql";
			
		$sql = "SELECT m.* FROM ".tname('mtag')." m ";
		$sql = $sql." LEFT OUTER JOIN ".tname('mtagfans')." mf ON m.tagid=mf.tagid AND mf.deleteflag=0 ";
		$sql = $sql." WHERE mf.uid='$userid' $wheresql";
		$sql = $sql." ORDER BY m.{$_GET['orderby']} DESC LIMIT $start,$perpage";
	}
	else if($_GET['view'] == 'member') {
		
		$csql = "SELECT COUNT(m.tagid) FROM ".tname('mtag')." m ";
		$csql = $csql." LEFT OUTER JOIN ".tname('mtagmember')." mm ON m.tagid=mm.tagid";
		$csql = $csql." WHERE mm.uid='$_SGLOBAL[supe_uid]' $wheresql";
			
		$sql = "SELECT distinct m.* FROM ".tname('mtag')." m ";
		$sql = $sql." LEFT OUTER JOIN ".tname('mtagmember')." mm ON m.tagid=mm.tagid";
		$sql = $sql." WHERE mm.uid='$_SGLOBAL[supe_uid]' $wheresql";
		$sql = $sql." ORDER BY m.{$_GET['orderby']} DESC LIMIT $start,$perpage";
	}
	else if($_GET['view'] == 'all') {

		$csql = "SELECT COUNT(m.tagid) FROM ".tname('mtag')." m ";
		$csql = $csql." WHERE 1=1 $wheresql";
			
		$sql = "SELECT m.* FROM ".tname('mtag')." m ";
		$sql = $sql." WHERE 1=1 $wheresql";
		$sql = $sql." ORDER BY m.{$_GET['orderby']} DESC LIMIT $start,$perpage";
	}
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($csql), 0);
	if($count) {
		$list = querymtag($sql);
		$multi = multi($count, $perpage, $page, $theurl);
	}
	
	$searchengine_description='社团/工作室 群组：';
	foreach($list as $value) {
		$searchengine_description.=$value['tagname'].",";
	}
	
	$nav_list = array();
	$nav_item = array();
	$nav_item['url'] = "space.php?do=mtag"; $nav_item['dispname'] = "我的圈子";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	if($_GET['view'] == 'me') {
		$nav_item['url'] = "space.php?do=mtag&view=me"; $nav_item['dispname'] = "我关注的群组";
	}
	else if($_GET['view'] == 'member') {
		$nav_item['url'] = "space.php?do=mtag&view=member"; $nav_item['dispname'] = "我参与的群组";
	}
	else if($_GET['view'] == 'all') {
		$nav_item['url'] = "space.php?do=mtag&view=all"; $nav_item['dispname'] = "热门群组";
	}
	$nav_list[] = $nav_item;
	
	$nav_search_flag = true;
	$nav_search_lbl = "请输入想查找的群组名称";
	include_once template("space_mtags");
}

?>