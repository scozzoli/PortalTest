<?php
	$logDir = scandir($pr->getRootPath('i18n/log'));
	
	$missList = '<table class="lite orange">
		<tr>
			<th><i18n>logFileName</i18n></th>
			<th><i18n>logDtm</i18n></th>
			<th style="text-align:right;"><i18n>logFileSize</i18n></th>
			<th style="text-align:right;"><i18n>logActions</i18n></th>
		</tr>';
	foreach($logDir as $k => $v){
		if(strpos($v,'.miss')){
			$missList .='<tr>
				<td>'.$v.'</td>
				<td>'.substr($v,6,2).'/'.substr($v,4,2).'/'.substr($v,0,4).'</td>
				<td style="text-align:right;">'.number_format(filesize($pr->getRootPath('i18n/log/'.$v)),0).'</td>
				<td style="text-align:right;">
					<div id="lf_'.substr($v,0,8).'">
						<input type="hidden" name="Q" value="ElabLogFile">
						<input type="hidden" name="file" value="'.$v.'">
						<button class="orange" onclick="pi.request(\'lf_'.substr($v,0,8).'\')"><i class="mdi mdi-pencil"></i><i18n>logElabora</i18n></button>
					</div>
				</td>
			</tr>';
		}
	}
	$missList .='</table>';
	
	$out = '<div class="panel">'.$missList.'</div>';
	
	$pr->addHtml('container',$out)->response();
?>