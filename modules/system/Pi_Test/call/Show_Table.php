<?php
	$tabRow= '<td> Testo </td>
				<td class="blue"> Testo </td>
				<td class="red"> Testo </td>
				<td class="orange"> Testo </td>
				<td class="green"> Testo </td>
				<td class="purple"> Testo </td>';
	$table='<tr>
				<th>TR/TD</th>
				<th>---</th>
				<th>blue</th>
				<th>red</th>
				<th>orange</th>
				<th>green</th>
				<th>purple</th>
			</tr>
			<tr>
				<th> --- </th>
				'.$tabRow.'
			</tr>
			<tr class="blue">
				<th> blue </th>
				'.$tabRow.'
			</tr>
			<tr class="red">
				<th> red </th>
				'.$tabRow.'
			</tr>
			<tr class="orange">
				<th> orange </th>
				'.$tabRow.'
			</tr>
			<tr class="green">
				<th> green </th>
				'.$tabRow.'
			</tr>
			<tr class="purple">
				<th> purple </th>
				'.$tabRow.'
			</tr>';
	$out = '<div class="panel">
				<div class="header">Tili delle tabelle</div>
				Tutti gli stili applicati alle tabelle ne portano la larghezza al 100%<br />
				anche sulle tabelle &eacute; possibile applicare i colori a livello di tabella, riga e cella<br />
				Gli stili principali delle tabelle sono 3 : <br />
				<ul>
					<li> <b>lite</b> : stile con divisorio delle righe ma non delle colonne </li>
					<li> <b>bold</b> : stile con divisorio delle righe e delle colonne </li>
					<li> <b>form</b> : <i>th</i> allineari a destra e <i>td</i> allineati a sinistra senza altri stili (usati per l\'impaginazione) </li>
				</ul>
				<br />
				Esistono 2 stili accessori che servono per modificare il comportamento : <br />
				<ul>
					<li> <b>fix</b> : gli effetti hover evidenziano le celle colorate sono se si &eacute; sopra la cella e non sopra la riga </li>
					<li> <b>separate</b> : aggiunge un margine di 10px alla tabella (utilie nelle finestre che hanno il content senza padding)</li>
				</ul>
			</div>
			
			<div class="panel">
				<table class="form" id="buttonlist"><tr>
					<th>Colore tablella : </th>
					<td><button onclick="setColor(\'\',this);" disabled> Nessuno </button></td>
					<td><button onclick="setColor(\'blue\',this);" class="blue"> Blue </button></td>
					<td><button onclick="setColor(\'orange\',this);" class="orange"> Orange </button></td>
					<td><button onclick="setColor(\'red\',this);" class="red"> Red </button></td>
					<td><button onclick="setColor(\'green\',this);" class="green"> Green </button></td>
					<td><button onclick="setColor(\'purple\',this);" class="purple"> Purple </button></td>
				</tr></table>
			</div>
			
			<table width="100%">
				<tr>
					<th> Tipologia </th>
					<th> <i>Nessuno stile applicato</i></th>
					<th> .fix </th>
				</tr>
				<tr>
					<th> <i>Nessuno stile applicato</i> </th>
					<td> <table id="TableNormal">'.$table.'</table> </td>
					<td> <table id="TableFix">'.$table.'</table> </td>
				</tr>
				<tr>
					<th> .lite </th>
					<td> <table id="TableLiteNormal" class="lite">'.$table.'</table> </td>
					<td> <table id="TableLiteFix" class="lite fix nohover">'.$table.'</table> </td>
				</tr>
				<tr>
					<th> .bold </th>
					<td> <table id="TableBoldNormal" class="bold">'.$table.'</table> </td>
					<td> <table id="TableBoldFix" class="bold fix nohover">'.$table.'</table> </td>
				</tr>
			</table>
			<div class="panel">
				<div class="header">TableSortable</div>
				Esisotno delle estensioni (dette Component) che servono per estendere le funzionalit&aacute; e che vengono applicate in automatico su tutti gli elementi con il l\'attributo <b>data-pi-component</b> valorizzato :<br>
				<div class="focus blue">
					&lt;<b>table</b> <b>class</b>="lite blue" <b>data-pi-component</b>="<i>tablesort</i>"&gt;<br>
					<br>
					<b> ... </b>
					<br><br>
					&lt;/<b>table</b>&gt;
				</div>
				<br>
				<table class="lite blue" data-pi-component="tablesort">
					<tr>
						<th>Stringa</th>
						<th>Stringa</th>
						<th data-pi-sort="numeric">Numero</th>
						<th data-pi-sort="data">Data</th>
						<th data-pi-sort="none">Non ordinabile</th>
					</tr>
					<tr>
						<td>Angelo</td>
						<td>Scozzoli</td>
						<td>55665</td>
						<td>01/01/2010</td>
						<td> dati a caso </td>
					</tr>
					<tr>
						<td>Zanfo</td>
						<td>Zanfagni</td>
						<td>558</td>
						<td class="green">02/01/2010</td>
						<td> dati a caso </td>
					</tr>
					<tr>
						<td>Pdor</td>
						<td>Ishtar</td>
						<td>669</td>
						<td>01/05/2010</td>
						<td> dati a caso </td>
					</tr>
					<tr>
						<td></td>
						<td>Palanca</td>
						<td class="red">0</td>
						<td>01/01/2015</td>
						<td>  <table><tr><td>XXXX</td></tr></table>  dati a caso </td>
					</tr>
				</table>
			</div>';
	$js="setColor = function(color,obj){
		$('#TableNormal').attr('class',color);
		$('#TableFix').attr('class','fix '+color);
		$('#TableLiteNormal').attr('class','lite '+color);
		$('#TableLiteFix').attr('class','lite fix '+color);
		$('#TableBoldNormal').attr('class','bold '+color);
		$('#TableBoldFix').attr('class','bold fix '+color);
		$('#buttonlist button').each(function(){ this.disabled = false; });
		obj.disabled=true;
	}";
	$pr->addHtml('container',$out)->addScript($js)->response();
?>