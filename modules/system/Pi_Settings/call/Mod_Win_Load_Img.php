<?php
	/*
		Modulo Common
	*/ 
	$mod_list = $sysConfig->loadMod();
	
	$params = Array(
		'imgSelect' => $mod_list[$pr->post('ID')]['icon'],
		'callSelector' => 'Mod_Save_Img',
		'callHiddenVars' => Array( 'Mid' => $pr->post('ID') )
	);
	
	$pr->nextCommon('system/Win_MDI_Selector',$params);
	
?>