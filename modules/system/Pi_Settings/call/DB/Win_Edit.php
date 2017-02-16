<?php
	$db_list = $sysConfig->loadDB();
	
	$id = $pr->post('id',false);
	$isUsed = $pr->post('used',0);
	
	$type = $id ? $db_list[$id]['DB'] : $type=$pr->post('DB');
		
	$pr->next('DB/Win_Edit_'.$type);
?>