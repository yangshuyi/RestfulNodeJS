<? if(!defined('UC_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>
<? if(empty($_REQUEST['inajax'])) { ?>
	<div class="container">
		<div class="ajax rtninfo">
			<div class="ajaxbg">
				<h4>��ʾ��Ϣ:</h4>
				<p><?=$message?></p>
				<? if($redirect == 'BACK') { ?>
					<p><a href="###" onclick="history.back();">������ﷵ��</a></p>
				<? } elseif($redirect) { ?>
					<p><a href="<?=$redirect?>">ҳ�潫�� 3 ����Զ���ת����һҳ���������ֱ����ת...</a></p>
					<script type="text/javascript">
					function redirect(url, time) {
						setTimeout("window.location='" + url + "'", time * 1000);
					}
					redirect('<?=$redirect?>', 3);
					</script>
				<? } ?>
			</div>
		</div>
	</div>
<? } else { ?>
	<?=$message?>
<? } ?>
<? include $this->gettpl('footer');?>