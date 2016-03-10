<?php
	//$ini = parse_ini_file($pr->getRootPath('settings/menu/'.$pr->post("menu").'.ini'),true);
	$menu_list = $sysConfig->loadMenu();
	$mod_list = $sysConfig->loadMod();
	
	//ksort($ini);
	$menu = $pr->post("menu");
	
	$out = '<div class="panel red" id="Menu_Action_Info">
			<input type="hidden" name="menu" value="'.$menu.'">
			<table class="form">
				<tr>
					<td><button class="red" onclick="pi.request(null,\'Menu_Load_Interface\')"> <i class="mdi mdi-arrow-left"/> Indietro </button></td>
					<th>
						<button class="red" onclick="pi.chk(\'Rimuovere completamente il menu?\').request(\'Menu_Action_Info\',\'Menu_Del_Selected\')"><i class="mdi mdi-delete" /> Rimuvi il menu '.$menu.' </button>
						<button class="red" onclick="pi.request(\'Menu_Action_Info\',\'Menu_Win_Edit_Voice\')"><i class="mdi mdi-server-plus"/> Aggiungi voce al menu </button>
					</th>
				</tr>
			</table>
		</div>
		<table class="lite red"><tr>
				<th>Indice</th>
				<th>Nome Voce</th>
				<th colspan="3">Moduli</th>
			</tr>';
	
	foreach($menu_list[$menu] as $k => $v){
		$mod_ok = $mod_miss = 0;
		$oo = '';
		if(isset($v['list'])){
			for($i=0;$i!= count($v['list']);$i++){
				if(!isset($mod_list[$v['list'][$i]])){
					$mod_miss++;
				}else{
					$mod_ok++;
				}
				$oo.='<tr style=" cursor:pointer;" onclick="pi.request(\'edit_module_'.$k.'_'.$i.'\')">
					<td style="width:30px; text-align:right;">
						<div id="edit_module_'.$k.'_'.$i.'">
							<input type="hidden" name="Q" value="Menu_Win_Edit_Elem">
							<input type="hidden" name="menu" value="'.$menu.'">
							<input type="hidden" name="voice" value="'.$k.'">
							<input type="hidden" name="pos" value="'.$i.'">
							<input type="hidden" name="mod" value="'.$v['list'][$i].'">
							<i class="mdi l2 '.($mod_list[$v['list'][$i]]['icon'] ?: 'red mdi-alert-box').'" />
						</div>
					</td>
					<td> (<b> '.($i + 1).' </b>) '.$v['list'][$i].'</td>
					<td colspan="3">'.$mod_list[$v['list'][$i]]['nome'].' - <i>'.$mod_list[$v['list'][$i]]['des'].'</i> </td>
				</tr>';
				
			}
		}
		$out.='<tr class="red">
			<td style="text-align:center;">
				<div id="Load_Win_Menu_Edit_Voice_'.$k.'">
					<input type="hidden" name="Q" value="Menu_Win_Edit_Voice">
					<input type="hidden" name="menu" value="'.$menu.'">
					<input type="hidden" name="voice" value="'.$k.'">
					<b>'.$k.'</b>
				</div>
			</td>
			<td colspan="2">'.($v['BASE64']!=0 ? base64_decode($v['des']) : $v['des']).'</td>
			<td>
				'.($mod_miss>0 ?'<i class="mdi mdi-alert-circle red" />' : '<i class="mdi mdi-check green" />').'
				[ <b class="focus" >Totali : </b> '.($mod_ok + $mod_miss).' ]
				[ <b class="green" >Ok : </b> '.$mod_ok.' ]
				[ <b class="red">Mancanti : </b> '.$mod_miss.' ]
			</td>
			<td style="text-align:right;">
				<button class="red" onclick="pi.request(\'Load_Win_Menu_Edit_Voice_'.$k.'\');">Modifica voce</button>
				<button class="red" onclick="pi.request(\'Add_Voice_Menu_Int_'.$k.'\')"><i class="mdi mdi-plus-box"/> Aggiungi modulo</button>
				<span id="Add_Voice_Menu_Int_'.$k.'">
					<input type="hidden" name="Q" value="Menu_Win_Add_Elem">
					<input type="hidden" name="menu" value="'.$menu.'">
					<input type="hidden" name="voice" value="'.$k.'">
				</span>
			</td>
		</tr>'.$oo;
		
		//<button class="del" onclick="pi.request(\'Del_Voice_'.$k.'\',\'Eliminare la voce del menu?\');"><div>Elimina voce</div></button>
	}
	$out.='</table><br><div id="menu_container"></div>';
	$pr->addHtml('container',$out)->response();
?>