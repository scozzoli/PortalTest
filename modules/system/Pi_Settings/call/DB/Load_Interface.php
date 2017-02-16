<?php
	$db_list = $sysConfig->loadDB();
	$usr_list = $sysConfig->loadUsr();
	
	$filter = strtolower($pr->post('cerca',''));

	$out='<div class="panel purple" style="text-align:center;">
	
		<table class="form" id="cerca_db">
			<tr>
				<th>
					<input type="hidden" name="Q" value="DB/Load_Interface">
					<i18n>db:iface:dbName</i18n>  
				</th>
				<td> <input type="text" name="cerca" class="full" value="'.$filter.'" id="input_cerca_db"> </td>
				<td> <button class="purple" onclick="pi.request(\'cerca_db\');"><i class="mdi mdi-magnify"></i> <i18n>search</i18n> </button></td>
				<th> <button class="purple" onclick="pi.request(null,\'DB/Win_New\');"><i class="mdi mdi-database-plus"></i> <i18n>db:iface:newDb</i18n> </button> </th>
			</tr>
		</table>
	</div>
	<table class="lite purple">
		<tr>
			<th title="DB Id univoco"> <i18n>db:iface:uid</i18n> </th>
			<th title="Nome DB"> <i18n>db:iface:name</i18n> </th>
			<th title="Tipologia"> <i18n>db:iface:type</i18n> </th>
			<th title="Dettagli"> <i18n>db:iface:dett</i18n> </th>
			<th title="Visibilita"> <i18n>db:iface:visibility</i18n> </th>
			<th title="Numero di utenti che usano il DB"> <i18n>db:iface:used</i18n> </th>
		</tr>';
	
	//$out='<div class="purple panel" style="text-align:center;">
	//	
	//		<button class="new" onclick="pi.requestQ(null,\'DB_Win_New_OCI8\');"><div>Nuovo DB Oracle</div></button>
	//		<button class="new" onclick="pi.requestQ(null,\'DB_Win_New_MSSQL\');"><div>Nuovo DB SQL Server</div></button>
	//		<button class="new" onclick="pi.requestQ(null,\'DB_Win_New_SQLITE\');"><div>Nuovo DB SQLite</div></button>
	//		<button class="new" onclick="pi.requestQ(null,\'DB_Win_New_MYSQL\');"><div>Nuovo MySQL Server</div></button>
	//	
	//	</div> 
	//	<table class="lite purple">
	//	<tr>
	//		<th title="DB Id univoco"> UID </th>
	//		<th title="Nome DB"> Nome </th>
	//		<th title="Tipologia"> Tipologia </th>
	//		<th title="Dettagli"> Dettagli </th>
	//		<th title="Visibilita"> Visibilita </th>
	//		<th title="Numero di utenti che usano il DB"> Usato </th>
	//	</tr>';
	
	foreach($usr_list as $k => $v){
		$count_db[$v['db']] = $count_db[$v['db']] ? $count_db[$v['db']] + 1 : 1;
	}
	
	$db_dis = $db_abil = '';
	
	foreach($db_list as $k => $v){
		
		if($filter != ''){
			if(!(strpos(strtolower($k),$filter)!==false || strpos(strtolower($v['des']),$filter)!==false)){ continue; }
		}
		
		if($v['hide'] == 1){
			$db_out = 'db_dis';
			$vis = '<i><i18n>db:iface:hidden</i18n></i>';
			$style = 'color:#888;';
			$ico='<i class="mdi mdi-eye-off" />';
		}else{
			$db_out = 'db_abil';
			$vis = '<i18n>db:iface:visible</i18n>';
			$style='';
			$ico='<i class="mdi mdi-eye" />';
		}
		
		switch($v['DB']){
			case 'OCI8' :
				$oc = get_oci8_des($v['server']);
				$dett = '[ <b><i18n>db:iface:lang</i18n> :</b> '.$v['lang'].' ][ <b><i18n>db:iface:server</i18n> :</b> '.$oc['server'].' : '.$oc['port'].' ][ <b><i18n>db:iface:service</i18n> :</b> '.$oc['service'].' ]';
			break;
			case 'MSSQL' :
				$dett = '[ <b><i18n>db:iface:server</i18n> :</b> '.$v['server'].' ][ <b>DB :</b> '.$v['dbname'].' ]';
			break;
			case 'SQLITE3' :
				$dett = '<i>SQLite non ha dettagli</i>';
			break;
			case 'MYSQL' :
				$dett = '[ <b><i18n>db:iface:server</i18n> :</b> '.$v['server'].' ][ <b>DB :</b> '.$v['dbname'].' ]';
			break;
			case 'PostgreSQL' :
				$dett = '[ <b><i18n>db:iface:server</i18n> :</b> '.$v['server'].' ][ <b>DB :</b> '.$v['dbname'].' ]';
			break;
		}
		
		$$db_out .='<tr style="cursor:pointer; '.$style.'" onclick="pi.request(\'edit_'.$k.'\');">
			<td>
				<div id="edit_'.$k.'">
					<input type="hidden" name="Q" value="DB/Win_Edit"> 
					<input type="hidden" name="id" value="'.$k.'">
					<input type="hidden" name="used" value="'.(isset($count_db[$k]) ? '1' : '0').'">
					'.$k.'
				</div>
			</td>
			<td>'.$v['des'].'</td>
			<td>'.$v['DB'].'</td>
			<td>'.$dett.'</td>
			<td>'.$ico.' '.$vis.'</td>
			<td>'.(isset($count_db[$k]) ? '<i class="mdi mdi-account" /> '.$count_db[$k] : '').'</td>
		</tr>';
	}
	
	$out .= $db_abil.$db_dis.'</table>';
	$pr->addHtml('container',$out)->addScript('$("#input_cerca_db").focus(); $("#input_cerca_db").select(); shortcut("enter", onEnterDB,{"propagate":false, target:"input_cerca_db"} );')->response();
?>