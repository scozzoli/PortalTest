<?php
	if($pr->post('db') != ""){
		$db = new PiDB($pr->getDB($pr->post('db')));
	}

	$inputs = json_decode($pr->post('inputs'),true);

	$aSrc = Array();
	$aDest = Array();

	foreach($inputs ?: [] as $k => $v){
		$aSrc[] = $k;
		$tmpDest = $pr->post('i_'.$k);
		if($tmpDest != ''){
			switch($v['type']){
				case 'data' :
					$tmpDest = $pr->getDate('i_'.$k);
					if($tmpDest === false) $pr->alert("<i18n>err:validDate;{$v['des']}</i18n>");
				break;
				case 'numeric' :
					$tmpDest = $pr->getNumber('i_'.$k);
					if($tmpDest === false) $pr->alert("<i18n>err:validNumber;{$v['des']}</i18n>");
				break;
				default:
					$tmpDest = $pr->getString('i_'.$k, $pr->GET_STR_SQLSAFE);
			}
		}
		$aDest[] = $tmpDest;
	}

	$qry = str_replace($aSrc,$aDest,$pr->post('qry'));

	$res = $db->get($qry,true);

	if(count($res) == 0){
		$pr->alert("<i18n>err:qryNoResult</i18n>");
	}

	$metadata = json_decode($pr->post('metadata'),true) ?: [];

	foreach($res[0] as $k => $v){
		$key = strtolower($k);
		$metadata[$key] = $metadata[$key] ?: 'string';
	}

	ksort($metadata);
	$htmlMetadata = createMetadataTable($metadata);
	$fill = Array( 'metadata' => json_encode($metadata) );
	$pr->addHtml('metadataTable',$htmlMetadata)->addFill('qryDataForm',$fill)->response();
?>
