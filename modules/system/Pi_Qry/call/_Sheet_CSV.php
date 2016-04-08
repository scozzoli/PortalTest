<?php
	$eol = "\n";
	if($qryConf['xls'] == 'csv' ){
		$sep = ',';
	}else{
		$sep = ';';
	}
	$prefix = $qryConf['xls'];
	
	function StringToCsv($iStr,$iType){
		if($iType == 'csv') return '"'.str_replace('"','""',$iStr).'"';
		if($iType == 'csve') return '"=""'.str_replace('"','""',$iStr).'"""';
	}
	
	function DateToCsv($dtm,$null){
		$res = preg_match('/^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$/',$dtm);
		if($res == 1){
			if(strpos($res,'/') !== false){
				$d = explode('/',$out);
			}elseif(strpos($res,'-') !== false){
				$d = explode('-',$out);
			}elseif(strpos($res,'.') !== false){
				$d = explode('.',$out);
			}else{
				return '';
			}
			return (strlen($d[2]) == 2 ? '20'.$d[2] : $d[2]).'-'.$d[1].'-'.$d[0];
		}else{
			return '';
		}
	}
	
	function DatecobolToCsv($dtm,$null){
		if($dtm == '99999999' || $dtm == '0' || $dtm == $null){ return ''; }
		if( strlen($dtm) != 8 ){ return ''; }
		return substr($dtm,0,4).'-'.substr($dtm,4,2).'-'.substr($dtm,6,2);
	}
		
	$name = explode('.',$pr->post('qry'));

	header('Content-Type: text/csv');
	header('Content-Disposition: filename="'.$name[1].'_'.date('Y.m.d_H.i').'.csv"');
	
	$a = Array();
	foreach($res[0] as $key => $val){
		if(($qryConf['metadata'][strtolower($key)] ?: 'string')== 'hidden') { continue; } 
		$a[] = StringToCsv($key,$prefix);
	}
	
	$out = implode($sep,$a).$eol;
	
	foreach($res as $idx => $row){
		$a = Array();
		foreach($row as $k => $v){
			switch($qryConf['metadata'][strtolower($k)] ?: 'string'){
				case 'numeric' :
					$a[] = $v;
					break;
				case 'date' :
					$a[] .= DateToCsv($v,$qryConf['null']);
					break;
				case 'datecobol' :
					$a[] .= DatecobolToCsv($v,$qryConf['null']);
					break;
				case 'hidden' :
					break;
				default :
					$a[] .= StringToCsv($v,$prefix);
			}
		}
		$out .= implode($sep,$a).$eol;
	}
	
	$pr->responseRaw($out);
?>