<?php
	$out = "auto : ".var_export($pr->post('cars'),true)."<br>";
	$out .= "text : ".var_export($pr->post('text'),true)."<br>";
	$out .= "radio : ".var_export($pr->post('radio'),true)."<br>";
	$out .= "chk : ".var_export($pr->post('chk'),true)."<br>";
	$pr->alert($out);
?>