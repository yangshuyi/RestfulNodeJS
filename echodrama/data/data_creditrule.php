<?php
if(!defined('IN_UCHOME')) exit('Access Denied');
$_SGLOBAL['creditrule']=Array
	(
	'register' => Array
		(
		'rid' => 1,
		'rulename' => '��ͨ�ռ�',
		'action' => 'register',
		'cycletype' => '0',
		'cycletime' => '0',
		'rewardnum' => 1,
		'rewardtype' => 1,
		'norepeat' => '0',
		'credit' => 5,
		'experience' => '0'
		),
	'realname' => Array
		(
		'rid' => 2,
		'rulename' => 'ʵ����֤',
		'action' => 'realname',
		'cycletype' => '0',
		'cycletime' => '0',
		'rewardnum' => 1,
		'rewardtype' => 1,
		'norepeat' => '0',
		'credit' => 10,
		'experience' => 2
		),
	'realemail' => Array
		(
		'rid' => 3,
		'rulename' => '������֤',
		'action' => 'realemail',
		'cycletype' => '0',
		'cycletime' => '0',
		'rewardnum' => 1,
		'rewardtype' => 1,
		'norepeat' => '0',
		'credit' => 10,
		'experience' => 5
		),
	'invitefriend' => Array
		(
		'rid' => 4,
		'rulename' => '�ɹ��������',
		'action' => 'invitefriend',
		'cycletype' => 4,
		'cycletime' => '0',
		'rewardnum' => 20,
		'rewardtype' => 1,
		'norepeat' => '0',
		'credit' => 10,
		'experience' => 10
		),
	'setavatar' => Array
		(
		'rid' => 5,
		'rulename' => '����ͷ��',
		'action' => 'setavatar',
		'cycletype' => '0',
		'cycletime' => '0',
		'rewardnum' => 1,
		'rewardtype' => 1,
		'norepeat' => '0',
		'credit' => 10,
		'experience' => 5
		),
	'videophoto' => Array
		(
		'rid' => 6,
		'rulename' => '��Ƶ��֤',
		'action' => 'videophoto',
		'cycletype' => '0',
		'cycletime' => '0',
		'rewardnum' => 1,
		'rewardtype' => 1,
		'norepeat' => '0',
		'credit' => 10,
		'experience' => 5
		),
	'report' => Array
		(
		'rid' => 7,
		'rulename' => '�ɹ��ٱ�',
		'action' => 'report',
		'cycletype' => 4,
		'cycletime' => '0',
		'rewardnum' => '0',
		'rewardtype' => 1,
		'norepeat' => '0',
		'credit' => 2,
		'experience' => 2
		),
	'updatemood' => Array
		(
		'rid' => 8,
		'rulename' => '��������',
		'action' => 'updatemood',
		'cycletype' => 1,
		'cycletime' => '0',
		'rewardnum' => 1,
		'rewardtype' => 1,
		'norepeat' => '0',
		'credit' => 2,
		'experience' => 2
		),
	'hotinfo' => Array
		(
		'rid' => 9,
		'rulename' => '�ȵ���Ϣ',
		'action' => 'hotinfo',
		'cycletype' => 4,
		'cycletime' => '0',
		'rewardnum' => '0',
		'rewardtype' => 1,
		'norepeat' => '0',
		'credit' => 10,
		'experience' => 5
		),
	'daylogin' => Array
		(
		'rid' => 10,
		'rulename' => 'ÿ���½',
		'action' => 'daylogin',
		'cycletype' => 1,
		'cycletime' => '0',
		'rewardnum' => 1,
		'rewardtype' => 1,
		'norepeat' => '0',
		'credit' => 2,
		'experience' => 2
		),
	'visit' => Array
		(
		'rid' => 11,
		'rulename' => '���ʱ��˿ռ�',
		'action' => 'visit',
		'cycletype' => 1,
		'cycletime' => '0',
		'rewardnum' => 5,
		'rewardtype' => 1,
		'norepeat' => 2,
		'credit' => 1,
		'experience' => 1
		),
	'poke' => Array
		(
		'rid' => 12,
		'rulename' => '���к�',
		'action' => 'poke',
		'cycletype' => 1,
		'cycletime' => '0',
		'rewardnum' => 5,
		'rewardtype' => 1,
		'norepeat' => 2,
		'credit' => 1,
		'experience' => 1
		),
	'guestbook' => Array
		(
		'rid' => 13,
		'rulename' => '����',
		'action' => 'guestbook',
		'cycletype' => 1,
		'cycletime' => '0',
		'rewardnum' => 20,
		'rewardtype' => 1,
		'norepeat' => 2,
		'credit' => 2,
		'experience' => 2
		),
	'getguestbook' => Array
		(
		'rid' => 14,
		'rulename' => '������',
		'action' => 'getguestbook',
		'cycletype' => 1,
		'cycletime' => '0',
		'rewardnum' => 5,
		'rewardtype' => 1,
		'norepeat' => 2,
		'credit' => 1,
		'experience' => '0'
		),
	'doing' => Array
		(
		'rid' => 15,
		'rulename' => '�����¼',
		'action' => 'doing',
		'cycletype' => 1,
		'cycletime' => '0',
		'rewardnum' => 5,
		'rewardtype' => 1,
		'norepeat' => '0',
		'credit' => 1,
		'experience' => 1
		),
	'publishblog' => Array
		(
		'rid' => 16,
		'rulename' => '������־',
		'action' => 'publishblog',
		'cycletype' => 1,
		'cycletime' => '0',
		'rewardnum' => 3,
		'rewardtype' => 1,
		'norepeat' => '0',
		'credit' => 5,
		'experience' => 5
		),
	'uploadimage' => Array
		(
		'rid' => 17,
		'rulename' => '�ϴ�ͼƬ',
		'action' => 'uploadimage',
		'cycletype' => 1,
		'cycletime' => '0',
		'rewardnum' => 10,
		'rewardtype' => 1,
		'norepeat' => '0',
		'credit' => 2,
		'experience' => 2
		),
	'camera' => Array
		(
		'rid' => 18,
		'rulename' => '�Ĵ�ͷ��',
		'action' => 'camera',
		'cycletype' => 1,
		'cycletime' => '0',
		'rewardnum' => 1,
		'rewardtype' => 1,
		'norepeat' => '0',
		'credit' => 2,
		'experience' => 2
		),
	'publishthread' => Array
		(
		'rid' => 19,
		'rulename' => '������',
		'action' => 'publishthread',
		'cycletype' => 1,
		'cycletime' => '0',
		'rewardnum' => 5,
		'rewardtype' => 1,
		'norepeat' => '0',
		'credit' => 3,
		'experience' => 1
		),
	'replythread' => Array
		(
		'rid' => 20,
		'rulename' => '�ظ�����',
		'action' => 'replythread',
		'cycletype' => 1,
		'cycletime' => '0',
		'rewardnum' => 10,
		'rewardtype' => 1,
		'norepeat' => 1,
		'credit' => 1,
		'experience' => 1
		),
	'createpoll' => Array
		(
		'rid' => 21,
		'rulename' => '����ͶƱ',
		'action' => 'createpoll',
		'cycletype' => 1,
		'cycletime' => '0',
		'rewardnum' => 3,
		'rewardtype' => 1,
		'norepeat' => '0',
		'credit' => 5,
		'experience' => 2
		),
	'joinpoll' => Array
		(
		'rid' => 22,
		'rulename' => '����ͶƱ',
		'action' => 'joinpoll',
		'cycletype' => 1,
		'cycletime' => '0',
		'rewardnum' => 10,
		'rewardtype' => 1,
		'norepeat' => 1,
		'credit' => 1,
		'experience' => 1
		),
	'createevent' => Array
		(
		'rid' => 23,
		'rulename' => '����',
		'action' => 'createevent',
		'cycletype' => 1,
		'cycletime' => '0',
		'rewardnum' => 1,
		'rewardtype' => 1,
		'norepeat' => '0',
		'credit' => 3,
		'experience' => 3
		),
	'joinevent' => Array
		(
		'rid' => 24,
		'rulename' => '����',
		'action' => 'joinevent',
		'cycletype' => 1,
		'cycletime' => '0',
		'rewardnum' => 1,
		'rewardtype' => 1,
		'norepeat' => 1,
		'credit' => 1,
		'experience' => 1
		),
	'recommendevent' => Array
		(
		'rid' => 25,
		'rulename' => '�Ƽ��',
		'action' => 'recommendevent',
		'cycletype' => 4,
		'cycletime' => '0',
		'rewardnum' => '0',
		'rewardtype' => 1,
		'norepeat' => '0',
		'credit' => 5,
		'experience' => 2
		),
	'createshare' => Array
		(
		'rid' => 26,
		'rulename' => '�������',
		'action' => 'createshare',
		'cycletype' => 1,
		'cycletime' => '0',
		'rewardnum' => 3,
		'rewardtype' => 1,
		'norepeat' => '0',
		'credit' => 2,
		'experience' => 2
		),
	'comment' => Array
		(
		'rid' => 27,
		'rulename' => '����',
		'action' => 'comment',
		'cycletype' => 1,
		'cycletime' => '0',
		'rewardnum' => 40,
		'rewardtype' => 1,
		'norepeat' => 1,
		'credit' => 1,
		'experience' => 1
		),
	'getcomment' => Array
		(
		'rid' => 28,
		'rulename' => '������',
		'action' => 'getcomment',
		'cycletype' => 1,
		'cycletime' => '0',
		'rewardnum' => 20,
		'rewardtype' => 1,
		'norepeat' => 1,
		'credit' => 1,
		'experience' => '0'
		),
	'installapp' => Array
		(
		'rid' => 29,
		'rulename' => '��װӦ��',
		'action' => 'installapp',
		'cycletype' => 4,
		'cycletime' => '0',
		'rewardnum' => '0',
		'rewardtype' => 1,
		'norepeat' => 3,
		'credit' => '0',
		'experience' => '0'
		),
	'useapp' => Array
		(
		'rid' => 30,
		'rulename' => 'ʹ��Ӧ��',
		'action' => 'useapp',
		'cycletype' => 1,
		'cycletime' => '0',
		'rewardnum' => 10,
		'rewardtype' => 1,
		'norepeat' => 3,
		'credit' => 1,
		'experience' => 1
		),
	'click' => Array
		(
		'rid' => 31,
		'rulename' => '��Ϣ��̬',
		'action' => 'click',
		'cycletype' => 1,
		'cycletime' => '0',
		'rewardnum' => 10,
		'rewardtype' => 1,
		'norepeat' => 1,
		'credit' => 1,
		'experience' => 1
		),
	'editrealname' => Array
		(
		'rid' => 32,
		'rulename' => '�޸�ʵ��',
		'action' => 'editrealname',
		'cycletype' => '0',
		'cycletime' => '0',
		'rewardnum' => 1,
		'rewardtype' => '0',
		'norepeat' => '0',
		'credit' => 10,
		'experience' => 5
		),
	'editrealemail' => Array
		(
		'rid' => 33,
		'rulename' => '����������֤',
		'action' => 'editrealemail',
		'cycletype' => '0',
		'cycletime' => '0',
		'rewardnum' => 1,
		'rewardtype' => '0',
		'norepeat' => '0',
		'credit' => 5,
		'experience' => '0'
		),
	'delavatar' => Array
		(
		'rid' => 34,
		'rulename' => 'ͷ��ɾ��',
		'action' => 'delavatar',
		'cycletype' => '0',
		'cycletime' => '0',
		'rewardnum' => 1,
		'rewardtype' => '0',
		'norepeat' => '0',
		'credit' => 10,
		'experience' => 5
		),
	'invitecode' => Array
		(
		'rid' => 35,
		'rulename' => '��ȡ������',
		'action' => 'invitecode',
		'cycletype' => '0',
		'cycletime' => '0',
		'rewardnum' => 1,
		'rewardtype' => '0',
		'norepeat' => '0',
		'credit' => '0',
		'experience' => '0'
		),
	'search' => Array
		(
		'rid' => 36,
		'rulename' => '����һ��',
		'action' => 'search',
		'cycletype' => '0',
		'cycletime' => '0',
		'rewardnum' => 1,
		'rewardtype' => '0',
		'norepeat' => '0',
		'credit' => '0',
		'experience' => '0'
		),
	'blogimport' => Array
		(
		'rid' => 37,
		'rulename' => '��־����',
		'action' => 'blogimport',
		'cycletype' => '0',
		'cycletime' => '0',
		'rewardnum' => 1,
		'rewardtype' => '0',
		'norepeat' => '0',
		'credit' => 10,
		'experience' => '0'
		),
	'modifydomain' => Array
		(
		'rid' => 38,
		'rulename' => '�޸�����',
		'action' => 'modifydomain',
		'cycletype' => '0',
		'cycletime' => '0',
		'rewardnum' => 1,
		'rewardtype' => '0',
		'norepeat' => '0',
		'credit' => 5,
		'experience' => '0'
		),
	'delblog' => Array
		(
		'rid' => 39,
		'rulename' => '��־��ɾ��',
		'action' => 'delblog',
		'cycletype' => '0',
		'cycletime' => '0',
		'rewardnum' => 1,
		'rewardtype' => '0',
		'norepeat' => '0',
		'credit' => 5,
		'experience' => 5
		),
	'deldoing' => Array
		(
		'rid' => 40,
		'rulename' => '��¼��ɾ��',
		'action' => 'deldoing',
		'cycletype' => '0',
		'cycletime' => '0',
		'rewardnum' => 1,
		'rewardtype' => '0',
		'norepeat' => '0',
		'credit' => 1,
		'experience' => 1
		),
	'delimage' => Array
		(
		'rid' => 41,
		'rulename' => 'ͼƬ��ɾ��',
		'action' => 'delimage',
		'cycletype' => '0',
		'cycletime' => '0',
		'rewardnum' => 1,
		'rewardtype' => '0',
		'norepeat' => '0',
		'credit' => 2,
		'experience' => 2
		),
	'delpoll' => Array
		(
		'rid' => 42,
		'rulename' => 'ͶƱ��ɾ��',
		'action' => 'delpoll',
		'cycletype' => '0',
		'cycletime' => '0',
		'rewardnum' => 1,
		'rewardtype' => '0',
		'norepeat' => '0',
		'credit' => 5,
		'experience' => 2
		),
	'delthread' => Array
		(
		'rid' => 43,
		'rulename' => '���ⱻɾ��',
		'action' => 'delthread',
		'cycletype' => '0',
		'cycletime' => '0',
		'rewardnum' => 1,
		'rewardtype' => '0',
		'norepeat' => '0',
		'credit' => 3,
		'experience' => 1
		),
	'delevent' => Array
		(
		'rid' => 44,
		'rulename' => '���ɾ��',
		'action' => 'delevent',
		'cycletype' => '0',
		'cycletime' => '0',
		'rewardnum' => 1,
		'rewardtype' => '0',
		'norepeat' => '0',
		'credit' => 3,
		'experience' => 3
		),
	'delshare' => Array
		(
		'rid' => 45,
		'rulename' => '����ɾ��',
		'action' => 'delshare',
		'cycletype' => '0',
		'cycletime' => '0',
		'rewardnum' => 1,
		'rewardtype' => '0',
		'norepeat' => '0',
		'credit' => 2,
		'experience' => 2
		),
	'delguestbook' => Array
		(
		'rid' => 46,
		'rulename' => '���Ա�ɾ��',
		'action' => 'delguestbook',
		'cycletype' => '0',
		'cycletime' => '0',
		'rewardnum' => 1,
		'rewardtype' => '0',
		'norepeat' => '0',
		'credit' => 2,
		'experience' => 2
		),
	'delcomment' => Array
		(
		'rid' => 47,
		'rulename' => '���۱�ɾ��',
		'action' => 'delcomment',
		'cycletype' => '0',
		'cycletime' => '0',
		'rewardnum' => 1,
		'rewardtype' => '0',
		'norepeat' => '0',
		'credit' => 1,
		'experience' => 1
		),
	'topic_new' => Array
		(
		'rid' => 48,
		'rulename' => '�ϴ��㲥��',
		'action' => 'topic_new',
		'cycletype' => 4,
		'cycletime' => '0',
		'rewardnum' => '0',
		'rewardtype' => 1,
		'norepeat' => '0',
		'credit' => 50,
		'experience' => 10
		),
	'tone_new' => Array
		(
		'rid' => 49,
		'rulename' => '�ϴ���������',
		'action' => 'tone_new',
		'cycletype' => 4,
		'cycletime' => '0',
		'rewardnum' => '0',
		'rewardtype' => 1,
		'norepeat' => '0',
		'credit' => 50,
		'experience' => 10
		),
	'topic_delete' => Array
		(
		'rid' => 50,
		'rulename' => 'ɾ���㲥��',
		'action' => 'topic_delete',
		'cycletype' => '0',
		'cycletime' => '0',
		'rewardnum' => 1,
		'rewardtype' => '0',
		'norepeat' => '0',
		'credit' => 50,
		'experience' => 10
		),
	'tone_delete' => Array
		(
		'rid' => 51,
		'rulename' => 'ɾ����������',
		'action' => 'tone_delete',
		'cycletype' => '0',
		'cycletime' => '0',
		'rewardnum' => 1,
		'rewardtype' => '0',
		'norepeat' => '0',
		'credit' => 50,
		'experience' => 10
		),
	'mtag_new' => Array
		(
		'rid' => 52,
		'rulename' => '����Ⱥ��',
		'action' => 'mtag_new',
		'cycletype' => '0',
		'cycletime' => '0',
		'rewardnum' => 1,
		'rewardtype' => '0',
		'norepeat' => '0',
		'credit' => 500,
		'experience' => 500
		),
	'cover_add' => Array
		(
		'rid' => 53,
		'rulename' => '��������',
		'action' => 'cover_add',
		'cycletype' => 4,
		'cycletime' => '0',
		'rewardnum' => '0',
		'rewardtype' => 1,
		'norepeat' => '0',
		'credit' => 50,
		'experience' => 10
		),
	'cover_delete' => Array
		(
		'rid' => 54,
		'rulename' => 'ɾ������',
		'action' => 'cover_delete',
		'cycletype' => '0',
		'cycletime' => '0',
		'rewardnum' => 1,
		'rewardtype' => '0',
		'norepeat' => '0',
		'credit' => 50,
		'experience' => 10
		),
	'video_add' => Array
		(
		'rid' => 55,
		'rulename' => '������Ƶ',
		'action' => 'video_add',
		'cycletype' => 4,
		'cycletime' => '0',
		'rewardnum' => '0',
		'rewardtype' => 1,
		'norepeat' => '0',
		'credit' => 50,
		'experience' => 10
		),
	'video_delete' => Array
		(
		'rid' => 56,
		'rulename' => 'ɾ����Ƶ',
		'action' => 'video_delete',
		'cycletype' => '0',
		'cycletime' => '0',
		'rewardnum' => 1,
		'rewardtype' => '0',
		'norepeat' => '0',
		'credit' => 50,
		'experience' => 10
		),
	'report_success' => Array
		(
		'rid' => 57,
		'rulename' => '�ٱ��ɹ�',
		'action' => 'report_success',
		'cycletype' => 4,
		'cycletime' => '0',
		'rewardnum' => '0',
		'rewardtype' => 1,
		'norepeat' => '0',
		'credit' => 20,
		'experience' => 5
		),
	'report_fail' => Array
		(
		'rid' => 58,
		'rulename' => '�ٱ�ʧ��',
		'action' => 'report_fail',
		'cycletype' => '0',
		'cycletime' => '0',
		'rewardnum' => 1,
		'rewardtype' => '0',
		'norepeat' => '0',
		'credit' => 20,
		'experience' => 5
		),
	'poll_invite_friend' => Array
		(
		'rid' => 59,
		'rulename' => 'ͶƱ�������к���',
		'action' => 'poll_invite_friend',
		'cycletype' => '0',
		'cycletime' => '0',
		'rewardnum' => 1,
		'rewardtype' => '0',
		'norepeat' => '0',
		'credit' => 50,
		'experience' => '0'
		),
	'poll_invite_all' => Array
		(
		'rid' => 60,
		'rulename' => 'ͶƱ�������г�Ա',
		'action' => 'poll_invite_all',
		'cycletype' => '0',
		'cycletime' => '0',
		'rewardnum' => 1,
		'rewardtype' => '0',
		'norepeat' => '0',
		'credit' => 200,
		'experience' => '0'
		),
	'event_invite_friend' => Array
		(
		'rid' => 61,
		'rulename' => '��ļ�������к���',
		'action' => 'event_invite_friend',
		'cycletype' => '0',
		'cycletime' => '0',
		'rewardnum' => 1,
		'rewardtype' => '0',
		'norepeat' => '0',
		'credit' => 50,
		'experience' => '0'
		),
	'event_invite_all' => Array
		(
		'rid' => 62,
		'rulename' => '��ļ�������г�Ա',
		'action' => 'event_invite_all',
		'cycletype' => '0',
		'cycletime' => '0',
		'rewardnum' => 1,
		'rewardtype' => '0',
		'norepeat' => '0',
		'credit' => 200,
		'experience' => '0'
		),
	'topic_forecast_new' => Array
		(
		'rid' => 63,
		'rulename' => '�㲥��Ԥ�淢��',
		'action' => 'topic_forecast_new',
		'cycletype' => '0',
		'cycletime' => '0',
		'rewardnum' => 1,
		'rewardtype' => '0',
		'norepeat' => '0',
		'credit' => 100,
		'experience' => '0'
		),
	'topic_forecast_disca' => Array
		(
		'rid' => 64,
		'rulename' => '�㲥��û��ʱ����',
		'action' => 'topic_forecast_disca',
		'cycletype' => '0',
		'cycletime' => '0',
		'rewardnum' => 1,
		'rewardtype' => '0',
		'norepeat' => '0',
		'credit' => 100,
		'experience' => 100
		),
	'topic_forecast_post' => Array
		(
		'rid' => 65,
		'rulename' => '�㲥��Ԥ�淢���ɹ�',
		'action' => 'topic_forecast_post',
		'cycletype' => 4,
		'cycletime' => '0',
		'rewardnum' => '0',
		'rewardtype' => 1,
		'norepeat' => '0',
		'credit' => 100,
		'experience' => '0'
		),
	'ad_click' => Array
		(
		'rid' => 66,
		'rulename' => '��л��֧�ֱ�վ���',
		'action' => 'ad_click',
		'cycletype' => '0',
		'cycletime' => '0',
		'rewardnum' => 1,
		'rewardtype' => 1,
		'norepeat' => '0',
		'credit' => 5,
		'experience' => '0'
		)
	)
?>