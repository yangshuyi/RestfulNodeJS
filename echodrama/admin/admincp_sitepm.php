<?php
/*
 [UCenter Home] (C) 2007-2008 Comsenz Inc.
 $Id: admincp_blog.php 9233 2008-10-28 06:21:44Z liguode $
 */

if(!defined('IN_UCHOME') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$_GET['op'] = empty($_GET['op'])?'manage':$_GET['op'];

//Ȩ��
if(!checkperm('managetopic')) {
	cpmessage('no_authority_management_operation');
}

include_once(S_ROOT.'./source/function_cp.php');

if($_GET['op'] == 'send') {
	$note=$_POST['note'];
	$qsql=$_POST['queryusersql'];
	$query = $_SGLOBAL['db']->query($qsql);
	$list=array();
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		notification_add($value[uid],"sitepm",$note,0);
	}
	
	
	showmessage('do_success', "admincp.php?ac=sitepm", 0);

} elseif($_GET['op'] == 'manage') {

	$pmtemplatelist=array();
	$pmtemplate=array();
	$pmtemplate['name']="��Ѱ�����û�";
	
	//only invite 45 last login member
	$curofftime = $_SGLOBAL['timestamp'] - 2592000*3; 
	$pmtemplate['queryusersql']="SELECT s.uid, s.username FROM ".tname('space')." s WHERE s.lastlogin>$curofftime";
	$pmtemplatelist[]=$pmtemplate;
	$pmtemplate['name']="��Ѱ���й���Ա";
	$pmtemplate['queryusersql']="SELECT s.uid FROM ysys_space s WHERE 1=1 AND s.groupid=1 ORDER BY s.uid";
	$pmtemplatelist[]=$pmtemplate;
	$pmtemplate['name']="��Ѱ���������û�";
	$pmtemplate['queryusersql']="SELECT s.uid FROM ysys_session s WHERE 1=1 ORDER BY s.uid";
	$pmtemplatelist[]=$pmtemplate;
	$pmtemplate['name']="��Ѱ����δ�������������û�";
	$pmtemplate['queryusersql']="select s.uid from ysys_space s where length(s.name)=0";
	$pmtemplatelist[]=$pmtemplate;
	
}

?>