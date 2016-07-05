<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: log.php 11425 2009-03-05 05:11:17Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//一次处理的个数，防止超时
execute();

function execute(){
	global $_SGLOBAL, $_SC;
	include_once(S_ROOT.'./data/data_static_tableinfotype.php');

	$sitedailystatic = array();
	
	$date = sgmdate('Y-m-d', $_SGLOBAL['timestamp']);
	
	$qsql="SELECT * FROM ".tname('site_static_daily')." WHERE date='$date'";
	$query = $_SGLOBAL['db']->query($qsql);
	$sitedailystatic = $_SGLOBAL['db']->fetch_array($query);
	if(empty($sitedailystatic)){
		$sitedailystatic=array();
		$sitedailystatic['date']=$date;
	}
	else{
	}
	
	$query = $_SGLOBAL['db']->query("SELECT count(*) AS num_space FROM ".tname('space')."");
	$value = $_SGLOBAL['db']->fetch_array($query);
	$sitedailystatic['num_space'] = $value['num_space'];
	
	$query = $_SGLOBAL['db']->query("SELECT count(*) AS num_space_updated FROM ".tname('space')." where lastlogin>".($_SGLOBAL['timestamp']-3600*24));
	$value = $_SGLOBAL['db']->fetch_array($query);
	$sitedailystatic['num_space_updated'] = $value['num_space_updated'];
	
	$query = $_SGLOBAL['db']->query("SELECT count(*) AS num_topic FROM ".tname('topic')." ");
	$value = $_SGLOBAL['db']->fetch_array($query);
	$sitedailystatic['num_topic'] = $value['num_topic'];
	
	$query = $_SGLOBAL['db']->query("SELECT count(*) AS num_topic_user FROM ".tname('topicuser')." ");
	$value = $_SGLOBAL['db']->fetch_array($query);
	$sitedailystatic['num_topic_user'] = $value['num_topic_user'];
	
	$query = $_SGLOBAL['db']->query("SELECT count(*) AS num_topic_poll FROM ".tname('topicpoll')." ");
	$value = $_SGLOBAL['db']->fetch_array($query);
	$sitedailystatic['num_topic_poll'] = $value['num_topic_poll'];
	
	$query = $_SGLOBAL['db']->query("SELECT count(*) AS num_video FROM ".tname('video')." ");
	$value = $_SGLOBAL['db']->fetch_array($query);
	$sitedailystatic['num_video'] = $value['num_video'];
	
	$query = $_SGLOBAL['db']->query("SELECT count(*) AS num_video_user FROM ".tname('videouser')." ");
	$value = $_SGLOBAL['db']->fetch_array($query);
	$sitedailystatic['num_video_user'] = $value['num_video_user'];
	
	$query = $_SGLOBAL['db']->query("SELECT count(*) AS num_video_poll FROM ".tname('videopoll')." ");
	$value = $_SGLOBAL['db']->fetch_array($query);
	$sitedailystatic['num_video_poll'] = $value['num_video_poll'];
	
	$query = $_SGLOBAL['db']->query("SELECT count(*) AS num_cover FROM ".tname('cover')." ");
	$value = $_SGLOBAL['db']->fetch_array($query);
	$sitedailystatic['num_cover'] = $value['num_cover'];
	
	$query = $_SGLOBAL['db']->query("SELECT count(*) AS num_cover_user FROM ".tname('coveruser')." ");
	$value = $_SGLOBAL['db']->fetch_array($query);
	$sitedailystatic['num_cover_user'] = $value['num_cover_user'];
	
	$query = $_SGLOBAL['db']->query("SELECT count(*) AS num_cover_poll FROM ".tname('coverpoll')." ");
	$value = $_SGLOBAL['db']->fetch_array($query);
	$sitedailystatic['num_cover_poll'] = $value['num_cover_poll'];
	
	$query = $_SGLOBAL['db']->query("SELECT count(*) AS num_tone FROM ".tname('tone')." ");
	$value = $_SGLOBAL['db']->fetch_array($query);
	$sitedailystatic['num_tone'] = $value['num_tone'];
	
	$query = $_SGLOBAL['db']->query("SELECT count(*) AS num_tone_user FROM ".tname('toneuser')." ");
	$value = $_SGLOBAL['db']->fetch_array($query);
	$sitedailystatic['num_tone_user'] = $value['num_tone_user'];
	
	$query = $_SGLOBAL['db']->query("SELECT count(*) AS num_tone_poll FROM ".tname('tonepoll')." ");
	$value = $_SGLOBAL['db']->fetch_array($query);
	$sitedailystatic['num_tone_poll'] = $value['num_tone_poll'];
	
	$query = $_SGLOBAL['db']->query("SELECT count(*) AS num_poll FROM ".tname('poll')." ");
	$value = $_SGLOBAL['db']->fetch_array($query);
	$sitedailystatic['num_poll'] = $value['num_poll'];
	
	$query = $_SGLOBAL['db']->query("SELECT count(*) AS num_poll_user FROM ".tname('polluser')." ");
	$value = $_SGLOBAL['db']->fetch_array($query);
	$sitedailystatic['num_poll_user'] = $value['num_poll_user'];
	
	$query = $_SGLOBAL['db']->query("SELECT count(*) AS num_mtag FROM ".tname('mtag')." ");
	$value = $_SGLOBAL['db']->fetch_array($query);
	$sitedailystatic['num_mtag'] = $value['num_mtag'];
	
	$query = $_SGLOBAL['db']->query("SELECT count(*) AS num_notification FROM ".tname('notification')." ");
	$value = $_SGLOBAL['db']->fetch_array($query);
	$sitedailystatic['num_notification'] = $value['num_notification'];
	
	$query = $_SGLOBAL['db']->query("SELECT count(*) AS num_friend FROM ".tname('friend')." ");
	$value = $_SGLOBAL['db']->fetch_array($query);
	$sitedailystatic['num_friend'] = $value['num_friend'];
	
	$query = $_SGLOBAL['db']->query("SELECT count(*) AS num_comment FROM ".tname('comment')." ");
	$value = $_SGLOBAL['db']->fetch_array($query);
	$sitedailystatic['num_comment'] = $value['num_comment'];
	
	$query = $_SGLOBAL['db']->query("SELECT count(*) AS num_comment_topic FROM ".tname('comment')." WHERE idtype='topicid'");
	$value = $_SGLOBAL['db']->fetch_array($query);
	$sitedailystatic['num_comment_topic'] = $value['num_comment_topic'];
	
	$query = $_SGLOBAL['db']->query("SELECT count(*) AS num_comment_video FROM ".tname('comment')." WHERE idtype='videoid'");
	$value = $_SGLOBAL['db']->fetch_array($query);
	$sitedailystatic['num_comment_video'] = $value['num_comment_video'];
	
	$query = $_SGLOBAL['db']->query("SELECT count(*) AS num_comment_cover FROM ".tname('comment')." WHERE idtype='coverid'");
	$value = $_SGLOBAL['db']->fetch_array($query);
	$sitedailystatic['num_comment_cover'] = $value['num_comment_cover'];
	
	$query = $_SGLOBAL['db']->query("SELECT count(*) AS num_comment_tone FROM ".tname('comment')." WHERE idtype='toneid'");
	$value = $_SGLOBAL['db']->fetch_array($query);
	$sitedailystatic['num_comment_tone'] = $value['num_comment_tone'];
	
	$query = $_SGLOBAL['db']->query("SELECT count(*) AS num_comment_poll FROM ".tname('comment')." WHERE idtype='pid'");
	$value = $_SGLOBAL['db']->fetch_array($query);
	$sitedailystatic['num_comment_poll'] = $value['num_comment_poll'];
	
	$query = $_SGLOBAL['db']->query("SELECT count(*) AS num_bbs_threads FROM ".tname('mtag_thread')." WHERE tagid='".FORUM_TAGID."' ");
	$value = $_SGLOBAL['db']->fetch_array($query);
	$sitedailystatic['num_bbs_threads'] = $value['num_bbs_threads'];
	
	$query = $_SGLOBAL['db']->query("SELECT count(*) AS num_bbs_posts FROM ".tnamebbs('post')." WHERE tagid='".FORUM_TAGID."' ");
	$value = $_SGLOBAL['db']->fetch_array($query);
	$sitedailystatic['num_bbs_posts'] = $value['num_bbs_posts'];
	
	if(empty($sitedailystatic['id'])){
		inserttable('site_static_daily', $sitedailystatic);
	}
	else{
		updatetable('site_static_daily', $sitedailystatic, array('id'=>$sitedailystatic['id']));
	}
	
}
?>