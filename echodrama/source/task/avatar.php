<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: avatar.php 13217 2009-08-21 06:57:53Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//�ж��û��Ƿ�������ͷ��
include_once(S_ROOT.'./source/function_cp.php');
$avatar_exists = trim(ckavatar($space['uid']));
if(strlen($avatar_exists) < 1) {
	showmessage('�������Ҫ������UCenter��Server�˵� avatar.php ������Ҫ����������<br>������Ǳ�վ����Ա����ͨ������ĵ�ַ���� avatar.php �ļ���ѹ����������������UCenter��Ŀ¼�е�ͬ���ļ����ɡ�<br><a href="http://u.discuz.net/download/avatar.zip">http://u.discuz.net/download/avatar.zip</a>');
}
	
if($avatar_exists) {

	//�������
	$task['done'] = 1;
	
	//�����û�ͷ���ʶλ
	updatetable('space', array('avatar'=>1), array('uid'=>$space['uid']));
	
	//������������ͷ����û�
	$wherearr = array();
	$wherearr[] = "s.uid=sf.uid";
	$wherearr[] = "s.avatar='1'";
	if($space['sex'] == 2) {
		$title = '˧��';
		$wherearr[] = "sf.sex='1'";
	} else {
		$title = '��Ů';
		$wherearr[] = "sf.sex='2'";
	}
	
	$space['friends'][] = $space['uid'];
	$nouids = implode(',', $space['friends']);
	$wherearr[] = "s.uid NOT IN ($nouids)";
	
	$query = $_SGLOBAL['db']->query("SELECT s.uid,s.username,s.name,s.namestatus
		FROM ".tname('space')." s, ".tname('spacefield')." sf
		WHERE ".implode(' AND ', $wherearr)."
		ORDER BY s.friendnum DESC LIMIT 0,10");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		realname_set($value['uid'], $value['username'], $value['name'], $value['namestatus']);
		$spaces[] = $value;
	}
	
	realname_get();
	
	if($spaces) {
		$task['result'] = '<p>�ҵ�'.$title.'���ѣ��Ƽ�������</p>';
		$task['result'] .= '<ul class="avatar_list">';
		foreach ($spaces as $key => $value) {
			$task['result'] .= '<li>
			<div class="avatar48"><a href="space.php?uid='.$value['uid'].'" target="_blank">'.avatar($value['uid'], 'small').'</a></div>
			<p><a href="space.php?uid='.$value['uid'].'" target="_blank" target="_blank">'.$_SN[$value['uid']].'</a></p>
			<p class=\"time\"><a href="cp.php?ac=friend&op=add&uid='.$value['uid'].'" id="a_reside_friend_'.$key.'" onclick="ajaxmenu(event, this.id, 1)">��Ϊ����</a></p>
			</li>';
		}
		$task['result'] .= '</ul>';
	}

} else {

	//���������
	$task['guide'] = '�밴�����µ�˵�������뱾����
		<ul>
		<li>1. <a href="cp.php?ac=avatar" target="_blank">�´��ڴ򿪸���ͷ������ҳ��</a>��</li>
		<li>2. ���´򿪵�����ҳ���У���ѡ��������Ƭ�����ϴ��༭��</li>
		</ul>';

}

?>