<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: sample.php 11056 2009-02-09 01:59:47Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//���ñ�����$task['done'] (��ɱ�ʶ����) $task['result'] (�������) $task['guide'] (������)

//�ж��û��Ƿ����������
$done = 0;

//---------------------------------------------------
//	��д���룬�ж��û��Ƿ��������Ҫ�� $done = 1;
//---------------------------------------------------

$qsql="SELECT * FROM ".tname('resumehistory')." WHERE uid='$space[uid]' and currentflag=1";
$query = $_SGLOBAL['db']->query($qsql);
$value = $_SGLOBAL['db']->fetch_array($query);

if( !empty($value) ) {
	
	$task['done'] = 1;//�������
	$task['result'] .= '<p>����������ø��˼�����Ŀǰ״̬������������������Ѱ������ƥǧ����</p>';
	
} else {

	$task['guide'] .= '<strong>�밴�����µ�˵������ɱ�����</strong>
		<ul class="task">
		<li>����������<a href="cp.php?ac=resume&op=current" target="_blank">Ŀǰ״̬</a>��</li>
		</ul>';
}


?>