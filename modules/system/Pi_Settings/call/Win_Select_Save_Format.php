<?php
	
	$footer = '<button class="red" onclick="pi.win.close()"><i18n>cancel</i18n></button>';
	
	if($pr->getUsr() == 'root'){
		$edit = '';
		$footer .= '<button class="blue" onclick="pi.requestOnModal(\'saveformat\')"><i18n>save</i18n></button>';
		$call = '<input type="hidden" name="Q" value="Save_Format">';
	}else{
		$edit = 'disabled';
		$call= '';
	}
	
	$out='<div class="focus blue">
		<i18n>cfg:info</i18n>
	</div>
	<table class="form separate" id="saveformat">
		<tr>
			<th>
				<input type="radio" name="format" value="json" '.$edit.'>
				'.$call.'
				<input type="hidden" name="old">
			</th>
			<td> <i18n>cfg:lblJson</i18n> </td>
			<td> <i18n>cfg:desJson</i18n> </td>
		</tr>
		<tr>
			<th><input type="radio" name="format" value="serialize" '.$edit.'></th>
			<td> <i18n>cfg:lblSerializie</i18n></td>
			<td> <i18n>cfg:desSerializie</i18n></td>
		</tr>
		<tr>
			<th><input type="radio" name="format" value="encripted" '.$edit.'></th>
			<td> <i18n>cfg:lblEncript</i18n></td>
			<td> <i18n>cfg:desEncript</i18n></td>
		</tr>
	</table>';
	
	$fill['format'] = $sysConfig->get('type');
	$fill['old'] = $sysConfig->get('type');
	
	$pr->addWindow(600,0,'Selezionare il formato',$out,$footer)->addFill('saveformat',$fill)->response();
?>
