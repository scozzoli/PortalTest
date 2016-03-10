<?php
	$qry = $pr->post('locking');
	$header = 'Query bloccante';
	$content = '<div class="focus orange">
		Interrogazione che occupa la risorsa:
	</div>
	<div data-pi-component="code" data-pi-mode="sql" data-pi-readonly="true" name="sql" style="min-height:100px;">'.htmlentities($qry).'</div>';
	$footer = '<button class="red" onclick="pi.win.close()">Chiudi</button>';
	$pr->addWindow(500,0,$header,$content,$footer)->response();
?>