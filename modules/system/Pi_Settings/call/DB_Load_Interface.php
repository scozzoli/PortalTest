<?php
	$db_list = $sysConfig->loadDB();
	$usr_list = $sysConfig->loadUsr();
	
	$filter = strtolower($pr->post('cerca',''));

	$out='<div class="panel purple" style="text-align:center;">
	
		<table class="form" id="cerca_db">
			<tr>
				<th>
					<input type="hidden" name="Q" value="DB_Load_Interface">
					Nome DB : 
				</th>
				<td> <input type="text" name="cerca" class="full" value="'.$filter.'" id="input_cerca_db"> </td>
				<td> <button class="purple" onclick="pi.request(\'cerca_db\');"><i class="mdi mdi-magnify"></i> Cerca </button></td>
				<th> <button class="purple" onclick="pi.request(null,\'DB_Win_New\');"><i class="mdi mdi-database-plus"></i> Nuovo DB </button> </th>
			</tr>
		</table>
	</div>
	<table class="lite purple">
		<tr>
			<th title="DB Id univoco"> UID </th>
			<th title="Nome DB"> Nome </th>
			<th title="Tipologia"> Tipologia </th>
			<th title="Dettagli"> Dettagli </th>
			<th title="Visibilita"> Visibilita </th>
			<th title="Numero di utenti che usano il DB"> Usato </th>
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
			$vis = '<i>Nascosto</i>';
			$style = 'color:#888;';
			$ico='<i class="mdi mdi-eye-off" />';
		}else{
			$db_out = 'db_abil';
			$vis = 'Visibile';
			$style='';
			$ico='<i class="mdi mdi-eye" />';
		}
		
		switch($v['DB']){
			case 'OCI8' :
				$oc = get_oci8_des($v['server']);
				$dett = '[ <b>Lang :</b> '.$v['lang'].' ][ <b>Server :</b> '.$oc['server'].' : '.$oc['port'].' ][ <b>Servizio :</b> '.$oc['service'].' ]';
			break;
			case 'MSSQL' :
				$dett = '[ <b>Server :</b> '.$v['server'].' ][ <b>DB :</b> '.$v['dbname'].' ]';
			break;
			case 'SQLITE3' :
				$dett = '<i>SQLite non ha dettagli</i>';
			break;
			case 'MYSQL' :
				$dett = '[ <b>Server :</b> '.$v['server'].' ][ <b>DB :</b> '.$v['dbname'].' ]';
			break;
			case 'PostgreSQL' :
				$dett = '[ <b>Server :</b> '.$v['server'].' ][ <b>DB :</b> '.$v['dbname'].' ]';
			break;
		}
		
		$$db_out .='<tr style="cursor:pointer; '.$style.'" onclick="pi.request(\'edit_'.$k.'\');">
			<td>
				<div id="edit_'.$k.'">
					<input type="hidden" name="Q" value="DB_Win_Edit"> 
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