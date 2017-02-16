<?php
	
	$menu_list = $sysConfig->loadMenu();
	$mod_list = $sysConfig->loadMod();
	$usr_list = $sysConfig->loadUsr();
	
	$filter = strtolower($pr->post('cerca',''));
	
	foreach($usr_list as $k => $v){
		if(!isset($usr[$v['menu']])){$usr[$v['menu']]=0;}
		$usr[$v['menu']]++;
	}
	
	$out = '<div class="panel red" style="text-align:center;">
	
		<table class="form" id="cerca_menu">
			<tr>
				<th>
					<input type="hidden" name="Q" value="Menu/Load_Interface">
					Nome Menu : 
				</th>
				<td> <input type="text" name="cerca" class="full" value="'.$filter.'" id="input_cerca_menu"> </td>
				<td> <button class="red" onclick="pi.request(\'cerca_menu\');"><i class="mdi mdi-magnify"></i> <i18n>search</i18n> </button></td>
				<th> <button class="red" onclick="pi.request(null,\'Menu/Win_New\');"><i class="mdi mdi-playlist-plus"></i> <i18n>menu:iface:newMenu</i18n> </button> </th>
			</tr>
		</table>
	</div>
	<table class="lite red">
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
			
		$out.='<tr onclick="pi.request(\'Load_Dett_'.$k.'\');" style="cursor:pointer;">
				<td>'.$k.'</td>
				<td><i class="mdi mdi-account" /> '.(isset($usr[$k]) ? $usr[$k]: ' --- ').'</td>
				<td>
					<div id="Load_Dett_'.$k.'">
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
	$pr->addHtml('container',$out)->addScript('$("#input_cerca_menu").focus(); $("#input_cerca_menu").select(); shortcut("enter", onEnterMenu,{"propagate":false, target:"input_cerca_menu"} );')->response();
?>