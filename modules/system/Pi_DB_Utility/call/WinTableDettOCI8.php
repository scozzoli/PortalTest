<?php
	// $cerca e $dbConfig sono ereditati da Cerca

	$db = new PiDB($pr->getDB($pr->post('db')));
	$table = $pr->getString('table',$pr::GET_STR_SQLSAFE);
	$schema = $pr->getString('schema',$pr::GET_STR_SQLSAFE);
	$qry = "SELECT
			  c.column_name as name,
			  c.NULLABLE as \"null\",
			  c.DATA_TYPE as \"type\",
			  c.DATA_LENGTH as strlen,
			  c.DATA_PRECISION || ',' || c.data_scale as numreiclen,
			  c.CHARACTER_SET_NAME as collation,
			  listagg(i.index_name,'!!') within group (order by c.column_name) as indici,
			  count(x.CONSTRAINT_NAME) as idxp,
			  count(i.index_name) - count(x.CONSTRAINT_NAME)as idxs

			from all_tab_columns c left join SYS.ALL_IND_COLUMNS i
			    on( i.table_name = c.table_name
			    and i.column_name = c.column_name
					and i.TABLE_OWNER = c.owner)
			  left join SYS.ALL_CONSTRAINTS x
			    on( x.INDEX_NAME = i.INDEX_NAME
			    and x.INDEX_OWNER = i.INDEX_OWNER
			    and x.TABLE_NAME = i.TABLE_NAME
			    and x.CONSTRAINT_TYPE = 'P' )

			where c.table_name = '{$table}'
			and c.OWNER = '{$schema}'
			group by c.column_name, c.NULLABLE, c.DATA_TYPE, c.DATA_LENGTH, c.DATA_PRECISION, c.data_scale,c.CHARACTER_SET_NAME,c.column_id
      order by c.column_id";

	$res = $db->get($qry,true);

	$header = "Dettagli  di  {$schema}.{$table}";

	$content = '<div class="focus purple">
			Dettagli della tabella
		</div>
		<table class="lite purple" data-pi-component="tablesort">
		<tr>
			<th>Campo</th>
			<th>Null</th>
			<th>Tipo</th>
			<th>Idx</th>
			<th>Nome Indici</th>
		</tr>';
	$idx = 0;
	foreach($res as $k=>$v){
		$null = $v['null'] == 'N' ? '<b class="orange"> No </b>' : '<b class="green"> Si </b>';
		if($v['numreiclen'] == ','){
			$size = '<i>('.$v['strlen'].')</i>';
		}else{
			$size = '<i>('.$v['numreiclen'].')</i>';
		}

		$collation = $v['collation'] == $db->opt('null') ? '' : ' <i style="color:#888;">'.$v['collation'].'</i>';

		$key = '';
		$key .= str_repeat('<i class="mdi mdi-key-variant orange" title="Chiave Primaria"></i>',$v['idxp']);
		$key .= str_repeat('<i class="mdi mdi-key-variant" title="Indice"></i>',$v['idxs']);

		$aIndex = $v['indici']==$db->opt('null') ? array() : explode('!!', str_replace('?','_',utf8_decode($v['indici'])));
		$aclass='j-row';
		$index = '';
		for($i = 0; $i < count($aIndex); $i++){
			if(trim($aIndex[$i]) == '') continue;
			$aclass .= ' j-k-'.$aIndex[$i];
			$index .= '<div style="cursor:pointer" class="j-index" data-index="j-k-'.$aIndex[$i].'">'.$aIndex[$i].'</div>';
		}

		$content .= '<tr class="'.$aclass.'">
			<td>'.htmlentities($v['name']).'</td>
			<td>'.$null.'</td>
			<td><b class="blue">'.htmlentities($v['type']).'</b> '.$size.$collation.' </td>
			<td>'.$key.'</td>
			<td>'.$index.'</td>
		</tr>';
		$idx++;
	}
	$content .= '</table>';
	$js="$('.j-index').on('click',function(e){
		$('.j-row').removeClass('orange');
		$('.'+e.target.getAttribute('data-index')).addClass('orange');
	});";
	$pr->addWindow(650,0,$header,$content,'')->addScript($js)->response();
?>
