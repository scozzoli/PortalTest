<?php
	include 'lib/Pi.System.php';
	
	$sysConfig = new PiSystem('./settings/','it');
	
	echo '<h1> Conversione dei file di configurazione: </h1><br>';
	echo '<h2> Moduli </h2><br>';
	$tmp = $sysConfig->loadMod();
	
	foreach($tmp as $k => $v){
		$done = false;
		if(is_string($v['nome'])){ 	
			$tmp[$k]['nome'] = array('it' => $v['nome']);	
			$done = true;
		}
		if(is_string($v['des'])){ 	
			$tmp[$k]['des'] = array('it' => $v['des']);	
			$done = true;
		}
		
		echo $k.' - '.htmlentities($tmp[$k]['nome']['it']);
		if($done){
			echo '<b> Convertito </b><br>';
		}else{
			echo '<b> OK </b><br>';
		}
	}
	
	$sysConfig->saveMod($tmp);
	
	
	echo '<br><br><h2> Gruppi </h2><br>';
	$tmp = $sysConfig->loadGrp();
	
	foreach($tmp as $k => $v){
		$done = false;
		if(is_string($v['nome'])){ 	
			$tmp[$k]['nome'] = array('it' => $v['nome']);	
			$done = true;
		}
		if(is_string($v['des'])){ 	
			$tmp[$k]['des'] = array('it' => $v['des']);	
			$done = true;
		}
		
		echo $k.' - '.htmlentities($tmp[$k]['nome']['it']);
		if($done){
			echo '<b> Convertito </b><br>';
		}else{
			echo '<b> OK </b><br>';
		}
	}
	
	$sysConfig->saveGrp($tmp);
	
	
	echo '<br><br><h2> Menu </h2><br>';
	$tmp = $sysConfig->loadMenu();
	
	foreach($tmp as $k => $v){
		$done = false;
		
		foreach($v as $idx => $val){
			if(is_string($val['des'])){
				$tmp[$k][$idx]['des'] = array('it' => $val['des']);	
				$done = true;
			}
		}
		
		echo $k;
		if($done){
			echo '<b> Convertito </b><br>';
		}else{
			echo '<b> OK </b><br>';
		}
	}
	
	$sysConfig->saveMenu($tmp);
	
	echo '<br><br><h2> Utenti </h2><br>';
	$tmp = $sysConfig->loadUsr();
	
	foreach($tmp as $k => $v){
		$done = false;
		
		if(!isset($v['lang'])){
			$tmp[$k]['lang'] = 'it';
			$done = true;
		}
		
		echo $k;
		if($done){
			echo '<b> Convertito </b><br>';
		}else{
			echo '<b> OK </b><br>';
		}
	}
	
	$sysConfig->saveMenu($tmp);
	
?>