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

$qsql="SELECT COUNT(id) AS topicusercount FROM ".tname('topicuser')." WHERE uid='$space[uid]'";
$query = $_SGLOBAL['db']->query($qsql);
$value = $_SGLOBAL['db']->fetch_array($query);

if( !empty($value) && $value['topicusercount']>0 ) {
	
	$task['done'] = 1;//�������
	$task['result'] .= '<p>��������ղع㲥�磬лл��Ĳ��롣</p>';
	
} else {

	$task['guide'] .= '<strong>�밴�����µ�˵������ɱ�����</strong>
		<ul class="task">
		<li>����ϲ����<a href="space.php?do=topic&view=single" target="_blank">�㲥��</a>�ղ������ɣ��´ξͲ����ڲ��ҿ�����</li>
		</ul>';
}


?>