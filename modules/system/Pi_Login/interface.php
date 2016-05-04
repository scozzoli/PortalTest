<?php
	$js = '$(document).ready(function(){$("#UID").focus();});';
	$sd->includeScript($js);
	
	//if(!isset($_SESSION[MSID]['usr'])){
	if(($_SESSION[MSID]['usr'] ?: 'guest') == 'guest'){
		$interface = '<DIV class="panel blue">
			<i18n>iface:infoNoLogin</i18n>
		</DIV><br>
		
		<div style="position:relative; margin-left:50%; padding:0; text-align:center;"  id="login">
			<input type="hidden" name="Q" value="LogIn">
			<div class="panel" style="width : 340px; margin-left:-180px;">
				<div class="header" style="font-size : 16px; margin-bottom: 60px;">
					<br>
					<b style="font-size : 22px;">Portal 1</b><br>
					<span style="font-size : 12px;"><i18n>iface:lblLogin</i18n>Login utente</apan>
					<br>
					
					<div class="badge xlarge" style="width:190px;"><i class="mdi mdi-account"></i></div>
				</div>
				<input type="text" class="std" name="UID" id="UID" style="width:230px" placeholder="Nome Utente"><br><br>
				<button class="confirm blu" onclick="pi.request(\'login\')"><i18n>login</i18n></button>
			</div>
		</div>';
	}else{
		//$userlist = parse_ini_file('./settings/users.ini',true);
		$dblist = parse_ini_file('./settings/db.ini',true);
		
		// Creo la dropdown degli stili
		$themeDir = scandir('style/themes');
		$currentStyle = $_SESSION[MSID]['config']["theme"].':'.$_SESSION[MSID]['config']["style"];
		$ddTheme='<select name="themeselector">';
		foreach($themeDir as $k => $v){
			if(is_dir('style/themes/'.$v) && ($v != '.') && ($v != '..')){
				$chk = ($v.':') == $currentStyle ? 'selected' : '';
				$ddTheme.= '<optgroup label="'.$v.'">';
				$ddTheme.= '<option value="'.$v.':" '.$chk.'>'.$v.'</option>';
				$styleDir = scandir('style/themes/'.$v);
				foreach($styleDir as $ks => $vs){
					if((strpos($vs,'style.') !== false) && strpos($vs,'.less')){
						$styleName = substr($vs,6,-5) ?: '';
						$chk = ($v.':'.$styleName) == $currentStyle ? 'selected' : '';
						$ddTheme.= '<option value="'.$v.':'.$styleName.'" '.$chk.'>'.$v.' ('.$styleName.') </option>';
					}
				}
				$ddTheme.= '</optgroup>';
			}
		}
		$ddTheme.='</select>';
		
		//$list_style = scandir('./style');
		//$style_select= '<select class="std" name="style">';
		//for($i=0;$i!=count($list_style);$i++){
		//	if(is_dir('./style/'.$list_style[$i])){
		//		if(($list_style[$i][0] == '.')){continue;}
		//		$style_select.='<option value="'.$list_style[$i].'" '.($list_style[$i] == $_SESSION[MSID]['css'] ? 'selected' : '').'>'.$list_style[$i].'</option>';
		//	}
		//}
		//$style_select .= '</select>';
				
		//$db_select = '<select class="std" name="db">';
		//foreach($dblist as $k => $v){
		//	if($v['hide']==1){continue;}
		//	$db_select .='<option value="'.$k.'" '.($_SESSION[MSID]['config']['db']==$k ? 'selected':'').'>'.$v['des'].'</option>';
		//}
		//$db_select .= '</select>';
		$interface='<DIV class="panel blue">
			<i18n>iface:infoLogged</i18n>
		</DIV>
		<div class="panel" id="data">
			<div class="header"> <i18n>iface:lblConfUsr</i18n> </div>
			<table class="form">
				<tr>
					<th><i18n>lbl:usrId</i18n></th>
					<td>
						<input type="text" disabled name="UID" value="'.$_SESSION[MSID]['usr'].'">
					</td>
					<td style="color: #888;"> <i18n>iface:onlyAdmin</i18n></td>
				</tr>
				<tr>
					<th><i18n>lbl:usrName</i18n></th>
					<td colspan="2">
						<input type="text" class="double" name="nome" value="'.$_SESSION[MSID]['config']['nome'].'" >
					</td>
				</tr>
				<tr>
					<th><i18n>lbl:email</i18n></th>
					<td colspan="2">
						<input type="text" class="double" name="email" value="'.$_SESSION[MSID]['config']['email'].'" >
					</td>
				</tr>
				<tr>
					<th align="right"><i18n>lbl:DB</i18n></th>
					<td>
						<input type="text" disabled value="'.$_SESSION[MSID]['db'][$_SESSION[MSID]['config']['db']]['des'].'">
					</td>
					<td style="color: #888;"> <i18n>iface:infoDB</i18n> </td>
				</tr>
				<tr>
					<th align="right"><i18n>lbl:style</i18n></th>
					<td colspan="2">
						'.$ddTheme.'
					</td>
				</tr>
				<tr>
					<th align="right"><i18n>lbl:sideMenu</i18n></th>
					<td>
						<input type="checkbox" name="showsidemenu" '.($_SESSION[MSID]['config']['showsidemenu']==1 ? 'checked' : '').'>
					</td>
					<td style="color: #888;"></td>
				</tr>
			</table>
			<div class="footer">
				<button onclick="pi.request(\'data\',\'ChangePassword\')" '.($_SESSION[MSID]['config']['use_pwd']==0 ? 'disabled' : '').'><i class="mdi mdi-key-change"></i> <i18n>btn:changePwd</i18n></button>
				<button onclick="pi.request(\'data\',\'Save\')"><i class="mdi mdi-content-save"> </i> <i18n>btn:saveMod</i18n></button>
			</div>
		</div>';
	}
?>
