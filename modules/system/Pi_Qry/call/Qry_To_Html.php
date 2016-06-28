<?php
	$qryConf = json_decode(file_get_contents($pr->getLocalPath("script/".$pr->post('qry'))),true);
	$res = getQryData($pr,$qryConf);

	function parsePHPCode($iRow,$iCode,$iPr){

		function val($iCol){ return $iCol['value']; }
		function isnull($iCol){ return $iCol['value'] == '[[null]]'; }
		function color(&$iCol, $iColor){ $iCol['color'] = $iColor; }
		function bg(&$iCol, $iColor){ $iCol['bg'] = $iColor; }
		function bold(&$iCol, $iVal = true){ $iCol['bold'] = $iVal; }
		function italic(&$iCol, $iVal = true){ $iCol['italic'] = $iVal; }

		foreach($iRow as $K => $V){
			$tName = '$'.str_replace(' ','_',strtolower($K));

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
			$tName = '$'.$K;
			unset($$tName['value']);
			$OUT[$K] = $$tName;
		}

		return Array("row" => $ROW , "col" => $OUT);
	}

	function GetClassPHPFormat($iCfg,$iCol = null){
		if($iCfg == false){ return ''; }
		if($iCol === null){
			switch($iCfg['row']['bg']){
				case '' :
				case 'white' :
					return '';
				case 'black' :
					return 'style="background-color:#000;"';
				default:
					return 'class="'.strtolower($iCfg['row']['bg']).'"';
			}
		}else{
			if(!isset($iCfg['col'][$iCol])){ return ''; }
			switch($iCfg['col'][$iCol]['bg']){
				case '' :
				case 'white' :
					return '';
				case 'black' :
					return 'style="background-color:#000;"';
				default:
					return 'class="'.strtolower($iCfg['row']['bg']).'"';
			}
		}
	}

	function GetTXTfromPHPFormat($iCfg,$iCol,$iVal,$iNull){
		if($iCfg == false){ return nvl($iVal,$iNull); }
		$out = nvl($iVal,$iNull);

		if($iVal != '[[null]]'){
			$bold = $iCfg['col'][$iCol]['bold'] == null ? $iCfg['row']['bold'] : $iCfg['col'][$iCol]['bold'];
			$italic = $iCfg['col'][$iCol]['italic'] == null ? $iCfg['row']['italic'] : $iCfg['col'][$iCol]['italic'];
			switch($iCfg['col'][$iCol]['color']){
				case 'white':
					$out = '<span style="color:#FFF;">'.$out.'</span>';
					break;
				case '' :
				case 'black' :
					break;
				default:
					$out = '<span class="'.$iCfg['col'][$iCol]['color'].'">'.$out.'</span>';
			}
			if($bold){ $out = "<b>{$out}</b>"; }
			if($italic){ $out = "<i>{$out}</i>"; }
		}

		return $out;
	}

	$pr->addHtml('containerList','<div class="panel green" style="text-align:center;"> <i18n>info:htmlResult</i18n> </div>');

	if(count($res) == 0){
		$table = '<div class="panel red" style="text-align:center;"><br><b><i18n>err:noResult</i18n></b><br><br></div>';
	}else{

		if($qryConf['html'] == 'sortable'){
			$color = 'green';
			$sortable = 'data-pi-component="tablesort"';
		}else{
			$color = 'blue';
			$sortable = '';
		}

		$table='<table class="lite '.$color.'" '.$sortable.'><tr>';

		foreach($res[0] as $k => $v){
			$style = '';
			$dataType = '';
			$isHidden = false;
			if($qryConf['metadata'][strtolower($k)]){
				switch($qryConf['metadata'][strtolower($k)]){
					case 'numeric' :
						$dataType = 'data-pi-sort="numeric"';
					break;
					case 'date' :
						$dataType = 'data-pi-sort="data"';
					break;
					case 'hidden':
						$isHidden = true;
					break;
				}
			}
			if(!$isHidden){
				$table.='<th '.$dataType.' >'.$k.'</th>';
			}
		}

		$table.='</tr>';

		$myNull = $qryConf['null'] == '' ? '<i class="disabled"> null </i>' : $qryConf['null'];

		foreach($res as $k => $v){
			$table .= '<tr>';
			foreach($v as $vk => $vv){
				if($qryConf['metadata'][strtolower($vk)]){
					switch($qryConf['metadata'][strtolower($vk)]){
						case 'numeric' :
							$table.='<td style="text-align:right;">'.nvl($vv,$myNull).'</td>';
						break;
						case 'date' :
							$table.='<td style="text-align:center;">'.nvl($vv,$myNull).'</td>';
						break;
						case 'datecobol' :
							$table.='<td style="text-align:center;">'.substr($vv,6,2).'/'.substr($vv,4,2).'/'.substr($vv,0,4).'</td>';
						break;
						case 'qry' :
							$table.='<td style="text-align:center; cursor:pointer;" id="'.$k.'_'.$vk.'" onclick="pi.request(\''.$k.'_'.$vk.'\');">
								<input type="hidden" name="Q" value="Win_Execute_Sql">
								<input type="hidden" name="db" value="'.$qryConf['db'].'">
								<input type="hidden" name="sql" value="'.htmlentities($vv).'">
								<i class="mdi mdi-database"></i> '.$vk.'
							</td>';
						break;
						case 'text' :
							$table.='<td style="text-align:center; cursor:pointer;" onclick="pi.win.open({ content: $(\'#'.$k.'_'.$vk.'\').html(), title:\''.$vk.'\'});">
								<div style="display:none" id="'.$k.'_'.$vk.'"><div style="padding:10px;">'.nvl($vv,$myNull).'</div></div>
								<i class="mdi mdi-comment-text-outline"></i> '.$vk.'
							</td>';
						break;
						case 'link' :
							$table.='<td style="text-align:center;"><a href="'.$vv.'" target="_blank" > [ Link ] </a></td>';
						break;
						case 'string':
							$table.='<td>'.nvl($vv,$myNull).'</td>';
						break;
						case 'hidden':
						break;
					}
				}else{
					$table.='<td>'.nvl($vv,$myNull).'</td>';
				}

			}
			$table .= '<tr>';
		}
	}


	$name = explode('.',$pr->post('qry'));

	$iList = '';
	foreach($qryConf['inputs'] as $k => $v){
		$iList .= '<tr>
			<th>'.$v['des'].' : </th>
			<td>'.($pr->post($k) == '' ? '<i class="blue"> <i18n>iface:noValue</i18n> </i>' : $pr->post($k)).'</td>
		</tr>';
	}


	$out ='<div class="panel">
		<table class="form">
			<tr>
				<th> <i18n>iface:queryName</i18n> </th>
				<td>'.str_replace('_',' ',$name[1]).'</td>
				<th rowspan="'.(count($qryConf['inputs']) + 1).'" id="exec_again">
					<button onclick="$(\'#containerRes\').html(\'\'); pi.request(\'data\',\'Cerca\');"><i class="mdi mdi-close"></i> Chiudi i risulati</button><br>
					<button onclick="pi.request(\'exec_again\')"><i class="mdi mdi-reload"></i> <i18n>btn:execQry</i18n></button>

					<input type="hidden" name="Q" value="Win_Qry_Launcher_Int">
					<input type="hidden" name="qry" value="'.$pr->post('qry').'">
				</th>
			</tr>
			'.$iList.'
		</table>
	</div>'.$table;

	$pr->addHtml('containerRes',$out)->response();

?>
