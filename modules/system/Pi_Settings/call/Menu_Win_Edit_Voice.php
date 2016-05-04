<?php
	$i18n = $sysConfig->loadI18n();
	$voice = $pr->post('voice',false);
	$footer = '<button class="red" onclick="pi.win.close()">Annulla</button>';

	if($voice){ // sono in modifica
		$menu_list = $sysConfig->loadMenu();
		//$ini = parse_ini_file($pr->getRootPath('settings/menu/'.$pr->post('menu').'.ini'),true);
		
		$fill = Array(
			"New-Id" => $pr->post('voice'),
			"Old-Id" => $pr->post('voice'),
			"menu" => $pr->post('menu'),
			"hidden" => $menu_list[$pr->post('menu')][$pr->post('voice')]['hidden']
			);
		
		$footer .= '<button class="red" onclick="pi.chk(\'Eliminare la Voce del menu?\').requestOnModal(\'Mod_Voice\',\'Menu_Del_Voice\')"> Elimina </button>
		<button class="green" onclick="pi.requestOnModal(\'Mod_Voice\',\'Menu_Mod_Voice\')"> Salva </button>';
		$header = 'Modifica dettagli voce';
	}else{ // sono in inserimento
		$footer .= '<button class="green" onclick="pi.requestOnModal(\'Mod_Voice\',\'Menu_Add_Voice\')"> Salva </button>';
		$fill = Array("menu" => $pr->post('menu'));
		$header = 'Inserisci nuova voce';
	}
	
	$out='<div class="focus red">
			Sarebbe buona norma tenere conto di un paio di punti:
					<ul>
						<li>L\'ordinamento &eacute; la chiave primaria. <b>NON</b> sono ammessi duplicati</li>
						<li>L\'ordinamento &eacute; di tipo alfabetico, ES : "1" - "11" - "2" - "21" - "A1" - ecc...</li>
						<li>Sarebbe buona norma tenere la descrizione pi&uacute; sintetica possbile (deve stare su di un pulsate e non c\'&eacute; solo lei)</li>
						<li>Il men&uacute; nascosto permette di eseguire i moduli in esso contenuto senza visualizzarli negli elenchi </li>
					<ul>
		</div><br>
		<div id="Mod_Voice">
			<table class="form separate" >
				<tr>
					<th>Ordinamento</th>
					<td>
						<input type="text" name="New-Id" id="winMenuFocusMe" class="ale">
						<input type="hidden" name="Old-Id">
						<input type="hidden" name="menu">
						<th>Nascosto</th>
						<td><input type="checkbox" name="hidden"></td>
					</td>
				</tr>
				
			</table>
			<table class="lite red">
				<tr>
					<th colspan="2">Lingua</th>
					<th>Descrizione</th>
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