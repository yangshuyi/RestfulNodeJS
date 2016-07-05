<?php
/*
 [UCenter Home] (C) 2007-2008 Comsenz Inc.
 $Id: function_delete.php 13001 2009-08-05 06:18:06Z zhengqingpeng $
 */

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

function connecttosina($nextstep){
	global $_SGLOBAL, $_SC;
	
	include_once(S_ROOT.'./source/weibooauth.php');
	
	$o = new WeiboOAuth( WB_AKEY , WB_SKEY  );

	$keys = $o->getRequestToken();
	
	$sina = array();
	$sina['oauth_token'] = $keys['oauth_token'];
	$sina['oauth_token_secret'] = $keys['oauth_token_secret'];
	$sina['url'] = $o->getAuthorizeURL( $keys['oauth_token'] ,false , "http://www.echodrama.com/".$nextstep."&oauth_token=".$keys['oauth_token']."&oauth_token_secret=".$keys['oauth_token_secret']);
	
	return $sina;
}

function confirmstatus($sina){
	global $_SGLOBAL, $_SC;
	
	include_once(S_ROOT.'./source/weibooauth.php');
	
	$o = new WeiboOAuth( WB_AKEY , WB_SKEY , $sina['oauth_token'] , $sina['oauth_token_secret']);

	$keys = $o->getAccessToken(  $_REQUEST['oauth_verifier'] ) ;
	$sina['lastkey_oauth_token'] = $keys['oauth_token'];
	$sina['lastkey_oauth_token_secret'] = $keys['oauth_token_secret'];
	
	return $sina;
}

function sendtopicmessagetosina($sina){
	$lastkey_oauth_token = "62ed6cb41b293035f63cc8b4dd490cf7";
	$lastkey_oauth_token_secret = "f6394954f3dc36c73a542469efac43f3";

	if( empty($sina['weibo_message']) ) {
		return;
	}
	
	include_once(S_ROOT.'./source/weibooauth.php');
	
	$c = new WeiboClient( WB_AKEY , WB_SKEY , $lastkey_oauth_token , $lastkey_oauth_token_secret  );
	
	if( $sina['weibo_image'] ) {
		$returnflag = $c->upload( iconv("gbk","utf-8", $sina['weibo_message']), $sina['weibo_image'] );
		if(empty($returnflag)){
			$returnflag = $c->update( iconv("gbk","utf-8", $sina['weibo_message']) );
		}
	}
	else{
		$returnflag = $c->update( iconv("gbk","utf-8", $sina['weibo_message']) );
	}
}

function sendtopicmessagetosinabyoauth1($sina){
	if( empty($sina['weibo_message']) ) {
		return;
	}
	
	include_once(S_ROOT.'./source/t_sina_oauth1.class.php');
	
	$c = new WeiboClient( WB_AKEY , WB_SKEY , $sina['lastkey_oauth_token'] , $sina['lastkey_oauth_token_secret']  );
	
	if( $sina['weibo_image'] ) {
		$returnflag = $c->upload( iconv("gbk","utf-8", $sina['weibo_message']), $sina['weibo_image'] );
		if(empty($returnflag)){
			$returnflag = $c->update( iconv("gbk","utf-8", $sina['weibo_message']) );
		}
	}
	else{
		$returnflag = $c->update( iconv("gbk","utf-8", $sina['weibo_message']) );
	}
}


?>