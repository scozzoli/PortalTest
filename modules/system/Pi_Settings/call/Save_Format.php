<?php
	$newFormat = $pr->post('format');
	$oldFormat = $pr->post('old');
	
	if($newFormat == $oldFormat){
		$pr->addInfoBox('Nessuna modifica al formato necessaria')->response();
	}
	
	$menu = $sysConfig->loadMenu();
	$usr = $sysConfig->loadUsr();
	$grp = $sysConfig->loadGrp();
	$mod = $sysConfig->loadMod();
	$db = $sysConfig->loadDB();
	
	$sysConfig->set('type',$newFormat);
	
	$sysConfig->saveMenu($menu);
	$sysConfig->saveUsr($usr);
	$sysConfig->saveGrp($grp);
	$sysConfig->saveMod($mod);
	$sysConfig->saveDB($db);
	
	$sysConfig->saveFormat($newFormat);
	
	$sysConfig->clean($oldFormat);
	
	$pr->addInfoBox("File di configurazione cambiati da <b>{$oldFormat}</b> a <b>{$newFormat}</b>")->response();
?>