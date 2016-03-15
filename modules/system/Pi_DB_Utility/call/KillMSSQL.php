<?php
	$id = $pr->post('kill');
	$dbConfig = $pr->getDB($pr->post('db'));
	$db = new PiDB($dbConfig,$pr);
	
	$qry="KILL {$id}";
	$db->exec($qry,true);
	$pr->addScript("pi.requestOnLoad('data','Lock');")->set('CloseLoader',false)->response();
?>