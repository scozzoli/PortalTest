<?php
	//$ini = parse_ini_file($pr->getRootPath('settings/menu/'.$pr->post('menu').'.ini'),true);
	//array_put($ini[$pr->post('voice')]['list'],$pr->getNumber('pos_from',PiRespose::GET_NUM_INT),$pr->getNumber('pos_to',PiRespose::GET_NUM_INT)-1);
	//create_ini_file($ini,$pr->getRootPath('settings/menu/'.$pr->post('menu').'.ini'),true);
	
	$menu_list = $sysConfig->loadMenu();
	array_put($menu_list[$pr->post('menu')][$pr->post('voice')]['list'],$pr->getNumber('pos_from',PiRespose::GET_NUM_INT),$pr->getNumber('pos_to',PiRespose::GET_NUM_INT)-1);
	$sysConfig->saveMenu($menu_list);
	$pr->addScript('pi.requestOnLoad("Menu_Action_Info","Menu_Load_Dett");')->response();
?>