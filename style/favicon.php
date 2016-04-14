<?php
	
	//error_reporting(E_ALL || ~E_NOTICE);
	
	function parseCSS($file){
		$css = file_get_contents($file);
		preg_match_all( '/(?ims)([a-z0-9\s\.\:#_\-@,]+)\{([^\}]*)\}/', $css, $arr);
		$result = array();
		foreach ($arr[0] as $i => $x){
			$selector = trim($arr[1][$i]);
			$rules = explode(';', trim($arr[2][$i]));
			$rules_arr = array();
			foreach ($rules as $strRule){
				if (!empty($strRule)){
					$rule = explode(":", $strRule);
					$rules_arr[trim($rule[0])] = trim($rule[1]);
				}
			}

			$selectors = explode(',', trim($selector));
			foreach ($selectors as $strSel){
				$result[$strSel] = $rules_arr;
			}
		}
		return $result;
	}
	
	function getTextFromStyle($iCSS,$iStyle){
		$key = '.'.$iStyle.':before';
		$val = str_replace(Array('"','\\'),Array('',''),$iCSS[$key]['content']);
		return '&#x'.$val.';';
	}
	
	function ImageTTFCenter($image, $text, $font, $size, $angle = 45){
		$xi = imagesx($image);
		$yi = imagesy($image);
		// First we create our bounding box for the first text
		$box = imagettfbbox($size, $angle, $font, $text);
		$xr = abs(max($box[2], $box[4]));
		$yr = abs(max($box[5], $box[7]));
		// compute centering
		$x = intval(($xi - $xr) / 2);
		$y = intval(($yi + $yr) / 2);
		//echo $x;echo '|';	echo $y;exit;
		return array($x, $y);
	}
	
	function createImg($text,$font,$outputSize,$img = null){
		
		$size = $width = $height = $outputSize;
		$fontSize = $outputSize*0.85;
		$padding = (int)ceil(($outputSize/25));
		
		$im = imagecreatetruecolor($width, $height);
		imagealphablending($im, false);
		$fontC = imagecolorallocate($im, 0, 0, 0);
		
		$bgc = imagecolorallocatealpha($im, 255, 0, 255, 127);
		imagefilledrectangle($im, 0, 0, $width, $height, $bgc);
		imagealphablending($im, true);
		
		//Aggiunta del testo
		list($fontX, $fontY) = ImageTTFCenter($im, $text, $font, $fontSize);
		imagettftext($im, $fontSize, 0, $fontX-2, $fontY+1, $fontC, $font, $text);
	
		imagealphablending($im,false);
		imagesavealpha($im,true);			
		//imagetrim($im, $bgc, $padding);
		//imagecanvas($im, $outputSize, $bgc, $padding);
		imagepng($im,$img);
		imagedestroy($im);
	}
	
	$img = $_GET['img'] ?: 'camera-iris';
	$color = $_GET['color'] ?: 'black';
	
	if(!file_exists("favicon/{$img}.png")){
		$css = parseCSS('common/materialdesignicons.min.css');	
		createImg(getTextFromStyle($css,$img),'fonts/materialdesignicons-webfont.ttf',16,"favicon/{$img}.png");
	}
	
	//var_dump($css);
	//echo $img.' '.getTextFromStyle($css,$img).'<br>' ;
	
	header('Content-Disposition: Attachment;filename='.$img.'.png'); 
	header('Content-type: image/png'); 
	
	readfile("favicon/{$img}.png");
	
	//createImg(getTextFromStyle($css,$img),'fonts/materialdesignicons-webfont.ttf',16);
	//createImg('&#x065','fonts/OpenSans-Bold.ttf',200);

?>