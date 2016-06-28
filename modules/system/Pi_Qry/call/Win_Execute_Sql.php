<?php
	$header = '<i18n>lbl:qry</i18n>';
	$qry = $pr->post('sql');
	$content = '<div id="winEdit">
		<input type="hidden" name="Q" value="Exec_Query">
		<input type="hidden" name="db" value="'.$pr->post('db').'">
		<div class="focus blue">
		<i18n>info:execQry</i18n> <br />
		</div>
		<div data-pic="code : {mode:\'sql\', readOnly:true }" name="qry" style="min-height:100px;">'.htmlentities($qry).'</div>
	</div>';
	$footer = '<button class="red" onClick="pi.win.close();"> <i18n>cancel</i18n> </button> <button class="green" onClick="pi.requestOnModal(\'winEdit\');"> <i18n>btn:exec</i18n> </button>';

	$pr->addWindow(600,0,$header,$content,$footer)->response();
?>
