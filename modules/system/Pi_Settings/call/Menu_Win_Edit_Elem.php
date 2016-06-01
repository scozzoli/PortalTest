<?php
	$menu_list = $sysConfig->loadMenu();
	$mod_list = $sysConfig->loadMod();
	$menu = $pr->post('menu');
	$list = $menu_list[$menu][$pr->post('voice')]['list'];
	//$ini = parse_ini_file($pr->getRootPath('settings/menu/'.$pr->post('menu').'.ini'),true);
	//$list = $ini[$pr->post('voice')]['list'];
	$buttonList= '';
	//foreach($ini[$pr->post('voice')]['list'] as $k => $v){
	//	$buttonList .= '<button class="red" onclick="selectPos('.$k.')" '.($k == $pr->post('pos') ? 'disabled' : '').'>'.($k+1).'</button>';
	//}
	
	foreach($list as $k => $v){
		$buttonList .= '<button class="j-button '.($k == $pr->post('pos') ? 'red' : '').'" data-pi-pos="'.($k+1).'" '.($k == $pr->post('pos') ? 'disabled' : '').'> 
			<i class="mdi l3 '.(isset($mod_list[$v]) ? $mod_list[$v]['icon'] : 'mdi-alert-box').'" />  ('.($k+1).')</button>';
	}
	$out ='<div class="red focus">
			<i18n>menu:win:infoMove</i18n>
		</div><br>
		<div id="move">
		<table class="form separate">
			<tr>
				<th> Posiszione attuale <i class="red" style="font-size:16px;">'.($pr->post('pos') + 1).'</i> <i18n>menu:iface:newPos</i18n> : </th>
				<td><input type="text" class="ale" name="pos_to" value="'.($pr->post('pos') + 1).'" id="focusme" style="width:60px; text-align:center;"></td>
			</tr>
		</table>
		
		<input type="hidden" name="pos_from" value="'.$pr->post('pos').'">
		<input type="hidden" name="menu" value="'.$pr->post('menu').'">
		<input type="hidden" name="voice" value="'.$pr->post('voice').'">
		<input type="hidden" name="Q" value="Menu_Move_Elem">
		<br><div id="buttonListConainer">'.$buttonList.'</div>
	</div>';
	
	$footer = '<button class="red" onclick="pi.win.close();"> <i18n>cancel</i18n> </button>
	<button class="red" onclick="pi.requestOnModal(\'move\',\'Menu_Del_Elem\');"> <i18n>menu:iface:delModule</i18n></button>
	<button class="green" onclick="pi.requestOnModal(\'move\')"> <i18n>save</i18n> </button>';
	
	$js='$("#buttonListConainer").find(".j-button").on("click",function(){
		$("#buttonListConainer").find(".j-button").attr("disabled",false);
		var pos = this.getAttribute("data-pi-pos");
		$("#move").find("#focusme").val(pos);
		this.setAttribute("disabled",true);
	});';
	$pr->addWindow(500,0,'<i18n>menu:win:moveTitle</i18n>',$out,$footer)->addScript("$('#focusme').select();")->addScript($js)->response();
	
?>