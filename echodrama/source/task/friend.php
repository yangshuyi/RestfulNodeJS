<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: friend.php 11056 2009-02-09 01:59:47Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

if($space['friendnum']>=5) {

	$task['done'] = 1;//�������

} else {

	//��
	$task['guide'] = '
		<strong>�밴�����µ�˵�������뱾����</strong>
		<ul>
		<li>1. <a href="cp.php?ac=friend&op=find" target="_blank">�´��ڴ�Ѱ�Һ���ҳ��</a>��</li>
		<li>2. ���´򿪵�ҳ���У����Խ�ϵͳ�Զ������ҵ����Ƽ��û���Ϊ���ѣ�Ҳ�����Լ���������Ѱ�Ҳ����Ϊ���ѣ�</li>
		<li>3. ��������������Ҫ�ȴ��Է���׼���ĺ������롣</li>
		</ul>';

}

?>