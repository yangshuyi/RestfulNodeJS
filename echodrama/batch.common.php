<?
include_once('./common.php');
include_once(S_ROOT.'./source/function_cp.php');
include_once(S_ROOT.'./source/function_magic.php');

//转换
function encodeconvert( $encode, $content, $to = 0 )
{
    global $chs;
    global $_SC;
    if ( !empty( $encode ) && strtolower( $encode ) != strtolower( $_SC['charset'] ) )
    {
        include_once( S_ROOT."./source/chinese.class.php" );
        if ( $to )
        {
            $chs = new chinese( $_SC['charset'], $encode, $content );
        }
        else
        {
            $chs = new chinese( $encode, $_SC['charset'], $content );
        }
        $content = $chs->convertit( );
    }
    return $content;
}


//允许动作
$dos = array('musicconfig','musicpasspage');

$uid = empty($_GET['uid'])?0:intval($_GET['uid']);
$action = (!empty($_GET['action']) && in_array($_GET['action'], $dos))?$_GET['action']:'musicconfig';

if ($action == 'musicconfig') {
	if(empty($uid)) {
		exit();
	}
	$reauthcode = md5($_SCONFIG['sitekey'].$uid);
	if($reauthcode == $_GET['hash']) {
		$query = $_SGLOBAL['db']->query('SELECT `music` FROM '.tname('spacefield').' WHERE uid = \''.$uid.'\'');
		$musicmsgs = unserialize($_SGLOBAL['db']->result($query, 0));
		$outxml = '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
		$outxml .= '<playlist version="1">'."\n";
		$outxml .= '<mp3config>'."\n";
		if('big' == $musicmsgs['config']['showmod']) {
			$outxml .= '<showdisplay>true</showdisplay>'."\n";
		} else {
			$outxml .= '<showdisplay>false</showdisplay>'."\n";
		}
		$outxml .= '<autostart>'.$musicmsgs['config']['autorun'].'</autostart>'."\n";
		$outxml .= '<showplaylist>true</showplaylist>'."\n";
		$outxml .= '<shuffle>'.$musicmsgs['config']['shuffle'].'</shuffle>'."\n";
		$outxml .= '<repeat>all</repeat>'."\n";
		$outxml .= '<volume>100</volume>';		
		$outxml .= '<linktarget>_top</linktarget> '."\n";
		$outxml .= '<backcolor>0x'.substr($musicmsgs['config']['crontabcolor'], -6).'</backcolor> '."\n";
		$outxml .= '<frontcolor>0x'.substr($musicmsgs['config']['buttoncolor'], -6).'</frontcolor>'."\n";
		$outxml .= '<lightcolor>0x'.substr($musicmsgs['config']['fontcolor'], -6).'</lightcolor>'."\n";
		$outxml .= '<jpgfile>'.$musicmsgs['config']['crontabbj'].'</jpgfile>'."\n";
		$outxml .= '<callback></callback> '."\n"; 
		$outxml .= '</mp3config>'."\n";
		$outxml .= '<trackList>'."\n";
		foreach ($musicmsgs['mp3list'] as $value){
			$outxml .= '<track><annotation>'.$value['mp3name'].'</annotation><location>'.$value['mp3url'].'</location><image>'.$value['cdbj'].'</image></track>'."\n";
		}
		$outxml .= '</trackList></playlist>';
		$outxml = encodeconvert("UTF-8", $outxml, 1);
		@header("Expires: -1");
		@header("Cache-Control: no-store, private, post-check=0, pre-check=0, max-age=0", FALSE);
		@header("Pragma: no-cache");
		@header("Content-type: application/xml");
		echo $outxml;
	}
	exit();
} elseif ($action == 'musicpasspage') {
	if(empty($uid)) {
		exit();
	}
	$reauthcode = md5($_SCONFIG['sitekey'].$uid);
	if($reauthcode == $_GET['hash']) {
		
		$query = $_SGLOBAL['db']->query('SELECT `music` FROM '.tname('spacefield').' WHERE uid = \''.$uid.'\'');
		$musicmsgs = unserialize($_SGLOBAL['db']->result($query, 0));
		if(0 == $musicmsgs['config']['passpage']){
			echo '<script language="javascript" type="text/javascript">parent.window.location.href="./?'.$uid.'"</script>';
			exit();
		}
		$swfurl = $_SC['siteurl'].'image/music/mp3player.swf?site='.$_SC['siteurl'].'&uid='.$uid.'&hash='.$reauthcode.'&rand='.rand(100, $_SGLOBAL['timestamp']);
		$outxml .= '<html>'."\n";
		$outxml .= '<body style="margin:0;background:url('.rawurldecode($musicmsgs['config']['bgimg']).')">'."\n";
		$outxml .= '<object codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" height="300" width="192">'."\n";
		$outxml .= '<param name="movie" value="'.$swfurl.'" />'."\n";
		$outxml .= '<param name="AllowScriptAccess" value="always" />'."\n";
		$outxml .= '<param name="AllowFullScreen" value="true" />'."\n";
		$outxml .= '<embed src="'.$swfurl.'" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" pluginspage="http://www.macromedia.com/go/getflashplayer" height="300" width="192" />'."\n"; 
		$outxml .= '</object>'."\n";
		$outxml .= '</body></html>';
		echo $outxml;
	} 
	exit();
}
?>