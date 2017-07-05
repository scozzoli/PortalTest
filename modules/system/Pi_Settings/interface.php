<?php
	
	$interface = '<DIV class="panel blue">
		<table class="form">
			<tr>
				<td><i18n>iface:info</i18n></td>
				<th><button class="blue" onClick="pi.request(null,\'Win_Select_Save_Format\')"><i18n>btn:configFormat</i18n></button></th>
			</tr>
		</table>
		
	</DIV>
	<div class="panel">
		<div data-pi-component="tabstripe">
			<div class="blue" data-pi-i18n="iface:btn:users">
				<div class="blue panel" style="text-align:center;">
					<table class="form" id="cerca_utente">
						<tr>
							<th>
								<input type="hidden" name="Q" value="Usr/Load_Interface">
								<i18n>usr:iface:lblUser</i18n>
							</th>
							<td> <input type="text" name="cerca" class="full" id="input_cerca_utente"> </td>
							<td> <button class="blue" onclick="pi.request(\'cerca_utente\');"><i class="mdi mdi-magnify"></i> <i18n>search</i18n> </button></td>
							<th> <button class="blue" onclick="pi.request(null,\'Usr/Win_Load_Dett\');"><i class="mdi mdi-account-plus"></i> <i18n>usr:btn:newUser</i18n> </button></th>
						</tr>
					</table>
				</div> 
				<div id="container-user"></div>
			</div>
			<div class="green" data-pi-i18n="iface:btn:modules">
				<div class="panel green" style="text-align:center;">
					<table class="form" id="cerca_modulo">
						<tr>
							<th>
								<input type="hidden" name="Q" value="Mod/Load_Interface">
								<i18n>mod:iface:nameModule</i18n>
							</th>
							<td> <input type="text" name="cerca" class="full" id="input_cerca_modulo"> </td>
							<td> <button class="green" onclick="pi.request(\'cerca_modulo\');"><i class="mdi mdi-magnify"></i> <i18n>search</i18n> </button></td>
							<th> <button class="green" onclick="pi.request(null,\'Mod/Win_Load_Dett\');"><i class="mdi mdi-plus-box"></i> <i18n>mod:iface:newMod</i18n> </button> </th>
						</tr>
					</table>
				</div>
				<div id="container-mod"></div>
			</div>
			<div class="orange" data-pi-i18n="iface:btn:groups">
				<div class="panel orange" style="text-align:center;">
					<table class="form" id="cerca_gruppo">
						<tr>
							<th>
								<input type="hidden" name="Q" value="Grp/Load_Interface">
								<i18n>grp:iface:groupName</i18n>
							</th>
							<td> <input type="text" name="cerca" class="full" id="input_cerca_gruppo"> </td>
							<td> <button class="orange" onclick="pi.request(\'cerca_gruppo\');"><i class="mdi mdi-magnify"></i> <i18n>search</i18n> </button></td>
							<th> <button class="orange" onclick="pi.request(null,\'Grp/Win_New\');"><i class="mdi mdi-library-plus"></i> <i18n>grp:iface:newGroup</i18n> </button> </th>
						</tr>
					</table>
				</div>
				<div id="container-grp"></div>
			</div>
			<div class="red" data-pi-i18n="iface:btn:menus">
				<div class="panel red" style="text-align:center;">
					<table class="form" id="cerca_menu">
						<tr>
							<th>
								<input type="hidden" name="Q" value="Menu/Load_Interface">
								Nome Menu : 
							</th>
							<td> <input type="text" name="cerca" class="full" id="input_cerca_menu"> </td>
							<td> <button class="red" onclick="pi.request(\'cerca_menu\');"><i class="mdi mdi-magnify"></i> <i18n>search</i18n> </button></td>
							<th> <button class="red" onclick="pi.request(null,\'Menu/Win_New\');"><i class="mdi mdi-playlist-plus"></i> <i18n>menu:iface:newMenu</i18n> </button> </th>
						</tr>
					</table>
				</div>
				<div id="container-menu"></div>
			</div>
			<div class="purple" data-pi-i18n="iface:btn:db">
				<div class="panel purple" style="text-align:center;">
					<table class="form" id="cerca_db">
						<tr>
							<th>
								<input type="hidden" name="Q" value="DB/Load_Interface">
								<i18n>db:iface:dbName</i18n>  
							</th>
							<td> <input type="text" name="cerca" class="full" id="input_cerca_db"> </td>
							<td> <button class="purple" onclick="pi.request(\'cerca_db\');"><i class="mdi mdi-magnify"></i> <i18n>search</i18n> </button></td>
							<th> <button class="purple" onclick="pi.request(null,\'DB/Win_New\');"><i class="mdi mdi-database-plus"></i> <i18n>db:iface:newDb</i18n> </button> </th>
						</tr>
					</table>
				</div>
				<div id="container-db"></div>
			</div>
		</div>
	</div>

	<div id="container"></div>';
?>
