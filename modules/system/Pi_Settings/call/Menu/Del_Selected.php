<?php
	//unlink($pr->getRootPath('settings/menu/'.$pr->post('menu').'.ini')) or $pr->addErrorBox('Errore nella cancellazione del menu')->response();
	$usr_list = $sysConfig->loadUsr();
	$menu_list = $sysConfig->loadMenu();
	
	foreach($usr_list as $k => $v){
		if(!isset($usr[$v['menu']])){$usr[$v['menu']]=0;}
		$usr[$v['menu']]++;
	}
	if(isset($usr[$pr->post('menu')])){
		$pr->addAlertBox('<i18n>menu:err:menuUsed;'.$usr[$pr->post('menu')].'</i18n>')->response();
	}
	unset($menu_list[$pr->post('menu')]);
	$sysConfig->saveMenu($menu_list);
	$pr->addScript('pi.requestOnLoad(null,"Menu/Load_Interface");')->response();
?>