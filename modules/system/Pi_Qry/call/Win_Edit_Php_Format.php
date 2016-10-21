<?php
	$header = 'PHP Editor';
	$php = json_decode($pr->post('php'),true);
	$numRows = substr_count($php['code'],"\n");
	if ($numRows < 10){ $numRows = 10; }
	$content = '<div id="winEdit">
		<div class="focus blue">
			<input type="checkbox" name="enabled" '.($php['enabled'] ? 'checked' : '').'> <i18n>lbl:phpEnable</i18n> <br>
		</div>
		<table class="form">
			<tr>
				<td width="60%">
					<div data-pic="code : {mode:\'php\'}"  name="code" style="min-height:500px;">'.htmlentities($php['code']).'</div>
				</td>
				<td style="vertical-align:top">
					<div class="focus blue">
						<i class="mdi mdi-information l2"></i> <i style="font-size:24px;"><i18n>lbl:phpIstrunction</i18n></i>
					<div>
					<div class="focus blue">
						<i18n>info:phpInstruction</i18n>
					</div>
				</td>
			</tr>
		</table>

	</div>';
	$js = '$("#save_php_button").click(function(){
		$("#php_qry_value").val(JSON.stringify(pi.getInputsByName("winEdit").call));
		pi.win.close();
	});';
	$footer = '<button class="red" onClick="pi.win.close();"> <i18n>cancel</i18n> </button> <button class="green" id="save_php_button"> <i18n>save</i18n> </button>';

	$pr->addWindow(600,0,$header,$content,$footer)->addScript($js)->response();
?>
