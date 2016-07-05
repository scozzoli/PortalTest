<?php
	include $pr->getRootPAth('lib/xls/PHPExcel.php');

	function ExcelDateCobol($dtm,$null = ' '){
		if($dtm == '99999999' || $dtm == '0' || $dtm == $null){ return ''; }
		if( strlen($dtm) != 8 ){ return ''; }
		$date_from = date_create('1900-01-01');
		$date_to = date_create(substr($dtm,0,4).'-'.substr($dtm,4,2).'-'.substr($dtm,6,2));
		$diff = date_diff($date_from,$date_to);
		return ((int)$diff->format('%a'))+2;
	}

	function ExcelDate($dtm,$null = ' '){
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
			$date_from = date_create('1900-01-01');
			$date_to = date_create((strlen($d[2]) == 2 ? '20'.$d[2] : $d[2]).'-'.$d[1].'-'.$d[0]);
			$diff = date_diff($date_from,$date_to);
			return ((int)$diff->format('%a'))+2;
		}else{
			return '';
		}
	}

	$qryConf = json_decode(file_get_contents($pr->getLocalPath("script/".$pr->post('qry'))),true);

	$res = getQryData($pr,$qryConf);//,$qryConf['null']);

	switch($qryConf['xls']){
		case 'legacy' : $pr->next('_Sheet_Legacy'); break;
		case 'csv' :
		case 'csve' :
			$pr->next('_Sheet_CSV');
		break;
		default: $pr->next('_Sheet'); break;
	}
?>
