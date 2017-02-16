<?php
	$db_list = $sysConfig->loadDB();
	$grp_list = $sysConfig->loadGrp();
	$usr_list = $sysConfig->loadUsr();
	$menu_list = $sysConfig->loadMenu();
	$ext_list = $sysConfig->loadUsrExt() ?: [];
	
	$lang_list = getLangList($pr);
	
	$usr = $pr->post("ID",'');//$_POST["ID"];
	if($usr == ''){
		$usr = false;
		$usr_list[$usr] = array(
			'nome' => 'Nuovo Utente',
			'pwd' => 'd41d8cd98f00b204e9800998ecf8427e', // l'MD5 della pasword vuota
			'email' => '',
			'use_pwd' => '0',
			'menu' => '',
			'showsidemenu' => '1',
			'db' => '',
			'http' => '1',
			'https' => '0',
			'theme' => 'material',
			'style' => '',
			'grpdef' => '0',
			'acc_dev' => '0',
			'acc_err' => '0',
			'acc_dis' => '0',
			'acc_priv' => '0',
			'lang' => $lang_List['defaultLang'],
			'extension' => array()
		);
	}
	
	// Creo la dropdown del menù
	
	$ddMenu='<select name="menu">';
	foreach($menu_list as $k => $v){
		$ddMenu .= '<option value="'.$k.'">'.$k.'</option>';
	}
	$ddMenu.='</select>';
	
	// Creo la dropdown degli stili
	$themeDir = scandir($pr->getRootPath('style/themes'));
	$ddTheme='<select name="themeselector">';
	foreach($themeDir as $k => $v){
		if(is_dir($pr->getRootPath("style/themes/{$v}")) && ($v != '.') && ($v != '..')){
			$ddTheme.= '<optgroup label="'.$v.'">';
			$ddTheme.= '<option value="'.$v.':">'.$v.'</option>';
			$styleDir = scandir($pr->getRootPath("style/themes/{$v}"));
			foreach($styleDir as $ks => $vs){
				if((strpos($vs,'style.') !== false) && strpos($vs,'.less')){
					$styleName = substr($vs,6,-5);
					$ddTheme.= '<option value="'.$v.':'.$styleName.'">'.$v.' ('.$styleName.') </option>';
				}
			}
			$ddTheme.= '</optgroup>';
		}
	}
	$ddTheme.='</select>';
	
	// Creo la dropdown della base dati
	
	$ddDB = '<select name="db">';
	foreach($db_list as $k => $v){
		if($v['hide']==0){
			$ddDB .='<option value="'.$k.'">'.$v['des'].'</option>';
		}
	}
	$ddDB .= '</select>';
	
	// creo la dropdown delle lingue
	$ddLang ='<select name="lang">';
	foreach($lang_list['langs'] as $k => $v){
		$ddLang .='<option value="'.$k.'">'.$k.' - '.$v['des'].'</option>';
	}
	$ddLang .='</select>';
	
	
	$tb_grp='<table class="lite '.($usr_list[$usr]['grpdef']==1 ? 'green' : 'red').'" id="usr_grant_table">
			<tr>	
				<th><i18n>usr:win:groupCode</i18n></th>
				<th><i18n>usr:win:group</i18n></th>
				<th><i18n>usr:win:description</i18n></th>
				<th style="text-align:center;" title="Valore di Delault">Def</th>
				<th style="text-align:center;" title="Nessun Permesso"> <i18n>no</i18n></th>
				<th style="text-align:center;" title="Permesso Standard"><i18n>yes</i18n></th>
			</tr>';
	foreach($grp_list as $kg => $vg){
		$lev = isset($usr_list[$usr]['grp'][$kg]) ? $usr_list[$usr]['grp'][$kg] : -1;
		$class = isset($usr_list[$usr]['grp'][$kg]) ? ($usr_list[$usr]['grp'][$kg]==1 ? 'green' : 'red') : '';
		$tb_grp.='<tr class="'.$class.'">
			<td>
				'.$kg.'	
			</td>
			<td>'.$sysConfig->i18nGet($vg['nome']).'</td>
			<td>'.$sysConfig->i18nGet($vg['des']).'</td>
			<td style="text-align:center;">
				<input type="radio" name="Grp-dett-'.$kg.'" '.($lev==-1 ? 'checked' :'').' value="-1" onclick="this.parentNode.parentNode.setAttribute(\'class\',\'\')">
			</td>
			<td style="text-align:center;" class="red">
				<input type="radio" name="Grp-dett-'.$kg.'" '.($lev==0 ? 'checked' :'').' value="0" onclick="this.parentNode.parentNode.setAttribute(\'class\',\'red\')">
			</td>
			<td style="text-align:center;" class="green">
				<input type="radio" name="Grp-dett-'.$kg.'" '.($lev==1 ? 'checked' :'').' value="1" onclick="this.parentNode.parentNode.setAttribute(\'class\',\'green\')">
			</td>
		</tr>';
	}
	
	$fillVars = $usr_list[$usr];
	
	$extList='';
	$extListIdx = 0;
	
	$userExtList = $usr_list[$usr]['extension'] ?: [];
	$fixedExt = [];
	
	foreach($ext_list as $k => $v ){
		$fillVars['ext_key_'.$extListIdx] = $k;
		$fillVars['ext_val_'.$extListIdx] = $userExtList[$k] ?: '';
		$fixedExt[$extListIdx] = $k;
		$extListIdx++;
	}
	
	foreach($userExtList as $k => $v){
		if(isset($ext_list[$k])){ continue; }
		$fillVars['ext_key_'.$extListIdx] = $k;
		$fillVars['ext_val_'.$extListIdx] = $v;
		$extListIdx++;
	}
	for($i = 0; $i <= $extListIdx; $i++){
		if(isset($fixedExt[$i])){ 
//			$extList.='<tr>
//					<td style="text-align: right;">
//						<b class="purple">'.$fixedExt[$i].' :</b> 
//						<input type="hidden" name="ext_key_'.$i.'">
//					</td>
//					<td>
//						<i> '.htmlentities($sysConfig->i18nGet($ext_list[$fixedExt[$i]])).'</i><br>
//						<input type="text" class="full" name="ext_val_'.$i.'" placeholder="Valore">
//					</td>
//				</tr>';
			$extList.='<tr>
					<td colspan="2">
						<b class="purple">'.$fixedExt[$i].' : </b> <i> '.htmlentities($sysConfig->i18nGet($ext_list[$fixedExt[$i]])).'</i><br>
						<input type="hidden" name="ext_key_'.$i.'">
						<input type="text" class="full" name="ext_val_'.$i.'" placeholder="Valore">
					</td>
				</tr>';
		}else{
			$extList .= '<tr>
				<td style="text-align: right;">
					<input type="text" class="small" name="ext_key_'.$i.'" placeholder="Chiave"> 
				</td>
				<td width="100%">
					<input type="text" class="full" name="ext_val_'.$i.'" placeholder="Valore">
				</td>
			</tr>';
		}
		
	}
	
	$tb_grp.='</table>';
	$out ='	<div id="user_del"><input type="hidden" name="Q" value="Usr/Del"><input type="hidden" name="UID" value="'.$usr.'" ></div>
	<div id="user_mod" style="text-align:left;">
		<div data-pi-component="tabstripe">
			<div data-pi-i18n="usr:win:detail">	
				<div class="focus blue"> <i18n>usr:win:info;'.$usr_list[$usr]['nome'].'</i18n></div>
				<table class="form separate">
					<tr>
						<th style="text-align:right" > <i18n>usr:win:lblUid</i18n></th>
						<td>
							<input type="text" name="New-Uid" class="ale" value="'.$usr.'" id="UID">
							<input type="hidden" name="Old-Uid" value="'.$usr.'">
							<input type="hidden" name="Q" value="Usr/Mod">
						</td>
					</tr>
					<tr>
						<th style="text-align:right" > <i18n>usr:win:lblName</i18n></th>
						<td> <input type="text" name="nome" style="width:300px;"></td>
					</tr>
					<tr>
						<th style="text-align:right" > <i18n>usr:win:lblEmail</i18n></th>
						<td> <input type="text" name="email" value="" style="width:300px;"></td>
					</tr>
					<tr>
						<th style="text-align:right" > <i18n>usr:win:lblUsePwd</i18n></th>
						<td> <input type="checkbox" name="use_pwd" > </td>
					</tr>
					<tr>
						<th style="text-align:right" > <i18n>usr:win:lblPwd</i18n></th>
						<td> <input type="password" name="pwd" > md5 [ '.$usr_list[$usr]['pwd'].' ]</td>
					</tr>
					<tr>
						<th style="text-align:right" > <i18n>usr:win:lblLang</i18n></th>
						<td> '.$ddLang.'</td>
					</tr>
					<tr>
						<th style="text-align:right" > <i18n>usr:win:lblStyle</i18n></th>
						<td> '.$ddTheme.'</td>
					</tr>
					<tr>
						<th style="text-align:right" > <i18n>usr:win:lblSideMenu</i18n></th>
						<td> <input type="checkbox" name="showsidemenu" > </td>
					</tr>
					<tr>
						<th style="text-align:right" > <i18n>usr:win:lblDBDef</i18n></th>
						<td> '.$ddDB.'</td>
					</tr>
					<tr>
						<th style="text-align:right" > <i18n>usr:win:lblMenu</i18n></th>
						<td> '.$ddMenu.'</td>
					</tr>
					<tr>
						<th style="text-align:right" > <i18n>usr:win:lblProtocol</i18n> </th>
						<td>
							<table>
								<tr>
									<td><input type="checkbox" name="http" ></td>
									<td><i18n>usr:win:lblHttpDes</i18n></td>
								</tr>
								<tr>
									<td><input type="checkbox" name="https"></td>
									<td><i18n>usr:win:lblHttpsDes</i18n></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</div>
			<div data-pi-i18n="usr:win:grants">
				<div class="focus green">
					<i18n>usr:win:infoGrants</i18n>
				</div>
				<table class="form separate">
					<tr>
						<td style="border-bottom:1px #888 solid;"><input type="checkbox" name="grpdef" onClick="if(this.checked){$(\'#usr_grant_table\').attr(\'class\',\'green lite\');}else{$(\'#usr_grant_table\').attr(\'class\',\'red lite\');}"></td>
						<td colspan="3" style="border-bottom:1px #888 solid;"><i18n>usr:win:lblgrpdef</i18n></td>
					</tr>
					<tr>
						<td><input type="checkbox" name="acc_dev" ></td>
						<td><i18n>usr:win:lblDevModules</i18n> </td>
						<td><input type="checkbox" name="acc_err" ></td>
						<td><i18n>usr:win:lblErrModules</i18n></td>
					</tr>
					<tr>
						<td><input type="checkbox" name="acc_dis"></td>
						<td><i18n>usr:win:lblDisModules</i18n></td>
						<td><input type="checkbox" name="acc_priv"></td>
						<td><i18n>usr:win:lblPrivModules</i18n></td>
					</tr>
				</table>
				<input type="hidden" name="Grp-key-list" value="'.implode(':',array_keys($grp_list)).'">'.$tb_grp.'
			</div>
			<div data-pi-i18n="usr:win:extension">
				<div class="focus purple">
					<table class="form">
						<tr>
							<td>
								<i18n>usr:win:infoExtension</i18n>
							</td>
							<th>
								<button class="purple" id="addExtensionOnClick"><i class="mdi mdi-playlist-plus"></i> <i18n>add</i18n> </button>
								<input type="hidden" id="ExtenzionCounter" value="'.$extListIdx.'">
							</th>
						</tr>
					</table>
				</div>
				<table class="form separate" id="ExtensionTable">
					'.$extList.'
				</table>
			</div>
		</div>
	</div>';
	$footer='<button class="red" onclick="pi.win.close()"><i18n>cancel</i18n></button>
			<button class="red" onclick="pi.chk(\'<i18n>usr:chk:deleteUser;'.$usr.'</i18n>\').requestOnModal(\'user_del\')"><i18n>usr:win:btnDelete</i18n></button>
			<button class="green" onclick="pi.requestOnModal(\'user_mod\')"> <i18n>save</i18n> </button>';
	
	$fillVars['themeselector'] = $usr_list[$usr]['theme'].':'.$usr_list[$usr]['style'];
	unset($fillVars['pwd']);
	
	$js = "$('#addExtensionOnClick').click(function(e){
		var idx = $('#ExtenzionCounter').val() * 1; 
		
		var htm = '<td style=\"text-align: right;\"><input type=\"text\" class=\"small\" name=\"ext_key_'+idx+'\" placeholder=\"Chiave\"></td>';
			htm += '<td style=\"text-align: left;\"><input type=\"text\" class=\"full\" name=\"ext_val_'+idx+'\" placeholder=\"Valore\"></td>';
		
		$('#ExtensionTable tr:last').after('<tr>'+htm+'</tr>');
		$(window).resize();
		$('#ExtenzionCounter').val(idx + 1);
	});
	$('#UID').focus();";
	
	$pr->addWindow(600,0,'Modifica utente',$out,$footer)->addFill('user_mod',$fillVars)->addScript($js)->response();
?>