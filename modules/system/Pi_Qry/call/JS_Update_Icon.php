<?php
	$ico = $pr->post('Ico');
	$js = "$('#icon_icon').val('{$ico}'); $('#icon_show').attr('class','mdi l2 {$ico}');";
	$pr->addScript($js)->response();
?>