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

$qsql="SELECT COUNT(tid) AS count FROM ".tname('mtag_thread')." WHERE tagid = ".FORUM_TAGID." AND uid='$space[uid]'";
$query = $_SGLOBAL['db']->query($qsql);
$value = $_SGLOBAL['db']->fetch_array($query);

if( !empty($value) && $value['count']>0 ) {
	
	$task['done'] = 1;//�������
	$task['result'] .= '<p>��������Ӿ���Ϸ���'.$value['postcount'].'ƪ���ӡ�</p>';
	
} else {

	$task['guide'] .= '<strong>�밴�����µ�˵������ɱ�����</strong>
		<ul class="task">
		<li>������ܲ˵��ġ�<a href="space.php?do=forum" target="_blank">��Ӿ��</a>�����ӣ�ȥ��̳���黶�ְɡ�</li>
		</ul>';
}


?>