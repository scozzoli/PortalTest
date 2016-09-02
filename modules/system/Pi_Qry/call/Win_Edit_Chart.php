<?php

	$charts = json_decode($pr->post('charts'),true);
	$metadata = json_decode($pr->post('metadata'),true);
	$idx = $pr->post('idx',false);

	$fill = Array();

	if($idx !== false){
		$footer = '<button class="red" onClick="pi.chk(\'<i18n>chk:removeChart</i18n>\').requestOnModal(\'winEdit\',\'Remove_Chart\');"><i18n>delete</i18n></button>';
		$keys = array_keys($charts);
		$fill['oldName'] = $keys[$idx];
		$fill['name'] = $keys[$idx];
		$fill['des'] = $charts[$keys[$idx]]['des'];
		$fill['size'] = $charts[$keys[$idx]]['size'];
		$fill['type'] = $charts[$keys[$idx]]['type'];
		$fill['labels'] = $charts[$keys[$idx]]['labels'];
		$fill['color'] = $charts[$keys[$idx]]['color'];
	}else{
		$footer = '';
		$fill['size'] = 'L';
		$fill['labels'] = '';
	}

	$footer .= '<button class="red" onClick="pi.win.close();"> <i18n>cancel</i18n> </button><button class="green" onClick="pi.requestOnModal(\'winEdit\');"> <i18n>save</i18n> </button>';

	$metaOpt ='<select name="labels">
		<option value=""> --- </option>';
	foreach ($metadata ?: [] as $k => $v) {
		$metaOpt.='<option value="'.$k.'"> '.$k.' </option>';
	}
	$metaOpt.='</select>';

	$header = '<i18n>win:headerChart</i18n>';

	$content = '<div id="winEdit">
		<input type="hidden" name="Q" value="Save_Chart">
		<input type="hidden" name=":LINK:ELEM" value="chartsData">
		<div class="focus blue">
			<i18n>info:editCharts</i18n>
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
				<th><i18n>lbl:desc</i18n></th>
				<td> <input type="text" class="double" name="des"></td>
			</tr>
			<tr>
				<th><i18n>lbl:type</i18n></th>
				<td>
					<select name="type" data-i18n>
						<optgroup label="optg:monoData">
							<option value="pie"> opt:chart:pie </option>
							<option value="nut"> opt:chart:nut </option>
							<option value="polar"> opt:chart:polar </option>
						</optgroup>
						<optgroup label="optg:multiData">
							<option value="mixed"> opt:chart:mixed </option>
							<option value="bar"> opt:chart:bar </option>
							<option value="line"> opt:chart:line </option>
							<option value="area"> opt:chart:area </option>
							<option value="radar"> opt:chart:radar </option>
						</optgroup>
					</select>
				</td>
			</tr>
			<tr>
				<th><i18n>lbl:size</i18n></th>
				<td>
					<select name="size" data-i18n>
						<option value="S"> opt:size:s </option>
						<option value="M"> opt:size:m </option>
						<option value="L"> opt:size:l </option>
					</select>
				</td>
			</tr>
			<tr>
				<th><i18n>lbl:labels</i18n></th>
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

	$pr->addWindow(600,0,$header,$content,$footer)->addFill('winEdit',$fill)->addScript('$("#autofocusme").focus();')->response();
?>
