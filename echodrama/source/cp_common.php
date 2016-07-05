<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: cp_common.php 12872 2009-07-24 01:55:54Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

$op = empty($_GET['op'])?'':trim($_GET['op']);

if($op == 'logout') {
	
	if($_GET['uhash'] == $_SGLOBAL['uhash']) {
		//删除session
		if($_SGLOBAL['supe_uid']) {
			$_SGLOBAL['db']->query("DELETE FROM ".tname('session')." WHERE uid='$_SGLOBAL[supe_uid]'");
			$_SGLOBAL['db']->query("DELETE FROM ".tname('adminsession')." WHERE uid='$_SGLOBAL[supe_uid]'");//管理平台
		}
	
		if($_SCONFIG['uc_status']) {
			include_once S_ROOT.'./uc_client/client.php';
			$ucsynlogout = uc_user_synlogout();
		} else {
			$ucsynlogout = '';
		}
	
		clearcookie();
		ssetcookie('_refer', '');
	}
	showmessage('security_exit', 'index.php', 1, array($ucsynlogout));

} elseif($op == 'seccode') {

	if(ckseccode(trim($_GET['code']))) {
		showmessage('succeed');
	} else {
		showmessage('incorrect_code');
	}

} elseif($op == 'report') {

	$_GET['idtype'] = trim($_GET['idtype']);
	$_GET['id'] = intval($_GET['id']);
	$uidarr = $report = array();
	
	if(!in_array($_GET['idtype'], array('picid', 'blogid', 'albumid', 'tagid', 'threadid', 'shareid', 'uid', 'pollid', 'eventid', 'topicid', 'coverid', 'videoid', 'toneid', 'repasteid', 'commentid', 'postid')) || empty($_GET['id'])) {
		showmessage('report_error');
	}
	//获取举报记录
	
	$qsql="SELECT * FROM ".tname('report')." WHERE id='$_GET[id]' AND idtype='$_GET[idtype]'";
	
	$query = $_SGLOBAL['db']->query($qsql);
	if($report = $_SGLOBAL['db']->fetch_array($query)) {
		$useridindex=stripos($report['userids'],"/".$_SGLOBAL['supe_uid']."/");
		if($useridindex>=0){
			showmessage('repeat_report');
		}
		$uidarr = unserialize($report['uids']);
	}

	if(submitcheck('reportsubmit')) {
		$reason = getstr($_POST['reason'], 150, 1, 1);

		$reason = "<li><strong><a href=\"space.php?uid=$space[uid]\" target=\"_blank\">$_SGLOBAL[supe_username]</a>:</strong> ".$reason.' ('.sgmdate('Y-m-d H:i').')</li>';

		include_once(S_ROOT.'./source/function_report.php');
	
		$rid=null;
		if($report) {
			$report_userids=$report['userids'].$_SGLOBAL['supe_uid']."/";
			$report_usernames=$report['usernames'].$_SGLOBAL['username']."/";
			
			$uidarr[$space['uid']] = $_SGLOBAL['supe_uid'];
			$uids = addslashes(serialize($uidarr));
			$reason = addslashes($report['reason']).$reason;
			$_SGLOBAL['db']->query("UPDATE ".tname('report')." SET num=num+1, reason='$reason', dateline='$_SGLOBAL[timestamp]', processstate='0', userids='$report_userids', usernames='$report_usernames', uids='$uids' WHERE rid='$report[rid]'");
			$rid = $report['rid'];
		} else {
			$uidarr[$space['uid']] = $space['username'];

			$setarr = array(
				'id' => $_GET['id'],
				'idtype' => $_GET['idtype'],
				'num' => 1,
				'new' => 1,
				'processstate' => 0,
				'userids' => '/'.$_SGLOBAL['supe_uid'].'/',
				'usernames' => '/'.$_SGLOBAL['username'].'/',
				'reason' => $reason,
				'uids' => addslashes(serialize($uidarr)),
				'dateline' => $_SGLOBAL['timestamp']
			);
			$rid = inserttable('report', $setarr, 1);
		}
		
		$qsql = "SELECT * FROM ".tname('report')." WHERE rid=$rid";
		$list = queryreport($qsql);
		if(count($list)==0){
			showmessage("report_does_not_exist"); 
		}
		
		$notification=null;
		foreach($list as $report){
			$notification="<br/>举报项目ID[<a href='space.php?do=report&op=viewsingle&reportid=$report[rid]' target='_blank'>$report[rid]</a>]";
			$notification.="<br/>$report[dispidtype]模块的<a href=\"$report[url]\" target=\"_blank\">$report[subject]</a>存在问题。";
		}
		
		$adminusersql="SELECT s.uid FROM ysys_space s WHERE 1=1 AND s.groupid=1 ORDER BY s.uid";
		$query = $_SGLOBAL['db']->query($adminusersql);
		$list=array();
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			notification_add($value[uid],"report_new",$notification,0);
		}
		
		showmessage('report_success');
	}

	//判断是否是被忽略的举报
	if(isset($report['num']) && $report['num'] < 1) {
		showmessage('the_normal_information');
	}

	$reason = explode("\r\n", trim(preg_replace("/(\s*(\r\n|\n\r|\n|\r)\s*)/", "\r\n", data_get('reason'))));
	if(is_array($reason) && count($reason) == 1 && empty($reason[0])) {
		$reason = array();
	}

} elseif($op == 'ignore') {

	$type = empty($_GET['type'])?'':preg_replace("/[^0-9a-zA-Z\_\-\.]/", '', $_GET['type']);
	if(submitcheck('ignoresubmit')) {
		$authorid = empty($_POST['authorid']) ? 0 : intval($_POST['authorid']);
		if($type) {
			$type_uid = $type.'|'.$authorid;
			if(empty($space['privacy']['filter_note']) || !is_array($space['privacy']['filter_note'])) {
				$space['privacy']['filter_note'] = array();
			}
			$space['privacy']['filter_note'][$type_uid] = $type_uid;
			privacy_update();
		}
		showmessage('do_success', $_POST['refer']);
	}
	$formid = random(8);

} elseif($op == 'closefeedbox') {

	ssetcookie('closefeedbox', 1);

} elseif($op == 'changetpl') {

	$dir = empty($_GET['name'])?'':str_replace('.','', trim($_GET['name']));
	if($dir && file_exists(S_ROOT.'./template/'.$dir.'/style.css')) {
		ssetcookie('mytemplate', $dir, 3600*24*365);//长期有效
	}
	showmessage('do_success', 'space.php?do=feed', 0);
} elseif($op == 'adclick') {

	//积分 $action, $update=1, $uid=0, $needle='', $setcookie = 1
	$reward = getreward("ad_click", 1, $_SGLOBAL[supe_uid]);
}

include template('cp_common');

?>
