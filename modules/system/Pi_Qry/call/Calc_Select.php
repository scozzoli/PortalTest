<?php
	$inputs = json_decode($pr->post('inputs'),true);
	$idSel = $pr->post('inputIdForMod');
	
	$inputs[$idSel]['select'] = json_decode($pr->post('select'),true);
	ksort($inputs[$idSel]['select']);
	
	if(!$inputs[$idSel]['select'][$inputs[$idSel]['default']]){
		$inputs[$idSel]['default'] = '';
		$htmlInputs = createInputsTable($inputs);
		$pr->addHtml('inputList',$htmlInputs);
	}
	
	$fill = Array( 'inputs' => json_encode($inputs) );
	$pr->addFill('qryDataForm',$fill)->response();
?>