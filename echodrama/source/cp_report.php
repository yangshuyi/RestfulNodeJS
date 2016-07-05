<?php
/*
 [UCenter Home] (C) 2007-2008 Comsenz Inc.
 $Id: cp_report.php 12436 2009-06-25 09:07:38Z liguode $
 */

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//�����Ϣ
$rid = empty($_GET['rid'])?0:intval($_GET['rid']);
$idtype = empty($_GET['idtype'])?'':trim($_GET['idtype']);
$_GET['op'] = empty($_GET['op'])?'new':$_GET['op'];
$op = empty($_GET['op'])?'':$_GET['op'];

include_once(S_ROOT.'./source/function_report.php');

if($_GET['op'] == 'setprocessstate') {
	if(empty($rid) || $rid<=0) {
		showmessage("report_does_not_exist"); 
	}
	
	$report=loadreportbyid($rid);
	if(empty($report)) {
		showmessage('report_does_not_exist');
	}
	
	$processsate=$_GET['processstate'];
	if( empty($processsate) || ($processsate<0 || $processsate>4) ){
		showmessage('report_process_state_error');
	}
	
	$newstate=null;
	if($processsate == 0){
		//���¾ٱ�
		if($report['processstate']!=3 || $report['processstate']!=4){
			showmessage('report_process_state_check_error');
		}
		
		$index=stripos($report['userids'],"/".$_SGLOBAL['supe_uid']."/");
		if(empty($index) || $index<0){
			showmessage('report_process_state_check_error');
		}
		
		$report['processstate']=0; 
		$report['lastpost']=$_SGLOBAL['timestamp']; 
		$newstate="��δ����";
		$datachanged=true;
	}
	else if($processsate == 1){
		//ȷ�ϸþٱ�
		if( $_SGLOBAL['member']['system']!=99 ){
			showmessage('report_process_state_check_error');
		}
		
		$report['processstate']=1; 
		$report['lastpost']=$_SGLOBAL['timestamp']; 
		$newstate="�ٱ�ȷ����";
	}
	else if($processsate == 2){
		//����þٱ�
		if( $_SGLOBAL['member']['system']!=99 ){
			showmessage('report_process_state_check_error');
		}
		
		$report['processstate']=2; 
		$report['lastpost']=$_SGLOBAL['timestamp']; 
		$newstate="�ٱ�������";
	}
	else if($processsate == 3){
		//������ϣ��ύ���û�ȷ��
		if( $_SGLOBAL['member']['system']!=99 ){
			showmessage('report_process_state_check_error');
		}
		
		$report['processstate']=3; 
		$report['lastpost']=$_SGLOBAL['timestamp']; 
		$newstate="�ȴ��û�����";
	}
	else if($processsate == 4){
		//�رոþٱ�
		if($report['processstate']==3){
			$index=stripos($report['userids'],"/".$_SGLOBAL['supe_uid']."/");
			if( $_SGLOBAL['member']['system']!=99 && $index<0){
				showmessage('report_process_state_check_error');
			}
		}
		$report['processstate']=4; 
		$report['lastpost']=$_SGLOBAL['timestamp']; 
		$newstate="�ѹر�";
	}
	else{
		
	}
	
	if(!empty( $newstate )){
		$qsql="UPDATE ".tname("report")." r SET r.processstate='$report[processstate]', r.lastpost='$report[lastpost]' WHERE r.rid=$rid";
		$_SGLOBAL['db']->query($qsql);
		
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
		
		foreach($useridarray as $useriditem){
			notification_add($useriditem, 'report_statechanged', "<br/> �ٱ���ĿIDΪ[<a href='space.php?do=report&op=viewsingle&reportid=$report[rid]' target='_blank'>$report[rid]</a>]��״̬�ѱ��޸�Ϊ[$newstate]��");
		}
		
	}
	
	showmessage('do_success', $_SGLOBAL[refer], 1);
}
else if($_GET['op'] == 'delete') {
	if(empty($reportid)) {
		showmessage("report_does_not_exist"); 
	}
	
	$report=loadreportbyid($reportid);
	if(empty($report)) {
		showmessage('report_does_not_exist');
	}
	
	deletereports($reportid);
	
	showmessage('do_success', $_SGLOBAL[refer], 0);
}



?>