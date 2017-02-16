<?php
	if($id){
		$oldID = '<input type="hidden" name="old_id" value="'.($id ?: '').'">';
		$fill = $db_list[$id];
		unset($fill['dbpwd']);
		$delButton='<button class="red" onclick="pi.chk(\'<i18n>db:chk:delete</i18n>\').requestOnModal(\'Win_Edit\',\'DB/Del\');" '.($isUsed ? 'disabled' : '').'> <i18n>delete</i18n> </button>';
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
		$txtMod = '<br><b><i18n>db:iface:undelConnUsed</i18n></b>';
	}else{
		$txtMod = '';
	}
	
	$oc = get_oci8_des($db_list[$id]['server']);
	
	$fill['srv_server'] = $oc['server'];
	$fill['srv_port'] = $oc['port'];
	$fill['srv_service'] = $oc['service'];
	
	$out = '<div id="Win_Edit">
		<div class="focus purple">
			<i18n>db:conn:oracleInfo</i18n> '.$txtMod.'
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
				<th><i18n>db:iface:server</i18n></th>
				<td>
					<input type="text" name="srv_server" style="width:300px;">
				</td>
			</tr>
			<tr>
				<th><i18n>db:iface:port</i18n></th>
				<td>
					<input type="text" name="srv_port"> <i style="purple disabled"> default : 1521</i>
				</td>
			</tr>
			<tr>
				<th><i18n>db:iface:service</i18n></th>
				<td>
					<input type="text" class="double" name="srv_service">
				</td>
			</tr>
			<tr>
				<th><i18n>db:iface:lang</i18n></th>
				<td>
					<input type="text" class="double" name="lang"> <i class="purple disabled"> <br> <b>IT</b> : WE8ISO8859P15 <br> <b>EUR</b> : AL32UTF8 </i>
				</td>
			</tr>
			<tr>
				<th><i18n>db:iface:user</i18n></th>
				<td>
					<input type="text" name="dbuser">
				</td>
			</tr>
			<tr>
				<th><i18n>db:iface:pwd</i18n></th>
				<td>
					<input type="password" value="" name="dbpwd"> <i class="purple disabled"> <i18n>db:iface:pwdInfo</i18n></i>
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
		
	$footer = '<button class="red" onclick="pi.win.close();"> <i18n>cancel</i18n></button>'.$delButton.'<button class="green" onclick="pi.requestOnModal(\'Win_Edit\',\'DB/Save_OCI8\')"><i18n>save</i18n></button>';
	
	$pr->addWindow(600,0,'<i18n>db:conn:oracle</i18n>',$out,$footer)->addScript('$("#WinEditFocus").focus();')->addFill('Win_Edit',$fill)->response();
?>