<?php
	// $cerca e $dbConfig sono ereditati da Cerca
	
	$db = new PiDB($pr->getDB($pr->post('db')));
	$table = $pr->getString('table',$pr::GET_STR_SQLSAFE);
	$schema = $pr->getString('schema',$pr::GET_STR_SQLSAFE);
	
	$qry = ";with idx as (SELECT 
				S.name as ShemaName,
				T.name as TableName,
				I.name as IndexName,
				C.name as ColumName,
				I.is_unique as IdxUnique,
				cast(I.is_primary_key as numeric(5)) as IdxPrimary,
				case I.type when 1 then 'S' else 'N' end as IdxCluster
			  FROM sys.tables T INNER JOIN sys.schemas S
					ON ( T.schema_id = S.schema_id )
				INNER JOIN sys.indexes I
					ON ( I.object_id = T.object_id )
				INNER JOIN sys.index_columns IC
					ON ( IC.object_id = T.object_id )
				INNER JOIN sys.columns C
					ON ( C.object_id = T.object_id
					AND IC.index_id = I.index_id
					AND IC.column_id = C.column_id )
			)

			SELECT info.COLUMN_NAME AS [name],
				   info.IS_NULLABLE AS [null],
				   info.DATA_TYPE as [type],
				   COALESCE( CASE WHEN info.CHARACTER_MAXIMUM_LENGTH = -1
							 THEN 'Max'
							 ELSE CAST(info.CHARACTER_MAXIMUM_LENGTH AS VARCHAR(5))
							 END, null) AS [Strlen],
				   cast(info.NUMERIC_PRECISION as varchar) + ',' +cast(info.NUMERIC_SCALE as varchar) as [Numericlen],
				info.COLLATION_NAME as Collation,
				info.COLUMN_DEFAULT as Def,
				isnull(sum(idx.IdxPrimary),0) as IdxPrimary,
				count(idx.IndexName) - isnull(sum(idx.IdxPrimary),0) as IdxSec,
				cast(stuff((select x.IndexName+'!!' 
					from idx x 
					where x.ColumName = info.COLUMN_NAME
					and x.ShemaName =  info.TABLE_SCHEMA
					and x.TableName =  info.TABLE_NAME
					for XML PATH('')),1,1,'') as text) as indici
			FROM INFORMATION_SCHEMA.COLUMNS info left join idx 
				on ( idx.ShemaName = info.TABLE_SCHEMA
				and idx.TableName = info.TABLE_NAME	
				and idx.ColumName = info.COLUMN_NAME)
			WHERE info.TABLE_NAME = '{$table}'
			and info.TABLE_SCHEMA = '{$schema}'
			group by info.COLUMN_NAME, info.IS_NULLABLE, info.DATA_TYPE, info.COLLATION_NAME, info.COLUMN_DEFAULT, info.TABLE_SCHEMA, info.TABLE_NAME,
			info.CHARACTER_MAXIMUM_LENGTH, info.NUMERIC_PRECISION, info.NUMERIC_SCALE, info.ORDINAL_POSITION
			order by info.ORDINAL_POSITION";
	
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
		$null = $v['null'] == 'NO' ? '<b class="orange"> No </b>' : '<b class="green"> Si </b>';
		if($v['Strlen'] != $db->opt('null')){
			$size = '<i>('.$v['Strlen'].')</i>';
		}elseif($v['Numericlen'] != $db->opt('null')){
			$size = '<i>('.$v['Numericlen'].')</i>';
		}else{
			$size = '';
		}
		
		$collation = $v['Collation'] == $db->opt('null') ? '' : ' <i style="color:#888;">'.$v['Collation'].'</i>';
		
		$key = '';
		$key .= str_repeat('<i class="mdi mdi-key-variant orange" title="Chiave Primaria"></i>',$v['IdxPrimary']);
		$key .= str_repeat('<i class="mdi mdi-key-variant" title="Indice"></i>',$v['IdxSec']);
		
		$aIndex = $v['indici']==$db->opt('null') ? array() : explode('!!', str_replace('?','_',$v['indici']));
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