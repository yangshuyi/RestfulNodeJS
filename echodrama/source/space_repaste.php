<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_repaste.php 13208 2009-08-20 06:31:35Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

$minhot = $_SCONFIG['feedhotmin']<1?3:$_SCONFIG['feedhotmin'];

$page = empty($_GET['page'])?1:intval($_GET['page']);
if($page<1) $page=1;
$id = empty($_GET['id'])?0:intval($_GET['id']);
$classid = empty($_GET['classid'])?0:intval($_GET['classid']);

//表态分类
@include_once(S_ROOT.'./data/data_click.php');
$clicks = empty($_SGLOBAL['click']['repasteid'])?array():$_SGLOBAL['click']['repasteid'];

if($id) {
	//读取转帖
	$query = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('repaste')." b LEFT JOIN ".tname('repastefield')." bf ON bf.repasteid=b.repasteid WHERE b.repasteid='$id' AND b.uid='$space[uid]'");
	$repaste = $_SGLOBAL['db']->fetch_array($query);
	//转帖不存在
	if(empty($repaste)) {
		showmessage('view_to_info_did_not_exist');
	}

	//整理
	$repaste['tag'] = empty($repaste['tag'])?array():unserialize($repaste['tag']);

	//处理视频标签
	include_once(S_ROOT.'./source/function_repaste.php');
	$repaste['message'] = repaste_bbcode($repaste['message']);

	$otherlist = $newlist = array();

	//有效期
	if($_SCONFIG['uc_tagrelatedtime'] && ($_SGLOBAL['timestamp'] - $repaste['relatedtime'] > $_SCONFIG['uc_tagrelatedtime'])) {
		$repaste['related'] = array();
	}
	if($repaste['tag'] && empty($repaste['related'])) {
		@include_once(S_ROOT.'./data/data_tagtpl.php');

		$b_tagids = $b_tags = $repaste['related'] = array();
		$tag_count = -1;
		foreach ($repaste['tag'] as $key => $value) {
			$b_tags[] = $value;
			$b_tagids[] = $key;
			$tag_count++;
		}
		if(!empty($_SCONFIG['uc_tagrelated']) && $_SCONFIG['uc_status']) {
			if(!empty($_SGLOBAL['tagtpl']['limit'])) {
				include_once(S_ROOT.'./uc_client/client.php');
				$tag_index = mt_rand(0, $tag_count);
				$repaste['related'] = uc_tag_get($b_tags[$tag_index], $_SGLOBAL['tagtpl']['limit']);
			}
		} else {
			//自身TAG
			$tag_repasteids = array();
			$query = $_SGLOBAL['db']->query("SELECT DISTINCT repasteid FROM ".tname('tagrepaste')." WHERE tagid IN (".simplode($b_tagids).") AND repasteid<>'$repaste[repasteid]' ORDER BY repasteid DESC LIMIT 0,10");
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				$tag_repasteids[] = $value['repasteid'];
			}
			if($tag_repasteids) {
				$query = $_SGLOBAL['db']->query("SELECT uid,username,subject,repasteid FROM ".tname('repaste')." WHERE repasteid IN (".simplode($tag_repasteids).")");
				while ($value = $_SGLOBAL['db']->fetch_array($query)) {
					realname_set($value['uid'], $value['username']);//实名
					$value['url'] = "space.php?do=repaste&uid=$value[uid]&id=$value[repasteid]";
					$repaste['related'][UC_APPID]['data'][] = $value;
				}
				$repaste['related'][UC_APPID]['type'] = 'UCHOME';
			}
		}
		if(!empty($repaste['related']) && is_array($repaste['related'])) {
			foreach ($repaste['related'] as $appid => $values) {
				if(!empty($values['data']) && $_SGLOBAL['tagtpl']['data'][$appid]['template']) {
					foreach ($values['data'] as $itemkey => $itemvalue) {
						if(!empty($itemvalue) && is_array($itemvalue)) {
							$searchs = $replaces = array();
							foreach (array_keys($itemvalue) as $key) {
								$searchs[] = '{'.$key.'}';
								$replaces[] = $itemvalue[$key];
							}
							$repaste['related'][$appid]['data'][$itemkey]['html'] = stripslashes(str_replace($searchs, $replaces, $_SGLOBAL['tagtpl']['data'][$appid]['template']));
						} else {
							unset($repaste['related'][$appid]['data'][$itemkey]);
						}
					}
				} else {
					$repaste['related'][$appid]['data'] = '';
				}
				if(empty($repaste['related'][$appid]['data'])) {
					unset($repaste['related'][$appid]);
				}
			}
		}
		updatetable('repastefield', array('related'=>addslashes(serialize(sstripslashes($repaste['related']))), 'relatedtime'=>$_SGLOBAL['timestamp']), array('repasteid'=>$repaste['repasteid']));//更新
	} else {
		$repaste['related'] = empty($repaste['related'])?array():unserialize($repaste['related']);
	}

	//作者的其他最新转帖
	$otherlist = array();
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('repaste')." WHERE uid='$space[uid]' ORDER BY dateline DESC LIMIT 0,6");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($value['repasteid'] != $repaste['repasteid'] && empty($value['friend'])) {
			$otherlist[] = $value;
		}
	}

	//最新的转帖
	$newlist = array();
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('repaste')." WHERE hot>=3 ORDER BY dateline DESC LIMIT 0,6");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($value['repasteid'] != $repaste['repasteid'] && empty($value['friend'])) {
			realname_set($value['uid'], $value['username']);
			$newlist[] = $value;
		}
	}

	//评论
	$perpage = 30;
	$perpage = mob_perpage($perpage);
	
	$start = ($page-1)*$perpage;

	//检查开始数
	ckstart($start, $perpage);

	$count = $repaste['replynum'];

	$list = array();
	if($count) {
		$cid = empty($_GET['cid'])?0:intval($_GET['cid']);
		$csql = $cid?"cid='$cid' AND":'';

		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('comment')." WHERE $csql id='$id' AND idtype='repasteid' ORDER BY dateline LIMIT $start,$perpage");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			realname_set($value['authorid'], $value['author']);//实名
			$list[] = $value;
		}
	}

	//分页
	$multi = multi($count, $perpage, $page, "space.php?do=$do&uid=$repaste[uid]&id=$id", '', 'content');

	//访问统计
	if(!$space['self'] && $_SCOOKIE['view_repasteid'] != $repaste['repasteid']) {
		$_SGLOBAL['db']->query("UPDATE ".tname('repaste')." SET viewnum=viewnum+1 WHERE repasteid='$repaste[repasteid]'");
		inserttable('log', array('id'=>$space['uid'], 'idtype'=>'uid'));//延迟更新
		ssetcookie('view_repasteid', $repaste['repasteid']);
	}

	//表态
	$hash = md5($repaste['uid']."\t".$repaste['dateline']);
	$id = $repaste['repasteid'];
	$idtype = 'repasteid';

	foreach ($clicks as $key => $value) {
		$value['clicknum'] = $repaste["click_$key"];
		$value['classid'] = mt_rand(1, 4);
		if($value['clicknum'] > $maxclicknum) $maxclicknum = $value['clicknum'];
		$clicks[$key] = $value;
	}

	//点评
	$clickuserlist = array();
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('clickuser')."
		WHERE id='$id' AND idtype='$idtype'
		ORDER BY dateline DESC
		LIMIT 0,18");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		realname_set($value['uid'], $value['username']);//实名
		$value['clickname'] = $clicks[$value['clickid']]['name'];
		$clickuserlist[] = $value;
	}

	//热点
	$topic = topic_get($repaste['topicid']);

	//实名
	realname_get();

	$_TPL['css'] = 'repaste';
	include_once template("space_repaste_view");

} else {
	//分页
	$perpage = 10;
	$perpage = mob_perpage($perpage);
	
	$start = ($page-1)*$perpage;

	//检查开始数
	ckstart($start, $perpage);

	//摘要截取
	$summarylen = 300;

	$classarr = array();
	$list = array();
	$userlist = array();
	$count = 0;

	$ordersql = 'b.dateline';

	if(empty($_GET['view']) && ($space['friendnum']<$_SCONFIG['showallfriendnum'])) {
		$_GET['view'] = 'all';//默认显示
	}

	//处理查询
	$f_index = '';
	if($_GET['view'] == 'click') {
		//踩过的转帖
		$theurl = "space.php?do=$do&uid=$space[uid]&view=click";
		$actives = array('click'=>' class="active"');

		$clickid = intval($_GET['clickid']);
		if($clickid) {
			$theurl .= "&clickid=$clickid";
			$wheresql = " AND c.clickid='$clickid'";
			$click_actives = array($clickid => ' class="current"');
		} else {
			$wheresql = '';
			$click_actives = array('all' => ' class="current"');
		}

		$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('clickuser')." c WHERE c.uid='$space[uid]' AND c.idtype='repasteid' $wheresql"),0);
		if($count) {
			$query = $_SGLOBAL['db']->query("SELECT b.*, bf.url, bf.target_ids, bf.magiccolor FROM ".tname('clickuser')." c
				LEFT JOIN ".tname('repaste')." b ON b.repasteid=c.id
				LEFT JOIN ".tname('repastefield')." bf ON bf.repasteid=c.id
				WHERE c.uid='$space[uid]' AND c.idtype='repasteid' $wheresql
				ORDER BY c.dateline DESC LIMIT $start,$perpage");
		}
	} else {
		
		if($_GET['view'] == 'all') {
			//大家的转帖
			$wheresql = '1';

			$actives = array('all'=>' class="active"');

			//排序
			$orderarr = array('dateline','replynum','viewnum','hot');
			foreach ($clicks as $value) {
				$orderarr[] = "click_$value[clickid]";
			}
			if(!in_array($_GET['orderby'], $orderarr)) $_GET['orderby'] = '';

			//时间
			$_GET['day'] = intval($_GET['day']);
			$_GET['hotday'] = 7;

			if($_GET['orderby']) {
				$ordersql = 'b.'.$_GET['orderby'];

				$theurl = "space.php?do=repaste&uid=$space[uid]&view=all&orderby=$_GET[orderby]";
				$all_actives = array($_GET['orderby']=>' class="current"');

				if($_GET['day']) {
					$_GET['hotday'] = $_GET['day'];
					$daytime = $_SGLOBAL['timestamp'] - $_GET['day']*3600*24;
					$wheresql .= " AND b.dateline>='$daytime'";

					$theurl .= "&day=$_GET[day]";
					$day_actives = array($_GET['day']=>' class="active"');
				} else {
					$day_actives = array(0=>' class="active"');
				}
			} else {

				$theurl = "space.php?do=$do&uid=$space[uid]&view=all";

				$wheresql .= " AND b.hot>='$minhot'";
				$all_actives = array('all'=>' class="current"');
				$day_actives = array();
			}


		} else {
			
			if(empty($space['feedfriend']) || $classid) $_GET['view'] = 'me';
			
			if($_GET['view'] == 'me') {
				//查看个人的
				$wheresql = "b.uid='$space[uid]'";
				$theurl = "space.php?do=$do&uid=$space[uid]&view=me";
				$actives = array('me'=>' class="active"');
				//转帖分类
				$query = $_SGLOBAL['db']->query("SELECT classid, classname FROM ".tname('class')." WHERE uid='$space[uid]'");
				while ($value = $_SGLOBAL['db']->fetch_array($query)) {
					$classarr[$value['classid']] = $value['classname'];
				}
			} else {
				$wheresql = "b.uid IN ($space[feedfriend])";
				$theurl = "space.php?do=$do&uid=$space[uid]&view=we";
				$f_index = 'USE INDEX(dateline)';
	
				$fuid_actives = array();
	
				//查看指定好友的
				$fusername = trim($_GET['fusername']);
				$fuid = intval($_GET['fuid']);
				if($fusername) {
					$fuid = getuid($fusername);
				}
				if($fuid && in_array($fuid, $space['friends'])) {
					$wheresql = "b.uid = '$fuid'";
					$theurl = "space.php?do=$do&uid=$space[uid]&view=we&fuid=$fuid";
					$f_index = '';
					$fuid_actives = array($fuid=>' selected');
				}
	
				$actives = array('we'=>' class="active"');
	
				//好友列表
				$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('friend')." WHERE uid='$space[uid]' AND status='1' ORDER BY num DESC, dateline DESC LIMIT 0,500");
				while ($value = $_SGLOBAL['db']->fetch_array($query)) {
					realname_set($value['fuid'], $value['fusername']);
					$userlist[] = $value;
				}
			}
		}

		//分类
		if($classid) {
			$wheresql .= " AND b.classid='$classid'";
			$theurl .= "&classid=$classid";
		}

		//搜索
		if($searchkey = stripsearchkey($_GET['searchkey'])) {
			$wheresql .= " AND b.subject LIKE '%$searchkey%'";
			$theurl .= "&searchkey=$_GET[searchkey]";
			cksearch($theurl);
		}

		$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('repaste')." b WHERE $wheresql"),0);
		//更新统计
		if($wheresql == "b.uid='$space[uid]'" && $space['repastenum'] != $count) {
			updatetable('space', array('repastenum' => $count), array('uid'=>$space['uid']));
		}
		if($count) {
			$query = $_SGLOBAL['db']->query("SELECT bf.url, bf.target_ids, bf.magiccolor, b.* FROM ".tname('repaste')." b $f_index
				LEFT JOIN ".tname('repastefield')." bf ON bf.repasteid=b.repasteid
				WHERE $wheresql
				ORDER BY $ordersql DESC LIMIT $start,$perpage");
		}
	}

	if($count) {
		include_once(S_ROOT.'./data/data_repasteclass.php');
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			realname_set($value['uid'], $value['username']);
			$value['classname']=$_SGLOBAL['repasteclass'][$value['classid']]['classname'];
			$list[] = $value;
		}
	}

	//分页
	$multi = multi($count, $perpage, $page, $theurl);

	//实名
	realname_get();

	$_TPL['css'] = 'repaste';
	include_once template("space_repaste_list");
}

?>