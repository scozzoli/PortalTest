<?php
	$cerca = $pr->getString('cerca',$pr::GET_STR_SQLSAFE + $pr::GET_STR_UPPER);
	$dbConfig = $pr->getDB($pr->post('db'));
	if(trim($cerca) ==''){
		$pr->alert('Il campo <b>Cerca</b> non pu&oacute; essere vuoto');
	}
	
	switch($dbConfig['DB']){
		//case 'OCI8' :
		//	$pr->next('CercaOCI8');
		//	break;
		case 'MSSQL' :
			$pr->next('CercaMSSQL');
			break;
		//case 'MYSQL' :
		//	$pr->next('CercaMYSQL');
		//	break;
		default :
			$pr->alert('Funzione non ancora implementata per il DB <b>'.$dbConfig['DB'].'</b>');
	}
?>