<? if(!defined('UC_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>

<script src="js/common.js" type="text/javascript"></script>
<script type="text/javascript">
var apps = new Array();
var run = 0;
function testlink() {
	if(apps[run]) {
		$('status_' + apps[run]).innerHTML = '��������...';
		$('link_' + apps[run]).src = $('link_' + apps[run]).getAttribute('testlink') + '&sid=<?=$sid?>';
	}
	run++;
}
window.onload = testlink;
</script>
<div class="container">
	<? if($a == 'ls') { ?>
		<h3 class="marginbot">Ӧ���б�<a href="admin.php?m=app&a=add" class="sgbtn">�����Ӧ��</a></h3>
		<? if(!$status) { ?>
			<div class="note fixwidthdec">
				<p class="i">������֡�ͨ��ʧ�ܡ����������༭����������Ӧ��������Ӧ�� IP��</p>
			</div>
		<? } elseif($status == '2') { ?>
			<div class="correctmsg"><p>Ӧ���б�ɹ����¡�</p></div>
		<? } ?>
		<div class="mainbox">
			<? if($applist) { ?>
				<form action="admin.php?m=app&a=ls" method="post">
					<input type="hidden" name="formhash" value="<?=FORMHASH?>">
					<table class="datalist fixwidth" onmouseover="addMouseEvent(this);">
						<tr>
							<th nowrap="nowrap"><input type="checkbox" name="chkall" id="chkall" onclick="checkall('delete[]')" class="checkbox" /><label for="chkall">ɾ��</label></th>
							<th nowrap="nowrap">ID</th>
							<th nowrap="nowrap">Ӧ������</th>
							<th nowrap="nowrap">Ӧ�õ� URL</th>
							<th nowrap="nowrap">ͨ�����</th>
							<th nowrap="nowrap">����</th>
						</tr>
						<? $i = 0;?>
						<? foreach((array)$applist as $app) {?>
							<tr>
								<td width="50"><input type="checkbox" name="delete[]" value="<?=$app['appid']?>" class="checkbox" /></td>
								<td width="35"><?=$app['appid']?></td>
								<td><a href="admin.php?m=app&a=detail&appid=<?=$app['appid']?>"><strong><?=$app['name']?></strong></a></td>
								<td><a href="<?=$app['url']?>" target="_blank"><?=$app['url']?></a></td>
								<td width="90"><div id="status_<?=$app['appid']?>"></div><script id="link_<?=$app['appid']?>" testlink="admin.php?m=app&a=ping&inajax=1&url=<? echo urlencode($app['url']);?>&ip=<? echo urlencode($app['ip']);?>&appid=<?=$app['appid']?>&random=<? echo rand()?>"></script><script>apps[<?=$i?>] = '<?=$app['appid']?>';</script></td>
								<td width="40"><a href="admin.php?m=app&a=detail&appid=<?=$app['appid']?>">�༭</a></td>
							</tr>
							<? $i++?>
						<? } ?>
						<tr class="nobg">
							<td colspan="9"><input type="submit" value="�� ��" class="btn" /></td>
						</tr>
					</table>
					<div class="margintop"></div>
				</form>
			<? } else { ?>
				<div class="note">
					<p class="i">Ŀǰû����ؼ�¼!</p>
				</div>
			<? } ?>
		</div>
	<? } elseif($a == 'add') { ?>
		<h3 class="marginbot">�����Ӧ��<a href="admin.php?m=app&a=ls" class="sgbtn">����Ӧ���б�</a></h3>
		<div class="mainbox">
			<table class="opt">
				<tr>
					<th>ѡ��װ��ʽ:</th>
				</tr>
				<tr>
					<td>
						<input type="radio" name="installtype" class="radio" checked="checked" onclick="$('url').style.display='';$('custom').style.display='none';" />URL ��װ (�Ƽ�)
						<input type="radio" name="installtype" class="radio" onclick="$('url').style.display='none';$('custom').style.display='';" />�Զ��尲װ
					</td>
				</tr>
			</table>
			<div id="url">
				<form method="post" action="" target="_blank" onsubmit="document.appform.action=document.appform.appurl.value;" name="appform">
					<table class="opt">
						<tr>
							<th>Ӧ�ó���װ��ַ:</th>
						</tr>
						<tr>
							<td><input type="text" name="appurl" size="50" value="http://domainname/install/index.php" style="width:300px;" /></td>
						</tr>
					</table>
					<div class="opt">
						<input type="hidden" name="ucapi" value="<?=UC_API?>" />
						<input type="hidden" name="ucfounderpw" value="<?=$md5ucfounderpw?>" />
						<input type="submit" name="installsubmit"  value=" �� װ " class="btn" />
					</div>
				</form>
			</div>
			<div id="custom" style="display:none;">
				<form action="admin.php?m=app&a=add" method="post">
				<input type="hidden" name="formhash" value="<?=FORMHASH?>">
					<table class="opt">
						<tr>
							<th colspan="2">Ӧ������:</th>
						</tr>
						<tr>
							<td><input type="text" class="txt" name="name" value="" /></td>
							<td>�� 20 �ֽڡ�</td>
						</tr>
						<tr>
							<th colspan="2">Ӧ�õ� URL:</th>
						</tr>
						<tr>
							<td><input type="text" class="txt" name="url" value="" /></td>
							<td>��Ӧ���� UCenter ͨ�ŵĽӿ� URL����β�벻Ҫ�ӡ�/�� </td>
						</tr>
						<tr>
							<th colspan="2">Ӧ�� IP:</th>
						</tr>
						<tr>
							<td><input type="text" class="txt" name="ip" value="" /></td>
							<td>������������ռ��ɡ�������������������⵼�� UCenter ���Ӧ��ͨ��ʧ�ܣ��볢������Ϊ��Ӧ�����ڷ������� IP ��ַ��</td>
						</tr>
						<tr>
							<th colspan="2">ͨ����Կ:</th>
						</tr>
						<tr>
							<td><input type="text" class="txt" name="authkey" value="" /></td>
							<td>ֻ����ʹ��Ӣ����ĸ�����֣��� 64 �ֽڡ�Ӧ�ö˵�ͨ����Կ����������ñ���һ�£������Ӧ�ý��޷��� UCenter ����ͨ�š�</td>
						</tr>
						<tr>
							<th colspan="2">Ӧ������:</th>
						</tr>
						<tr>
							<td>
							<select name="type">
								<? foreach((array)$typelist as $typeid => $typename) {?>
									<option value="<?=$typeid?>"> <?=$typename?> </option>
								<?}?>
							</select>
							</td>
							<td></td>
						</tr>
						<tr>
							<th colspan="2">Ӧ�õ�����·��:</th>
						</tr>
						<tr>
							<td>
								<input type="text" class="txt" name="apppath" value="" />
							</td>
							<td>Ĭ�������գ������д��Ϊ���·���������UC����������Զ�ת��Ϊ����·������ ../</td>
						</tr>
						<tr>
							<th colspan="2">�鿴��������ҳ���ַ:</th>
						</tr>
						<tr>
							<td>
								<input type="text" class="txt" name="viewprourl" value="" />
							</td>
							<td>URL����������Ĳ��֣��磺/space.php?uid=%s ����� %s ����uid</td>
						</tr>
						<tr>
							<th colspan="2">Ӧ�ýӿ��ļ�����:</th>
						</tr>
						<tr>
							<td>
								<input type="text" class="txt" name="apifilename" value="uc.php" />
							</td>
							<td>Ӧ�ýӿ��ļ����ƣ�����·����Ĭ��Ϊuc.php</td>
						</tr>
						<tr>
							<th colspan="2">��ǩ������ʾģ��:</th>
						</tr>
						<tr>
							<td><textarea class="area" name="tagtemplates"></textarea></td>
							<td valign="top">��ǰӦ�õı�ǩ������ʾ������Ӧ��ʱ�ĵ�������ģ�塣</td>
						</tr>
						<tr>
							<th colspan="2">��ǩģ����˵��:</th>
						</tr>
						<tr>
							<td><textarea class="area" name="tagfields"><?=$tagtemplates['fields']?></textarea></td>
							<td valign="top">һ��һ�����˵����Ŀ���ö��ŷָ��Ǻ�˵�����֡��磺<br />subject,�������<br />url,�����ַ</td>
						</tr>
						<tr>
							<th colspan="2">�Ƿ���ͬ����¼:</th>
						</tr>
						<tr>
							<td>
								<input type="radio" class="radio" id="yes" name="synlogin" value="1" /><label for="yes">��</label>
								<input type="radio" class="radio" id="no" name="synlogin" value="0" checked="checked" /><label for="no">��</label>
							</td>
							<td>����ͬ����¼�󣬵��û��ڵ�¼����Ӧ��ʱ��ͬʱҲ���¼��Ӧ�á�</td>
						</tr>
						<tr>
							<th colspan="2">�Ƿ����֪ͨ:</th>
						</tr>
						<tr>
							<td>
								<input type="radio" class="radio" id="yes" name="recvnote" value="1"/><label for="yes">��</label>
								<input type="radio" class="radio" id="no" name="recvnote" value="0" checked="checked" /><label for="no">��</label>
							</td>
							<td></td>
						</tr>
					</table>
					<div class="opt"><input type="submit" name="submit" value=" �� �� " class="btn" tabindex="3" /></div>
				</form>
			</div>
		</div>
	<? } else { ?>
		<h3 class="marginbot">�༭Ӧ��<a href="admin.php?m=app&a=ls" class="sgbtn">����Ӧ���б�</a></h3>
		<? if($updated) { ?>
			<div class="correctmsg"><p>���³ɹ���</p></div>
		<? } elseif($addapp) { ?>
			<div class="correctmsg"><p>�ɹ����Ӧ�á�</p></div>
		<? } ?>
		<div class="mainbox">
			<form action="admin.php?m=app&a=detail&appid=<?=$appid?>" method="post">
			<input type="hidden" name="formhash" value="<?=FORMHASH?>">
				<table class="opt">
					<tr>
						<th colspan="2">ID: <?=$appid?></th>
					</tr>
					<tr>
						<th colspan="2">Ӧ������:</th>
					</tr>
					<tr>
						<td><input type="text" class="txt" name="name" value="<?=$name?>" /></td>
						<td>�� 20 �ֽڡ�</td>
					</tr>
					<tr>
						<th colspan="2">Ӧ�õ� URL:</th>
					</tr>
					<tr>
						<td><input type="text" class="txt" name="url" value="<?=$url?>" /></td>
						<td>��Ӧ���� UCenter ͨ�ŵĽӿ� URL����β�벻Ҫ�ӡ�/�� </td>
					</tr>
					<tr>
						<th colspan="2">Ӧ�� IP:</th>
					</tr>
					<tr>
						<td><input type="text" class="txt" name="ip" value="<?=$ip?>" /></td>
						<td>������������ռ��ɡ�������������������⵼�� UCenter ���Ӧ��ͨ��ʧ�ܣ��볢������Ϊ��Ӧ�����ڷ������� IP ��ַ��</td>
					</tr>
					<tr>
						<th colspan="2">ͨ����Կ:</th>
					</tr>
					<tr>
						<td><input type="text" class="txt" name="authkey" value="<?=$authkey?>" /></td>
						<td>ֻ����ʹ��Ӣ����ĸ�����֣��� 64 �ֽڡ�Ӧ�ö˵�ͨ����Կ����������ñ���һ�£������Ӧ�ý��޷��� UCenter ����ͨ�š�</td>
					</tr>
					<tr>
						<th colspan="2">Ӧ������:</th>
					</tr>
					<tr>
						<td>
						<select name="type">
							<? foreach((array)$typelist as $typeid => $typename) {?>
							<option value="<?=$typeid?>" <? if($typeid == $type) { ?>selected="selected"<? } ?>> <?=$typename?> </option>
							<?}?>
						</select>
						</td>
						<td></td>
					</tr>
					<tr>
						<th colspan="2">Ӧ�õ�����·��:</th>
					</tr>
					<tr>
						<td>
							<input type="text" class="txt" name="apppath" value="<?=$apppath?>" />
						</td>
						<td>Ĭ�������գ������д��Ϊ���·���������UC����������Զ�ת��Ϊ����·������ ../</td>
					</tr>
					<tr>
						<th colspan="2">�鿴��������ҳ���ַ:</th>
					</tr>
					<tr>
						<td>
							<input type="text" class="txt" name="viewprourl" value="<?=$viewprourl?>" />
						</td>
						<td>URL����������Ĳ��֣��磺/space.php?uid=%s ����� %s ����uid</td>
					</tr>
					<tr>
						<th colspan="2">Ӧ�ýӿ��ļ�����:</th>
					</tr>
					<tr>
						<td>
							<input type="text" class="txt" name="apifilename" value="<?=$apifilename?>" />
						</td>
						<td>Ӧ�ýӿ��ļ����ƣ�����·����Ĭ��Ϊuc.php</td>
					</tr>
					<tr>
						<th colspan="2">��ǩ������ʾģ��:</th>
					</tr>
					<tr>
						<td><textarea class="area" name="tagtemplates"><?=$tagtemplates['template']?></textarea></td>
						<td valign="top">��ǰӦ�õı�ǩ������ʾ������Ӧ��ʱ�ĵ�������ģ�塣</td>
					</tr>
					<tr>
						<th colspan="2">��ǩģ����˵��:</th>
					</tr>
					<tr>
						<td><textarea class="area" name="tagfields"><?=$tagtemplates['fields']?></textarea></td>
						<td valign="top">һ��һ�����˵����Ŀ���ö��ŷָ��Ǻ�˵�����֡��磺<br />subject,�������<br />url,�����ַ</td>
					</tr>
					<tr>
						<th colspan="2">�Ƿ���ͬ����¼:</th>
					</tr>
					<tr>
						<td>
							<input type="radio" class="radio" id="yes" name="synlogin" value="1" <?=$synlogin[1]?> /><label for="yes">��</label>
							<input type="radio" class="radio" id="no" name="synlogin" value="0" <?=$synlogin[0]?> /><label for="no">��</label>
						</td>
						<td>����ͬ����¼�󣬵��û��ڵ�¼����Ӧ��ʱ��ͬʱҲ���¼��Ӧ�á�</td>
					</tr>
					<tr>
						<th colspan="2">�Ƿ����֪ͨ:</th>
					</tr>
					<tr>
						<td>
							<input type="radio" class="radio" id="yes" name="recvnote" value="1" <?=$recvnotechecked[1]?> /><label for="yes">��</label>
							<input type="radio" class="radio" id="no" name="recvnote" value="0" <?=$recvnotechecked[0]?> /><label for="no">��</label>
						</td>
						<td></td>
					</tr>
				</table>
				<div class="opt"><input type="submit" name="submit" value=" �� �� " class="btn" tabindex="3" /></div>
<? if($isfounder) { ?>
				<table class="opt">
					<tr>
						<th colspan="2">Ӧ�õ� UCenter ������Ϣ:</th>
					</tr>
					<tr>
						<th>
<textarea class="area" onFocus="this.select()">
define('UC_CONNECT', 'mysql');
define('UC_DBHOST', '<?=UC_DBHOST?>');
define('UC_DBUSER', '<?=UC_DBUSER?>');
define('UC_DBPW', '<?=UC_DBPW?>');
define('UC_DBNAME', '<?=UC_DBNAME?>');
define('UC_DBCHARSET', '<?=UC_DBCHARSET?>');
define('UC_DBTABLEPRE', '`<?=UC_DBNAME?>`.<?=UC_DBTABLEPRE?>');
define('UC_DBCONNECT', '0');
define('UC_KEY', '<?=$authkey?>');
define('UC_API', '<?=UC_API?>');
define('UC_CHARSET', '<?=UC_CHARSET?>');
define('UC_IP', '');
define('UC_APPID', '<?=$appid?>');
define('UC_PPP', '20');
</textarea>
						</th>
						<td>��Ӧ�õ� UCenter ������Ϣ��ʧʱ�ɸ������Ĵ��뵽Ӧ�õ������ļ���</td>
					</tr>
				</table>
<? } ?>
			</form>
		</div>
	<? } ?>
</div>

<? include $this->gettpl('footer');?>