<?php
	$grp_list = $sysConfig->loadGrp();
	$i18n = $sysConfig->loadI18n();
	
	$grp_list[$pr->post('id')] = array('nome' => array(), 'des' => array());
	
	foreach($i18n['langs'] as $k => $v){
		$grp_list[$pr->post('id')]['nome'][$k] = $pr->post("nome_{$k}");
		$grp_list[$pr->post('id')]['des'][$k] = $pr->post("des_{$k}");
	}
	
	$sysConfig->saveGrp($grp_list);
	$pr->addScript('pi.requestOnLoad("cerca_gruppo");')->response();
?>