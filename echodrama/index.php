<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: index.php 13003 2009-08-05 06:46:06Z liguode $
*/

include_once('./common.php');

if(is_numeric($_SERVER['QUERY_STRING'])) {
	showmessage('enter_the_space', "space.php?uid=$_SERVER[QUERY_STRING]", 0);
}

//��������
if(!isset($_GET['do']) && $_SCONFIG['allowdomain']) {
	$hostarr = explode('.', $_SERVER['HTTP_HOST']);
	$domainrootarr = explode('.', $_SCONFIG['domainroot']);
	if(count($hostarr) > 2 && count($hostarr) > count($domainrootarr) && $hostarr[0] != 'www' && !isholddomain($hostarr[0])) {
		showmessage('enter_the_space', $_SCONFIG['siteallurl'].'space.php?domain='.$hostarr[0], 0);
	}
}

if($_SGLOBAL['supe_uid']) {
	//�ѵ�¼��ֱ����ת������ҳ
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('space')." WHERE uid='$setarr[uid]'");
	$space = $_SGLOBAL['db']->fetch_array($query);
	
	$forwardurl = "";
	if($space['loginsucessforwardflag'] == 2){
		//�����
		$forwardurl = 'space.php?do=home';
	}
	elseif($space['loginsucessforwardflag'] == 1){
		//�㲥���Ż�
		$forwardurl = 'portal_topic.php';
	}
	elseif($space['loginsucessforwardflag'] == 0){
		//��ҳ
		$forwardurl = 'portal_index.php';
	}
	else{
		//��ҳ
		$forwardurl = 'portal_index.php';
	}
	
	showmessage('enter_the_space', $forwardurl, 0);
}

include_once(S_ROOT.'./portal_index.php');


?>