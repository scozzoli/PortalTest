<?php
	if($id){
		$oldID = '<input type="hidden" name="old_id" value="'.($id ?: '').'">';
		$fill = $db_list[$id];
		unset($fill['dbpwd']);
		$delButton='<button class="red" onclick="pi.chk(\'<i18n>db:chk:delete</i18n>\').requestOnModal(\'Win_Edit\',\'DB_Del\');" '.($isUsed ? 'disabled' : '').'> <i18n>cancel</i18n> </button>';
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
		$txtMod = '<br><b><i18n>db:iface:undelConnUsed</i18n></b>';
	}else{
		$txtMod = '';
	}
	
	$out = '<div id="Win_Edit">
		<div class="focus purple">
			<i18n>db:conn:sqliteInfo</i18n> '.$txtMod.'
			'.$oldID.'
		</div>
		<table class="form separate">
			<tr>
				<th><i18n>db:iface:uid</i18n></th>
				<td>
					<input type="text" class="ale" value="'.$id.'" name="id" '.($isUsed ? 'disabled' : 'id="WinEditFocus"').'>
				</td>
			</tr>
			<tr>
				<th><i18n>db:iface:name</i18n></th>
				<td>
					<input type="text" calss="full" name="des" '.($isUsed ? 'id="WinEditFocus"' : '').'>
				</td>
			</tr>
			<tr>
				<th style="text-align:right;"><i18n>db:iface:hide</i18n></th>
				<td>
					<input type="checkbox" name="hide">
					<input type="hidden" name="userid">
					<input type="hidden" name="userpwd">
				</td>
			</tr>
		</table>
		</div>';
		
	$footer = '<button class="red" onclick="pi.win.close();"> <i18n>cancel</i18n></button>'.$delButton.'<button class="green" onclick="pi.requestOnModal(\'Win_Edit\',\'DB_Save_SQLITE3\')"><i18n>save</i18n></button>';
	
	$pr->addWindow(600,0,'<i18n>db:conn:sqlite</i18n>',$out,$footer)->addScript('$("#WinEditFocus").focus();')->addFill('Win_Edit',$fill)->response();
?>