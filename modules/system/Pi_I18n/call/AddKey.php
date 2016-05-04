<?php
	$modList = $sysConfig->loadMod();
	
	switch($pr->post('scope')){
		case 'local'  : 
			$dic = $i18n->openDic($pr->getRootPath('modules/'.$modList[$pr->post('module')]['path'].'/'))->getDic();
			break;
		case 'defaults' :	
			$dic = $i18n->openDic($pr->getRootPath('i18n/'),'defaults')->getDic();
			break;
		case 'common' :	
			$dic = $i18n->openDic($pr->getRootPath('i18n/'),'common')->getDic();
			break;
	}
	
	$i18n->addKey($pr->post('newkey'));
	
	$i18n->saveDic();
	
	$out = getModuleKeyList($pr->post('module'),$pr->post('containerId'), $i18n->getConfig(),$i18n->getDic(),$pr->post('scope'));
	$pr->addHtml('container_'.$pr->post('containerId'),$out)->addInfoBox('<i18n>resp:keyAdded;'.$pr->post('newkey').'</i18n>')->response();
?>