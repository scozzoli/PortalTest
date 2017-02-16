<?php
	$mod_list = $sysConfig->loadMod();
	$mod_list[$pr->post('Mid')]['icon'] = $pr->post('Ico');
	$sysConfig->saveMod($mod_list);
	$pr->addScript('pi.requestOnLoad(\'cerca_modulo\');')->response();
?>