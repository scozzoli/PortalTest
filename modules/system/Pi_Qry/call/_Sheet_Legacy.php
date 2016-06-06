<?php
	function xlsBOF(){return pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);} 

	function xlsEOF(){return pack("ss", 0x0A, 0x00);} 

	function xlsWriteNumber($Row, $Col, $Value){ 
		return pack("sssss", 0x203, 14, $Row, $Col, 0x0). pack("d", str_replace(',','.',$Value)); 
	} 
	function xlsWriteLabel($Row, $Col, $Value ){ 
		$L = strlen($Value); 
		return pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L).$Value;
	}
	
	$name = explode('.',$pr->post('qry'));

	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename="'.$name[1].'_'.date('Y.m.d_H.i').'.xls"');
	
	$out = xlsBOF();
	
	$j = 0;
	
	foreach($res[0] as $key => $val){
		if(($qryConf['metadata'][strtolower($key)] ?: 'string')== 'hidden') { continue; } 
		$out .= xlsWriteLabel(0,$j++,$key);
	}
	
	foreach($res as $idx => $row){
		$j = 0;
		foreach($row as $k => $v){
			switch($qryConf['metadata'][strtolower($k)] ?: 'string'){
				case 'numeric' :
					$out .= xlsWriteNumber($idx+1,$j++,$v);
					break;
				case 'date' :
					$out .= xlsWriteNumber($idx+1,$j++,ExcelDate($v,$qryConf['null']));
					break;
				case 'datecobol' :
					$out .= xlsWriteNumber($idx+1,$j++,ExcelDateCobol($v,$qryConf['null']));
					break;
				case 'hidden' :
					break;
				default :
					$out .= xlsWriteLabel($idx+1,$j++,utf8_decode($v));
			}
		}
	}
	
	$out .= xlsEOF();

	$pr->responseRaw($out);
?>