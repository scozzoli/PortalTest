<?php
	/**
	 * Includo tutti i css nella cartella common.
	 * La priorità viene data ai file .min.css in modod che non venga caricaricato 2 volte lo stesso foglio di stile:
	 *  - Se siste <nomefile>.min.css --> carico
	 *  - Se siste <nomefile>.css --> carico solo se non esiste la versione .min.css
	 */
	
	$dir = scandir('./common');
	
	$list = array();
	
	foreach($dir as $k => $v){
		if(substr(strtolower($v),-4) == '.css'){
			if(substr(strtolower($v),-8) == '.min.css'){
				$list[substr(strtolower($v),0,-8)] = true;
			}else{
				$list[substr(strtolower($v),0,-4)] = $list[substr(strtolower($v),0,-4)] ?: false;
			}
		}
	}
	
	$out = '';
	$crlf = "\n";
	foreach($list as $k => $v){
		$ext = $v ? 'min.css' : 'css';
		$out .= $crlf."@import url(./common/{$k}.{$ext});";
	}
	
	header('Content-type: text/css');
	echo $out
?>