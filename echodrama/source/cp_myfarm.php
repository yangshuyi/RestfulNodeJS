<?php
/*
 [UCenter Home] (C) 2007-2008 Comsenz Inc.
 $Id: cp_topic.php 12436 2009-06-25 09:07:38Z liguode $
 */

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//╪Л╡Ипео╒
$op = empty($_GET['op'])?'':$_GET['op'];

include_once(S_ROOT.'./source/function_cp.php');

if($_GET['op'] == 'exchange') {
	submitcheck('topicsubmit');
	
	if($_GET['subop'] == 'exchange_credit_money') {

		$spaceinfocredit = intval($_POST['exchange_credit_money_creditamount']);
		if(!empty($spaceinfocredit)){
			$spaceinfo = $value = $_SGLOBAL['db']->fetch_array( $_SGLOBAL['db']->query( "SELECT * FROM ".tname( "space" )." where uid=".$_SGLOBAL['supe_uid'] ));
			$myfarm = $value = $_SGLOBAL['db']->fetch_array( $_SGLOBAL['db']->query( "SELECT * FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] ));
			
			if(!empty($spaceinfo) && !empty($myfarm) ){
				$_SGLOBAL['db']->query( "UPDATE ".tname( "space" )." SET credit = credit - $spaceinfocredit where uid=".$_SGLOBAL['supe_uid'] );
				$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." SET money = money + " .floor($spaceinfocredit*2) ." where uid=".$_SGLOBAL['supe_uid'] );
			}
		}
	}
	elseif($_GET['subop'] == 'exchange_credit_fb') {

		$spaceinfocredit = intval($_POST['exchange_credit_fb_creditamount']);
		if(!empty($spaceinfocredit)){
			$spaceinfo = $value = $_SGLOBAL['db']->fetch_array( $_SGLOBAL['db']->query( "SELECT * FROM ".tname( "space" )." where uid=".$_SGLOBAL['supe_uid'] ));
			$myfarm = $value = $_SGLOBAL['db']->fetch_array( $_SGLOBAL['db']->query( "SELECT * FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] ));
			
			if(!empty($spaceinfo) && !empty($myfarm) ){
				$_SGLOBAL['db']->query( "UPDATE ".tname( "space" )." SET credit = credit - $spaceinfocredit where uid=".$_SGLOBAL['supe_uid'] );
				$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." SET fb = fb + " .floor($spaceinfocredit*0.05) ." where uid=".$_SGLOBAL['supe_uid'] );
			}
		}
	}
	elseif($_GET['subop'] == 'exchange_money_credit') {

		$spaceinfocredit = intval($_POST['exchange_money_credit_moneyamount']);
		if(!empty($spaceinfocredit)){
			$spaceinfo = $value = $_SGLOBAL['db']->fetch_array( $_SGLOBAL['db']->query( "SELECT * FROM ".tname( "space" )." where uid=".$_SGLOBAL['supe_uid'] ));
			$myfarm = $value = $_SGLOBAL['db']->fetch_array( $_SGLOBAL['db']->query( "SELECT * FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] ));
			
			if(!empty($spaceinfo) && !empty($myfarm) ){
				$_SGLOBAL['db']->query( "UPDATE ".tname( "space" )." SET credit = credit + ".floor($spaceinfocredit*0.1)." where uid=".$_SGLOBAL['supe_uid'] );
				$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." SET money = money - $spaceinfocredit where uid=".$_SGLOBAL['supe_uid'] );
			}
		}
	}
	elseif($_GET['subop'] == 'exchange_fb_credit') {

		$spaceinfocredit = intval($_POST['exchange_fb_credit_fbamount']);
		if(!empty($spaceinfocredit)){
			$spaceinfo = $value = $_SGLOBAL['db']->fetch_array( $_SGLOBAL['db']->query( "SELECT * FROM ".tname( "space" )." where uid=".$_SGLOBAL['supe_uid'] ));
			$myfarm = $value = $_SGLOBAL['db']->fetch_array( $_SGLOBAL['db']->query( "SELECT * FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] ));
			
			if(!empty($spaceinfo) && !empty($myfarm) ){
				$_SGLOBAL['db']->query( "UPDATE ".tname( "space" )." SET credit = credit + ".floor($spaceinfocredit*20)." where uid=".$_SGLOBAL['supe_uid'] );
				$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." SET fb = fb - $spaceinfocredit where uid=".$_SGLOBAL['supe_uid'] );
			}
		}
	}
	
	showmessage('do_success', "space.php?do=myfarm&view=index", 0);
}

showmessage('do_success', "space.php?do=myfarm&view=index", 0);

?>