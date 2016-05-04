<?php
/**
* Le chiavi che vengono passate nei tag <i18n> </i18n> possono essere paramtriche e sono del tipo:
* <i18n> save </i18n> ---> cerca la chiave "save" del tipo "Salva"
* <i18n> save;ciao mondo </i18n> ---> se la chiave è parametrica è del tipo "salvare il file {1}?"
*
*/	session_start();

	include '../lib/Pi.I18n.php';
	include '../lib/Pi.Response.php';
	
	$pr = new PiRespose($_POST,$_SESSION);
	$pr->set('root','../');
	
	$i18n = new PiI18n($pr->getUsr('lang')?:'it');
	//$i18n = new PiI18n('it');
	$i18n->setModule($pr->getLocalPath(''));
	
	switch($pr->post('Q')){
		case 'init' :
			$out = $i18n->createJsonDictionary();
		break;
		case 'notfound' :
			$fp = fopen('./log/'.date('Ymd').'.miss','a+') or die('Impossibile aprire o creare il file '.date('Ymd'));
			fwrite($fp,$pr->post('lang').';'.$pr->post('scope').';'.$pr->post('module').';'.$pr->post('key')."\n");
			fclose($fp);
			$out = '[ '.$pr->post('lang').' ] '.$pr->post('scope').' -> '.$pr->post('key');
		break;
		default:
			$out = '[ i18n : Chiamata errata ] '.$pr->post('Q').' -> non ho idea di cosa sia';
	}
	
	$pr->responseRaw($out);
?>
