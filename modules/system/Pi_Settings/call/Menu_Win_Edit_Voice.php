<?php
	$i18n = $sysConfig->loadI18n();
	$voice = $pr->post('voice',false);
	$footer = '<button class="red" onclick="pi.win.close()"><i18n>cancel</i18n></button>';

	if($voice){ // sono in modifica
		$menu_list = $sysConfig->loadMenu();
		//$ini = parse_ini_file($pr->getRootPath('settings/menu/'.$pr->post('menu').'.ini'),true);
		
		$fill = Array(
			"New-Id" => $pr->post('voice'),
			"Old-Id" => $pr->post('voice'),
			"menu" => $pr->post('menu'),
			"hidden" => $menu_list[$pr->post('menu')][$pr->post('voice')]['hidden']
			);
		
		$footer .= '<button class="red" onclick="pi.chk(\'Eliminare la Voce del menu?\').requestOnModal(\'Mod_Voice\',\'Menu_Del_Voice\')"> <i18n>delete</i18n> </button>
		<button class="green" onclick="pi.requestOnModal(\'Mod_Voice\',\'Menu_Mod_Voice\')"> <i18n>save</i18n> </button>';
		$header = '<i18n>menu:iface:showDettVoice</i18n>';
	}else{ // sono in inserimento
		$footer .= '<button class="green" onclick="pi.requestOnModal(\'Mod_Voice\',\'Menu_Add_Voice\')"> <i18n>save</i18n> </button>';
		$fill = Array("menu" => $pr->post('menu'));
		$header = '<i18n>menu:iface:addNewVoice</i18n>';
	}
	
	$out='<div class="focus red">
			<i18n>menu:iface:infoVoice</i18n>
		</div><br>
		<div id="Mod_Voice">
			<table class="form separate" >
				<tr>
					<th><i18n>menu:iface:sorting</i18n></th>
					<td>
						<input type="text" name="New-Id" id="winMenuFocusMe" class="ale">
						<input type="hidden" name="Old-Id">
						<input type="hidden" name="menu">
						<th><i18n>menu:iface:hidden</i18n></th>
						<td><input type="checkbox" name="hidden"></td>
					</td>
				</tr>
				
			</table>
			<table class="lite red">
				<tr>
					<th colspan="2">Lingua</th>
					<th><i18n>menu:iface:desc</i18n></th>
				</tr>';
	foreach($i18n['langs'] as $k => $v){
		$out .= '<tr>
			<td style="text-align:right"><b> '.$v['des'].'<b></td>
			<td> <img src="./style/img/'.$v['icon'].'"> </td>
			<td><input type="text" class="double" name="des_'.$k.'"></td>
		</tr>';
		if($voice){
			$fill['des_'.$k] = $menu_list[$pr->post('menu')][$voice]['des'][$k] ?: '';
		}
	}
	$out.='	</table>
	</div>';

	$pr->addWindow(600,0,$header,$out,$footer)->addFill("Mod_Voice",$fill)->addScript('$("#winMenuFocusMe").focus();')->response();
?>