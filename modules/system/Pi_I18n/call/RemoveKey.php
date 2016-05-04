<?php
	//$id = $pr->post('removeid',false);
	
	switch($pr->post('scope')){
		case 'local'  : 
			$modList = $sysConfig->loadMod();
			$i18n->openDic($pr->getRootPath('modules/'.$modList[$pr->post('module')]['path'].'/'));
			break;
		case 'defaults' :	
			$i18n->openDic($pr->getRootPath('i18n/'),'defaults')->getDic();
			break;
		case 'common' :	
			$dic = $i18n->openDic($pr->getRootPath('i18n/'),'common')->getDic();
			break;
	}
	
	$i18n->removeKey($pr->post('key'));
	$i18n->saveDic();
	
	//if($id){
	//	$pr->addScript("$('#{$id}').remove();");
	//}
	if($pr->post('containerId',false) !== false){
		$out = getModuleKeyList($pr->post('module'),$pr->post('containerId'), $i18n->getConfig(),$i18n->getDic(),$pr->post('scope'));
		$pr->addHtml('container_'.$pr->post('containerId'),$out)->response();
	}else{
		$pr->addInfoBox('<i18n>removeKeyDone</i18n>')->response();
	}
?>