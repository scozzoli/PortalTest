<?php
	$qry = $pr->post('qry');
	$header = 'Query';
	$hRow = substr_count($qry,"\n");
	
	if($hRow < 10){
		$hRow = 10;
	}elseif($hRow > 35){
		$hRow = 35;
	}
	
	$content = '<div class="focus green">
		Interrogazione in esecuzione: 
	</div>
	<div data-pi-component="code" data-pi-mode="sql" data-pi-readonly="true" name="sql" data-pi-lines="'.$hRow.'" style="min-height:100px;">'.htmlentities($qry).'</div>';
	$footer = '<button class="red" onclick="pi.win.close()">Chiudi</button>';
	$pr->addWindow(500,0,$header,$content,$footer)->response();
?>