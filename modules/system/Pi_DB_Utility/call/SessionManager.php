<?php
	$dbConfig = $pr->getDB($pr->post('db'));
	
	switch($dbConfig['DB']){
		//case 'OCI8' :
		//	$pr->next('LockOCI8');
		//	break;
		case 'MSSQL' :
			$pr->next('SessionMSSQL');
			break;
		//case 'MYSQL' :
		//	$pr->next('LockMYSQL');
		//	break;
		default :
			$pr->alert('Funzione non ancora implementata per il DB <b>'.$dbConfig['DB'].'</b>');
	}
?>