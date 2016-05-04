<?php
	$dic = $i18n->openDic($pr->getRootPath('i18n/'),'defaults')->getDic();

	$out = '<div class="panel">
	<div class="header"> <i18n>def:pageTitle</i18n> </div>
	<div class="focus blue">
	<table class="form" id="general_action_def">
		<tr>
			<th><i18n>lblAddKey</i18n></th>
			<td>
				<input type="hidden" name="module" value="">
				<input type="hidden" name="containerId" value="def">
				<input type="hidden" name="scope" value="defaults">
				<input type="text" name="newkey" class="j-todel">
			</td>
			<td><button onclick="pi.request(\'general_action_def\',\'AddKey\'); $(\'#general_action_def\').find(\'.j-todel\').val(\'\')"><i18n>addKeyButton</i8n></button></td>
			<th><button onclick="pi.chk(\'<i18n>chk:removeAllUnusedKey</i18n>\').request(\'general_action_def\',\'RemoveAllUnusedKey\')"><i18n>removeEmptyKeyButton</i8n></button></th>
		</tr>
	</table>
	</div>
	<br>';
		
	$config = $i18n->getConfig();
	$out .= getModuleKeyList('','def',$config,$dic,'defaults');
	
	$out .= '</div></div>';
	$pr->addHtml('container',$out)->response();
?>