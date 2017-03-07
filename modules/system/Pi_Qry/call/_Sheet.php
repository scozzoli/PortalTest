<?php
	function GetExeclStyle($iCfg,$iCol){
		$out = Array();
		if($iCfg == false){ return $out; }
		$bg = $iCfg['col'][$iCol]['bg'] == '' ? $iCfg['row']['bg'] : $iCfg['col'][$iCol]['bg'];
		$fg = $iCfg['col'][$iCol]['color'] == '' ? $iCfg['row']['color'] : $iCfg['col'][$iCol]['color'];
		$bold = $iCfg['col'][$iCol]['bold'] == null ? $iCfg['row']['bold'] : $iCfg['col'][$iCol]['bold'];
		//$italic = $iCfg['col'][$iCol]['italic'] == null ? $iCfg['row']['italic'] : $iCfg['col'][$iCol]['italic'];

		$out['fill']['type'] = PHPExcel_Style_Fill::FILL_SOLID;
		$out['font']['bold'] = $bold;

		switch($bg){
			case '':
			case 'white' 	:	unset($out['fill']); break;
			case 'black' 	:	$out['fill']['color']['argb'] = 'FF000000'; break;
			case 'green' 	:	$out['fill']['color']['argb'] = 'FFDFEFC4'; break;
			case 'red' 		: $out['fill']['color']['argb'] = 'FFF2C4C3'; break;
			case 'blue'   : $out['fill']['color']['argb'] = 'FFD6DFEF'; break;
			case 'orange' :	$out['fill']['color']['argb'] = 'FFFEE8D0'; break;
			case 'purple' :	$out['fill']['color']['argb'] = 'FFBFA7D5'; break;
		}

		switch($fg){
			case 'black' 	:	$out['font']['color']['argb'] = 'FF000000'; break;
			case 'white' 	:	$out['font']['color']['argb'] = 'FFFFFFFF'; break;
			case 'green' 	:	$out['font']['color']['argb'] = 'FF4A661B'; break;
			case 'red' 	 	:	$out['font']['color']['argb'] = 'FF6B1918'; break;
			case 'blue'  	:	$out['font']['color']['argb'] = 'FF2A4269'; break;
			case 'orange'	:	$out['font']['color']['argb'] = 'FF9A5202'; break;
			case 'purple'	:	$out['font']['color']['argb'] = 'FF593977'; break;
		}


		return $out;
	}


	$xls = new PHPExcel();
	$xls->getProperties()->setCreator('Portal 1')->setTitle('Interrogazione SQL');

	$style_title['font']['bold'] = true;
	$style_title['borders']['bottom']['style'] = PHPExcel_Style_Border::BORDER_THICK;

	$j = 0;

	foreach($res[0] as $key => $val){
		if(($qryConf['metadata'][strtolower($key)] ?: 'string')== 'hidden') { continue; }
		$xls->setActiveSheetIndex(0)->getCellByColumnAndRow($j,1)->setValue($key);
		$xls->setActiveSheetIndex(0)->getStyleByColumnAndRow($j++,1)->applyFromArray($style_title);
	}

	$qryConf['php'] = $qryConf['php'] ?: Array("enabled" => false);

	foreach($res as $idx => $row){

		if($qryConf['php']["enabled"]){
			$format = parsePHPCode($row,$qryConf['php']['code'],$pr);
		}else{
			$format = false;
		}

		$j = 0;
		foreach($row as $k => $v){
			$xls->setActiveSheetIndex(0)->getStyleByColumnAndRow($j,$idx+2)->applyFromArray(GetExeclStyle($format,$k));
			switch($qryConf['metadata'][strtolower($k)] ?: 'string'){
				case 'numeric' :
					$xls->setActiveSheetIndex(0)->getCellByColumnAndRow($j++,$idx+2)->setValueExplicit(str_replace(',','.',excelNull($v)),PHPExcel_Cell_DataType::TYPE_NUMERIC);
					break;
				case 'date' :
					$xls->setActiveSheetIndex(0)->setCellValueByColumnAndRow($j,$idx+2,PHPExcel_Shared_Date::PHPToExcel( ExcelDateObj(excelDateNull($v),$qryConf['null']) ));
					$xls->setActiveSheetIndex(0)->getStyleByColumnAndRow($j++,$idx+2)->getNumberFormat()->setFormatCode('dd/mm/yyyy');

					//$xls->setActiveSheetIndex(0)->getCellByColumnAndRow($j,$idx+2)->setValueExplicit(ExcelDate(excelDateNull($v),$qryConf['null']),PHPExcel_Cell_DataType::TYPE_NUMERIC);
					//$xls->setActiveSheetIndex(0)->getStyleByColumnAndRow($j++,$idx+2)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
					break;
				case 'datecobol' :
					$xls->setActiveSheetIndex(0)->getCellByColumnAndRow($j,$idx+2)->setValueExplicit(ExcelDateCobol(excelNull($v),$qryConf['null']),PHPExcel_Cell_DataType::TYPE_NUMERIC);
					$xls->setActiveSheetIndex(0)->getStyleByColumnAndRow($j++,$idx+2)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
					break;
				case 'hidden' :
					break;
				default :
					$xls->setActiveSheetIndex(0)->getCellByColumnAndRow($j++,$idx+2)->setValueExplicit(excelNull($v),PHPExcel_Cell_DataType::TYPE_STRING);
			}
		}
	}
	//Excel5
	//Excel2007
	//OOCalc
	switch($qryConf['xls']){
		case 'xls' :
			$objWriter = PHPExcel_IOFactory::createWriter($xls, 'Excel5');
			header('Content-Type: application/vnd.ms-excel');
			break;
		case 'xlsx' :
			$objWriter = PHPExcel_IOFactory::createWriter($xls, 'Excel2007');
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			break;
		case 'ods' :
			$objWriter = PHPExcel_IOFactory::createWriter($xls, 'OOCalc');
			header('Content-Type: application/vnd.oasis.opendocument.spreadsheet');
			break;
	}
	$name = explode('.',$pr->post('qry'));
	header('Content-Disposition: attachment; filename="'.$name[1].'_'.date('Y.m.d_H.i').'.'.$qryConf['xls'].'"');
	$objWriter->save('php://output');
	$pr->responseRaw();
?>
