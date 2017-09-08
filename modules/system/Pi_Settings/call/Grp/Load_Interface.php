<?php

	$grp_list = $sysConfig->loadGrp();
	$mod_list = $sysConfig->loadMod();
	$i18n = $sysConfig->loadI18n();
	
	$filter = strtolower($pr->post('cerca',''));

	$out='<table class="lite orange">
		<tr>
			<th colspan="2"><i18n>grp:iface:id</i18n></th>
			<th><i18n>grp:iface:name</i18n></th>
			<th colspan="2"><i18n>grp:iface:descrMod</i18n></th>
		</tr>';
	foreach($mod_list as $k => $v){
		$v['id'] = $k;
		$grp_mod_list[$v['grp']][]=$v;
	}
	$idx = 0;
	foreach($grp_list as $k => $v){
		if($filter != ''){
			if(!(strpos(strtolower($k),$filter)!==false || strpos(strtolower($sysConfig->i18nGet($v['nome'])),$filter)!==false)){ continue; }
		}
		$out.='<tr onclick="pi.request(\'Load_GrpDett_'.$idx.'\');" style="cursor:pointer; height:30px;" class="orange">
			<td colspan="2"> 
				<div id="Load_GrpDett_'.$idx.'">
				<input type="hidden" name="Q" value="Grp/Win_Load_Dett">
				<input type="hidden" name="ID" value="'.$k.'">
				[ <b>'.$k.'</b> ] '.$sysConfig->i18nGet($v['nome']).'
				</div>
			</td>
			<td>'.$sysConfig->i18nGet($v['des']).'</td>
			<td> [ Moduli Registrati : <b>'.(!isset($grp_mod_list[$k]) ? ' --- ' : count($grp_mod_list[$k])).' </b>]</td>
		</tr>';
		if(isset($grp_mod_list[$k])){
			foreach($grp_mod_list[$k] as $k1 => $v1){
				switch($v1['stato']){
				case 'ATT' : $des_stato = '<i18n>mod:iface:active</i18n>'; 			$class=''; 		    $style='';	break;
				case 'DEV' : $des_stato = '<i18n>mod:iface:devel</i18n>';  			$class='orange';	$style='';	break;
				case 'PRIV': $des_stato = '<i18n>mod:iface:priv</i18n>';  			$class='purple';	$style='';	break;
				case 'ERR' : $des_stato = '<i18n>mod:iface:error</i18n>';		 	$class='red';		$style='';	break;
				case 'DIS' : $des_stato = '<i18n>mod:iface:disable</i18n>'; 		$class='';			$style='color:#888;';	break;
			}
			$out.='<tr style="cursor:pointer; '.$style.'" onclick="pi.request(\'Mod_Grp_Mod_'.$v1['id'].'\')">
					<td style="text-align:right; width:30px;" >
						<div id="Mod_Grp_Mod_'.$v1['id'].'">
							<input type="hidden" name="Q" value="Grp/Win_Edit_Mod">
							<input type="hidden" name="ID" value="'.$v1['id'].'">
							<i class="mdi '.$v1['icon'].' '.$class.'" />
						</div>
					</td>
					<td>[ '.$v1['id'].' ]</td>
					<td>'.htmlentities($sysConfig->i18nGet($v1['nome'])).'</td>
					<td>'.htmlentities($sysConfig->i18nGet($v1['des'])).'</td>
				</tr>';
			}
		}
		$idx++;
	}
	$out.='</table>';
	$pr->addHtml('container-grp',$out)->addScript('$("#input_cerca_gruppo").focus(); $("#input_cerca_gruppo").select(); shortcut("enter", onEnterGrp,{"propagate":false, target:"input_cerca_gruppo"} );')->response();
?>