<?php
	// $cerca e $dbConfig sono ereditati da Cerca
	
	$db = new PiDB($dbConfig,$pr);
	
	$qry = "SELECT t.name AS table_name,
			SCHEMA_NAME(t.schema_id) AS schema_name,
			c.name AS column_name,
			c.max_length as max_length,
			c.precision as prec,
			c.scale as scale,
			c.is_nullable as nullable,
			p.name as data_type,
			c.collation_name as collation_name,
			t.object_id as object_id

			FROM sys.tables AS t
			INNER JOIN sys.columns c ON t.object_id = c.object_id
			inner join sys.types p on (c.system_type_id = p.system_type_id)
			WHERE upper(c.name) LIKE '{$cerca}'
			and p.name != 'sysname'
			ORDER BY schema_name, table_name";
	
	$qryTab = "SELECT t.name AS table_name,
			SCHEMA_NAME(t.schema_id) AS schema_name,
			count(c.name) as column_number,
			t.object_id as object_id

			FROM sys.tables AS t
			INNER JOIN sys.columns c ON t.object_id = c.object_id
			WHERE upper(t.name) LIKE '{$cerca}'
			group by t.name, t.schema_id,t.object_id
			ORDER BY schema_name, table_name";
	
	$resTab = $db->get($qryTab);
	
	$outTab = '<table class="lite red" data-pi-component="tablesort">
		<tr>
			<th>Tabella</th>
			<th>Schema</th>
			<th>Numero Colonne</th>
		</tr>';
	$idx = 0;
	foreach($resTab as $k=>$v){
		$outTab .= '<tr style="cursor:pointer" onclick="pi.request(\'tableObj'.$idx.'\',\'WinTableDettMSSQL\')">
			<td id="tableObj'.$idx.'">
				<input type="hidden" name="id" value="'.$v['object_id'].'">
				<input type="hidden" name="db">
				<input type="hidden" name="table">
				<input type="hidden" name="schema">
				'.$v['table_name'].'
			</td>
			<td>'.$v['schema_name'].'</td>
			<td>'.$v['column_number'].'</td>
		</tr>';
		$pr->addFill('tableObj'.$idx, array('table' => $v['table_name'], 'schema' => $v['schema_name'], 'db' => $pr->post('db')));
		$idx++;
	}
	$outTab.='</table>';
	
	$res = $db->get($qry,true);
	$out = '<table class="lite blue" data-pi-component="tablesort">
		<tr>
			<th>Tabella</th>
			<th>Schema</th>
			<th>Colonna</th>
			<th>Tipo Dato</th>
		</tr>';
	$fill = array();
	foreach($res as $k=>$v){
		if($v['collation_name'] == $db->opt('null')){
			$type='<b style="color:#800">'.$v['data_type'].'</b> ('.$v['prec'].','.$v['scale'].')';
		}else{
			$type='<b style="color:#008">'.$v['data_type'].'</b> ('.$v['max_length'].') <i style="color:#888;">'.$v['collation_name'].'</i>';
		}
		$out .= '<tr style="cursor:pointer" onclick="pi.request(\'tableObj'.$idx.'\',\'WinTableDettMSSQL\')">
			<td id="tableObj'.$idx.'">
				<input type="hidden" name="id" value="'.$v['object_id'].'">
				<input type="hidden" name="db">
				<input type="hidden" name="table">
				<input type="hidden" name="schema">
				'.$v['table_name'].'
			</td>
			<td>'.$v['schema_name'].'</td>
			<td>'.$v['column_name'].'</td>
			<td>'.$type.'</td>
		</tr>';
		$pr->addFill('tableObj'.$idx, array('table' => $v['table_name'], 'schema' => $v['schema_name'], 'db' => $pr->post('db')));
		$idx++;
	}
	$out .= '</table>';
	
	$content = '<div class="panel" data-pic="'.(count($resTab) > 0 ? 'collapse' : 'collapse : {close:true}').'"><div class="header red">Tabelle ('.count($resTab).')</div>'.$outTab.'</div>';
	$content .= '<div class="panel" data-pic="'.(count($res) > 0 ? 'collapse' : 'collapse : {close:true}').'"><div class="header blue">Colonne ('.count($res).')</div>'.$out.'</div>';
	
	$pr->addHtml('container',$content)->response();
?>