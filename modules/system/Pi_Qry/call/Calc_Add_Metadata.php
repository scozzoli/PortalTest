<?php
	$metadata = json_decode($pr->post('metadata'),true);
	
	ksort($metadata);
	$htmlMetadata = createMetadataTable($metadata);
	$fill = Array( 'metadata' => json_encode($metadata) );
	$pr->addHtml('metadataTable',$htmlMetadata)->addFill('qryDataForm',$fill)->response();
?>