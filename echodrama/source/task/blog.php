<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: blog.php 11056 2009-02-09 01:59:47Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

$blogcount = getcount('blog', array('uid'=>$space['uid']));
if($blogcount) {

	$task['done'] = 1;//�������

} else {

	//���������
	$task['guide'] = '
		<strong>�밴�����µ�˵�������뱾����</strong>
		<ul>
		<li>1. <a href="cp.php?ac=blog" target="_blank">�´��ڴ򿪷����ռ�ҳ��</a>��</li>
		<li>2. ���´򿪵�ҳ���У���д�Լ��ĵ�һƪ�ռǣ������з�����</li>
		</ul>';

}

?>