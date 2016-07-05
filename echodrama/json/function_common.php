<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: function_common.php 13235 2009-08-24 09:48:36Z shirui $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}


function commentformmapper_JSON( $commentlist ){
	global $_SGLOBAL, $_SC;

	foreach($commentlist as $comment){
		$comment_json = array();
		$comment_json['userid'] = $comment['authorid'];
		$comment_json['username'] = $comment['author'];
		$comment_json['dateline'] = $comment['dateline']?sgmdate('Y-m-d', $comment['dateline']):'';
		$comment_json['message'] = $comment['message'];
		$commentlist_json[] = $comment_json;
	}
	
	return $commentlist_json;
}


function spaceformmapper_JSON($space, $detail, $passport = ''){
	$space_JSON = array();
	$space_JSON['userid'] = $space['uid'];
	$space_JSON['passport'] = $passport;
	$space_JSON['username'] = $space['username'];
	$space_JSON['groupid'] = $space['groupid'];
	$space_JSON['grouptitle'] = $space['grouptitle'];
	if($detail){
		$space_JSON['avatarpath'] = "/".avatar_file($space['uid'], 'big');
		$space_JSON['realname'] = $space['name'];
		$space_JSON['friendnum'] = $space['friendnum'];
		$space_JSON['viewnum'] = $space['viewnum'];
		$space_JSON['credit'] = $space['credit'];
		$space_JSON['experience'] = $space['experience'];
		$space_JSON['credit'] = $space['credit'];
		$space_JSON['sex'] = $space['sex'];
		$space_JSON['birthday'] = $space['birthday'];
		$space_JSON['qq'] = $space['qq'];
		$space_JSON['club'] = $space['club'];
		$space_JSON['jobName'] = $space['jobName'];
		$space_JSON['introduce'] = $space['introduce'];
	}
	else{	
		$space_JSON['avatarpath'] = "/".avatar_file($space['uid'], 'middle');
	}
	$space_JSON['note'] = $space['note'];

	return $space_JSON;
}


//分页
function multi_JSON($num, $perpage, $curpage, $mpurl, $list) {
	$multipage = array();
	$multipage['num'] = $num;
	$multipage['perpage'] = $perpage;
	$multipage['curpage'] = $curpage;
	$multipage['mpurl'] = $mpurl;
	$multipage['list'] = $list;
	return $multipage;
}

function showmessage_JSON($msgkey, $url_forward='', $second=1, $values=array()) {
	global $_SGLOBAL, $_SC, $_SCONFIG, $_TPL, $space, $_SN;

	obclean();
	
	//去掉广告
	$_SGLOBAL['ad'] = array();
	
	//语言
	$message = loadmessage($msgkey, $values);

	exitWithError_JSON($message);
}

function exitWithError_JSON( $msg ) {
	global $_SGLOBAL, $_SC;

	$returnObj = array();
	
	$headerInfo = array();
	
	$status = array();
	$status['code'] = 0;
	
	$msg = gbk2utf8($msg);
	
	$status['message'] = $msg;
	
	$body = "";
	
	$headerInfo['status'] = $status;
	$returnObj['header'] = $headerInfo;
	
	$returnObj['body'] = $body;
	
	$json_string = json_encode($returnObj); 
	
	if( $_SGLOBAL['encodeFlag']==true ) {
		echo base64_encode($json_string);
	}
  	else{	
  		echo $json_string;
	}
	exit();
}

function returnObj_JSON( $obj ) {
	global $_SGLOBAL, $_SC;
        
	$returnObj = array();
	
	$headerInfo = array();
	
	$status = array();
	$status['code'] = 1;
	$status['message'] = "";
	
	$body = $msg;
	
	$headerInfo['status'] = $status;
	$returnObj['header'] = $headerInfo;
	
	$obj = gbk2utf8($obj);
	
	$returnObj['body'] = $obj;
	
	$json_string = json_encode($returnObj); 
        
  	if( $_SGLOBAL['encodeFlag']==true ) {
		echo base64_encode($json_string);
	}
  	else{	
  		echo $json_string;
	}

	exit();
}

function gbk2utf8($data){
if(is_array($data)){
return array_map('gbk2utf8', $data);
}
return iconv('gbk','utf-8',$data);
}
	
?>