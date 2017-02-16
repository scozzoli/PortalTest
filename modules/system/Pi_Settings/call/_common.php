<?php
	include $pr->getRootPath('lib/Pi.DB.php');
	//include $pr->getRootPath('lib/Pi.Custom.php'); --> la usavo solo per array_put
	include $pr->getRootPath('lib/Pi.System.php');
	
	$db = new PiDB($pr->getDB());
	session_write_close();
	
	$sysConfig = new PiSystem($pr->getRootPath('settings/'),$pr->getUsr('lang'));
	
	//$usr_list = parse_ini_file($pr->getRootPath('settings/users.ini'),true);
	//$grp_list = parse_ini_file($pr->getRootPath('settings/groups.ini'),true);
	//$db_list = parse_ini_file($pr->getRootPath('settings/db.ini'),true);
	//$mod_list = parse_ini_file($pr->getRootPath('settings/modules.ini'),true);
	//ksort($mod_list);
	//ksort($usr_list);
	//ksort($db_list);
	//ksort($grp_list);
	
	function get_img_tit($id,$op = 1){
		switch($id){
			case '0' : $class='mdi-close'; $color='#800'; $title = 'Nessun permesso - pubblico'; break;
			case '1' : $class='mdi-check'; $color='#080'; $title = 'Permesso standard - apparteneze'; break;
		}
		return(array('<i class="mdi '.$class.'" style="color: '.$color.'; Opacity:'.$op.';">',$title));
	}
	
	function get_mod_menu($menu,$mod,$path){
		$tot = 0;
		$miss = 0;
		foreach($menu as $k => $v){
			if(!isset($v['list'])){continue;}
			if(!is_array($v['list'])){continue;}
			for($i=0;$i!=count($v['list']);$i++){
				$tot++;
				if(!isset($mod[$v['list'][$i]])){
					$miss++;
				}
			}
		}
		return(array($tot,$miss));
	}
	function get_oci8_des($oci8){
		$start = strpos($oci8,'HOST');
		if($start === false){return array('server'=>'','port'=>'','service'=>'');}
		
		$start = strpos($oci8,'=',$start);
		$start++;
		$stop = strpos($oci8,')',$start);
		$out['server'] = trim(substr($oci8,$start,$stop-$start));
		
		$start = strpos($oci8,'PORT');
		$start = strpos($oci8,'=',$start);
		$start++;
		$stop = strpos($oci8,')',$start);
		$out['port'] = trim(substr($oci8,$start,$stop-$start));
		
		$start = strpos($oci8,'SERVICE_NAME');
		$start = strpos($oci8,'=',$start);
		$start++;
		$stop = strpos($oci8,')',$start);
		$out['service'] = trim(substr($oci8,$start,$stop-$start));
		
		return $out;
	}
	
	function getLangList($pr){
		////$pr->error(json_encode(Array('x'=>'Español')));
		//if(file_exists($pr->getRootPath('i18n/settings.json')))
		//	$pr->error(file_get_contents($pr->getRootPath('i18n/settings.json')));
		//else
		//	$pr->alert($pr->getRootPath('i18n/settings.json'));
		return json_decode(file_get_contents($pr->getRootPath('i18n/settings.json')),true);
	}
	
	function array_put(&$array, $key, $pos){
		if(is_string($key)){
			$index = 0;
			foreach($array as $k => $v){
				if($index == $pos){$new[$key] = $array[$key];}
				if($k == $key){continue;}
				$new[$k] = $array[$k];
				$index++;
			}
		}else{
			$new =$array;
			$new[$pos] = $array[$key];
			$inc = ($pos>$key) ? 1 : -1;
			//die("E: $key - $pos - $inc");
			for($i=$key;$i!=$pos;$i+=$inc){
				$new[$i] = $array[$i+$inc];
			}
		}
		$array = $new;
	}

?>