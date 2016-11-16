<?php
	include $pr->getRootPath('lib/Pi.DB.php');
	
	$db = new PiDB($pr->getDB(),$pr);
	
	session_write_close();
?>