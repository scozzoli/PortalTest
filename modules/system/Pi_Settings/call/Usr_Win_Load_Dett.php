<?php
	$db_list = $sysConfig->loadDB();
	$grp_list = $sysConfig->loadGrp();
	$usr_list = $sysConfig->loadUsr();
	$menu_list = $sysConfig->loadMenu();
	
	$usr = $pr->post("ID",'');//$_POST["ID"];
	if($usr == ''){
		$usr = false;
		$usr_list[$usr] = array(
			'nome' => 'Nuovo Utente',
			'pwd' => 'd41d8cd98f00b204e9800998ecf8427e', // è l'MD5 della pasword vuota
			'email' => '',
			'use_pwd' => '0',
			'menu' => '',
			'showsidemenu' => '1',
			'db' => '',
			'http' => '1',
			'https' => '0',
			'theme' => 'material',
			'style' => '',
			'grpdef' => '0',
			'acc_dev' => '0',
			'acc_err' => '0',
			'acc_dis' => '0',
			'acc_priv' => '0',
			'extension' => array()
		);
	}
	
	// Creo la dropdown del menù
	
	$ddMenu='<select name="menu">';
	foreach($menu_list as $k => $v){
		$ddMenu .= '<option value="'.$k.'">'.$k.'</option>';
	}
	$ddMenu.='</select>';
	
	// Creo la dropdown degli stili
	$themeDir = scandir($pr->getRootPath('style/themes'));
	$ddTheme='<select name="themeselector">';
	foreach($themeDir as $k => $v){
		if(is_dir($pr->getRootPath("style/themes/{$v}")) && ($v != '.') && ($v != '..')){
			$ddTheme.= '<optgroup label="'.$v.'">';
			$ddTheme.= '<option value="'.$v.':">'.$v.'</option>';
			$styleDir = scandir($pr->getRootPath("style/themes/{$v}"));
			foreach($styleDir as $ks => $vs){
				if((strpos($vs,'style.') !== false) && strpos($vs,'.less')){
					$styleName = substr($vs,6,-5);
					$ddTheme.= '<option value="'.$v.':'.$styleName.'">'.$v.' ('.$styleName.') </option>';
				}
			}
			$ddTheme.= '</optgroup>';
		}
	}
	$ddTheme.='</select>';
	
	// Creo la dropdown della base dati
	
	$ddDB = '<select name="db">';
	foreach($db_list as $k => $v){
		if($v['hide']==0){
			$ddDB .='<option value="'.$k.'">'.$v['des'].'</option>';
		}
	}
	$ddDB .= '</select>';
	
	
	$tb_grp='<table class="lite '.($usr_list[$usr]['grpdef']==1 ? 'green' : 'red').'" id="usr_grant_table">
			<tr>	
				<th>Codice Grp</th>
				<th>Gruppo</th>
				<th>Descrizione</th>
				<th style="text-align:center;" title="Valore di Delault">Def</th>
				<th style="text-align:center;" title="Nessun Permesso"> No</th>
				<th style="text-align:center;" title="Permesso Standard">Si</th>
			</tr>';
	foreach($grp_list as $kg => $vg){
		$lev = isset($usr_list[$usr]['grp'][$kg]) ? $usr_list[$usr]['grp'][$kg] : -1;
		$class = isset($usr_list[$usr]['grp'][$kg]) ? ($usr_list[$usr]['grp'][$kg]==1 ? 'green' : 'red') : '';
		$tb_grp.='<tr class="'.$class.'">
			<td>
				'.$kg.'	
			</td>
			<td>'.$vg['nome'].'</td>
			<td>'.$vg['des'].'</td>
			<td style="text-align:center;">
				<input type="radio" name="Grp-dett-'.$kg.'" '.($lev==-1 ? 'checked' :'').' value="-1" onclick="this.parentNode.parentNode.setAttribute(\'class\',\'\')">
			</td>
			<td style="text-align:center;" class="red">
				<input type="radio" name="Grp-dett-'.$kg.'" '.($lev==0 ? 'checked' :'').' value="0" onclick="this.parentNode.parentNode.setAttribute(\'class\',\'red\')">
			</td>
			<td style="text-align:center;" class="green">
				<input type="radio" name="Grp-dett-'.$kg.'" '.($lev==1 ? 'checked' :'').' value="1" onclick="this.parentNode.parentNode.setAttribute(\'class\',\'green\')">
			</td>
		</tr>';
	}
	
	$fillVars = $usr_list[$usr];
	
	$extList='';
	$extListIdx = 0;
	foreach($usr_list[$usr]['extension'] ?: array() as $k => $v){
		$fillVars['ext_key_'.$extListIdx] = $k;
		$fillVars['ext_val_'.$extListIdx] = $v;
	}
	$extListIdx = count($usr_list[$usr]['extension'] ?: array()) + 1; // --> aggiungo sempre una riga in più
	
	for($i = 0; $i< $extListIdx; $i++){
		$extList .= '<tr>
				<td style="text-align: center;">
					<input type="text" class="small" name="ext_key_'.$i.'" placeholder="Chiave">
				</td>
				<td style="text-align: center;">
					<input type="text" class="double" name="ext_val_'.$i.'" placeholder="Valore">
				</td>
			</tr>';
	}
	
	$tb_grp.='</table>';
	$out ='	<div id="user_del"><input type="hidden" name="Q" value="Usr_Del"><input type="hidden" name="UID" value="'.$usr.'" ></div>
	<div id="user_mod" style="text-align:left;">
		<div data-pi-component="tabstripe">
			<div data-pi-tab="Dettaglio">	
				<div class="focus blue"> Modifica i dettagli del Dell\'utente <b>'.$usr_list[$usr]['nome'].'</b></div>
				<table class="form separate">
					<tr>
						<th style="text-align:right" > User Id </th>
						<td>
							<input type="text" name="New-Uid" class="ale" value="'.$usr.'" id="UID">
							<input type="hidden" name="Old-Uid" value="'.$usr.'">
							<input type="hidden" name="Q" value="Usr_Mod">
						</td>
					</tr>
					<tr>
						<th style="text-align:right" > Nome </th>
						<td> <input type="text" name="nome" style="width:300px;"></td>
					</tr>
					<tr>
						<th style="text-align:right" > Email </th>
						<td> <input type="text" name="email" value="" style="width:300px;"></td>
					</tr>
					<tr>
						<th style="text-align:right" > Usa Password </th>
						<td> <input type="checkbox" name="use_pwd" > </td>
					</tr>
					<tr>
						<th style="text-align:right" > Password </th>
						<td> <input type="password" name="pwd" > attuale md5 [ '.$usr_list[$usr]['pwd'].' ]</td>
					</tr>
					<tr>
						<th style="text-align:right" > Stile </th>
						<td> '.$ddTheme.'</td>
					</tr>
					<tr>
						<th style="text-align:right" > Menu laterale </th>
						<td> <input type="checkbox" name="showsidemenu" > </td>
					</tr>
					<tr>
						<th style="text-align:right" > DB Default </th>
						<td> '.$ddDB.'</td>
					</tr>
					<tr>
						<th style="text-align:right" > Menu associato </th>
						<td> '.$ddMenu.'</td>
					</tr>
					<tr>
						<th style="text-align:right" > Protocolli </th>
						<td>
							<table>
								<tr>
									<td><input type="checkbox" name="http" ></td>
									<td>Abilita il <b>Protocollo HTTP (uso interno)</b></td>
								</tr>
								<tr>
									<td><input type="checkbox" name="https"></td>
									<td>Abilita il <b>Protocollo HTTPS (Per accesso esterno)</b></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</div>
			<div data-pi-tab="Permessi">
				<div class="focus green">
					Gestione dei permessi sui gruppi
				</div>
				<table class="form separate">
					<tr>
						<td style="border-bottom:1px #888 solid;"><input type="checkbox" name="grpdef" onClick="if(this.checked){$(\'#usr_grant_table\').attr(\'class\',\'green lite\');}else{$(\'#usr_grant_table\').attr(\'class\',\'red lite\');}"></td>
						<td colspan="3" style="border-bottom:1px #888 solid;">Accesso di default a tutti i <b>gruppi</b> (se non specificato diversamente)</td>
					</tr>
					<tr>
						<td><input type="checkbox" name="acc_dev" ></td>
						<td>Accedi ai moduli in <b>sviluppo</b></td>
						<td><input type="checkbox" name="acc_err" ></td>
						<td>Accedi ai moduli con <b>errori</b></td>
					</tr>
					<tr>
						<td><input type="checkbox" name="acc_dis"></td>
						<td>Accedi ai moduli <b>disabilitati</b></td>
						<td><input type="checkbox" name="acc_priv"></td>
						<td>Accedi ai moduli <b>privati</b></td>
					</tr>
				</table>
				<input type="hidden" name="Grp-key-list" value="'.implode(':',array_keys($grp_list)).'">'.$tb_grp.'
			</div>
			<div data-pi-tab="Estensioni">
				<div class="focus purple">
					<table class="form">
						<tr>
							<td>
								Valori aggiuntivi. Per eliminare una voce basta cancellare la chiave.<br> 
								NB: le chiavi sono <b>Case Sensitive</b>
							</td>
							<th>
								<button class="purple" id="addExtensionOnClick"><i class="mdi mdi-playlist-plus"></i> Aggiungi </button>
								<input type="hidden" id="ExtenzionCounter" value="'.$extListIdx.'">
							</th>
						</tr>
					</table>
				</div>
				<table class="form separate" id="ExtensionTable">
					'.$extList.'
				</table>
			</div>
		</div>
	</div>';
	$footer='<button class="red" onclick="pi.win.close()">Annulla</button>
			<button class="red" onclick="pi.chk(\'Eliminare <b>'.$usr.'</b> ?\').requestOnModal(\'user_del\')">Cancella Utente</button>
			<button class="green" onclick="pi.requestOnModal(\'user_mod\')"> Salva </button>';
	
	$fillVars['themeselector'] = $usr_list[$usr]['theme'].':'.$usr_list[$usr]['style'];
	unset($fillVars['pwd']);
	
	$js = "$('#addExtensionOnClick').click(function(e){
		var idx = $('#ExtenzionCounter').val() * 1; 
		
		var htm = '<td style=\"text-align: center;\"><input type=\"text\" class=\"small\" name=\"ext_key_'+idx+'\" placeholder=\"Chiave\"></td>';
			htm += '<td style=\"text-align: center;\"><input type=\"text\" class=\"double\" name=\"ext_val_'+idx+'\" placeholder=\"Valore\"></td>';
		
		$('#ExtensionTable tr:last').after('<tr>'+htm+'</tr>');
		$(window).resize();
		$('#ExtenzionCounter').val(idx + 1);
	});
	$('#UID').focus();";
	
	$pr->addWindow(600,0,'Modifica utente',$out,$footer)->addFill('user_mod',$fillVars)->addScript($js)->response();
?>