<?php
	$inputs = json_decode($pr->post('inputs'),true);
	$idSel = $pr->post('inputIdForMod');
	
	$input = $inputs[$idSel];
	
	$selectMulti = '';
	if($input['select']){
		foreach($input['select'] as $k => $v){
			$selectMulti .= '<tr id="sel_'.$k.'">
				<td style="text-align: center;"><b>'.$k.'</b></td>
				<td>'.$v.'</td>
				<td class="red j-del" style="text-align:center; cursor:pointer;"><i class="mdi mdi-close l2 red"></i></td>
			</tr>';
		}
	}
	
	$content = '<div class="focus blue"> 
			Inserire i valori selezinabili.<br> 
			I valori verranno ordinati per chiave in fase di salvataggio.<br>
			Inserendo una chiave gi&aacute; esistente, si aggiorna la descrizione.<br><br>
			<table width="100%">
				<tr>
					<td><input type="text" id="key" placeholder="Chiave" class="small"></td>
					<td><input type="text" id="value" placeholder="Valore" class="full"></td>
					<td><button class="icon blue" onClick="addVoice();"><i class="mdi mdi-playlist-plus"></i></button></td>
				</tr>
			</table>
		</div>
		<div id="WinEditInputRow">
			<input type="hidden" name="Q" value="Calc_Select">
			<input type="hidden" name="select" id="inputSelect">
			<input type="hidden" name="inputIdForMod">
			<input type="hidden" name="inputs">
			<table class="lite orange" id="valueList">
				<tr>
					<th>Chiave</th>
					<th>Valore</th>
					<th width="24px;">Canc</th>
				</tr>
				'.$selectMulti.'
			</table>
		</div>';
	
	$footer='<button class="red" onclick="pi.win.close()">Annulla</button><button onclick="pi.requestOnModal(\'WinEditInputRow\')">Salva</button>';
	
	$js= "addVoice = function(){
			var key = $('#key').val();
			var value = $('#value').val();
			
			var iSelect = JSON.parse($('#inputSelect').val()) || {};
			
			iSelect[key] = value;
			
			$('#inputSelect').val(JSON.stringify(iSelect));
			
			var htm = '<td><b>'+key+'</b></td>';
			htm += '<td>'+value+'</td>';
			htm += '<td class=\"red j-del\" style=\"text-align:center; cursor:pointer;\"><i class=\"mdi mdi-close l2 red\"></i></td>';
			
			if($('#sel_'+key).length > 0){
				$('#sel_'+key).html(htm);
			}else{
				$('#valueList tr:last').after('<tr id=\"sel_'+key+'\">'+htm+'</tr>');
			}
			
			$('#key').val('');
			$('#value').val('');
			$('#key').focus();
			$(window).resize();
		}
	
		$('#WinEditInputRow').on('click','.j-del',function(e){
			var tr = $(e.target).closest('tr');
			var key = tr.attr('id').substr(4);
			tr.remove();
			var iSelect = JSON.parse($('#inputSelect').val());
			delete(iSelect[key]);
			$('#inputSelect').val(JSON.stringify(iSelect));
			$(window).resize();
		});
		$('#key').focus();";
	
	/*
	shortcut('enter',addVoice,{target:'key', propagate:false});
		shortcut('enter',addVoice,{target:'value', propagate:false});
	*/
	
	$fill['inputs'] = $pr->post('inputs');
	$fill['inputIdForMod'] = $pr->post('inputIdForMod');
	$fill['select'] = json_encode($input['select']);
		
	$pr->addWindow(400,0,'Modifica dei valori di '.$idSel,$content,$footer)->addScript($js)->addFill('WinEditInputRow',$fill)->response();
?>