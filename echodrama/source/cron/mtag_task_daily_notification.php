<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: log.php 11425 2009-03-05 05:11:17Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//һ�δ���ĸ�������ֹ��ʱ
execute();

function execute(){
	global $_SGLOBAL, $_SC;
	
	include_once(S_ROOT.'./source/function_cp.php');

	$datestr = sgmdate('Y-m-d', $_SGLOBAL['timestamp']) ;
	$date = sstrtotime($datestr);
	$qsql="SELECT * FROM ".tname('mtagtask')." WHERE endtime = '$date'";
	$list=array();
	
	$query = $_SGLOBAL['db']->query($qsql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$list[] = $value;
	}	

	foreach($list as $task){
		$memberidarr = explode(',', $task['members']);

		$qsql="SELECT distinct mm.uid, m.tagid AS tagid, m.tagname AS tagname FROM ".tname('mtagmember')." mm LEFT OUTER JOIN ".tname('mtag')." m ON m.tagid = mm.tagid ";
		$qsql.=" WHERE mm.memberid in (0$task[members]0)";
		
		$memberlist = array();
		$query = $_SGLOBAL['db']->query($qsql);
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			$memberlist[] = $value;
		}
		
		foreach($memberlist as $member){
			$notification = "����<a href=\"space.php?do=mtag&tagid=$member[tagid]\" target=\"_blank\">$member[tagname]Ⱥ��</a>";
			$notification .= "��<a href=\"space.php?do=mtag&view=task&tagid=$member[tagid]&taskid=$task[taskid]\" target=\"_blank\">$task[subject]��Ա����</a>�Ѿ������һ���ˣ���ȷ�ϡ�";
			notification_add($member['uid'], 'mtag_task', $notification);
		}
	}
}
?>