<?php
	//$id = $pr->post('callbackid');
	$txt = trim($pr->post('txt'));
	
	$modList = $sysConfig->loadMod();
	
	switch($pr->post('scope')){
		case 'local'  : 
			$dic = $i18n->openDic($pr->getRootPath('modules/'.$modList[$pr->post('module')]['path'].'/'))->getDic();
			break;
		case 'defaults' :	
			$dic = $i18n->openDic($pr->getRootPath('i18n/'),'defaults')->getDic();
			break;
		case 'common' :	
			$dic = $i18n->openDic($pr->getRootPath('i18n/'),'common')->getDic();
			break;
	}
	
	$i18n->updateValue($pr->post('key'),$pr->post('lang'),$txt);
	$i18n->saveDic();
		
	//if($txt == ''){
	//	$js = " $('#{$id}').attr('class','orange').css('text-align','center'); 
	//	$('#{$id}').find('.j-icon').attr('class','mdi mdi-close l2 j-icon orange'); 
	//	$('#{$id}').find('.j-prev').html(''); ";
	//}else{
	//	$js = " $('#{$id}').attr('class','blue').css('text-align','left'); 
	//	$('#{$id}').find('.j-icon').attr('class','mdi mdi-check l2 j-icon blue'); 
	//	$('#{$id}').find('.j-prev').html('".substr($txt,0,50)."'); ";
	//}
	
	$out = getModuleKeyList($pr->post('module'),$pr->post('containerId'), $i18n->getConfig(),$i18n->getDic(),$pr->post('scope'));
	$pr->addHtml('container_'.$pr->post('containerId'),$out)->response();
	//$pr->addScript($js)->response();
?>