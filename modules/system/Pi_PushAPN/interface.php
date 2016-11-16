<?php
	$js = '$(document).ready(
		function(){
			$("#focusme").focus();
			shortcut("enter",function(){pi.request("data");},{type:"keydown",propagate:false,target:"focusme"});
		}
	);';
	$sd->includeScript($js);
	
	$settings = json_decode(file_get_contents($sd->getModulePath().'/settings.json'),true);
	
	$selectList = '<select name="device">'
			. '<option value="*"> Custom </option>';
	foreach ($settings['device'] as $k => $v){
		$selectList .= '<option value="'.$v.'">'.$k.'</option>';
	}
	$selectList .= '</select>';
	
	$cert = scandir($sd->getModulePath().'/cert/');
	$certList = '<select name="serverkey">';
	
	foreach ($cert as $k => $v){
		if($v == '.' || $v == '..') continue;
		$certList .= '<option value="'.$v.'">'.$v.'</option>';
	}
	
	$certList .= '</select>';
	
	$interface = '<div class="panel blue">
			</div>
			<div class="panel orange" id="data">
				<table class="form">
					<tr>
						<th>API Key : </th>
						<td>
							<input type="hidden" name="Q" value="Send">
							'.$certList.'
						</td>
					</tr>
					<tr>
						<th> Distribuzione : </th>
						<td> <input type="checkbox" name="distribution"> </td>
					</tr>
					<tr>
						<th>Device : </th>
						<td>
							'.$selectList.'
								<input type="text" class="full" name="CustomDevice">
						</td>
					</tr>
					<tr>
						<th>Titolo : </th>
						<td><input type="text" name="title" class="full"></td>
					</tr>
					<tr>
						<th>Testo : </th>
						<td><input type="text" name="text" class="full"></td>
					</tr>
					<tr>
						<th>Custom 1 : </th>
						<td>Chiave : <input type="text" name="c1" class="small"> Valore : <input type="text" name="v1" ></td>
					</tr>
					<tr>
						<th>Custom 2 : </th>
						<td>Chiave : <input type="text" name="c2" class="small"> Valore : <input type="text" name="v2" ></td>
					</tr>
					<tr>
						<th>Colore Led (RGB): </th>
						<td>
							<input type="text" name="r" class="small" value="0"> -
							<input type="text" name="g" class="small" value="255"> -
							<input type="text" name="b" class="small" value="0"> -- badge
							<input type="text" name="count" class="small" value="0">
						</td>
					</tr>
				</table>
				<div class="footer">
					<button onclick="pi.request(\'data\')">Invia</button>
				</div>
			</div>
			<div id="container"></div>';
?>