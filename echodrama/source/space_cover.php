<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_repaste.php 13208 2009-08-20 06:31:35Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}


$coverid = empty($_GET['coverid'])?0:intval($_GET['coverid']);
$view = isset($_GET['view']) ? $_GET['view'] : "all";

$page = empty($_GET['page'])?1:intval($_GET['page']);
if($page<1) $page = 1;

$perpage = empty($_GET['perpage'])?10:intval($_GET['perpage']);
$start = ($page-1)*$perpage;

//��̬����
@include_once(S_ROOT.'./data/data_click.php');
include_once(S_ROOT.'./source/function_cover.php');
include_once(S_ROOT.'./data/data_coverproductclass.php');

$clicks = empty($_SGLOBAL['click']['coverid'])?array():$_SGLOBAL['click']['coverid'];

if($coverid) {
	
	//��ȡ����
	$cover = loadcoverbyid($coverid);
	//����������
	if(empty($cover)) {
		showmessage('cover_does_not_exist');
	}
	
	$cover=coverformmapper($cover);
	//������Ƶ��ǩ
	if(!empty($cover['product'])){
		$swfindex=stripos($cover['product'],".swf");
		$mp3index=stripos($cover['product'],".mp3");
		$wmaindex=stripos($cover['product'],".wma");
		if($swfindex>0){
			$cover['productpath'] = cover_bbcode("[flash]".$cover['product']."[/flash]");
		}
		elseif($mp3index>0){
			$cover['productpath'] = cover_bbcode("[flash=media]".$cover['product']."[/flash]");
		}
		elseif($wmaindex>0){
			$cover['productpath'] = cover_bbcode("[flash=real]".$cover['product']."[/flash]");
		}
		else{
			$cover['productpath'] = $cover['product'];
		}
	}
	$cover['message'] = cover_bbcode($cover['message']);
		
	
	
	//�Ƿ��ղ�
	$shareSql= "SELECT COUNT(*) FROM ".tname('coveruser')." cu WHERE cu.coverid=$coverid and cu.uid=$_SGLOBAL[supe_uid]";
	$inShare = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($shareSql), 0);

	//�Ƿ�������
	$userip=getonlineip(0);
	$coverpollsql= "SELECT * FROM ".tname('coverpoll')." cp WHERE cp.coverid=$coverid and ( cp.uid='$_SGLOBAL[supe_uid]' OR cp.userip='$userip' )";
	$query = $_SGLOBAL['db']->query($coverpollsql);
	$coverpoll = $_SGLOBAL['db']->fetch_array($query);

	//���ߵ��������·���
	$otherlist = array();
	$qsql="SELECT * FROM ".tname('cover')." WHERE uid='$cover[uid]' AND coverid!='$coverid' ORDER BY dateline DESC LIMIT 0,6";
	$userothercoverlist=querycover($qsql);
	
	//ͬ���͵����ŷ���
	$newlist = array();
	$qsql="SELECT * FROM ".tname('cover')." c WHERE c.productclassid='$cover[productclassid]' order by (c.poll_1*1+c.poll_2*2+c.poll_3*3+c.poll_4*4+c.poll_5*5) desc LIMIT 0,6";
	$sameproductclassidcoverlist=querycover($qsql);

	//����
	$perpage = 30;
	$perpage = mob_perpage($perpage);
	
	$start = ($page-1)*$perpage;

	//��鿪ʼ��
	ckstart($start, $perpage);

	$count = $cover['replynum'];

	$commentlist = array();
	if($count) {
		$cid = empty($_GET['cid'])?0:intval($_GET['cid']);
		$csql = $cid?"cid='$cid' AND":'';

		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('comment')." WHERE $csql id='$coverid' AND idtype='coverid' ORDER BY dateline LIMIT $start,$perpage");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			realname_set($value['authorid'], $value['author']);//ʵ��
			$commentlist[] = $value;
		}
	}

	//��ҳ
	$multi = multi($count, $perpage, $page, "space.php?do=$do&uid=$cover[uid]&coverid=$coverid", '', 'content');

	//����ͳ��
	if( ($cover['uid']!=$_SGLOBAL['supe_uid']) && ($cover['coverid']!=$_SCOOKIE['view_coverid']) ) {
		ssetcookie('view_coverid', $cover['coverid']);
		
		$_SGLOBAL['db']->query("UPDATE ".tname('cover')." SET viewnum=viewnum+1 WHERE coverid='$cover[coverid]'");
		
		$currentweek=getCurrentWeek();
		$weeklyqsql="SELECT * FROM ".tname('cover_static_weekly')." WHERE coverid='$cover[coverid]' AND week='$currentweek'";
		$query = $_SGLOBAL['db']->query($weeklyqsql);
		$staticweekly = $_SGLOBAL['db']->fetch_array($query);
		if(empty($staticweekly)){
			$staticweekly=array();
			$staticweekly['coverid']=$cover[coverid];
			$staticweekly['week']=$currentweek;
			$staticweekly['viewnum']=1;
			inserttable("cover_static_weekly", $staticweekly);
		}
		else{
			$_SGLOBAL['db']->query("UPDATE ".tname('cover_static_weekly')." SET viewnum=viewnum+1 WHERE coverstaticweeklyid='$staticweekly[coverstaticweeklyid]'");
		}
	}
		

	//ʵ��
	realname_get();

	$_TPL['css'] = 'cover';
	$searchengine_description="������".$cover['subject'].",".$cover['productclassname'].",�ϴ���:".$cover['username'];
	
	$nav_list = array();
	$nav_item = array();
	$nav_item['url'] = "space.php?do=cover"; $nav_item['dispname'] = "�ֳ淭��";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "space.php?do=cover&view=all"; $nav_item['dispname'] = "������";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	$nav_item['url'] = "space.php?do=cover&coverid=$cover[coverid]"; $nav_item['dispname'] = "$cover[subject]";
	if($cover[originwordflag]==1){
		$nav_item['dispname'] .= "&nbsp;&nbsp;<img src='image/originwordflag.gif' title='��ԭ��'/>";
	}
	if($cover[originmelodyflag]==1){
		$nav_item['dispname'] .= "&nbsp;&nbsp;<img src='image/originmelodyflag.gif' title='��ԭ��'/>";
	}
	$nav_list[] = $nav_item;
	
	include_once template("space_cover_view");
} 
else {
	//list
	
	//��������
	include_once(S_ROOT.'./source/function_admincp.php');
		
	$mpurl="space.php?do=cover&uid=$uid";
	$list = array();
	$multi = '';
	
	$intkeys = array('productclassid');
	$strkeys = array();
	$randkeys = array();
	$likekeys = array('subject','club','wordwriter','singer');
	$results = getwheres($intkeys, $strkeys, $randkeys, $likekeys, 'c.');
	$wherearr = $results['wherearr'];
	$wheresql = empty($wherearr)?'1':implode(' AND ', $wherearr);
	
	if(!empty($_GET['label'])){
		$wheresql.=" AND (c.label like '%/$_GET[label]/%' OR c.label like '$_GET[label]/%' OR c.label like '%/$_GET[label]')";
	}
	if($_GET['originwordflag']==-1){
		$wheresql.=" AND c.originwordflag='0'";
	}
	else if($_GET['originwordflag']==1){
		$wheresql.=" AND c.originwordflag='1'";
	}
	
	if($_GET['originmelodyflag']==-1 ){
		$wheresql.=" AND c.originmelodyflag='0'";
	}
	else if($_GET['originmelodyflag']==1){
		$wheresql.=" AND c.originmelodyflag='1'";
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
		//�ҷ����ķ���
		$userid='';
		if(empty($uid)){
			$userid=$_SGLOBAL[supe_uid];
		}else{
			$userid=$uid;
		}
		
		$csql = "SELECT COUNT(*) FROM ".tname('cover')." c WHERE c.uid='$userid' and $wheresql";
		$qsql = "SELECT c.* FROM ".tname('cover')." c WHERE c.uid='$userid' and $wheresql order by c.dateline desc LIMIT $start,$perpage";
	} else if($view == 'all') {
		$csql = "SELECT COUNT(*) FROM ".tname('cover')." c WHERE 1=1 and $wheresql";
		$qsql = "SELECT c.* FROM ".tname('cover')." c WHERE 1=1 and $wheresql order by c.dateline desc LIMIT $start,$perpage";
	} else if($view == 'share') {
		//�ҵ��ղ�
		$csql = "SELECT COUNT(*) FROM ".tname('cover')." c, ".tname('coveruser')." cu WHERE cu.coverid=c.coverid and cu.uid = '$_SGLOBAL[supe_uid]' and $wheresql";
		$qsql = "SELECT c.* FROM ".tname('cover')." c, ".tname('coveruser')." cu WHERE cu.coverid=c.coverid and cu.uid = '$_SGLOBAL[supe_uid]' and $wheresql order by c.dateline desc LIMIT $start,$perpage";
	}
	//showmessage($qsql);
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($csql), 0);
	if($count) {
		$list=querycover($qsql);
		
		//��ʾ��ҳ
		$multi = multi($count, $perpage, $page, $mpurl);
	}
	$actives = array($view => ' class="active"');
	
	realname_get();
	
	//������ǩ
	$hotcoverlabellist=listhotcoverlabel();
	
	//poll list
	$popupcoverlistsql = "SELECT c.* FROM ".tname('cover')." c WHERE 1=1 order by (c.poll_1*1+c.poll_2*2+c.poll_3*3+c.poll_4*4+c.poll_5*5) desc LIMIT 0,10";
	$popupcoverlist=querycover($popupcoverlistsql);
	
	$_TPL['css'] = 'cover';
	$searchengine_description='�����б�';
	foreach($list as $value) {
		$searchengine_description.=$value['subject'].",";
	}
	
	$nav_list = array();
	$nav_item = array();
	$nav_item['url'] = "space.php?do=cover"; $nav_item['dispname'] = "�ֳ淭��";
	$nav_list[] = $nav_item;
	
	$nav_item = array();
	if($view == 'me') {
		$nav_item['url'] = "space.php?do=cover&view=me"; $nav_item['dispname'] = "�ҵķ����б�";
	}
	elseif($view == 'all') {
		$nav_item['url'] = "space.php?do=cover&view=all"; $nav_item['dispname'] = "������";
	}
	elseif($view == 'share') {
		$nav_item['url'] = "space.php?do=cover&view=share"; $nav_item['dispname'] = "�ҵ��ղ��б�";
	}
	$nav_list[] = $nav_item;
	
	include_once template('space_cover_list');
}

?>