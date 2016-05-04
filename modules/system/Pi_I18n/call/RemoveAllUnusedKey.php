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
	
	foreach($dic as $k =>$lang){
		$toKeep = false;
		foreach($lang as $kl => $v){
			$toKeep = $toKeep || ($v != '');
		}
		
		if(!$toKeep){
			$i18n->removeKey($k);
		}
	}
	
	$i18n->saveDic();
	
	$out = getModuleKeyList($pr->post('module'),$pr->post('containerId'), $i18n->getConfig(),$i18n->getDic(),$pr->post('scope'));
	$pr->addHtml('container_'.$pr->post('containerId'),$out)->response();
	
?>