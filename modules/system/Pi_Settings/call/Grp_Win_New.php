<?php	
	$out ='<div class="focus orange"> <ul>
		<li>l\'ID &eacute; un campo univoco che non pu&uacute; essere modificato</li>
		<li>Nome e Descrizione possono sempre essere modificati</li>
	</ul></div><br>
		<div style="text-align:center;">
			<div id="Grp_To_New">
				<input type="hidden" name="Q" value="Grp_New">
				<table style="margin:auto;"><tr>
					<th>ID <input type="text" name="ID" class="ale" style="width:50px; min-width:50px;" id="focusme"></th>
					<td><input type="text" name="nome" class="std"></td>
					<td><input type="text" name="des" class="std" style="width:250px;"></td>
				</tr></table><br>
			</div>
		</div>';
	$footer = '<button class="red" onclick="pi.win.close()">Annulla</button>
			<button class="green" onclick="pi.requestOnModal(\'Grp_To_New\')">Salva</button>';
	$pr->addWindow(600,0,'Nuovo Gruppo',$out,$footer)->addScript("$('#focusme').focus();")->response();
?>