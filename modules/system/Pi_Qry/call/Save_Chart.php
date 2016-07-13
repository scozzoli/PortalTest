<?php

	$charts = json_decode($pr->post('charts'),true);
	$oldName = $pr->post('oldName');

	if(trim($pr->post('name')) == ''){
		$pr->set('CloseWin',false)->addAlertBox('<i18n>err:required;Nome</i18n>')->response();
	}

	if($oldName == ''){ // se è nuovo
		$type = $pr->post('type') == 'mixed' ? 'bar' : $pr->post('type');
		$data = Array('data' => Array(
				'src' => '',
				'type' => $type,
				'color' => ''
			)
		);
	}else{ // modifica di uno esistente
		if($oldName!= $pr->post('name')){ // Cambiamento di id
			if(isset($charts[$pr->post('name')])){
				$pr->set('CloseWin',false)->addAlertBox('<i18n>err:chartExists;'.$pr->post('name').'</i18n>')->response();
			}
			$data = $charts[$oldName]['data'];
			unset($charts[$oldName]);
		}else{
			$data = $charts[$pr->post('name')]['data'];
		}

		if($charts[$oldName]['type'] != $pr->post('type')){
			if($pr->post('type') == 'pie' || $pr->post('type') == 'nut' || $pr->post('type') == 'polar'){
				$done = false;
				foreach($data as $k => $v){
					if($done){
						unset($data[$k]);
					}else{
						$done = true;
						$data[$k]['type'] = $pr->post('type');
					}
				}
			}else{
				foreach($data as $k => $v){
					if($pr->post('type') == 'mixed'){
						if($data[$k]['type'] != 'bar' && $data[$k]['type'] != 'line' && $data[$k]['type'] == 'area'){
							$data[$k]['type'] = 'bar';
						}
					}else{
						$data[$k]['type'] = $pr->post('type');
					}
				}
			}
		}
	}

	$charts[$pr->post('name')] = Array(
		'des' => $pr->post('des'),
		'size' => $pr->post('size'),
		'type' => $pr->post('type'),
		'labels' => $pr->post('labels'),
		'color' => $pr->post('color'),
		'data' => $data
	);

	ksort($charts);

	$fill = Array('charts' => json_encode($charts) );

	$pr->addHtml('chartsList',createChartTable($charts))->addFill('qryDataFormChart',$fill)->response();

?>
