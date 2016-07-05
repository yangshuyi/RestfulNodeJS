<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}


//一次处理的个数，防止超时
execute();

function execute(){
	global $_SGLOBAL, $_SC;

	$query = $_SGLOBAL['db']->query('SELECT uid,farmlandstatus FROM '.tname('plug_newfarm'));
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$list[] = $value;
	}
	
	foreach ($list as $userparameter) {
	    $farm=(array) json_decode($userparameter[farmlandstatus]);
	    foreach ($farm[farmlandstatus] as $value){
	    	$value->q = $value->q - 3600;
	    }
	    $farm=json_encode($farm);
	    $_SGLOBAL['db']->query("UPDATE ".tname('plug_newfarm')." set farmlandstatus='".$farm."' where uid=".$userparameter[uid]);
	
	}
}

?>
