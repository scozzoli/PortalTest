<?php
	$qryConf = json_decode(file_get_contents($pr->getLocalPath("script/".$pr->post('qry'))),true);
	$res = getQryData($pr,$qryConf);

	$toTable = $qryConf['html'] != 'chart';
	$toSort =  $qryConf['html'] == 'chartsort' || $qryConf['html'] == 'sortable';
	$toChart = $qryConf['html'] == 'chartsort' || $qryConf['html'] == 'chart';

	function GetClassPHPFormat($iCfg,$iCol = null){
		$out = Array('class' => '' , 'style' => '');
		if($iCfg == false){	return $out; }
		if($iCol === null){
			switch($iCfg['row']['bg']){
				case '' :
				case 'white' :
					break;
				case 'black' :
					$out['style'] = 'background-color:#000;' ;
					break;
				default:
					$out['class'] = strtolower($iCfg['row']['bg']);
			}
		}else{
			if(!isset($iCfg['col'][$iCol])){ return $out; }
			switch($iCfg['col'][$iCol]['bg']){
				case '' :
				case 'white' :
					break;
				case 'black' :
					$out['style'] = 'background-color:#000;' ;
					break;
				default:
					$out['class'] = strtolower($iCfg['col'][$iCol]['bg']);
			}
		}
		return $out;
	}

	function GetTXTfromPHPFormat($iCfg,$iCol,$iVal,$iNull){
		if($iCfg == false){ return nvl($iVal,$iNull); }
		$out = nvl($iVal,$iNull);

		if($iVal != '[[null]]'){
			$bold = $iCfg['col'][$iCol]['bold'] == null ? $iCfg['row']['bold'] : $iCfg['col'][$iCol]['bold'];
			$italic = $iCfg['col'][$iCol]['italic'] == null ? $iCfg['row']['italic'] : $iCfg['col'][$iCol]['italic'];
			$myColor = $iCfg['col'][$iCol]['color'] == '' ? $iCfg['row']['color'] : $iCfg['col'][$iCol]['color'];
			switch($myColor){
				case 'white':
					$out = '<span style="color:#FFF;">'.$out.'</span>';
					break;
				case '' :
				case 'black' :
					break;
				default:
					$out = '<span class="'.$myColor.'">'.$out.'</span>';
			}
			if($bold){ $out = "<b>{$out}</b>"; }
			if($italic){ $out = "<i>{$out}</i>"; }
		}

		return $out;
	}
	
	function parseJson($iNode,$iDepth = 0){
		$out = '';
		foreach($iNode as $k => $v){
			if(is_array($v)){
				$out .= '<b class="orange">'.$k.'</b>';
				$out .= '<div class="focus" style="border-left:1px solid;">'.parseJson($v, $iDepth + 1).'</div>';
			}else if ($v === null){
				$out.='<b>'.$k.' : </b> <i class="disabled"> null </i><br>';
			}else if ($v === false || $v === true){
				$out.='<b>'.$k.' : </b> <i class="mdi '.($v ? 'green mdi-checkbox-marked-circle' : 'red mdi-circle-circle').'"></i><br>';
			}else{
				$out.='<b>'.$k.' : </b> '.htmlentities($v).'<br>';
			}
//			$out.='<b>'.$k.'</b>';
//			if(is_array($v)){
//				$out .= '<div class="focus" style="border-left:1px solid;">'.parseJson($v, $iDepth + 1).'</div>';
//			} else {
//				$out .= ' : '.htmlentities($v) . '<br>';
//			}
		}
		return $out;
	}
	
	function GetLongTextFormat($iTxt,$iNull){
		
		$json = json_decode(str_replace('[[null]]','!!',$iTxt),true);
		
		if(json_last_error() === JSON_ERROR_NONE){
			return '<div class="focus green"><b>Json</b></div><div style="padding:10px;">'.parseJson($json).'</div>';
		}else{
			return '<div style="padding:10px">'.nvl($iTxt,$iNull).'</div>';
		}
	}

	function GetValueFromRes($iCols,$iRow,$iIdx,$iNull){
		$out = [];
		
		foreach($iCols as $k => $v){
			$out[] = $iRow[$iIdx[$v]] == $iNull ? 'null' : $iRow[$iIdx[$v]];
		}
		return implode(',',$out);
	}
	
	$pr->addHtml('containerList','<div class="panel green" style="text-align:center;"> <i18n>info:htmlResult</i18n> </div>');

	if($toTable){
		if(count($res) == 0){
			$table = '<div class="panel red" style="text-align:center;"><br><b><i18n>err:noResult</i18n></b><br><br></div>';
		}else{

			if($toSort){
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
					$table.='<th '.$dataType.'>'.$k.'</th>';
				}
			}

			$table.='</tr>';

			$myNull = $qryConf['null'] == '' ? '<i class="disabled"> null </i>' : $qryConf['null'];
			$qryConf['php'] = $qryConf['php'] ?: Array("enabled" => false);

			foreach($res as $k => $v){
				if($qryConf['php']["enabled"]){
					$format = parsePHPCode($v,$qryConf['php']['code'],$pr);
				}else{
					$format = false;
				}
				$phpClass = GetClassPHPFormat($format);
				$table .= '<tr class="'.$phpClass['class'].'" style="'.$phpClass['style'].'">';
				foreach($v as $vk => $vv){
					$phpClass = GetClassPHPFormat($format,$vk);
					if($qryConf['metadata'][strtolower($vk)]){
						switch($qryConf['metadata'][strtolower($vk)]){
							case 'numeric' :
								$table.='<td class="'.$phpClass['class'].'" style="text-align:right; '.$phpClass['style'].'">'.GetTXTfromPHPFormat($format,$vk,$vv,$myNull).'</td>';
							break;
							case 'date' :
								$timeVal = is_object($vv) ? $vv->format('d/m/Y') : $vv;
								$table.='<td class="'.$phpClass['class'].'" style="text-align:center; '.$phpClass['style'].'">'.GetTXTfromPHPFormat($format,$vk,$timeVal,$myNull).'</td>';
							break;
							case 'datecobol' :
								$table.='<td class="'.$phpClass['class'].'" style="text-align:center; '.$phpClass['style'].'">
									'.GetTXTfromPHPFormat($format,$vk,substr($vv,6,2).'/'.substr($vv,4,2).'/'.substr($vv,0,4),$myNull).'
									</td>';
							break;
							case 'qry' :
								$table.='<td class="'.$phpClass['class'].'" style="text-align:center; cursor:pointer; '.$phpClass['style'].'" id="'.$k.'_'.$vk.'" onclick="pi.request(\''.$k.'_'.$vk.'\');">
										<input type="hidden" name="Q" value="Win_Execute_Sql">
										<input type="hidden" name="db" value="'.$qryConf['db'].'">
										<input type="hidden" name="sql" value="'.htmlentities($vv).'">
										<i class="mdi mdi-database"></i> '.GetTXTfromPHPFormat($format,$vk,$vk,$myNull).'
								</td>';
							break;
							case 'text' :
								$table.='<td class="'.$phpClass['class'].'" style="text-align:center; cursor:pointer; '.$phpClass['style'].'" onclick="pi.win.open({ content: $(\'#'.$k.'_'.$vk.'\').html(), title:\''.$vk.'\'});">
										<div style="display:none" id="'.$k.'_'.$vk.'"><div style="word-wrap: break-word;">'.GetLongTextFormat($vv,$myNull).'</div></div>
										<i class="mdi mdi-comment-text-outline"></i> '.GetTXTfromPHPFormat($format,$vk,$vk,$myNull).'
								</td>';
							break;
							case 'link' :
								$table.='<td class="'.$phpClass['class'].'" style="text-align:center; '.$phpClass['style'].'"><a href="'.$vv.'" target="_blank" > [ Link ] </a></td>';
							break;
							case 'string':
								$table.='<td class="'.$phpClass['class'].'" style="'.$phpClass['style'].'">'.GetTXTfromPHPFormat($format,$vk,$vv,$myNull).'</td>';
							break;
							case 'hidden':
							break;
						}
					}else{
						$table.='<td class="'.$phpClass['class'].'" style="'.$phpClass['style'].'">'.GetTXTfromPHPFormat($format,$vk,$vv,$myNull).'</td>';
					}

				}
				$table .= '<tr>';
			}
		}
	}else{
		$table = '';
	}

	if($toChart){
		/*
		 * I grafici normali necessitano di una matrice "invertita"
		 * QRY[<numero riga>][<nome colonna>] = valore
		 * DATA[<nome colonna>][<numero riga>] = valore
		 * Questo a meno che il grafico non si ti tipo "per riga"
		 */
		$reverse = Array();
		foreach ($qryConf['metadata'] as $key => $val) { $reverse[$key] = Array();	}
		foreach($res as $k => $v){
			foreach ($v as $tCell => $tVal) {
				if($qryConf['metadata'][strtolower($tCell)]){
					$reverse[strtolower($tCell)][] = $tVal == $db->opt('null') ? 'null' : $tVal;
				}
			}
		}

		$chart = '';

		switch ($qryConf['chartsize'] ?: 'L') {
			case 'L': $chartsize = '500px'; break;
			case 'M': $chartsize = '350px'; break;
			case 'S': $chartsize = '200px'; break;
		}

		foreach ($qryConf['charts'] as $key => $val) {
			$chart .='<div class="panel pi-size-'.strtolower($val['size']).'">';
			$chart .='<div class="focus nopad-top '.($val['color'] ? :'').'"><span class="'.($val['color'] ? :'').'"><b>'.htmlentities($key).'</b> - '.htmlentities($val['des']).' </span></div>';
			
			if(($val['collection'] ?: 'col') == 'col'){
				$chart .= '<div data-pic="chart : { type : \''.$val['type'].'\'}" style="height:'.$chartsize.';">';
				if($val['labels'] != ''){
					$chart .= '<div data-labels="separator:\'!:!\'">'.implode('!:!',$reverse[$val['labels']]).'</div>';
				}
				foreach($val['data'] as $kd => $vd){
					$chart .='<div data-chart=" type :\''.$vd['type'].'\' , data : { color : \''.$vd['color'].'\', values : ['.implode(',',$reverse[$vd['src']]).']}">'.$kd.'</div>';
				}
			}else{
				$chart .= '<div data-pic="chart : { type : \''.$val['type'].'\'}" style="height:'.$chartsize.';">';
				$chart .= '<div data-labels="separator:\'!:!\'">'.implode('!:!',$val['cols']).'</div>';
				
				$revIdx = [];
				foreach(($res[0] ?: []) as $jKey => $jVal){
					$revIdx[strtolower($jKey)] = $jKey; 
				}
				foreach($res as $jKey => $jVal){
					$chart .='<div data-chart=" type :\''.$val['type'].'\' , data : { values : ['.GetValueFromRes($val['cols'],$jVal,$revIdx,$db->opt('null')).']}">'.$jVal[$revIdx[$val['labels']]].'</div>';
				}
			}
			
			$chart .= '</div> </div>';
		}



	}else{
		$chart = '';
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
	</div>'.$chart.$table;

	$pr->addHtml('containerRes',$out)->response();

?>
