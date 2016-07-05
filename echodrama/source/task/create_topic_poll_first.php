<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: sample.php 11056 2009-02-09 01:59:47Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//内置变量：$task['done'] (完成标识变量) $task['result'] (结果文字) $task['guide'] (向导文字)

//判断用户是否完成了任务
$done = 0;

//---------------------------------------------------
//	编写代码，判读用户是否完成任务要求 $done = 1;
//---------------------------------------------------

$userip=getonlineip();
$topicpollsql= "SELECT * FROM ".tname('topicpoll')." tp WHERE tp.uid='$_SGLOBAL[supe_uid]' OR tp.userip='$userip' ";
$topicpoll = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($topicpollsql));

if( !empty($value) ) {
	
	$task['done'] = 1;//任务完成
	$task['result'] .= '<p>感谢您为您喜爱的剧组投出您真诚的一票。谢谢！</p>';
	
} else {

	$task['guide'] .= '<strong>通知：</strong>
		<ul class="task">
		<li>广播剧详细页面已经支持投票，请为您喜爱的作品投票支持下。方式：决定并选择在剧右下方的五角星后，选择投票，即可；</li>
		</ul>';
}


?>