<?
	$usr = strtolower($pr->post("UID"));
	if(!isset($userlist[$usr])){$pr->addAlertBox('Nessu profilo associato a <b>'.$usr.'</b>')->response();}
	if($userlist[$usr]['use_pwd']=='0'){
		$pr->next('RegisterSession');
	}else{
		
		$content='<div id="pwd_data">
				<div class="focus orange">
					Questo profilo &eacute; protetto da password:
					<input type="hidden" name="UID" value="'.$usr.'">
					<input type="hidden" name="Q" value="LogInPwd">
				</div>
			<table class="form separate" >
				<tr style="height:40px;">
					<th> Password : </th>
					<td>
						<input type="password" class="std" name="PWD" id="PWD">
					</td>
				</tr>
			</table>
		</div>';
		$footer = '<button onclick="pi.requestOnModal(\'pwd_data\')">LogIn</button>';
		$pr->addWindow(300,0,'Password del profilo',$content,$footer)->addScript('$("#PWD").focus();')->response();
	}
?>