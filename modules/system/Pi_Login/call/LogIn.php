<?php
	$usr = strtolower($pr->post("UID"));
	if(!isset($userlist[$usr])){$pr->addAlertBox('<i18n>ale:noprofile;'.$usr.'</i18n>')->response();}
	if($userlist[$usr]['use_pwd']=='0'){
		$pr->next('RegisterSession');
	}else{
		
		$content='<div id="pwd_data">
				<div class="focus orange">
					<i18n>lbl:askPwd</i18n>
					<input type="hidden" name="UID" value="'.$usr.'">
					<input type="hidden" name="Q" value="LogInPwd">
				</div>
			<table class="form separate" >
				<tr style="height:40px;">
					<th> <i18n>lbl:password</i18n></th>
					<td>
						<input type="password" class="std" name="PWD" id="PWD">
					</td>
				</tr>
			</table>
		</div>';
		$footer = '<button onclick="pi.requestOnModal(\'pwd_data\')"><i18n>login</i18n></button>';
		$pr->addWindow(300,0,'<i18n>win:password</i18n>',$content,$footer)->addScript('$("#PWD").focus();')->response();
	}
?>