<?
	//$pr->alert($pr->getLocalPath('upload/'));
	//$pr->alert($pr->file('filetest')->name());
	$out = ' <b>File : </b>';
	for($i = 0; $i< $pr->files('filetest'); $i++ ){
		$out .=  $pr->file('filetest',$i)->name().'; ';
	}
	$pr->info($out);
?>
