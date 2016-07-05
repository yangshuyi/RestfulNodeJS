<?php
$vid = $_GET['vid'];
$width = $_GET['width'];
$height = $_GET['height'];


?>
<html>
<body>

<a href="<?=$vid?>" target="_blank">link</a>

<object width="<?=$width?>" height="<?=$height?>" type="application/x-shockwave-flash" 
		data="<?=$vid?>">
	<param name="src" value="<?=$vid?>"/>
</object>

------------------------<br/>
<object width="300" height="200">
<param name="movie"
value="http://fpdownload.adobe.com/strobe/FlashMediaPlayback_101.swf"></param>
<param name="flashvars"
value="src=<?=$vid?>"></param>
<param name="allowFullScreen" value="true"></param>
<param name="allowscriptaccess" value="always"></param>
<embed
src="<?=$vid?>"
type="application/x-shockwave-flash" allowscriptaccess="always"
allowfullscreen="true" width="500" height="300"
flashvars="src=<?=$vid?>">
</embed>
</object>
</body>
</html>