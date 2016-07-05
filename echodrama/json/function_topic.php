<?php
/*
 [UCenter Home] (C) 2007-2008 Comsenz Inc.
 $Id: function_delete.php 13001 2009-08-05 06:18:06Z zhengqingpeng $
 */

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

function topicformmapper_JSON($topic){
	global $_SGLOBAL, $_SC;
	
	if( $topic['type'] == 'single' ){
		return topicsingleformmapper_JSON($topic);
	} 
	else if( $topic['type'] == 'album' ){
		return topicalbumformmapper_JSON($topic);
	}
}

// 完结广播剧专辑映射
function topicalbumformmapper_JSON($topic){
	global $_SGLOBAL, $_SC;
	
	$topic_json = array();
	
	$topic_json['topicid']=$topic['topicid'];
	$topic_json['typename']=$topic['typename'];
	$topic_json['dispnumber']=$topic['dispnumber'];
	$topic_json['subject']=$topic['subject'];
	$topic_json['pic']=$topic['picpath'];
	$topic_json['picthumb']=$topic['picthumbpath'];
	$topic_json['topictagid']=$topic['topictagid'];
	$topic_json['type']=$topic['type'];
	$topic_json['singtonalbum']=$topic['singtonalbum'];
	$topic_json['label']=$topic['label'];
	$topic_json['productclassid']=$topic['productclassid'];
	$topic_json['productclassname']=$topic['productclassname'];
	$topic_json['productclasstype']=$topic['productclasstype'];
	$topic_json['club']=$topic['club'];
	$topic_json['clubtagid']=$topic['clubtagid'];
	//$topic_json['group']=$topic['group'];
	$staff = buildstaffarray($topic);
	$topic_json['staff'] = $staff;
	$topic_json['director']=$topic['director'];
	$topic_json['cehua']=$topic['cehua'];
	$topic_json['producer']=$topic['producer'];
	$topic_json['yuanzhu']=$topic['yuanzhu'];
	$topic_json['writer']=$topic['writer'];
	$topic_json['cast']=$topic['cast'];
	$topic_json['effector']=$topic['effector'];
	$topic_json['photographer']=$topic['photographer'];
	$topic_json['propagandizer']=$topic['propagandizer'];
	$topic_json['producedate']=$topic['producedate'];
	$topic_json['dateline']=$topic['dateline'];
	$topic_json['replynum']=$topic['replynum'];
	$topic_json['viewnum']=$topic['viewnum'];
	$topic_json['downloadnum']=$topic['downloadnum'];
	$topic_json['joinnum']=$topic['joinnum'];
	$topic_json['pollnum']=$topic['pollnum'];
	$topic_json['poll_1']=$topic['poll_1'];
	$topic_json['poll_1_rate']=$topic['poll_1_rate'];
	$topic_json['poll_2']=$topic['poll_2'];
	$topic_json['poll_2_rate']=$topic['poll_2_rate'];
	$topic_json['poll_3']=$topic['poll_3'];
	$topic_json['poll_3_rate']=$topic['poll_3_rate'];
	$topic_json['poll_4']=$topic['poll_4'];
	$topic_json['poll_4_rate']=$topic['poll_4_rate'];
	$topic_json['poll_5']=$topic['poll_5'];
	$topic_json['poll_5_rate']=$topic['poll_5_rate'];
	$topic_json['jointype']=$topic['jointype'];
	$topic_json['joinnum']=$topic['joinnum'];
	
	return $topic_json;
}

function topicsingledetailformmapper_JSON( $topic, $topicwithme, $topiclabel_list, $topicattachment_list, $commentlist30 ){
	global $_SGLOBAL, $_SC;

	$topic_json = topicsingleformmapper_JSON($topic);
	$detail_json = array();	
	
	$detail_json['picthumb']='/'.$topic['picthumbpath'];
	$detail_json['picexists']=$topic['pic'];
	
	$detail_json['onlineurl']=$topic['audioplayerpath_tudou'];
	$detail_json['mp3remotepath']=$topic['productpath'];
	
	$detail_json['poll_1']=$topic['poll_1'];
	$detail_json['poll_1_rate']=$topic['poll_1_rate'];
	$detail_json['poll_2']=$topic['poll_2'];
	$detail_json['poll_2_rate']=$topic['poll_2_rate'];
	$detail_json['poll_3']=$topic['poll_3'];
	$detail_json['poll_3_rate']=$topic['poll_3_rate'];
	$detail_json['poll_4']=$topic['poll_4'];
	$detail_json['poll_4_rate']=$topic['poll_4_rate'];
	$detail_json['poll_5']=$topic['poll_5'];
	$detail_json['poll_5_rate']=$topic['poll_5_rate'];
	$detail_json['pollavg']=$topic['pollavg'];
	
	if(!empty($topicwithme)){
		$mine_json = array();
		$mine_json['share']=empty($topicwithme['share'])?false:true;
		$mine_json['poll']=empty($topicwithme['topicpoll'])?0:$topicwithme['topicpoll']['pollvalue'];
		$mine_json['label']=empty($topicwithme['topiclabellist'])?'':$topicwithme['topiclabellist'][0];
		$detail_json['mine']=$mine_json;
	}
	
	$labellist_json = array();
	foreach($topiclabel_list as $label){
		$label_json = array();
		$label_json['label'] = $label['label'];
		$labellist_json[] = $label_json;
	}
	$detail_json['labellist'] = $labellist_JSON;
	
	$attachmentlist_json = array();
	foreach($topicattachment_list as $topicattachment){
		
	}
	$detail_json['attachmentlist'] = $attachmentlist_json;
	
	$detail_json['commentlist'] = commentformmapper_JSON( $commentlist30 );	
	
	$topic_json['detail'] = $detail_json;
	return $topic_json;
}

function topicsingleformmapper_JSON($topic){
	global $_SGLOBAL, $_SC;

	$topic_json = array();
	
	$topic_json['topicid']=$topic['topicid'];
	$topic_json['typename']=$topic['typename'];
	$topic_json['dispnumber']=$topic['dispnumber'];
	$topic_json['subject']=$topic['subject'];
	$topic_json['topictagid']=$topic['topictagid'];
	$topic_json['type']=$topic['type'];
	$topic_json['singtonalbum']=$topic['singtonalbum'];
	$topic_json['label']=$topic['label'];
	$topic_json['productclassid']=$topic['productclassid'];
	$topic_json['productclassname']=$topic['productclassname'];
	$topic_json['productclasstype']=$topic['productclasstype'];
	$topic_json['club']=$topic['club'];
	$topic_json['clubtagid']=$topic['clubtagid'];
	//$topic_json['group']=$topic['group'];
	$staff = buildstaff($topic, '/');
	$topic_json['staff'] = $staff;
	$topic_json['director']=$topic['director'];
	$topic_json['cehua']=$topic['cehua'];
	$topic_json['producer']=$topic['producer'];
	$topic_json['yuanzhu']=$topic['yuanzhu'];
	$topic_json['writer']=$topic['writer'];
	$topic_json['cast']=$topic['cast'];
	$topic_json['effector']=$topic['effector'];
	$topic_json['photographer']=$topic['photographer'];
	$topic_json['propagandizer']=$topic['propagandizer'];
	$topic_json['producedate']=$topic['producedate'];
	$topic_json['dateline']=$topic['dateline'];
	$topic_json['replynum']=$topic['replynum'];
	$topic_json['viewnum']=$topic['viewnum'];
	$topic_json['downloadnum']=$topic['downloadnum'];
	$topic_json['joinnum']=$topic['joinnum'];
	$topic_json['pollnum']=$topic['pollnum'];
	$topic_json['polllevel']=$topic['polllevel'];
	$topic_json['jointype']=$topic['jointype'];
	$topic_json['joinnum']=$topic['joinnum'];
	
	return $topic_json;
}



?>