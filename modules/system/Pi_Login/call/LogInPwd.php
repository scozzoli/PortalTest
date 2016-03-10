<?
	$usr = strtolower($pr->post("UID"));
	if(md5($pr->post("PWD")) == $userlist[$usr]['pwd']){
		$pr->next('RegisterSession');
	}else{
		$pr->addAlertBox('Password Errata')->response();
	}
?>