<?php
class PiI18n{
	
	private $lang;
	private $defaultLang;
	private $modulePath;
	private $rootPath;
	
	public function __construct($iLang){
		$this->lang = strtolower($iLang);
		$this->modulePath = '';
		$this->defaultLang = $iLang;
		$this->rootPath = './';
	}
	
	public function setModule($iPath){
		$this->modulePath = $iPath;
		return $this;
	}
	
	public function setDefaultLang($iLang){
		$this->defaultLang = $iLang;
		return $this;
	}
	
	public function setLang($iLang){
		$this->lang = strtolower($iLang);
		return $this;
	}
	
	private function getModule($iLang){
		if(file_exists($this->modulePath.'/i18n')){
			if(file_exists($this->modulePath."/i18n/{$iLang}.json")){
				return json_decode(file_get_contents($this->modulePath."/i18n/{$iLang}.json"));
			}else{
				return array($this->lang => Array());
			}
		}else{
			return array();
		}
	}
	
	private function getCommon($iLang){
		if(file_exists($this->rootPath.'common')){
			if(file_exists($this->rootPath."common/{$iLang}.json")){
				return json_decode(file_get_contents($this->rootPath."/common/{$iLang}.json"));
			}else{
				return array($this->lang => Array());
			}
		}else{
			return array();
		}
	}
	
	private function getDefaults($iLang){
		if(file_exists($this->rootPath.'defaults')){
			
			if(file_exists($this->rootPath."defaults/{$iLang}.json")){
				return json_decode(file_get_contents($this->rootPath."/defaults/{$iLang}.json"));
			}else{
				return array($this->lang => Array());
			}
		}else{
			return array();
		}
	}
	
	private function getSystem($iLang){
		if(file_exists($this->rootPath.'system')){
			
			if(file_exists($this->rootPath."system/{$iLang}.json")){
				return json_decode(file_get_contents($this->rootPath."/system/{$iLang}.json"));
			}else{
				return array($this->lang => Array());
			}
		}else{
			return array();
		}
	}
	
	public function createJsonDictionary(){
		$out = Array(
			'def' => Array(),
			'common' => Array(),
			'local' => Array(),
			'sys' => Array(),
			'lang' => $this->lang,
			'module' => $this->modulePath
		);
		
		// Recupero la lingua richiesta
		
		$out['def'][$this->lang] = $this->getDefaults($this->lang);
		$out['sys'][$this->lang] = $this->getSystem($this->lang);
		$out['common'][$this->lang] = $this->getCommon($this->lang);
		$out['local'][$this->lang] = $this->getModule($this->lang);
		
		// Recupero i deafults (solo se diversi dalla lingua selezionata)
		
		if($this->defaultLang != $this->lang){
			$out['def'][$this->defaultLang] = $this->getDefaults($this->defaultLang);
			$out['sys'][$this->defaultLang] = $this->getSystem($this->defaultLang);
			$out['common'][$this->defaultLang] = $this->getCommon($this->defaultLang);
			$out['local'][$this->defaultLang] = $this->getModule($this->defaultLang);
		}
		
		return json_encode($out);
	}
}
?>
