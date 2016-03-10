<?php
	$mod_list = $sysConfig->loadMod();
	
	$out='<table class="lite red">
	<tr>
		<th>Ico</th>
		<th>Nome e Gruppo</th>
		<th>Descrizione</th>
	</tr>';
	
	$out ='
			<div class="focus red">
				<table class="form">
					<tr>
						<th>Filtra per : </th>
						<td><input type="text" class="full" id="search_module_field"></td>
						<td><button class="red icon" onclick="menuFilterMod()"><i class="mdi mdi-magnify"></button></td>
					</tr>
				</table>
			</div>
			<div id="icon_list" style="height:350px; overflow-y:auto;">
	<table class="lite red" id="win_menu_module_list">
	<tr>
		<th>Ico</th>
		<th>Nome e Gruppo</th>
		<th>Descrizione</th>
	</tr>';
	
	foreach($mod_list as $k => $v){
		$strSearch = strtolower($v['nome'].$v['des'].$k);
		$strSearch = str_replace('"',"'",$strSearch);
		$out.='<tr onclick="pi.requestOnModal(\'Add_Mod_'.$k.'\');" style="text-align:left; cursor:pointer;" class="j-module" data-pi-des="'.$strSearch.'">
				<td style="width:30px; text-align:right;">
					<div id="Add_Mod_'.$k.'">
					<input type="hidden" name="Q" value="Menu_Add_Mod_On_Voice">
					<input type="hidden" name="menu" value="'.$pr->post('menu').'">
					<input type="hidden" name="mod" value="'.$k.'">
					<input type="hidden" name="voice" value="'.$pr->post('voice').'">
					<i class="mdi l2 '.$v['icon'].'" />
					</div>
				</td>
				<td>
					'.$k.'<br>
					<span style="color:#888;">Gruppo : <i>'.$v['grp'].'</i>
				</td>
				<td><b>'.$v['nome'].'</b><br> '.$v['des'].'</td>
			</tr>';
	}
	$out.='</table></div>';
	$js = '$("#search_module_field").focus(); shortcut("enter", menuFilterMod,{"propagate":false, target:"search_module_field"} );';
	$pr->addWindow(600,0,'Selezionare il modulo da aggiungere',$out,'')->addScript($js)->response();
?>