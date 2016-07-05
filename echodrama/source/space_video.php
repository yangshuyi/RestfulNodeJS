<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_repaste.php 13208 2009-08-20 06:31:35Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//ҳ��ģ��
$site_module_actives = array('portal_video' => ' class="portalmenuli-sel"');
	
$videoid = empty($_GET['videoid'])?0:intval($_GET['videoid']);
$view = isset($_GET['view']) ? $_GET['view'] : "all";

$page = empty($_GET['page'])?1:intval($_GET['page']);
if($page<1) $page = 1;

$perpage = empty($_GET['perpage'])?10:intval($_GET['perpage']);
$start = ($page-1)*$perpage;

//��̬����
@include_once(S_ROOT.'./data/data_click.php');
include_once(S_ROOT.'./source/function_video.php');
include_once(S_ROOT.'./data/data_videoproductclass.php');

$clicks = empty($_SGLOBAL['click']['videoid'])?array():$_SGLOBAL['click']['videoid'];

if($videoid) {
	
	//��ȡ��Ƶ
	$video = loadvideobyid($videoid);
	//��Ƶ������
	if(empty($video)) {
		showmessage('video_does_not_exist');
	}
	
	$video=videoformmapper($video);
	//������Ƶ��ǩ
	if(!empty($video['product'])){
		$swfindex=stripos($video['product'],".swf");
		$mp3index=stripos($video['product'],".mp3");
		$wmaindex=stripos($video['product'],".wma");
		if($swfindex>0){
			$video['productpath'] = video_bbcode("[flash]".$video['product']."[/flash]");
		}
		elseif($mp3index>0){
			$video['productpath'] = video_bbcode("[flash=media]".$video['product']."[/flash]");
		}
		elseif($wmaindex>0){
			$video['productpath'] = video_bbcode("[flash=real]".$video['product']."[/flash]");
		}
		else{
			$video['productpath'] = $video['product'];
		}
	}
	
	$video['message'] = video_bbcode($video['message']);
	
	//�Ƿ��ղ�
	$shareSql= "SELECT COUNT(*) FROM ".tname('videouser')." vu WHERE vu.videoid=$videoid and vu.uid=$_SGLOBAL[supe_uid]";
	$inShare = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($shareSql), 0);

	//�Ƿ�������
	$userip=getonlineip(0);
	$videopollsql= "SELECT * FROM ".tname('videopoll')." vp WHERE vp.videoid=$videoid and ( vp.uid='$_SGLOBAL[supe_uid]' OR vp.userip='$userip' )";
	$query = $_SGLOBAL['db']->query($videopollsql);
	$videopoll = $_SGLOBAL['db']->fetch_array($query);
 
	//��Ƶ��ǩ
	$videolabel_list = loadvideolabelbyvideoid($video[videoid]);
	
	$videolabel_latest_sql = "SELECT vl.* FROM ".tname('videolabel')." vl WHERE vl.videoid='$videoid' AND vl.uid>0 ORDER BY vl.lastpost DESC LIMIT 0, 10";
	$videolabel_lastest_list = queryvideolabel($videolabel_latest_sql);
	
	$videolabel_me_sql = "SELECT vl.label FROM ".tname('videolabel')." vl WHERE vl.videoid='$videoid' AND uid='$_SGLOBAL[supe_uid]' ORDER BY vl.lastpost DESC";
	$videolabel_me_list = queryvideolabel($videolabel_me_sql);
	
	
	//���ߵ�����������Ƶ
	$otherlist = array();
	$qsql="SELECT * FROM ".tname('video')." WHERE uid='$video[uid]' AND videoid!='$videoid' ORDER BY dateline DESC LIMIT 0,6";
	$userothervideolist=queryvideo($qsql);
	
	//ͬ���͵�������Ƶ
	$newlist = array();
	$qsql="SELECT * FROM ".tname('video')." v WHERE v.productclassid='$video[productclassid]' order by (v.poll_1*1+v.poll_2*2+v.poll_3*3+v.poll_4*4+v.poll_5*5) desc LIMIT 0,6";
	$sameproductclassidvideolist=queryvideo($qsql);

	//����
	$perpage = 30;
	$perpage = mob_perpage($perpage);
	
	$start = ($page-1)*$perpage;

	//��鿪ʼ��
	ckstart($start, $perpage);

	$count = $video['replynum'];

	$commentlist = array();
	if($count) {
		$cid = empty($_GET['cid'])?0:intval($_GET['cid']);
		$csql = $cid?"cid='$cid' AND":'';

		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('comment')." WHERE $csql id='$videoid' AND idtype='videoid' ORDER BY dateline LIMIT $start,$perpage");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			realname_set($value['authorid'], $value['author']);//ʵ��
			$commentlist[] = $value;
		}
	}

	//��ҳ
	$multi = multi($count, $perpage, $page, "space.php?do=$do&uid=$video[uid]&videoid=$videoid", '', 'content');

	//����ͳ��
	if( ($video['uid']!=$_SGLOBAL['supe_uid']) && ($video['videoid']!=$_SCOOKIE['view_videoid']) ) {
		ssetcookie('view_videoid', $video['videoid']);
		
		$uip=getonlineip(0);
		$qsql="SELECT sa.* FROM ".tname("session_all")." sa WHERE sa.ip='$uip'";
		$query = $_SGLOBAL['db']->query($qsql);
		$session_sa = $_SGLOBAL['db']->fetch_array($query);
		if( !empty($session_sa)) {
			if(strstr($session_sa[videoids], $video['videoid'])) {
			
			}
			else{
				$session_sa['videoids'] .= ",".$video['videoid'];
				$_SGLOBAL['db']->query("UPDATE ".tname('session_all')." SET videoids='$session_sa[videoids]' WHERE ip='$uip'");
				$_SGLOBAL['db']->query("UPDATE ".tname('video')." SET viewnum=viewnum+1 WHERE videoid='$video[videoid]'");
			
				$currentweek=getCurrentWeek();
				$weeklyqsql="SELECT * FROM ".tname('video_static_weekly')." WHERE videoid='$video[videoid]' AND week='$currentweek'";
				$query = $_SGLOBAL['db']->query($weeklyqsql);
				$staticweekly = $_SGLOBAL['db']->fetch_array($query);
				if(empty($staticweekly)){
					$staticweekly=array();
					$staticweekly['videoid']=$video[videoid];
					$staticweekly['week']=$currentweek;
					$staticweekly['viewnum']=1;
					inserttable("video_static_weekly", $staticweekly);
				}
				else{
					$_SGLOBAL['db']->query("UPDATE ".tname('video_static_weekly')." SET viewnum=viewnum+1 WHERE videostaticweeklyid='$staticweekly[videostaticweeklyid]'");
				}
			}
		}
	}
		
	//ʵ��
	realname_get();

	$_TPL['css'] = 'video';
	$searchengine_description="��Ƶ��".$video['subject'].",".$video['productclassname'].",�ϴ���:".$video['username'].",CAST:".$video['group'].",STAFF:".$video['group'];
	
	$nav_list = array();
	$nav_item = array();
	$nav_item['url'] = "space.php?do=video"; $nav_item['dispname'] = "��Ƶӳ��";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "space.php?do=video&view=all"; $nav_item['dispname'] = "��Ƶ��";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "space.php?do=video&videoid=$video[videoid]"; $nav_item['dispname'] = "$video[subject]";
	$nav_list[] = $nav_item;
	
	include_once template("space_video_view");
} 
else {
	//list
	
	//��������
	include_once(S_ROOT.'./source/function_admincp.php');
		
	$mpurl="space.php?do=video&uid=$uid";
	$list = array();
	$multi = '';
	
	$intkeys = array('productclassid');
	$strkeys = array();
	$randkeys = array();
	$likekeys = array('subject','club','effector','cast', 'label');
	$results = getwheres($intkeys, $strkeys, $randkeys, $likekeys, 'v.');
	$wherearr = $results['wherearr'];
	$wheresql = empty($wherearr)?'1':implode(' AND ', $wherearr);
	
	if(!empty($_GET['label'])){
		$wheresql.=" AND (v.label like '%/$_GET[label]/%' OR v.label like '$_GET[label]/%' OR v.label like '%/$_GET[label]')";
	}
	
	if(!empty($_GET['directorproducer'])){
		$wheresql.=" AND (v.director like '%/$_GET[directorproducer]/%' OR v.producer like '%/$_GET[directorproducer]/%')";
	}
	
	$page = empty($_GET['page'])?1:intval($_GET['page']);
	if($page<1) $page = 1;
	$start = ($page-1)*$perpage;
	//��鿪ʼ��
	ckstart($start, $perpage);
	
	$mpurl .= '&'.implode('&', $results['urls']);
	$mpurl .= '&perpage='.$perpage;
	$mpurl .= '&view='.$view;
	
	if($view == 'me') {
		$userid='';
		if(empty($uid)){
			$userid=$_SGLOBAL[supe_uid];
		}else{
			$userid=$uid;
		}
		
		//�ҷ�������Ƶ
		$csql = "SELECT COUNT(*) FROM ".tname('video')." v WHERE v.uid='$userid' and $wheresql";
		$qsql = "SELECT v.* FROM ".tname('video')." v WHERE v.uid='$userid' and $wheresql order by v.dateline desc LIMIT $start,$perpage";
	} else if($view == 'all') {
		$csql = "SELECT COUNT(*) FROM ".tname('video')." v WHERE 1=1 and $wheresql";
		$qsql = "SELECT v.* FROM ".tname('video')." v WHERE 1=1 and $wheresql order by v.dateline desc LIMIT $start,$perpage";
	} else if($view == 'share') {
		//�ҵ��ղ�
		$csql = "SELECT COUNT(*) FROM ".tname('video')." v, ".tname('videouser')." vu WHERE vu.videoid=v.videoid and vu.uid = '$_SGLOBAL[supe_uid]' and $wheresql";
		$qsql = "SELECT v.* FROM ".tname('video')." v, ".tname('videouser')." vu WHERE vu.videoid=v.videoid and vu.uid = '$_SGLOBAL[supe_uid]' and $wheresql order by v.dateline desc LIMIT $start,$perpage";
	}
	
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($csql), 0);
	if($count) {
		$list=queryvideo($qsql);
		
		//��ʾ��ҳ
		$multi = multi($count, $perpage, $page, $mpurl);
	}
	
	$actives = array($view => ' class="active"');
	
	realname_get();
	
	//��Ƶ��ǩ
	$videolabel_hot_sql="SELECT vl.label AS label, count(vl.id) AS num FROM ".tname('videolabel')." vl WHERE 1=1 GROUP BY vl.label ORDER BY num desc LIMIT 0,20";
	$videolabel_hot_list = queryvideolabel($videolabel_hot_sql);
	
	//poll list
	$popupvideolistsql = "SELECT v.* FROM ".tname('video')." v WHERE 1=1 order by (v.poll_1*1+v.poll_2*2+v.poll_3*3+v.poll_4*4+v.poll_5*5) desc LIMIT 0,10";
	$popupvideolist=queryvideo($popupvideolistsql);
	
	$_TPL['css'] = 'video';
	$searchengine_description='��Ƶ�б�';
	foreach($list as $value) {
		$searchengine_description.=$value['subject'].",";
	}
	
	$nav_list = array();
	$nav_item = array();
	$nav_item['url'] = "space.php?do=video"; $nav_item['dispname'] = "��Ƶӳ��";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	if($view == 'me') {
		$nav_item['url'] = "space.php?do=video&view=me"; $nav_item['dispname'] = "�ҵ���Ƶ�б�";
	}
	elseif($view == 'all') {
		$nav_item['url'] = "space.php?do=video&view=all"; $nav_item['dispname'] = "��Ƶ��";
	}
	elseif($view == 'share') {
		$nav_item['url'] = "space.php?do=video&view=share"; $nav_item['dispname'] = "�ҵ��ղ��б�";
	}
	$nav_list[] = $nav_item;
	
	include_once template('space_video_list');
}

?>