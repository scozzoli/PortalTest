<?php
	//unlink($pr->getRootPath('settings/menu/'.$pr->post('menu').'.ini')) or $pr->addErrorBox('Errore nella cancellazione del menu')->response();
	$usr_list = $sysConfig->loadUsr();
	$menu_list = $sysConfig->loadMenu();
	
	foreach($usr_list as $k => $v){
		if(!isset($usr[$v['menu']])){$usr[$v['menu']]=0;}
		$usr[$v['menu']]++;
	}
	if(isset($usr[$pr->post('menu')])){
		$pr->addAlertBox('Ci sono ancora <b class="red">'.$usr[$pr->post('menu')].'</b> utenti con questo menu associato. <br> Per poter eliminare un men&uacute; questo non deve essere usato da nessuno!')->response();
	}
	unset($menu_list[$pr->post('menu')]);
	$sysConfig->saveMenu($menu_list);
	$pr->addScript('pi.requestOnLoad(null,"Menu_Load_Interface");')->response();
?>