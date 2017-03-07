<?php
	include $pr->getRootPath('lib/Pi.DB.php');
	//include $pr->getRootPath('lib/Pi.Custom.php');
	include $pr->getRootPath('lib/Pi.System.php');

	$db = new PiDB($pr->getDB(),$pr);
	$sysConfig = new PiSystem($pr->getRootPath('settings/'),$pr->getUsr('lang'));

	/*
		Struttura dei file delle query:

		< grupppo >.< nome della query >.json --> sys.Oracle_DB_Lock_Sessioni.json

		{
			des : < descrizione >
			--- note : < note >
			null : < valore al posto del null >
			db : < id del db da usare (se null quello di default) >
			html : < *disabled / show / sortable / chart / charttab / chartsort >
			xls : < *disabled / legacy / xls / xlsx / ods >
			color : < *none / blue / red / orange / green / purple >
			icon : < mdi-... >
			qry : < query >
			enabled : < *true / false >
			inputs : {
				<id campo es '{campo}'> : {
					des : < descrizione visualizzata >
					note : < Note aggiuntive sul campo >
					required : < true / *false >
					default : < valore di default >
					type : < *string / numeric / date / select >
					select : { des : val  ... }
				},
				...
			}
			metadata : {
				<nome colonna> : {
					< *string / numeric / date / datecobol / qry / link / text / hidden >
				}
			}
			php : {
				enabled : < true / false* >
				code : < codice php di fomattazione >
			}
			chartSize : < S / M* / L >  // Altezza dei grafici
			charts : {
				<nome> : {
					des : < descrizione >
					size : < S / M / L / - responsive > // larghezza dei grafici in formato responsive L = fullscreen
					color : < blue / red / orange / green / purple >
					type : < line / bar / area / radar / polar / pie / nut / mixed* > //  validi per righe: ( line / radar / bar / area )
	 				collection : < row / col* >
					labels : < nome colonna >
					data : {
						<nome> : {
							src : < nome colonna (usata anche come descrizione) >
							type : < line* / bar / area > // solo per mixed
							color : < blue / red / orange / green / purple >
						}
					}
					cols : [ <nome delle colonne> ] // per i grafici di tipo "r:" indica i valori da visualizzare per ogni serie
				}
				...
			}
		}
	*/

	function getUsrPref($iUsr){
		global $pr;
		$filename = $pr->getLocalPath('config/'.$iUsr.'.json');
		if(file_exists($filename)){
			$conf = json_decode(file_get_contents($filename),true);
		}else{
			$conf = Array("fav" => Array(), "save" => Array());
		}
		return $conf;
	}

	function saveUsrPref($iUsr,$iConf){
		global $pr;
		$filename = $pr->getLocalPath('config/'.$iUsr.'.json');
		file_put_contents($filename, json_encode($iConf,JSON_PRETTY_PRINT));
	}

	function createInputsTable($iInputs){
		$out = '
			<input type="hidden" name="inputIdForMod" id="inputIdForMod">
			<table class="lite blue fix">
			<tr>
				<th> <i18n>iface:idField</i18n> </th>
				<th> <i18n>lbl:name</i18n> </th>
				<th> </th>
				<th> <i18n>iface:type</i18n> </th>
				<th> <i18n>iface:mandatory</i18n> </th>
				<th> <i18n>iface:default</i18n> </th>
				<th> <i18n>iface:note</i18n> </th>
				<th colspan="2"> <i18n>iface:edit</i18n> </th>
			</tr>';
		$fill = Array();
		$i = 0;
		foreach($iInputs ?: [] as $k => $v){
			switch($v['type']){
				case "string" :
					$typeIco = '<i class="mdi l2 mdi-format-size orange" title="Testo"></i>';
					$type = '<i18n>iface:text</i18n>';
				break;
				case "numeric" :
					$typeIco = '<i class="mdi l2 mdi-numeric orange" title="Numero"></i>';
					$type = '<i18n>iface:number</i18n>';
				break;
				case "date" :
					$typeIco = '<i class="mdi l2 mdi-calendar orange" title="Data (dd/mm/yyyy)"></i>';
					$type = '<i18n>iface:date</i18n>';
				break;
				case "select" :
					$typeIco = '<i class="mdi l2 mdi-playlist-play orange" title="Seleziona una voce"></i>';
					$type = '<i18n>iface:select</i18n>';
					//$typeIco = '<button class="icon"><i class="mdi mdi-playlist-play"></i></button>';
				break;
			}

			if($v['type'] == "select"){
				$action = '<td class="blue" style="text-align:center; cursor:pointer;" onclick="$(\'#inputIdForMod\').val(\''.$k.'\'); pi.request(\'qryDataForm\',\'Win_Edit_Input_Row\')">
					<i class="mdi mdi-pencil blue"></i>
				</td>
				<td class="orange" style="text-align:center; cursor:pointer;" onclick="$(\'#inputIdForMod\').val(\''.$k.'\'); pi.request(\'qryDataForm\',\'Win_Edit_Input_Select_Row\')">
					<i class="mdi mdi-playlist-play orange"></i>
				</td>';
			}else{
				$action = '<td class="blue" colspan="2" style="text-align:center; cursor:pointer;" onclick="$(\'#inputIdForMod\').val(\''.$k.'\'); pi.request(\'qryDataForm\',\'Win_Edit_Input_Row\')">
					<i class="mdi mdi-pencil blue"></i>
				</td>';
			}

			$out .= '<tr>
				<th>'.$k.'</th>
				<td>'.$v['des'].'</td>
				<td> '.$typeIco.' </td>
				<td> '.$type.' </td>
				<td>
					'.($v['required'] ? '<b><i18n>iface:mandatory</i18n></b>' : '<i><i18n>iface:optional</i18n></i>').'
				</td>
				<td>'.($v['default'] != '' ? htmlentities($v['default']) : '<i class="disabled"><i18n>iface:noValue</i18n></i>').'</td>
				<td>'.htmlentities($v['note']).'</td>
				'.$action.'
			</tr>';

			$i++;
		}
		$out .='</table>';
		return($out);
	}

	function createChartTable($iCharts){

		$getIcon = function($iType){
			$icon = '';
			switch ($iType) {
				case 'area': 
				case 'mixed': $icon = 'mdi-chart-areaspline'; break;
				case 'bar':  $icon = 'mdi-chart-bar'; break;
				case 'line': $icon = 'mdi-chart-line'; break;
				case 'polar':
				case 'pie': $icon = 'mdi-chart-pie'; break;
				case 'nut': $icon = 'mdi-chart-arc'; break;
				case 'radar': $icon = 'mdi-vector-polygon'; break;
			}
			return $icon;
		};

		$isMultiChart = function($iType){
			switch ($iType) {
				case 'mixed':
				case 'bar':
				case 'line':
				case 'radar':
				case 'area':
					return true;
				case 'polar':
				case 'pie':
				case 'nut':
					return false;
			}
		};

		$out = '<table class="lite green fix">';
		$idx = 0;
		foreach($iCharts ?: [] as $k => $v){
			$srcIdx = 0;
			
			$out .= '<tr class="green">
				<td style="text-align:center;" id="chart_data_'.$idx.'">
					<i class="mdi '.$getIcon($v['type']).' l3 green"></i>
					<input type="hidden" name=":LINK:GRP" value="qryDataFormChart">
					<input type="hidden" name="idx" value="'.$idx.'">
				</td>
				<td> 
					<div class="pi-line">
						<i class="mdi mdi-swap-'.(($v['collection'] ?: 'col') == 'col' ? 'horizontal' : 'vertical' ).' green"></i> 
						<i18n>opt:chart:'.$v['type'].'</i18n>
					</div>
				</td>
				<td> <b>'.$k.'</b> - <i>'.$v['des'].'</i></td>
				<td> 
					[ <b><i18n>lbl:size</i18n></b> :  <i18n>opt:size:'.strtolower($v['size']).'</i18n> ]
					[ <b><i18n>lbl:labels</i18n></b> : '.$v['labels'].']
					[ <b><i18n>lbl:color</i18n></b> : <i18n>opt:'.($v['color'] != '' ? 'color'.  ucfirst($v['color']) : 'noColor'  ).'</i18n> ]
				</td>';
			
//			$out .= '<tr class="green">
//				<th style="text-align:center;" id="chart_data_'.$idx.'">
//					<i class="mdi '.$getIcon($v['type']).' l2"></i>
//					<input type="hidden" name=":LINK:GRP" value="qryDataFormChart">
//					<input type="hidden" name="idx" value="'.$idx.'">
//				</th>
//				<td>'.$k.'</td>
//				<td>'.$v['des'].'</td>
//				<td><i18n>opt:size:'.strtolower($v['size']).'</i18n></td>
//				<td>'.$v['labels'].'</td>';

			if($isMultiChart($v['type']) && (($v['collection'] ?: 'col') == 'col')){
				$out .= '<td style="text-align:center; cursor:pointer;" class="green" onClick="pi.request(\'chart_data_'.$idx.'\',\'Win_Edit_Chart\')"><i class="mdi mdi-pencil l2 green"></i></td>';
				$out .=	'<td style="text-align:center; cursor:pointer;" class="green" onClick="pi.request(\'chart_data_'.$idx.'\',\'Win_Edit_Chart_Data\')"><i class="mdi mdi-plus l2 green"></i></td>';
			}else{
				$out .= '<td style="text-align:center; cursor:pointer;" class="green" colspan="2" onClick="pi.request(\'chart_data_'.$idx.'\',\'Win_Edit_Chart\')"><i class="mdi mdi-pencil l2 green"></i></td>';
			}
			$out .= '</tr>';

			foreach ($v['data'] as $key => $val) {
				if(($v['collection'] ?: 'col') == 'col'){
					$out.='<tr style="cursor:pointer;" onClick="pi.request(\'chart_data_'.$idx.'_'.$srcIdx.'\',\'Win_Edit_Chart_Data\')">
						<td style="text-align:right;" id="chart_data_'.$idx.'_'.$srcIdx.'">
							<i class="mdi '.$getIcon($val['type'] ?: $v['type']).' green l2"></i>
							<input type="hidden" name=":LINK:GRP" value="qryDataFormChart">
							<input type="hidden" name="idx" value="'.$idx.'">
							<input type="hidden" name="srcidx" value="'.$srcIdx.'">
						</td>
						<td colspan="2">
							<b>'.$key.'</b>
						</td>
						<td colspan="3"> 
							[ <b><i18n>lbl:src</i18n></b> : '.$val['src'].' ]
							[ <b><i18n>lbl:color</i18n></b> : <i18n>opt:'.($val['color'] != '' ? 'color'.  ucfirst($val['color']) : 'noColor'  ).'</i18n> ]
						</td>
					</tr>';
					$srcIdx++;
				}else{
					$out.='<tr style="cursor:pointer;" onClick="pi.request(\'chart_data_'.$idx.'_'.$srcIdx.'\',\'Win_Edit_Chart_Data_Row\')">
						<td style="text-align:right;" id="chart_data_'.$idx.'_'.$srcIdx.'">
							<i class="mdi '.$getIcon($val['type'] ?: $v['type']).' green l2"></i>
							<input type="hidden" name=":LINK:GRP" value="qryDataFormChart">
							<input type="hidden" name="idx" value="'.$idx.'">
							<input type="hidden" name="srcidx" value="'.$srcIdx.'">
						</td>
						<td colspan="2">
							<b>'.$key.'</b>
						</td>
						<td colspan="3"> 
							[ <b><i18n>lbl:src</i18n></b> : '.join(', ',$v['cols'] ?: []).' ]
						</td>
					</tr>';
				}
			}
			$idx++;
		}
		$out .= '</table>';
		return $out;
	}

	function createMetadataTable($iMetadata){
		$out='<table class="orange lite fix">
			<tr>
				<th><i18n>iface:colum</i18n></th>
				<th style="text-align:center;"><i18n>opt:simpleText</i18n></th>
				<th style="text-align:center;"><i18n>opt:number</i18n></th>
				<th style="text-align:center;"><i18n>opt:date</i18n></th>
				<th style="text-align:center;"><i18n>opt:dateCobol</i18n></th>
				<th style="text-align:center;"><i18n>opt:sql</i18n></th>
				<th style="text-align:center;"><i18n>opt:link</i18n></th>
				<th style="text-align:center;"><i18n>opt:longText</i18n></th>
				<th style="text-align:center;"><i18n>opt:hidden</i18n></th>
				<th style="width:80px;"><i18n>iface:remove</i18n></th>
			</tr>';
		foreach($iMetadata ?: [] as $k => $v){
			$style = ' style="text-align:center; cursor:pointer;"';
			$out.='<tr>
				<td style="text-align:right"><b>'.$k.'</b></td>
				<td class="j-select '.($v=='string' ? 'orange':'').'" data-pi-id="'.$k.'" data-pi-val="string" '.$style.'>
					<i class="l2 mdi mdi-format-size '.($v=='string' ? 'orange':'disabled').'"></i>
				</td>
				<td class="j-select '.($v=='numeric' ? 'orange':'').'" data-pi-id="'.$k.'" data-pi-val="numeric" '.$style.'>
					<i class="l2 mdi mdi-numeric '.($v=='numeric' ? 'orange':'disabled').'"></i>
				</td>
				<td class="j-select '.($v=='date' ? 'orange':'').'" data-pi-id="'.$k.'" data-pi-val="date" '.$style.'>
					<i class="l2 mdi mdi-calendar '.($v=='date' ? 'orange':'disabled').'"></i>
				</td>
				<td class="j-select '.($v=='datecobol' ? 'orange':'').'" data-pi-id="'.$k.'" data-pi-val="datecobol" '.$style.'>
					<i class="l2 mdi mdi-calendar-range '.($v=='datecobol' ? 'orange':'disabled').'"></i>
				</td>
				<td class="j-select '.($v=='qry' ? 'orange':'').'" data-pi-id="'.$k.'" data-pi-val="qry" '.$style.'>
					<i class="l2 mdi mdi-database '.($v=='qry' ? 'orange':'disabled').'"></i>
				</td>
				<td class="j-select '.($v=='link' ? 'orange':'').'" data-pi-id="'.$k.'" data-pi-val="link" '.$style.'>
					<i class="l2 mdi mdi-link '.($v=='link' ? 'orange':'disabled').'"></i>
				</td>
				<td class="j-select '.($v=='text' ? 'orange':'').'" data-pi-id="'.$k.'" data-pi-val="text" '.$style.'>
					<i class="l2 mdi mdi-comment-text-outline '.($v=='text' ? 'orange':'disabled').'"></i>
				</td>
				<td class="j-select '.($v=='hidden' ? 'orange':'').'" data-pi-id="'.$k.'" data-pi-val="hidden" '.$style.'>
					<i class="l2 mdi mdi-eye-off '.($v=='hidden' ? 'orange':'disabled').'"></i>
				</td>
				<td class="red j-delete" style="cursor:pointer; text-align:center;" data-pi-id="'.$k.'">
					<span class="red"><i class="mdi mdi-close"></i> <i18n>delete</i18n></span>
				</td>
			</tr>';
		}
		$out .='</table>';
		return $out;
	}

	function getQryData($pr, $qryConf,$null = '[[null]]'){
		$aSrc = Array();
		$aDest = Array();
		$aToSave = Array();

		$myDB = new PiDB($pr->getDB($qryConf['db']),$pr);
		$myDB->opt('null',$null);

		$prev = $pr->get('CloseWin');
		$pr->set('CloseWin',false);
		foreach($qryConf['inputs'] as $k => $v){
			$aSrc[] = $k;
			$tmpDest = $pr->post($k);

			if($v['required'] && ($tmpDest == '')){
				$pr->addAlertBox("<i18n>err:required;{$v['des']}</i18n>")->response();
			}

			switch($v['type']){
				case 'data' :
					$tmpDest = $pr->getDate($k);
					if($tmpDest === false) $pr->addAlertBox("<i18n>err:validDate;{$v['des']}</i18n>")->response();
				break;
				case 'numeric' :
					$tmpDest = $pr->getNumber($k);
					if($tmpDest === false) $pr->addAlertBox("<i18n>err:validNumber;{$v['des']}</i18n>")->response();
				break;
				default:
					$tmpDest = $pr->getString($k, $pr::GET_STR_SQLSAFE);
			}
			$aDest[] = $tmpDest;
			$aToSave[$k] = $tmpDest;
		}

		if($pr->post('saveparam',0) == 1){
			$usrConf = getUsrPref($pr->getUsr());
			$usrConf['save'][$pr->post('qry')] = $aToSave;
			saveUsrPref($pr->getUsr(),$usrConf);
		}

		$qry = str_replace($aSrc,$aDest,$qryConf['qry']);

		$pr->set('CloseWin',$prev);
		return $myDB->get($qry,true);
	}

	function nvl($iVal,$iNotNull,$iNull = '[[null]]'){
		if(!is_string($iVal)){
			return '<i class="disabled"><i18n>info:unformatted</i18n></i>';
		}
		if($iVal == $iNull){
			return $iNotNull;
		}else{
			return htmlentities($iVal);
		}
	}

	function excelNull($iVal,$iNull = '[[null]]'){
		if(!is_string($iVal)){
			return '';
		}
		if($iVal == $iNull){
			return '';
		}else{
			return $iVal;
		}
	}

	function excelDateNull($iVal,$iNull = '[[null]]'){
		if(!is_string($iVal)){
			return $iVal;
		}elseif($iVal == $iNull){
			return '';
		}else{
			return $iVal;
		}
	}

	//#region PHP format function

	function parsePHPCode($iRow,$iCode,$iPr){

		$VAL = function($iCol){ return $iCol['value']; };
		$NULL = function($iCol){ return $iCol['value'] == '[[null]]'; };
		$FG = function(&$iCol, $iColor){ $iCol['color'] = $iColor; };
		$BG = function(&$iCol, $iColor){ $iCol['bg'] = $iColor; };
		$B = function(&$iCol, $iVal = true){ $iCol['bold'] = $iVal; };
		$I = function(&$iCol, $iVal = true){ $iCol['italic'] = $iVal; };

		foreach($iRow as $K => $V){
			$tName = str_replace(' ','_',strtolower($K));
			$$tName = Array(
				'value' => $V,
				'color' => '',
				'bg'	=> '',
				'bold'	=> null,
				'italic'=> null
			);
		}

		$ROW = Array(
			'color' => '',
			'bg'	=> '',
			'bold'	=> false,
			'italic'=> false
		);

		try{
			eval($iCode);
		}catch(Exception $e){
			$iPr->error("<i18n>err:phpFormat</i18n>");
		}

		$OUT = Array();

		foreach($iRow as $K => $V){
			$tName = str_replace(' ','_',strtolower($K));
			$OUT[$K] = $$tName;
		}

		return Array("row" => $ROW , "col" => $OUT);
	}


	session_write_close();
?>
