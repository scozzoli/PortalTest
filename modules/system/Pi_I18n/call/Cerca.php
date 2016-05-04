<?php
	$modList = $sysConfig->loadMod();
	
	$filter = strtolower($pr->post('cerca',''));
	$out = '';
	$count = 0;
	foreach($modList as $k => $v){
		
		if($filter != ''){
			if(!(strpos(strtolower($k),$filter)!==false || strpos(strtolower($sysConfig->i18nGet($v['nome'])),$filter)!==false)){ continue; }
		}
		$count++;
		
		switch($v['stato']){
			case 'ATT' : $des_stato = 'Attivo'; 			$class='blue'; 		$style='';	break;
			case 'DEV' : $des_stato = 'Sviluppo';  			$class='orange';	$style='';	break;
			case 'PRIV': $des_stato = 'Privato';  			$class='purple';	$style='';	break;
			case 'ERR' : $des_stato = 'Errori Bloccanti'; 	$class='red';		$style='';	break;
			case 'DIS' : $des_stato = 'Disabilitato'; 		$class='';			$style='color:#888;';	break;
		}
		$out .= '<div class="panel" data-pic="collapse:{close:true}">
			<div class="header '.$class.'"><i class="mdi '.$v['icon'].'"></i> ('.$k.') - '.htmlentities($sysConfig->i18nGet($v['nome'])).'</div>';
		
		$dic = $i18n->openDic($pr->getRootPath('modules/'.$v['path'].'/'))->getDic();
		
		$out .= '<div class="focus blue">
		<table class="form" id="general_action_'.$count.'">
			<tr>
				<th><i18n>lblAddKey</i18n></th>
				<td>
					<input type="hidden" name="module" value="'.$k.'">
					<input type="hidden" name="containerId" value="'.$count.'">
					<input type="hidden" name="scope" value="local">
					<input type="text" name="newkey" class="j-todel">
				</td>
				<td><button onclick="pi.request(\'general_action_'.$count.'\',\'AddKey\'); $(\'#general_action_'.$count.'\').find(\'.j-todel\').val(\'\')"><i18n>addKeyButton</i8n></button></td>
				<th><button onclick="pi.chk(\'<i18n>chk:removeAllUnusedKey</i18n>\').request(\'general_action_'.$count.'\',\'RemoveAllUnusedKey\')"><i18n>removeEmptyKeyButton</i8n></button></th>
			</tr>
		</table>
		</div>
		<br>';
			
		$config = $i18n->getConfig();
		$out .= getModuleKeyList($k,$count,$config,$dic);
		
		$out .= '</div>';
		//	
		//	'
		//	<table class="lite fix" data-pic="tablesort">
		//	<tr><th><i18n>lblKeyName</i18n></th>';
        //
		//foreach($config['langs'] as $key => $val){
		//	$out.='<th style="text-align:center;"><img src="./style/img/'.$val['icon'].'"> '.$val['des'].' </th>';
		//}
		//$myIdx = 0;
		//$out.='<th style="text-align:center;" data-sort:"none"><i18n>remove</i18n></th></tr>';
		//foreach($dic as $key => $lang){
		//	$out.='<tr id="row_'.$count.'_'.$myIdx.'">	<td>'.$key.'</td>';
		//	foreach($config['langs'] as $kLang => $val){
		//		if(trim($lang[$kLang]) == ''){
		//			$classLang= 'orange';
		//			$icon = '<i class="mdi mdi-close l2 j-icon '.$classLang.'"></i> <i class="j-prev"></i>';
		//			$align = 'center';
		//		}else{
		//			$classLang= 'blue';
		//			$icon = '<i class="mdi mdi-check l2 j-icon '.$classLang.'"></i> <i class="j-prev">'.htmlentities(substr($lang[$kLang],0,50)).'</i>';
		//			$align = 'left';
		//		}
		//		$out.='<td id="Lang_'.$count.'_'.$myIdx.'_'.$kLang.'" style="text-align:'.$align.'; cursor:pointer;" class="'.$classLang.'" onclick="pi.request(this.id)">
		//			'.$icon.'
		//			<input type="hidden" name="Q" value="WinEditLocal">
		//			<input type="hidden" name="lang" value="'.$kLang.'">
		//			<input type="hidden" name="module" value="'.$k.'">
		//			<input type="hidden" name="key" value="'.$key.'">
		//			<input type="hidden" name="callbackid" value="Lang_'.$count.'_'.$myIdx.'_'.$kLang.'">
		//		</td>';
		//		
		//	}
		//	$out .='
		//	<td class="red" style="text-align:center; cursor:pointer;" onclick="pi.chk(\'<i18n>chk:confirmDelete</i18n>\').request(this.id);" id="Lang_'.$k.'_'.$myIdx.'">
		//		<input type="hidden" name="Q" value="RemoveKey">
		//		<input type="hidden" name="module" value="'.$k.'">
		//		<input type="hidden" name="key" value="'.$key.'">
		//		<input type="hidden" name="scope" value="local">
		//		<input type="hidden" name="removeid" value="row_'.$count.'_'.$myIdx.'">
		//		<i class="mdi mdi-delete l2 red"></i>
		//	</td>
		//	</tr>';
		//	$myIdx++;
		//}
		//$out.= '</table></div>';
		//$out.= '</div>';
	}
	if($count == 1) {
		$out = str_replace('data-pic="collapse:{close:true}"','data-pic="collapse"',$out);
	} 
	$pr->addHtml('container',$out)->response();
?>