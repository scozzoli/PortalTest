<?php	
	$i18n = $sysConfig->loadI18n();
	
	$out ='<div class="focus orange"> <ul>
		<li>l\'ID &eacute; un campo univoco che non pu&uacute; essere modificato</li>
		<li>Nome e Descrizione possono sempre essere modificati</li>
	</ul></div><br>
		<div style="text-align:center;">
			<div id="Grp_To_New">
				<input type="hidden" name="Q" value="Grp_New">
				<table class="form separate">
					<tr>
						<th style="width:50%;">ID univoco dell gruppo </th>
						<td><input type="text" name="id" class="ale" style="width:50px; min-width:50px;" id="focusme"></td>
					</tr>
				</table>
				<br>
				<table class="lite orange">
					<tr>
						<th colspan="2">Lingua</th>
						<th>Nome</th>
						<th>Descrizione</th>
					</tr>';

	foreach($i18n['langs'] as $k => $v){
		$out .= '<tr>
			<td style="text-align:right"><b> '.$v['des'].'<b></td>
			<td> <img src="./style/img/'.$v['icon'].'"> </td>
			<td><input type="text" class="" name="nome_'.$k.'"></td>
			<td><input type="text" class="double" name="des_'.$k.'"></td>
		</tr>';
	}
	$out .='</table></div></div>';
	$footer = '<button class="red" onclick="pi.win.close()">Annulla</button>
			<button class="green" onclick="pi.requestOnModal(\'Grp_To_New\')">Salva</button>';
	$pr->addWindow(600,0,'Nuovo Gruppo',$out,$footer)->addScript("$('#focusme').focus();")->response();
?>