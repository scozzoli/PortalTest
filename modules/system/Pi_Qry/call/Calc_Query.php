<?php
	preg_match_all('/\{.*?\}/s',$pr->post('qry'),$params);
	$inputs = json_decode($pr->post('inputs'),true);
	$newInputs = Array();
	$defInput = Array(
		'des' => 'nuovo input',
		'note' => '',
		'required' => false,
		'default' => '',
		'type' => 'string'
	);
	
	if(isset($params[0])){
		asort($params[0]);
		foreach($params[0] as $k => $v){
			if(isset($newInputs[$v])){ continue; }
			$newInputs[$v] = $inputs[$v] ?: $defInput;
		}		
	}
	
	$htmlInputs = createInputsTable($newInputs);
	
	$fill = Array(
		'inputs' => json_encode($newInputs),
		'qry' => $pr->post('qry')
		);
	$pr->addHtml('inputList',$htmlInputs)->addFill('qryDataForm',$fill)->response();
?>