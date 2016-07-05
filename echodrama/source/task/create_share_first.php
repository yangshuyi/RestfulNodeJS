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

$qsql="SELECT COUNT(sid) AS sharecount FROM ".tname('share')." WHERE uid='$space[uid]'";
$query = $_SGLOBAL['db']->query($qsql);
$value = $_SGLOBAL['db']->fetch_array($query);

if( !empty($value) && $value['sharecount']>0 ) {
	
	$task['done'] = 1;//任务完成
	$task['result'] .= '<p>你已完成分享了自己的好东东，顺便也去看看<a href="space.php?uid='.$space[uid].'&do=share&view=all" target="_blank">大家的分享</a>吧。</p>';
	
} else {

	$task['guide'] .= '<strong>请按照以下的说明来完成本任务：</strong>
		<ul class="task">
		<li>把自己有爱的广播剧，声线，日记，图片，一切的一切分享给自己的好友吧。记得填写分享时的感受哦～～</li>
		</ul>';
}


?>