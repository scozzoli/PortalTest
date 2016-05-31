<?php
	$modList = $sysConfig->loadMod();
	
	switch($pr->post('scope')){
		case 'local'  : 
			$dic =  $i18n->openDic($pr->getRootPath('modules/'.$modList[$pr->post('module')]['path'].'/'))->getDic();
			break;
		case 'defaults' :	
			$dic = $i18n->openDic($pr->getRootPath('i18n/'),'defaults')->getDic();
			break;
		case 'common' :	
			$dic = $i18n->openDic($pr->getRootPath('i18n/'),'common')->getDic();
			break;
	}
	
	$header = '<i18n>winedit:title;'.$pr->post('key').'</i18n>';
	$content = '<div class="focus blue"><i18n>winedit:info</i18n></div>
		<div id="Win_Edit_Lang" style="font-size:14px;">
			<input type="hidden" name="Q" value="ModLocalTrans">
			<input type="hidden" name="key" value="'.$pr->post('key').'">
			<input type="hidden" name="module" value="'.$pr->post('module').'">
			<input type="hidden" name="lang" value="'.$pr->post('lang').'">
			<input type="hidden" name="scope" value="'.$pr->post('scope').'">
			<input type="hidden" name="containerId" value="'.$pr->post('containerId').'">
			<textarea data-pic="markdowneditor : { autofocus : true }" name="txt">'.$dic[$pr->post('key')][$pr->post('lang')].'</textarea>
		</div>';
	$footer = '<button class="red" onClick="pi.win.close();"><i18n>cancel</i18n></button>
	<button class="blue" onclick="pi.requestOnModal(\'Win_Edit_Lang\')"><i18n>save</i18n></button>';
	
	$pr->addWindow(600,0,$header,$content,$footer)->response();
?>