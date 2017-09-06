<?php
	/*
		IMPORTANTE : Questa lista NON si aggiorna da sola, ma bisogna copiare la lista dele icone dalla preview.html che è presente in boundle 
		quando si scaricano le MDI.
		
		/style/common/preview.html
		
		Variabili che devono essere passate:
		
		$imgSelect ==> immagine selezionata
		$callSelector ==> Chiamata da fare su OK
		$callHiddenVars ==> array { val => valore } da passare alla chiamata successiva
		
		ps: nei moduli common lo scope è quello della classe Response QUINDI NON esiste $pr, ma $this (e le uniche variabili a cui ha accesso sono quelle passate come parametri)
	*/ 
	
	function parseCSS($filePath){
		$file = file_get_contents($filePath);
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
		return $css;
	}

	$css = parseCSS($this->getRootPath('style/common/materialdesignicons.min.css'));
	$iconlist=[];
	foreach($css as $k => $v){
		if($k == '.mdi:before') continue;
		if($k == '.mdi-blank:before') continue;
		if(strpos($k,'mdi-18px:before')) continue;
		if(strpos($k,'mdi-24px:before')) continue;
		if(strpos($k,'mdi-36px:before')) continue;
		if(strpos($k,'mdi-48px:before')) continue;
		if(strpos($k,':before') !== false){
			$iconlist[] = substr(substr($k,5),0,-7);
		}
	}

	$inputList = '';
	foreach($callHiddenVars ?: [] as $k => $v){
		$inputList .= '<input type="hidden" name="'.$k.'" value = "'.$v.'">';
	}
	
	$out = '<div id="Set_Icon">
			<input type="hidden" name="Q" value = "'.$callSelector.'">
			'.$inputList.'
			<input type="hidden" name="Ico" value = "'.$imgSelect.'" id="anchor_img_to_save">
			</div>
			<div class="focus green">
				<table class="form">
					<tr>
						<th>Filtra per : </th>
						<td><input type="text" class="full" id="search_icon_field"></td>
						<td><button class="green icon" id="search_icon_button"><i class="mdi mdi-magnify"></button></td>
					</tr>
				</table>
			</div>
			<div id="icon_list" style="height:350px; overflow-y:auto;">';
	$firstLetter = '';
	foreach($iconlist as $k => $v){
		if($v[0] != $firstLetter){
			$firstLetter = $v[0];
			$out.='<div class="focus green j-letter" style="float:left; width: 600px; text-align:right; border-radius: 0 30px 30px 0; padding-right: 20px;"> 
				<i>Icone dalla lettera <b class="green" style="font-size:24px;">'.strtoupper($firstLetter).'</b> </i>
				</div>';
		}
		$out .= '<span class="j-icon" style="text-align:center; height:80px; width:128px; float:left; display:block; cursor:pointer;" data-pi-icon="mdi-'.$v.'"> 
			<i class="mdi l4 mdi-'.$v.' '.('mdi-'.$v == $imgSelect ? 'green' : '').'" style="padding:5px;" title="'.$v.'"/><br>
			<span style="overflow:hidden;">'.$v.'</span>
			</span>';
	}
	$out.='</div>';

	if($callSelector){
		$footer = '<button class="red" onclick="pi.win.close();">Annulla</button>
				<button class="green" onclick="pi.requestOnModal(\'Set_Icon\')">Salva</button>';
	}else{
		$footer = null;
	}

			
	$js = "function MDISelectorIcons(){
		var root = $('#icon_list');
		var list = root.find('.j-icon');
		var val = $('#search_icon_field').val();
		for (var i= 0; i<list.length; i++){
			if(val){
				if(list[i].getAttribute('data-pi-icon').indexOf(val) > -1){
					list[i].style.display = 'block';
				}else{
					list[i].style.display = 'none';
				}
			}else{
				list[i].style.display = 'block';
			}
		}
		if(val){
			root.find('.j-letter').hide();
		}else{
			root.find('.j-letter').show();
		}
	}
	function MDIReplaceIcon(obj){
		var elem = $('#anchor_img_to_save');
		var root = $('#icon_list');
		if(elem.val()){
			root.find('.'+elem.val()).removeClass('green');
		}
		elem.val($(obj.target.parentNode).attr('data-pi-icon'));
		root.find('.'+elem.val()).addClass('green');
	}

	$('#search_icon_field').on('click',MDISelectorIcons);
	$('#icon_list').on('click', '.j-icon',  MDIReplaceIcon);
	
	$('#search_icon_field').focus(); shortcut('enter', MDISelectorIcons,{'propagate':false, target:'search_icon_field'} );";
	$this->addWindow(660,0,'Lista Immagini',$out,$footer)->addScript($js)->response();
?>