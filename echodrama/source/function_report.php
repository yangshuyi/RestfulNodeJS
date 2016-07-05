<?php
/*
 [UCenter Home] (C) 2007-2008 Comsenz Inc.
 $Id: function_delete.php 13001 2009-08-05 06:18:06Z zhengqingpeng $
 */

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}


function loadreportbyid($rid){
	global $_SGLOBAL, $_SC;
	
	$qsql="SELECT r.* FROM ".tname("report")." r WHERE r.rid=$rid";
	
	$query = $_SGLOBAL['db']->query($qsql);
	$value = $_SGLOBAL['db']->fetch_array($query);
	
	return $value;
}

function deletereports($reportids, $deletemessage) {
	global $_SGLOBAL, $_SC;
	
	include_once(S_ROOT.'./source/function_cp.php');
	
	//����
	$list = array();
	$qsql="SELECT * FROM ".tname('report')." WHERE rid IN (".simplode($reportids).")";
	$query = $_SGLOBAL['db']->query($querysql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$list[]=$value;
	}
	
	foreach($list as $value) {
		$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE idtype='reportid' and id='$value[rid]'");
		$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE rid='$value[rid]'");
		
//		$notification="</br>��Ǹ�����ϴ��Ĺ㲥��&nbsp;���$value[topicid]&nbsp;����&nbsp;$value[subject]&nbsp;�ѱ�ɾ����";
//		if(!empty($deletemessage)){
//			$notification=$notification."</br>ɾ�����ɣ�".$deletemessage;
//		}
//		notification_add($value[uid],"topic_delete",$notification,0);
	}
		
	
	return true;
}


// ��ѯ�ٱ�
function queryreport($querysql){
	global $_SGLOBAL, $_SC;

	$list=array();
	 $ids = array();
	$blogids = $picids = $albumids = $spaceids = $pollids = $mtagids = $threadids = $shareids = $eventids = $shareids = $topicids = $coverids = $videoids = $toneids = $repasteids = $posts = $comments = array();
	$bloglist = $piclist = $albumlist = $spacelist = $polllist = $mtagids = $threadids = $shareids = $eventids = $shareids = $topicids = $coverids = $videoids = $toneids = $repasteids = $postids = $commentids = array();

	$query = $_SGLOBAL['db']->query($querysql);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {

		$list[$value[rid]] = reportformmapper($value);
		switch($value['idtype']) {
			case 'blogid':
				$blogids[] = $value;
				break;
			case 'picid':
				$picids[] = $value;
				break;
			case 'albumid':
				$albumids[] = $value;
				break;
			case 'threadid':
				$threadids[] = $value;
				break;
			case 'tagid':
				$mtagids[] = $value;
				break;
			case 'shareid':
				$shareids[] = $value;
				break;
			case 'uid':
				$spaceids[] = $value;
				break;
			case 'eventid':
				$eventids[] = $value;
				break;
			case 'pollid':
				$pollids[] = $value;
				break;
			case 'commentid':
				$commentids[] = $value;
				break;
			case 'postid':
				$posts[] = $value;
				break;
			case 'topicid':
				$topicids[] = $value;
				break;
			case 'coverid':
				$coverids[] = $value;
				break;
			case 'videoid':
				$videoids[] = $value;
				break;
			case 'toneid':
				$toneids[] = $value;
				break;
			case 'repasteid':
				$repasteids[] = $value;
				break;
		}
	}
	//ȡ�������Ϣ
	//�ռ�
	if(count($blogids)>0) {
		$blogqsql="0";
		foreach($blogids as $value) {
			$blogqsql=$blogqsql.",".$value['id'];
		}
		$query = $_SGLOBAL['db']->query("SELECT b.*,r.rid FROM ".tname('blog')." b LEFT OUTER JOIN ".tname('report')." r ON b.blogid = r.id AND r.idtype='blogid' WHERE b.blogid IN ($blogqsql)");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			$list[$value[rid]]['blog']=$value;
			$list[$value[rid]]['dispidtype']="�����ռ�";
			$list[$value[rid]]['url']="space.php?do=blog&id=$value[blogid]&uid=$value[uid]";
			$list[$value[rid]]['subject']=$value[subject];
		}
	}
	//ͼƬ
	if(count($picids)>0) {
		$picqsql="0";
		foreach($picids as $value) {
			$picqsql=$picqsql.",".$value['id'];
		}
		$query = $_SGLOBAL['db']->query("SELECT p.*,r.rid FROM ".tname('pic')." p LEFT OUTER JOIN ".tname('report')." r ON p.picid = r.id AND r.idtype='picid' WHERE p.picid IN ($picqsql)");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			$value['pic'] = pic_get($value['filepath'], $value['thumb'], $value['remote']);
			$list[$value[rid]]['pic']=$value;
			$list[$value[rid]]['dispidtype']="ͼƬ��Դ";
			$list[$value[rid]]['url']="space.php?do=album&picid=$value[picid]&uid=$value[uid]";
			$list[$value[rid]]['subject']=$value[title];
		}
	}
	//���
	if(count($albumids)>0) {
		$albumqsql="0";
		foreach($albumids as $value) {
			$albumqsql=$albumqsql.",".$value['id'];
		}
		$query = $_SGLOBAL['db']->query("SELECT a.*,r.rid FROM ".tname('album')." a LEFT OUTER JOIN ".tname('report')." r ON a.albumid = r.id AND r.idtype='albumid' WHERE a.albumid IN ($albumqsql)");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			$value['pic'] = pic_cover_get($value['pic'], $value['picflag']);
			$list[$value[rid]]['album']=$value;
			$list[$value[rid]]['dispidtype']="���ϼ�";
			$list[$value[rid]]['url']="space.php?&do=album&id=$value[albumid]&uid=$value[uid]";
			$list[$value[rid]]['subject']=$value[albumname];
		}
	}

	//����
	if(count($threadids)>0) {
		$threadqsql="0";
		foreach($threadids as $value) {
			$threadqsql=$threadqsql.",".$value['id'];
		}

		$query = $_SGLOBAL['db']->query("SELECT mt.*,r.rid FROM ".tname('mtag_thread')." mt LEFT OUTER JOIN ".tname('report')." r ON mt.tid = r.id AND r.idtype='threadid' WHERE mt.tid IN ($threadqsql)");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			$list[$value[rid]]['thread']=$value;
			$list[$value[rid]]['dispidtype']="Ⱥ�黰��";
			$list[$value[rid]]['url']="space.php?do=thread&id=$value[tid]";
			$list[$value[rid]]['subject']=$value[subject];
		}
	}

	//����ظ�
	if(count($postids)>0) {
		$postqsql="0";
		foreach($postids as $value) {
			$postqsql=$postqsql.",".$value['id'];
		}

		$query = $_SGLOBAL['db']->query("SELECT p.*,r.rid FROM ".tname('post')." p LEFT OUTER JOIN ".tname('report')." r ON p.pid = r.id AND r.idtype='postid' WHERE p.pid IN ($postqsql)");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			$list[$value[rid]]['post']=$value;
			$list[$value[rid]]['dispidtype']="����ظ�";
			$list[$value[rid]]['url']="space.php?do=thread&tid=$value[tid]&pid=$value[pid]";
			$list[$value[rid]]['subject']=getstr($value[message], 24, 0, 0, 0, 0, -1);
		}
	}

	//Ⱥ��
	if(count($mtagids)>0) {
		$mtagqsql="0";
		foreach($mtagids as $value) {
			$mtagqsql=$mtagqsql.",".$value['id'];
		}

		$query = $_SGLOBAL['db']->query("SELECT m.*,r.rid FROM ".tname('mtag')." m LEFT OUTER JOIN ".tname('report')." r ON m.tagid = r.id AND r.idtype='tagid' WHERE m.tagid IN ($mtagqsql)");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			$list[$value[rid]]['mtag']=$value;
			$list[$value[rid]]['dispidtype']="Ȧ��Ⱥ��";
			$list[$value[rid]]['url']="space.php?do=mtag&tagid=$value[tagid]";
			$list[$value[rid]]['subject']=$value[tagname];
		}
	}

	//����
	if(count($shareids)>0) {
		$shareqsql="0";
		foreach($shareids as $value) {
			$shareqsql=$shareqsql.",".$value['id'];
		}

		$query = $_SGLOBAL['db']->query("SELECT s.*,r.rid FROM ".tname('share')." s LEFT OUTER JOIN ".tname('report')." r ON s.sid = r.id AND r.idtype='shareid' WHERE s.sid IN ($shareqsql)");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			$value = mkshare($value);
			$list[$value[rid]]['share']=$value;
			$list[$value[rid]]['dispidtype']="������";
			$list[$value[rid]]['url']="space.php?do=share&id=$value[sid]&uid=$value[uid]";
			$list[$value[rid]]['subject']=$value[username]."�����".$value[title_template];
		}
	}

	//�ռ�
	if(count($spaceids)>0) {
		$spacesql="0";
		foreach($spaceids as $value) {
			$spacesql=$spacesql.",".$value['id'];
		}

		$query = $_SGLOBAL['db']->query("SELECT s.*,r.rid FROM ".tname('space')." s LEFT OUTER JOIN ".tname('report')." r ON s.uid = r.id AND r.idtype='uid' WHERE s.uid IN ($spacesql)");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			$list[$value[rid]]['space']=$value;
			$list[$value[rid]]['dispidtype']="�����";
			$list[$value[rid]]['url']="space.php?uid=$value[uid]";
			$list[$value[rid]]['subject']=$value[username];
		}
	}

	// �
	if(count($eventids)>0) {
		$eventsql="0";
		foreach($eventids as $value) {
			$eventsql=$eventsql.",".$value['id'];
		}

		$query = $_SGLOBAL['db']->query("SELECT e.*,r.rid FROM ".tname('event')." e LEFT OUTER JOIN ".tname('report')." r ON e.eventid = r.id AND r.idtype='eventid' WHERE e.eventid IN ($eventsql)");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			$list[$value[rid]]['event']=$value;
			$list[$value[rid]]['dispidtype']="��ļ�";
			$list[$value[rid]]['url']="space.php?do=event&id=$value[eventid]";
			$list[$value[rid]]['subject']=$value[title];
		}
	}

	//ͶƱ
	if(count($pollids)>0) {
		$pollsql="0";
		foreach($pollids as $value) {
			$pollsql=$pollsql.",".$value['id'];
		}

		$query = $_SGLOBAL['db']->query("SELECT p.*,r.rid FROM ".tname('poll')." p LEFT OUTER JOIN ".tname('report')." r ON p.pid = r.id AND r.idtype='pollid' WHERE p.pid IN ($pollsql)");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			$list[$value[rid]]['poll']=$value;
			$list[$value[rid]]['dispidtype']="��ѪͶƱ";
			$list[$value[rid]]['url']="space.php?do=poll&pid=$value[pid]&uid=$value[uid]";
			$list[$value[rid]]['subject']=$value[subject];
		}
	}

	//�㲥��
	if(count($topicids)>0) {
		$topicsql="0";
		foreach($topicids as $value) {
			$topicsql=$topicsql.",".$value['id'];
		}

		$topicsql="SELECT t.*,r.rid FROM ".tname('topic')." t LEFT OUTER JOIN ".tname('report')." r ON t.topicid = r.id AND r.idtype='topicid' WHERE t.topicid IN ($topicsql)";
		$query = $_SGLOBAL['db']->query($topicsql);
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			$list[$value[rid]]['topic']=$value;
			$list[$value[rid]]['dispidtype']="�㲥�糡";
			$list[$value[rid]]['url']="space.php?do=topic&topicid=$value[topicid]";
			$list[$value[rid]]['subject']=$value[subject];
		}
	}
		
	//�ֳ淭��
	if(count($coverids)>0) {
		$coversql="0";
		foreach($coverids as $value) {
			$coversql=$coversql.",".$value['id'];
		}
		
		$coversql="SELECT c.*,r.rid FROM ".tname('cover')." c LEFT OUTER JOIN ".tname('report')." r ON c.coverid = r.id AND r.idtype='coverid' WHERE c.coverid IN ($coversql)";
		$query = $_SGLOBAL['db']->query($coversql);
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			$list[$value[rid]]['cover']=$value;
			$list[$value[rid]]['dispidtype']="�ֳ淭��";
			$list[$value[rid]]['url']="space.php?do=cover&coverid=$value[coverid]";
			$list[$value[rid]]['subject']=$value[subject];
		}
	}
	
	//��Ƶӳ��
	if(count($videoids)>0) {
		$videosql="0";
		foreach($videoids as $value) {
			$videosql=$videosql.",".$value['id'];
		}

		$videosql="SELECT v.*,r.rid FROM ".tname('video')." v LEFT OUTER JOIN ".tname('report')." r ON v.videoid = r.id AND r.idtype='videoid' WHERE v.videoid IN ($videosql)";
		$query = $_SGLOBAL['db']->query($videosql);
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			$list[$value[rid]]['video']=$value;
			$list[$value[rid]]['dispidtype']="��Ƶӳ��";
			$list[$value[rid]]['url']="space.php?do=video&videoid=$value[videoid]";
			$list[$value[rid]]['subject']=$value[subject];
		}
	}
	
	//����
	if(count($toneids)>0) {
		$tonesql="0";
		foreach($toneids as $value) {
			$tonesql=$tonesql.",".$value['id'];
		}

		$query = $_SGLOBAL['db']->query("SELECT t.*,r.rid FROM ".tname('tone')." t LEFT OUTER JOIN ".tname('report')." r ON t.toneid = r.id AND r.idtype='toneid' WHERE t.toneid IN ($tonesql)");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			$list[$value[rid]]['tone']=$value;
			$list[$value[rid]]['dispidtype']="���߻���";
			$list[$value[rid]]['url']="space.php?do=tone&toneid=$value[toneid]";
			$list[$value[rid]]['subject']=$value[username]."-".$value[label];
		}
	}

	//ת��
	if(count($repasteids)>0) {
		$repastesql="0";
		foreach($repasteids as $value) {
			$repastesql=$repastesql.",".$value['id'];
		}

		$query = $_SGLOBAL['db']->query("SELECT re.*,r.rid FROM ".tname('repaste')." re LEFT OUTER JOIN ".tname('report')." r ON re.repasteid = r.id AND r.idtype='repasteid' WHERE re.repasteid IN ($repastesql)");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			$list[$value[rid]]['repaste']=$value;
			$list[$value[rid]]['dispidtype']="����ת��";
			$list[$value[rid]]['url']="space.php?do=repaste&id=$value[repasteid]&uid=$value[uid]";
			$list[$value[rid]]['subject']=$value[subject];
		}
	}

	//����
	if(count($commentids)>0) {
		$commentsql="0";
		foreach($commentids as $value) {
			$commentsql=$commentsql.",".$value['id'];
		}

		$query = $_SGLOBAL['db']->query("SELECT c.*,r.rid FROM ".tname('comment')." c LEFT OUTER JOIN ".tname('report')." r ON c.cid = r.id AND r.idtype='comment' WHERE c.cid IN ($commentsql)");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			$url = "space.php?uid=$value[uid]&do=";
			switch ($value['idtype']) {
				case 'uid':
					//����
					$url .= "wall&view=me&cid=$value[cid]";
					break;
				case 'picid':
					//���
					$url .= "album&picid=$value[id]&cid=$value[cid]";
					break;
				case 'blogid':
					//�ռ�
					$url .= "blog&id=$value[id]&cid=$value[cid]";
					break;
				case 'sid':
					//����
					$url .= "share&id=$value[id]&cid=$value[cid]";
					break;
				case 'pid':
					//ͶƱ
					$url .= "poll&pid=$value[id]&cid=$value[cid]";
					break;
				case 'eventid':
					// �
					$url .= "event&id=$value[id]&cid=$value[cid]";
					break;
				case 'topicid':
					// �㲥��
					$url .= "topic&topicid=$value[id]&cid=$value[cid]";
					break;
				case 'coverid':
					// �ֳ淭��
					$url .= "cover&coverid=$value[id]&cid=$value[cid]";
					break;
				case 'videoid':
					// ��Ƶӳ��
					$url .= "video&videoid=$value[id]&cid=$value[cid]";
					break;
				case 'toneid':
					// ����
					$url .= "tone&id=$value[id]&cid=$value[cid]";
					break;
				case 'repasteid':
					// ת��
					$url .= "repaste&repasteid=$value[id]&cid=$value[cid]";
					break;
			}

			$value['url'] = $url;
			$value['message'] = getstr($value['message'], 150, 1, 1, 0, 0, -1);
			$list[$value[rid]]['dispidtype']="�٣�����";
			$list[$value[rid]]['subject']=$value['message'];
		}
	}

	return $list;
}
function reportformmapper($value){
	global $_SGLOBAL, $_SC;

	$value['dispdateline'] = sgmdate('Y-m-d H:i', $value['dateline']);
	
	$arr=explode('/',$value['usernames']);
	$dispusername="";
	foreach ($arr as $username) {
		$dispusername=$dispusername.$username." ";
	}
	$value['dispusername'] = $dispusername;
	return $value;
}

?>