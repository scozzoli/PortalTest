<?php

	$charts = json_decode($pr->post('charts'),true);
	$oldName = $pr->post('oldName');
	$iType = substr($pr->post('type'), 4);
	$iCollection = substr($pr->post('type'), 0, 3);

	if(trim($pr->post('name')) == ''){
		$pr->set('CloseWin',false)->addAlertBox('<i18n>err:required;Nome</i18n>')->response();
	}

	if($oldName == ''){ // se è nuovo
		$type = $iType == 'mixed' ? 'bar' : $iType;
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

		if($charts[$oldName]['type'] != $iType){
			if($iType == 'pie' || $iType == 'nut' || $iType == 'polar'){
				$done = false;
				foreach($data as $k => $v){
					if($done){
						unset($data[$k]);
					}else{
						$done = true;
						$data[$k]['type'] = $iType;
					}
				}
			}else{
				foreach($data as $k => $v){
					if($iType == 'mixed'){
						if($data[$k]['type'] != 'bar' && $data[$k]['type'] != 'line' && $data[$k]['type'] == 'area'){
							$data[$k]['type'] = 'bar';
						}
					}else{
						$data[$k]['type'] = $iType;
					}
				}
			}
		}
	}

	$charts[$pr->post('name')] = [
		'des' => $pr->post('des'),
		'size' => $pr->post('size'),
		'type' => $iType,
		'labels' => $pr->post('labels'),
		'color' => $pr->post('color'),
		'collection' => $iCollection,
		'data' => $data,
		'cols' => explode(',',$pr->post('cols'))
	];

	ksort($charts);

	$fill = ['charts' => json_encode($charts) ];

	$pr->addHtml('chartsList',createChartTable($charts))->addFill('qryDataFormChart',$fill)->response();

?>
