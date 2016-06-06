<?php
	$cerca = strtolower($pr->post('cerca'));
	
	$conf = getUsrPref($pr->getUsr());
	
	$list = scandir($pr->getLocalPath('script'));
	
	$out = '<div class="pi-list">';
	$prevGrp = '';
	
	$GroupList = $sysConfig->loadGrp();
	
	$key = 0;
	foreach($list as $k => $v){
		if($v == '.' || $v == '..' || $v == 'deleted') continue;
		
		$qryConfig = json_decode(file_get_contents($pr->getLocalPath("script/{$v}")),true);
		
		$parts = explode('.',$v);
		$grp = $parts[0];
		$name = str_replace('_',' ',$parts[1]);
		
		if((!$qryConfig['enabled'] && !$pr->chkGrp('qry')) || !$pr->chkGrp($grp)) continue;
		
		if($cerca != ''){
			if(!(strpos(strtolower($v),$cerca)!==false || strpos(strtolower($qryConfig['des']),$cerca)!==false)){ continue; }
		}else{
			if($prevGrp != $grp){
				$prevGrp = $grp;
				$out.='</div><div class="panel orange" style="font-size:16px;"><i class="mdi mdi-comment-multiple-outline"> </i> <b>'.$sysConfig->i18nGet($GroupList[$grp]['nome']).'</b> - <i>'.$sysConfig->i18nGet($GroupList[$grp]['des']).'</i></div><div class="pi-list">';
			}
		}
		
		
		$icon = '<i class="mdi l2 '.($qryConfig['icon'] ?: 'mdi-comment-text-outline').' '.($qryConfig['color'] ?: '').'" ></i>';
		
		$disabled = $qryConfig['enabled'] ? '' : ' disabled';
		
		$qryPanel='<div class="pi-mod '.$qryConfig['color'].$disabled.'" onclick="pi.request(this.id)" id="RunQry'.$key.'">
			<input type="hidden" name="Q" value="Win_Qry_Launcher_Int">
			<input type="hidden" name="qry" value="'.$v.'">
			<table class="form">
				<tr>
					<td width="20px;">'.$icon.'</td>
					<td style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:0;"><i class="'.$qryConfig['color'].'" style="font-size:16px;">'.$name.'</i></td>
				</tr>
				<tr>
					<td colspan="2">
						<div style="max-height:30px; height:30px; overflow:hidden; text-overflow:ellipsis;">'.(htmlentities($qryConfig['des']) ?: '<i class="disabled"> <i18n>iface:noDescForQry</i18n> </i>').'</div>
					</td>
				</tr>
			</table>
		</div>';
		
		$out .= $qryPanel;
		$key++;
	}
	
	$out .= '</div>';
	
	$pr->addHtml('containerList',$out)->response();
?>