<?php
	$grp_list = $sysConfig->loadGrp();
	if(isset($grp_list[$pr->post('ID')])){$pr->addAlertBox('Il codice Gruppo inserito non &eacute; univoco.')->response();}
	$grp_list[$pr->post('ID')] = array('nome' => $pr->post('nome'), 'des' => $pr->post('des'));
	$sysConfig->saveGrp($grp_list);
	$pr->addScript('pi.requestOnLoad("cerca_gruppo");')->response();
?>