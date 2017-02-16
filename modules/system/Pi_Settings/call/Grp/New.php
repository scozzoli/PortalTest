<?php
	$grp_list = $sysConfig->loadGrp();
	if(isset($grp_list[$pr->post('id')])){$pr->addAlertBox('<i18n>grp:err:codeNotUnique</i18n>')->response();}
	//$grp_list[$pr->post('id')] = array('nome' => $pr->post('nome'), 'des' => $pr->post('des'));
	
	$i18n = $sysConfig->loadI18n();
	
	$grp_list[$pr->post('id')] = array('nome' => array(), 'des' => array());
	
	foreach($i18n['langs'] as $k => $v){
		$grp_list[$pr->post('id')]['nome'][$k] = $pr->post("nome_{$k}");
		$grp_list[$pr->post('id')]['des'][$k] = $pr->post("des_{$k}");
	}
	
	$sysConfig->saveGrp($grp_list);
	$pr->addScript('pi.requestOnLoad("cerca_gruppo");')->response();
?>