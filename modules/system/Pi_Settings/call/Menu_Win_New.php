<?php
	$out='<div class="red focus">
			Inserire il nome del nuovo menu. <br> <b>NB</b> : Il nome non &eacute; modificabile.
		</div>
		<div id="new_menu">
			<table class="form separate">
				<tr>
					<th>Nome del menu</th>
					<td>
						<input type="hidden" name="Q" value="Menu_New">
						<input type="text" class="std" name="nome" value="" id="focusme">
					</td>
				</tr>
				
			</table>
		</div>';
		$footer = '<button class="red" onclick="pi.win.close()">Annulla</button>
		<button class="green" onclick="pi.requestOnModal(\'new_menu\')"> Crea </button>';
	$pr->addWindow(400,0,'Crea un nuovo menu',$out,$footer)->addScript("$('#focusme').focus();")->response();
?>