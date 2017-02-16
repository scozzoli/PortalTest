<?php
	$mod_list = $sysConfig->loadMod();
	$i18n = $sysConfig->loadI18n();
	if(trim($pr->post('New-Id')) == ''){$pr->addAlertBox('<i18n>mod:err:notEmpty</i18n>')->set('CloseWin',false)->response();}
	if($pr->post('New-Id') != $pr->post('Old-Id')){
		if(isset($mod_list[$pr->post('New-Id')])){$pr->addAlertBox("<i18n>mod:err:alreadyExists;".$pr->post("New-Id")."</i18n>")->set('CloseWin',false)->response();}
		unset($mod_list[$pr->post('Old-Id')]);
	}
	$mod_list[$pr->post('New-Id')] = array(
		'nome' 	=> Array(),// $pr->post('nome'),
		'des'	=> Array(),// $pr->post('des'),
		'path'	=> $pr->post('path'),
		'icon'	=> $pr->post('icon'),
		'stato' => $pr->post('stato'),
		'grp'	=> $pr->post('grp'));
	
	foreach($i18n['langs'] as $k => $v){
		$mod_list[$pr->post('New-Id')]['nome'][$k] = $pr->post("nome_{$k}");
		$mod_list[$pr->post('New-Id')]['des'][$k] = $pr->post("des_{$k}");
	}
	
	$sysConfig->saveMod($mod_list);
	$pr->addScript('pi.requestOnLoad(\'cerca_modulo\');')->response();
?>