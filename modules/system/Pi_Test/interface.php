<?php
	$sd->includeLib('./lib/Pi.Component.Calendar.js');
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
				<button onclick="pi.request(null,\'Show_Cal\')">Calendario</button>
			</div>			
			<div id="container" style="height:100%">
				<div class="panel" data-pi-component="collapse">
					<div class="header"> test </div>
					<div>
						<div data-pi-component="tabstripe">
							<div data-pi-tab="primo">
								<table class="lite" data-pi-component="tablesort">
									<tr>
										<th>Ciao</th>
										<th>Ciccia</th>
										<th>Puffi</th>
									</tr>
									<tr>
										<td>1</td>
										<td>2</td>
										<td>3</td>
									</tr>
									<tr>
										<td>1.3</td>
										<td>2.2</td>
										<td>3.1</td>
									</tr>
								</table>
							</div>
							<div data-pi-tab="secondo">
								nulla
							</div>
							<div data-pi-tab="uffa">
								<div class="panel blue"> BU! </div>
							</div>
						</div>
					</div>
				</div>
				
				<div data-pic="tabstripe" class="panel">
					<div data-pi-tab="primo">
						<table class="lite" data-pi-component="tablesort">
							<tr>
								<th>Ciao</th>
								<th>Ciccia</th>
								<th>Puffi</th>
							</tr>
							<tr>
								<td>1</td>
								<td>2</td>
								<td>3</td>
							</tr>
							<tr>
								<td>1.3</td>
								<td>2.2</td>
								<td>3.1</td>
							</tr>
						</table>
					</div>
					<div data-pi-tab="secondo">
						<div class="panel" data-pic="collapse" id="xx">
							<div class="header">Collapse ME!</div>
							fuffa fuffa<br>fuffa fuffa
							<div class="footer">
								<button> WOW </button>
							</div>
						</div>
						nulla
					</div>
					<div data-pi-tab="uffa">
						<div class="panel blue"> BU! </div>
					</div>
				</div>
				
				<div class="panel" data-pic="collapse">
					
					fuffa varia
					
					<div class="panel" data-pic="collapse">
						<div class="header"> hello </div>
						<i18n>save</i18n> <br> <i18n>NK</i18n>
						
					</div>
					
					<div class="panel" data-pic="collapse">
						<div class="header"> hi </div>
						fuffa a caso
						
					</div>
					
				</div>
					
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
