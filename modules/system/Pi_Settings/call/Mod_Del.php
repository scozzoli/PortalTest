<?php
	$mod_list = $sysConfig->loadMod();
	unset($mod_list[$pr->post('Mid')]);
	$sysConfig->saveMod($mod_list);
	$pr->addScript('pi.requestOnLoad(\'cerca_modulo\');')->response();
?>