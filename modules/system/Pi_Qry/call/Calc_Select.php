<?php
	$inputs = json_decode($pr->post('inputs'),true);
	$idSel = $pr->post('inputIdForMod');
	
	$inputs[$idSel]['select'] = json_decode($pr->post('select'),true);
	$inputs[$idSel]['sort'] = $pr->post('sort','key');
	$inputs[$idSel]['showKey'] = $pr->post('showKey','1') == '1';

	if( $inputs[$idSel]['sort'] == 'key'){
		ksort($inputs[$idSel]['select'], SORT_NATURAL);
	}else{
		asort($inputs[$idSel]['select'], SORT_NATURAL);
	}
	
	if(!$inputs[$idSel]['select'][$inputs[$idSel]['default']]){
		$inputs[$idSel]['default'] = '';
		$htmlInputs = createInputsTable($inputs);
		$pr->addHtml('inputList',$htmlInputs);
	}
	
	$fill = Array( 'inputs' => json_encode($inputs) );
	$pr->addFill('qryDataForm',$fill)->response();
?>