<?php
	if($pr->post('saveparam') == 0){
		$usrConf = getUsrPref($pr->getUsr());
		$usrConf['save'][$pr->post('qry')] = null;
		saveUsrPref($pr->getUsr(),$usrConf);
	}
	$pr->set('CloseWin',false)->response();
?>