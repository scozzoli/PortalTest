<?php
	$js = '$(document).ready(function(){
			$("#intFocusMe").focus();
			shortcut("enter",function(){pi.request("data","Cerca")},{target:"intFocusMe", propagate:false});
			pi.silent().request("data","Cerca");
		});';
	$sd->includeScript($js);
	$sd->includeLib('./lib/js/ace/ace.js');
	$sd->includeLib('./lib/js/chart.bundle.min.js');
	$sd->includeLib('./lib/Pi.Component.Code.js');
	$sd->includeLib('./lib/Pi.Component.Chart.js');
	
	$showNewButton = false;
	if($_SESSION[MSID]['usr'] == 'root'){
		$showNewButton = true;
	}else{
		$showNewButton = ($_SESSION[MSID]['config']['grp']['qry'] ?: $_SESSION[MSID]['config']['grpdef']) == 1;
	}

	$insNew = $showNewButton ? '<button class="blue" onclick="pi.request(null,\'Int_Edit_Query\')"><i class="mdi mdi-note-plus"></i> <i18n>iface:newQry</i18n></button>' : '';

	$interface = '<div class="blue panel" id="data">
				<table class="form">
					<tr>
						<th><i18n>iface:nameOrDesc</i18n> </th>
						<td><input type="text" name="cerca" class="full" id="intFocusMe"></td>
						<th><button class="blue" onclick="pi.request(\'data\',\'Cerca\');"><i class="mdi mdi-magnify"></i> <i18n>search</i18n></button> '.$insNew .'</th>
					</tr>
				</table>
			</div>
			<div id="containerList"></div>
			<div id="containerRes"></div>';

?>
