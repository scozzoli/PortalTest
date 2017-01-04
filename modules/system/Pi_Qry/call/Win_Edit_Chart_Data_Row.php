<?php

	$charts = json_decode($pr->post('charts'),true);
	$metadata = json_decode($pr->post('metadata'),true);
	$idx = $pr->post('idx',false);
	$srcIdx = $pr->post('srcidx',false);

	$fill = Array();

	$keys = array_keys($charts);
	$fill['chartKey'] = $keys[$idx];

	$chartType = $charts[$keys[$idx]]['type'];
	$fill['name'] = $kData[$srcIdx];
	$cols = $charts[$keys[$idx]]['cols'];
	
	
	$kData = array_keys($charts[$keys[$idx]]['data']);
	$fill['color'] = '';
	$fill['name'] = $kData[$srcIdx];
	$fill['oldName'] = $kData[$srcIdx];
	$fill['type'] = $charts[$keys[$idx]]['data'][$kData[$srcIdx]]['type'];
	$fill['src'] = '';
	
	$footer .= '<button class="red" onClick="pi.win.close();"> <i18n>cancel</i18n> </button><button class="green" onClick="pi.requestOnModal(\'winEdit\');"> <i18n>save</i18n> </button>';

	$metaList = '<table class="form">';
	$metaIdx = 0;
	foreach ($metadata as $k => $v) {
		if($v != 'numeric') { continue; }
		if($metaIdx % 2 == 0){ $metaList.='<tr>'; }
		$metaList.='<th>
				<input type="checkbox" name="md-'.$metaIdx.'" '.(array_search($k, $charts[$keys[$idx]]['cols'])!== false ? 'checked' : '' ).'>
				<input type="hidden" name="mdv-'.$metaIdx.'">
				</th>';
		$fill['mdv-'.$metaIdx] = $k;
		$metaList.='<td>'.$k.'</td>';
		if($metaIdx % 2 == 1){ $metaList.='</tr>'; }
		$metaIdx++;
	}
	if($metaIdx % 2 == 1){ $metaList.='<td></td></tr>'; }
	$metaList .= '</table>';

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
					<input type="hidden" name="type">
					<input type="hidden" name="color">
					<input type="hidden" name="src">
				</td>
			</tr>
			<tr>
				<th><i18n>lbl:src</i18n></th>
				<td>
					'.$metaList.'
				</td>
			</tr>
		</table>
	</div>';



	//$fill = Array('inputs' => $pr->post('inputs'));

	$pr->addWindow(450,0,$header,$content,$footer)->addFill('winEdit',$fill)->addScript('$("#autofocusme").focus();')->response();
?>
