<?php
	//$js = '$(document).ready(function(){$("#focusme").focus();});';
	//$sd->includeScript($js);
	$text = 'Portal 1 è un framework nato come strumento di supporto per i gestionali aziendali e per questo motivo è in grado di connettersi a svariati DB, 
	ciononoctante è cresciuto molto nel tempo diventando uno strumento per semplificare lo sviluppo di applicazioni web che hanno come obbiettivo la gestione dei dati.
	Il suo punto di forza è la semplicità e malleabilità, portal infatti permette di essere integrato con script di terze parti senza problemi e permette di "uscire dal seminato"
	del framework senza dover fare giri troppo bizzarri.<br>
	La maggior parte del codice è fatto da me, ciononostante ho usato anche numerosi script esterni (tutti sotto licenza GPL, LGPL, MIT, ecc...)';
	$interface = '<div class="panel blue">
			<b>Portal 1 </b> versione 3<br>
				'.htmlentities($text).'
			</div>
			<div class="panel">
				<div class="focus blue">  <b>Javascript : </b> JQuery </div>
				<div class="focus">
					Libreria fondamentale usata per tutta la parte javascript.<br>
					Versione dalla 2 in poi
				</div>
				
				<div class="focus blue"> <b>Javascript : </b> sortElement <i>( jQuery Plugin )</i> </div>
				<div class="focus">
					Libreria usata dal component <b class="blue">tablesort</b>.<br>
					<b> Autore : </b> James Padolsey ( <a href="http://james.padolsey.com">http://james.padolsey.com</a> )
				</div>
				
				<div class="focus blue"> <b>Javascript : </b> dateTimePicker <i>( jQuery Plugin )</i> </div>
				<div class="focus">
					Libreria usata dal component <b class="blue">datepicker</b>.<br>
					<b> Copyright : </b> Kartik Visweswaran, Krajee.com, 2014 - 2015 <br>
					<b> JQuery Plugin : </b> <a href="http://plugins.krajee.com">http://plugins.krajee.com</a><br>
					<b> Framework : </b> <a href="http://krajee.com">Krajee.com</a><br>
				</div>
				
				<div class="focus blue"> <b>Javascript : </b> shortcut </div>
				<div class="focus">
					Libreria usata per la gestione delle combinazioni di tasti.<br>
					Questa libreria non ha nessuna licenza in particolare e non ho trovato riferimenti all\'autore.
				</div>
				
				<div class="focus blue"> <b>Javascript : </b> ace </div>
				<div class="focus">
					Libreria usata per la gestione dei campi di codice editabili dal component  <b class="blue">code</b>.<br>
					<b> Homepage del progetto : </b> <a href="https://ace.c9.io"> https://ace.c9.io </a>
				</div>
				
				<div class="focus blue"> <b>Javascript : </b> SimpleMDE - Markdown Editor </div>
				<div class="focus">
					Libreria usata per eseguire l\'editing del codice markdown delle descrizioni e per il component <b class="blue">markdown</b>.<br>
					<b> Homepage del progetto : </b> <a href="https://github.com/NextStepWebs/simplemde-markdown-editor"> https://github.com/NextStepWebs/simplemde-markdown-editor </a>
				</div>
				
				<div class="focus blue"> <b>Javascript : </b> markdown-js </div>
				<div class="focus">
					Libreria usata per eseguire il parsing del linguaggio markdown per il traduttore<br>
					<b> Homepage del progetto : </b> <a href="https://github.com/evilstreak/markdown-js"> https://github.com/evilstreak/markdown-js </a>
				</div>
				
				<div class="focus purple">
					<b>PHP : </b> Parsedown
				</div>
				<div class="focus">
					Libreria usata per la trasformazione del codice markdown in html (per le tradusioni).<br>
					<b> Homepage del progetto : </b> <a href="https://github.com/erusev/parsedown"> https://github.com/erusev/parsedown </a><br>
					Licensed under MIT
				</div>
				
				<div class="focus purple">
					<b>PHP : </b> PHPExcel
				</div>
				<div class="focus">
					Libreria usata per la generazione dei fogli di lavoro (eccetto quelli in BIFF 9 non formattai).<br>
					<b> Homepage del progetto : </b> <a href="https://phpexcel.codeplex.com"> https://phpexcel.codeplex.com </a>
				</div>
				
				<div class="focus purple">
					<b>PHP : </b> Lessphp
				</div>
				<div class="focus">
					Libreria usata per la generazione dei file CSS a partire dai file LESS.<br>
					Copyright 2012, Leaf Corcoran (leafot@gmail.com)<br>
					Licensed under MIT or GPLv3<br>
					<b> Homepage del progetto : </b> <a href="http://leafo.net/lessphp"> http://leafo.net/lessphp </a>
				</div>
				
				<div class="focus purple">
					<b>PHP : </b> ezPdf
				</div>
				<div class="focus">
					Libreria usata per la generazione dei file PDF.<br>
					released under a public domain licence.<br>
					<b> Autore : </b> ayne Munro, R&OS Ltd, <a href="http://www.ros.co.nz/pdf"> http://www.ros.co.nz/pdf </a>
				</div>
				
			</div>
			
			<div id="container"></div>';
			
			
			/*
			<div class="focus blue"> <b>Javascript : </b> micromarkdown </div>
				<div class="focus">
					Libreria usata per eseguire il parsing del linguaggio markdown per il traduttore<br>
					<b> Homepage del progetto : </b> <a href="https://github.com/SimonWaldherr/micromarkdown.js"> https://github.com/SimonWaldherr/micromarkdown.js </a>
				</div>
			*/
?>