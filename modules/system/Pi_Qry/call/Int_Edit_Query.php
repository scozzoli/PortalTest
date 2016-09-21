<?php
	if($pr->post('qry',false) === false){
		$qryConf = Array(
			'des' => 'Nuova Interrogazione',
			'enabled' => true,
			'null' => '',
			'db' => '',
			'color' => '',
			'icon'=>'mdi-comment-text-outline',
			'qry'=>'',
			'html'=>'disabled',
			'xls'=>'disabled',
			'inputs'=> null,
			'metadata'=> null
		);

		$filename = '';
		$grp = 'qry';
		$icon = 'mdi-comment-text-outline';

		$shodel = '';
	}else{
		$qryConf = json_decode(file_get_contents($pr->getLocalPath("script/".$pr->post('qry'))),true);
		$parts = explode('.',$pr->post('qry'));
		$title = str_replace('_',' ',$parts[1]);
		$icon = $qryConf['icon'] ?: 'mdi-comment-text-outline';
		$filename = $pr->post('qry');
		$grp = $parts[0];

		$showdel = '<div class="panel red">
			<table class="form">
				<tr>
					<td><i18n>info:deleteQry</i18n></td>
					<th><button class="red" onclick="pi.chk(\'<i18n>chk:removeQry</i18n>\').request(\'qryDataForm\',\'Delete_Query\')"><i class="mdi mdi-delete"></i><i18n>btn:removeQry</i18n></button></th>
				</tr>
			</table>
		</div>';
	}

	$db_list = $sysConfig->loadDB();
	$grp_list = $sysConfig->loadGrp();

	$fill = Array(
		'des' => $qryConf['des'],
		'enabled' => $qryConf['enabled'],
		'null' => $qryConf['null'] ?: '',
		'db' => $qryConf['db'] ?: '',
		'color' => $qryConf['color'] ?: '',
		'grp' => $grp,
		'html' => $qryConf['html'],
		'xls' => $qryConf['xls'],
		'icon' => $icon,
		'qry' => $qryConf['qry'],
		'filename' => $filename
	);

	$ddDB = '<select name="db">
		<option value=""> Default Utente </option>
		<optgroup label="DB registrati">';
	foreach($db_list as $k => $v){
		if($v['hide']==0){
			$ddDB .='<option value="'.$k.'">'.$v['des'].'</option>';
		}
	}
	$ddDB .= '</optgroup></select>';

	$ddGrp ='<select name="grp" class="ale">';
	foreach($grp_list as $k => $v){
		$ddGrp.='<option value="'.$k.'">'.$k.' - '.$sysConfig->i18nGet($v["nome"]).'</option>';
	}
	$ddGrp.='</select>';

	$inputs = createInputsTable($qryConf['inputs']);
	$charts = createChartTable($qryConf['charts']);
	$metadata = createMetadataTable($qryConf['metadata']);
	$fill['inputs'] = json_encode($qryConf['inputs']);
	$fill['metadata'] = json_encode($qryConf['metadata']);
	$fill['php'] = json_encode($qryConf['php'] ?: Array('enabled' => false, 'code' => ''));
	$fill['charts'] = json_encode($qryConf['charts'] ?: Array());
	$fill['chartsize'] = $qryConf['chartsize'] ?: 'L';



	$out = $showdel.'<div class="panel">
		<table class="form" id="qryDataForm">
			<tr>
				<th> <i18n>lbl:name</i18n> </th>
				<td>
					'.$ddGrp.' <input type="text" class="double ale" value="'.$title.'" name="name">
					<input type="hidden" name="filename">
				</td>
			</tr>
			<tr>
				<th> <i18n>lbl:desc</i18n> </th>
				<td> <input type="text" class="double" name="des"> </td>
			</tr>
			<tr>
				<th> <i18n>lbl:enable</i18n> </th>
				<td> <input type="checkbox" name="enabled"> </td>
			</tr>
			<tr>
				<th> <i18n>lbl:null</i18n> </th>
				<td> <input type="text" class="double" name="null"> </td>
			</tr>
			<tr>
				<th> <i18n>lbl:db</i18n> </th>
				<td> '.$ddDB.' </td>
			</tr>
			<tr>
				<th> <i18n>lbl:color</i18n> </th>
				<td>
					<select name="color" data-i18n>
						<option> opt:noColor </option>
						<option value="blue"> opt:colorBlue </option>
						<option value="green"> opt:colorGreen </option>
						<option value="orange"> opt:colorOrange </option>
						<option value="red"> opt:colorRed </option>
						<option value="purple"> opt:colorPurple </option>
					</select>
				</td>
			</tr>
			<tr>
				<th> <i18n>lbl:icon</i18n> </th>
				<td>
					<input type="hidden" name="icon" id="icon_icon">
					<button onClick="pi.request(\'qryDataForm\',\'Win_Load_Icons\')" class="icon"> <i class="mdi l2 '.$icon.'" id="icon_show"></i> </button>
				</td>
			</tr>
			<tr>
				<th> <i18n>lbl:html</i18n> </th>
				<td>
					<select name="html" class="double" data-i18n>
						<option value="disabled"> opt:disabled </option>
						<optgroup label="optg:onlyData">
							<option value="show"> opt:htmlTable </option>
							<option value="sortable"> opt:htmlSortable </option>
						</optgroup>
						<optgroup label="optg:chart">
							<option value="chart"> opt:htmlChart </option>
							<option value="charttab"> opt:htmlChartTable </option>
							<option value="chartsort"> opt:htmlChartSortable </option>
						</optgroup>
					</select>
					<b><i18n>lbl:chartSize</i18n></b>
					<select name="chartsize" data-i18n>
						<option value="S"> opt:size:s </option>
						<option value="M"> opt:size:m </option>
						<option value="L"> opt:size:l </option>
					</select>
				</td>
			</tr>
			<tr>
				<th> <i18n>lbl:excel</i18n> </th>
				<td>
					<select name="xls" class="double" data-i18n>
						<option value="disabled"> opt:disabled </option>
						<optgroup label="optg:noFormat">
							<option value="legacy"> opt:excel95Biff </option>
							<option value="csv"> opt:csvComma </option>
							<option value="csve"> opt:csv </option>
						</optgroup>
						<optgroup label="optg:format">
							<option value="xls"> opt:excel95 </option>
							<option value="xlsx"> opt:openXml </option>
							<option value="ods"> opt:openDoc </option>
						</optgroup>
					</select>
				</td>
			</tr>
			<tr>
				<th> <i18n>lbl:qry</i18n> </th>
				<td>
					<input type="hidden" name="qry">
					<input type="hidden" name="php" id="php_qry_value">
					<button onClick="pi.request(\'qryDataForm\',\'Win_Edit_Query\')"> <i class="mdi mdi-pencil"> </i> <i18n>btn:modQry</i18n> </button>
					<button onClick="pi.request(\'qryDataForm\',\'Win_Edit_Php_Format\')"> <i class="mdi mdi-brush"> </i> <i18n>btn:phpFormat</i18n> </button>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<div class="focus blue"> <i18n>info:paramList</i18n> </div>
					<div id="inputList">'.$inputs.'</div>
					<input type="hidden" name="inputs">
				</td>
			</tr>
			<tr>
				<td colspan="2" >
					<div class="focus green">
					<table class="form">
						<tr>
							<td style="width: 30px"><i class="mdi mdi-chart-areaspline l3"></i></td>
							<td><i18n>info:charts</i18n></td>
							<th>
								<button class="green" onclick="pi.request(\'qryDataFormChart\',\'Win_Edit_Chart\')"><i class="mdi mdi-plus"></i> <i18n>add</i18n> </button>
							</th>
						</tr>
					</table>
					</div>
					<div id="chartsList">'.$charts.'</div>
					<span id="qryDataFormChart">
						<input type="hidden" name="charts" id="chartsData">
						<input type="hidden" name=":LINK:ELEM" value="metadataInput">
					</span>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<div class="focus orange">
						<table class="form">
							<tr>
								<td style="width: 30px"><i class="mdi mdi-shape-plus l3"></i></td>
								<td><i18n>info:metadata</i18n></td>
								<th>
									<button class="orange" id="hideShowMetadataButton"><i class="mdi mdi-eye"></i> <i18n>btn:show</i18n> </button>
								</th>
							</tr>
						</table>
					</div>
					<div id="metadataList" style="display:none;">
						<div class="focus orange">
							<table class="form">
								<tr>
									<td>
										<input type="text" id="metadataName" placeHolder="Nome Colonna">
										<button class="orange" id="metadataAdd"> <i class="mdi mdi-plus"></i> <i18n>add</i18n> </button>
									</td>
									<th>
										<button class="orange" onclick="pi.request(\'qryDataForm\',\'Win_Get_Metadata_From_Qry\')"> <i class="mdi mdi-download"></i> <i18n>btn:loadFromQuery</i18n> </button>
									</th>
								</tr>
							</table>
						</div>
						<div id="metadataTable">'.$metadata.'</div>
						<input type="hidden" name="metadata" id="metadataInput">
					</div>
				</td>
			</tr>
		</table>
		<div class="footer">
			<button onClick="pi.request(\'data\',\'Cerca\')"><i class="mdi mdi-arrow-left"></i> <i18n>cancel</i18n> </button>
			<button class="green" onClick="pi.request(\'qryDataForm\',\'Save_Query\')"><i class="mdi mdi-content-save"></i> <i18n>save</i18n></button>
		</div>
	</div>';

	$js="$('#hideShowMetadataButton').on('click',function(e){
		var button = $('#hideShowMetadataButton');
		if($('#metadataList').css('display') == 'none'){
			$('#metadataList').slideDown('fast');
			button.html('<i class=\"mdi mdi-eye-off\"></i> <i18n>btn:hide</i18n> ');
		}else{
			$('#metadataList').slideUp('fast');
			button.html('<i class=\"mdi mdi-eye\"></i> <i18n>btn:show</i18n> ');
		}
		pi.i18n.parse(button);
	});
	$('#metadataAdd').on('click',function(e){
		var keyElem = $('#metadataName');
		var keyVal = keyElem.val().trim().toLowerCase();
		if(keyVal != ''){
			var val = JSON.parse($('#metadataInput').val())||{};
			if(!val[keyVal]){
				val[keyVal] = 'string';
				$('#metadataInput').val(JSON.stringify(val));
				pi.silent().request('qryDataForm','Calc_Add_Metadata');
			}
		}
		keyElem.val('');
		keyElem.focus();
	});
	$('#metadataTable').on('click','.j-delete',function(e){
		var val = JSON.parse($('#metadataInput').val()) || {};
		var td = $(e.target).closest('td');
		var tr = $(e.target).closest('tr');
		var key = td.attr('data-pi-id');
		delete(val[key]);
		$('#metadataInput').val(JSON.stringify(val));
		tr.remove();
	});

	$('#metadataTable').on('click','.j-select',function(e){
		var val = JSON.parse($('#metadataInput').val()) || {};
		var key = $(e.target).attr('data-pi-id');
		val[key] = $(e.target).val();
		$('#metadataInput').val(JSON.stringify(val));
	});";

	$pr->addHtml('containerRes','')->addHtml('containerList',$out)->addScript($js)->addFill('qryDataForm',$fill)->response();
?>
