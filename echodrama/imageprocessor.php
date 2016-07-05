<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: cp.php 13003 2009-08-05 06:46:06Z liguode $
*/

//通用文件
include_once('./common.php');
include_once(S_ROOT.'./source/function_cp.php');
include_once(S_ROOT.'./source/function_image.php');
include_once(S_ROOT.'./source/function_topic.php');

$topicid = $_GET['topicid'];
$type = $_GET['type'];
$rec_percent = $_GET['rec_percent'];
$rec_x = $_GET['rec_x'];
$rec_y = $_GET['rec_y'];
$rec_width = $_GET['rec_width'];
$rec_height = $_GET['rec_height'];

$errormessage = "";
//"http://localhost:80/imageprocessor.php?topicid="+this.p_topicid+"type="+this.p_type+"&imagepath="+this.p_imagepath+paramStr; 
//"&rec_percent="+this.imageSlider.value+"&rec_x="+imageBlock.x+"&rec_y="+imageBlock.y+"&rec_width="+imageBlock.width+"&rec_height="+imageBlock.height;
				
	include_once(S_ROOT.'./language/lang_showmessage.php');
	$topic=loadtopicbyid($topicid);
	//广播剧不存在
	if(empty($topic)) {
		$errormessage = loadmessage('topic_does_not_exist');
	}
	else{
		if($topic['type']=='single'){
			$topic= topicsingleformmapper($topic);
		}
		else if($topic['type']=='album'){
			$topic= topicalbumformmapper($topic);
		}
		
		if(!file_exists($topic['pic'])) {
			$errormessage = loadmessage('topic_pic_empty');
		}
		else {
			//$errormessage = "rec_percent:$rec_percent rec_x:$rec_x - rec_y:$rec_y - rec_width:$rec_width - rec_height:$rec_height";
			if($type == "thumb"){
				maketopiccanvasthumb("thumb", $topic[pic], $rec_percent, $rec_x, $rec_y, $rec_width, $rec_height);
			}
			else{
				maketopiccanvasthumb("thumb", $topic[pic], $rec_percent, $rec_x, $rec_y, $rec_width, $rec_height);
			}
		}
	}
?>
<?=$errormessage?>