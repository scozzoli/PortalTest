<?php
	$mod_list = $sysConfig->loadMod();
	$grp_list = $sysConfig->loadGrp();
	$i18n = $sysConfig->loadI18n();
	
	$filter = strtolower($pr->post('cerca',''));

	$out='
	<table class="lite green">
		<tr>
			<th style="width:30px;"> <i18n>mod:iface:icon</i18n> </th>
			<th><i18n>mod:iface:modId</i18n></th>
			<th><i18n>mod:iface:name</i18n></th>
			<th><i18n>mod:iface:desc</i18n></th>
			<th title="Dove si trova fisicamente il modulo" colspan="2"><i18n>mod:iface:path</i18n></th>
			<th><i18n>mod:iface:state</i18n></th>
			<th title="Gruppo di appartenenza"><i18n>mod:iface:group</i18n></th>
			<th><i18n>mod:iface:modify</i18n></th>
		</tr>';
	foreach($mod_list as $k => $v){
		
		if($filter != ''){
			if(!(strpos(strtolower($k),$filter)!==false || strpos(strtolower($sysConfig->i18nGet($v,'nome')),$filter)!==false)){ continue; }
		}
		
		switch($v['stato']){
			case 'ATT' : $des_stato = '<i18n>mod:iface:active</i18n>'; 			$class='green'; 	$style='';	break;
			case 'DEV' : $des_stato = '<i18n>mod:iface:devel</i18n>';  			$class='orange';	$style='';	break;
			case 'PRIV': $des_stato = '<i18n>mod:iface:priv</i18n>';  			$class='purple';	$style='';	break;
			case 'ERR' : $des_stato = '<i18n>mod:iface:error</i18n>';		 	$class='red';		$style='';	break;
			case 'DIS' : $des_stato = '<i18n>mod:iface:disable</i18n>'; 		$class='';			$style='color:#888;';	break;
		}
		$out.='<tr style="'.$style.'">
				<td class="'.$class.'" style="text-align:center; cursor:pointer;" onclick="pi.request(\'Load_Img_'.$k.'\')">
					<div id="Load_Img_'.$k.'">
						<input type="hidden" name="Q" value="Mod/Win_Load_Img">
						<input type="hidden" name="ID" value="'.$k.'">
						<i class="mdi l2 '.$v['icon'].'"></i>
					</div>
				</td>
				<td>'.$k.'</td>
				<td>'.htmlentities($sysConfig->i18nGet($v['nome'])).'</td>
				<td>'.htmlentities($sysConfig->i18nGet($v['des'])).'</td>
				<td width="20px">'.(file_exists($pr->getRootPath("modules/{$v['path']}/interface.php")) 
								? '<i class="mdi mdi-check green"></i>'
								: '<i class="mdi mdi-alert-circle red"></i>').'</td>
				<td>'.$v['path'].'</td>
				<td>'.$des_stato.'</td>
				<td>[ <b>'.$v['grp'].' </b>] '.$sysConfig->i18nGet($grp_list[$v['grp']]['nome']).'</td>
				<td class="green" style="text-align:center; cursor:pointer;" onclick="pi.request(\'Load_Dett_'.$k.'\')">
					<div id="Load_Dett_'.$k.'">
						<input type="hidden" name="Q" value="Mod/Win_Load_Dett">
						<input type="hidden" name="ID" value="'.$k.'">
						<i class="mdi mdi-pencil green l2" />
					</div>
				</td>
			</tr>';
	}
	$out.='</table>';
	$pr->addHtml('container-mod',$out)->addScript('$("#input_cerca_modulo").focus(); $("#input_cerca_modulo").select(); shortcut("enter", onEnterMod,{"propagate":false, target:"input_cerca_modulo"} );')->response();
?>