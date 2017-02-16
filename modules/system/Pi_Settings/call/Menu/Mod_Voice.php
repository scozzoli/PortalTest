<?php
	//$ini = parse_ini_file($pr->getRootPath('settings/menu/'.$pr->post('menu').'.ini'),true);
	//create_ini_file($ini,$pr->getRootPath('settings/menu/'.$pr->post('menu').'.ini'),true);
	$id = strtoupper($pr->post('New-Id')); //Gli id li mantengo tutti uppercase
	$oid = $pr->post('Old-Id');
	
	$menu_list = $sysConfig->loadMenu();
	$i18n = $sysConfig->loadI18n();
	$menu = $pr->post('menu');
	
	if($id == ''){
		$pr->addAlertBox('<i18n>menu:err:codeNull</i18n>')->set('CloseWin',false)->response();
	}
	
	if($oid != $id){
		if(isset($menu_list[$menu][$id])){$pr->addAlertBox('<i18n>menu:err:codeExist</i18n>')->set('CloseWin',false)->response();}
	}
	
	$menu_list[$menu][$id]['hidden'] = $pr->post('hidden');
	$menu_list[$menu][$id]['list'] = $menu_list[$menu][$oid]['list'] ?: Array();
	
	foreach($i18n['langs'] as $k => $v){
		$menu_list[$menu][$id]['des'][$k] = $pr->post("des_{$k}");
	}
	
	if($oid != $id){
		unset($menu_list[$menu][$oid]);
	}
	
	$sysConfig->saveMenu($menu_list);
	$pr->addScript('pi.requestOnLoad("Menu_Action_Info","Menu/Load_Dett");')->response();
?>