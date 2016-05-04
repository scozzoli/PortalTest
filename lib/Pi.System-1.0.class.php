<?php
 
 class PiSystem{
		 
	private $opt;
	private $path;
	private $pr;
	private $lang;
	
	/*
		Classe per la gestione dei file di configurazione.
		Le possibili opzioni per il salvataggio dei dati sono : 
		json -> il più lento (ma permette una struttura complessa e facilmente editabile anche a mano)
		ini -> veloce e facile da editare a mano ma limitante nell'uso dei caratteri e nella complessita dei dati (max 2 livelli nativi + 1 con notazioe var[x] = valore e codifica base64 se ci  sono caratteri speciali)
		serialize -> 'na scheggia di guerra che permette la massima complessita... MOLTO difficile da leggere e scrive a mano
		encripted -> lo stesso di serialize ma con la cifratura (il più sicuro)
	*/
	
	public function __construct($iPath = './',$iLang = false){	
		
		if(file_exists($iPath)){
			$this->path = $iPath;
		}else{
			die("Pi System : {$iPath} non è presente su disco");
		}
		
		if(file_exists($iPath.'system.ini')){
			$type = parse_ini_file($iPath.'system.ini',false);
		}else{
			$type['format'] = 'json';
		}
		
		$this->opt = array(
				'type'			=>	$type['format'],
				'users' 		=>	false,
				'groups'		=>	false,
				'modules'		=>	false,
				'menu'			=>	false,
				'db'			=>	false,
				'i18n'			=>	false,
				'key'			=>	'mybucuducu!++[**~',
				'iv'			=>	'nelmezzodelcammi'
		);
		
		$this->lang = $iLang;
	}
	
	private function _load($iSetting){
		switch($this->opt['type']){
			case 'ini' : 
				$out = parse_ini_file($this->path.$iSetting.'.ini', true);
				break;
			case 'json'	: 
				$out = json_decode(file_get_contents($this->path.$iSetting.'.json'),true);
				break;
			case 'serialize' : 
				$out = unserialize(file_get_contents($this->path.$iSetting.'.ser'));
				break;
			case 'encripted' : 
				$out = unserialize(openssl_decrypt(file_get_contents($this->path.$iSetting.'.aes'),'aes-128-cbc',$this->opt['key'],true,$this->opt['iv']));
				break;
		}
		ksort($out);
		return $out;
	}
	
	private function _save($iSetting,$iData){
		switch($this->opt['type']){
			case 'ini' :
				$this->createIniFile($iData,$this->path.$iSetting.'.ini', true);
			break;
			case 'json'	:
				file_put_contents($this->path.$iSetting.'.json', json_encode($iData,JSON_PRETTY_PRINT));
			break;
			case 'serialize' :
				file_put_contents($this->path.$iSetting.'.ser', serialize($iData));
			break;
			case 'encripted' :
				file_put_contents($this->path.$iSetting.'.aes', openssl_encrypt(serialize($iData),'aes-128-cbc',$this->opt['key'],true,$this->opt['iv']));
			break;
		}
	}
	
	private function createIniFile($assoc_arr, $path, $has_sections=FALSE) { 
		$content = ""; 
		$eol = "\n";
		if($has_sections){ 
			foreach ($assoc_arr as $key=>$elem){ 
				$content .= $eol.'['.$key.']'.$eol; 
				foreach ($elem as $key2=>$elem2){ 
					if(is_array($elem2)){ 
							//for($i=0;$i<count($elem2);$i++){
						foreach($elem2 as $i => $val){
							$content .= $key2."['$i'] = \"".$val."\"$eol"; 
						} 
					}else if($elem2===""){
						$content .= $key2." = $eol";
					}else{
						$content .= $key2." = \"".$elem2."\"$eol"; 
					}
				} 
			} 
		}else{ 
			foreach ($assoc_arr  as $key2=>$elem2){ 
				if(is_array($elem2)){ 
						//for($i=0;$i<count($elem2);$i++){
					foreach($elem2 as $i => $val){
						$content .= $key2."['$i'] = \"".$val."\"$eol"; 
					} 
				}else if($elem2===""){
					$content .= $key2." = $eol";
				}else{
					$content .= $key2." = \"".$elem2."\"$eol"; 
				}
			}
			
		}  
		if (!$handle = fopen($path, 'w')){ 
			return false; 
		} 
		if (!fwrite($handle, $content)){ 
			return false; 
		} 
		fclose($handle); 
		return true; 
	} 
	
	public function saveFormat($iFormat){
		if($iFormat == 'ini' || $iFormat == 'json' || $iFormat == 'serialize' || $iFormat == 'encripted'){
			$config = array('format' => $iFormat);
			$this->createIniFile($config,$this->path.'system.ini',false);
		}else{
			die("Pi System : Formato {$iFormat} non supportato!");
		}
	}
	
	public function loadDB(){ 
		if(!$this->opt['db']){ $this->opt['db'] = $this->_load('db'); }
		return $this->opt['db'];
	}
	
	public function loadUsr(){ 
		if(!$this->opt['users']){ $this->opt['users'] = $this->_load('users'); }
		return $this->opt['users'];
	}
	
	public function loadGrp(){ 
		if(!$this->opt['groups']){ $this->opt['groups'] = $this->_load('groups'); }
		return $this->opt['groups'];
	}
	
	public function loadMod(){ 
		if(!$this->opt['modules']){ $this->opt['modules'] = $this->_load('modules'); }
		return $this->opt['modules'];
	}
	
	public function loadMenu(){ 
		if(!$this->opt['menu']){ 
			if($this->opt['type'] == 'ini'){
				$dir = scandir($this->path.'menu');
				$this->opt['menu'] = Array();
				foreach($dir as $k => $v){
					if(strpos($v,'.ini')){
						$file = substr($v,0,-4);
						$this->opt['menu'][$file] = $this->_load("menu/{$file}");
					}
				}
			}else{
				$this->opt['menu'] = $this->_load('menu'); 
			}
		}
		return $this->opt['menu'];
	}
	
	public function saveDB($iData){ 
		$this->opt['db'] = $iData;
		$this->_save('db',$iData);
	}
	
	public function saveUsr($iData){ 
		$this->opt['users'] = $iData;
		$this->_save('users', $iData); 
	}
	
	public function saveGrp($iData){
		$this->opt['groups'] = $iData;
		$this->_save('groups', $iData); 
	}
	public function saveMod($iData){ 
		$this->opt['modules'] = $iData;
		$this->_save('modules', $iData);
	}
	public function saveMenu($iData){ 
		$this->opt['menu'] = $iData;
		if($this->opt['type'] == 'ini'){
			if(!file_exists($this->path.'menu')){
				mkdir($this->path.'menu');
			}
			foreach($iData as $k => $v){
				$this->_save("menu/{$k}", $v);
			}
			$dir = scandir($this->path.'menu');
			foreach($dir as $k => $v){
				if(strpos($v,'.ini') && !isset($this->opt['menu'][substr($v,0,-4)])){
					unlink($this->path."menu/{$v}");
				}
			}
		}else{
			$this->_save('menu', $iData); 
		}
	}
	
	// la configurazione di i18n non è sensibile e necessita di essere modifcata anche a mano, per questo è l'unica che rimane sempre in JSON
	
	public function loadI18n(){
		if(!$this->opt['i18n']){ 
			$this->opt['i18n'] = json_decode(file_get_contents($this->path.'../i18n/settings.json'),true);}
		return $this->opt['i18n'];
		
	}
	
	public function saveI18n($iData){
		$this->opt['i18n'] = $iData;
		file_put_contents($this->path.'../i18n/settings.json', json_encode($iData,JSON_PRETTY_PRINT));
	}
	
	public function set($iKey,$iVal){
		if(array_key_exists($iKey,$this->opt)){
			$this->opt[$iKey] = $iVal;
		}
		return $this;
	}
	
	public function get($iKey){
		if(!array_key_exists($iKey,$this->opt)){
			return null;
		}else{
			return $this->opt[$iKey];
		}
	}
	
	public function i18nGet($iData,$iName = false){
		if(!$this->opt['i18n']){
			$this->loadI18n();
		}
		
		$var = $iName === false ? $iData : $iData[$iName];
		if($this->lang){
			$tr = $var[$this->lang] ?: '';	
		}else{
			$tr = '';
		}
		if(trim($tr) == ''){
			$tr = $var[$this->opt['i18n']['defaultLang']] ?: '';
		}
		return $tr;
	}
	
	public function clean($iFormat){
		if($iFormat == $this->opt['type']){ return false; }
		switch($iFormat){
			case 'ini' :
				unlink($this->path.'users.ini');
				unlink($this->path.'groups.ini');
				unlink($this->path.'db.ini');
				unlink($this->path.'modules.ini');
				foreach(scandir($this->path.'menu') as $f){
					if($f == '.' || $f == '..'){ continue; }
					unlink($this->path.'menu/'.$f);
				}
				rmdir($this->path.'menu');
			break;
			case 'json':
				unlink($this->path.'users.json');
				unlink($this->path.'groups.json');
				unlink($this->path.'db.json');
				unlink($this->path.'modules.json');
				unlink($this->path.'menu.json');
			break;
			case 'serialize':
				unlink($this->path.'users.ser');
				unlink($this->path.'groups.ser');
				unlink($this->path.'db.ser');
				unlink($this->path.'modules.ser');
				unlink($this->path.'menu.ser');
			break;
			case 'encripted':
				unlink($this->path.'users.aes');
				unlink($this->path.'groups.aes');
				unlink($this->path.'db.aes');
				unlink($this->path.'modules.aes');
				unlink($this->path.'menu.aes');
			break;
		}
	}
	
	public function __destruct(){}
}

?>