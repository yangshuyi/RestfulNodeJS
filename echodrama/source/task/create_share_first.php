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

$qsql="SELECT COUNT(sid) AS sharecount FROM ".tname('share')." WHERE uid='$space[uid]'";
$query = $_SGLOBAL['db']->query($qsql);
$value = $_SGLOBAL['db']->fetch_array($query);

if( !empty($value) && $value['sharecount']>0 ) {
	
	$task['done'] = 1;//�������
	$task['result'] .= '<p>������ɷ������Լ��ĺö�����˳��Ҳȥ����<a href="space.php?uid='.$space[uid].'&do=share&view=all" target="_blank">��ҵķ���</a>�ɡ�</p>';
	
} else {

	$task['guide'] .= '<strong>�밴�����µ�˵������ɱ�����</strong>
		<ul class="task">
		<li>���Լ��а��Ĺ㲥�磬���ߣ��ռǣ�ͼƬ��һ�е�һ�з�����Լ��ĺ��Ѱɡ��ǵ���д����ʱ�ĸ���Ŷ����</li>
		</ul>';
}


?>