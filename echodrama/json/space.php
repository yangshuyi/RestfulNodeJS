<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space.php 13003 2009-08-05 06:46:06Z liguode $
*/

include_once('./common.php');
include_once(S_ROOT.'./data/data_magic.php');


//��������
//$dos = array('feed', 'doing', 'mood', 'blog', 'repaste', 'album', 'thread', 'mtag', 'friend', 'wall', 'tag', 'notice', 'share', 'report', 'topic', 'topicalbum', 'cover', 'video', 'tone', 'home', 'pm', 'event', 'poll', 'top', 'info', 'resume', 'videophoto', 'sitegift', 'postnote', 'radio', 'forum', 'myfarm');
$dos = array('topic', 'tudou');

//��ȡ����
$uid = empty($_GET['uid'])?0:intval($_GET['uid']);
$username = empty($_GET['username'])?'':$_GET['username'];
$domain = empty($_GET['domain'])?'':$_GET['domain'];
$do = (!empty($_GET['do']) && in_array($_GET['do'], $dos))?$_GET['do']:'index';
$op = !empty($_GET['op'])?$_GET['op']:'list';

if($do == 'home') {
	$do = 'feed';
} 
elseif ($do == 'index') {
	//�������
	$invite = empty($_GET['invite'])?'':$_GET['invite'];
	$code = empty($_GET['code'])?'':$_GET['code'];
	$reward = getreward('invitecode', 0);
	if($code && !$reward['credit']) {
		$isinvite = -1;
	} elseif($invite) {
		$isinvite = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT id FROM ".tname('invite')." WHERE uid='$uid' AND code='$invite' AND fuid='0'"), 0);
	}
}

//��ȡ�ռ�
if($uid) {
	$space = getspace($uid, 'uid');
	if(empty($space)) {
		showmessage_JSON('space_does_not_exist');
	}
} 
elseif ($username) {
	$space = getspace($username, 'username');
} 
elseif ($domain) {
	$space = getspace($domain, 'domain');
} 
elseif ($_SGLOBAL['supe_uid']) {
	$space = getspace($_SGLOBAL['supe_uid'], 'uid');
}

if($space) {
	
	//��֤�ռ��Ƿ�����
	if($space['flag'] == -1) {
		showmessage_JSON('space_has_been_locked');
	}
	
	//��˽���
	if(empty($isinvite) || ($isinvite<0 && $code != space_key($space, $_GET['app']))) {
		//�ο�
		if(empty($_SCONFIG['networkpublic'])) {
			checklogin();//��Ҫ��¼
		}
		if(!ckprivacy($do)) {
			include template('space_privacy');
			exit();
		}
	}
	
	if( ($do=="topic" || $do=="tone" || $do=="cover" || $do=="video" || $do=="repaste" || $do=="postnote" || $do=="thread" )&& !empty($_GET['view'])){
	}
	else{
		//����ֻ�鿴�Լ�
		if(!$space['self']) {
			$_GET['view'] = 'me';
		} else if(empty($space['feedfriend']) && empty($_GET['view'])) {
			if( $do=="topic" || $do=="mtag" || $do=="forum" || $do=="thread"){
				
			}
			else{
				$_GET['view'] = 'all';
			}
		}
		if ($_GET['view'] == 'me') {
			$space['feedfriend'] = '';
		}
	}
	
} elseif($uid) {

	//�жϵ�ǰ�û��Ƿ�ɾ��
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('spacelog')." WHERE uid='$uid' AND flag='-1'");
	if($value = $_SGLOBAL['db']->fetch_array($query)) {
		showmessage_JSON('the_space_has_been_closed');
	}
	
	//δ��ͨ�ռ�
	include_once(S_ROOT.'./uc_client/client.php');
	if($user = uc_get_user($uid, 1)) {
		$space = array('uid' => $user[0], 'username' => $user[1], 'dateline'=>$_SGLOBAL['timestamp'], 'friends'=>array());
		$_SN[$space['uid']] = $space['username'];
	}
}

//�ο�
if(empty($space)) {
	$space = array('uid'=>0, 'username'=>'guest', 'self'=>1);
	if($do == 'index') $do = 'feed';
}

//���»session
if($_SGLOBAL['supe_uid']) {
	
	getmember(); //��ȡ��ǰ�û���Ϣ
	
	if($_SGLOBAL['member']['flag'] == -1) {
		showmessage_JSON('space_has_been_locked');
	}
	
	//��ֹ����
	if(checkperm('banvisit')) {
		ckspacelog();
		showmessage_JSON('you_do_not_have_permission_to_visit');
	}
	
	updatetable('session', array('lastactivity' => $_SGLOBAL['timestamp']), array('uid'=>$_SGLOBAL['supe_uid']));
}

//�ƻ�����
if(UC_IP=="60.191.232.59"){
	if(!empty($_SCONFIG['cronnextrun']) && $_SCONFIG['cronnextrun'] <= $_SGLOBAL['timestamp']) {
		include_once S_ROOT.'./source/function_cron.php';
		runcron();
	}
}

//ϵͳ��������
$sitegift = 0;
$giftvalue = rand(0,25);

if( ($giftvalue==1) && ($_SGLOBAL['timestamp'] < sstrtotime('2010-08-02')) ){
	$sitegift = 1;
}

//����
include_once(S_JSON_ROOT."./space_{$do}_{$op}.php");

?>