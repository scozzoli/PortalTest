<?php
	$qryConf = json_decode(file_get_contents($pr->getLocalPath("script/".$pr->post('qry'))),true);

	$usrConf = getUsrPref($pr->getUsr());

	$parts = explode('.',$pr->post('qry'));
	$title = str_replace('_',' ',$parts[1]);

	$footer = '';


	$buttonConfig = $pr->chkGrp('qry') ? '<button class="blue" onclick="pi.requestOnModal(\'config_qry\')"><i class="mdi mdi-settings"></i> <i18n>btn:config</i18n></button>' : '';
	$fill = Array();

	if(count($qryConf['inputs'])>0){
		$paramSave = '<input type="checkbox" name="saveparam" onclick="pi.silent().requestOnModal(\'config_qry\',\'Update_Flg_SaveParam\')" '.($usrConf['save'][$pr->post('qry')] ? 'checked' : '').'> <i18n>lbl:saveParam</i18n> ';
		$contentInput = '<table class="form separate" id="inputFill">';
		foreach($qryConf['inputs'] as $k => $v){
			$style= $v['required'] ? 'ale' : '';
			$typeIco = '<i class="mdi mdi-help l2" title="Tipo sconosiuto '.$v['type'].'"></i>';
			switch($v['type']){
				case "string" :
					$typeIco = '<i class="mdi l2 mdi-format-size orange" title="Testo"></i>';
					$input = '<input type="text" name="'.$k.'" class="double '.$style.'">';
				break;
				case "numeric" :
					$typeIco = '<i class="mdi l2 mdi-numeric orange" title="Numero"></i>';
					$input = '<input type="text" name="'.$k.'" class="'.$style.'" style="text-align:right;">';
				break;
				case "date" :
					$typeIco = '<i class="mdi l2 mdi-calendar orange" title="Numero"></i>';
					$input = '<input type="text" name="'.$k.'" class="'.$style.'" placeholder="dd/mm/yyyy" data-pic="datepicker">';
				break;
				case "select" :
					$typeIco = '<i class="mdi l2 mdi-playlist-play orange" title="Seleziona una voce"></i>';
					$input = '<select  name="'.$k.'" class="'.$style.'">';
					//$input .= '<option value=""><i18n>iface:noValue</i18n></option>';
					if(!$v['required']){
						$input .= '<option value=""> --- </option>';
					}
					$showKey = isset($v['showKey']) ? $v['showKey'] : true;
					if($showKey){
						foreach($v['select'] as $selKey => $selVal){
							$input .= '<option value="'.$selKey.'">'.$selKey.' - '.$selVal.'</option>';
						}
					}else{
						foreach($v['select'] as $selKey => $selVal){
							$input .= '<option value="'.$selKey.'">'.$selVal.'</option>';
						}
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
		$paramSave = '';
		$contentInput = '<div class="focus orange" style="text-align:center;"><br> <b><i18n>iface:noParam</i18n> </b></br></br>';
	}

	if($usrConf['save'][$pr->post('qry')]){
		$fill = $usrConf['save'][$pr->post('qry')];
	}

	/*
	<tr>
				<td colspan="2">'.(htmlentities($qryConf['des']) ?: '<i> Nessuna descrizione </i>').'</td>
			</tr>
	*/

	$content = '<div class="focus blue" id="config_qry">
		<input type="hidden" name="Q" value="Int_Edit_Query">
		<input type="hidden" name="qry" value="'.$pr->post('qry').'">
		<table class="form">
			<tr>
				<td>'.$paramSave.'</td>
				<th>'.$buttonConfig.'</th>
			</tr>
		</table>
	</div>';

	//$content .= '<div id="win_launch_qry"><input type="hidden" name="qry" value="'.$pr->post('qry').'">'.$contentInput.'</div>';
	$content = '<div id="win_launch_qry">'.$content.$contentInput.'</div>';


	$footer .= $qryConf['xls'] != 'disabled' ? '<button class="green" onclick="pi.downloadOnModal(\'win_launch_qry\',\'Qry_To_Sheet\'); pi.win.close();"><i class="mdi mdi-file-excel"></i> <i18n>btn:export</i18n> </button>' : '';
	$footer .= $qryConf['html'] != 'disabled' ? '<button class="blue" onclick="pi.requestOnModal(\'win_launch_qry\',\'Qry_To_Html\')"><i class="mdi mdi-language-html5"></i> <i18n>btn:visio</i18n> </button>' : '';
	$footer .= '<button class="red" onclick="pi.win.close();"><i18n>cancel</i18n></button>';
	$js = "if($('#inputFill').find('input').length > 0) $('#inputFill').find('input')[0].focus();";
	$pr->addWindow(500,0,$title,$content,$footer)->addfill('inputFill',$fill)->addScript($js)->response();
?>
