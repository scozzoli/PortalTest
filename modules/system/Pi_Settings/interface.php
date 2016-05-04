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
				<td><i18n>iface:info</i18n></td>
				<th><button class="blue" onClick="pi.request(null,\'Win_Select_Save_Format\')"><i18n>btn:configFormat</i18n></button></th>
			</tr>
		</table>
		
	</DIV>
	<div id="load_interface">
		<table width="100%">
			<tr>
				<td width="20%">
					<div class="panel blue">
						<table width="100%"><tr>
							<td><i18n>iface:users</i18n></td>
							<td style="text-align:right;">
								<button class="blue" onclick="pi.request(null,\'Usr_Load_Interface\')"><i18n>iface:btn:users</i18n></button>
							</td>
						</tr></table>				
					</div>
				</td>
				<td width="20%">
					<div class="panel green">
						<table width="100%"><tr>
							<td><i18n>iface:modules</i18n></td>
							<td style="text-align:right;">
								<button class="green" onclick="pi.request(null,\'Mod_Load_Interface\')"><i18n>iface:btn:modules</i18n></button>
							</td>
						</tr></table>				
					</div>
				</td>
				<td width="20%">
					<div class="panel orange">
						<table width="100%"><tr>
							<td><i18n>iface:groups</i18n></td>
							<td style="text-align:right;">
								<button class="orange" onclick="pi.request(null,\'Grp_Load_Interface\')"><i18n>iface:btn:groups</i18n></button>
							</td>
						</tr></table>				
					</div>
				</td>
				<td width="20%">
					<div class="panel red">
						<table width="100%"><tr>
							<td><i18n>iface:menus</i18n></td>
							<td style="text-align:right;">
								<button class="red" onclick="pi.request(null,\'Menu_Load_Interface\')"><i18n>iface:btn:menus</i18n></button>
							</td>
						</tr></table>				
					</div>
				</td>
				<td width="20%">
					<div class="panel purple">
						<table width="100%"><tr>
							<td><i18n>iface:db</i18n></td>
							<td style="text-align:right;">
								<button class="purple" onclick="pi.request(null,\'DB_Load_Interface\')"><i18n>iface:btn:db</i18n></button>
							</td>
						</tr></table>				
					</div>
				</td>
			</tr>
		</table>
	</div>
	<div id="container"></div>';
?>
