<?php
	$mod_list = $sysConfig->loadMod();
	$grp_list = $sysConfig->loadGrp();
	$i18n = $sysConfig->loadI18n();
	
	$grp_sel ='<select name="grp">';
	$id = $pr->post("ID",'');
	
	foreach($grp_list as $k => $v){
		$grp_sel.='<option value="'.$k.'">'.$k.' - '.$v["nome"].'</option>';
	}
	$grp_sel.='</select>';
	
	$fill = $mod_list[$id];
	unset($fill['nome']);
	unset($fill['des']);
	$descr = '<table class="lite green">
		<tr>
			<th colspan="2">Lingua</th>
			<th>Nome</th>
			<th>Descrizione</th>
		</tr>';
	foreach($i18n['langs'] as $k => $v){
		$descr .= '<tr>
			<td style="text-align:right"><b> '.$v['des'].'<b></td>
			<td> <img src="./style/img/'.$v['icon'].'"> </td>
			<td><input type="text" class="" name="nome_'.$k.'"></td>
			<td><input type="text" class="double" name="des_'.$k.'"></td>
		</tr>';
		$fill['nome_'.$k] = $mod_list[$id]['nome'][$k] ?: '';
		$fill['des_'.$k] = $mod_list[$id]['des'][$k] ?: '';
	}
	$descr .= '</table>';
	
	
	$out='<div class="green focus">
			Dettagli del modulo <b>'.$sysConfig->i18nGet($mod_list[$id]["nome"]).'</b>
		</div>
		<div style="text-align:left;">
		<div id="Mod_Del">
			<input type="hidden" name="Mid" value="'.$id.'">
			<input type="hidden" name="Q" value="Mod_Del">
		</div>
		<div id="mod_mod">
			<table class="form">
				<tr>
					<th>Id Modulo</th>
					<td>
						<input type="text" class="ale" name="New-Id" value="'.$id.'" id="focusme">
						<input type="hidden" name="Old-Id" value="'.$id.'" id="MID">
						<input type="hidden" name="icon">
						<input type="hidden" name="Q" value="Mod_Mod">
					</td>
				</tr>
				<tr>
					<th>Percorso</th>
					<td><input type="text" class="double" name="path"> Usare la barra stile Unix</td>
				</tr>
				<tr>
					<th>Stato</th>
					<td>
						<select name="stato">
							<option value="ATT"> ATT - Attivo</option>
							<option value="DEV"> DEV - In Sviluppo</option>
							<option value="ERR"> ERR - Con Errori Critici</option>
							<option value="PRIV"> PRIV - Privato</option>
							<option value="DIS"> DIS - Disabilitato</option>
						</select>
					</td>
				</tr>
				<tr>
					<th> Gruppo </th>
					<td>'.$grp_sel.'</td>
				</tr>
				
			</table>
			'.$descr.'
		</div>';

		$footer.='<button class="red" onclick="pi.win.close();"> Annulla </button>
			<button class="red" onclick="pi.chk(\'Eliminare il modulo?\').requestOnModal(\'Mod_Del\')"> Rimuovi Modulo </button>
			<button class="green" onclick="pi.requestOnModal(\'mod_mod\')"> Salva </button>';
	
	if($id == ''){
		$fill['icon'] = 'mdi-android-studio';
	}
	$pr->addWindow(650,0,'Modifica dettagli del modulo',$out,$footer)->addFill('mod_mod',$fill)->addScript(" $('#focusme').focus(); ")->response();
?>