<?php
	//$ini = parse_ini_file($pr->getRootPath('settings/menu/'.$pr->post('menu').'.ini'),true);
	//create_ini_file($ini,$pr->getRootPath('settings/menu/'.$pr->post('menu').'.ini'),true);
	$menu_list = $sysConfig->loadMenu();
	$menu = $pr->post('menu');
	$max = count($menu_list[$menu][$pr->post('voice')]['list'])-1;
	array_put($menu_list[$menu][$pr->post('voice')]['list'],$pr->getNumber('pos_from',PiRespose::GET_NUM_INT),(int)$max);
	unset($menu_list[$menu][$pr->post('voice')]['list'][$max]);
	$sysConfig->saveMenu($menu_list);
	$pr->addScript('pi.requestOnLoad("Menu_Action_Info","Menu/Load_Dett");')->response();
?>