<?php
	$js = '$(document).ready(function(){$("#UID").focus();});';
	$sd->includeScript($js);
	
	//if(!isset($_SESSION[MSID]['usr'])){
	if($_SESSION[MSID]['usr'] ?: 'guest' == 'guest'){
		$interface = '<DIV class="panel blue">
			<ul>
				<li> Inserire il nome del profilo da caricare </li>
				<li> Ne caso non si possieda un profilo contattare il CED</li>
			</ul>
		</DIV><br>
		
		<div style="position:relative; margin-left:50%; padding:0; text-align:center;"  id="login">
			<input type="hidden" name="Q" value="LogIn">
			<div class="panel" style="width : 340px; margin-left:-180px;">
				<div class="header" style="font-size : 16px; margin-bottom: 60px;">
					<br>
					<b style="font-size : 22px;">Portal 1</b><br>
					<span style="font-size : 12px;">Login utente</apan>
					<br>
					
					<div class="badge xlarge" style="width:190px;"><i class="mdi mdi-account"></i></div>
				</div>
				<input type="text" class="std" name="UID" id="UID" style="width:230px" placeholder="Nome Utente"><br><br>
				<button class="confirm blu" onclick="pi.request(\'login\')">Entra</button>
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
			Dettagli Utente:<br><ul>
			<li>Cambia nome utente</li>
			<li>Cambia password</li>
			</ul>
		</DIV>
		<div class="panel" id="data">
			<div class="header"> Configurazione utente </div>
			<table class="form">
				<tr>
					<th>Utente</th>
					<td>
						<input type="text" disabled name="UID" value="'.$_SESSION[MSID]['usr'].'">
					</td>
					<td style="color: #888;"> (Solo l\'amministratore di sistema pu&oacute; cambiarlo)</td>
				</tr>
				<tr>
					<th>Nome Utente</th>
					<td colspan="2">
						<input type="text" class="double" name="nome" value="'.$_SESSION[MSID]['config']['nome'].'" >
					</td>
				</tr>
				<tr>
					<th>Email</th>
					<td colspan="2">
						<input type="text" class="double" name="email" value="'.$_SESSION[MSID]['config']['email'].'" >
					</td>
				</tr>
				<tr>
					<th align="right">Base Dati</th>
					<td>
						<input type="text" disabled value="'.$_SESSION[MSID]['db'][$_SESSION[MSID]['config']['db']]['des'].'">
					</td>
					<td style="color: #888;"> (Non tutti gli strumenti gestiscono il cambio di base dati)</td>
				</tr>
				<tr>
					<th align="right">Stile</th>
					<td colspan="2">
						'.$ddTheme.'
					</td>
				</tr>
				<tr>
					<th align="right">Visualizza il menu laterale</th>
					<td>
						<input type="checkbox" name="showsidemenu" '.($_SESSION[MSID]['config']['showsidemenu']==1 ? 'checked' : '').'>
					</td>
					<td style="color: #888;"></td>
				</tr>
			</table>
			<div class="footer">
				<button onclick="pi.request(\'data\',\'ChangePassword\')" '.($_SESSION[MSID]['config']['use_pwd']==0 ? 'disabled' : '').'><i class="mdi mdi-key-change"></i> Cambia Password</button>
				<button onclick="pi.request(\'data\',\'Save\')"><i class="mdi mdi-content-save"> </i>Salva modifiche</button>
			</div>
		</div>';
	}
?>
