<?php
	$out = '<div class="focus purple">
		Selezionare il tipo di base dati a cui creare il collecamento:
	</div>
	<table class="lite purple" style="text-align:center; font-size:18px;">
		<tr> 
			<td>Collegamento a DB MySQL</td> 
			<td><button class="purple" onclick="pi.win.close(); pi.requestOnModal(null,\'DB_Win_Edit_MYSQL\');"><i class="mdi mdi-database-plus"/> Crea Nuovo </button></td>
		</tr>
		<tr > 
			<td>Collegamento a DB MS SQLServer</td> 
			<td><button class="purple" onclick="pi.win.close(); pi.requestOnModal(null,\'DB_Win_Edit_MSSQL\');"><i class="mdi mdi-database-plus"/> Crea Nuovo </button></td>
		</tr>
		<tr> 
			<td>Collegamento a DB Oracle</td> 
			<td><button class="purple" onclick="pi.win.close(); pi.requestOnModal(null,\'DB_Win_Edit_OCI8\');"><i class="mdi mdi-database-plus"/> Crea Nuovo </button></td>
		</tr>
		<tr> 
			<td>Collegamento a SQLite v3</td> 
			<td><button class="purple" onclick="pi.win.close(); pi.requestOnModal(null,\'DB_Win_Edit_SQLITE3\');"><i class="mdi mdi-database-plus"/> Crea Nuovo </button></td>
		</tr>
		<tr> 
			<td>Collegamento a DB PostgreSQL</td> 
			<td><button class="purple" onclick="pi.win.close(); pi.requestOnModal(null,\'DB_Win_Edit_PostgreSQL\');"><i class="mdi mdi-database-plus"/> Crea Nuovo </button></td>
		</tr>
	</table>';
	$footer='<button onclick="pi.win.close()"> Annulla </button>';
	
	$pr->addWindow(600,0,'Nuovo collegamento',$out,$footer)->response();
?>