<html>

<head>
<meta http-equiv="content-type" content="text/html; charset=gbk" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
</head>

<style>
html,body,div{margin:0px; padding:0px; border:0px;}
</style>

<body>
<?php 
$currhour=date("H");
?>

<?php if( ($currhour >= 2 && $currhour < 20) || true ) {?>	

<script type="text/javascript">
	var notification = 0; 
	function timecheck() {
		var nowDate = new Date();
		var hour = nowDate.getHours()+0;
		var minute = nowDate.getMinutes()+0;
		if( hour == 19 && minute > 45){
			if( notification == 0 ){
				notification = 1;
				alert("您的农场快要休养生息啦～");	
			}
			setTimeout('timecheck()', 1000);
		}
		else if(hour >= 2 && hour < 20){
			setTimeout('timecheck()', 1000);
		}
		else{
			window.location.href = "../space.php?do=myfarm&view=nc";
		}
	}
	//timecheck();
</script>
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
		id="happyfarm" width="100%" height="620"
		codebase=" http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab">
		<param name="movie" value="/myfarm/happyfarm.swf" />
		<param name="quality" value="high" />
		<param name="flashvars" value="fv=1252682630" />
		<param name="base" value='/myfarm/' />
		<param name="AllowScriptAccess" value='always' />
		<param name="bgcolor" value="#ffffff" />
		<embed src="/myfarm/happyfarm.swf" quality="high" bgcolor="#ffffff"
			width="100%" height="620" name="happyfarm" align="middle"
			play="true"
			loop="false"
			base='/myfarm/'
			allowScriptAccess="always"
			flashvars='fv=1252682630' 
			quality="high"
			type="application/x-shockwave-flash"
			pluginspage=" http://www.adobe.com/go/getflashplayer">
		</embed>
	</object>
<?php } else {?>	
<div><span> 
虫虫开心农场将在电台时间段关闭，请大家谅解。
</span></div>
<?php }?>	
</body></html>
