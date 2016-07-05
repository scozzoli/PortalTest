<?php
	// $cerca e $dbConfig sono ereditati da Cerca

	$db = new PiDB($dbConfig,$pr);

/*
	$qry = "SELECT
			table_name as table_name,
			owner as schema_name,
			column_name as column_name,
			data_length as max_length,
			data_precision as prec,
			data_scale as scale,
			nullable as nullable,
			data_type as data_type,
			character_set_name as collation_name
			from all_tab_columns where column_name like '{$cerca}'
			ORDER BY schema_name, table_name";
*/
	$qry= "SELECT
			c.table_name as table_name,
			c.owner as schema_name,
			c.column_name as column_name,
			c.data_length as max_length,
			c.data_precision as prec,
			c.data_scale as scale,
			c.nullable as nullable,
			c.data_type as data_type,
			c.character_set_name as collation_name,
      decode(v.view_name, null, 'T','V') as table_view
			from all_tab_columns c left join SYS.ALL_VIEWS v
        on( c.owner = v.owner
        and c.table_name = v.VIEW_NAME)
      where UPPER(c.column_name) like '{$cerca}'
			and c.owner not in ('SYS','OLAPSYS','WMSYS','MDSYS')
			ORDER BY c.owner, c.table_name";

	$qryTab = "SELECT
			c.table_name as table_name,
			c.owner as schema_name,
			count(c.column_name) as column_number,
      decode(v.view_name, null, 'T','V') as table_view
			from all_tab_columns c left join SYS.ALL_VIEWS v
        on( c.owner = v.owner
        and c.table_name = v.VIEW_NAME)
			where upper(c.table_name) like '{$cerca}'
			and c.owner not in ('SYS','OLAPSYS','WMSYS','MDSYS')
			group by c.table_name, c.owner,v.view_name
      order by 1";

	$resTab = $db->get($qryTab);

	$outTab = '<table class="lite red" data-pi-component="tablesort">
		<tr>
			<th style="width:30px;"></th>
			<th>Tabella / vista</th>
			<th>Schema</th>
			<th>Numero Colonne</th>
		</tr>';
	$idx = 0;
	foreach($resTab as $k=>$v){
		if($v['table_view'] == 'T'){
			$tv = '<i class="blue mdi mdi-table l2" title="Tabella"></i>';
			$styleCol = '';
		}else{
			$styleCol = 'class="green"';
			$tv = '<i class="green mdi mdi-glasses l2" title="Vista"></i>';
		}
		$outTab .= '<tr '.$styleCol.' style="cursor:pointer" onclick="pi.request(\'tableObj'.$idx.'\',\'WinTableDettOCI8\')">
			<td>'.$tv.'</td>
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
			<th style="width:30px;"></th>
			<th>Tabella / vista</th>
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
		if($v['table_view'] == 'T'){
			$tv = '<i class="blue mdi mdi-table l2" title="Tabella"></i>';
			$styleCol = '';
		}else{
			$styleCol = 'class="green"';
			$tv = '<i class="green mdi mdi-glasses l2" title="Vista"></i>';
		}
		$out .= '<tr '.$styleCol.' style="cursor:pointer" onclick="pi.request(\'tableObj'.$idx.'\',\'WinTableDettOCI8\')">
			<td>'.$tv.'</td>
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
