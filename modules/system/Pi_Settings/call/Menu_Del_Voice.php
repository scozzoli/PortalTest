<?php
	//$ini = parse_ini_file($pr->getRootPath('settings/menu/'.$pr->post('menu').'.ini'),true);
	//unset($ini[$pr->post('Old-Id')]);
	//create_ini_file($ini,$pr->getRootPath('settings/menu/'.$pr->post('menu').'.ini'),true);
	
	$menu_list = $sysConfig->loadMenu();
	unset($menu_list[$pr->post('menu')][$pr->post('Old-Id')]);
	$sysConfig->saveMenu($menu_list);
	$pr->addScript('pi.requestOnLoad("Menu_Action_Info","Menu_Load_Dett");')->response();
?>