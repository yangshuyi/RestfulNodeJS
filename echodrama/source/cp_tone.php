<?php
/*
 [UCenter Home] (C) 2007-2008 Comsenz Inc.
 $Id: cp_tone.php 12436 2009-06-25 09:07:38Z liguode $
 */

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//�����Ϣ
$toneid = empty($_GET['toneid'])?0:intval($_GET['toneid']);
$id = empty($_GET['id'])?0:intval($_GET['id']);
$idtype = empty($_GET['idtype'])?'':trim($_GET['idtype']);
$_GET['op'] = empty($_GET['op'])?'new':$_GET['op'];
$op = empty($_GET['op'])?'':$_GET['op'];

// ��ȡ����������Ϣ
include_once(S_ROOT.'./data/data_toneclass.php');

include_once(S_ROOT.'./source/function_tone.php');


//TODO need implement for label
$tonelabellist=listtonelabel();

if($_GET['op'] == 'new') {


	//check the maxinum of user tone number
	if(checkusertonecount($_SGLOBAL['supe_uid'])>=10){
		showmessage('tone_reacah_max_size');// ��Ŀǰû��Ȩ�޽��д˲���
	}

	$nav_list = array();
	$nav_item = array();
	$nav_item['url'] = "space.php?do=tone"; $nav_item['dispname'] = "���߻���";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "space.php?do=tone&view=all"; $nav_item['dispname'] = "���߿��б�";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "cp.php?ac=tone&op=new"; $nav_item['dispname'] = "�ύ������";
	$nav_list[] = $nav_item;
}
elseif($_GET['op'] == 'toedit') {
	if(empty($toneid)) {
		showmessage("tone_does_not_exist"); // ���߲����ڻ����ѱ�ɾ��
	}
	submitcheck('tonesubmit');

	$tone=loadtonebyid($toneid);
	//���߲�����
	if(empty($tone)) {
		showmessage('tone_does_not_exist');
	}
	
	$tone = toneformmapper($tone);
	if($tone['uid'] != $_SGLOBAL['supe_uid']){
		showmessage('no_privilege');// ��Ŀǰû��Ȩ�޽��д˲���
	}
	
	$nav_list = array();
	$nav_item = array();
	$nav_item['url'] = "space.php?do=tone"; $nav_item['dispname'] = "���߻���";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "space.php?do=tone&view=all"; $nav_item['dispname'] = "���߿��б�";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "cp.php?ac=tone&op=toedit&toneid=$tone[toneid]"; $nav_item['dispname'] = "�༭����";
	$nav_list[] = $nav_item;
}
else if($_GET['op'] == 'edit') {
	if(empty($toneid)) {
		showmessage("tone_does_not_exist"); // ���߲����ڻ����ѱ�ɾ��
	}

	submitcheck('tonesubmit');

	$tone=loadtonebyid($toneid);
	//���߲�����
	if(empty($tone)) {
		showmessage('tone_does_not_exist');
	}
	if($tone['uid'] != $_SGLOBAL['supe_uid']){
		showmessage('no_privilege');// ��Ŀǰû��Ȩ�޽��д˲���
	}
		
	$tone['label'] = $_POST['label'];
	$tone['classid'] = $_POST['classid'];
	$tone['description'] = $_POST['description'];
	$tone['source'] = $_POST['source'];
	$tone['lastpost'] = $_SGLOBAL['timestamp'];

	//�������
	if(empty($tone['uid'])){
		showmessage('tone_uid_empty');
	} elseif(empty($tone['label'])){
		showmessage('tone_label_empty');
	} elseif(empty($tone['username'])){
		showmessage('tone_username_empty');
	} elseif(empty($tone['description'])) {
		showmessage('tone_description_empty');
	} elseif(empty($tone['classid'])) {
		showmessage('tone_classid_empty');
	}
	
	$tone['label']=updatetonelabel($tone['label']);
	updatetable('tone', $tone, array('toneid'=>$toneid));

	updateToneSpace($_SGLOBAL['supe_uid']);
	
	//������̬
	if($_POST['makefeed']) {
		include_once(S_ROOT.'./source/function_feed.php');
		feed_publish($toneid, 'toneid', 0);
	}	
	
	showmessage('do_success', $_POST['referlink'], 1);
}
else if($_GET['op'] == 'add') {

	submitcheck('tonesubmit');
	
	//check the maxinum of user tone number
	if(checkusertonecount($_SGLOBAL['supe_uid'])>=10){
		showmessage('tone_reach_max_size');// ��Ŀǰû��Ȩ�޽��д˲���
	}

	// ������
	$tone = Array();
	$tone['toneid'] = null;
	$tone['uid'] = $_SGLOBAL['supe_uid'];
	$tone['username'] = $_SGLOBAL['supe_username'];
	$tone['dateline'] = $_SGLOBAL['timestamp'];

	$tone['label'] = $_POST['label'];
	$tone['classid'] = $_POST['classid'];
	$tone['description'] = $_POST['description'];
	$tone['source'] = $_POST['source'];
	$tone['file'] = $_POST['file'];
	$tone['lastpost'] = $_SGLOBAL['timestamp'];

	$tone['file']=mp3_save($tone['file'],'tone');
	
	//�������
	if(empty($tone['uid'])){
		showmessage('tone_uid_empty');
	} elseif(empty($tone['username'])){
		showmessage('tone_username_empty');
	} elseif(empty($tone['description'])) {
		showmessage('tone_description_empty');
	} elseif(empty($tone['file'])) {
		showmessage('tone_file_empty');
	} elseif(empty($tone['classid'])) {
		showmessage('tone_classid_empty');
	}
	
	$tone['label']=updatetonelabel($tone['label']);
	$toneid = inserttable("tone", $tone, 1);
	
	updateToneSpace($_SGLOBAL['supe_uid']);

	updatetonereward($tone['uid'],'tone_new');

	//������̬
	if($_POST['makefeed']) {
		include_once(S_ROOT.'./source/function_feed.php');
		feed_publish($toneid, 'toneid', 0);
	}	
	
	showmessage('do_success', "space.php?do=tone&view=me", 1);

} 
elseif($_GET['op'] == 'pm') {

	if(!$toneid) {
		showmessage("tone_does_not_exist");
	}

	$tone=loadtonebyid($toneid);
	//���߲�����
	if(empty($tone)) {
		showmessage('tone_does_not_exist');
	}
	
	include_once S_ROOT.'./uc_client/client.php';
	$result=uc_pm_send($_SGLOBAL['supe_uid'], $tone[uid], "������$_SGLOBAL[supe_username]�����Ļ�", $_POST['message'], 1, $pmid, 0);
	
	showmessage($result);
} 
elseif($_GET['op'] == 'share') {
	if(empty($toneid)) {
		showmessage("tone_does_not_exist"); // �����߲����ڻ����ѱ�ɾ��
	}

	//AJAX CALL
	$_SGLOBAL['inajax'] = 1;

	$tone=loadtonebyid($toneid);
	//���߲�����
	if(empty($tone)) {
		showmessage('tone_does_not_exist');
	}
	
	if($_GET['toshare']==0){
		//ȡ���ղ�
		$tuSql = "DELETE FROM ".tname('toneuser')." WHERE toneid=$toneid and uid=$_SGLOBAL[supe_uid]";
		$_SGLOBAL['db']->query($tuSql);

	}else if($_GET['toshare']==1){
		//�����ղ�
		$tuSql = "SELECT COUNT(id) FROM ".tname('toneuser')." WHERE toneid=$toneid and uid=$_SGLOBAL[supe_uid]";
		$tuCount = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($tuSql), 0);
		if($tuCount<=0){
			$toneuser = Array();
			$toneuser['id'] = null;
			$toneuser['uid'] = $_SGLOBAL['supe_uid'];
			$toneuser['toneid'] = $toneid;
			$toneuser['username'] = $_SGLOBAL['supe_username'];
			$toneuser['dateline'] = $_SGLOBAL['timestamp'];
			inserttable("toneuser", $toneuser);
		}
	}else{
		showMessage("no action");
	}


	$updatesharesql="UPDATE ".tname('tone')." SET joinnum = (SELECT COUNT(id) FROM ".tname('toneuser')." WHERE toneid=$toneid ) where toneid=$toneid";
	$_SGLOBAL['db']->query($updatesharesql);

	showmessage('ajax_param', '', 0, array($tuCount,$_GET['toshare']));
} 
elseif($_GET['op'] == 'poll') {
	if(empty($toneid)) {
		showmessage("tone_does_not_exist"); 
	}
	
	$tone=loadtonebyid($toneid);
	//���߲�����
	if(empty($tone)) {
		showmessage('tone_does_not_exist');
	}
	
	$userip=getonlineip();
	$tonepollsql= "SELECT * FROM ".tname('tonepoll')." tp WHERE tp.toneid=$toneid and ( tp.uid='$_SGLOBAL[supe_uid]' OR tp.userip='$userip' )";
	$tonepoll = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($tonepollsql));
	if( !empty($tonepoll) ){
		return;
	}
	
	//AJAX CALL
	$_SGLOBAL['inajax'] = 1;
	
	$tonepoll = array();
	$tonepoll['toneid']=$toneid;
	$tonepoll['uid']= $_SGLOBAL['supe_uid'];
	$tonepoll['username']= $_SGLOBAL['supe_username'];
	$tonepoll['userip']=getonlineip();
	$tonepoll['pollvalue']=$_GET['tonepollvalue'];
	$tonepoll['polldateline']=$_SGLOBAL['timestamp'];;
	inserttable("tonepoll", $tonepoll);
	
	$updatepollinforSql="  UPDATE ".tname('tone')." ";
	$updatepollinforSql.=" SET poll_".$tonepoll['pollvalue']." = (SELECT COUNT(tonepollid) FROM ".tname('tonepoll')." WHERE toneid=$toneid AND pollvalue='$tonepoll[pollvalue]' )";
	$updatepollinforSql.=" WHERE toneid=$toneid";
	$_SGLOBAL['db']->query($updatepollinforSql);
	
	showmessage('ajax_param', '', 0, array($_GET['toneid'], $_GET['tonepollvalue']));
}
elseif($_GET['op'] == 'viewpoll') {
	if(empty($toneid)) {
		showmessage("tone_does_not_exist"); 
	}
	
	$tone=loadtonebyid($toneid);
	//���߲�����
	if(empty($tone)) {
		showmessage('tone_does_not_exist');
	}
	$tone = toneformmapper($tone);
	
	include_once template("space_tone_poll");
}
elseif($_GET['op'] == 'delete') {
	//ɾ��

	if(deletetones(array($toneid))) {
		
		updateToneSpace($_SGLOBAL['supe_uid']);
	
		showmessage('do_success', $_POST['referlink']);
	} else {
		showmessage('failed_to_delete_operation');
	}
} 
elseif($_GET['op'] == 'invite') {
	//����
	$tone=loadtonebyid($toneid);
	//���߲�����
	if(empty($tone)) {
		showmessage('tone_does_not_exist');
	}
	if($tone['uid'] != $_SGLOBAL['supe_uid']){
		showmessage('no_privilege');// ��Ŀǰû��Ȩ�޽��д˲���
	}
	
	$uidarr = explode(',', $tone['invite']);
	//��ת����
	$newuid = array_flip($uidarr);
	if(submitcheck('invitesubmittype')) {
		
		if($_POST["invitesubmittype"]==1){ //invite target
			$ids = empty($_POST['ids'])?array():$_POST['ids'];
		}
		elseif($_POST['invitesubmittype']==2){ //invite all
			$friendsql="SELECT * FROM ".tname('friend')." WHERE uid='$tone[uid]' AND status='1'";
			$query = $_SGLOBAL['db']->query($friendsql);
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				$ids[] = $value['fuid'];
			}
		}
		if($ids) {
			//������������û�
			foreach($ids as $key => $uid) {
				if(isset($newuid[$uid])) {
					unset($ids[$key]);
				} else {
					$ids[$key] = intval($uid);
				}
			}
			
			//��֤�û�����ʵ��
			$query = $_SGLOBAL['db']->query("SELECT uid FROM ".tname('space')." WHERE uid IN (".simplode($ids).")");
			$ids = array();
			while($value = $_SGLOBAL['db']->fetch_array($query)) {
				$ids[$value['uid']] = $value['uid'];
			}
			//�ϲ�������
			$newinvite = array_merge($uidarr, $ids);
			
			//�������ݿ�
			if($newinvite) {
				$_SGLOBAL['db']->query("UPDATE ".tname('tone')." SET invite='".implode(',', $newinvite)."' WHERE toneid='$toneid'");
			}
			//֪ͨ
			$tone = toneformmapper($tone);
			$note = "������һ�����͸������� <a href=\"space.php?do=tone&toneid=$tone[toneid]\" target=\"_blank\"> $tone[classname] - $tone[label]</a>";
			foreach($ids as $key => $uid) {
				if($uid && $uid != $_SGLOBAL['supe_uid']) {
					notification_add($uid, 'toneinvite', $note);
				}
			}
		}
		showmessage('do_success', "cp.php?ac=tone&op=invite&toneid=$tone[toneid]&group=$_GET[group]&page=$_GET[page]&start=$_GET[start]", 1);
	}
	
	//��ҳ
	$perpage = 24;
	$page = empty($_GET['page'])?0:intval($_GET['page']);
	if($page<1) $page = 1;
	$start = ($page-1)*$perpage;
		
	//��鿪ʼ��
	ckstart($start, $perpage);
		
	$list = array();

	$wherearr = array();
	$_GET['group'] = isset($_GET['group'])?intval($_GET['group']):-1;
	if($_GET['group'] >= 0) {
		$wherearr[] = " gid='$_GET[group]'";
	}

	$sql = $wherearr ? 'AND'.implode(' AND ', $wherearr) : '';
		
	$csql = "SELECT COUNT(*) FROM ".tname('friend')." WHERE uid='$tone[uid]' AND status='1' $sql";
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($csql), 0);
	$fuids = array();
	if($count) {
		$friendsql="SELECT * FROM ".tname('friend')." WHERE uid='$tone[uid]' AND status='1' $sql ORDER BY num DESC, dateline DESC LIMIT $start,$perpage";
		$query = $_SGLOBAL['db']->query($friendsql);
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			realname_set($value['fuid'], $value['fusername']);
			$list[] = $value;
			$fuids[] = $value['fuid'];
		}
	}
	$invitearr = array();
	
	//������
	foreach($uidarr as $key => $uid) {
		$invitearr[$uid] = $uid;
	}
	
	realname_get();
			
	//�û���
	$groups = getfriendgroup();
	$groupselect = array($_GET['group'] => ' selected');
		
	$multi = multi($count, $perpage, $page, "cp.php?ac=tone&op=invite&toneid=$tone[toneid]&group=$_GET[group]");
	
	$nav_list = array();
	$nav_item = array();
	$nav_item['url'] = "space.php?do=tone"; $nav_item['dispname'] = "���߻���";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "space.php?do=tone&view=all"; $nav_item['dispname'] = "���߿��б�";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "cp.php?ac=tone&op=invite&toneid=$tone[toneid]"; $nav_item['dispname'] = "�������";
	$nav_list[] = $nav_item;
} 
else if($_GET['op'] == 'return') {
	//TODO ò�������⣬�޷�������ת	
	//showmessage('do_success', $_GET['refer'], 0);
}

include_once template("cp_tone");

?>