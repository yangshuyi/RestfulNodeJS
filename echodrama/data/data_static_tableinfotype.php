<?php
if(!defined('IN_UCHOME')) exit('Access Denied');
$_SGLOBAL['tableinfotype']=Array
	(
	1 => Array
		(
		'classid' => 1,
		'classname' => '广播剧总数',
		'column' => 'num_topic',
		'sql' => "SELECT count(*) AS num_topic FROM ".tname('topic')."",
		'displayorder' => 1
		),
	2 => Array
		(
		'classid' => 2,
		'classname' => '广播剧收藏用户总数',
		'column' => 'num_topic_user',
		'sql' => "SELECT count(*) AS num_topic_user FROM ".tname('topicuser')."",
		'displayorder' => 2
		),
	3 => Array
		(
		'classid' => 3,
		'classname' => '广播剧用户投票总数',
		'column' => 'num_topic_poll',
		'sql' => "SELECT count(*) AS num_topic_poll FROM ".tname('topicpoll')."",
		'displayorder' => 3
		),	
	4 => Array
		(
		'classid' => 4,
		'classname' => '声线总数',
		'column' => 'num_tone',
		'sql' => "SELECT count(*) AS num_tone FROM ".tname('tone')."",
		'displayorder' => 4
		)
		
	)
?>