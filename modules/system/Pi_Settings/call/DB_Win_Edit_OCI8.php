<?php
	if($id){
		$oldID = '<input type="hidden" name="old_id" value="'.($id ?: '').'">';
		$fill = $db_list[$id];
		unset($fill['dbpwd']);
		$delButton='<button class="red" onclick="pi.chk(\'Eliminare il collegamento al DB?\').requestOnModal(\'Win_Edit\',\'DB_Del\');" '.($isUsed ? 'disabled' : '').'> Cancella </button>';
	}else{
		$oldID = '';
		$fill = Array(
			'des' => 'Nuovo DB', 
			'DB' => 'OCI8',
			'server' => '',
			'lang' => 'WE8ISO8859P15', // ita = WE8ISO8859P15 ; usa = AL32UTF8
			'dbuser' => '',
			'dbpwd' => '',
			'userid' => 0,
			'userpwd' => 0,
			'hide' => 0
		);
		$delButton='';
	}
	
	if($isUsed){
		$txtMod = '<br><b>L\' id non &eacute; modificabile (e non &eacute; cancellabile) finch&eacute; la sorgente risuta in uso</b>';
	}else{
		$txtMod = '';
	}
	
	$oc = get_oci8_des($db_list[$id]['server']);
	
	$fill['srv_server'] = $oc['server'];
	$fill['srv_port'] = $oc['port'];
	$fill['srv_service'] = $oc['service'];
	
	$out = '<div id="Win_Edit">
		<div class="focus purple">
			Sorgente dati Oracle (usando i driver OCI8) '.$txtMod.'
			'.$oldID.'
		</div>
		<table class="form separate">
			<tr>
				<th>ID</th>
				<td>
					<input type="text" class="ale" value="'.$id.'" name="id" '.($isUsed ? 'disabled' : 'id="WinEditFocus"').'>
				</td>
			</tr>
			<tr>
				<th>Nome</th>
				<td>
					<input type="text" calss="full" name="des" '.($isUsed ? 'id="WinEditFocus"' : '').'>
				</td>
			</tr>
			<tr>
				<th>Server</th>
				<td>
					<input type="text" name="srv_server" style="width:300px;">
				</td>
			</tr>
			<tr>
				<th>Porta</th>
				<td>
					<input type="text" name="srv_port"> <i style="purple disabled"> default : 1521</i>
				</td>
			</tr>
			<tr>
				<th>Servizio</th>
				<td>
					<input type="text" class="double" name="srv_service">
				</td>
			</tr>
			<tr>
				<th>Lingua</th>
				<td>
					<input type="text" class="double" name="lang"> <i class="purple disabled"> <br> <b>IT</b> : WE8ISO8859P15 <br> <b>EUR</b> : AL32UTF8 </i>
				</td>
			</tr>
			<tr>
				<th>Utente</th>
				<td>
					<input type="text" name="dbuser">
				</td>
			</tr>
			<tr>
				<th>Password</th>
				<td>
					<input type="password" value="" name="dbpwd"> <i class="purple disabled"> Compilare solo se &eacute; cambiata</i>
				</td>
			</tr>
			<tr>
				<th style="text-align:right;">Nascondi</th>
				<td>
					<input type="checkbox" name="hide">
					<input type="hidden" name="userid">
					<input type="hidden" name="userpwd">
				</td>
			</tr>
		</table>
		</div>';
		
	$footer = '<button class="red" onclick="pi.win.close();"> Annulla</button>'.$delButton.'<button class="green" onclick="pi.requestOnModal(\'Win_Edit\',\'DB_Save_OCI8\')">Salva</button>';
	
	$pr->addWindow(600,0,'Sorgente Dati Oracle',$out,$footer)->addScript('$("#WinEditFocus").focus();')->addFill('Win_Edit',$fill)->response();
?>