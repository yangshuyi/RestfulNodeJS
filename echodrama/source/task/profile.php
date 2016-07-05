<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: profile.php 13217 2009-08-21 06:57:53Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//�ж��û��Ƿ�ȫ�������˸�������
$nones = array();
$profile_lang = array(
	'name' => '����',
	'sex' => '�Ա�',
	'birthyear' => '����(��)',
	'birthmonth' => '����(��)',
	'birthday' => '����(��)',
	'blood' => 'Ѫ��',
	'marry' => '����״̬',
	'birthprovince' => '����(ʡ)',
	'birthcity' => '����(��)',
	'resideprovince' => '��ס��(ʡ)',
	'residecity' => '��ס��(��)'
);
foreach (array('name','sex','birthyear','birthmonth','birthday','marry','birthprovince','birthcity','resideprovince','residecity') as $key) {
	$value = trim($space[$key]);
	if(empty($value)) {
		$nones[] = $profile_lang[$key];
	}
}
//վ����չ
@include_once(S_ROOT.'./data/data_profilefield.php');
foreach ($_SGLOBAL['profilefield'] as $field => $value) {
	if($value['required'] && empty($space['field_'.$field])) {
		$nones[] = $value['title'];
	}
}

if(empty($nones)) {

	$task['done'] = 1;//�������
	
	//�Զ��Һ���
	$findmaxnum = 10;
	$space['friends'][] = $space['uid'];
	$nouids = implode(',', $space['friends']);

	//��ס�غ���
	$residelist = array();
	$warr = array();
	$warr[] = "sf.resideprovince='".addslashes($space['resideprovince'])."'";
	$warr[] = "sf.residecity='".addslashes($space['residecity'])."'";
	$query = $_SGLOBAL['db']->query("SELECT s.uid,s.username,s.name,s.namestatus FROM ".tname('spacefield')." sf
		LEFT JOIN ".tname('space')." s ON s.uid=sf.uid
		WHERE ".implode(' AND ', $warr)." AND sf.uid NOT IN ($nouids)
		LIMIT 0,$findmaxnum");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		realname_set($value['uid'], $value['username'], $value['name'], $value['namestatus']);
		$residelist[] = $value;
	}

	//�Ա����
	$sexlist = array();
	$warr = array();
	if(empty($space['marry']) || $space['marry'] < 2) {//����
		$warr[] = "sf.marry='1'";//����
	}
	if(empty($space['sex']) || $space['sex'] < 2) {//����
		$warr[] = "sf.sex='2'";//Ů��
	} else {
		$warr[] = "sf.sex='1'";//����
	}
	$query = $_SGLOBAL['db']->query("SELECT s.uid,s.username,s.name,s.namestatus FROM ".tname('spacefield')." sf
		LEFT JOIN ".tname('space')." s ON s.uid=sf.uid
		WHERE ".implode(' AND ', $warr)." AND sf.uid NOT IN ($nouids)
		LIMIT 0,$findmaxnum");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		realname_set($value['uid'], $value['username'], $value['name'], $value['namestatus']);
		$sexlist[] = $value;
	}
	
	realname_get();
	
	if($residelist) {
		$task['result'] .= '<p>Ϊ���ҵ�ͬ�ǵĻ�Ա���Ͽ��Ϊ���Ѱɣ�</p>';
		$task['result'] .= '<ul class="avatar_list">';
		foreach ($residelist as $key => $value) {
			$task['result'] .= '<li>
				<div class="avatar48"><a href="space.php?uid='.$value['uid'].'" target="_blank">'.avatar($value['uid'], 'small').'</a></div>
				<p><a href="space.php?uid='.$value['uid'].'" target="_blank">'.$_SN[$value['uid']].'</a></p>
				<p><a href="cp.php?ac=friend&op=add&uid='.$value['uid'].'" id="a_reside_friend_'.$key.'" onclick="ajaxmenu(event, this.id, 1)">��Ϊ����</a></p>
				</li>';
		}
		$task['result'] .= '</ul>';
	}
	if($sexlist) {
		$task['result'] .= '<p>Ϊ���ҵ��������Ż�Ա���Ͽ��Ϊ���Ѱɣ�</p>';
		$task['result'] .= '<ul class="avatar_list">';
		foreach ($sexlist as $key => $value) {
			$task['result'] .= '<li>
				<div class="avatar48"><a href="space.php?uid='.$value['uid'].'" target="_blank">'.avatar($value['uid'], 'small').'</a></div>
				<p><a href="space.php?uid='.$value['uid'].'" target="_blank">'.$_SN[$value['uid']].'</a></p>
				<p><a href="cp.php?ac=friend&op=add&uid='.$value['uid'].'" id="a_sex_friend_'.$key.'" onclick="ajaxmenu(event, this.id, 1)">��Ϊ����</a></p>
				</li>';
		}
		$task['result'] .= '</ul>';
	}

} else {

	//���������
	$task['guide'] = '
		<strong>���������¸�����������Ҫ����������</strong><br>
		<span style="color:red;">'.implode('<br>', $nones).'</span><br><br>
		<strong>�밴�����µ�˵������ɱ�����</strong>
		<ul>
		<li><a href="cp.php?ac=profile" target="_blank">�´��ڴ򿪸�����������ҳ��</a>��</li>
		<li>���´򿪵�����ҳ���У��������������ϲ���������</li>
		</ul>';

}

?>