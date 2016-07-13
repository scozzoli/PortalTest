<?php

	$charts = json_decode($pr->post('charts'),true);
	$oldName = $pr->post('oldName');

	unset($charts[$oldName]);

	ksort($charts);

	$fill = Array('charts' => json_encode($charts) );

	$pr->addHtml('chartsList',createChartTable($charts))->addFill('qryDataFormChart',$fill)->response();

?>
