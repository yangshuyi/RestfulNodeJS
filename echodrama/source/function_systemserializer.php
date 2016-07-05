<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: function_common.php 13235 2009-08-24 09:48:36Z shirui $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

function loadSystemSerializerFromFile( $moduleName, $cutoffTime, $keepSeconds){
	global $_SGLOBAL, $_SC;
	
	$cachefile = S_ROOT.'./data/tpl_cache/'.$moduleName.'.temp';
	if( !file_exists($cachefile) ){
		return null;
	}
	
	$system_serializer_sql="SELECT ss.* FROM ".tname('systemserializer')." ss WHERE ss.modulename='$moduleName' AND ss.ip='".UC_IP."' LIMIT 0,1";
	$query = $_SGLOBAL['db']->query($system_serializer_sql);
	$system_serializer = $_SGLOBAL['db']->fetch_array($query);
	
	if( ($cutoffTime - $system_serializer['dateline']) <= $keepSeconds ){
		$module_serializer_value = file_get_contents($cachefile);
		return unserialize($module_serializer_value);
	}
	else{
		return null;
	}
}

function saveSystemSerializerIntoFile( $moduleName, $cutoffTime, $module_serializer_array){
	global $_SGLOBAL, $_SC;
	
	$cachefile = S_ROOT.'./data/tpl_cache/'.$moduleName.'.temp';
	
	$module_serializer_value=serialize($module_serializer_array);
	$fileopen = fopen($cachefile,"wb");
	fwrite($fileopen,$module_serializer_value);
	fclose($fileopen);
	
	$datelinestr = sgmdate('Y-m-d H:i:s', $cutoffTime);
	$sql="update ".tname('systemserializer')." ss set ss.dateline=$cutoffTime, datelinestr='$datelinestr' where ss.modulename='$moduleName' AND ss.ip='".UC_IP."'";
	$query = $_SGLOBAL['db']->query($sql);
}

?>
