<?php
	if($pr->post('db') != ""){
		$db = new PiDB($pr->getDB($pr->post('db')));
	}
	
	$res = $db->exec($pr->post('qry'),true);
	
	$pr->addInfoBox("<i18n>msg:recordNumber;{$db->opt('numrow')}</i18n>")->response();
?>