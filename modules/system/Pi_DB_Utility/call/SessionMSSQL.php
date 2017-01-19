<?php
	// $dbConfig è ereditato da Lock
	
	$db = new PiDB($dbConfig,$pr);
	
	$qry ="select
				P.spid as spid,   
				right(convert(varchar, 
						getdate() - P.last_batch, 
						121), 12) as 'batch_duration',   
				P.program_name as program,   
				P.hostname as hostname,
				P.net_address as addr,   
				P.loginame as loginname, 
				P.cmd as command, 
				P.status as status,
				cast(h1.text as text) as qry,
				P.blocked as blocked
			from master.dbo.sysprocesses P
			CROSS APPLY sys.dm_exec_sql_text(P.sql_handle) AS h1
			where P.spid > 50
			--and      P.status not in ('background', 'sleeping')
			/*and      P.cmd not in ('AWAITING COMMAND'
								,'MIRROR HANDLER'
								,'LAZY WRITER'
								,'CHECKPOINT SLEEP'
								,'RA MANAGER')
								*/
			order by batch_duration desc";
	
	$res = $db->get($qry,true);
	$fill = array();
	if(count($res) == 0){
		$out = '<div class="green panel" style="text-align:center;">
			<br><br>  <b>Nessun lock sul DB</b> <br><br><br>
		</div>';
	}else{
		$out = '<table class="green lite fix" data-pi-component="tablesort">
			<tr>
				<th>PID</th>
				<th>Durata</th>
				<th>Bloccanto</th>
				<th>Login</th>
				<th>Host</th>
				<th>Programma</th>
				<th>Comando</th>
				<th>Stato</th>
				<th>Query</th>
			</tr>';
		$idx = 0;
		foreach($res as $k=>$v){
			//$sec = ceil($v['TimeMs'] / 1000);
			
			switch(trim($v['status'])){
				case 'sleeping':
				case 'background':
					$class='disabled';
				break;
				default:
					$class='green';
			}
			
			$out .= '<tr id="rowProcess_'.$idx.'" class="'.$class.'">
				<td>'.$v['spid'].'</td>
				<td style="text-align:center">'.$v['batch_duration'].'</td>
				<td style="text-align:center">'.($v['blocked'] == 0 ? '<b class="green">No</b>' : '<b class="red">Si</b>').'</td>
				<td>'.$v['loginname'].'</td>
				<td>'.$v['hostname'].'</td>
				<td>'.$v['program'].'</td>
				<td>'.$v['command'].'</td>
				<td>'.$v['status'].'</td>
				<td style="text-align:center; cursor:pointer;" class="green" onclick="pi.request(\'rowProcess_'.$idx.'\',\'WinShowQGeneric\')">
					<i class="mdi mdi-comment-text-outline l2"></i>
					<input type="hidden" name="qry">
				</td>
				
			</tr>';
			$fill['rowProcess_'.$idx] = array( 'qry' => $v['qry'], 'db' => $pr->post('db'));
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