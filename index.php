<?php	
	error_reporting(E_ALL || ~E_NOTICE); //-> mi permette di usare la notazione ?: anche per variabili non impostate senza avere errori in output
	//error_reporting(E_ALL);
	
	define("MSID","PiMainSessionID");
	session_start();
	
	include './lib/Pi.SD-1.1.class.php' ;
	$sd = new PiSD();
	
	$sd->set('BaseURL','/');
	//$sd->set('BaseURL','/_test/pm/'); // 'http://'.$_SERVER['SERVER_ADDR'].
	//$sd->set('charset','ISO-8859-15'); // per il simbolo dell'euro € -> 164
	$sd->set('MSID',MSID); // 'http://'.$_SERVER['SERVER_ADDR'].
	
	$sd->includeLib('./lib/js/jquery-2.1.4.min.js');
	$sd->includeLib('./lib/js/jquery.sortElements.js');
	$sd->includeLib('./lib/js/jquery.datetimepicker.full.min.js');
	$sd->includeLib('./lib/js/shortcuts.js');
	$sd->includeLib('./lib/js/markdown.min.js');
	$sd->includeLib('./lib/Pi.JS-1.2.js');
	$sd->includeLib('./lib/Pi.Component.Tablesort.js');
	$sd->includeLib('./lib/Pi.Component.Datepicker.js');
	$sd->includeLib('./lib/Pi.Component.Tabstripe.js');
	$sd->includeLib('./lib/Pi.Component.Collapse.js');
	
	$GID = $_GET["GID"] ?: false;
	$MID = $_GET["MID"] ?: false;

	$usr = $_SESSION[MSID]["usr"] ?: 'guest';
	
	$sd->initSession($usr);
	
	if($usr == 'guest'){ 
		$sd->select(false,'Pi_Login'); 
	}else{
		$sd->select($GID,$MID);
	}
	
	/**
	 * Inserire quì tutti i controlli EXTRA sugli utenti e le include aggiuntive:
	 * ATTENZIONE : se si modifica l'utente è necessario eseguire nuovamente "initSession( <Utente> )" e "select( <Modulo> [, <Gruppo>] )".
	 */
	 
	//$sd->includeLib('./lib/js/lightbox.php');
	//$sd->includeLib('./lib/js/nicedit.php');
	
	$https = isset($_SERVER['HTTPS']);
	$unset = false;
	
	if($https){
		$unset = $sd->usr['https'] == '0';
	}else{
		$unset = $sd->usr['http'] == '0';
	}
	
	if($unset){
		unset($_SESSION[MSID]);
		$sd->initSession('guest');
		$sd->select(false,'Pi_Login');
	}
	
	/** Fine Controlli personalizzati */
	$sd->includeScript('$(document).ready(pi.init);');
	if($sd->get('MID')){
		$sd->includeLib($sd->getModulePath().'/script.js');
		if(file_exists($sd->getModulePath().'/remote.php')){
			$sd->includeScript('$.ajaxSetup({ url:"'.$sd->getModulePath().'/remote.php" });');
		}else{
			$sd->includeScript('$.ajaxSetup({ url:"lib/Pi.RemoteLoader.php" });');
		}
		include $sd->getModulePath().'/interface.php';
	}else{
		$interface = $sd->renderList();
	}
	
	echo $sd->render($interface);
?>
