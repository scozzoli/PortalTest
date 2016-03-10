<?php
	$mod_list = $sysConfig->loadMod();
	if(trim($pr->post('New-Id')) == ''){$pr->addAlertBox('Il codice del modulo non deve essere vuoto!')->set('CloseWin',false)->response();}
	if($pr->post('New-Id') != $pr->post('Old-Id')){
		if(isset($mod_list[$pr->post('New-Id')])){$pr->addAlertBox("Il nuovo codice modulo <i class=\"green\">".$pr->post("New-Id")."</i> esiste gi&aacute;!")->set('CloseWin',false)->response();}
		unset($mod_list[$pr->post('Old-Id')]);
	}
	$mod_list[$pr->post('New-Id')] = array(
		'nome' 	=> $pr->post('nome'),
		'des'	=> $pr->post('des'),
		'path'	=> $pr->post('path'),
		'icon'	=> $pr->post('icon'),
		'stato' => $pr->post('stato'),
		'grp'	=> $pr->post('grp'));
	$sysConfig->saveMod($mod_list);
	$pr->addScript('pi.requestOnLoad(\'cerca_modulo\');')->response();
?>