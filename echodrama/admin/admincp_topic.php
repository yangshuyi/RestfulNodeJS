<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: admincp_blog.php 9233 2008-10-28 06:21:44Z liguode $
*/

if(!defined('IN_UCHOME') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

//权限
if(!checkperm('managetopic')) {
	cpmessage('no_authority_management_operation');
}

$MODULE_NAME = "SPACE_TOPIC";

$_GET['op'] = empty($_GET['op'])?'list':$_GET['op'];
$_GET['subop'] = empty($_GET['subop'])?'manage':$_GET['subop'];
$topicid = empty($_GET['topicid'])?0:intval($_GET['topicid']);
$view = empty($_GET['view']) ? "single": $_GET['view'];

include_once(S_ROOT.'./data/data_productclass.php');
include_once(S_ROOT.'./data/data_topicauditclass.php');
include_once(S_ROOT.'./source/function_topic.php');
include_once(S_ROOT.'./source/function_cp.php');

if($_GET['op'] == 'batchdelete') {
	//删除
	if(deletetopics($_POST['ids'])) {
		showmessage('do_success', $_POST['mpurl']);
	} else {
		cpmessage('choose_to_delete_the_columns_topic'); // 请选择要删除的广播剧
	}
} elseif($_GET['op'] == 'batchauditpass') {
	//批量审核通过
	if(audittopics($_POST['ids'],2)) {
		showmessage('do_success', $_POST['mpurl']);
	} else {
		cpmessage('choose_to_audit_the_columns_topic'); // 请选择要审核的广播剧
	}
	
} elseif($_GET['op'] == 'batchauditfail') {
	//批量审核不通过
	if(audittopics($_POST['ids'],1)) {
		showmessage('do_success', $_POST['mpurl']);
	} else {
		cpmessage('choose_to_audit_the_columns_topic'); // 请选择要审核的广播剧
	}
} elseif($_GET['op'] == 'batchupdateproducttype') {

	//批量重名
	if(batchupdateproducttype($_POST['fromtopicid'], $_POST['totopicid'], $_POST['topicprefix'])) {
		showmessage('do_success', "admincp.php?ac=topic");
	} else {
		cpmessage('choose_to_audit_the_columns_topic'); // 请选择要审核的广播剧
	}
} elseif($_GET['op'] == 'batchupdateproductpath') {

	//批量重名
	if(batchupdateproductpath($_POST['fromtopicid'], $_POST['totopicid'], $_POST['topicprefix'])) {
		showmessage('do_success', "admincp.php?ac=topic");
	} else {
		cpmessage('choose_to_audit_the_columns_topic'); // 请选择要审核的广播剧
	}
} elseif($_GET['op'] == 'flushmemcache') {

	$_SGLOBAL['db']->flushcache();
	showmessage('do_success', "admincp.php?ac=topic");
	
} elseif($_GET['op'] == 'buildtopicquantum') {

	//批量重名
	buildtopicquantum();
		
	showmessage('do_success', "admincp.php?ac=topic");
} elseif($_GET['op'] == 'batchupdatequantum') {

	//批量重名
	if(batchupdatequantum($_POST['fromtopicid'], $_POST['totopicid'])) {
		showmessage('do_success', "admincp.php?ac=topic");
	} else {
		cpmessage('choose_to_audit_the_columns_topic'); // 请选择要审核的广播剧
	}
} elseif($_GET['op'] == 'synsina') {
	//be used for t_sina_oauth
	
	if(empty($topicid)) {
		showmessage("topic_does_not_exist");
	}
	$topic=loadtopicsinglebyid($topicid);
	//广播剧不存在
	if(empty($topic)) {
		showmessage('topic_does_not_exist');
	}
	
	$sina = array();
	$sina['oauth_token'] = empty($_GET['oauth_token'])?$_POST['oauth_token']:$_GET['oauth_token'];
	$sina['oauth_token_secret'] = empty($_GET['oauth_token_secret'])?$_POST['oauth_token_secret']:$_GET['oauth_token_secret'];
	$sina['oauth_verifier'] = empty($_GET['oauth_verifier'])?$_POST['oauth_verifier']:$_GET['oauth_verifier'];
	$sina['lastkey_oauth_token'] = empty($_GET['lastkey_oauth_token'])?$_POST['lastkey_oauth_token']:$_GET['lastkey_oauth_token'];
	$sina['lastkey_oauth_token_secret'] = empty($_GET['lastkey_oauth_token_secret'])?$_POST['lastkey_oauth_token_secret']:$_GET['lastkey_oauth_token_secret'];
	
	if($_GET['subop'] == 'loginsina') {
		include_once(S_ROOT.'./source/function_t_sina_oauth.php');
		
		$sina = connecttosina("admincp.php?ac=topic&op=synsina&subop=tosynsina&topicid=$topicid");
	}
	else if($_GET['subop'] == 'tosynsina') {
		include_once(S_ROOT.'./source/function_t_sina_oauth.php');
		
		$topic = topicsingleformmapper($topic);
		$topicadditioninfo = querytopicadditioninfobytopic($topic[topicid]);
		$weibo_message = buildtopicmessage($topic, true);
		$sina = confirmstatus($sina);
	}
	else if($_GET['subop'] == 'synsina') {
		include_once(S_ROOT.'./source/function_t_sina_oauth.php');
		
		$topic = topicsingleformmapper($topic);
		
		$sina['weibo_message'] = $_POST['weibo_message'];
		$sina['weibo_image'] = $topic['pic'];
		sendtopicmessagetosina($sina);
		
		$sql="update ".tname('topic')." t set t.synthreadid=1 where t.topicid=$topic[topicid]";
		$query = $_SGLOBAL['db']->query($sql);
		
		showmessage('do_success', 'admincp.php?ac=topic');
	}	
} 
elseif($_GET['op'] == 'quicksynsina') {
	//be used for t_sina_oauth with defined secret token
	
	if(empty($topicid)) {
		showmessage("topic_does_not_exist");
	}
	$topic=loadtopicsinglebyid($topicid);
	//广播剧不存在
	if(empty($topic)) {
		showmessage('topic_does_not_exist');
	}
	
	$sina = array();
	
	if($_GET['subop'] == 'tosynsina') {
		include_once(S_ROOT.'./source/function_t_sina_oauth.php');
		
		$topic = topicsingleformmapper($topic);
		$topicadditioninfo = querytopicadditioninfobytopic($topic[topicid]);
		$weibo_message = buildtopicmessage($topic, true);
		//$sina = confirmstatus($sina);
	}
	else if($_GET['subop'] == 'synsina') {
		include_once(S_ROOT.'./source/function_t_sina_oauth.php');
		
		$topic = topicsingleformmapper($topic);
		
		$sina['weibo_message'] = $_POST['weibo_message'];
		$sina['weibo_image'] = $topic['picthumb'];
		sendtopicmessagetosina($sina);
		
		$sql="update ".tname('topic')." t set t.synthreadid=1 where t.topicid=$topic[topicid]";
		$query = $_SGLOBAL['db']->query($sql);
		
		showmessage('do_success', 'admincp.php?ac=topic');
	}	
} 
elseif($_GET['op'] == 'delete') {
	
	submitcheck('topicsubmit');
	
	//删除
	if(empty($topicid)) {
		showmessage("topic_does_not_exist");
	}
	$topic=loadtopicsinglebyid($topicid);
	//广播剧不存在
	if(empty($topic)) {
		showmessage('topic_does_not_exist');
	}
	
	$deletemessage = $_POST['auditmessage'];
	
	if(deletetopics(array($topicid), $deletemessage)) {
		showmessage('do_success', $_POST['referlink']);
	} else {
		showmessage('failed_to_delete_operation');
	}
} 
elseif($_GET['op'] == 'audit') {
		
	submitcheck('topicsubmit');

	if(empty($topicid)) {
		showmessage("topic_does_not_exist");
	}
	$topic=loadtopicsinglebyid($topicid);
	//广播剧不存在
	if(empty($topic)) {
		showmessage('topic_does_not_exist');
	}
	$topicadditioninfo = querytopicadditioninfobytopic($topicid);
	
	$previousTopicState = $topic['auditstate'];
	
	$topic['subject'] = $_POST['subject'];
	$topic['firstpublish'] = $_POST['firstpublish'];
	$topic['shorttopic'] = $_POST['shorttopic'];
	$topic['singtonalbum'] = $_POST['singtonalbum'];
	$topic['label'] = $_POST['label'];
	
	$topic['audiotype'] = $_POST['audiotype'];
	$topic['audioplayerpathtype'] = $_POST['audioplayerpathtype'];
	$topic['audioplayerpath_tudou'] = $_POST['audioplayerpath_tudou'];
	$topic['audiodownloadpathtype'] = $_POST['audiodownloadpathtype'];
	$topic['audiodownloadpath_rayfile'] = $_POST['audiodownloadpath_rayfile'];
	$topic['audiodownloadpath_115'] = $_POST['audiodownloadpath_115'];
	$topic['audiodownloadpath_zhongzhuan'] = $_POST['audiodownloadpath_zhongzhuan'];

	$topic['productclassid'] = $_POST['productclassid'];
	$topic['club'] = $_POST['club'];
	$topic['clubtagid'] = $_POST['clubtagid'];
	$topic['director'] = $_POST['director'];
	$topic['producer'] = $_POST['producer'];
	$topic['cehua'] = $_POST['cehua'];
	$topic['yuanzhu'] = $_POST['yuanzhu'];
	$topic['writer'] = $_POST['writer'];
	$topic['cast'] = $_POST['cast'];
	$topic['effector'] = $_POST['effector'];
	$topic['photographer'] = $_POST['photographer'];
	$topic['propagandizer'] = $_POST['propagandizer'];
	$topic['producedate'] = sstrtotime($_POST['producedate']);
	$topic['lastpost'] = $_SGLOBAL['timestamp'];
	
	$topic['auditstate'] = $_POST['auditstate'];
	$topic['auditdate'] = $_SGLOBAL['timestamp'];
	$topic['auditmessage'] = $_POST['auditmessage'];
	$topic['replydateline'] = $_SGLOBAL['timestamp'];
	
	$topicadditioninfo['message'] = $_POST['message'];
	
	//检查输入
	if(empty($topic['uid'])){
		showmessage('topic_uid_empty');
	} elseif(empty($topic['username'])){
		showmessage('topic_username_empty');
	} elseif(empty($topic['subject'])) {
		showmessage('topic_subject_empty');
	} elseif(empty($topicadditioninfo['message'])) {
		showmessage('topic_message_empty');
	} elseif(empty($topic['club'])) {
		showmessage('topic_club_empty');
	} elseif(empty($topic['club'])) {
		showmessage('topic_club_empty');
	} elseif(empty($topic['auditstate'])) {
		showmessage('topic_auditstate_empty');
	} elseif(empty($topic['auditdate'])) {
		showmessage('topic_auditdate_empty');
	} elseif(empty($topic['auditmessage'])) {
		showmessage('topic_auditmessage_empty');
	}
	
	//audiotype
	if($topic['audiotype']==1){
		
	}
	elseif($topic['audiotype']==2){
		if(empty($topic['audioplayerpath_tudou'])){
			showmessage('topic_audioplayerpath_tudou_empty');
		}
		if(empty($topic['audiodownloadpath_rayfile']) && empty($topic['audiodownloadpath_115']) && empty($topic['audiodownloadpath_zhongzhuan'])){
			showmessage('topic_audiodownloadpath_empty');
		}
	}else{
		showmessage('topic_audiotype_empty');
	}
	
	updatetable('topic', $topic, array('topicid'=>$topicid));
	updatetable('topic_additioninfo', $topicadditioninfo, array('topicid'=>$topicid));
	
	updatesystemtopiclabel($topic);
	
	if($previousTopicState != $topic['auditstate']){
		$auditstatevalue=$_SGLOBAL[topicauditclass][$topic[auditstate]][classname];
		$auditdatevalue=sgmdate('Y-m-d', $topic[auditdate]);
		$auditmessage = $topic[auditmessage];
			
		$notification="你上传的广播剧&nbsp;编号$topic[topicid]&nbsp;剧名&nbsp;<a target='_blank' href='space.php?do=topic&topicid=$topic[topicid]'>$topic[subject]</a> ".$auditstatevalue."。 </br> 审核时间 </br> $auditdatevalue </br> 审核批注 </br> $auditmessage";
	
		if($topic['auditstate']==1){
			//审核未通过
			notification_add($topic[uid],"topic_audit","</br>抱歉，".$notification,0);
		}elseif($topic['auditstate']==2){
			//通知预告关注者
			$joinuser_list = querytopicforecastuserlist($topicid);
			foreach($joinuser_list as $joinuser){
				notification_add($joinuser['uid'],"topicforecast_confirm","你关注的广播剧预告: $topic[subject] 已经发布，<br/>请<a href='space.php?do=topic&topicid=$topic[topicid]' target='_blank'>点击访问并收听</a>。 ",0);
			}
			
			notification_add($topic[uid],"topic_audit","</br>您好，".$notification,0);
		}
	}

	//生成群组记录
	if( !empty($topic['clubtagid']) ){
		include_once(S_ROOT.'./source/function_mtag.php');
		$mtagproductitemsql = "SELECT mp.* FROM ".tname('mtagproduct')." mp WHERE mp.tagid='$topic[clubtagid]' AND mp.producttype='1' AND mp.productid='$topic[topicid]'";
		$mtagproductitemlist = querymtagproductitem($mtagproductitemsql);
		if( count($mtagproductitemlist) >= 1 ){
			
		}
		else{
			$mtagproductitem = array();
			$mtagproductitem['tagid'] = $topic['clubtagid'];
			$mtagproductitem['producttype'] = 1;
			$mtagproductitem['productid'] = $topic['topicid'];
			$mtagproductitem['productname'] = $topic['subject'];
			$mtagproductitem['introduce'] = '';
			$mtagproductitem['dateline'] = $_SGLOBAL['timestamp'];
			inserttable('mtagproduct', $mtagproductitem);
			
			//更新群组统计
			$_SGLOBAL['db']->query("UPDATE ".tname("mtag")." SET productnum=(select count(*) from ".tname('mtagproduct')." mp where mp.tagid=$topic[clubtagid]) where tagid='$topic[clubtagid]'");
		
			if( $topic['firstpublish']==1 ){
				updatemtagcredit($topic['clubtagid'], $topic['uid'], $topic['username'], "广播剧".$topic[subject]."首发", 20);
			}
		}
	}
			
	//产生动态
	if($topic['auditstate']==2 && $_POST['makefeed']==1) {
		
		include_once(S_ROOT.'./source/function_feed.php');
		feed_publish($topicid, 'topicid', 0);
	}	
	
	//更新缓存
	$topic=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "topic", "loadtopicbyid", array($topicid), 3600, true);
	
	showmessage('do_success', $_POST['referlink'], 1);

} 
elseif($_GET['op'] == 'manage') {
	if(empty($topicid)) {
		showmessage("topic_does_not_exist");
	}
	$topic=loadtopicsinglebyid($topicid);
	//广播剧不存在
	if(empty($topic)) {
		showmessage('topic_does_not_exist');
	}
	$topicadditioninfo = querytopicadditioninfobytopic($topicid);
	
	if(empty($_POST['formhash'])) {
		$topic=topicsingleformmapper($topic);
		$topic['auditmessage']=$topic['auditmessage']."\n\n";
	}
	else{
		if( $_GET['subop'] == 'updateproductpath' ){
			$product = $topic['product'];
			$productpath = $_SC['attachdir'].'./'.$topic['product'];
			$newproduct = $_POST['newproduct'];
			$newproductpath = $_SC['attachdir'].'./'.$newproduct;
			if(empty($newproduct)) {
				showmessage('topic_product_empty');
			} 
			if(is_file($newproductpath)){
				showmessage('topic_product_exists');
			}
			if(!is_file($productpath)){
				showmessage('topic_product_not_exists');
			}
			
			rename($productpath,$newproductpath);
			
			$updateSql="UPDATE ".tname('topic')." SET product = '$newproduct' where topicid=$topicid";
			$_SGLOBAL['db']->query($updateSql);
		}
		else if( $_GET['subop'] == 'deletepic' ){
			$picpath=pic_get($topic['pic'], 0, $topic['remote']);
			if(file_exists($picpath)){
				unlink($picpath);
			}
			$thumbpath=$picpath.'.thumb.jpg';
			if(file_exists($thumbpath)){
				unlink($thumbpath);
			}
				
			$updateSql="UPDATE ".tname('topic')." SET pic = '' where topicid=$topicid";
			$_SGLOBAL['db']->query($updateSql);
		}
		else if( $_GET['subop'] == 'uploadpic' ){
			$picpath = $_FILES['newpic'];
			
			if(empty($picpath)){
				showmessage("topic_pic_empty");
			}
			
			$picpath=topicPic_save($picpath);
			
			//默认图片
			$picPath=$_SC['attachdir'].'./'.$picpath;
			if(!is_file($picPath)){
				$picpath=getfilepath("jpg",true);
				copy("image/notopicpic.jpg",$_SC['attachdir'].'./'.$picpath); 
			}
			
			$updateSql="UPDATE ".tname('topic')." SET pic = '$picpath' where topicid=$topicid";
			$_SGLOBAL['db']->query($updateSql);
		}
		else if( $_GET['subop'] == 'mailtest' ){
			internal_mail('MAIL_TOPIC_AUDITOR', $topic['subject'], "请审核<a href='http://www.echodrama.com/admincp.php?ac=topic&op=manage&subop=manage&topicid=$topic[topicid]' target='_blank'>$topic[subject]</a>");
		}
		
		//更新缓存
		$topic=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "topic", "loadtopicbyid", array($topicid), 3600, true);
		$topicadditioninfo=$_SGLOBAL['db']->cacheobj($MODULE_NAME, "topicadditioninfo", "querytopicadditioninfobytopic", array($topicid), 3600, true);
	
		showmessage('do_success', "/admincp.php?ac=topic&op=manage&subop=process&topicid=$topicid", 1);
	}
		
} elseif($_GET['op'] == 'list') {
	// 搜索
	
	$page = empty($_GET['page'])?1:intval($_GET['page']);
	if($page<1) $page = 1;
	
	$perpage = 30;
	$start = ($page-1)*$perpage;
	
	//处理搜索
	include_once(S_ROOT.'./source/function_admincp.php');

	$mpurl = 'admincp.php?ac=topic';
	$list = array();
	$multi = '';
	
	$intkeys = array('productclassid');
	$strkeys = array();
	//TODO 日期查询有问题
	$randkeys = array(array('sstrtotime','producedate'), array('intval','viewnum'), array('intval','replynum'), array('intval','hot'));
	$likekeys = array('subject','club','director','writer','cast','producer','effector','photographer');
	$results = getwheres($intkeys, $strkeys, $randkeys, $likekeys, 't.');
	$wherearr = $results['wherearr'];
	$wheresql = empty($wherearr)?'1':implode(' AND ', $wherearr);
	
	$page = empty($_GET['page'])?1:intval($_GET['page']);
	if($page<1) $page = 1;
	$start = ($page-1)*$perpage;
	//检查开始数
	ckstart($start, $perpage);
	
	$mpurl .= '&'.implode('&', $results['urls']);
	$mpurl .= '&perpage='.$perpage;
	$mpurl .= '&view='.$view;
	
	if($view == 'audit') {
		//需要审核的广播剧
		$csql = "SELECT COUNT(*) FROM ".tname('topic')." t WHERE t.type='single' and t.auditstate<1 and $wheresql";
		$qsql = "SELECT * FROM ".tname('topic')." t WHERE t.type='single' and t.auditstate<1 and $wheresql order by dateline DESC LIMIT $start,$perpage";
	} else if($view == 'single') {
		$csql = "SELECT COUNT(*) FROM ".tname('topic')." t WHERE t.type='single' and $wheresql";
		$qsql = "SELECT * FROM ".tname('topic')." t WHERE t.type='single' and $wheresql order by dateline DESC LIMIT $start,$perpage";
	}
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($csql), 0);
	if($count) {
		$list=querytopic($qsql);
		
		//显示分页
		$multi = multi($count, $perpage, $page, $mpurl);
	}
	
	$managebatch = checkperm('managebatch');
	$allowbatch = true;
	$actives = array($view => ' class="active"');
}

?>