<?php
	/*
		Questo file viene incluso in TUTTE le chiamate remote, quindi è importante che non utilizzi variabili diverse da $pr.
		Il controllo della sessione è valido per tutti i moduli ECCETTO per quello di login (system/Pi_Login)
		infatti è lui che imposta la sessione in cotrso.
		Changelog : 
		Aggiunta la gestion dei remote personalizzati: eliminato il controllo del modulo login
		 && $pr->system('module') != 'system/Pi_Login' 
	*/
	session_start();
	include './Pi.Response.php';
	$pr = new PiRespose($_POST,$_SESSION);
	$pr->set('root','../');
	
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