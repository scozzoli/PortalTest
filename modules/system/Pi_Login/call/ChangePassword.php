<?php

	$content='<div class="focus blue">
		<i18n>win:chkPwdInfo</i18n>
	</div>
	<table class="form separate" id="change_pwd">
		<tr>
			<th><i18n>lbl:oldPwd</i18n></th>
			<td>
				<input type="password" class="ale" name="old_pwd" id="focusme">
				<input type="hidden" name="Q" value="SavePwd">
				<input type="hidden" name="UID" value="'.$pr->post('UID').'">
			</td>
		</tr>
		<tr>
			<th><i18n>lbl:newPwd</i18n></th>
			<td><input type="password" name="new_pwd"></td>
		</tr>
		<tr>
			<th><i18n>lbl:newPwdConfirm</i18n></th>
			<td><input type="password" name="conf_pwd"></td>
		</tr>
	</table><br>';
	
	$footer='<button class="red" onclick="pi.win.close()"><i18n>cancel</i18n></button>
	<button class="green" onclick="pi.requestOnModal(\'change_pwd\')"><i18n>save</i18n></button>';
	
	$pr->addWindow(400,0,'<i18n>btn:changePwd</i18n>',$content,$footer)->addScript('$("#focusme").focus();')->response();
?>