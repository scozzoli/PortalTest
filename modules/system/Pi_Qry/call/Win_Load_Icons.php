<?php
	$params = Array(
		'imgSelect' => $pr->post('icon'),
		'callSelector' => 'JS_Update_Icon'
	);
	
	$pr->nextCommon('system/Win_MDI_Selector',$params);
?>