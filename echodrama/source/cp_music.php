<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: cp_music.php 13149 2009-08-13 03:11:26Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

include_once(S_ROOT.'./common.php');

if ( !get_magic_quotes_gpc( ) )
{
    $GLOBALS['_GET'] = saddslashes( $_GET );
    $GLOBALS['_POST'] = saddslashes( $_POST );
    $GLOBALS['_COOKIE'] = saddslashes( $_COOKIE );
}


function initurl( $url )
{
    $newurl = "";
    $blanks = array( "url" => "" );
    $urls = $blanks;
    if ( strlen( $url ) < 10 )
    {
        return $blanks;
    }
    $urls = @parse_url( $url );
    if ( empty( $urls ) || !is_array( $urls ) )
    {
        return $blanks;
    }
    if ( empty( $urls['scheme'] ) )
    {
        return $blanks;
    }
    if ( $urls['scheme'] == "file" )
    {
        return $blanks;
    }
    if ( empty( $urls['path'] ) )
    {
        $urls['path'] = "/";
    }
    $newurl .= $urls['scheme']."://";
    $newurl .= empty( $urls['user'] ) ? "" : $urls['user'];
    $newurl .= empty( $urls['pass'] ) ? "" : ":".$urls['pass'];
    $newurl .= empty( $urls['host'] ) ? "" : ( !empty( $urls['user'] ) || !empty( $urls['pass'] ) ? "@" : "" ).$urls['host'];
    $newurl .= empty( $urls['port'] ) ? "" : ":".$urls['port'];
    $newurl .= empty( $urls['path'] ) ? "" : $urls['path'];
    $newurl .= empty( $urls['query'] ) ? "" : "?".$urls['query'];
    $newurl .= empty( $urls['fragment'] ) ? "" : "#".$urls['fragment'];
    $urls['port'] = empty( $urls['port'] ) ? "80" : $urls['port'];
    $urls['url'] = $newurl;
    return $urls;
}



function checkmp3url( $mp3url )
{
    if ( strtolower( substr( $mp3url, 0 - 4 ) ) != ".mp3" )
    {
        return false;
    }
    if ( "http://" != strtolower( substr( $mp3url, 0, 7 ) ) )
    {
        return false;
    }
    $mp3urlarr = initurl( $mp3url );
    if ( empty( $mp3urlarr['host'] ) )
    {
        return false;
    }
    return $mp3url;
}


//提交处理
if (submitcheck('musicsubmit') )
{
	$musicmsg = $setsqlarr = $swapmp3msgarr = array( );
    $musicmsg = unserialize( $space['music'] );

	//配置
    if ( "config" == $_POST['action'] )
    {
        $musicmsg['config'] = array( );
        $musicmsg['config']['passpage'] = empty( $_POST['passpage'] ) ? 0 : 1;
        $musicmsg['config']['showmod'] = $_POST['showmod'] == "big" ? "big" : "default";
        $musicmsg['config']['autorun'] = $_POST['autorun'] == "true" ? "true" : "false";
        $musicmsg['config']['shuffle'] = $_POST['shuffle'] == "true" ? "true" : "false";
        $musicmsg['config']['crontabcolor'] = eregi( "^#[a-f0-9]{6}\$", $_POST['crontabcolor'] ) ? $_POST['crontabcolor'] : "";
        $musicmsg['config']['buttoncolor'] = eregi( "^#[a-f0-9]{6}\$", $_POST['buttoncolor'] ) ? $_POST['buttoncolor'] : "";
        $musicmsg['config']['fontcolor'] = eregi( "^#[a-f0-9]{6}\$", $_POST['fontcolor'] ) ? $_POST['fontcolor'] : "";
        $musicmsg['config']['crontabbj'] = array_pop( initurl( $_POST['crontabbj'] ) );
        $musicmsg['config']['bgimg'] = rawurlencode( $_POST['bgimg'] );
        $setsqlarr['music'] = addslashes( serialize( $musicmsg ) );
        updatetable( "spacefield", $setsqlarr, array('uid'=>$_SGLOBAL['supe_uid']));
        showmessage( "music_config_successful", "cp.php?ac=music");
    }
	//添加
    else if ( "addlist" == $_POST['action'] )
    {
		if ( is_array( $_POST['mp3url'] ) )
        {
            $addmp3arr = @array_map( null, $_POST['mp3url'], $_POST['mp3name'], $_POST['cdbj'] );
            $addmusicsuc = false;
            foreach ( $addmp3arr as $value )
            {
                if ( $checkmp3url = checkmp3url( $value[0] ) )
                {
                    $picmsgarr = initurl( $value[2] );
                    empty( $picmsgarr['host'] ) ? ( $cdbj = "" ) : ( $cdbj = shtmlspecialchars( $value[2] ) );
                    empty( $value[1] ) ? ( $mp3name = substr( md5( $checkmp3url ), 0 - 6 ) ) : ( $mp3name = shtmlspecialchars( $value[1] ) );
                    $musicmsg['mp3list'][] = array(
                        "mp3url" => $checkmp3url,
                        "mp3name" => $mp3name,
                        "cdbj" => $cdbj
                    );
                    $addmusicsuc = true;
                }
            }
            if ( $addmusicsuc == false )
            {
                showmessage( "music_mp3_add_error", "cp.php?ac=music&back=musicadd" );
            }
            $setsqlarr['music'] = addslashes( serialize( $musicmsg ) );

            updatetable( "spacefield", $setsqlarr, array('uid'=>$_SGLOBAL['supe_uid']));
            showmessage( "music_mp3_add_successful", "cp.php?ac=music");
        }
    }
	//编辑
    else if ( "editlist" == $_POST['action'] )
    {
        if ( !empty( $_POST['id'] ) && is_array( $_POST['id'] ) )
        {			
			foreach ( $GLOBALS['_POST']['id'] as $value )
            {
                $value = intval( $value );
				unset( $GLOBALS['_POST']['mp3url'][$value] );
                unset( $GLOBALS['_POST']['mp3name'][$value] );
                unset( $GLOBALS['_POST']['cdbj'][$value]);
            }
        }
        $swapmp3msgarr = array_map( NULL, $_POST['mp3url'], $_POST['mp3name'], $_POST['cdbj'] );
        $musicmsg['mp3list'] = array( );


        foreach ( $swapmp3msgarr as $index => $value )
        {
            if ( $checkmp3url = checkmp3url( $value[0] ) )
            {
                $_value = array( );
                $_value['mp3url'] = stripslashes( $value[0] );
                $_value['mp3name'] = stripslashes( $value[1] );
                $_value['cdbj'] = stripslashes( $value[2] );
                $musicmsg['mp3list'][] = $_value;
            }
        }
        $setsqlarr['music'] = addslashes( serialize( $musicmsg ) );


        updatetable( "spacefield", $setsqlarr, array('uid'=>$_SGLOBAL['supe_uid']));
        
		#$credits = getcredits( "music" );
        #if ( empty( $space['music'] ) && !empty( $credits['sql'] ) )
       # {
        #    updatecredits( $credits['sql'], $uid );
       # }
        showmessage( "music_mp3_delete_successful", $theurl."cp.php?ac=music", "notice" );
    }
    else
    {
        showmessage( "no_safe_post_data_into", "cp.php?ac=music");
    }
}

	#checkcredit( "music" ); //花费积分
    $musicmsgs = array( );
    $usershowmod = $userautomod = $usercrontabcolor = $userbuttoncolor = $userfontcolor = $usercrontabbj = $mp3listhtml = $passpage = $bgimg = "";
    if ( $space['music'] )
    {
		$musicmsgs = unserialize( $space['music'] );
    }
    #$credits = getcredits( "music", "<tr><td>{name} {credit}</td></tr>" );
    $crontabcolor = empty( $musicmsgs['config']['crontabcolor'] ) ? "#FFFFFF" : $musicmsgs['config']['crontabcolor'];
    $buttoncolor = empty( $musicmsgs['config']['buttoncolor'] ) ? "#333333" : $musicmsgs['config']['buttoncolor'];
    $fontcolor = empty( $musicmsgs['config']['fontcolor'] ) ? "#CCFF00" : $musicmsgs['config']['fontcolor'];
    $crontabbj = empty( $musicmsgs['config']['crontabbj'] ) ? "http://" : $musicmsgs['config']['crontabbj'];
    $bgimg = empty( $musicmsgs['config']['bgimg'] ) ? "http://" : rawurldecode( $musicmsgs['config']['bgimg'] );
    $musicmsgs['config']['autorun'] = empty( $musicmsgs['config']['autorun'] ) ? "true" : $musicmsgs['config']['autorun'];
	
	//完整OR列表
	 if ( $musicmsgs['config']['showmod'] == "big" )
    {
        $usershowmod = "完整 <input type=\"radio\" name=\"showmod\" value=\"big\" style=\"border:none;\" checked> 列表<input name=\"showmod\" type=\"radio\" value=\"default\" style=\"border:none;\">";
    }
    else
    {
        $usershowmod = "完整 <input type=\"radio\" name=\"showmod\" value=\"big\" style=\"border:none;\"> 列表<input name=\"showmod\" type=\"radio\" value=\"default\" style=\"border:none;\" checked>";
    }
	
	//自动OR手动
	 if ( $musicmsgs['config']['autorun'] == "true" )
    {
        $userautomod = "自动<input type=\"radio\" name=\"autorun\" value=\"true\" style=\"border:none;\" checked>手动<input name=\"autorun\" type=\"radio\" value=\"false\" style=\"border:none;\">";
    }
    else
    {
        $userautomod = "自动<input type=\"radio\" name=\"autorun\" value=\"true\" style=\"border:none;\">手动<input name=\"autorun\" type=\"radio\" value=\"false\" style=\"border:none;\" checked>";
    }


	 if ( $musicmsgs['config']['shuffle'] == "true" )
    {
        $usershuffle = "随机顺序<input type=\"radio\" name=\"shuffle\" value=\"true\" style=\"border:none;\" checked>列表顺序<input name=\"shuffle\" type=\"radio\" value=\"false\" style=\"border:none;\">";
    }
    else
    {
        $usershuffle = "随机顺序<input type=\"radio\" name=\"shuffle\" value=\"true\" style=\"border:none;\">列表顺序<input name=\"shuffle\" type=\"radio\" value=\"false\" style=\"border:none;\" checked>";
    }

	 if ( !empty( $musicmsgs['config']['passpage'] ) )
    {
        $passpage = "<input name=\"passpage\" type=\"checkbox\" id=\"passpage\" value=\"1\" style=\"border:none;\" checked>";
    }
    else
    {
        $passpage = "<input name=\"passpage\" type=\"checkbox\" id=\"passpage\" style=\"border:none;\" value=\"1\" disabled=\"disabled\">";
    }

	
	$box_color= "<tr>\r\n\t      <td>界面颜色</td>\r\n\t      <td> 面板背景颜色\r\n\t          <button type=\"button\" id=\"usercrontabcolor\" style=\"height:16px;width:16px;background: {$crontabcolor};\" onClick=\"usercrontabcolor_frame.location='/image/music/getcolor.htm?usercrontabcolor';showMenu('usercrontabcolor');\"></button>\r\n\t          <input type=\"text\" id=\"usercrontabcolor_v\" name=\"crontabcolor\" style=\"font-size: 10px;height:16px;width:44px;border:0px;\" size=\"5\" maxlength=\"7\" onblur=\"setpreview();\" onchange=\"setpreview();\" value=\"{$crontabcolor}\" />\r\n\t          <span id=\"usercrontabcolor_menu\" style=\"display: none\" class=\"tableborder\">\r\n\t          <iframe name=\"usercrontabcolor_frame\" src=\"\" frameborder=\"0\" width=\"164\" height=\"164\" scrolling=\"no\"></iframe>\r\n\t          </span> 字体按钮颜色\r\n\t          <button type=\"button\" id=\"userbuttoncolor\" style=\"height:16px;width:16px;background: {$buttoncolor};\" onClick=\"userbuttoncolor_frame.location='/image/music/getcolor.htm?userbuttoncolor';showMenu('userbuttoncolor');\"></button>\r\n\t          <input type=\"text\" id=\"userbuttoncolor_v\" name=\"buttoncolor\" style=\"font-size: 10px;height:16px;width:44px;border:0px;\" size=\"5\" maxlength=\"7\" onblur=\"setpreview();\" onchange=\"setpreview();\" value=\"{$buttoncolor}\" />\r\n\t          <span id=\"userbuttoncolor_menu\" style=\"display: none\" class=\"tableborder\">\r\n\t          <iframe name=\"userbuttoncolor_frame\" src=\"\" frameborder=\"0\" width=\"164\" height=\"164\" scrolling=\"no\"></iframe>\r\n\t          </span> 播放曲目颜色\r\n\t          <button type=\"button\" id=\"userfontcolor\" style=\"height:16px;width:16px;background: {$fontcolor};\" onClick=\"userfontcolor_frame.location='/image/music/getcolor.htm?userfontcolor';showMenu('userfontcolor');\"></button>\r\n\t          <input type=\"text\" id=\"userfontcolor_v\" name=\"fontcolor\" style=\"font-size: 10px;height:16px;width:44px;border:0px;\" size=\"5\" maxlength=\"7\" onblur=\"setpreview();\" onchange=\"setpreview();\" value=\"{$fontcolor}\" />\r\n\t          <span id=\"userfontcolor_menu\" style=\"display: none\" class=\"tableborder\">\r\n\t          <iframe name=\"userfontcolor_frame\" src=\"\" frameborder=\"0\" width=\"164\" height=\"164\" scrolling=\"no\"></iframe>\r\n\t        </span> </td>\r\n\t    </tr>\r\n\t    <tr>\r\n\t      <td>面板背景</td>\r\n\t      <td><input type=\"text\" name=\"crontabbj\" value=\"{$crontabbj}\" size=\"60\" maxlength=\"200\" />\r\n\t          <br /></td>\r\n\t    </tr>";



	 if ( !empty( $musicmsgs['mp3list'] ) )
    {
        $mp3listhtml = "<tr><td colspan=\"3\"><table width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\" id=\"thetable\"><tbody style=\"display:none;\"><tr><td colspan=\"2\"><hr size=\"0\" /></td></tr></tbody>";
        foreach ( $musicmsgs['mp3list'] as $index => $value )
        {
            $picmsg = initurl( $value['cdbj'] );
            $index_ = $index + 1;
            empty( $picmsg['url'] ) ? ( $picmsg['url'] = "/image/music/cd.gif" ) : ( $picmsg['url'] = $picmsg['url'] );
            $mp3listhtml .= "\r\n                      \t\t <tbody id=\"".$index_."\">\r\n\t\t      \t\t   <tr>\r\n\t\t      \t\t     <td>\r\n\t\t      \t\t       <table width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"2\" cellpadding=\"2\">\r\n\t\t      \t\t         <tr>\r\n\t\t      \t\t           <td>mp3地址</td>\r\n\t\t      \t\t           <td><input type=\"text\" name=\"mp3url[]\" size=\"60\" maxlength=\"200\" value=\"".$value['mp3url']."\" /></td>\r\n\t\t      \t\t         </tr>\r\n\t\t      \t\t         <tr>\r\n\t\t      \t\t           <td>曲目名</td>\r\n\t\t      \t\t           <td><input type=\"text\" name=\"mp3name[]\" size=\"20\" maxlength=\"30\" value=\"".$value['mp3name']."\"  />\r\n\t\t      \t\t             </td>\r\n\t\t      \t\t         </tr>\r\n\t\t      \t\t         <tr>\r\n\t\t      \t\t           <td>封面</td>\r\n\t\t      \t\t           <td><input type=\"text\" name=\"cdbj[]\" size=\"60\" maxlength=\"200\" value=\"".$picmsg['url']."\" /> <img src=\"".$picmsg['url']."\" class=\"musicbj\" border=\"0\" align=\"absmiddle\">\r\n\t\t      \t\t               <br />\r\n\t\t      \t\t            </td>\r\n\t\t      \t\t         </tr>\r\n\t\t      \t\t     </table></td>\r\n\t\t      \t\t     <td width=\"50px\"><input name=\"id[]\" type=\"checkbox\" id=\"id\" value=\"".$index."\" style=\"border:none;\"><a href=\"javascript:;\" onclick=\"exchangeNode(this, -1)\"><img src=\"/image/music/icon_top.gif\"  width=\"11\" height=\"12\" border=\"0\" /></a><a href=\"javascript:;\" onclick=\"exchangeNode(this, 1)\"><img src=\"/image/music/icon_down.gif\"  width=\"11\" height=\"12\" border=\"0\" /></a></td>\r\n\t\t      \t\t   </tr>\r\n\t\t      \t\t   <tbody>\r\n\t\t\t\t";
        }
        $mp3listhtml .= "</table></td></tr>";
    }




 if ( !empty( $musicmsgs['mp3list'] ) )
    {
        $formhash =formhash();
		$mp3_list ="\t<style>\r\n\t.musicbj{max-width: 28px; max-height: 26px; width: expression(this.width > 28 ? 28: true); height: expression(this.height > 26 ? 26: true);}\r\n\t</style>\r\n\t<form method=\"post\" name=\"theformmp3list\" id=\"theformmp3list\" action=\"cp.php?ac=music\" enctype=\"multipart/form-data\" class=\"block\">\r\n\t<table width=\"95%\" align=\"center\" border=\"0\" cellspacing=\"2\" cellpadding=\"2\">\r\n\t    <tr>\r\n\t      <td colspan=\"2\">唱片集封面和文件地址(不能播放的时候请确定该地址mp3文件是否存在)</td>\r\n\t      <td><div align=\"right\">全选删除\r\n\t              <input id=\"chkall\" name=\"chkall\" onclick=\"checkall(this.form, 'id')\" type=\"checkbox\" style=\"border:none;\">\r\n\t      </div></td>\r\n\t    </tr>\r\n\t    {$mp3listhtml}\r\n\t    <tr>\r\n\t      <td colspan=\"2\"><div align=\"center\"><input name=\"action\" type=\"hidden\" id=\"action\" value=\"editlist\">\r\n\t          <button type=\"submit\" name=\"musicsubmit\" class=\"submit\" value=\"true\">更新当前音乐列表</button></div></td>\r\n\t    </tr>\r\n\t</table>\r\n      <input type=\"hidden\" name=\"formhash\" value=\"".$formhash."\" /></form>";
    }
    else
    {
        $mp3_list="\t<table width=\"40%\" height=\"60\" border=\"0\" align=\"center\" cellpadding=\"2\" cellspacing=\"2\">\r\n\t    <tr>\r\n\t      <td><div align=\"center\">[当前播放列表为空]</div></td>\r\n\t    </tr>\r\n\t</table>";
    }




$actives = array('music' =>' class="active"');

include template("cp_music");

?>