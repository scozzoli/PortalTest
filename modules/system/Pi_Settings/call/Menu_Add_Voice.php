<?php
	//$ini = parse_ini_file($pr->getRootPath('settings/menu/'.$pr->post('menu').'.ini'),true);
	//create_ini_file($ini,$pr->getRootPath('settings/menu/'.$pr->post('menu').'.ini'),true);
	$menu_list = $sysConfig->loadMenu();
	$menu = $pr->post('menu');
	$id = strtoupper($pr->post('New-Id')); //Gli id li mantengo tutti uppercase
	if(isset($menu_list[$menu][$id])){$pr->addAlertBox('Il codice ordinamento esiste gi&aacute;!')->set('CloseWin',false)->response();}
	$menu_list[$menu][$id]['BASE64'] = $pr->post('BASE64');
	$menu_list[$menu][$id]['list'] = Array();
	$menu_list[$menu][$id]['des'] = ($pr->post('BASE64')==1 ? base64_encode($pr->post('des')) : $pr->post('des'));
	$sysConfig->saveMenu($menu_list);
	$pr->addScript('pi.requestOnLoad("Menu_Action_Info","Menu_Load_Dett");')->response();
?>