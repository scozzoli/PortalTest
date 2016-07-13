<?php

	$charts = json_decode($pr->post('charts'),true);
	$metadata = json_decode($pr->post('metadata'),true);
	$idx = $pr->post('idx',false);
	$srcIdx = $pr->post('srcidx',false);

	$fill = Array();

	$keys = array_keys($charts);
	$fill['chartKey'] = $keys[$idx];

	$chartType = $charts[$keys[$idx]]['type'];

	if($srcIdx !== false){

		$kData = array_keys($charts[$keys[$idx]]['data']);
		$fill['oldName'] = $kData[$srcIdx];
		$fill['name'] = $kData[$srcIdx];
		$fill['type'] = $charts[$keys[$idx]]['data'][$kData[$srcIdx]]['type'];
		$fill['src'] = $charts[$keys[$idx]]['data'][$kData[$srcIdx]]['src'];
		$fill['color'] = $charts[$keys[$idx]]['data'][$kData[$srcIdx]]['color'];
	}else{
		$fill['oldName'] = '';
		$fill['name'] = '';
		$fill['type'] = $charts[$keys[$idx]] == 'mixed' ? 'bar' : $charts[$keys[$idx]];
		$fill['labels'] = '';
		$fill['color'] = '';
	}

	if($fill['oldName'] != '' && ($chartType != 'pie' && $chartType != 'nut' && $chartType != 'polar') ){
		$footer = '<button class="red" onClick="pi.chk(\'<i18n>chk:removeChart</i18n>\').requestOnModal(\'winEdit\',\'Remove_Chart_Data\');"><i18n>delete</i18n></button>';
	}

	$footer .= '<button class="red" onClick="pi.win.close();"> <i18n>cancel</i18n> </button><button class="green" onClick="pi.requestOnModal(\'winEdit\');"> <i18n>save</i18n> </button>';

	$metaOpt ='<select name="src">
		<option value=""> --- </option>';
	foreach ($metadata as $k => $v) {
		$metaOpt.='<option value="'.$k.'" '.($v == 'numeric' ? '' : 'disabled').'> '.$k.' </option>';
	}
	$metaOpt.='</select>';



	$header = '<i18n>win:headerChartData</i18n>';

	$content = '<div id="winEdit">
		<input type="hidden" name="Q" value="Save_Chart_Data">
		<input type="hidden" name=":LINK:ELEM" value="chartsData">
		<input type="hidden" name="chartKey">
		<div class="focus blue">
			<i18n>info:editChartsData</i18n>
		</div>
		<table class="form separate">
			<tr>
				<th><i18n>lbl:name</i18n></th>
				<td>
					<input type="text" class="ale" name="name" id="autofocusme">
					<input type="hidden" name="oldName">
				</td>
			</tr>
			<tr>
				<th><i18n>lbl:type</i18n></th>
				<td>
					<select name="type" data-i18n>
						<optgroup label="optg:monoData">
							<option value="pie" '.($chartType == 'pie' ? '' : 'disabled').'> opt:chart:pie </option>
							<option value="nut" '.($chartType == 'nut' ? '' : 'disabled').'> opt:chart:nut </option>
							<option value="polar" '.($chartType == 'polar' ? '' : 'disabled').'> opt:chart:polar </option>
						</optgroup>
						<optgroup label="optg:multiData">
							<option value="bar" '.($chartType == 'bar' || $chartType == 'mixed'? '' : 'disabled').'> opt:chart:bar </option>
							<option value="line" '.($chartType == 'line' || $chartType == 'mixed' ? '' : 'disabled').'> opt:chart:line </option>
							<option value="area" '.($chartType == 'area' || $chartType == 'mixed' ? '' : 'disabled').'> opt:chart:area </option>
							<option value="radar" '.($chartType == 'radar' ? '' : 'disabled').'> opt:chart:radar </option>
						</optgroup>
					</select>
				</td>
			</tr>
			<tr>
				<th><i18n>lbl:src</i18n></th>
				<td>
					'.$metaOpt.'
				</td>
			</tr>
			<tr>
				<th><i18n>lbl:color</i18n></th>
				<td>
					<select name="color" data-i18n>
						<option value=""> opt:noColor </option>
						<option value="blue"> opt:colorBlue </option>
						<option value="green"> opt:colorGreen </option>
						<option value="orange"> opt:colorOrange </option>
						<option value="red"> opt:colorRed </option>
						<option value="purple"> opt:colorPurple </option>
					</select>
				</td>
			</tr>
		</table>
	</div>';



	//$fill = Array('inputs' => $pr->post('inputs'));

	$pr->addWindow(450,0,$header,$content,$footer)->addFill('winEdit',$fill)->addScript('$("#autofocusme").focus();')->response();
?>
