<?php
	$out = '<div class="focus purple">
		<i18n>db:win:newDbInfo</i18n>
	</div>
	<table class="lite purple" style="text-align:center; font-size:18px;">
		<tr> 
			<td><i18n>db:conn:mysql</i18n></td> 
			<td><button class="purple" onclick="pi.win.close(); pi.requestOnModal(null,\'DB_Win_Edit_MYSQL\');"><i class="mdi mdi-database-plus"/> <i18n>db:iface:createNew</i18n> </button></td>
		</tr>
		<tr > 
			<td><i18n>db:conn:mssql</i18n></td> 
			<td><button class="purple" onclick="pi.win.close(); pi.requestOnModal(null,\'DB_Win_Edit_MSSQL\');"><i class="mdi mdi-database-plus"/> <i18n>db:iface:createNew</i18n> </button></td>
		</tr>
		<tr> 
			<td><i18n>db:conn:oracle</i18n></td> 
			<td><button class="purple" onclick="pi.win.close(); pi.requestOnModal(null,\'DB_Win_Edit_OCI8\');"><i class="mdi mdi-database-plus"/> <i18n>db:iface:createNew</i18n> </button></td>
		</tr>
		<tr> 
			<td><i18n>db:conn:sqlite</i18n></td> 
			<td><button class="purple" onclick="pi.win.close(); pi.requestOnModal(null,\'DB_Win_Edit_SQLITE3\');"><i class="mdi mdi-database-plus"/> <i18n>db:iface:createNew</i18n> </button></td>
		</tr>
		<tr> 
			<td><i18n>db:conn:postgre</i18n></td> 
			<td><button class="purple" onclick="pi.win.close(); pi.requestOnModal(null,\'DB_Win_Edit_PostgreSQL\');"><i class="mdi mdi-database-plus"/> <i18n>db:iface:createNew</i18n> </button></td>
		</tr>
	</table>';
	$footer='<button onclick="pi.win.close()"> <i18n>cancel</i18n> </button>';
	
	$pr->addWindow(600,0,'<i18n>db:win:newDbTitle</i18n>',$out,$footer)->response();
?>