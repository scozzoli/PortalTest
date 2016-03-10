<?php
	if($pr->post('qry',false) === false){
		$qryConf = Array(
			'des' => 'Nuova Interrogazione',
			'enabled' => true,
			'null' => '',
			'db' => '',
			'color' => '',
			'icon'=>'mdi-comment-text-outline',
			'qry'=>'',
			'html'=>'disabled',
			'xls'=>'disabled',
			'inputs'=> null,
			'metadata'=> null
		);
		
		$filename = '';
		$grp = 'qry';
		$icon = 'mdi-comment-text-outline';
		
		$shodel = '';
	}else{		
		$qryConf = json_decode(file_get_contents($pr->getLocalPath("script/".$pr->post('qry'))),true);
		$parts = explode('.',$pr->post('qry'));
		$title = str_replace('_',' ',$parts[1]);
		$icon = $qryConf['icon'] ?: 'mdi-comment-text-outline';
		$filename = $pr->post('qry');
		$grp = $parts[0];
		
		$showdel = '<div class="panel red">
			<table class="form">
				<tr>
					<td>La cancellazione di una interrogazione non la elimina definitivamente dal sistema, ma la sposta in una cartella sul server con la data di cancellazione</td>
					<th><button class="red" onclick="pi.chk(\'Eliminare l\\\'interrogazione?\').request(\'qryDataForm\',\'Delete_Query\')"><i class="mdi mdi-delete"></i>Cancella interrogazione</button></th>
				</tr>
			</table>
		</div>';
	}
	
	$db_list = $sysConfig->loadDB();
	$grp_list = $sysConfig->loadGrp();
	
	$fill = Array(
		'des' => $qryConf['des'],
		'enabled' => $qryConf['enabled'],
		'null' => $qryConf['null'] ?: '',
		'db' => $qryConf['db'] ?: '',
		'color' => $qryConf['color'] ?: '',
		'grp' => $grp,
		'html' => $qryConf['html'],
		'xls' => $qryConf['xls'],
		'icon' => $icon,
		'qry' => $qryConf['qry'],
		'filename' => $filename
	);
	
	$ddDB = '<select name="db">
		<option value=""> Default Utente </option>
		<optgroup label="DB registrati">';
	foreach($db_list as $k => $v){
		if($v['hide']==0){
			$ddDB .='<option value="'.$k.'">'.$v['des'].'</option>';
		}
	}
	$ddDB .= '</optgroup></select>';
	
	$ddGrp ='<select name="grp" class="ale">';
	foreach($grp_list as $k => $v){
		$ddGrp.='<option value="'.$k.'">'.$k.' - '.$v["nome"].'</option>';
	}
	$ddGrp.='</select>';
	
	$inputs = createInputsTable($qryConf['inputs']);
	$metadata = createMetadataTable($qryConf['metadata']);
	$fill['inputs'] = json_encode($qryConf['inputs']);
	$fill['metadata'] = json_encode($qryConf['metadata']);
	
	
	
	$out = $showdel.'<div class="panel">
		<table class="form" id="qryDataForm">
			<tr>
				<th> Nome: </th>
				<td> 
					'.$ddGrp.' <input type="text" class="double ale" value="'.$title.'" name="name"> 
					<input type="hidden" name="filename">
				</td>
			</tr>
			<tr>
				<th> Descrizione: </th>
				<td> <input type="text" class="double" name="des"> </td>
			</tr>
			<tr>
				<th> Abilitata: </th>
				<td> <input type="checkbox" name="enabled"> </td>
			</tr>
			<tr>
				<th> Null: </th>
				<td> <input type="text" class="double" name="null"> </td>
			</tr>
			<tr>
				<th> Db: </th>
				<td> '.$ddDB.' </td>
			</tr>
			<tr>
				<th> Colore: </th>
				<td> 
					<select name="color">
						<option> Nessuno colore </option>
						<option value="blue"> Blue </option>
						<option value="green"> Verde </option>
						<option value="orange"> Arancione </option>
						<option value="red"> Rosso </option>
						<option value="purple"> Viola </option>
					</select>
				</td>
			</tr>
			<tr>
				<th> Icona: </th>
				<td> 
					<input type="hidden" name="icon" id="icon_icon"> 
					<button onClick="pi.request(\'qryDataForm\',\'Win_Load_Icons\')"> <i class="mdi l2 '.$icon.'" id="icon_show"></i> </button>
				</td>
			</tr>
			<tr>
				<th> Html: </th>
				<td>
					<select name="html" class="double">
						<option value="disabled"> Disattivato </option>
						<option value="show"> Tabella HTML </option>
						<option value="sortable"> Tabella HTML ordinabile </option>
					</select>
					
				</td>
			</tr>
			<tr>
				<th> Excel: </th>
				<td> 
					<select name="xls" class="double">
						<option value="disabled"> Disattivato </option>
						<optgroup label="Senza formattazione">
							<option value="legacy"> Excel 95 senza formattazione (xls) </option>
						</optgroup>
						<optgroup label="Campi formattati">
							<option value="xls"> Excel 95 (xls) </option>
							<option value="xlsx"> Open Xml (xlsx) </option>
							<option value="ods"> Open Document (ods) </option>
						</optgroup>
					</select>
				</td>
			</tr>
			<tr>
				<th> Interrogazione: </th>
				<td> 
					<input type="hidden" name="qry">
					<button onClick="pi.request(\'qryDataForm\',\'Win_Edit_Query\')"> <i class="mdi mdi-pencil"> </i> Modifica interrogazione </button> 
				</td>
			</tr>
			<tr>
				<td colspan="2"> 
					<div class="focus blue"> Lista Parametri (elaborata automaticamente dall\'interrogazione)</div>
					<div id="inputList">'.$inputs.'</div>
					<input type="hidden" name="inputs">
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<div class="focus orange"> 
						<table class="form">
							<tr>
								<td><b>Tipologie colonne.</b> Le colonne sono di tipo <i>string</i> (testo semplice) se non specificato diversamente.<br>
								&Egrave; anche possibile caricare la lista completa delle colonne eseguento l\'interrogazione. </td> 
								<th>
									<button class="orange" id="hideShowMetadataButton"><i class="mdi mdi-eye"></i> Mostra </button>
								</th>
							</tr>
						</table>
					</div>
					<div id="metadataList" style="display:none;">
						<div class="focus orange">
							<table class="form">
								<tr>
									<td>
										<input type="text" id="metadataName" placeHolder="Nome Colonna"> 
										<button class="orange" id="metadataAdd"> <i class="mdi mdi-plus"></i> Aggiungi </button>
									</td>
									<th>
										<button class="orange" onclick="pi.request(\'qryDataForm\',\'Win_Get_Metadata_From_Qry\')"> <i class="mdi mdi-download"></i> Carica da interrogazione </button>
									</th>
								</tr>
							</table>
						</div>
						<div id="metadataTable">'.$metadata.'</div>
						<input type="hidden" name="metadata" id="metadataInput">
					</div>
				</td>
			</tr>
		</table>
		<div class="footer">
			<button onClick="pi.request(\'data\',\'Cerca\')"><i class="mdi mdi-arrow-left"></i> Annulla</button>
			<button class="green" onClick="pi.request(\'qryDataForm\',\'Save_Query\')"><i class="mdi mdi-content-save"></i> Salva</button>
		</div>
	</div>';
	
	$js="$('#hideShowMetadataButton').on('click',function(e){
		var button = $('#hideShowMetadataButton');
		if($('#metadataList').css('display') == 'none'){
			$('#metadataList').show('fast');
			button.html('<i class=\"mdi mdi-eye-off\"></i> Nascondi ');
		}else{
			$('#metadataList').hide('fast');
			button.html('<i class=\"mdi mdi-eye\"></i> Mostra ');
		}
	});	
	$('#metadataAdd').on('click',function(e){
		var keyElem = $('#metadataName');
		var keyVal = keyElem.val().trim().toLowerCase();
		if(keyVal != ''){
			var val = JSON.parse($('#metadataInput').val())||{};
			if(!val[keyVal]){
				val[keyVal] = 'string';
				$('#metadataInput').val(JSON.stringify(val));
				pi.silent().request('qryDataForm','Calc_Add_Metadata');
			}
		}
		keyElem.val('');
		keyElem.focus();
	});
	$('#metadataTable').on('click','.j-delete',function(e){
		var val = JSON.parse($('#metadataInput').val()) || {};
		var td = $(e.target).closest('td');
		var tr = $(e.target).closest('tr');
		var key = td.attr('data-pi-id');
		delete(val[key]);
		$('#metadataInput').val(JSON.stringify(val));
		tr.remove();
	});
	
	$('#metadataTable').on('click','.j-select',function(e){
		var val = JSON.parse($('#metadataInput').val()) || {};
		var key = $(e.target).attr('data-pi-id');
		val[key] = $(e.target).val();
		$('#metadataInput').val(JSON.stringify(val));
	});";
	
	$pr->addHtml('containerRes','')->addHtml('containerList',$out)->addScript($js)->addFill('qryDataForm',$fill)->response();
?>