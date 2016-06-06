<?php
	$header = 'Query Editor';
	$qry = $pr->post('qry');
	$numRows = substr_count($qry,"\n");
	if ($numRows < 10){ $numRows = 10; }
	$content = '<div id="winEdit">
		<input type="hidden" name="Q" value="Calc_Query">
		<input type="hidden" name="inputs">
		<div class="focus blue">
			<i18n>info:editQry</i18n>
		</div>
		<div data-pic="code : {mode:\'sql\'}"  name="qry" style="min-height:500px;">'.htmlentities($qry).'</div>
	</div>';
	$footer = '<button class="red" onClick="pi.win.close();"> <i18n>cancel</i18n> </button> <button class="green" onClick="pi.requestOnModal(\'winEdit\');"> <i18n>save</i18n> </button>';

	$fill = Array('inputs' => $pr->post('inputs'));

	$pr->addWindow(600,0,$header,$content,$footer)->addFill('winEdit',$fill)->response();
?>
