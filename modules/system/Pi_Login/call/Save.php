<?php
	$usr = $pr->post('UID');
	
	if($pr->getUsr() != $pr->post('UID')) { 
		$pr->addErrorBox('Incongrueza tra l\'utente in sessione (<b class="red">'.$pr->getUsr().'</b>) e quello visualizzato (<b class="red">'.$pr->post('UID').'</b>)!')->resposne(); 
	}
	
	$style = explode(':',$pr->post('themeselector'));
	
	$userlist[$usr]['nome'] = $pr->getString('nome');
	$userlist[$usr]['email'] = $pr->getString('email');
	$userlist[$usr]['showsidemenu'] = $pr->post('showsidemenu');
	$userlist[$usr]['events'] = $pr->post('events');
	$userlist[$usr]['theme'] = $style[0];
	$userlist[$usr]['style'] = $style[1];	
	
	$_SESSION[$pr->system('MSID')]['config'] = $userlist[$usr];
	
	$sysConfig->saveUsr($userlist);
	$pr->addScript('document.location.reload()')->set('CloseLoader',false)->response();
?>