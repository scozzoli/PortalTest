<?php
	//$tb_test='';
	//foreach($grp_list as $k => $v){
	//	$tb_test .= '<th style="text-align:center;" title="'.$v['nome'].' - '.$v['des'].'"> '.$k.'</th>';
	//}
	
	$usr_list = $sysConfig->loadUsr();
	$grp_list = $sysConfig->loadGrp();
	$db_list = $sysConfig->loadDB();
	$lang_list = getLangList($pr);
	
	$countGroup = count($grp_list);
	$filter = $pr->post('cerca','');
	
	$out='<div id="usrContainer">
		<table class="lite blue">
		<tr>
			<th style="width:36px;">  </th>
			<th> <i18n>usr:lbl:user</i18n> </th>
			<th> <i18n>usr:lbl:theme</i18n> </th>
			<th> <i18n>usr:lbl:menu</i18n> </th>
			<th> <i18n>usr:lbl:db</i18n> </th>
			<th> <i18n>usr:lbl:http</i18n> </th>
			<th> <i18n>usr:lbl:ssl</i18n> </th>
			<th> <i18n>usr:lbl:pwd</i18n></th>
			<th> <i18n>usr:lbl:flags</i18n></th>
			<th title="Valoro estesi"><i18n>usr:lbl:extension</i18n></th>
			<th style="text-align:center;"> <i18n>usr:lbl:grant</i18n></th>
		</tr>';
	
	$idx = 0;
	foreach($usr_list as $k => $v){
		if($filter != ''){
			if(!(strpos($k,$filter)!==false || strpos($v['nome'],$filter)!==false)){ continue; }
		}
		
		if($k == 'root' || $k == 'guest'){
			$mdiAccount = '<i class="mdi mdi-account-key" style="font-size:30px"></i>';
		}else{
			$mdiAccount = '<i class="mdi mdi-account" style="font-size:30px"></i>';
		}
		
		$countAtt = $countDis = 0;
		if(count($v['grp']) > 0) {
			foreach($v['grp'] as $kg => $kv){
				if($kv == 0){
					$countDis++;
				}else{
					$countAtt++;
				}
			}
		}
		if($v['grpdef']==1){
			$grpDef = '<td class="green" style="text-align:center;"><i class="mdi mdi-check" style="color:#080;"></i> Concessi (<b style="color:#800;">'.$countDis.'</b> negati su '.$countGroup.')</td>';
		}else{
			$grpDef = '<td class="red" style="text-align:center;" ><i class="mdi mdi-close" style="color:#800;"></i> Negati (<b style="color:#080;">'.$countAtt.'</b> Concessi su '.$countGroup.')</td>';
		}
		
		
		
		$out .='<tr style="cursor:pointer;" onclick="pi.request(\'usr_'.$idx.'\')">
			<th>
				<div id="usr_'.$idx.'">'.$mdiAccount.'
					<input type="hidden" name="Q" value="Usr/Win_Load_Dett">
					<input type="hidden" name="ID" value="'.$k.'">
				</div>
			</th>
			<td>
				<b>'.$k.'</b><br>
				<i>'.$v['nome'].'</i>
			</td>
			<td>'.$v['theme'].'<br> <i>'.$v['style'].'</i></td>
			<td>'.$v['menu'].'</td>
			<td>'.$db_list[$v['db']]['des'].'</td>
			<td><b class="green '.($v['http']==1 ? '' : 'disabled').'"><i18n>usr:lbl:http</i18n></b></td>
			<td><b class="green '.($v['https']==1 ? '' : 'disabled').'"><i18n>usr:lbl:ssl</i18n></b></td>
			<td><b class="green '.($v['use_pwd']==1 ? '' : 'disabled').'"><i18n>usr:lbl:pwd</i18n></b></td>
			<td>
				<img src="style/img/'.$lang_list['langs'][$v['lang']]['icon'].'" title="'.$lang_list['langs'][$v['lang']]['des'].'">
				<i class="mdi mdi-settings blue '.($v['acc_dev'] == 1 ? '' : 'disabled').'" title="strumenti di sviluppo"></i>
				<i class="mdi mdi-alert-circle blue '.($v['acc_err'] == 1 ? '' : 'disabled').'" title="strumenti di errore" ></i>
				<i class="mdi mdi-server-off blue '.($v['acc_dis'] == 1 ? '' : 'disabled').'" title="strumenti di disabilitati"></i>
				<i class="mdi mdi-key blue '.($v['acc_priv'] == 1 ? '' : 'disabled').'" title="strumenti di privati"></i>
			</td>
			<td><b class=" '.(count($v['extension'])==0? 'disabled' : 'focus').'">'.count($v['extension']).'</b></td>
			'.$grpDef.'
		</tr>';
		$idx++;
	}
	
	/*
	<td><b style="color:'.($v['http']==1 ? '#080' : '#aaa').';">http</b></td>
			<td><b style="color:'.($v['https']==1 ? '#080' : '#aaa').';">SSL</b></td>
			<td><b style="color:'.($v['use_pwd']==1 ? '#080' : '#aaa').';">Password</b></td>
	*/
	
	$out.='</table></div>';
	
	$pr->addHtml('container-user',$out)->addScript('$("#input_cerca_utente").focus(); $("#input_cerca_utente").select(); shortcut("enter", onEnterUsr,{"propagate":false, target:"input_cerca_utente"} );')->response();
?>