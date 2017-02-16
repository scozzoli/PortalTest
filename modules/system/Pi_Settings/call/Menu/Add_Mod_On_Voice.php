<?php
	//$ini = parse_ini_file($pr->getRootPath('settings/menu/'.$pr->post('menu').'.ini'),true);
	//$ini[$pr->post('voice')]['list'][] = $pr->post('mod');
	//create_ini_file($ini,$pr->getRootPath('settings/menu/'.$pr->post('menu').'.ini'),true);
	
	$menu_list = $sysConfig->loadMenu();
	$menu_list[$pr->post('menu')][$pr->post('voice')]['list'][] = $pr->post('mod');
	$sysConfig->saveMenu($menu_list);
	
	$pr->addScript('pi.requestOnLoad("Menu_Action_Info","Menu/Load_Dett");')->response();
?>