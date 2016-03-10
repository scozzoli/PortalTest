<?php 
	$filename = $pr->post('filename');
	$timestamp = date("YmdHis");
	rename($pr->getLocalPath("script/{$filename}"),$pr->getLocalPath("script/deleted/{$timestamp}.{$filename}"));
	$pr->addScript("pi.requestOnLoad('data','Cerca');")->response();
?>