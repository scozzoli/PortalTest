<?php

	$content='<div class="focus blue">
		Per cambiare la password inserire la vecchia password e poi confermare la nuova
	</div>
	<table class="form separate" id="change_pwd">
		<tr>
			<th>Vecchia password</th>
			<td>
				<input type="password" class="ale" name="old_pwd" id="focusme">
				<input type="hidden" name="Q" value="SavePwd">
				<input type="hidden" name="UID" value="'.$pr->post('UID').'">
			</td>
		</tr>
		<tr>
			<th>Nuova password</th>
			<td><input type="password" name="new_pwd"></td>
		</tr>
		<tr>
			<th>Converma password</th>
			<td><input type="password" name="conf_pwd"></td>
		</tr>
	</table><br>';
	
	$footer='<button class="red" onclick="pi.win.close()">Annulla</button>
	<button class="green" onclick="pi.requestOnModal(\'change_pwd\')">Salva</button>';
	
	$pr->addWindow(400,0,'Cambia Password',$content,$footer)->addScript('$("#focusme").focus();')->response();
?>