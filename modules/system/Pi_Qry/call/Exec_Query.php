<?php
	if($pr->post('db') != ""){
		$db = new PiDB($pr->getDB($pr->post('db')));
	}
	
	$res = $db->exec($pr->post('qry'),true);
	
	$pr->addInfoBox("Record interessati dalla query: <b>{$db->opt('numrow')}</b>")->response();
?>