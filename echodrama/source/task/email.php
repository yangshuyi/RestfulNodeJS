<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: email.php 12304 2009-06-03 07:29:34Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

if($space['emailcheck']) {

	$task['done'] = 1;//�������

} else {

	//���������
	$task['guide'] = '
		<strong>�밴�����µ�˵�������뱾����</strong>
		<ul>
		<li><a href="cp.php?ac=profile&op=contact" target="_blank">�´��ڴ��˺�����ҳ��</a>��</li>
		<li>���´򿪵�����ҳ���У����Լ���������ʵ��д�����������֤���䡱��ť��</li>
		<li>�����Ӻ�ϵͳ����㷢��һ���ʼ����յ��ʼ����밴���ʼ���˵���������ʼ��е���֤���ӾͿ����ˡ�</li>
		</ul>';

}

?>