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

$qsql="SELECT COUNT(distinct uid) AS pokecount FROM ".tname('poke')." WHERE fromuid='$space[uid]'";
$query = $_SGLOBAL['db']->query($qsql);
$value = $_SGLOBAL['db']->fetch_array($query);

if( !empty($value) && $value['pokecount']>=10 ) {
	
	$task['done'] = 1;//�������
	$task['result'] .= '<p>���Ѻ�'.$value['pokecount'].'�����Ѵ��к��ˣ��㻹��������Ե�ء�</p>';
	
} else {

	$task['guide'] .= '<strong>�밴�����µ�˵������ɱ�����</strong>
		<ul class="task">
		<li>���Ѻ�'.$value['pokecount'].'�����Ѵ���к��ˡ�</li>
		<li>��¼�������˵ĳ�����Ժ󣬵��TAͷ���·��ġ�����к������ӣ�˵��hi�ɡ�</li>
		</ul>';
}


?>