<?php
	$js = '$(document).ready(
		function(){
			pi.request(null,"LoadDbList");
		}
	);';
	$sd->includeScript($js);
	$sd->includeLib('./lib/js/ace/ace.js');
	$sd->includeLib('./lib/Pi.Component.Code.js');
	
	$interface = '<div class="panel blue">
				Strumenti per la ricerca di campi e tabelle all\interno dei DB.<br>
				Alcune funzioni potrebbero non essere abilitate a seconda del DB che si seleziona
			</div>
			<div class="panel orange" id="data">
				<table class="form">
					<tr>
						<th> Cerca : </th>
						<td> <input type="text" class="full" name="cerca" id="cerca" disabled> </td>
						<th> DB : </th>
						<td id="DBList"> Caricamento lista dei DB in corso ... </td>
						<th>
							<button id="SessionBtn" class="orange" onclick="pi.request(\'data\',\'SessionManager\')" disabled><i class="mdi mdi-server-network"></i> Processi </button>
						</th>
						<th>
							<button id="LockBtn" class="orange" onclick="pi.request(\'data\',\'Lock\')" disabled><i class="mdi mdi-lock"></i> Lock </button>
						</th>
						<th>
							<button id="SubmitBtn" class="orange" onclick="pi.request(\'data\',\'Cerca\')" disabled><i class="mdi mdi-magnify"></i> Cerca </button>
						</th>
					</tr>
				</table>
			</div>
			<div id="container"></div>';

?>