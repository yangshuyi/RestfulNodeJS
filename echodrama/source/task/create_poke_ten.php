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

$qsql="SELECT COUNT(distinct uid) AS pokecount FROM ".tname('poke')." WHERE fromuid='$space[uid]'";
$query = $_SGLOBAL['db']->query($qsql);
$value = $_SGLOBAL['db']->fetch_array($query);

if( !empty($value) && $value['pokecount']>=10 ) {
	
	$task['done'] = 1;//任务完成
	$task['result'] .= '<p>你已和'.$value['pokecount'].'个朋友打招呼了，你还真是有人缘呢。</p>';
	
} else {

	$task['guide'] .= '<strong>请按照以下的说明来完成本任务：</strong>
		<ul class="task">
		<li>你已和'.$value['pokecount'].'个朋友打过招呼了。</li>
		<li>登录到其他人的虫虫窝以后，点击TA头像下方的“打个招呼”链接，说声hi吧～</li>
		</ul>';
}


?>