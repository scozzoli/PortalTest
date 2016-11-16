<?php
	/*
	 * $iDB = < >
	 * $iQry = < >
	 * $iOpt = < >
	 */
	 
	switch($iDB){
		case 'MSSQL' :
			$qry = "select * from ({$iQry}) order by {$iOpt['col']} {$iOpt['dir']}";
		case 'OCI8' :
		case 'MYSQL' :
		case 'PostgreSQL' :
	}
	$qryCount = "select count(*) as numrow from ({$iQry})";
	 
	if($iOpt['reload']){}
	
?>