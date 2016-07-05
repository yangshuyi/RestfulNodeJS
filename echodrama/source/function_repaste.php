<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: function_repaste.php 13245 2009-08-25 02:01:40Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//添加转帖
function save($repaste) {
	global $_SGLOBAL, $_SC, $space;

	//类型
	if(empty($repaste)){
		return;
	}	
	
	$new=empty($repaste['repasteid']);
	
	//主表
	$repastearr = array(
		'repasteid' => $repaste['repasteid'],
		'uid' => $repaste['uid'],
		'username' => $repaste['username'],
		'subject' => $repaste['subject'],
		'classid' => $repaste['classid'],
		'viewnum' => $repaste['viewnum'],
		'replynum' => $repaste['replynum'],
		'hot' => $repaste['hot'],
		'dateline' => $repaste['dateline']
	);
	
	if($new) {
		$repaste['repasteid'] = inserttable('repaste', $repastearr, 1);
	}else{
		//更新
		updatetable('repaste', $repastearr, array('repasteid'=>$repaste['repasteid']));
	}	
		
	//附表	
	$fieldarr = array(
		'repasteid' => $repaste['repasteid'],
		'uid' => $repaste['uid'],
		'tag' => $repaste['tag'],
		'url' => $repaste['url'],
		'message' => $repaste['message'],
		'comment' => $repaste['comment'],
		'postip' => getonlineip(),
		'related' => $repaste['related'],
		'relatedtime' => $repaste['relatedtime'],
		'target_ids' => $repaste['target_ids'],
		'hotuser' => $repaste['hotuser'],
		'magiccolor' => $repaste['magiccolor'],
		'magicpaper' => $repaste['magicpaper'],
		'magiccall' => $repaste['magiccall']
	);
	
	if($new){
		inserttable('repastefield', $fieldarr);
	}else{
		updatetable('repastefield', $fieldarr, array('repasteid'=>$repaste['repasteid']));
	}	
	
//	//TAG
//	$oldtagstr = addslashes(empty($olds['tag'])?'':implode(' ', unserialize($olds['tag'])));
//	
//
//	$tagarr = array();
//	if($POST['tag'] != $oldtagstr) {
//		if(!empty($olds['tag'])) {
//			//先把以前的给清理掉
//			$oldtags = array();
//			$query = $_SGLOBAL['db']->query("SELECT tagid, repasteid FROM ".tname('tagrepaste')." WHERE repasteid='$repasteid'");
//			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
//				$oldtags[] = $value['tagid'];
//			}
//			if($oldtags) {
//				$_SGLOBAL['db']->query("UPDATE ".tname('tag')." SET repastenum=repastenum-1 WHERE tagid IN (".simplode($oldtags).")");
//				$_SGLOBAL['db']->query("DELETE FROM ".tname('tagrepaste')." WHERE repasteid='$repasteid'");
//			}
//		}
//		$tagarr = tag_batch($repasteid, $POST['tag']);
//		//更新附表中的tag
//		$fieldarr['tag'] = empty($tagarr)?'':addslashes(serialize($tagarr));
//	}

	//空间更新
//	if($isself) {
//		if($olds) {
//			//空间更新
//			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET updatetime='$_SGLOBAL[timestamp]' WHERE uid='$_SGLOBAL[supe_uid]'");
//		} else {
//			if(empty($space['repastenum'])) {
//				$space['repastenum'] = getcount('repaste', array('uid'=>$space['uid']));
//				$repastenumsql = "repastenum=".$space['repastenum'];
//			} else {
//				$repastenumsql = 'repastenum=repastenum+1';
//			}
//			//积分
//			$reward = getreward('publishrepaste', 0);
//			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET {$repastenumsql}, lastpost='$_SGLOBAL[timestamp]', updatetime='$_SGLOBAL[timestamp]', credit=credit+$reward[credit], experience=experience+$reward[experience] WHERE uid='$_SGLOBAL[supe_uid]'");
//			
//			//统计
//			updatestat('repaste');
//		}
//	}
	
	//产生feed
	if($POST['makefeed']) {
		include_once(S_ROOT.'./source/function_feed.php');
		feed_publish($repaste['repasteid'], 'repasteid', $new?1:0);
	}
	
	return $repastearr;
}

//删除转帖
function deleterepaste($repaste) {
	global $_SGLOBAL;

	include_once(S_ROOT.'./source/function_delete.php');
//	
//	//获取积分
//	$reward = getreward('delblog', 0);
//	//获取博客信息
//	$spaces = $blogs = $newblogids = array();
//	$allowmanage = checkperm('manageblog');
//	$managebatch = checkperm('managebatch');
//	$delnum = 0;
//	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('blog')." WHERE blogid IN (".simplode($blogids).")");
//	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
//		if($allowmanage || $value['uid'] == $_SGLOBAL['supe_uid']) {
//			$blogs[] = $value;
//			if(!$managebatch && $value['uid'] != $_SGLOBAL['supe_uid']) {
//				$delnum++;
//			}
//		}
//	}
//	if(empty($blogs) || (!$managebatch && $delnum > 1)) return array();
//	
//	foreach($blogs as $key => $value) {
//		$newblogids[] = $value['blogid'];
//		if($allowmanage && $value['uid'] != $_SGLOBAL['supe_uid']) {
//			//扣除积分
//			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit-$reward[credit], experience=experience-$reward[experience] WHERE uid='$value[uid]'");
//		}
//		//tag
//		$tags = array();
//		$subquery = $_SGLOBAL['db']->query("SELECT tagid, blogid FROM ".tname('tagblog')." WHERE blogid='$value[blogid]'");
//		while ($tag = $_SGLOBAL['db']->fetch_array($subquery)) {
//			$tags[] = $tag['tagid'];
//		}
//		if($tags) {
//			$_SGLOBAL['db']->query("UPDATE ".tname('tag')." SET blognum=blognum-1 WHERE tagid IN (".simplode($tags).")");
//			$_SGLOBAL['db']->query("DELETE FROM ".tname('tagblog')." WHERE blogid='$value[blogid]'");
//		}
//	}

	//数据删除
	$_SGLOBAL['db']->query("DELETE FROM ".tname('repaste')." WHERE repasteid = $repaste[repasteid]");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('repastefield')." WHERE repasteid = $repaste[repasteid]");

	//评论
	$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE id = $repaste[repasteid] AND idtype='repasteid'");

	//删除举报
	$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id = $repaste[repasteid] AND idtype='repasteid'");

	//删除feed
	$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE id = $repaste[repasteid] AND idtype='repasteid'");
	
	//删除脚印
	$_SGLOBAL['db']->query("DELETE FROM ".tname('clickuser')." WHERE id = $repaste[repasteid] AND idtype='blogid'");

	return $blogs;
}


//处理tag
function tag_batch($repasteid, $tags) {
	global $_SGLOBAL;

	$tagarr = array();
	$tagnames = empty($tags)?array():array_unique(explode(' ', $tags));
	if(empty($tagnames)) return $tagarr;

	$vtags = array();
	$query = $_SGLOBAL['db']->query("SELECT tagid, tagname, close FROM ".tname('tag')." WHERE tagname IN (".simplode($tagnames).")");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$value['tagname'] = addslashes($value['tagname']);
		$vkey = md5($value['tagname']);
		$vtags[$vkey] = $value;
	}
	$updatetagids = array();
	foreach ($tagnames as $tagname) {
		if(!preg_match('/^([\x7f-\xff_-]|\w){3,20}$/', $tagname)) continue;
		
		$vkey = md5($tagname);
		if(empty($vtags[$vkey])) {
			$setarr = array(
				'tagname' => $tagname,
				'uid' => $_SGLOBAL['supe_uid'],
				'dateline' => $_SGLOBAL['timestamp'],
				'repastenum' => 1
			);
			$tagid = inserttable('tag', $setarr, 1);
			$tagarr[$tagid] = $tagname;
		} else {
			if(empty($vtags[$vkey]['close'])) {
				$tagid = $vtags[$vkey]['tagid'];
				$updatetagids[] = $tagid;
				$tagarr[$tagid] = $tagname;
			}
		}
	}
	if($updatetagids) $_SGLOBAL['db']->query("UPDATE ".tname('tag')." SET repastenum=repastenum+1 WHERE tagid IN (".simplode($updatetagids).")");
	$tagids = array_keys($tagarr);
	$inserts = array();
	foreach ($tagids as $tagid) {
		$inserts[] = "('$tagid','$repasteid')";
	}
	if($inserts) $_SGLOBAL['db']->query("REPLACE INTO ".tname('tagrepaste')." (tagid,repasteid) VALUES ".implode(',', $inserts));

	return $tagarr;
}

//获取日记图片
function getmessagepic($message) {
	$pic = '';
	$message = stripslashes($message);
	$message = preg_replace("/\<img src=\".*?image\/face\/(.+?).gif\".*?\>\s*/is", '', $message);	//移除表情符
	preg_match("/src\=[\"\']*([^\>\s]{25,105})\.(jpg|gif|png)/i", $message, $mathes);
	if(!empty($mathes[1]) || !empty($mathes[2])) {
		$pic = "{$mathes[1]}.{$mathes[2]}";
	}
	return addslashes($pic);
}

//屏蔽html
function checkhtml($html) {
	$html = stripslashes($html);
	if(!checkperm('allowhtml')) {
		
		preg_match_all("/\<([^\<]+)\>/is", $html, $ms);

		$searchs[] = '<';
		$replaces[] = '&lt;';
		$searchs[] = '>';
		$replaces[] = '&gt;';
		
		if($ms[1]) {
			$allowtags = 'img|a|font|div|table|tbody|caption|tr|td|th|br|p|b|strong|i|u|em|span|ol|ul|li|blockquote|object|param|embed';//允许的标签
			$ms[1] = array_unique($ms[1]);
			foreach ($ms[1] as $value) {
				$searchs[] = "&lt;".$value."&gt;";
				$value = shtmlspecialchars($value);
				$value = str_replace(array('\\','/*'), array('.','/.'), $value);
				$value = preg_replace(array("/(javascript|script|eval|behaviour|expression)/i", "/(\s+|&quot;|')on/i"), array('.', ' .'), $value);
				if(!preg_match("/^[\/|\s]?($allowtags)(\s+|$)/is", $value)) {
					$value = '';
				}
				$replaces[] = empty($value)?'':"<".str_replace('&quot;', '"', $value).">";
			}
		}
		$html = str_replace($searchs, $replaces, $html);
	}
	$html = addslashes($html);
	
	return $html;
}

//视频标签处理
function repaste_bbcode($message) {
	$message = preg_replace("/\[flash\=?(media|real)*\](.+?)\[\/flash\]/ie", "repaste_flash('\\2', '\\1')", $message);
	return $message;
}
//视频
function repaste_flash($swf_url, $type='') {
	$width = '520';
	$height = '390';
	if ($type == 'media') {
		$html = '<object classid="clsid:6bf52a52-394a-11d3-b153-00c04f79faa6" width="'.$width.'" height="'.$height.'">
			<param name="autostart" value="0">
			<param name="url" value="'.$swf_url.'">
			<embed autostart="false" src="'.$swf_url.'" type="video/x-ms-wmv" width="'.$width.'" height="'.$height.'" controls="imagewindow" console="cons"></embed>
			</object>';
	} elseif ($type == 'real') {
		$html = '<object classid="clsid:cfcdaa03-8be4-11cf-b84b-0020afbbccfa" width="'.$width.'" height="'.$height.'">
			<param name="autostart" value="0">
			<param name="src" value="'.$swf_url.'">
			<param name="controls" value="Imagewindow,controlpanel">
			<param name="console" value="cons">
			<embed autostart="false" src="'.$swf_url.'" type="audio/x-pn-realaudio-plugin" width="'.$width.'" height="'.$height.'" controls="controlpanel" console="cons"></embed>
			</object>';
	} else {
		$html = '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="'.$width.'" height="'.$height.'">
			<param name="movie" value="'.$swf_url.'">
			<param name="WMode" value="Transparent">
			<param name="allowscriptaccess" value="always">
			<embed wmode="transparent" src="'.$swf_url.'" type="application/x-shockwave-flash" width="'.$width.'" height="'.$height.'" allowfullscreen="true" allowscriptaccess="always"></embed>
			</object>';
	}
	return $html;
}

?>
