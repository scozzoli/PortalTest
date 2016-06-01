<?php
	//$ini = parse_ini_file($pr->getRootPath('settings/menu/'.$pr->post('menu').'.ini'),true);
	//create_ini_file($ini,$pr->getRootPath('settings/menu/'.$pr->post('menu').'.ini'),true);
	$menu_list = $sysConfig->loadMenu();
	$i18n = $sysConfig->loadI18n();
	$menu = $pr->post('menu');
	$id = strtoupper($pr->post('New-Id')); //Gli id li mantengo tutti uppercase
	if(isset($menu_list[$menu][$id])){$pr->addAlertBox('<i18n>menu:err:codeExist</i18n>')->set('CloseWin',false)->response();}
	$menu_list[$menu][$id]['hidden'] = $pr->post('hidden');
	$menu_list[$menu][$id]['list'] = Array();
	
	foreach($i18n['langs'] as $k => $v){
		$menu_list[$menu][$id]['des'][$k] = $pr->post("des_{$k}");
	}
	$sysConfig->saveMenu($menu_list);
	$pr->addScript('pi.requestOnLoad("Menu_Action_Info","Menu_Load_Dett");')->response();
?>