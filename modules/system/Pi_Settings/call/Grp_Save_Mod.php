<?php
	$mod_list = $sysConfig->loadMod();
	$mod_list[$pr->post('id')]['grp'] = $pr->post('grp');
	$sysConfig->saveMod($mod_list);
	$pr->addScript('pi.requestOnLoad("cerca_gruppo");')->response();
?>