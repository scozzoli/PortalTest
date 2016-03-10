<?php
	$out='<iframe id="frame" src="style/common/preview.html" style="width:calc( 100% - 10px ); height:100%; border:none; margin:5px;"/>';
	$js='setTimeout(function(){$("#frame").height($("#frame").contents().height())}, 200); ';
	$pr->addHtml('container',$out)->addScript($js)->response();
?>