<?php
if(!defined('IN_UCHOME')) exit('Access Denied');
$_SGLOBAL['attachmentclass']=Array
	(
	1 => Array
		(
		'classid' => 1,
		'classname' => '��Ƶ',
		'imagepath' => '/image/filetype/audio.gif',
		'filetype' => '*.mp3',
		'displayorder' => 1
		),
	2 => Array
		(
		'classid' => 2,
		'classname' => 'ͼƬ',
		'imagepath' => '/image/filetype/image.gif',
		'filetype' => '*.jpg',
		'displayorder' => 2
		),
	3 => Array
		(
		'classid' => 3,
		'classname' => 'Word�ĵ�',
		'imagepath' => '/image/filetype/msoffice.gif',
		'filetype' => '*.doc|*.docx',
		'displayorder' => 3
		),
	4 => Array
		(
		'classid' => 4,
		'classname' => 'ѹ���ļ�',
		'imagepath' => '/image/filetype/rar.gif',
		'filetype' => '*.zip|*.rar',
		'displayorder' => 4
		),
	5 => Array
		(
		'classid' => 5,
		'classname' => '�ı��ļ�',
		'imagepath' => '/image/filetype/text.gif',
		'filetype' => '*.txt',
		'displayorder' => 5
		),
	6 => Array
		(
		'classid' => 6,
		'classname' => '������Դ',
		'imagepath' => '/image/filetype/link.gif',
		'filetype' => '*.*',
		'displayorder' => 6
		),
	99 => Array
		(
		'classid' => 99,
		'classname' => '����',
		'imagepath' => '/image/filetype/unknown.gif',
		'filetype' => '*.*',
		'displayorder' => 99
		)
	)
?>