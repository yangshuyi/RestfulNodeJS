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

$userip=getonlineip();
$topicpollsql= "SELECT * FROM ".tname('topicpoll')." tp WHERE tp.uid='$_SGLOBAL[supe_uid]' OR tp.userip='$userip' ";
$topicpoll = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($topicpollsql));

if( !empty($value) ) {
	
	$task['done'] = 1;//�������
	$task['result'] .= '<p>��л��Ϊ��ϲ���ľ���Ͷ������ϵ�һƱ��лл��</p>';
	
} else {

	$task['guide'] .= '<strong>֪ͨ��</strong>
		<ul class="task">
		<li>�㲥����ϸҳ���Ѿ�֧��ͶƱ����Ϊ��ϲ������ƷͶƱ֧���¡���ʽ��������ѡ���ھ����·�������Ǻ�ѡ��ͶƱ�����ɣ�</li>
		</ul>';
}


?>