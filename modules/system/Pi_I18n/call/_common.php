<?php
	include $pr->getRootPath('lib/Pi.DB.php');
	include $pr->getRootPath('lib/Pi.System.php');
		
	//$db = new PiDB($pr->getDB(),$pr);
	$sysConfig = new PiSystem($pr->getRootPath('settings/'),$pr->getUsr('lang'));
	
	session_write_close();
	
	class PiI18nManipulate{
		private $rootPath;
		private $config;
		private $path;
		private $dic;
		private $scope;
		
		public function __construct($iRootPath){
			$this->rootPath = $iRootPath;
			$this->config = json_decode(file_get_contents($iRootPath.'/i18n/settings.json'),true);
			$this->path = '';
			$this->dic = Array();
		}
		
		public function openDic($iPath,$iScope='i18n'){
			$this->path = $iPath;
			$this->scope = $iScope;
			$config = Array();
			if(file_exists($iPath.$iScope)){
				foreach($this->config['langs'] as $k => $v){
					if(file_exists($iPath."{$iScope}/{$k}.json")){
						$config[$k] = json_decode(file_get_contents($iPath."{$iScope}/{$k}.json"),true);
					}else{
						$config[$k] = Array();
					}
				}
			}else{
				foreach($this->config['langs'] as $k => $v){			
					$config[$k] = Array();
				}
			}
			$this->createDic($config);
			return $this;
		}
		
		public function getDic(){
			return $this->dic;
		}
		
		public function saveDic(){
			$config = $this->createConfig();
			if(!file_exists($this->path.$this->scope)){
				mkdir($this->path.$this->scope);
			}
			foreach($config as $lang => $cfg){
				//ksort($cfg);
				file_put_contents($this->path.'/'.$this->scope."/{$lang}.json",json_encode($cfg,JSON_PRETTY_PRINT));
			}
		}
		
		public function addKey($iKey){
			$this->dic[$iKey] = $this->dic[$iKey] ?: Array();
			foreach($this->config['langs'] as $k => $v){
				$this->dic[$iKey][$k] = $this->dic[$iKey][$k] ?: '';
			}
			return $this;
		}
		
		public function updateValue($iKey,$iLang,$iVal){
			if(isset($this->dic[$iKey])){
				$this->dic[$iKey][$iLang] = $iVal;
			}
			return $this;
		}
		
		public function removeKey($iKey){
			unset($this->dic[$iKey]);
			return $this;
		}
		
		public function getString($ikey,$iLang = false){
			if($iLang){
				return $this->dic[$iKey][$iLang];
			}else{
				return $this->dic[$iKey];
			}
		}
		
		public function getConfig($iLang = false){
			if(!$iLang){
				return $this->config;
			}else{
				return $this->config['langs'][$iLang];
			}
		}
		
		private function createDic($iConfig){
			$this->dic = Array();
			
			foreach($iConfig as $lang => $dic){
				foreach($dic as $key => $val){
					$this->dic[$key][$lang] = $val;
				}
			}
			
			foreach($this->dic as $key => $dic){
				foreach($this->config['langs'] as $lang => $langCong){
					if(!isset($dic[$lang])){
						$this->dic[$key][$lang] = '';
					}
				}
			}
		}
		
		private function createConfig(){
			$config = Array();
			ksort($this->dic);
			foreach($this->dic as $key => $dic){
				foreach($dic as $lang => $val){
					$config[$lang][$key] = $val;
				}
			}
			return $config;
		}
	}
	
	$i18n = new PiI18nManipulate($pr->getRootPath(''));
	
	function getModuleKeyList($iModule,$iId,$iConfig,$iDic,$iScope = 'local'){
		
		$out = '<div id="container_'.$iId.'">
				<table class="lite fix" data-pic="tablesort">
			<tr><th><i18n>lblKeyName</i18n></th>';
		foreach($iConfig['langs'] as $key => $val){
			$out.='<th style="text-align:center;"><img src="./style/img/'.$val['icon'].'"> '.$val['des'].' </th>';
		}
		$myIdx = 0;
		$out.='<th style="text-align:center;" data-sort:"none"><i18n>remove</i18n></th></tr>';
		foreach($iDic as $key => $lang){
			$out.='<tr id="row_'.$iId.'_'.$myIdx.'">	<td>'.$key.'</td>';
			foreach($iConfig['langs'] as $kLang => $val){
				if(trim($lang[$kLang]) == ''){
					$classLang= 'orange';
					$icon = '<i class="mdi mdi-close l2 j-icon '.$classLang.'"></i> <i class="j-prev"></i>';
					$align = 'center';
				}else{
					$classLang= 'blue';
					$icon = '<i class="mdi mdi-check l2 j-icon '.$classLang.'"></i> <i class="j-prev">'.htmlentities(substr($lang[$kLang],0,50)).'</i>';
					$align = 'left';
				}
				$out.='<td id="Lang_'.$iId.'_'.$myIdx.'_'.$kLang.'" style="text-align:'.$align.'; cursor:pointer;" class="'.$classLang.'" onclick="pi.request(this.id)">
					'.$icon.'
					<input type="hidden" name="Q" value="WinEditLocal">
					<input type="hidden" name="lang" value="'.$kLang.'">
					<input type="hidden" name="module" value="'.$iModule.'">
					<input type="hidden" name="key" value="'.$key.'">
					<input type="hidden" name="scope" value="'.$iScope.'">
					<input type="hidden" name="containerId" value="'.$iId.'">
				</td>';
				
			}
			$out .='
			<td class="red" style="text-align:center; cursor:pointer;" onclick="pi.chk(\'<i18n>chk:confirmDelete</i18n>\').request(this.id);" id="Lang_'.$k.'_'.$myIdx.'">
				<input type="hidden" name="Q" value="RemoveKey">
				<input type="hidden" name="module" value="'.$iModule.'">
				<input type="hidden" name="key" value="'.$key.'">
				<input type="hidden" name="scope" value="'.$iScope.'">
				<input type="hidden" name="containerId" value="'.$iId.'">
				<i class="mdi mdi-delete l2 red"></i>
			</td>
			</tr>';
			$myIdx++;
		}
		$out .= '</table></div>';
		
		return $out;
	}
?>