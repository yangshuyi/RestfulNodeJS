<? if(!defined('UC_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('plugin_header');?>
<? if($modifiedfiles > 0) { ?>
	<a href="###" onclick="showresult('modify')"><em class="edited">���޸�: <?=$modifiedfiles?></em></a>&nbsp;&nbsp;
<? } ?>
<? if($deletedfiles > 0) { ?>
	<a href="###" onclick="showresult('del')"><em class="edited">��ɾ��: <?=$deletedfiles?></em></a>&nbsp;&nbsp;
<? } ?>
<? if($unknownfiles > 0) { ?>
	<a href="###" onclick="showresult('add')"><em class="edited">δ֪: <?=$unknownfiles?></em></a>&nbsp;&nbsp;
<? } ?>
<? if($doubt > 0) { ?>
	<a href="###" onclick="showresult('doubt')"><em class="edited">һ���ڱ��޸�: <?=$doubt?></em></a>&nbsp;&nbsp;
<? } ?>

<?=$result?>

<? include $this->gettpl('plugin_footer');?>