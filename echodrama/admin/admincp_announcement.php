<?php
/*
 [UCenter Home] (C) 2007-2008 Comsenz Inc.
 $Id: admincp_blog.php 9233 2008-10-28 06:21:44Z liguode $
 */

if(!defined('IN_UCHOME') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

//х╗оч
if(!checkperm('managetopic')) {
	cpmessage('no_authority_management_operation');
}


?>