<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: network.php 13003 2009-08-05 06:46:06Z liguode $
*/

include_once('./common.php');

//�ռ䱻����
if($_SGLOBAL['supe_uid']) {
	$space = getspace($_SGLOBAL['supe_uid']);
	
	if($space['flag'] == -1) {
		showmessage('space_has_been_locked');
	}
	
	//��ֹ����
	if(checkperm('banvisit')) {
		ckspacelog();
		showmessage('you_do_not_have_permission_to_visit');
	}
}

//��վͳ��
//���߻�Ա
$member_online_count = getcount('session', array());
	
//�����û�
$guest_ol_count = getcount('session_all', array());
	
	
include_once(S_ROOT.'./source/function_systemserializer.php');
$system_serializer_modulename = "PortalIndex";
$system_serializer_cutofftime = $_SGLOBAL['timestamp'];
$system_serializer_array = loadSystemSerializerFromFile($system_serializer_modulename, $system_serializer_cutofftime, 60*60);

//ʹ��ҳ�����ݻ���
if( !empty($system_serializer_array) ){
	
	//�㲥������
	$topic_single_num = $system_serializer_array['topic_single_num'];
	$topic_album_num = $system_serializer_array['topic_album_num'];
	
	//��Ƶ����
	$video_num = $system_serializer_array['video_num'];
	
	//INDEX_HEADER
	$index_header_flashvar = $system_serializer_array['index_header_flashvar'];
	
	//�㲥���Ȳ�����ʾ���28������������9����Ʒ��
	$topic_sitejoin_list = $system_serializer_array['topic_sitejoin_list'];
	$topic_sitejoin_first = $system_serializer_array['topic_sitejoin_first'];
	
	//��Ƶ�Ƽ�����ʾ���28������������1����Ʒ��
	$video_sitejoin_first = $system_serializer_array['video_sitejoin_first'];
	
	//�����Ƽ�����ʾ���28������������6����Ʒ��
	$cover_sitejoin_list = $system_serializer_array['cover_sitejoin_list'];
	
	//���Ż��⣺��ʾ���28������������1����Ʒ��
	$forum_sitejoin_first = $system_serializer_array['forum_sitejoin_first'];
	
	//���»��⣺��ʾ���¸��µ�10������
	$forum_lastest_list = $system_serializer_array['forum_lastest_list'];
	
	//�����Ƽ�����ʾ���¸��µ�3�������� 
	$forum_digest_list = $system_serializer_array['forum_digest_list'];
	
	//�³���Ⱥ�飺��ʾ��������ģ��ѳ���5����˿��ע��һ������/������Ⱥ�顣
	$mtag_latest_list = $system_serializer_array['mtag_latest_list'];
	
	//������Ⱥ�飺��ʾ��Ա������һ������/������Ⱥ�顣
	$mtag_hot_list = $system_serializer_array['mtag_hot_list'];
	
	//���Ź����ң���ʾ��˿������6������/������Ⱥ�顣
	$mtag_fans_list = $system_serializer_array['mtag_fans_list'];
		
	//�����Ƽ���Ʒ/���� - �ɹ㲥������/������ Ⱥ�� �û��ַ�ʽ�Ƽ��Լ�����Ʒ��Ŀǰ��˼�У�ǣ�浽����Ⱥ����ʽ�أ�Ⱥ��Ļ�Ծ����ֵ�ȣ�
	$advertisement = $system_serializer_array['advertisement'];
	
	//Ⱥ�黰�⣺��ʾȺ�黰���У�����ظ�����13ƪ���ӡ�
	$thread_mtag_list = $system_serializer_array['thread_mtag_list'];
	
	//��������
	$externallink_list = $system_serializer_array['externallink_list'];
}
else{
	$system_serializer_array = array();
	
	include_once(S_ROOT.'./source/function_topic.php');
	include_once(S_ROOT.'./source/function_video.php');
	include_once(S_ROOT.'./source/function_cover.php');
	include_once(S_ROOT.'./source/function_share.php');
	include_once(S_ROOT.'./source/function_event.php');
	include_once(S_ROOT.'./source/function_mtag.php');
	include_once(S_ROOT.'./source/function_advertisement.php');
	include_once(S_ROOT.'./source/function_thread.php');
	include_once(S_ROOT.'./source/function_externallink.php');
	
	//�㲥������
	$topic_single_num_sql = "SELECT COUNT(*) AS num FROM ".tname('topic')." t WHERE t.type='single' AND t.auditstate=2 ";
	$query = $_SGLOBAL['db']->query($topic_single_num_sql);
	$topic_single_num = $_SGLOBAL['db']->fetch_array($query);
	$system_serializer_array['topic_single_num'] = $topic_single_num;
	
	$topic_album_num_sql = "SELECT COUNT(*) AS num FROM ".tname('topic')." t WHERE t.type='album' ";
	$query = $_SGLOBAL['db']->query($topic_album_num_sql);
	$topic_album_num = $_SGLOBAL['db']->fetch_array($query);
	$system_serializer_array['topic_album_num'] = $topic_album_num;
	
	//��Ƶ����
	$video_num_sql = "SELECT COUNT(*) AS num FROM ".tname('video')." v WHERE 1=1 ";
	$query = $_SGLOBAL['db']->query($video_num_sql);
	$video_num = $_SGLOBAL['db']->fetch_array($query);
	$system_serializer_array['video_num'] = $video_num;
	
	//INDEX_HEADER
	$index_header_pic ="image/site/PortalIndexHeader_20120720.jpg"."|";
	$index_header_url ="space.php?do=event%26id=2774"."|";
	$index_header_text ="Ӧ���� ECHO DRAMA��������ļ�ڶ���"."|";
	$index_header_pic.="image/site/PortalIndexHeader_20120630.jpg";
	$index_header_url.="space.php?do=event&id=2737";
	$index_header_text.="������2012��ļ�������������ǲ��ɻ�ȱ��ɫ�ʣ�";	
	//$topic_recommand_flashvar = "config=5|0xffffff|0xFFA84E|60|0xffffff|0xFF7905|0x000000";
	$index_header_flashvar = "pw=641&amp;ph=370&amp;sizes=14&amp;umcolor=16777215&amp;btnbg=13762561&amp;txtcolor=16777215&amp;txtoutcolor=0&amp;";
	$index_header_flashvar.= "&urls=" . $index_header_url;
	$index_header_flashvar.= "&titles=" . $index_header_text;
	$index_header_flashvar.= "&imgs=" . $index_header_pic;
	
	$system_serializer_array['index_header_flashvar'] = $index_header_flashvar;
	
	$cutofftime = $_SGLOBAL['timestamp'] - 2419200; //���1����
	//�㲥���Ȳ�����ʾ���28������������9����Ʒ��
	$topicreplysql= "SELECT t.* FROM ".tname('topic')." t WHERE t.auditstate=2 AND t.protalforbidden=0 and t.dateline > $cutofftime order by t.replynum DESC, t.viewnum DESC LIMIT 0,9";
	$topic_sitejoin_list = querytopic($topicreplysql);
	$topic_sitejoin_first = $topic_sitejoin_list[0];
	$system_serializer_array['topic_sitejoin_list'] = $topic_sitejoin_list;
	$system_serializer_array['topic_sitejoin_first'] = $topic_sitejoin_first;
	
	//��Ƶ�Ƽ�����ʾ���28������������1����Ʒ��
	$video_sitejoin_sql = "SELECT v.* FROM ".tname('video')." v WHERE v.dateline > $cutofftime order by v.replynum DESC, v.viewnum DESC LIMIT 0,1";
	$video_sitejoin_list = queryvideo($video_sitejoin_sql);
	$video_sitejoin_first = $video_sitejoin_list[0];
	$system_serializer_array['video_sitejoin_first'] = $video_sitejoin_first;
	
	//�����Ƽ�����ʾ���28������������6����Ʒ��
	$cover_sitejoin_sql = "SELECT c.* FROM ".tname('cover')." c WHERE c.dateline > $cutofftime order by c.replynum DESC, c.viewnum DESC LIMIT 0,6";
	$cover_sitejoin_list = querycover($cover_sitejoin_sql);
	$system_serializer_array['cover_sitejoin_list'] = $cover_sitejoin_list;
	
	//��Ӿ��
	$forum_cutofftime = $_SGLOBAL['timestamp'] - 2419200;//���1����
	//���Ż��⣺��ʾ���28������������1����Ʒ��(��ʾ�����Ƽ�)
	//$forum_hotest_sql = "SELECT mt.* FROM ".tname('mtag_thread')." mt WHERE mt.tagid='".FORUM_TAGID."' AND mt.displayorder=0 AND mt.digest=0 AND mt.dateline>$forum_cutofftime ORDER BY mt.replynum DESC LIMIT 0,1";
	$forum_hotest_sql = "SELECT mt.* FROM ".tname('mtag_thread')." mt WHERE mt.tagid='".FORUM_TAGID."' AND mt.displayportal = 1 ORDER BY mt.dateline DESC LIMIT 0,1";
	$forum_sitejoin_list = querymtagthread($forum_hotest_sql);
	$forum_sitejoin_first = $forum_sitejoin_list[0];
	$forum_sitejoin_first_post = loadthreadmainpostbyid($forum_sitejoin_first['tid']);
	$forum_sitejoin_first['message'] = strip_tags($forum_sitejoin_first_post['message']);
	$system_serializer_array['forum_sitejoin_first'] = $forum_sitejoin_first;
	
	//���»��⣺��ʾ���¸��µ�10������
	$forum_lastest_sql = "SELECT mt.*, mtc.classname AS threadclassname FROM ".tname('mtag_thread')." mt LEFT OUTER JOIN ".tname('mtag_threadclass')." mtc ON mt.tagid=mtc.tagid AND mt.threadclassid=mtc.classid WHERE mt.tagid='".FORUM_TAGID."' ORDER BY mt.lastpost DESC LIMIT 0,10";
	$forum_lastest_list = querymtagthread($forum_lastest_sql);
	$system_serializer_array['forum_lastest_list'] = $forum_lastest_list;
	
	//�����Ƽ�����ʾ���¸��µ�3�������� 
	$forum_digest_sql = "SELECT mt.*, mtc.classname AS threadclassname FROM ".tname('mtag_thread')." mt LEFT OUTER JOIN ".tname('mtag_threadclass')." mtc ON mt.tagid=mtc.tagid AND mt.threadclassid=mtc.classid WHERE mt.tagid='".FORUM_TAGID."' AND mt.displayorder=0 AND mt.digest=1 ORDER BY mt.lastpost DESC LIMIT 0,3";
	$forum_digest_list = querymtagthread($forum_digest_sql);
	$system_serializer_array['forum_digest_list'] = $forum_digest_list;
	
	//�³���Ⱥ�飺��ʾ��������ģ��ѳ���5����˿��ע��һ������/������Ⱥ�顣
	$mtag_latest_sql="SELECT m.* FROM ".tname('mtag')." m WHERE m.tagstate>=2 AND (m.fieldid = 1 OR m.fieldid = 5) AND m.fansnum>5 ORDER BY m.dateline DESC LIMIT 0,1";
	$mtag_latest_list = querymtag($mtag_latest_sql);
	
	$system_serializer_array['mtag_latest_list'] = $mtag_latest_list;
	
	//������Ⱥ�飺��ʾ��Ա������һ������/������Ⱥ�顣
	$mtag_hot_sql="SELECT m.* FROM ".tname('mtag')." m WHERE m.tagstate>=2 AND (m.fieldid = 1 OR m.fieldid = 5) ORDER BY m.membernum DESC LIMIT 0,1";
	$mtag_hot_list = querymtag($mtag_hot_sql);
	
	$system_serializer_array['mtag_hot_list'] = $mtag_hot_list;
	
	//���Ź����ң���ʾ��˿������6������/������Ⱥ�顣
	$mtag_fans_sql="SELECT m.* FROM ".tname('mtag')." m WHERE m.tagstate>=2 AND (m.fieldid = 1 OR m.fieldid = 5) ORDER BY m.fansnum DESC LIMIT 0,6";
	$mtag_fans_list = querymtag($mtag_fans_sql);
	$system_serializer_array['mtag_fans_list'] = $mtag_fans_list;
	
	//�����Ƽ���Ʒ/���� - �ɹ㲥������/������ Ⱥ�� �û��ַ�ʽ�Ƽ��Լ�����Ʒ��Ŀǰ��˼�У�ǣ�浽����Ⱥ����ʽ�أ�Ⱥ��Ļ�Ծ����ֵ�ȣ�
	$advertisement_location_portal_index = 2;
	$advertisement = displayadvertisementbylocation($advertisement_location_portal_index);
	
	$system_serializer_array['advertisement'] = $advertisement;
	
	
	//Ⱥ�黰�⣺��ʾȺ�黰���У�����ظ�����13ƪ���ӡ�
	$thread_mtag_sql = "SELECT mt.*, t.tagname FROM ".tname('mtag_thread')." mt, ".tname('mtag')." t WHERE mt.tagid=t.tagid AND mt.tagid!=".FORUM_TAGID." AND mt.tagid!=".ECHODRAMA_TAGID." ORDER BY mt.lastpost DESC LIMIT 0,13";
	$thread_mtag_list = querymtagthread($thread_mtag_sql);
	
	$system_serializer_array['thread_mtag_list'] = $thread_mtag_list;
	
	//��������
	$externallink_sql="SELECT el.* FROM ".tname('externallink')." el WHERE el.close=0 ORDER BY el.displayorder";
	$externallink_list = queryexternalink($externallink_sql);
	$system_serializer_array['externallink_list'] = $externallink_list;
	
	//serialize
	saveSystemSerializerIntoFile( $system_serializer_modulename, $system_serializer_cutofftime, $system_serializer_array);
}


//ҳ��ģ��
$site_module_actives = array('portal_index' => ' class="portalmenuli-sel"');

$_TPL['css'] = 'portal';
include_once template("portal_index");
?>