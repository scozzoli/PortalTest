<?php
	$grp_list = $sysConfig->loadGrp();
	unset($grp_list[$pr->post('ID')]);
	$sysConfig->saveGrp($grp_list);
	$pr->addScript('pi.requestOnLoad("cerca_gruppo");')->response();
?>