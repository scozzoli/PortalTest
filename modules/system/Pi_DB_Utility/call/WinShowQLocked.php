<?php
	$qry = $pr->post('locked');
	$header = 'Query bloccata';
	$content = '<div class="focus green">
		Interrogazione in attesa delle risorse:
	</div>
	<div data-pi-component="code" data-pi-mode="sql" data-pi-readonly="true" name="sql" style="min-height:100px;">'.htmlentities($qry).'</div>';
	$footer = '<button class="red" onclick="pi.win.close()">Chiudi</button>';
	$pr->addWindow(500,0,$header,$content,$footer)->response();
?>