<? if(!defined('UC_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>

<script src="js/common.js" type="text/javascript"></script>
<script src="js/calendar.js" type="text/javascript"></script>

<? if($a == 'ls') { ?>

	<script type="text/javascript">
		function switchbtn(btn) {
			$('srchuserdiv').style.display = btn == 'srch' ? '' : 'none';
			$('srchuserdiv').className = btn == 'srch' ? 'tabcontentcur' : '' ;
			$('srchuserbtn').className = btn == 'srch' ? 'tabcurrent' : '';
			$('adduserdiv').style.display = btn == 'srch' ? 'none' : '';
			$('adduserdiv').className = btn == 'srch' ? '' : 'tabcontentcur';
			$('adduserbtn').className = btn == 'srch' ? '' : 'tabcurrent';
		}
	</script>

	<div class="container">
		<? if($status) { ?>
			<div class="<? if($status > 0) { ?>correctmsg<? } else { ?>errormsg<? } ?>"><p><? if($status < 0) { ?><em>����û�ʧ��:</em> <? } ?><? if($status == 2) { ?>�ɹ�ɾ���û�<? } elseif($status == 1) { ?>�ɹ�����û���<? } elseif($status == -1) { ?>�û������Ϸ�<? } elseif($status == -2) { ?>�û������������ַ�<? } elseif($status == -3) { ?>���û����Ѿ���ע��<? } elseif($status == -4) { ?>Email ��ַ���Ϸ�<? } elseif($status == -5) { ?>Email ��������ʹ�õ���������<? } elseif($status == -6) { ?>�� Email ��ַ�Ѿ���ע��<? } ?></p></div>
		<? } ?>
		<div class="hastabmenu">
			<ul class="tabmenu">
				<li id="srchuserbtn" class="tabcurrent"><a href="#" onclick="switchbtn('srch')">�����û�</a></li>
				<li id="adduserbtn"><a href="#" onclick="switchbtn('add')">����û�</a></li>
			</ul>
			<div id="adduserdiv" class="tabcontent" style="display:none;">
				<form action="admin.php?m=user&a=ls&adduser=yes" method="post">
				<input type="hidden" name="formhash" value="<?=FORMHASH?>">
				<table width="100%">
					<tr>
						<td>�û���:</td>
						<td><input type="text" name="addname" class="txt" /></td>
						<td>����:</td>
						<td><input type="text" name="addpassword" class="txt" /></td>
						<td>Email:</td>
						<td><input type="text" name="addemail" class="txt" /></td>
						<td><input type="submit" value="�� ��"  class="btn" /></td>
					</tr>
				</table>
				</form>
			</div>
			<div id="srchuserdiv" class="tabcontentcur">
				<form action="admin.php?m=user&a=ls" method="post">
				<input type="hidden" name="formhash" value="<?=FORMHASH?>">
				<table width="100%">
					<tr>
						<td>�û���:</td>
						<td><input type="text" name="srchname" value="<?=$srchname?>" class="txt" /></td>
						<td>UID:</td>
						<td><input type="text" name="srchuid" value="<?=$srchuid?>" class="txt" /></td>
						<td>Email:</td>
						<td><input type="text" name="srchemail" value="<?=$srchemail?>" class="txt" /></td>
						<td rowspan="2"><input type="submit" value="�� ��" class="btn" /></td>
					</tr>
					<tr>
						<td>ע������:</td>
						<td colspan="3"><input type="text" name="srchregdatestart" onclick="showcalendar();" value="<?=$srchregdatestart?>" class="txt" /> �� <input type="text" name="srchregdateend" onclick="showcalendar();" value="<?=$srchregdateend?>" class="txt" /></td>
						<td>ע��IP:</td>
						<td><input type="text" name="srchregip" value="<?=$srchregip?>" class="txt" /></td>
					</tr>
				</table>
				</form>
			</div>
		</div>

		<? if($adduser) { ?><script type="text/javascript">switchbtn('add');</script><? } ?>
<br />
		<h3>�û��б�</h3>
		<div class="mainbox">
			<? if($userlist) { ?>
				<form action="admin.php?m=user&a=ls&srchname=<?=$srchname?>&srchregdate=<?=$srchregdate?>" onsubmit="return confirm('�ò������ɻָ�����ȷ��Ҫɾ����Щ�û���');" method="post">
				<input type="hidden" name="formhash" value="<?=FORMHASH?>">
				<table class="datalist fixwidth" onmouseover="addMouseEvent(this);">
					<tr>
						<th><input type="checkbox" name="chkall" id="chkall" onclick="checkall('delete[]')" class="checkbox" /><label for="chkall">ɾ��</label></th>
						<th>�û���</th>
						<th>Email</th>
						<th>ע������</th>
						<th>ע��IP</th>
						<th>�༭</th>
					</tr>
					<? foreach((array)$userlist as $user) {?>
						<tr>
							<td class="option"><input type="checkbox" name="delete[]" value="<?=$user['uid']?>" class="checkbox" /></td>
							<td><?=$user['smallavatar']?> <strong><?=$user['username']?></strong></td>
							<td><?=$user['email']?></td>
							<td><?=$user['regdate']?></td>
							<td><?=$user['regip']?></td>
							<td><a href="admin.php?m=user&a=edit&uid=<?=$user['uid']?>">�༭</a></td>
						</tr>
					<? } ?>
					<tr class="nobg">
						<td><input type="submit" value="�� ��" class="btn" /></td>
						<td class="tdpage" colspan="6"><?=$multipage?></td>
					</tr>
				</table>
				</form>
			<? } else { ?>
				<div class="note">
					<p class="i">Ŀǰû����ؼ�¼!</p>
				</div>
			<? } ?>
		</div>
	</div>

<? } else { ?>

	<div class="container">
		<h3 class="marginbot">�༭�û�����
			<? if(getgpc('fromadmin')) { ?>
				<a href="admin.php?m=admin&a=ls" class="sgbtn">���ع���Ա�б�</a>
			<? } else { ?>
				<a href="admin.php?m=user&a=ls" class="sgbtn">�����û��б�</a>
			<? } ?>
		</h3>
		<? if($status == 1) { ?>
			<div class="correctmsg"><p>�༭�û����ϳɹ�</p></div>
		<? } elseif($status == -1) { ?>
			<div class="correctmsg"><p>�༭�û�����ʧ��</p></div>
		<? } else { ?>
			<div class="note"><p class="i">�������գ����ֲ��䡣</p></div>
		<? } ?>
		<div class="mainbox">
			<form action="admin.php?m=user&a=edit&uid=<?=$uid?>" method="post">
			<input type="hidden" name="formhash" value="<?=FORMHASH?>">
				<table class="opt">
					<tr>
						<th>ͷ��: <input name="delavatar" class="checkbox" type="checkbox" value="1" /> ɾ��ͷ��</th>
					</tr>
					<tr>
						<th>����ͷ��:</th>
					</tr>
					<tr>
						<td><?=$user['bigavatar']?></td>
					</tr>
					<tr>
						<th>��ʵͷ��:</th>
					</tr>
					<tr>
						<td><?=$user['bigavatarreal']?></td>
					</tr>
					<tr>
						<th>�û���:</th>
					</tr>
					<tr>
						<td>
							<input type="text" name="newusername" value="<?=$user['username']?>" class="txt" />
							<input type="hidden" name="username" value="<?=$user['username']?>" class="txt" />
						</td>
					</tr>
					<tr>
						<th>�ܡ���:</th>
					</tr>
					<tr>
						<td>
							<input type="text" name="password" value="" class="txt" />
						</td>
					</tr>
					<tr>
						<th>��ȫ����: <input type="checkbox" class="checkbox" name="rmrecques" value="1" /> �����ȫ����</th>
					</tr>
					<tr>
						<th>Email:</th>
					</tr>
					<tr>
						<td>
							<input type="text" name="email" value="<?=$user['email']?>" class="txt" />
						</td>
					</tr>
				</table>
				<div class="opt"><input type="submit" name="submit" value=" �� �� " class="btn" tabindex="3" /></div>
			</form>
		</div>
	</div>
<? } ?>
<? include $this->gettpl('footer');?>