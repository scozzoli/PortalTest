<?php
	$usr = $pr->post('UID');
	
	if($pr->getUsr() != $pr->post('UID')) { 
		$pr->addErrorBox('<i18n>err:sessionUser;'.$pr->getUsr().';'.$pr->post('UID').'</i18n>')->resposne(); 
	}
	
	if(md5($pr->post('old_pwd')) != $pr->getUsr('pwd')){ $pr->addAlertBox('<i18n>err:wrongPwd</i18n>')->response(); }
	
	if($pr->post('new_pwd') != $pr->post('conf_pwd')){ $pr->addAlertBox('<i18n>err:newPwdWrond</i18n>')->response(); }
	
	$userlist[$usr]['pwd'] = md5($pr->post('new_pwd'));
	
	$sysConfig->saveUsr($userlist);
	$pr->addScript('document.location.reload()')->set('CloseLoader',false)->response();
?>