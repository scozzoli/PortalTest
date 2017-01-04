<?php

	$charts = json_decode($pr->post('charts'),true);
	$oldName = $pr->post('oldName');

	if(trim($pr->post('name')) == ''){
		$pr->set('CloseWin',false)->addAlertBox('<i18n>err:required;Nome</i18n>')->response();
	}

	if($oldName != '' && $oldName != $pr->post('name')){
		if(isset($charts[$pr->post('chartKey')]['data'][$pr->post('name')])){
			$pr->set('CloseWin',false)->addAlertBox('<i18n>err:chartExists;'.$pr->post('name').'</i18n>')->response();
		}
		unset($charts[$pr->post('chartKey')]['data'][$oldName]);
	}

	$idx = 0;
	$cols = [];
	while($pr->post('md-'.$idx,false) !== false){
		if($pr->post('md-'.$idx) == 1){
			$cols[] = $pr->post('mdv-'.$idx);
		}
		$idx++;
	}
	
	$charts[$pr->post('chartKey')]['cols'] = $cols;

	$charts[$pr->post('chartKey')]['data'][$pr->post('name')] = Array(
		'src' => $pr->post('src'),
		'type' => $pr->post('type'),
		'color' => $pr->post('color'),
	);

	ksort($charts[$pr->post('chartKey')]['data']);

	$fill = Array('charts' => json_encode($charts) );

	$pr->addHtml('chartsList',createChartTable($charts))->addFill('qryDataFormChart',$fill)->response();

?>
