<?php
	
	$footer = '<button class="red" onclick="pi.win.close()">Annulla</button>';
	
	if($pr->getUsr() == 'root'){
		$edit = '';
		$footer .= '<button class="blue" onclick="pi.requestOnModal(\'saveformat\')">Salva</button>';
		$call = '<input type="hidden" name="Q" value="Save_Format">';
	}else{
		$edit = 'disabled';
		$call= '';
	}
	
	$out='<div class="focus blue">
		Selezionare il formato con cui salvare i dati di configurazione.<br>
		&Eacute; comunque consigliabile evitare di rendere pubblica la cartella <b>settings</b> per avere una massima sicurezza.
	</div>
	<table class="form separate" id="saveformat">
		<tr>
			<th>
				<input type="radio" name="format" value="ini" '.$edit.'>
				'.$call.'
				<input type="hidden" name="old">
			</th>
			<td> <b>ini</b> </td>
			<td> Molto facie da leggere ed editare a mano ma con struttura limitata ad un paio di livelli e lento nella decodifica</td>
		</tr>
		<tr>
			<th><input type="radio" name="format" value="json" '.$edit.'></th>
			<td> <b>json</b> </td>
			<td> Facile da leggere ed editare a mano e permette un numero indefinito di livelli. Lento nella decodifica</td>
		</tr>
		<tr>
			<th><input type="radio" name="format" value="serialize" '.$edit.'></th>
			<td> <b>serialize PHP</b></td>
			<td> Velocissimo in lettura e scrittura con la massima flessibilit&aacute;, ma quasi impossibile da lavorare a mano.</td>
		</tr>
		<tr>
			<th><input type="radio" name="format" value="encripted" '.$edit.'></th>
			<td> <b>serialize PHP cifrato</b> </td>
			<td> I file di configurazioni <i>non sono leggibili o modificabili a mano</i>. La cifratura rende pi&uacute; lenta l\'elaborazine della configurazione.</td>
		</tr>
	</table>';
	
	$fill['format'] = $sysConfig->get('type');
	$fill['old'] = $sysConfig->get('type');
	
	$pr->addWindow(600,0,'Selezionare il formato',$out,$footer)->addFill('saveformat',$fill)->response();
?>
