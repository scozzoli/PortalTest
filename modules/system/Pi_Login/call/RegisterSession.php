<?php
	$dblist = $sysConfig->loadDB();
	$_SESSION[$pr->system('MSID')] = Array(
		"usr" => $usr,
		"config" => $userlist[$usr],
		"db" => $dblist
	);
	$pr->addScript('document.location.reload()')->set('CloseLoader',false)->response();
?>