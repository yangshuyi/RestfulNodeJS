<?php
/*
 [UCenter Home] (C) 2007-2008 Comsenz Inc.
 $Id: function_delete.php 13001 2009-08-05 06:18:06Z zhengqingpeng $
 */

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

function savecomment($cid, $idtype, $id, $message, $replypollvoteruid = 0, $mobileflag = 0){
	global $_SGLOBAL, $_SC;

	if(!checkperm('allowcomment')) {
		ckspacelog();
		if($mobileflag == 1){
			mobile_showmessage('no_privilege');
		}
		else{
			showmessage('no_privilege');
		}
	}

	//实名认证
	ckrealname('comment');

	//新用户见习
	cknewuser();

	$message = getstr($message, 0, 1, 1, 1, 2);
	if(strlen($message) < 2) {
		if($mobileflag == 1){
			mobile_showmessage('content_is_too_short');
		}
		else{
			showmessage('content_is_too_short');
		}
	}

	//摘要
	$summay = getstr($message, 150, 1, 1, 0, 0, -1);

	//引用评论
	$comment = array();
	if($cid) {
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('comment')." WHERE cid='$cid' AND id='$id' AND idtype='$idtype'");
		$comment = $_SGLOBAL['db']->fetch_array($query);
		if($comment && $comment['authorid'] != $_SGLOBAL['supe_uid']) {
			//实名
			if($comment['author'] == '') {
				$_SN[$comment['authorid']] = lang('hidden_username');
			} else {
				realname_set($comment['authorid'], $comment['author']);
				realname_get();
			}
			$comment['message'] = preg_replace("/\<div class=\"quote\"\>\<span class=\"q\"\>.*?\<\/span\>\<\/div\>/is", '', $comment['message']);
			//bbcode转换
			$comment['message'] = html2bbcode($comment['message']);
			$message = addslashes("<div class=\"quote\"><span class=\"q\"><b>".$_SN[$comment['authorid']]."</b>: ".getstr($comment['message'], 150, 0, 0, 0, 2, 1).'</span></div>').$message;
			if($comment['idtype']=='uid') {
				$id = $comment['authorid'];
			}
		} else {
			$comment = array();
		}
	}
	if($replypollvoteruid) {
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('space')." WHERE uid='$replypollvoteruid'");
		$replypollvoter = $_SGLOBAL['db']->fetch_array($query);
		if($replypollvoter) {
			$message = addslashes("<div class=\"quote\"><span class=\"q\"><b>回复".$replypollvoter[username]."的投票</b>".'</span></div>').$message;
		}
		else {
			$comment = array();
		}
	}

	$hotarr = array();
	$stattype = '';

	//检查权限
	switch ($idtype) {
		case 'uid':
			//检索空间
			$tospace = getspace($id);
			$stattype = 'wall';//统计
			break;
		case 'picid':
			//检索图片
			$query = $_SGLOBAL['db']->query("SELECT p.*, pf.hotuser
				FROM ".tname('pic')." p
				LEFT JOIN ".tname('picfield')." pf
				ON pf.picid=p.picid
				WHERE p.picid='$id'");
			$pic = $_SGLOBAL['db']->fetch_array($query);
			//图片不存在
			if(empty($pic)) {
				if($mobileflag == 1){
					mobile_showmessage('view_images_do_not_exist');
				}
				else{
					showmessage('view_images_do_not_exist');
				}
			}

			//检索空间
			$tospace = getspace($pic['uid']);

			//获取相册
			$album = array();
			if($pic['albumid']) {
				$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('album')." WHERE albumid='$pic[albumid]'");
				if(!$album = $_SGLOBAL['db']->fetch_array($query)) {
					updatetable('pic', array('albumid'=>0), array('albumid'=>$pic['albumid']));//相册丢失
				}
			}
			//验证隐私
			if(!ckfriend($album['uid'], $album['friend'], $album['target_ids'])) {
				if($mobileflag == 1){
					mobile_showmessage('no_privilege');
				}
				else{
					showmessage('no_privilege');
				}
			} elseif(!$tospace['self'] && $album['friend'] == 4) {
				//密码输入问题
				$cookiename = "view_pwd_album_$album[albumid]";
				$cookievalue = empty($_SCOOKIE[$cookiename])?'':$_SCOOKIE[$cookiename];
				if($cookievalue != md5(md5($album['password']))) {
					if($mobileflag == 1){
						mobile_showmessage('no_privilege');
					}
					else{
						showmessage('no_privilege');
					}
				}
			}
			
			$hotarr = array('picid', $pic['picid'], $pic['hotuser']);
			$stattype = 'piccomment';//统计
			break;
		case 'blogid':
			//读取日记
			$query = $_SGLOBAL['db']->query("SELECT b.*, bf.target_ids, bf.hotuser
				FROM ".tname('blog')." b
				LEFT JOIN ".tname('blogfield')." bf ON bf.blogid=b.blogid
				WHERE b.blogid='$id'");
			$blog = $_SGLOBAL['db']->fetch_array($query);
			//日记不存在
			if(empty($blog)) {
				if($mobileflag == 1){
					mobile_showmessage('view_to_info_did_not_exist');
				}
				else{
					showmessage('view_to_info_did_not_exist');
				}
			}
			
			//检索空间
			$tospace = getspace($blog['uid']);
			
			//验证隐私
			if(!ckfriend($blog['uid'], $blog['friend'], $blog['target_ids'])) {
				//没有权限
				if($mobileflag == 1){
					mobile_showmessage('no_privilege');
				}
				else{
					showmessage('no_privilege');
				}
			} elseif(!$tospace['self'] && $blog['friend'] == 4) {
				//密码输入问题
				$cookiename = "view_pwd_blog_$blog[blogid]";
				$cookievalue = empty($_SCOOKIE[$cookiename])?'':$_SCOOKIE[$cookiename];
				if($cookievalue != md5(md5($blog['password']))) {
					if($mobileflag == 1){
						mobile_showmessage('no_privilege');
					}
					else{
						showmessage('no_privilege');
					}
				}
			}

			//是否允许评论
			if(!empty($blog['noreply'])) {
				if($mobileflag == 1){
					mobile_showmessage('do_not_accept_comments');
				}
				else{
					showmessage('do_not_accept_comments');
				}
			}
			if($blog['target_ids']) {
				$blog['target_ids'] .= ",$blog[uid]";
			}
			
			$hotarr = array('blogid', $blog['blogid'], $blog['hotuser']);
			$stattype = 'blogcomment';//统计
			break;
		case 'sid':
			//读取日记
			$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('share')." WHERE sid='$id'");
			$share = $_SGLOBAL['db']->fetch_array($query);
			//日记不存在
			if(empty($share)) {
				if($mobileflag == 1){
					mobile_showmessage('sharing_does_not_exist');
				}
				else{
					showmessage('sharing_does_not_exist');
				}
			}

			//检索空间
			$tospace = getspace($share['uid']);
			
			$hotarr = array('sid', $share['sid'], $share['hotuser']);
			$stattype = 'sharecomment';//统计
			break;
		case 'pid':
			$query = $_SGLOBAL['db']->query("SELECT p.*, pf.hotuser
				FROM ".tname('poll')." p
				LEFT JOIN ".tname('pollfield')." pf ON pf.pid=p.pid
				WHERE p.pid='$id'");
			$poll = $_SGLOBAL['db']->fetch_array($query);
			if(empty($poll)) {
				if($mobileflag == 1){
					mobile_showmessage('voting_does_not_exist');
				}
				else{
					showmessage('voting_does_not_exist');
				}
			}
			//是否允许评论
			$tospace = getspace($poll['uid']);
			if($poll['noreply']) {
				//是否好友
				if(!$tospace['self'] && !in_array($_SGLOBAL['supe_uid'], $tospace['friends'])) {
					if($mobileflag == 1){
						mobile_showmessage('the_vote_only_allows_friends_to_comment');
					}
					else{
						showmessage('the_vote_only_allows_friends_to_comment');
					}
				}
			}
			
			$hotarr = array('pid', $poll['pid'], $poll['hotuser']);
			$stattype = 'pollcomment';//统计
			break;
		case 'eventid':
		    // 读取活动
		    $query = $_SGLOBAL['db']->query("SELECT e.*, ef.* FROM ".tname('event')." e LEFT JOIN ".tname("eventfield")." ef ON e.eventid=ef.eventid WHERE e.eventid='$id'");
			$event = $_SGLOBAL['db']->fetch_array($query);

			if(empty($event)) {
				if($mobileflag == 1){
					mobile_showmessage('event_does_not_exist');
				}
				else{
					showmessage('event_does_not_exist');
				}
			}
			
			if($event['grade'] < -1){
				if($mobileflag == 1){
					mobile_showmessage('event_is_closed');
				}
				else{
					showmessage('event_is_closed');//活动已经关闭
				}
			} elseif($event['grade'] <= 0){
				if($mobileflag == 1){
					mobile_showmessage('event_under_verify');
				}
				else{
					showmessage('event_under_verify');//活动未通过审核
				}
			}
			
			if(!$event['allowpost']){
				$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname("userevent")." WHERE eventid='$id' AND uid='$_SGLOBAL[supe_uid]' LIMIT 1");
				$value = $_SGLOBAL['db']->fetch_array($query);
				if(empty($value) || $value['status'] < 2){
					if($mobileflag == 1){
						mobile_showmessage('event_only_allows_members_to_comment');
					}
					else{
						showmessage('event_only_allows_members_to_comment');//只有活动成员允许发表留言
					}
				}
			}

			//检索空间
			$tospace = getspace($event['uid']);
			
			$hotarr = array('eventid', $event['eventid'], $event['hotuser']);
			$stattype = 'eventcomment';//统计
			break;
		case 'reportid':
			$query = $_SGLOBAL['db']->query("SELECT r.* FROM ".tname("report")." r WHERE r.rid='$id'");
			$report = $_SGLOBAL['db']->fetch_array($query);
			if(! $report){
				if($mobileflag == 1){
					mobile_showmessage('report_does_not_exist');
				}
				else{
					showmessage('report_does_not_exist');//该举报不存在或者已被删除
				}
			}
	
			//检索空间
			$tospace = getspace(1);
			
			break;
		case 'mtagtaskid':
			$query = $_SGLOBAL['db']->query("SELECT mt.* FROM ".tname("mtagtask")." mt WHERE mt.taskid='$id'");
			$mtagtask = $_SGLOBAL['db']->fetch_array($query);
			if(! $mtagtask){
				if($mobileflag == 1){
					mobile_showmessage('mtag_task_not_exist');
				}
				else{
					showmessage('mtag_task_not_exist');//群组成员任务不存在或者已被删除
				}
			}
	
			//检索空间
			$tospace = getspace(1);
			
			break;
		case 'postnoteid':
			$query = $_SGLOBAL['db']->query("SELECT pn.* FROM ".tname("postnote")." pn WHERE pn.postnoteid='$id'");
			$postnote = $_SGLOBAL['db']->fetch_array($query);
			if(! $postnote){
				if($mobileflag == 1){
					mobile_showmessage('postnote_not_exist');
				}
				else{
					showmessage('postnote_not_exist');//小贴士不存在或者已被删除
				}
			}
	
			//检索空间
			$tospace = getspace($postnote['uid']);
			
			break;
		case 'coverid':
			$query = $_SGLOBAL['db']->query("SELECT c.* FROM ".tname("cover")." c WHERE c.coverid='$id'");
			$cover = $_SGLOBAL['db']->fetch_array($query);
			if(! $cover){
				if($mobileflag == 1){
					mobile_showmessage('cover_does_not_exist');
				}
				else{
					showmessage('cover_does_not_exist');//翻唱不存在或者已被删除
				}
			}
	
			//检索空间
			$tospace = getspace($cover['uid']);
			
			break;
		case 'videoid':
			$query = $_SGLOBAL['db']->query("SELECT v.* FROM ".tname("video")." v WHERE v.videoid='$id'");
			$video = $_SGLOBAL['db']->fetch_array($query);
			if(! $video){
				if($mobileflag == 1){
					mobile_showmessage('video_does_not_exist');
				}
				else{
					showmessage('video_does_not_exist');//视频不存在或者已被删除
				}
			}

			//检索空间
			$tospace = getspace($video['uid']);

			break;
		case 'topicid':
			$query = $_SGLOBAL['db']->query("SELECT t.* FROM ".tname("topic")." t WHERE t.topicid='$id'");
			$topic = $_SGLOBAL['db']->fetch_array($query);
			if(! $topic){
				if($mobileflag == 1){
					mobile_showmessage('topic_does_not_exist');
				}
				else{
					showmessage('topic_does_not_exist');//广播剧不存在或者已被删除
				}
			}
	
			//是否允许评论
//			if(!empty($blog['noreply'])) {
//				showmessage('do_not_accept_comments');
//			}
//			if($blog['target_ids']) {
//				$blog['target_ids'] .= ",$blog[uid]";
//			}

			//检索空间
			$tospace = getspace($topic['uid']);
			
			$hotarr = array('topicid', $topic['topicid'], $topic['hotuser']);
			$stattype = 'topiccomment';//统计
			break;
		case 'topicforecastid':
			$query = $_SGLOBAL['db']->query("SELECT tf.* FROM ".tname("topic_forecast")." tf WHERE tf.topicforecastid='$id'");
			$topicforecast = $_SGLOBAL['db']->fetch_array($query);
			if(!$topicforecast){
				if($mobileflag == 1){
					mobile_showmessage('topicforecast_does_not_exist');
				}
				else{
					showmessage('topicforecast_does_not_exist');//广播剧不存在或者已被删除
				}
			}
			//检索空间
			$tospace = getspace($topicforecast['uid']);
			
			$hotarr = array('topicforecastid', $topicforecast['topicforecastid'], $topic['hotuser']);
			break;
		case 'toneid':
			$query = $_SGLOBAL['db']->query("SELECT t.* FROM ".tname("tone")." t WHERE toneid='$id'");
			$tone = $_SGLOBAL['db']->fetch_array($query);
			if(! $tone){
				if($mobileflag == 1){
					mobile_showmessage('tone_does_not_exist');
				}
				else{
					showmessage('tone_does_not_exist');//声线不存在或者已被删除
				}
			}
	
			//是否允许评论
//			if(!empty($blog['noreply'])) {
//				showmessage('do_not_accept_comments');
//			}
//			if($blog['target_ids']) {
//				$blog['target_ids'] .= ",$blog[uid]";
//			}

			//检索空间
			$tospace = getspace($tone['uid']);
			
			$hotarr = array('toneid', $tone['toneid'], $tone['hotuser']);
			$stattype = 'tonecomment';//统计
			break;
		case 'repasteid':
			$query = $_SGLOBAL['db']->query("SELECT r.* FROM ".tname("repaste")." r WHERE r.repasteid='$id'");
			$repaste = $_SGLOBAL['db']->fetch_array($query);
			if(! $repaste){
				if($mobileflag == 1){
					mobile_showmessage('repaste_does_not_exist');
				}
				else{
					showmessage('repaste_does_not_exist');//转帖不存在或者已被删除
				}
			}
	
			//是否允许评论
//			if(!empty($blog['noreply'])) {
//				showmessage('do_not_accept_comments');
//			}
//			if($blog['target_ids']) {
//				$blog['target_ids'] .= ",$blog[uid]";
//			}

			//检索空间
			$tospace = getspace($repaste['uid']);
			
			$hotarr = array('repasteid', $repaste['repasteid'], $repaste['hotuser']);
			$stattype = 'repastecomment';//统计
			break;
		default:
			if($mobileflag == 1){
				mobile_showmessage('non_normal_operation');
			}
			else{
				showmessage('non_normal_operation');
			}
			break;
	}
	
	if(empty($tospace)) {
		if($mobileflag == 1){
			mobile_showmessage('space_does_not_exist');
		}
		else{
			showmessage('space_does_not_exist');
		}
	}
	
	//视频认证
	if($tospace['videostatus']) {
		if($idtype == 'uid') {
			ckvideophoto('wall', $tospace);
		} else {
			ckvideophoto('comment', $tospace);
		}
	}
	
	//黑名单
	if(isblacklist($tospace['uid'])) {
		if($mobileflag == 1){
			mobile_showmessage('is_blacklist');
		}
		else{
			showmessage('is_blacklist');
		}
	}
	
	//热点
	if($hotarr && $tospace['uid'] != $_SGLOBAL['supe_uid']) {
		hot_update($hotarr[0], $hotarr[1], $hotarr[2]);
	}

	//事件
	$fs = array();
	$fs['icon'] = 'comment';
	$fs['target_ids'] = $fs['friend'] = '';

	switch ($idtype) {
		case 'uid':
			//事件
			$fs['icon'] = 'wall';
			$fs['title_template'] = cplang('feed_comment_space');
			$fs['title_data'] = array('touser'=>"<a href=\"space.php?uid=$tospace[uid]\">".$_SN[$tospace['uid']]."</a>");
			$fs['body_template'] = '';
			$fs['body_data'] = array();
			$fs['body_general'] = '';
			$fs['images'] = array();
			$fs['image_links'] = array();
			break;
		case 'picid':
			//事件
			$fs['title_template'] = cplang('feed_comment_image');
			$fs['title_data'] = array('touser'=>"<a href=\"space.php?uid=$tospace[uid]\">".$_SN[$tospace['uid']]."</a>");
			$fs['body_template'] = '{pic_title}';
			$fs['body_data'] = array('pic_title'=>$pic['title']);
			$fs['body_general'] = $summay;
			$fs['images'] = array(pic_get($pic['filepath'], $pic['thumb'], $pic['remote']));
			$fs['image_links'] = array("space.php?uid=$tospace[uid]&do=album&picid=$pic[picid]");
			$fs['target_ids'] = $album['target_ids'];
			$fs['friend'] = $album['friend'];
			break;
		case 'blogid':
			//更新评论统计
			$_SGLOBAL['db']->query("UPDATE ".tname('blog')." SET replynum=replynum+1 WHERE blogid='$id'");
			//事件
			$fs['title_template'] = cplang('feed_comment_blog');
			$fs['title_data'] = array('touser'=>"<a href=\"space.php?uid=$tospace[uid]\">".$_SN[$tospace['uid']]."</a>", 'blog'=>"<a href=\"space.php?uid=$tospace[uid]&do=blog&id=$id\">$blog[subject]</a>");
			$fs['body_template'] = '';
			$fs['body_data'] = array();
			$fs['body_general'] = '';
			$fs['target_ids'] = $blog['target_ids'];
			$fs['friend'] = $blog['friend'];
			break;
		case 'sid':
			//事件
			$fs['title_template'] = cplang('feed_comment_share');
			$fs['title_data'] = array('touser'=>"<a href=\"space.php?uid=$tospace[uid]\">".$_SN[$tospace['uid']]."</a>", 'share'=>"<a href=\"space.php?uid=$tospace[uid]&do=share&id=$id\">".str_replace(cplang('share_action'), '', $share['title_template'])."</a>");
			$fs['body_template'] = '';
			$fs['body_data'] = array();
			$fs['body_general'] = '';
			
			//更新分享统计
			$_SGLOBAL['db']->query("UPDATE ".tname('share')." SET replynum=replynum+1, replydateline = '$_SGLOBAL[timestamp]' WHERE sid='$id'");
		
			break;
		case 'eventid':
		    // 活动
		    $fs['title_template'] = cplang('feed_comment_event');
			$fs['title_data'] = array('touser'=>"<a href=\"space.php?uid=$tospace[uid]\">".$_SN[$tospace['uid']]."</a>", 'event'=>'<a href="space.php?do=event&id='.$event['eventid'].'">'.$event['title'].'</a>');
			$fs['body_template'] = '';
			$fs['body_data'] = array();
			$fs['body_general'] = '';
			
			//更新广播剧统计
			$_SGLOBAL['db']->query("UPDATE ".tname('event')." SET replynum=replynum+1 WHERE eventid='$id'");
			
			break;
		case 'pid':
			// 投票
			//更新评论统计
			$_SGLOBAL['db']->query("UPDATE ".tname('poll')." SET replynum=replynum+1 WHERE pid='$id'");
			$fs['title_template'] = cplang('feed_comment_poll');
			$fs['title_data'] = array('touser'=>"<a href=\"space.php?uid=$tospace[uid]\">".$_SN[$tospace['uid']]."</a>", 'poll'=>"<a href=\"space.php?uid=$tospace[uid]&do=poll&pid=$id\">$poll[subject]</a>");
			$fs['body_template'] = '';
			$fs['body_data'] = array();
			$fs['body_general'] = '';
			$fs['friend'] = '';
			break;
		case 'reportid':
			//更新举报统计
			$_SGLOBAL['db']->query("UPDATE ".tname('report')." SET replynum=replynum+1 WHERE rid='$id'");
			break;
		case 'mtagtaskid':
			//更新群组统计
			$_SGLOBAL['db']->query("UPDATE ".tname('mtagtask')." SET replynum=replynum+1 WHERE taskid='$id'");
			$_SGLOBAL['db']->query("UPDATE ".tname("mtag")." SET experience = experience+1 WHERE tagid='$id'");
			break;
		case 'postnoteid':
			//更新小贴士统计
			$_SGLOBAL['db']->query("UPDATE ".tname('postnote')." SET replynum=replynum+1 WHERE postnoteid='$id'");
			break;
		case 'coverid':
			//更新翻唱统计
			$_SGLOBAL['db']->query("UPDATE ".tname('cover')." SET replynum=replynum+1 WHERE coverid='$id'");
			break;	
		case 'videoid':
			//更新视频统计
			$_SGLOBAL['db']->query("UPDATE ".tname('video')." SET replynum=replynum+1, replydateline = '$_SGLOBAL[timestamp]' WHERE videoid='$id'");
			break;	
		case 'topicid':
			//更新广播剧统计
			$_SGLOBAL['db']->query("UPDATE ".tname('topic')." SET replynum=replynum+1, replydateline = '$_SGLOBAL[timestamp]' WHERE topicid='$id'");
			break;	
		case 'topicforecastid':
			//更新广播剧预告统计
			$_SGLOBAL['db']->query("UPDATE ".tname('topic_forecast')." SET replynum=replynum+1, replydateline = '$_SGLOBAL[timestamp]' WHERE topicforecastid='$id'");
			break;	
		case 'toneid':
			//更新声线统计
			$_SGLOBAL['db']->query("UPDATE ".tname('tone')." SET replynum=replynum+1 WHERE toneid='$id'");
			break;
			
		case 'repasteid':
			//更新转帖统计
			$_SGLOBAL['db']->query("UPDATE ".tname('repaste')." SET replynum=replynum+1 WHERE repasteid='$id'");
			break;
	}

	$setarr = array(
		'uid' => $tospace['uid'],
		'id' => $id,
		'idtype' => $idtype,
		'authorid' => $_SGLOBAL['supe_uid'],
		'author' => $_SGLOBAL['supe_username'],
		'dateline' => $_SGLOBAL['timestamp'],
		'message' => $message,
		'ip' => getonlineip()
	);
	
	//入库
	$cid = inserttable('comment', $setarr, 1);
	
	$action = 'comment';
	$becomment = 'getcomment';
	switch ($idtype) {
		case 'uid':
			$n_url = "space.php?uid=$tospace[uid]&do=wall&cid=$cid";
			$note_type = 'wall';
			$note = cplang('note_wall', array($n_url));
			$q_note = cplang('note_wall_reply', array($n_url));
			if($comment) {
				$msg = 'note_wall_reply_success';
				$magvalues = array($_SN[$tospace['uid']]);
				$becomment = '';
			} else {
				$msg = 'do_success';
				$magvalues = array();
				$becomment = 'getguestbook';
			}
			$msgtype = 'comment_friend';
			$q_msgtype = 'comment_friend_reply';
			$action = 'guestbook';
			break;
		case 'picid':
			$n_url = "space.php?uid=$tospace[uid]&do=album&picid=$id&cid=$cid";
			$note_type = 'piccomment';
			$note = cplang('note_pic_comment', array($n_url));
			$q_note = cplang('note_pic_comment_reply', array($n_url));
			$msg = 'do_success';
			$magvalues = array();
			$msgtype = 'photo_comment';
			$q_msgtype = 'photo_comment_reply';
			break;
		case 'blogid':
			//通知
			$n_url = "space.php?uid=$tospace[uid]&do=blog&id=$id&cid=$cid";
			$note_type = 'blogcomment';
			$note = cplang('note_blog_comment', array($n_url, $blog['subject']));
			$q_note = cplang('note_blog_comment_reply', array($n_url));
			$msg = 'do_success';
			$magvalues = array();
			$msgtype = 'blog_comment';
			$q_msgtype = 'blog_comment_reply';
			break;
		case 'sid':
			//分享
			$n_url = "space.php?uid=$tospace[uid]&do=share&id=$id&cid=$cid";
			$note_type = 'sharecomment';
			$note = cplang('note_share_comment', array($n_url));
			$q_note = cplang('note_share_comment_reply', array($n_url));
			$msg = 'do_success';
			$magvalues = array();
			$msgtype = 'share_comment';
			$q_msgtype = 'share_comment_reply';
			break;
		case 'pid':
			$n_url = "space.php?uid=$tospace[uid]&do=poll&pid=$id&cid=$cid";
			$note_type = 'pollcomment';
			$note = cplang('note_poll_comment', array($n_url, $poll['subject']));
			$q_note = cplang('note_poll_comment_reply', array($n_url));
			$msg = 'do_success';
			$magvalues = array();
			$msgtype = 'poll_comment';
			$q_msgtype = 'poll_comment_reply';
			break;
		case 'eventid':
		    // 活动
		    $n_url = "space.php?do=event&id=$id&view=comment&cid=$cid";
		    $note_type = 'eventcomment';
		    $note = cplang('note_event_comment', array($n_url));
		    $q_note = cplang('note_event_comment_reply', array($n_url));
		    $msg = 'do_success';
		    $magvalues = array();
		    $msgtype = 'event_comment';
		    $q_msgtype = 'event_comment_reply';
		    break;
		case 'reportid':
		    // 举报
		    $n_url = "space.php?do=report&op=viewsingle&reportid=$id";
		    $note_type = 'reportcomment';
		    $note = cplang('note_report_comment', array($n_url,$message));
		    $q_note = cplang('note_report_comment_reply', array($n_url));
		    $msg = 'do_success';
		    $magvalues = array();
		    $msgtype = 'report_comment';
		    $q_msgtype = 'report_comment_reply';
			break; 
		case 'mtagtaskid':
		    // 群组成员任务
		    $n_url = "space.php?do=mtag&view=task&tagid=$mtagtask[tagid]&taskid=$id";
		    $tasksubject = $mtagtask[subject];
		    $note_type = 'mtagtaskcomment';
		    $note = cplang('note_mtagtask_comment', array($n_url, $tasksubject, $message));
		    $q_note = cplang('note_mtagtask_comment_reply', array($n_url, $tasksubject, $message));
		    $msg = 'do_success';
		    $magvalues = array();
		    $msgtype = 'mtagtask_comment';
		    $q_msgtype = 'mtagtask_comment_reply';
			break; 
		case 'postnoteid':
		    // 小贴士
		    $n_url = "space.php?do=postnote&postnoteid=$id";
		    $postnotesubject = $postnote[subject];
		    $note_type = 'postnotecomment';
		    $note = cplang('note_postnote_comment', array($n_url, $postnotesubject, $message));
		    $q_note = cplang('note_postnote_comment_reply', array($n_url, $postnotesubject, $message));
		    $msg = 'do_success';
		    $magvalues = array();
		    $msgtype = 'postnote_comment';
		    $q_msgtype = 'postnote_comment_reply';
			break; 
		case 'coverid':
		    // 翻唱
		    $n_url = "space.php?do=cover&coverid=$id&view=comment&cid=$cid";
		    $note_type = 'covercomment';
			include_once(S_ROOT.'./source/function_cover.php');
		    $cover=loadcoverbyid($id);
		    $note = cplang('note_cover_comment', array($n_url,$cover[subject],$message));
		    $q_note = cplang('note_cover_comment_reply', array($n_url));
		    $msg = 'do_success';
		    $magvalues = array();
		    $msgtype = 'cover_comment';
		    $q_msgtype = 'cover_comment_reply';
			break;    
		case 'videoid':
		    // 视频
		    $n_url = "space.php?do=video&videoid=$id&view=comment&cid=$cid";
		    $note_type = 'videocomment';
			include_once(S_ROOT.'./source/function_video.php');
		    $video=loadvideobyid($id);
		    $note = cplang('note_video_comment', array($n_url,$video[subject],$message));
		    $q_note = cplang('note_video_comment_reply', array($n_url));
		    $msg = 'do_success';
		    $magvalues = array();
		    $msgtype = 'video_comment';
		    $q_msgtype = 'video_comment_reply';
			break;    
		case 'topicid':
		    // 广播剧
		    $n_url = "space.php?do=topic&topicid=$id&view=comment&cid=$cid";
		    $note_type = 'topiccomment';
			include_once(S_ROOT.'./source/function_topic.php');
		    $topic=loadtopicbyid($id);
		    $note = cplang('note_topic_comment', array($n_url,$topic[subject],$message));
		    $q_note = cplang('note_topic_comment_reply', array($n_url));
		    $msg = 'do_success';
		    $magvalues = array();
		    $msgtype = 'topic_comment';
		    $q_msgtype = 'topic_comment_reply';
			break;    
		case 'topicforecastid':
		    // 广播剧
		    $n_url = "space.php?do=topic&topicforecastid=$id&view=comment&cid=$cid";
		    $note_type = 'topicforecastcomment';
			include_once(S_ROOT.'./source/function_topic.php');
		    $topicforecast=loadtopicforecastbyid($id);
		    $note = cplang('note_topicforecast_comment', array($n_url,$topicforecast[subject],$message));
		    $q_note = cplang('note_topicforecast_comment_reply', array($n_url));
		    $msg = 'do_success';
		    $magvalues = array();
		    $msgtype = 'topicforecast_comment';
		    $q_msgtype = 'topicforecast_comment_reply';
			break;    
		case 'toneid':
		    // 声线
		    $n_url = "space.php?do=tone&toneid=$id&view=comment&cid=$cid";
		    $note_type = 'tonecomment';
		    $note = cplang('note_tone_comment', array($n_url));
		    $q_note = cplang('note_tone_comment_reply', array($n_url));
		    $msg = 'do_success';
		    $magvalues = array();
		    $msgtype = 'tone_comment';
		    $q_msgtype = 'tone_comment_reply';
		    break;
		case 'repasteid':
		    // 转帖
		    $n_url = "space.php?do=repaste&id=$id&view=comment&cid=$cid";
		    $note_type = 'repastecomment';
		    $note = cplang('note_repaste_comment', array($n_url));
		    $q_note = cplang('note_repaste_comment_reply', array($n_url));
		    $msg = 'do_success';
		    $magvalues = array();
		    $msgtype = 'repaste_comment';
		    $q_msgtype = 'repaste_comment_reply';
		    break;
	}


 	if( !empty($replypollvoteruid) ){
		notification_add($replypollvoteruid, $note_type, $q_note);
	}
	elseif(empty($comment)) {
					
		//非引用评论
		if($tospace['uid'] != $_SGLOBAL['supe_uid']) {
			//事件发布
		
	
			if(ckprivacy('comment', 1)) {
			
				feed_add($fs['icon'], $fs['title_template'], $fs['title_data'], $fs['body_template'], $fs['body_data'], $fs['body_general'],$fs['images'], $fs['image_links'], $fs['target_ids'], $fs['friend']);
			}
		
			
			//发送通知
			if(!empty($note)){
				if($note_type == 'topiccomment'){
					//发送消息给所有收藏该广播剧的人
				    $querytopicusersql="SELECT DISTINCT tu.uid FROM ".tname("topicuser")." tu WHERE tu.topicid=$id AND tu.uid!=$_SGLOBAL[supe_uid]";
				    $query = $_SGLOBAL['db']->query($querytopicusersql);
					while ($topicuser = $_SGLOBAL['db']->fetch_array($query)) {
						notification_add($topicuser['uid'], $note_type, $note);
				    }	
				}
				elseif($note_type == 'topicforecastcomment'){
					//发送消息给所有关注该广播剧预告的人
				    $querytopicforecastusersql="SELECT DISTINCT tfu.uid FROM ".tname("topic_forecast_user")." tfu WHERE tfu.topicforecastid=$id AND tfu.uid!=$_SGLOBAL[supe_uid]";
				    $query = $_SGLOBAL['db']->query($querytopicforecastusersql);
					while ($topicforecastuser = $_SGLOBAL['db']->fetch_array($query)) {
						notification_add($topicforecastuser['uid'], $note_type, $note);
				    }	
				}
				elseif($note_type == 'covercomment'){
					//发送消息给所有收藏该翻唱的人
				    $querycoverusersql="SELECT DISTINCT cu.uid FROM ".tname("coveruser")." cu WHERE cu.coverid=$id AND cu.uid!=$_SGLOBAL[supe_uid]";
				    $querycoverusersql.="UNION";
				    $querycoverusersql="SELECT c.uid FROM ".tname("cover")." c WHERE c.coverid=$id AND c.uid!=$_SGLOBAL[supe_uid]";
				    $query = $_SGLOBAL['db']->query($querycoverusersql);
					while ($coveruser = $_SGLOBAL['db']->fetch_array($query)) {
						notification_add($coveruser['uid'], $note_type, $note);
				    }	
				}
				elseif($note_type == 'videocomment'){
					//发送消息给所有收藏该视频的人
				    $queryvideousersql="SELECT DISTINCT vu.uid FROM ".tname("videouser")." vu WHERE vu.videoid=$id AND vu.uid!=$_SGLOBAL[supe_uid]";
				    $query = $_SGLOBAL['db']->query($queryvideousersql);
					while ($videouser = $_SGLOBAL['db']->fetch_array($query)) {
						notification_add($videouser['uid'], $note_type, $note);
				    }	
				}
				elseif($note_type == 'reportcomment'){
					$userids=split('/',$report[userids]);
					$useridarray=array();
					foreach($userids as $useriditem){
						if(!empty($useriditem)){
							$useridarray[$useriditem]=$useriditem;
						}
					}
					
					$adminusersql="SELECT s.uid FROM ysys_space s WHERE 1=1 AND s.groupid=1 ORDER BY s.uid";
					$query = $_SGLOBAL['db']->query($adminusersql);
					$list=array();
					while ($value = $_SGLOBAL['db']->fetch_array($query)) {
						$useridarray[$value[uid]]=$value[uid];
					}
					foreach ($useridarray as $userid) {
						if( empty($userid) || $userid==$_SGLOBAL[supe_uid] ){
							continue;
						}
						notification_add($userid, $note_type, $note);
					}
				}
				elseif($note_type == 'mtagtaskcomment'){
					//发送消息给所有参与成员
					$memberquerysql = "SELECT distinct mm.uid FROM ".tname('mtagmember')." mm ";
					$memberquerysql .= " WHERE mm.tagid='$mtagtask[tagid]' AND mm.memberid in (0$mtagtask[members]0)";
					$query = $_SGLOBAL['db']->query($memberquerysql);
					while ($memberuser = $_SGLOBAL['db']->fetch_array($query)) {
						if($memberuser['uid'] != $_SGLOBAL['supe_uid']) {
							notification_add($memberuser['uid'], "mtag_task", $note);
						}
				    }	
				}
				else{
					notification_add($tospace['uid'], $note_type, $note);
				}
			}
			
			//留言发送短消息
			if($idtype == 'uid' && $tospace['updatetime'] == $tospace['dateline']) {
				include_once S_ROOT.'./uc_client/client.php';
				uc_pm_send($_SGLOBAL['supe_uid'], $tospace['uid'], cplang('wall_pm_subject'), cplang('wall_pm_message', array(addslashes(getsiteurl().$n_url))), 1, 0, 0);
			}
			
			//发送邮件通知
			//smail($tospace['uid'], '', cplang($msgtype, array($_SN[$space['uid']], shtmlspecialchars(getsiteurl().$n_url))), '', $msgtype);
		}
		
	} elseif($comment['authorid'] != $_SGLOBAL['supe_uid']) {
		
		//发送邮件通知
		smail($comment['authorid'], '', cplang($q_msgtype, array($_SN[$space['uid']], shtmlspecialchars(getsiteurl().$n_url))), '', $q_msgtype);
		notification_add($comment['authorid'], $note_type, $q_note);
	}
	
	//统计
	if($stattype) {
		updatestat($stattype);
	}
	
	//积分
	if($tospace['uid'] != $_SGLOBAL['supe_uid']) {
		$needle = $id;
		if($idtype != 'uid') {
			$needle = $idtype.$id;
		} else {
			$needle = $tospace['uid'];
		}
		//奖励评论发起者
		getreward($action, 1, 0, $needle);
		//奖励被评论者
		if($becomment) {
			if($idtype == 'uid') {
				$needle = $_SGLOBAL['supe_uid'];
			}
			getreward($becomment, 1, $tospace['uid'], $needle, 0);
		}
	}
}

?>