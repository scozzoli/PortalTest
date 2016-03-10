<?php
	//$lev_path = substr_count($sd->get_mod_include(),'/'); // mi serve per capire a che livello si trova remote
	/*
	<table width="100%">
			<tr>
				<th width="20%"><button onclick="pi.request(null,\'Usr_Load_Interface\')">Utenti</button></th>
				<th width="20%"><button onclick="pi.request(null,\'Grp_Load_Interface\')">Gruppi</button></th>
				<th width="20%"><button onclick="pi.request(null,\'Mod_Load_Interface\')">Moduli</button></th>
				<th width="20%"><button onclick="pi.request(null,\'Menu_Load_Interface\')">Menu</button></th>
				<th width="20%"><button onclick="pi.request(null,\'DB_Load_Interface\')">DB</button></th>
			</tr>
		</table>
	*/
	
	$interface = '<DIV class="panel blue">
		<table class="form">
			<tr>
				<td>Creazione e gestione di utenti, gruppi, moduli, men&uacute; e risorse dati. &Eacute; possibile anche selezionare il formato del salvataggio della configurazione</td>
				<th><button class="blue" onClick="pi.request(null,\'Win_Select_Save_Format\')">Formato configurazione</button></th>
			</tr>
		</table>
		
	</DIV>
	<div id="load_interface">
		<table width="100%">
			<tr>
				<td width="20%">
					<div class="panel blue">
						<table width="100%"><tr>
							<td>Creazione e manutenzione utenti</td>
							<td style="text-align:right;">
								<button class="edit" onclick="pi.request(null,\'Usr_Load_Interface\')"><div>Utenti</div></button>
							</td>
						</tr></table>				
					</div>
				</td>
				<td width="20%">
					<div class="panel green">
						<table width="100%"><tr>
							<td>Registrazione e Gestione Moduli</td>
							<td style="text-align:right;">
								<button class="edit" onclick="pi.request(null,\'Mod_Load_Interface\')"><div>Moduli</div></button>
							</td>
						</tr></table>				
					</div>
				</td>
				<td width="20%">
					<div class="panel orange">
						<table width="100%"><tr>
							<td>Gestione Gruppi di permessi</td>
							<td style="text-align:right;">
								<button class="edit" onclick="pi.request(null,\'Grp_Load_Interface\')"><div>Gruppi</div></button>
							</td>
						</tr></table>				
					</div>
				</td>
				<td width="20%">
					<div class="panel red">
						<table width="100%"><tr>
							<td>Composizione menu per utenti</td>
							<td style="text-align:right;">
								<button class="edit" onclick="pi.request(null,\'Menu_Load_Interface\')"><div>Menu</div></button>
							</td>
						</tr></table>				
					</div>
				</td>
				<td width="20%">
					<div class="panel purple">
						<table width="100%"><tr>
							<td>Registrazione Base Dati</td>
							<td style="text-align:right;">
								<button class="edit" onclick="pi.request(null,\'DB_Load_Interface\')"><div>DB</div></button>
							</td>
						</tr></table>				
					</div>
				</td>
			</tr>
		</table>
	</div>
	<div id="container"></div>';
?>
