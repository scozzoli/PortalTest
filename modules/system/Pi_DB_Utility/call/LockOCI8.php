<?php
	// $dbConfig è ereditato da Lock

	$db = new PiDB($dbConfig,$pr);


	$qry = "SELECT 
			vs.username as l_username,
			vs.osuser as l_osuser,
			vh.sid as l_sid,
			vs.status as l_status,
			substr(vs.machine,0,LENGTH(vs.machine)-1) as l_machine,
			decode(locked_mode,
					1,'Null',
					2,'Row Share (SS)',
					3,'Row Exclusive (SX)',
					4,'Share (S)',
					5,'Share Row Exclusive (SSX)',
					6,'Exclusive(X)',
					'unknow'
				) as locked_mode,
			object_name as obj_name,
			vs.module as module,
			vs.program as l_program,
			jrh.job_name as l_job,
			vsw.username as w_user,
			vsw.osuser as w_osuser,
			vw.sid as w_sid,
			vsw.program as w_program,
			jrw.job_name as w_job,
			'alter system kill session ' || ''''|| vh.sid || ',' || vs.serial# || ''''  as kill_command,
			sqlw.sql_text as w_sql,
			sqlb.sql_text as l_sql
		FROM
			v$lock vh,
			v$lock vw,
			v$session vs,
			v$session vsw,
			dba_scheduler_running_jobs jrh,
			dba_scheduler_running_jobs jrw,
			v$locked_object b,
			dba_objects o,
			v$sqlarea sqlw,
			v$sqlarea sqlb
		WHERE vh.id1 = vw.id1
		AND vh.id2 = vw.id2
		AND vh.request = 0
		AND vw.lmode = 0
		and b.session_id = vh.sid
		and o.object_id = b.object_id
		AND vh.sid = vs.sid
		AND vw.sid = vsw.sid
		AND vh.sid = jrh.session_id (+)
		AND vw.sid = jrw.session_id (+)
		and vsw.sql_id = sqlw.sql_id (+)
		and vs.sql_id = sqlb.sql_id (+)";

	error_reporting(E_ERROR);

	try{
		$res = $db->get($qry,true);
	}catch(Exception $e){
		$pr->error("Si &eacute; verificato un errore! <br> Ricorda che bisogna avere i privilegi di <b>DBA</b> per usare quasta funzione");
	}


	$fill = array();
	if(count($res) == 0){
		$out = '<div class="green panel" style="text-align:center;">
			<br><br>  <b>Nessun lock sul DB</b> <br><br><br>
		</div>';
	}else{
		$out = '<table class="red lite fix" data-pi-component="tablesort">
			<tr>
				<th> B. Utente </th>
				<th> B. OS </th>
				<th> B. SID </th>
				<th> B. Status </th>
				<th> B. PC </th>
				<th> B. Prog </th>
				<th> B. Job </th>
				<th> Modalita </th>
				<th> Obj </th>
				<th> Module </th>
				<th> A. Utente </th>
				<th> A. OS </th>
				<th> A. SID </th>
				<th> A. Prog </th>
				<th> A. Job </th>
				<th> B. Query </th>
				<th> A. Query </th>
				<th> Termina </th>

			</tr>';
		$idx = 0;
		foreach($res as $k=>$v){

			$out .= '<tr id="rowLoked_'.$idx.'">
				<td>'.$v['l_username'].'</td>
				<td>'.$v['l_osuser'].'</td>
				<td>'.$v['l_sid'].'</td>
				<td>'.$v['l_status'].'</td>
				<td>'.$v['l_machine'].'</td>
				<td>'.$v['l_program'].'</td>
				<td>'.$v['l_obj'].'</td>

				<td>'.$v['locked_mode'].'</td>
				<td>'.$v['obj_name'].'</td>
				<td>'.$v['module'].'</td>

				<td>'.$v['w_username'].'</td>
				<td>'.$v['w_osuser'].'</td>
				<td>'.$v['w_sid'].'</td>
				<td>'.$v['w_program'].'</td>
				<td>'.$v['w_obj'].'</td>

				<td style="text-align:center; cursor:pointer;" class="green" onclick="pi.request(\'rowLoked_'.$idx.'\',\'WinShowQLocked\')">
					<i class="mdi mdi-comment-text-outline l2"></i>
					<input type="hidden" name="locked">
				</td>
				<td style="text-align:center; cursor:pointer;" class="orange" onclick="pi.request(\'rowLoked_'.$idx.'\',\'WinShowQLocking\')">
					<i class="mdi mdi-comment-text-outline l2"></i>
					<input type="hidden" name="locking">
				</td>
				<td style="text-align:center; cursor:pointer;" class="red" onclick="pi.chk(\'Fermare il processo '.$v['BlockingSID'].'\').request(\'rowLoked_'.$idx.'\',\'KillMSSQL\')">
					<i class="mdi mdi-comment-remove-outline red l2"></i>
					<input type="hidden" name="db">
					<input type="hidden" name="kill">
				</td>

			</tr>';
			$fill['rowLoked_'.$idx] = array( 'locked' => $v['RequestingText'], 'locking' => $v['BlockingText'], 'kill' => $v['BlockingSID'], 'db' => $pr->post('db'));
			//$pr->addFill('rowLoked_'.$idx,array( 'locked' => $v['RequestingText'], 'locking' => $v['BlockingText'], 'kill' => $v['BlockingSID']));
			$idx++;
		}
		$out .= '</table>';
	}

	$pr->addHtml('container',$out);
	foreach($fill as $k => $v){
		$pr->addFill($k,$v);
	}
	$pr->response();
?>
