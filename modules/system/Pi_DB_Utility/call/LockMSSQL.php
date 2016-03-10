<?php
	// $dbConfig è ereditato da Lock
	
	$db = new PiDB($dbConfig);
	
	//$qry = "SELECT t1.resource_type as resource_type,
	//		   DB_NAME(resource_database_id) as db,
	//		   t1.resource_associated_entity_id as objLoked,
	//		   t1.request_mode as mode, 
	//		   t1.request_session_id as sessione,
	//		   t2.blocking_session_id as lokingSession,
	//		   t2.wait_duration_ms as timeMs,
	//		  cast((SELECT SUBSTRING(text, t3.statement_start_offset/2 + 1,
	//			  (CASE WHEN t3.statement_end_offset = -1
	//				THEN LEN(CONVERT(nvarchar(max),text)) * 2
	//				ELSE t3.statement_end_offset
	//			   END - t3.statement_start_offset)/2)
	//		   FROM sys.dm_exec_sql_text(sql_handle)) as text)AS query_text,
	//	t2.resource_description as descr
	//	FROM
	//	   sys.dm_tran_locks AS t1,
	//	   sys.dm_os_waiting_tasks AS t2,
	//	   sys.dm_exec_requests AS t3
	//	WHERE
	//	   t1.lock_owner_address = t2.resource_address AND
	//	   t1.request_request_id = t3.request_id AND
	//	   t2.session_id = t3.session_id";
	
	$qry ="SELECT
		db.name DBName,
		tl.request_session_id AS BlockedSID,
		wt.blocking_session_id as BlockingSID,
		OBJECT_NAME(p.OBJECT_ID) BlockedObjectName,
		tl.resource_type ResourceType,
		cast(h1.TEXT as text) AS RequestingText,
		cast(h2.TEXT as text) AS BlockingText,
		tl.request_mode RequestMode,
		wt.wait_duration_ms as TimeMs
		FROM sys.dm_tran_locks AS tl
		INNER JOIN sys.databases db ON db.database_id = tl.resource_database_id
		INNER JOIN sys.dm_os_waiting_tasks AS wt ON tl.lock_owner_address = wt.resource_address
		INNER JOIN sys.partitions AS p ON p.hobt_id = tl.resource_associated_entity_id
		INNER JOIN sys.dm_exec_connections ec1 ON ec1.session_id = tl.request_session_id
		INNER JOIN sys.dm_exec_connections ec2 ON ec2.session_id = wt.blocking_session_id
		CROSS APPLY sys.dm_exec_sql_text(ec1.most_recent_sql_handle) AS h1
		CROSS APPLY sys.dm_exec_sql_text(ec2.most_recent_sql_handle) AS h2";
	
	$res = $db->get($qry,true);
	$fill = array();
	if(count($res) == 0){
		$out = '<div class="green panel" style="text-align:center;">
			<br><br>  <b>Nessun lock sul DB</b> <br><br><br>
		</div>';
	}else{
		$out = '<table class="red lite fix" data-pi-component="tablesort">
			<tr>
				<th>DB</th>
				<th>In attesa</th>
				<th>Bloccante</th>
				<th>Nome oggetto</th>
				<th>Tipo</th>
				<th>Modalita</th>
				<th>Tempo (sec) </th>
				<th>Query in attesa</th>
				<th>Query bloccante</th>
				<th>Termina</th>
			</tr>';
		$idx = 0;
		foreach($res as $k=>$v){
			$sec = ceil($v['TimeMs'] / 1000);
			
			$out .= '<tr id="rowLoked_'.$idx.'">
				<td>'.$v['DBName'].'</td>
				<td style="text-align:center">'.$v['BlockedSID'].'</td>
				<td style="text-align:center"><b class="red">'.$v['BlockingSID'].'</i></td>
				<td>'.$v['BlockedObjectName'].'</td>
				<td>'.$v['ResourceType'].'</td>
				<td>'.$v['RequestMode'].'</td>
				<td style="text-align:center">'.$sec.'</td>
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