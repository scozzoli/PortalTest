<?php
	//$pr->alert($pr->getLocalPath('upload/'));
	//$pr->alert($pr->file('filetest')->name());
	$out = ' <b>File : </b>';
	for($i = 0; $i< $pr->files('filetest'); $i++ ){
		$out .=  $pr->file('filetest',$i)->name().'; ';
		/*
		// salva il file con il nome originario nella cartella locale "upload"
			$pr->file('filetest',$i)->save($pr->getLocalPath('upload/'))
		// salva il file con un nome diverso
			$pr->file('filetest',$i)->save($pr->getLocalPath('upload/','prova.jpg'))
		*/
	}
	$pr->info($out);
?>