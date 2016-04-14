<?php
	$header = 'Interrogazione SQL';
	$qry = $pr->post('sql');
	$content = '<div id="winEdit">
		<input type="hidden" name="Q" value="Exec_Query">
		<input type="hidden" name="db" value="'.$pr->post('db').'">
		<div class="focus blue">
			Eseguire la seguente interrogazione?. <br />	
		</div>
		<div data-pic="code : {mode:\'sql\', readOnly:true }" name="qry" style="min-height:100px;">'.htmlentities($qry).'</div>
	</div>';
	$footer = '<button class="red" onClick="pi.win.close();"> Annulla </button> <button class="green" onClick="pi.requestOnModal(\'winEdit\');"> Esegui </button>';
	
	$pr->addWindow(600,0,$header,$content,$footer)->response();
?>