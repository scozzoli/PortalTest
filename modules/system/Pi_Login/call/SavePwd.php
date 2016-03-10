<?php
	$usr = $pr->post('UID');
	
	if($pr->getUsr() != $pr->post('UID')) { 
		$pr->addErrorBox('Incongrueza tra l\'utente in sessione (<b class="red">'.$pr->getUsr().'</b>) e quello visualizzato (<b class="red">'.$pr->post('UID').'</b>)!')->resposne(); 
	}
	
	if(md5($pr->post('old_pwd')) != $pr->getUsr('pwd')){ $pr->addAlertBox('Password Errata')->response(); }
	
	if($pr->post('new_pwd') != $pr->post('conf_pwd')){ $pr->addAlertBox('La nuova password non corrisponde!')->response(); }
	
	$userlist[$usr]['pwd'] = md5($pr->post('new_pwd'));
	
	$sysConfig->saveUsr($userlist);
	$pr->addScript('document.location.reload()')->set('CloseLoader',false)->response();
?>