<?php
	$inputs = json_decode($pr->post('inputs'),true);
	$idSel = $pr->post('inputIdForMod');
	
	$input = $inputs[$idSel];
	
	$selectMulti = '<option value="">Nessun valore</value>';
	if($input['select']){
		foreach($input['select'] as $k => $v){
			$selectMulti .= '<option value="'.$k.'">'.$k.' - '.$v.'</value>';
		}
	}
	
	$content = '<div class="focus blue"> Dettagli sul tipo di input.<br> I valori per la selezione multipla sono inseribili a parte</div>
	<div id="WinEditInputRow">
		<input type="hidden" name="Q" value="Calc_Input">
		<input type="hidden" name="inputs">
		<input type="hidden" name="inputIdForMod">
		<table class="form separate">
			<tr>
				<th>Descrizione</th>
				<td><input type="text" name="des" class="full" id="focusmeWin"></td>
			</tr>
			<tr>
				<th>Tipologia</th>
				<td>
					<select name="type" onChange="selectType(this)" id="selectType">
						<option value="string"> Testo </option>
						<option value="numeric"> Numero </option>
						<option value="date"> Data (dd/mm/yyyy) </option>
						<option value="select"> Selezione multipla </option>
					</select>
				</td>
			</tr>
			<tr>
				<th>Default</th>
				<td>
					<input type="hidden" name="default">
					<input type="text" name="'.($input['type'] == 'string' ? 'default' : '').'" id="def_str" style="display:none;">
					<input type="text" name="'.($input['type'] == 'numeric' ? 'default' : '').'" id="def_num" style="display:none; text-align:right">
					<input type="text" name="'.($input['type'] == 'date' ? 'default' : '').'" id="def_data" style="display:none;" data-pi-component="datepicker">
					<select name="'.($input['type'] == 'select' ? 'default' : '').'" id="def_select" style="display:none;">
					'.$selectMulti.'
					</select>
				</td>
			</tr>
			<tr>
				<th>Obbligatorio</th>
				<td><input type="checkbox" name="required"></td>
			</tr>
			<tr>
				<th>Note</th>
				<td><input type="text" name="note" class="full"></td>
			</tr>
		</table>
	</div>';
	
	$footer='<button class="red" onclick="pi.win.close()">Annulla</button><button onclick="pi.requestOnModal(\'WinEditInputRow\')">Salva</button>';
	
	$js= "selectType = function(obj){
		var value = typeof obj == 'string' ? obj : obj.value;
		selectDef = function(id,disable){
			var elem = $('#'+id);
			if(disable){
				elem.attr('name','');
				elem.css('display','none');
			}else{
				elem.attr('name','default');
				elem.css('display','block');
			}
		}
		
		selectDef('def_str',value != 'string');
		selectDef('def_num',value != 'numeric');
		selectDef('def_data',value != 'date');
		selectDef('def_select',value != 'select');
		
	}
	selectType('".$input['type']."')
	$('#focusmeWin').focus();";
	
	$input['inputs'] = $pr->post('inputs');
	$input['inputIdForMod'] = $pr->post('inputIdForMod');
		
	$pr->addWindow(400,0,'Modifica di '.$idSel,$content,$footer)->addScript($js)->addFill('WinEditInputRow',$input)->response();
?>