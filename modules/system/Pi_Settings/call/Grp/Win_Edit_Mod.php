<?php
	$grp_list = $sysConfig->loadGrp();
	$mod_list = $sysConfig->loadMod();

	$grp_sel ='<select name="grp" class="std">';
	$id = $pr->post('ID');
	foreach($grp_list as $k => $v){
		$grp_sel.='<option value="'.$k.'" '.($mod_list[$id]["grp"]==$k ? 'selected' : '').'>'.$k.' - '.$sysConfig->i18nGet($v["nome"]).'</option>';
	}
	$grp_sel.='</select>';
	switch($mod_list[$id]["stato"]){
		case 'ATT'  : $sts = 'mod:comb:active';  break;
		case 'DEV'  : $sts = 'mod:comb:devel';   break;
		case 'ERR'  : $sts = 'mod:comb:error';   break;
		case 'PRIV' : $sts = 'mod:comb:priv';   break;
		case 'DIS'  : $sts = 'mod:comb:disable'; break;
	}
	/*
	<div id="Mod_Del">
		<input type="hidden" name="Mid" value="'.$id.'">
		<input type="hidden" name="Q" value="Del">
	</div>
	*/
	$out='<div class="focus green"> <i18n>grp:win:infoModMod</i18n></div>
		<div style="text-align:left;">
		<div id="mod_mod">
			<table class="form separate">
				<tr>
					<th style="text-align:right; border-right:2px #080 solid;"><i18n>mod:iface:modId</i18n></th>
					<td>
						'.$id.'
						<input type="hidden" name="id" value="'.$id.'" id="MID">
						<input type="hidden" name="icon" value="'.$mod_list[$id]["iconfile"].'">
						<input type="hidden" name="Q" value="Grp/Save_Mod">
					</td>
				</tr>
				<tr>
					<th style="text-align:right; border-right:2px #080 solid;"><i18n>mod:iface:name</i18n></th>
					<td>'.$sysConfig->i18nGet($mod_list[$id]["nome"]).'</td>
				</tr>
				<tr>
					<th style="text-align:right; border-right:2px #080 solid;"><i18n>mod:iface:desc</i18n></th>
					<td>'.$sysConfig->i18nGet($mod_list[$id]["des"]).'</td>
				</tr>
				<tr>
					<th style="text-align:right; border-right:2px #080 solid;"><i18n>mod:iface:path</i18n></th>
					<td>'.$mod_list[$id]["path"].'</td>
				</tr>
				<tr>
					<th style="text-align:right; border-right:2px #080 solid;"><i18n>mod:iface:state</i18n></th>
					<td><i18n>'.$sts.'</i18n></td>
				</tr>
				<tr>
					<th style="text-align:right; border-right:2px #080 solid;" > <i18n>mod:iface:group</i18n> </th>
					<td>'.$grp_sel.'</td>
				</tr>
			</table>
		</div><br>';
	$footer = '<button class="red" onclick="pi.win.close();"> <i18n>cancel</i18n> </button> <button class="green" onclick="pi.requestOnModal(\'mod_mod\')"><i18n>save</i18n></button>';

	$pr->addWindow(400,0,'<i18n>grp:win:editModuleTitle</i18n>',$out,$footer)->response();
?>
