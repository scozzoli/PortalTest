<?php
	$mod_list = $sysConfig->loadMod();

	$out ='
			<div class="focus red">
				<table class="form">
					<tr>
						<th><i18n>menu:iface:filterFor</i18n></th>
						<td><input type="text" class="full" id="search_module_field"></td>
						<td><button class="red icon" onclick="menuFilterMod()"><i class="mdi mdi-magnify"></button></td>
					</tr>
				</table>
			</div>
			<div id="icon_list" style="height:350px; overflow-y:auto;">
	<table class="lite red" id="win_menu_module_list">
	<tr>
		<th><i18n>menu:iface:ico</i18n></th>
		<th><i18n>menu:iface:nameGroup</i18n></th>
		<th><i18n>menu:iface:desc</i18n></th>
	</tr>';
	
	foreach($mod_list as $k => $v){
		$strSearch = strtolower($sysConfig->i18nGet($v['nome']).$sysConfig->i18nGet($v['des']).$k);
		$strSearch = str_replace('"',"'",$strSearch);
		$out.='<tr onclick="pi.requestOnModal(\'Add_Mod_'.$k.'\');" style="text-align:left; cursor:pointer;" class="j-module" data-pi-des="'.$strSearch.'">
				<td style="width:30px; text-align:right;">
					<div id="Add_Mod_'.$k.'">
					<input type="hidden" name="Q" value="Menu/Add_Mod_On_Voice">
					<input type="hidden" name="menu" value="'.$pr->post('menu').'">
					<input type="hidden" name="mod" value="'.$k.'">
					<input type="hidden" name="voice" value="'.$pr->post('voice').'">
					<i class="mdi l2 '.$v['icon'].'" />
					</div>
				</td>
				<td>
					'.$k.'<br>
					<span style="color:#888;"><i18n>menu:iface:group</i18n> : <i>'.$v['grp'].'</i>
				</td>
				<td><b>'.$sysConfig->i18nGet($v['nome']).'</b><br> '.$sysConfig->i18nGet($v['des']).'</td>
			</tr>';
	}
	$out.='</table></div>';
	$js = '$("#search_module_field").focus(); shortcut("enter", menuFilterMod,{"propagate":false, target:"search_module_field"} );';
	$pr->addWindow(600,0,'<i18n>menu:win:selectMod</i18n>',$out,'')->addScript($js)->response();
?>