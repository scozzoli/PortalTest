<?php
	include $pr->getRootPath('lib/Pi.System.php');
	$sysConfig = new PiSystem($pr->getRootPath('settings/'));
	
	$userlist = $sysConfig->loadUsr();
?>