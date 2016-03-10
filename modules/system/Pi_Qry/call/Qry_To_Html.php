<?php
	$qryConf = json_decode(file_get_contents($pr->getLocalPath("script/".$pr->post('qry'))),true);
	$res = getQryData($pr,$qryConf);
	
	$pr->addHtml('containerList','<div class="panel green" style="text-align:center;"> Cliccare su <b>Cerca</b> per visualizzare nuovamente la lista (questo non canceller&aacute; i risultati)</div>');
	
	if(count($res) == 0){
		$table = '<div class="panel red" style="text-align:center;"><br><b>L\'interrogazione non ha riportato risultati</b><br><br></div>';
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
			<td>'.($pr->post($k) == '' ? '<i class="blue"> Nessun valore </i>' : $pr->post($k)).'</td>
		</tr>';
	}
	
	
	$out ='<div class="panel">
		<table class="form">
			<tr>
				<th> Nome Interrogazione : </th>
				<td>'.str_replace('_',' ',$name[1]).'</td>
				<th rowspan="'.(count($qryConf['inputs']) + 1).'" id="exec_again"> 
					<button onclick="$(\'#containerRes\').html(\'\'); pi.request(\'data\',\'Cerca\');"><i class="mdi mdi-close"></i> Chiudi i risulati</button><br>
					<button onclick="pi.request(\'exec_again\')"><i class="mdi mdi-reload"></i> Esegui Query</button>
					
					<input type="hidden" name="Q" value="Win_Qry_Launcher_Int">
					<input type="hidden" name="qry" value="'.$pr->post('qry').'">
				</th>
			</tr>
			'.$iList.'
		</table>
	</div>'.$table;
	
	$pr->addHtml('containerRes',$out)->response();
	
?>