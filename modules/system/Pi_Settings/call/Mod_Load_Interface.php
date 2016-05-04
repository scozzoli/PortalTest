<?php
	$mod_list = $sysConfig->loadMod();
	$grp_list = $sysConfig->loadGrp();
	$i18n = $sysConfig->loadI18n();
	
	$filter = strtolower($pr->post('cerca',''));

	$out='<div class="panel green" style="text-align:center;">
		<table class="form" id="cerca_modulo">
			<tr>
				<th>
					<input type="hidden" name="Q" value="Mod_Load_Interface">
					Nome modulo : 
				</th>
				<td> <input type="text" name="cerca" class="full" value="'.$filter.'" id="input_cerca_modulo"> </td>
				<td> <button class="green" onclick="pi.request(\'cerca_modulo\');"><i class="mdi mdi-magnify"></i> Cerca </button></td>
				<th> <button class="green" onclick="pi.request(null,\'Mod_Win_Load_Dett\');"><i class="mdi mdi-plus-box"></i> Nuovo Modulo </button> </th>
			</tr>
		</table>
	</div>
	<table class="lite green">
		<tr>
			<th style="width:30px;"> Icona </th>
			<th>Mod ID</th>
			<th>Nome</th>
			<th>Descrizione</th>
			<th title="Dove si trova fisicamente il modulo" colspan="2">Percorso</th>
			<th>Stato</th>
			<th title="Gruppo di appartenenza">Gruppo</th>
			<th>Modifica</th>
		</tr>';
	foreach($mod_list as $k => $v){
		
		if($filter != ''){
			if(!(strpos(strtolower($k),$filter)!==false || strpos(strtolower($sysConfig->i18nGet($v,'nome')),$filter)!==false)){ continue; }
		}
		
		switch($v['stato']){
			case 'ATT' : $des_stato = 'Attivo'; 			$class='green'; 	$style='';	break;
			case 'DEV' : $des_stato = 'Sviluppo';  			$class='orange';	$style='';	break;
			case 'PRIV': $des_stato = 'Privato';  			$class='purple';	$style='';	break;
			case 'ERR' : $des_stato = 'Errori Bloccanti'; 	$class='red';		$style='';	break;
			case 'DIS' : $des_stato = 'Disabilitato'; 		$class='';			$style='color:#888;';	break;
		}
		$out.='<tr style="'.$style.'">
				<td class="'.$class.'" style="text-align:center; cursor:pointer;" onclick="pi.request(\'Load_Img_'.$k.'\')">
					<div id="Load_Img_'.$k.'">
						<input type="hidden" name="Q" value="Mod_Win_Load_Img">
						<input type="hidden" name="ID" value="'.$k.'">
						<i class="mdi l2 '.$v['icon'].'"></i>
					</div>
				</td>
				<td>'.$k.'</td>
				<td>'.htmlentities($sysConfig->i18nGet($v['nome'])).'</td>
				<td>'.htmlentities($sysConfig->i18nGet($v['des'])).'</td>
				<td width="20px">'.(file_exists($pr->getRootPath("modules/{$v['path']}/interface.php")) 
								? '<i class="mdi mdi-check green"></i>'
								: '<i class="mdi mdi-alert-circle red"></i>').'</td>
				<td>'.$v['path'].'</td>
				<td>'.$des_stato.'</td>
				<td>[ <b>'.$v['grp'].' </b>] '.$sysConfig->i18nGet($grp_list[$v['grp']]['nome']).'</td>
				<td class="green" style="text-align:center; cursor:pointer;" onclick="pi.request(\'Load_Dett_'.$k.'\')">
					<div id="Load_Dett_'.$k.'">
						<input type="hidden" name="Q" value="Mod_Win_Load_Dett">
						<input type="hidden" name="ID" value="'.$k.'">
						<i class="mdi mdi-pencil green l2" />
					</div>
				</td>
			</tr>';
	}
	$out.='</table>';
	$pr->addHtml('container',$out)->addScript('$("#input_cerca_modulo").focus(); $("#input_cerca_modulo").select(); shortcut("enter", onEnterMod,{"propagate":false, target:"input_cerca_modulo"} );')->response();
?>