<?php
	$out = '<div class="panel">
				<div class="header">Finestre modali</div>
				Le finestre modalie sono coposte lanciabili tramite l\'oggetto pi.win(conf).<br/>
				il file di configurazione &eacute; cos&iacute; composto:
				<div class="focus blue">
					{<br/>
					&nbsp;&nbsp;	<b>width</b>: <i>larghezza in pixel. Default: 500</i><br/>
					&nbsp;&nbsp;	<b>height</b>: <i>Altezza in pixel, se 0 allora la finestra si adetta al contenuto. <u>Default: 0</u></i><br/>
					&nbsp;&nbsp;	<b>header</b>: <i>Titolo della finestra in html. <u>Default: "Portal 1"</u></i><br/>
					&nbsp;&nbsp;	<b>content</b>: <i>Contenuto della finestra in html. <u>Default: ""</u></i><br/>
					&nbsp;&nbsp;	<b>footer</b>: <i>Piede della finestra in html (viene escluso dallo scroll del content). <u>Default: ""</u></i><br/>
					&nbsp;&nbsp;	<b>closeButton</b>: <i>Se deve essere isualizzato il pulsante di chiusura in alto a destra. <u>Default: true</u></i><br/>
					}<br/>
					<table class="form">
						<tr>
							<th>Width</th>
							<td><input type="text" id="width" value="500"></td>
							<th>Height</th>
							<td><input type="text" id="height" value="0"></td>
						</tr>
						<tr>
							<th>header</th>
							<td colspan="3"><input type="text" id="header" value="Portal1" class="full"></td>
						</tr>
						<tr>
							<th>content</th>
							<td colspan="3"><textarea id="content" class="full"><div class="focus blue"> Testo </div></textarea></td>
						</tr>
						<tr>
							<th>footer</th>
							<td colspan="3"><input type="text" id="footer" value="<button>bottone</button>" class="full"></td>
						</tr>
					</table>
				</div>
				<br>
				<div class="footer">
					<button id="actionOpenWin">Apri finestra modale</button>
				</div>
				
			</div>
			
			<div class="panel">
				<div class="header">Messaggi modali</div>
				I messaggi modali possono essere di due 4 tipologie differenti, <i> info, alert, error, bug </i> ed in pi&uacute; esiste un messaggio di conferma ed un custom.<br>
				Le funzioni che aprono i messaggi possono avere un secondo parametro che indica le azioni customizzate aggiuntive: <br><br>
				<div class="focus blue">
					pi.msg.info(<i>Testo messaggio</i>, <i style="color:#888;"> Array pulsanti</i>); <br>
					pi.msg.alert(<i>Testo messaggio</i>, <i style="color:#888;"> Array pulsanti</i>); <br>
					pi.msg.error(<i>Testo messaggio</i>, <i style="color:#888;"> Array pulsanti</i>); <br>
					pi.msg.bug(<i>Testo messaggio</i>, <i style="color:#888;"> Array pulsanti</i>); <br>
					<br>
					pi.msg.confirm(<i>Testo messaggio</i>, <i style="color:#888;">Funzione da eseguire su OK </i>);<br>
					<u>PS: se il secondo parametro non viene passato la funzione ritorna una promise risolta all\'ok</u><br>
					<br><br>
					<table class="form">
						<tr>
							<th> Messaggio </th>
							<td> <input type="text" class="full" value="Messaggio generico" id="msg"></td>
						</tr>
					</table>
					
				</div>
				
				<div class="footer">
					<button onclick="pi.msg.info($(\'#msg\').val())" class="blue">Info</button>
					<button onclick="pi.msg.alert($(\'#msg\').val())" class="orange">Alert</button>
					<button onclick="pi.msg.error($(\'#msg\').val())" class="red">Error</button>
					<button onclick="pi.msg.bug($(\'#msg\').val())" class="red">Bug</button>
					<button onclick="pi.msg.confirm($(\'#msg\').val())" class="green">Confirm</button>
				</div>
			</div>
			
			<div class="panel">
				<div class="header">Loader modale</div>
				Il loader modale pu&oacute; essere attivato e disattivato tramite la funzione pi.loader:
				<div class="focus blue">
					pi.loader() -- ritorna <i>true</i> se il loader &eacute; attivo se no <i>false</i><br>
					pi.loader(<b>true</b>) -- attiva il loader e rirtona <i>true</i> se attivato correttamente, <i>false </i> se era gi&aacute; attivo<br>
					pi.loader(<b>false</b>) -- disattiva il loader e rirtona <i>true</i> se disattivato correttamente, <i>false </i> se era gi&aacute; chiuso<br>
				</div>
				<div class="footer">
					<button onclick="pi.loader(true); setTimeout(function(){pi.loader(false)},5000)">Attiva loader per 5 secondi </button>
				</div>
			</div>';
	$js="$('#actionOpenWin').click(function(){
		var opt = {			
			width : $('#width').val(),
			height : $('#height').val(),
			header : $('#header').val(),
			content : $('#content').val(),
			footer : $('#footer').val()
		};
		pi.win.open(opt);
	});";
	$pr->addHtml('container',$out)->addScript($js)->response();
?>