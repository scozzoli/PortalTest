<?php
	
	$menu_list = $sysConfig->loadMenu();
	$mod_list = $sysConfig->loadMod();
	$usr_list = $sysConfig->loadUsr();
	
	$filter = strtolower($pr->post('cerca',''));
	
	foreach($usr_list as $k => $v){
		if(!isset($usr[$v['menu']])){$usr[$v['menu']]=0;}
		$usr[$v['menu']]++;
	}
	
	$out = '<table class="lite red">
		<tr>
			<th><i18n>menu:iface:name</i18n></th>
			<th><i18n>menu:iface:nUtenti</i18n></th>
			<th><i18n>menu:iface:nModuli</i18n></th>
			<th><i18n>menu:iface:making</i18n></th>
		</tr>';
	
	
	foreach($menu_list as $k => $v){
	  if($filter != ''){
			if(!(strpos(strtolower($k),$filter)!==false)){ continue; }
		}
		list($tot,$miss) = get_mod_menu($v,$mod_list,$pr->getRootPath());
		$struct = '';
		foreach($v as $key => $val){
			$count = isset($val['list']) ? count($val['list']) : 0;
			//$struct.='[<b>'.$key.'</b> :<i> '.($val['BASE64'] == 1 ? base64_decode($val['des']) : $val['des']).'</i> ('.$count.') ]';
			$struct.='[<b>'.$key.'</b> :<i> '.$sysConfig->i18nGet($val['des']).'</i> ('.$count.') ]';
		}
		
		$icon = ($miss > 0) ? '<i class="mdi mdi-alert-circle orange" />' : '<i class="mdi mdi-check green" />';
			
		$out.='<tr onclick="pi.request(\'Load_MenuDett_'.$k.'\');" style="cursor:pointer;">
				<td>'.$k.'</td>
				<td><i class="mdi mdi-account" /> '.(isset($usr[$k]) ? $usr[$k]: ' --- ').'</td>
				<td>
					<div id="Load_MenuDett_'.$k.'">
						<input type="hidden" name="Q" value="Menu/Load_Dett">
						<input type="hidden" name="menu" value="'.$k.'">
						'.$icon.'
					[ <b><i18n>menu:iface:tot</i18n> :  <span class="focus">'.$tot.'</span> </b> ] 
					[ <b><i18n>menu:iface:ok</i18n> :  <span class="green">'.($tot - $miss).'</span> </b> ] 
					[ <b><i18n>menu:iface:miss</i18n> : <span class="orange">'.$miss.'</span></b> ] 
					</div>
				</td>
				<td>'.$struct.'</td>
			</tr>';
	}
	$out.='</table>';
	$pr->addHtml('container-menu',$out)->addScript('$("#input_cerca_menu").focus(); $("#input_cerca_menu").select(); shortcut("enter", onEnterMenu,{"propagate":false, target:"input_cerca_menu"} );')->response();
?>