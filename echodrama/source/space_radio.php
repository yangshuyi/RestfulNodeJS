<?php
/*
 [UCenter Home] (C) 2007-2008 Comsenz Inc.
 $Id: space_feed.php 12432 2009-06-25 07:31:34Z xupeng $
 */

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

$view = isset($_GET['view']) ? $_GET['view'] : "radio";

include_once(S_ROOT.'./source/function_radio.php');

//load the radio
$currenttime = $_SGLOBAL['timestamp'];
if( empty($_GET['rid']) ){
	$qsql="SELECT r.* FROM ".tname("radio")." r WHERE r.starttime<=$currenttime AND r.endtime>=$currenttime";
}
else{
	$qsql="SELECT r.* FROM ".tname("radio")." r WHERE r.rid = '$_GET[rid]'";
}

$query = $_SGLOBAL['db']->query($qsql);
$radio = $_SGLOBAL['db']->fetch_array($query);

$version = "$"."version";

if(empty($radio)){
	
	$radiolist = listseperateradio();
	include_once template('space_radio');
}
else {
	$userip=getonlineip(0);
	$qsql="SELECT sr.* FROM ".tname("session_radio")." sr WHERE sr.ip='$userip'";
	$query = $_SGLOBAL['db']->query($qsql);
	$session_radio = $_SGLOBAL['db']->fetch_array($query);
	
	if(empty($session_radio)){
		$_SGLOBAL['db']->query("insert into ".tname("session_radio")."(ip, uid, username, actioncount, firstactivity, lastactivity) values('$userip','$_SGLOBAL[supe_uid]','$_SGLOBAL[username]',1,'$_SGLOBAL[timestamp]','$_SGLOBAL[timestamp]')");
	}
	else{
		$_SGLOBAL['db']->query("update ".tname("session_radio")." set uid='$_SGLOBAL[supe_uid]', username = '$_SGLOBAL[username]', lastactivity='$_SGLOBAL[timestamp]', actioncount=actioncount+1 where ip='$userip'");
	}
	$_SGLOBAL['db']->query("delete from ".tname("session_radio")." where lastactivity < '".($_SGLOBAL['timestamp']-1800)."'");
	
	if($view == 'radio') {
		
		$radiopath=$radio['code'];
		$sessionId = getonlineip(1)."-".$currenttime;
		
		$radiolist = listseperateradio();
		
		include_once template('space_radio');
	}
	else if($view == 'space_radio_session_view') {
		//just refresh the user activity
	
		$sessionradiolist=array();
		$querysql="SELECT sr.* FROM ".tname('session_radio')." sr ORDER BY sr.firstactivity";
		$query = $_SGLOBAL['db']->query($querysql);
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			$sessionradiolist[] = $value;
		}
		include_once template('space_radio_session_view_ajax');
	}
	else if($view == 'space_radio_chatting_post') {
		if(empty($_GET['rid'])){
			return;
		}
		
		$radiochatting = array();
		
		if( empty($_SGLOBAL['supe_uid']) ){
			$radiochatting['uid'] = null;
			$radiochatting['username'] = 'ÄäÃû['.$userip;
		}
		else{
			$radiochatting['uid'] = $_SGLOBAL['supe_uid'];
			$radiochatting['username'] = $_SGLOBAL['username'];
		}
		$radiochatting['ip'] = $userip;
		$radiochatting['rid'] = $_GET['rid'];
		$radiochatting['messagetime'] = $currenttime;
		
		//Ìæ»»±íÇé
		$message = $_POST['message'];
		$message = preg_replace("/\[em:(\d+):]/is", "<img src=\"http://www.echodrama.com/image/face/\\1.gif\" class=\"face\">", $message);
		$message = preg_replace("/\<br.*?\>/is", ' ', $message);
	
		$radiochatting['message'] = $message;
		inserttable("radio_chatting", $radiochatting);
		
		showmessage('do_success');
	}
}

?>