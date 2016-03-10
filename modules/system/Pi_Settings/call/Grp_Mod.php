<?php
	$grp_list = $sysConfig->loadGrp();
	$grp_list[$pr->post('ID')] = array('nome'=>$pr->post('nome'),'des'=>$pr->post('des'));
	$sysConfig->saveGrp($grp_list);
	$pr->addScript('pi.requestOnLoad("cerca_gruppo");')->response();
?>