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

$qsql="SELECT * FROM ".tname('space')." WHERE uid='$space[uid]'";
$query = $_SGLOBAL['db']->query($qsql);
$value = $_SGLOBAL['db']->fetch_array($query);

if( !empty($value) && !empty($value['name'])) {
	
	$task['done'] = 1;//任务完成
	$task['result'] .= '<p>您已完成设定成员名为：'.$value[name].', 请继续创建您的辉煌吧。</p>';
	
} else {

	$task['guide'] .= '<strong>请按照以下的说明来完成本任务：</strong>
		<ul class="task">
		<li>请设置您的<a href="cp.php?ac=profile" target="_blank">社团成员名</a>；</li>
		</ul>';
}


?>