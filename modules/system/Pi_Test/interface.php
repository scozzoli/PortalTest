<?php
	$interface = '<div class="panel blue">
				Elenco degli stili applicabili
			</div>
			<div class="panel orange">
				<button onclick="pi.request(null,\'Show_Div\')">Stili DIV</button>
				<button onclick="pi.request(null,\'Show_Span\')">Stili Testo</button>
				<button onclick="pi.request(null,\'Show_Input\')">Stili INPUT</button>
				<button onclick="pi.request(null,\'Show_Table\')">Stili Tabelle</button>
				<button onclick="pi.request(null,\'Show_Modal\')">Stili Finestre</button>
				<button onclick="pi.request(null,\'Show_Icons\')">Material Icons</button>
			</div>			
			<div id="container" style="height:100%">
				<div class="panel">
					<table class="form">
						<tr>
							<th> Server IP </th>
							<td>'.$_SERVER['SERVER_ADDR'].'</td>
						</tr>
						<tr>
							<th> Client IP </th>
							<td>'.$_SERVER['REMOTE_ADDR'].'</td>
						</tr>
					</table>
				</div>
			</div>';
?>
