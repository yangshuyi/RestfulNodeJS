<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: log.php 11425 2009-03-05 05:11:17Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//一次处理的个数，防止超时
execute();

function execute(){
	global $_SGLOBAL, $_SC;
	include_once(S_ROOT.'./source/function_mtag.php');
	
	$sql = "SELECT * FROM ".tname('mtag')." mtag WHERE mtag.fieldid = 1 or mtag.fieldid = 5 ORDER BY mtag.fansnum DESC LIMIT 30";
	$list = querymtag($sql);
	
	$fileopen = fopen("sitelinkrank.xml","w");
	
	fwrite($fileopen,"<root>");
	foreach($list as $mtag) { 
		$mtag['utf_tagname'] = iconv("gb2312", "UTF-8", $mtag[tagname]);
		fwrite($fileopen,"<item type=\"text\" detail=\"".$mtag[utf_tagname]."\" link=\"space.php?do=mtag&tagid=".$mtag[tagid]."\" weight=\"".$mtag[fansnum]."\" />");
	}
	fwrite($fileopen,"</root>");
	fclose($fileopen);
}
?>