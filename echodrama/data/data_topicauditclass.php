<?php
if(!defined('IN_UCHOME')) exit('Access Denied');
$_SGLOBAL['topicauditclass']=Array
	(
	0 => Array
		(
		'classid' => 0,
		'classname' => '未审核',
		'displayorder' => 1
		),
	1 => Array
		(
		'classid' => 1,
		'classname' => '审核未通过',
		'displayorder' => 2
		),
	2 => Array
		(
		'classid' => 2,
		'classname' => '审核通过',
		'displayorder' => 3
		)
	)
?>