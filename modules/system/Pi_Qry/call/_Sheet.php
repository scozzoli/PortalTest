<?php
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
	
	foreach($res as $idx => $row){
		$j = 0;
		foreach($row as $k => $v){
			switch($qryConf['metadata'][strtolower($k)] ?: 'string'){
				case 'numeric' :
					$xls->setActiveSheetIndex(0)->getCellByColumnAndRow($j++,$idx+2)->setValueExplicit(str_replace(',','.',$v),PHPExcel_Cell_DataType::TYPE_NUMERIC);
					break;
				case 'date' :
					$xls->setActiveSheetIndex(0)->getCellByColumnAndRow($j,$idx+2)->setValueExplicit(ExcelDate($v,$qryConf['null']),PHPExcel_Cell_DataType::TYPE_NUMERIC);
					$xls->setActiveSheetIndex(0)->getStyleByColumnAndRow($j++,$idx+2)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
					break;
				case 'datecobol' :
					$xls->setActiveSheetIndex(0)->getCellByColumnAndRow($j,$idx+2)->setValueExplicit(ExcelDateCobol($v,$qryConf['null']),PHPExcel_Cell_DataType::TYPE_NUMERIC);
					$xls->setActiveSheetIndex(0)->getStyleByColumnAndRow($j++,$idx+2)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
					break;
				case 'hidden' :
					break;
				default :
					$xls->setActiveSheetIndex(0)->getCellByColumnAndRow($j++,$idx+2)->setValueExplicit($v,PHPExcel_Cell_DataType::TYPE_STRING);
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
	header('Content-Disposition: filename="'.$name[1].'_'.date('Y.m.d_H.i').'.'.$qryConf['xls'].'"');
	$objWriter->save('php://output');
	$pr->responseRaw();
?>