<?php
	session_start();
	if(!isset($_POST["module"])){die('Portal 1 Modulo non trovato');}
	include str_repeat('../',substr_count($_POST["module"],'/')+2).'lib/Pi.Response.php';
	$pr = new PiRespose($_POST,$_SESSION);
	$pr->set('root',str_repeat('../',substr_count($_POST["module"],'/')+2));
	
	if(!$pr->getUsr()){
		$pr->alert('<b>Sessione Scaduta</b>. Ricaricare la pagina o eseguire il login in un altro TAB!');
	}
	
	if(file_exists($pr->getLocalPath('call/_common.php'))){ include $pr->getLocalPath('call/_common.php') ; }
	
	$pr->set('CallBack',true);
	
	while($pr->get('CallBack')){
		$pr->set('CallBack',false);
		if(!file_exists($pr->getLocalPath('call/'.$pr->get('NextCall').'.php'))){ 
			$pr->error('Remote : Tipo Operazione "'.$pr->get('NextCall').'" non previsto.'); 
		}
		include $pr->getLocalPath('call/'.$pr->get('NextCall').'.php');
	}
	
	$pr->error('Remote : chiamata <b>'.$pr->get('NextCall').'</b> terminata senza azione (response o nextcall)');
?>