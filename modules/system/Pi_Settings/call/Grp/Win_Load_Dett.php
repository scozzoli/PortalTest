<?php
	$grp_list = $sysConfig->loadGrp();
	$mod_list = $sysConfig->loadMod();
	$i18n = $sysConfig->loadI18n();
	
	$count_mod = 0;
	$id = $pr->post('ID');
	foreach($mod_list as $k=>$v){if($v['grp'] == $id){$count_mod++;}}
	$del = '<td></td>';
	if($count_mod==0){
		$del ='<button class="red" onclick="pi.chk(\'Cancellare il gruppo?\').requestOnModal(\'mod_grp\',\'Grp/Del\')"><i18n>grp:iface:removeGroup</i18n></button>';
	}
	$fill = array();
	$fill['id'] = $id;
	$out ='<div class="focus orange"> <i18n>grp:win:modInfo;'.$id.'</i18n></div>
		<div id="mod_grp" style="text-align:center;">
			
			<input type="hidden" name="id">
			<br>
			<table class="lite separate">
				<tr>
					<th colspan="2"><i18n>grp:iface:lang</i18n></th>
					<th><i18n>grp:iface:name</i18n></th>
					<th><i18n>grp:iface:descr</i18n></th>
				</tr>';
	$firstId = 'id="focusme"';
	foreach($i18n['langs'] as $k => $v){
		$out .= '<tr>
			<td style="text-align:right"><b> '.$v['des'].'<b></td>
			<td> <img src="./style/img/'.$v['icon'].'"> </td>
			<td><input type="text" class="" name="nome_'.$k.'" '.$firstId.'></td>
			<td><input type="text" class="double" name="des_'.$k.'"></td>
		</tr>';
		$fill['nome_'.$k] = $grp_list[$id]['nome'][$k] ?: '';
		$fill['des_'.$k] = $grp_list[$id]['des'][$k] ?: '';
		$firstId='';
	}
	$out .='</table></div>';
	$footer = '<button class="red" onclick="pi.win.close()"><i18n>cancel</i18n></button>'.$del.'<button class="green" onclick="pi.requestOnModal(\'mod_grp\',\'Grp/Mod\')"><i18n>save</i18n></button>';
	$pr->addWindow(600,0,'<i18n>grp:win:modDetailTitle</i18n>',$out,$footer)->addFill('mod_grp',$fill)->addScript("$('#focusme').focus();")->response();
?>