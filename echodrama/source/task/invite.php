<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: invite.php 12304 2009-06-03 07:29:34Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//�û�������ɱ�ʶ���� 		$task['done']
//������ɽ��html�洢���� 	$task['result']
//�û�������html�洢���� 	$task['guide']

$query = $_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('invite')." WHERE uid='$space[uid]' AND fuid>'0'");
$count = $_SGLOBAL['db']->result($query, 0);

if($count >= 10) {
	
	$task['done'] = 1;//�������

} else {

	//���������
	if($count) {
		$task['guide'] .= '<p style="color:red;">�ۣ��������������Ѿ������� '.$count.' �������ˡ�����Ŭ����</p><br>';
	}
	$task['guide'] .= '<strong>�밴�����µ�˵������ɱ�����</strong>
		<ul class="task">
		<li>���´����д�<a href="cp.php?ac=invite" target="_blank">��������ҳ��</a>��</li>
		<li>ͨ��QQ��MSN��IM���ߣ����߷����ʼ������������Ӹ�����ĺ��ѣ��������Ǽ�������ɣ�</li>
		<li>����Ҫ����10�����Ѳ�����ɡ�</li>
		</ul>';

}

?>