<?php
	$inputs = json_decode($pr->post('inputs'),true);

	$title = '<i18n>win:loadMetadata</i18n>';

	$footer = '';

	$fill = Array();

	if(count($inputs)>0){
		$contentInput = '<table class="form separate" id="inputFill">';
		foreach($inputs as $k => $v){
			$style= $v['required'] ? 'ale' : '';
			$typeIco = '<i class="mdi mdi-help l2" title="Tipo sconosiuto '.$v['type'].'"></i>';
			switch($v['type']){
				case "string" :
					$typeIco = '<i class="mdi l2 mdi-format-size orange" title="Testo"></i>';
					$input = '<input type="text" name="i_'.$k.'" class="double '.$style.'">';
				break;
				case "numeric" :
					$typeIco = '<i class="mdi l2 mdi-numeric orange" title="Numero"></i>';
					$input = '<input type="text" name="i_'.$k.'" class="'.$style.'" style="text-align:right;">';
				break;
				case "date" :
					$typeIco = '<i class="mdi l2 mdi-calendar orange" title="Numero"></i>';
					$input = '<input type="text" name="i_'.$k.'" class="'.$style.'" placeholder="dd/mm/yyyy" data-pi-component="datepicker">';
				break;
				case "select" :
					$typeIco = '<i class="mdi l2 mdi-playlist-play orange" title="Seleziona una voce"></i>';
					$input = '<select  name="i_'.$k.'" class="'.$style.'">';
					$input .= '<option value=""><i18n>iface:noValue</i18n></option>';
					foreach($v['select'] as $selKey => $selVal){
						$input .= '<option value="'.$selKey.'">'.$selKey.' - '.$selVal.'</option>';
					}
					$input .= '</select>';
				break;
			}

			$contentInput .= '<tr>
				<th>'.$v['des'].'</th>
				<td>'.$typeIco.'</td>
				<td>'.$input.' <i>'.(htmlentities($v['note']) ?: '').'</i></td>
				</td>';
			$fill[$k] = $v['default'];
		}
		$contentInput .= '</table>';
	}else{
		$contentInput = '<div class="focus orange" style="text-align:center;"><br> <b><i18n>iface:noParam</i18n> </b></br></br>';
	}

	$fill['inputs'] = $pr->post('inputs');
	$fill['qry'] = $pr->post('qry');
	$fill['db'] = $pr->post('db');
	$fill['metadata'] = $pr->post('metadata');

	$content = '<div class="focus blue" id="config_qry">
		<i18n>err:noResultMetadata</i18n>
	</div>';

	$content .= '<div id="winCalcMetadata">
		<input type="hidden" name="Q" value="Calc_Metadata_From_Qry">
		<input type="hidden" name="inputs">
		<input type="hidden" name="metadata">
		<input type="hidden" name="qry">
		<input type="hidden" name="db">'.$contentInput.'</div>';

	$footer .= '<button class="red" onclick="pi.win.close();"><i18n>cancel</i18n></button> <button onclick="pi.requestOnModal(\'winCalcMetadata\')"><i18n>btn:getColumns</i18n></button>';
	$js = "if($('#inputFill').find('input').length > 0) $('#inputFill').find('input')[0].focus();";
	$pr->addWindow(500,0,$title,$content,$footer)->addfill('winCalcMetadata',$fill)->addScript($js)->response();
?>
