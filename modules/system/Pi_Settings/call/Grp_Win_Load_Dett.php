<?php
	$grp_list = $sysConfig->loadGrp();
	$mod_list = $sysConfig->loadMod();
	
	$count_mod = 0;
	$id = $pr->post('ID');
	foreach($mod_list as $k=>$v){if($v['grp'] == $id){$count_mod++;}}
	$del = '<td></td>';
	if($count_mod==0){
		$del ='<button class="red" onclick="pi.chk(\'Cancellare il gruppo?\').requestOnModal(\'mod_grp\',\'Grp_Del\')">Cancella Gruppo</button>';
	}
	
	$out ='<div class="focus orange"> Modifica dettagli del modulo <b>'.$id.'</b></div>
		<div id="mod_grp" style="text-align:center;">
			
			<input type="hidden" name="ID" value="'.$id.'">
			<br>
			<table class="form separate"><tr>
				<th>'.$id.'</th>
				<td><input type="text" name="nome" class="std" value="'.$grp_list[$id]['nome'].'" id="focusme"></td>
				<td><input type="text" name="des" class="std" style="width:250px;" value="'.$grp_list[$id]['des'].'"></td>
			</tr></table>
		
		</div>';
		$footer = '<button class="red" onclick="pi.win.close()">Annulla</button>'.$del.'<button class="green" onclick="pi.requestOnModal(\'mod_grp\',\'Grp_Mod\')">Salva</button>';
	$pr->addWindow(600,0,'Modifica dettagli',$out,$footer)->addScript("$('#focusme').focus();")->response();
?>