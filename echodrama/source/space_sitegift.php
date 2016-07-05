<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_repaste.php 13208 2009-08-20 06:31:35Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}
$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('usergift')." ORDER BY credit desc");
$sitegift = 0;
$list = array();
while ($value = $_SGLOBAL['db']->fetch_array($query)) {
	$list[] = $value;
}

include_once template('space_sitegift');

?>