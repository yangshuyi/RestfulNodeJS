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

$qsql="select count(*) AS taskcount from ".tname('task')." t where taskid!='24' AND taskid not in (select uk.taskid from ".tname('usertask')." uk where uk.uid='$space[uid]' )";
$query = $_SGLOBAL['db']->query($qsql);
$value = $_SGLOBAL['db']->fetch_array($query);

if( $value['taskcount']==0 ) {
	
	$task['done'] = 1;//任务完成
	$task['result'] .= '<p>感谢您在这个月给予我们的支持和鼓励。</p>';
	
} else {

	$task['guide'] .= '<strong>请按照以下的说明来完成本任务：</strong><br/>
		这个任务有点苛刻，要把所有其它任务全部完成哦～～～ <br/>
		哈哈，一旦完成了这个不可能完成的任务，你可是会有2000的积分奖励哦～～～～	';
	
	
	$task['guide'] .= "<br/>你还有 $value[taskcount] 个任务未完成，加油吧。";
}


?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     