<?php
	include $pr->getRootPath('lib/Pi.DB.php');
	include $pr->getRootPath('lib/Pi.System.php');
	//include $pr->getRootPath('lib/Pi.Custom.php');
	//include $pr->getRootPath('lib/php.i18n.php');
	//
	//$i18nDB = new PI_DB($pr->getDB('i18n'));
	//$i18n = new PI_I18n($pr->system('lang'), $i18nDB, $pr->system('SID'));
	
	$db = new PiDB($pr->getDB(),$pr);
	$sysConfig = new PiSystem($pr->getRootPath('settings/'));
	
	session_write_close();
?>