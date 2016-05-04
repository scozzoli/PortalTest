<?php
	$file = file_get_contents($pr->getRootPath('i18n/log/'.$pr->post('file')));
	$modList = $sysConfig->loadMod();
	
	function getModName($path,$list){
		foreach($list as $k => $v){
			if('../modules/'.$v['path'].'/' == $path){
				return $k;
			}
		}
		return false;
	}
	
	$file = explode("\n",$file);
	$chkfile = Array();
	$out ='<table class="orange lite" data-pic="tablesort">
		<tr>
			<th><i18n>logKey</i18n></th>
			<th><i18n>logLang</i18n></th>
			<th><i18n>logScope</i18n></th>
			<th><i18n>logKey</i18n></th>
		</tr>';
	$modules = Array();
	$common = Array();
	$def = Array();
	$sys = Array();
	foreach($file as $k => $row){
		if($chkfile[$row]){ continue; }
		$chkfile[$row] = true;
		$v = explode(";",$row);
		if(count($v) < 4){continue;}
		switch($v[1]){
			case 'local' :
				if(!isset($modules[$v[2]])){ $modules[$v[2]] = array(); }
				if(!isset($modules[$v[2]][$v[3]])){ $modules[$v[2]][$v[3]] = array(); }
				$modules[$v[2]][$v[3]][$v[0]] = true;
				break;
			case 'common' :
				if(!isset($common[$v[3]])){ $common[$v[3]] = array(); }
				$common[$v[3]][$v[0]] = true;
				break;
			case 'def' :
				if(!isset($def[$v[3]])){ $def[$v[3]] = array(); }
				$def[$v[3]][$v[0]] = true;
				break;
			case 'sys' :
				if(!isset($sys[$v[3]])){ $sys[$v[3]] = array(); }
				$sys[$v[3]][$v[0]] = true;
				break;
			default:
				$pr->error('<i18n>logScopeError;'.$v[1].'</i18n>');
		}
	}
	
	ksort($modules);
	$grupModule='<div class="panel green">
		<table class="form">
			<tr>
				<td><i18n>logInfoElabLog</i18n></td>
				<th>
					<button class="green" onclick="pi.request(null,\'LoadLogs\')"><i class="mdi mdi-arrow-left"></i> <i18n>back</i18n></button>
				</th>
			</tr>
		</table>
	</div>';
	
	foreach($modules as $k => $v){
		$modName = getModName($k,$modList);
		if($modName){
			$header = '<div class="header"><i class="mdi '.$modList[$modName]['icon'].'"></i> - <b>'.$modName.'</b> <i>['.htmlentities($k).']</i> ('.count($v).')</div>';
		}else{
			$header = '<div class="header red"><i class="mdi mdi-close-box"></i> - <b><i18n>moduleNotFound</i18n></b> <i>['.htmlentities($k).']</i> ('.count($v).')</div>';
		}
		$grupModule .= '<div class="panel" data-pic="collapse:{close:true}">
			'.$header.'
			<table class="lite" data-pic="tablesort">
				<tr>
					<th><i18n>logKeyName</i18n></th>
					<th><i18n>logKeyLang</i18n></th>
				</tr>';
		ksort($v);
		if($modName) { $i18n->openDic($k); }
		
		foreach($v as $kv => $vv){
			if($modName) { $i18n->addKey($kv); }
			$vals = array_keys($vv);
			$grupModule .= '<tr>
				<td>'.htmlentities($kv).'</td>
				<td>'.implode(' ',$vals).'</td>
			</tr>';
		}
		$grupModule .= '</table></div>';
		
		if($modName) { $i18n->saveDic(); }
	}
	
	if(count($common) > 0){
		ksort($common);
		$grupModule .= '<div class="panel" data-pic="collapse:{close:true}">
			<div class="header orange"><i class="mdi mdi-transcribe"></i> - <b><i18n>iface:common</i18n></b> <i>['.count($common).']</i> </div>
			<table class="lite" data-pic="tablesort">
				<tr>
					<th><i18n>logKeyName</i18n></th>
					<th><i18n>logKeyLang</i18n></th>
				</tr>';
				
		foreach($common as $k => $v){
			
			$vals = array_keys($v);
			$grupModule .= '<tr>
				<td>'.htmlentities($k).'</td>
				<td>'.implode(' ',$vals).'</td>
			</tr>';
		}
		$grupModule .= '</table></div>';
	}
	
	if(count($sys) > 0){
		ksort($sys);
		$grupModule .= '<div class="panel" data-pic="collapse:{close:true}">
			<div class="header red"><i class="mdi mdi-book-open-variant"></i> - <b><i18n>iface:default</i18n></b> <i>['.count($sys).']</i> </div>
			<table class="lite" data-pic="tablesort">
				<tr>
					<th><i18n>logKeyName</i18n></th>
					<th><i18n>logKeyLang</i18n></th>
				</tr>';
		foreach($sys as $k => $v){	
			
			$vals = array_keys($v);
			$grupModule .= '<tr>
				<td>'.htmlentities($k).'</td>
				<td>'.implode(' ',$vals).'</td>
			</tr>';
		}
		$grupModule .= '</table></div>';
	}

	unlink($pr->getRootPath('i18n/log/'.$pr->post('file')));
	
	$pr->addHtml('container',$grupModule)->response();
?>