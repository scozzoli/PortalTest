<?php
	$header = 'Query Editor';
	$qry = $pr->post('qry');
	$numRows = substr_count($qry,"\n");
	if ($numRows < 10){ $numRows = 10; }
	$content = '<div id="winEdit">
		<input type="hidden" name="Q" value="Calc_Query">
		<input type="hidden" name="inputs">
		<div class="focus blue">
			Editor delle interrogazioni. <br />
			le variabili vengono automaticamente riconosiute al <b>salva</b> e devono avere il formato <b>{<i class="disabled">nome</i>}</b><br/>
			<b>ATTENZIONE:</b> Le variabili non possono contenere spazi e sono presentate in ordine <i>alfabetico</i>
		</div>
		<div data-pi-component="code" data-pi-mode="sql" name="qry" style="min-height:500px;">'.htmlentities($qry).'</div>
	</div>';
	$footer = '<button class="red" onClick="pi.win.close();"> Annulla </button> <button class="green" onClick="pi.requestOnModal(\'winEdit\');"> Salva </button>';
	
	$fill = Array('inputs' => $pr->post('inputs'));
	
	$pr->addWindow(600,0,$header,$content,$footer)->addFill('winEdit',$fill)->response();
?>