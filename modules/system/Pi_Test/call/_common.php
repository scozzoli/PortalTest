<?
	include $pr->getRootPath('lib/Pi.DB.php');
	include $pr->getRootPath('lib/Pi.Custom.php');
	//include $pr->get('root').'../lib/php.i18n.php';
	//
	//$i18nDB = new PI_DB('i18n');
	//$i18n = new PI_I18n($_SESSION[$pr->get('MSID')]['usr']['lang'], $i18nDB, $pr->get('MID'));
	
	$db = new PiDB($pr->getDB());
	
	session_write_close();
?>