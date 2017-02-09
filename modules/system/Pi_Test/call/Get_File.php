<?php
	
	header('Content-Type: image/png');
	header('Content-Disposition: attachment; filename="image.png"');
	
	$fp = fopen($pr->getLocalPath('/img.png'),"rb");
	$out = fread($fp,filesize($pr->getLocalPath('/img.png')));
	fclose($fp);
	$pr->responseRaw($out);
?>