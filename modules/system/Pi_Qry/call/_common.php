<?php
	include $pr->getRootPath('lib/Pi.DB.php');
	//include $pr->getRootPath('lib/Pi.Custom.php');
	include $pr->getRootPath('lib/Pi.System.php');

	$db = new PiDB($pr->getDB(),$pr);
	$sysConfig = new PiSystem($pr->getRootPath('settings/'),$pr->getUsr('lang'));

	/*
		Struttura dei file delle query:

		< grupppo >.< nome della query >.json --> sys.Oragle_DB_Lock_Sessioni.json

		{
			des : < descrizione >
			--- note : < note >
			null : < valore al posto del null >
			db : < id del db da usare (se null quello di default) >
			html : < *disabled / show / sortable >
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
				enables : < true / false* >
				code : < codice php di fomattazione >
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

	function createMetadataTable($iMetadata){
		$out='<table class="orange lite fix">
			<tr>
				<th><i18n>iface:colum</i18n></th>
				<th><i18n>iface:type</i18n></th>
				<th style="width:80px;"><i18n>iface:remove</i18n></th>
			</tr>';
		foreach($iMetadata ?: [] as $k => $v){

			$tipologia = '<select id="metatype" class="double j-select" data-pi-id="'.$k.'" data-i18n>
							<option value="string" '.($v=='string' ? 'selected':'').'> opt:simpleText </option>
							<option value="numeric" '.($v=='numeric' ? 'selected':'').'> opt:number </option>
							<option value="date" '.($v=='date' ? 'selected':'').'> opt:date </option>
							<option value="datecobol" '.($v=='datecobol' ? 'selected':'').'> opt:dateCobol </option>
							<option value="qry" '.($v=='qry' ? 'selected':'').'> opt:sql </option>
							<option value="link" '.($v=='link' ? 'selected':'').'> opt:link </option>
							<option value="text" '.($v=='text' ? 'selected':'').'> opt:longText </option>
							<option value="hidden" '.($v=='hidden' ? 'selected':'').'> opt:hidden </option>
						</select>';

			$out.='<tr>
				<td style="text-align:right"><b>'.$k.'</b></td>
				<td>'.$tipologia.'</td>
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
		if($iVal == $iNull){
			return $iNotNull;
		}else{
			return htmlentities($iVal);
		}
	}

	session_write_close();
?>
