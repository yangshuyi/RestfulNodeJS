<?php
/*
 [UCenter Home] (C) 2007-2008 Comsenz Inc.
 $Id: function_delete.php 13001 2009-08-05 06:18:06Z zhengqingpeng $
 */

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

function testconnectiontosina($username, $password){
	global $_SGLOBAL, $_SC;
	
	include_once(S_ROOT.'./source/t_sina_weibo.class.php');
	
	$w = new weibo( '2514375514', 'e3404456ad1125fe5fabd16080e13a4d' );
	$w->setUser( $username , $password );
	
	$msg  = $w->verify_credentials();
	if ($msg === false || $msg === null){
		return "连接故障，请检查您的新浪登录用户名/密码。";
	}
	if (isset($msg['error_code']) && isset($msg['error'])){
		return "连接故障，请检查您的新浪登录用户名/密码。";
	}
	
	$screen_name = iconv("utf-8","gb2312",$msg['screen_name']);
	return "你的新浪微博名为[".$screen_name."]";
}

function sendmessagetosina($uid, $message){
	global $_SGLOBAL, $_SC;
	
	$list=array();
	$querysql="SELECT s.* FROM ".tname('space')." s WHERE s.uid = '$uid' ";
	$query = $_SGLOBAL['db']->query($querysql);
	$userspace = $_SGLOBAL['db']->fetch_array($query);
	
	if( empty($userspace) || $userspace['t_sina_flag'] != 1) {
		return;
	}
		
	include_once(S_ROOT.'./source/t_sina_weibo.class.php');
	
	$username = $userspace['t_sina_username'];
	$password = $userspace['t_sina_password'];
		
	$w = new weibo( '2514375514', 'e3404456ad1125fe5fabd16080e13a4d' );
	$w->setUser( $username , $password );
	
	$msg  = $w->verify_credentials();
	if ($msg === false || $msg === null){
		return;
	}
	if (isset($msg['error_code']) && isset($msg['error'])){
		return;
	}
	
	$screen_name = iconv("utf-8","gbk",$msg['screen_name']);
	
	if(empty($screen_name)){
		return;
	}
	
	$w->update(iconv("gbk","utf-8",$message));
}

function sendtopictosina($topic){
	global $_SGLOBAL, $_SC;
	
	if( empty($topic) ) {
		return;
	}
		
	include_once(S_ROOT.'./source/t_sina_weibo.class.php');
	
	$username = 'echodrama@sina.com';
	$password = 'javaking';

	$w = new weibo( '2514375514', 'e3404456ad1125fe5fabd16080e13a4d' );
	$w->setUser( $username , $password );
	
	$msg  = $w->verify_credentials();
	if ($msg === false || $msg === null){
		return;
	}
	
	if (isset($msg['error_code']) && isset($msg['error'])){
		return;
	}
	
	$screen_name = iconv("utf-8","gb2312",$msg['screen_name']);
	
	if(empty($screen_name)){
		return;
	}
	
	$message = $topic['typename'].":".$topic['subject'].",".$topic['productclassname'].",";
	$message .= "由".$topic['club']."发布,";
//	$message .= "CAST:".$topic['cast'].",";
//	$message .= "STAFF:".$topic['group']."。";
//	$limitmessage = getstr($message, 200, 0, 0, 0, 0, -1);
//	
//	if( $message!=$limitmessage ){
//		$limitmessage .= "...";
//	}
	
	$message .= " 收听链接:http://www.echodrama.com/space.php?do=topic&topicid=".$topic['topicid'];
	$w->update(iconv("gbk","utf-8", $message));
}


function sendtopicmessagetosina($topicmessage){
	if( empty($topicmessage) ) {
		return;
	}
		
	include_once(S_ROOT.'./source/t_sina_weibo.class.php');
	
	$username = 'echodrama@sina.com';
	$password = 'javaking';

	$w = new weibo( '2514375514', 'e3404456ad1125fe5fabd16080e13a4d' );
	$w->setUser( $username , $password );
	
	$msg  = $w->verify_credentials();
	if ($msg === false || $msg === null){
		return;
	}
	
	if (isset($msg['error_code']) && isset($msg['error'])){
		return;
	}
	
	$screen_name = iconv("utf-8","gb2312",$msg['screen_name']);
	
	if(empty($screen_name)){
		return;
	}
	$w->update(iconv("gbk","utf-8", $topicmessage));
}

function buildtopicmessage($topic){
	
	include_once(S_ROOT.'./source/function_cvweibo.php');
	
	$num = 0;
	$maxlen = 140;
	
	$cast_10_weiboitem = "";
	$cast_15_weiboitem = "";
	$cast_all_weiboitem = "";
	$group_weiboitem = "";
	
	if(!empty($topic[cast])){
		$topiccastarray=split('/',$topic[cast]);
		$index=1;
		foreach($topiccastarray as $castitem){
			if(empty($castitem)) break;
			
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
			
			$directoritem = cvmapper($directoritem);
			$director_weiboitem .= $directoritem.",";
		}
		$group_weiboitem.="导演:".substr($director_weiboitem,0,-1).",";
	}
	if(!empty($topic[producer])){
		$topicproducerarray=split('/',$topic[producer]);
		foreach($topicproducerarray as $produceritem){
			if(empty($produceritem)) break;
			
			$produceritem = cvmapper($produceritem);
			$producer_weiboitem .= $produceritem.",";
		}
		
		if($producer_weiboitem == $director_weiboitem){
			
		}
		else{
			$group_weiboitem.="监制:".substr($producer_weiboitem,0,-1).",";
		}
	}
	if(!empty($topic[cehua])){
		$topiccehuaarray=split('/',$topic[cehua]);
		foreach($topiccehuaarray as $cehuaitem){
			if(empty($cehuaitem)) break;
			
			$cehuaitem = cvmapper($cehuaitem);
			$cehua_weiboitem .= $cehuaitem.",";
		}
		if($cehua_weiboitem == $director_weiboitem){
			
		}
		else if($cehua_weiboitem == $producer_weiboitem){
			
		}
		else{
			$group_weiboitem.="策划:".substr($cehua_weiboitem,0,-1).",";
		}
		
	}
	if(!empty($topic[writer])){
		$topicwriterarray=split('/',$topic[writer]);
		foreach($topicwriterarray as $writeritem){
			if(empty($writeritem)) break;
			
			$writeritem = cvmapper($writeritem);
			$writer_weiboitem .= $writeritem.",";
		}
		$group_weiboitem.="编剧:".substr($writer_weiboitem,0,-1).",";
	}
	if(!empty($topic[effector])){
		$topiceffectorarray=split('/',$topic[effector]);
		foreach($topiceffectorarray as $effectoritem){
			if(empty($effectoritem)) break;
			
			$effectoritem = cvmapper($effectoritem);
			$effector_weiboitem .= $effectoritem.",";
		}
		$group_weiboitem.="后期:".substr($effector_weiboitem,0,-1).",";
	}	
	if(!empty($topic[photographer])){
		$topicphotographerarray=split('/',$topic[photographer]);
		foreach($topicphotographerarray as $photographeritem){
			if(empty($photographeritem)) break;
			
			$photographeritem = cvmapper($photographeritem);
			$photographer_weiboitem .= $photographeritem.",";
		}
		$group_weiboitem.="美工:".substr($photographer_weiboitem,0,-1).",";
	}	
	$group_weiboitem = substr($group_weiboitem,0,-1)." ";
	
	$subject_len = strlen($topic['subject']);
	$productclassname_len = strlen($topic['productclassname']);
	$club_len = strlen($topic['club']);
	$cast_len = strlen($cast_all_weiboitem);
	$group_len = strlen($group_weiboitem);
		
	$text_title = $topic['club']."发布:".$topic['productclassname']."-".$topic['subject'].";";
	$text_title_len = strlen($text_title);
		
	$text_link = "收听链接:http://www.echodrama.com/space.php?do=topic&topicid=".$topic['topicid']." ";
	$text_link_len = 15;
		
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
	
			$fileopen = fopen("c:/t_test.log","a+");
		fwrite($fileopen,$type."+".$text);
		fclose($fileopen);
		
	return $text;		
}

?>