<?php
	
	class PiFonticon{
		
		private $opt;
		private $colors;
		private $css;
		
		function __construct($iSchema = 'mdi'){
			$this->opt = Array(
				'css'	=>	'common/materialdesignicons.min.css',		// css da cui estrapolare gli stili
				'font'	=>	'fonts/materialdesignicons-webfont.ttf',	// font
				'size'	=>	32,											// Dimensione icone
				'color' =>	'black',									// Colore dell'icona (deve esserte codificato)
				'cache'	=>	'favicon',									// Direcotory dove salvare la cache
				'schema'=>	strtolower($iSchema)						// Schema per il parsing degli stili	
			);
			
			$this->colors = Array(
				'black'		=>	Array('r' => 0, 'g' => 0, 'b' => 0),
				'white'		=>	Array('r' => 255, 'g' => 255, 'b' => 255),
				'reserved'	=>	Array('r' => 255, 'g' => 0, 'b' => 255), // --> riservato per le trasparenze
			);
		}
		
		public function opt(){ //$iKey,$iVal
			if(!array_key_exists(func_get_arg(0),$this->opt)){
				die("Portal 1 Fonticon : L'opzione '".func_get_arg(0)."' non esiste!");
			}
			if (func_num_args() == 1) { 
				// Getter
				return $this->opt[func_get_arg(0)];
			} elseif(func_num_args() == 2) { 
				// setter
				if(func_get_arg(0) == 'color'){
					if(!array_key_exists(func_get_arg(1),$this->colors)){ 
						die("Portal 1 Fonticon : il colore '".func_get_arg(1)."' non esiste!");	
					}
					if(func_get_arg(1) == 'reserved') { 
						die("Portal 1 Fonticon : il colore '".func_get_arg(1)."' non può essere selezionato!");	
					}
				}
				$this->opt[func_get_arg(0)] = func_get_arg(1);
				return($this);
			} else { 
				// Numero di Parametri errato
				die("Portal 1 Fonticon : Numero di parametri errato in opt");
			}			
		}
		
		private function getColor($iColor){
			return $this->colors[$this->opt['color']][$iColor];
		}
		
		private function correctionX(){
			switch($this->opt['schema']){
				case 'mdi' :
					if($this->opt['size'] == 16) { return -2; }
					if($this->opt['size'] == 32) { return -4; }
				break;
				default : 
					return 0;
			}
		}
		
		private function correctionY(){
			switch($this->opt['schema']){
				case 'mdi' :
					if($this->opt['size'] == 16) { return 1; }
					if($this->opt['size'] == 32) { return 2; }
				break;
				default : 
					return 0;
			}
		}
		
		private function parseCSS(){
			$file = file_get_contents($this->opt['css']);
			preg_match_all( '/(?ims)([a-z0-9\s\.\:#_\-@,]+)\{([^\}]*)\}/', $file, $res);
			$css = array();
			foreach($res[0] as $k => $v){
				$key = trim($res[1][$k]);
				$vals = explode(';', trim($res[2][$k]));
				$aVals = array();
				foreach ($vals as $kv){
					if (!empty($kv)){
						$tmp = explode(":", $kv);
						$aVals[trim($tmp[0])] = trim($tmp[1]);
					}
				}

				$keys = explode(',', trim($key));
				foreach ($keys as $kk){
					$css[$kk] = $aVals;
				}
			}
			$this->css = $css;
		}
		
		private function getTextFromStyle($iIcon){
			switch($this->opt['schema']){
				case 'mdi' :
					$key = '.'.$iIcon.':before';
					$val = str_replace(Array('"','\\'),Array('',''),$this->css[$key]['content']);
					return '&#x'.$val.';';
				break;
				default :
					die("Portal 1 Fonticon : Schema {$this->opt['schema']} non gestito");
			}
		}
		
		private function createIcon($iIcon,$filename = null){
			$w = $h  = $this->opt['size'];
			$fontSize = $this->opt['size'] * 0.85 ;
			
			$icon = imagecreatetruecolor($w, $h);
			imagealphablending($icon, false);
			$fontColor = imagecolorallocate($icon, $this->getColor('r'), $this->getColor('g'), $this->getColor('b'));
			
			$bgColor = imagecolorallocatealpha($icon, 255, 0, 255, 127);
			imagefilledrectangle($icon, 0, 0, $w, $h, $bgColor);
			imagealphablending($icon, true);
			
			$xi = imagesx($icon);
			$yi = imagesy($icon);
			
			$box = imagettfbbox($fontSize, 45, $this->opt['font'], $this->getTextFromStyle($iIcon));
			$xr = abs(max($box[2], $box[4]));
			$yr = abs(max($box[5], $box[7]));
			
			$fontX = intval(($xi - $xr) / 2) + $this->correctionX();
			$fontY = intval(($yi + $yr) / 2) + $this->correctionY();
			
			imagettftext($icon, $fontSize, 0, $fontX, $fontY, $fontColor, $this->opt['font'], $this->getTextFromStyle($iIcon));
	
			imagealphablending($icon,false);
			imagesavealpha($icon,true);			
			imagepng($icon,$filename);
			imagedestroy($icon);
		}
		
		public function stream($iIcon){
			$iconName = $iIcon.'_'.$this->opt['color'].'_'.$this->opt['size'].'.png';
			if($this->opt['cache']){
				if(!file_exists($this->opt['cache'].'/'.$iconName)){
					$this->parseCSS();
					$this->createIcon($iIcon, $this->opt['cache'].'/'.$iconName);
				}
				header('Content-Disposition: Attachment;filename='.$iconName.'.png'); 
				header('Content-type: image/png'); 
	
				readfile($this->opt['cache'].'/'.$iconName);
			} else {
				
				header('Content-Disposition: Attachment;filename='.$iconName.'.png'); 
				header('Content-type: image/png'); 
				$this->createIcon($iIcon);
			}
		}
	}

	$img = $_GET['img'] ?: 'camera-iris';
	$color = $_GET['color'] ?: 'black';
	
	$favicon = new PiFonticon('mdi');
	$favicon->opt('css','common/materialdesignicons.min.css');
	$favicon->opt('font','fonts/materialdesignicons-webfont.ttf');
	$favicon->opt('cache','favicon');
	$favicon->opt('color',$color);
	$favicon->stream($img)
?>