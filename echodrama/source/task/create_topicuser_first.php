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

$qsql="SELECT COUNT(id) AS topicusercount FROM ".tname('topicuser')." WHERE uid='$space[uid]'";
$query = $_SGLOBAL['db']->query($qsql);
$value = $_SGLOBAL['db']->fetch_array($query);

if( !empty($value) && $value['topicusercount']>0 ) {
	
	$task['done'] = 1;//任务完成
	$task['result'] .= '<p>你已完成收藏广播剧，谢谢你的参与。</p>';
	
} else {

	$task['guide'] .= '<strong>请按照以下的说明来完成本任务：</strong>
		<ul class="task">
		<li>把你喜欢的<a href="space.php?do=topic&view=single" target="_blank">广播剧</a>收藏起来吧，下次就不用在查找咯～～</li>
		</ul>';
}


?>