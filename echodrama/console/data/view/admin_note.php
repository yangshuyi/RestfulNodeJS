<? if(!defined('UC_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>

<script src="js/common.js" type="text/javascript"></script>
<div class="container">
	<h3 class="marginbot">
		<a href="admin.php?m=feed&a=ls" class="sgbtn">�¼��б�</a>
		֪ͨ�б�
		<? if($user['allowadminlog'] || $user['isfounder']) { ?><a href="admin.php?m=log&a=ls" class="sgbtn">��־�б�</a><? } ?>
		<a href="admin.php?m=mail&a=ls" class="sgbtn">�ʼ�����</a>
	</h3>
	<? if($status == 2) { ?>
		<div class="correctmsg"><p>֪ͨ�б�ɹ����¡�</p></div>
	<? } ?>
	<div class="mainbox">
		<? if($notelist) { ?>
			<form action="admin.php?m=note&a=ls" method="post">
			<input type="hidden" name="formhash" value="<?=FORMHASH?>">
			<table class="datalist" onmouseover="addMouseEvent(this);" style="table-layout:fixed">
				<tr>
					<th width="60"><input type="checkbox" name="chkall" id="chkall" onclick="checkall('delete[]')" class="checkbox" /><label for="chkall">ɾ��</label></th>
					<th width="130">����</th>
					<th width="60">֪ͨ����</th>
					<th width="50">����</th>
					<th width="140">���֪ͨʱ��</th>
					<? foreach((array)$applist as $app) {?>
						<? if($app['recvnote']) { ?>
							<th width="100"><?=$app['name']?></th>
						<? } ?>
					<? } ?>
				</tr>
				<? foreach((array)$notelist as $note) {?>
					<? $debuginfo = htmlspecialchars(str_replace(array("\n", "\r", "'"), array('', '', "\'"), $note['getdata'].$note['postdata2'])); ?>
					<tr>
						<td><input type="checkbox" name="delete[]" value="<?=$note['noteid']?>" class="checkbox" /></td>
						<td><strong><?=$note['operation']?></strong></td>
						<td><?=$note['totalnum']?></td>
						<td><a href="###" onclick="alert('<?=$debuginfo?>');">�鿴</a></td>
						<td><?=$note['dateline']?></td>
						<? foreach((array)$applist as $appid => $app) {?>
							<? if($app['recvnote']) { ?>
								<td><?=$note['status'][$appid]?></td>
							<? } ?>
						<?}?>
					</tr>
				<? } ?>
				<tr class="nobg">
					<td><input type="submit" value="�� ��" class="btn" /></td>
					<td class="tdpage" colspan="<? echo count($applist) + 4;?>"><?=$multipage?></td>
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

<? include $this->gettpl('footer');?>