<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include_once('../common.php');
$credit= $_SGLOBAL['db']->result($_SGLOBAL['db']->query('SELECT credit FROM '.tname('space').' where uid='.$_SGLOBAL['supe_uid']),0);
if ($_REQUEST['fb']*10>$credit)
{
    echo('<HTML>
<HEAD>
<meta http-equiv="refresh" content="2; url=fb.htm">
</HEAD>
<BODY>
����ֲ���
</BODY>
</HTML>
');
    exit();
}
$_SGLOBAL['db']->query("UPDATE ".tname('space')." set credit=credit-".($_REQUEST['fb']*10)." where uid=".$_SGLOBAL['supe_uid']);
$_SGLOBAL['db']->query("UPDATE ".tname('plug_newfarm')." set fb=fb+".$_REQUEST['fb']." where uid=".$_SGLOBAL['supe_uid']);
echo('<HTML>
<HEAD>
<meta http-equiv="refresh" content="2; url=fb.htm">
</HEAD>
<BODY>
�ɹ��һ�'.$_REQUEST['fb'].'��fb
</BODY>
</HTML>
');
exit();
?>
