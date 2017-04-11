<?php
	$inputs = json_decode($pr->post('inputs'),true);
	$idSel = $pr->post('inputIdForMod');
	
	$inputs[$idSel]['des'] = $pr->post('des');
	$inputs[$idSel]['type'] = $pr->post('type');
	$inputs[$idSel]['default'] = $pr->post('default');
	$inputs[$idSel]['required'] = $pr->post('required') == 1;
	$inputs[$idSel]['note'] = $pr->post('note');

	$htmlInputs = createInputsTable($inputs);
	
	$fill = Array( 'inputs' => json_encode($inputs) );
	$pr->addHtml('inputList',$htmlInputs)->addFill('qryDataForm',$fill)->response();
?>