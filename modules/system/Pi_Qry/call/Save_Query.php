<?php
	$filename = $pr->post('filename');

	$aSpecial = Array(' ','.','\\','/',"'",'"','!');
	$aReplace = Array('_','_','_','_','','','');

	$newName = $pr->post('grp').'.'.str_replace($aSpecial,$aReplace,$pr->post('name')).'.json';

	if(trim($newName) == ''){
		$pr->alert("<i18n>err:required;Nome</i18n>");
	}
	
	$interrogazione = Array(
		'des' => $pr->post('des'),
		'enabled' => $pr->post('enabled') == 1,
		'null' => $pr->post('null'),
		'db' => $pr->post('db'),
		'color' => $pr->post('color'),
		'html' => $pr->post('html'),
		'xls' => $pr->post('xls'),
		'icon' => $pr->post('icon'),
		'qry' => $pr->post('qry'),
		'inputs' => json_decode($pr->post('inputs'),true),
		'metadata' => json_decode($pr->post('metadata'),true), 
		'php' => json_decode($pr->post('php'),true),
		'chartsize' => $pr->post('chartsize'),
		'charts'  => json_decode($pr->post('charts'),true)
	);

	if($filename != $newName){
		if(file_exists($pr->getLocalPath("script/{$newName}"))){
			$pr->alert("<i18n>err:existsInGroup;".$pr->post('name').";".$pr->post('grp')."</i18n>");
		}
		if(file_exists($pr->getLocalPath("script/{$filename}")) && ($filename != '')){
			unlink($pr->getLocalPath("script/{$filename}"));
		}
	}

	file_put_contents($pr->getLocalPath("script/{$newName}"),json_encode($interrogazione,JSON_PRETTY_PRINT));

	$pr->addScript("pi.requestOnLoad('data','Cerca');")->response();

?>
