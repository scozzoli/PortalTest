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
			'DB' => 'SQLITE3',
			'hide' => 0
		);
		$delButton='';
	}
	
	if($isUsed){
		$txtMod = '<br><b>L\' id non &eacute; modificabile (e non &eacute; cancellabile) finch&eacute; la sorgente risuta in uso</b>';
	}else{
		$txtMod = '';
	}
	
	$out = '<div id="Win_Edit">
		<div class="focus purple">
			Sorgente dati SQlite (usando i driver SQLITE Ver 3) '.$txtMod.'
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
				<th style="text-align:right;">Nascondi</th>
				<td>
					<input type="checkbox" name="hide">
					<input type="hidden" name="userid">
					<input type="hidden" name="userpwd">
				</td>
			</tr>
		</table>
		</div>';
		
	$footer = '<button class="red" onclick="pi.win.close();"> Annulla</button>'.$delButton.'<button class="green" onclick="pi.requestOnModal(\'Win_Edit\',\'DB_Save_SQLITE3\')">Salva</button>';
	
	$pr->addWindow(600,0,'Sorgente Dati SQLITE3',$out,$footer)->addScript('$("#WinEditFocus").focus();')->addFill('Win_Edit',$fill)->response();
?>