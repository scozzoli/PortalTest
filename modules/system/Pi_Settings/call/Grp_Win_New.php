<?php	
	$i18n = $sysConfig->loadI18n();
	
	$out ='<div class="focus orange">
		<i18n>grp:win:newGroupInfo</i18n>
		</div><br>
		<div style="text-align:center;">
			<div id="Grp_To_New">
				<input type="hidden" name="Q" value="Grp_New">
				<table class="form separate">
					<tr>
						<th style="width:50%;"><i18n>grp:win:uniqueId</i18n></th>
						<td><input type="text" name="id" class="ale" style="width:50px; min-width:50px;" id="focusme"></td>
					</tr>
				</table>
				<br>
				<table class="lite orange">
					<tr>
						<th colspan="2"><i18n>grp:iface:lang</i18n></th>
						<th><i18n>grp:iface:name</i18n></th>
						<th><i18n>grp:iface:descr</i18n></th>
					</tr>';

	foreach($i18n['langs'] as $k => $v){
		$out .= '<tr>
			<td style="text-align:right"><b> '.$v['des'].'<b></td>
			<td> <img src="./style/img/'.$v['icon'].'"> </td>
			<td><input type="text" class="" name="nome_'.$k.'"></td>
			<td><input type="text" class="double" name="des_'.$k.'"></td>
		</tr>';
	}
	$out .='</table></div></div>';
	$footer = '<button class="red" onclick="pi.win.close()"><i18n>cancel</i18n></button>
			<button class="green" onclick="pi.requestOnModal(\'Grp_To_New\')"><i18n>save</i18n></button>';
	$pr->addWindow(600,0,'<i18n>grp:iface:newGroup</i18n>',$out,$footer)->addScript("$('#focusme').focus();")->response();
?>