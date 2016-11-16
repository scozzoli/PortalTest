<?php
	$cert = $pr->post('serverkey');
	$pass = $pr->post('password','');
	$titolo = $pr->post('title');
	$msg = $pr->post('text');
	$deviceKey = $pr->post('device'); 
	
	if($deviceKey == '*'){
		$deviceKey = trim($pr->post('CustomDevice')); 
	}
	
	//$pr->alert($pr->getNumber('count'));
	function none($fuffer){ return '';} 
	ob_start('none');
	require_once $pr->getLocalPAth('/ApnsPHP/Autoload.php');
	
	$push = new ApnsPHP_Push(
		($pr->post('distribution') ? ApnsPHP_Abstract::ENVIRONMENT_PRODUCTION : ApnsPHP_Abstract::ENVIRONMENT_SANDBOX),
		$pr->getLocalPath('/cert/'.$cert)
	);
	
	$push->connect();
	$message = new ApnsPHP_Message($deviceKey);
	//$message->setCustomIdentifier("Message-Badge-3");
	
	if($pr->getNumber('count')){
		$message->setBadge($pr->getNumber('count',$pr::GET_NUM_INT));
	}else{
		$message->setBadge(0);
	}
	
	$message->setText($titolo);
	
	$message->setSound();
	
	$s1 = $s2 = ' -- ';
	
	if($pr->post('c1') != ''){ $message->setCustomProperty($pr->post('c1'), $pr->post('v1')); $s1 = 'OK';}
	if($pr->post('c2') != ''){ $message->setCustomProperty($pr->post('c2'), $pr->post('v2')); $s2 = 'OK';}
	
	// Set the expiry value to 30 seconds
	$message->setExpiry(30);
	// Add the message to the message queue
	$push->add($message);
	// Send all messages in the message queue
	$push->send();
	// Disconnect from the Apple Push Notification Service
	$push->disconnect();
	
	$alert = "<div class=\"panel\"> <b> Destinatario :</b> {$deviceKey}<br>
	<b> Certificato :</b> {$cert}<br>
	<b> Messaggio inviato :</b> 
	<ul> 
		<li> Titolo - {$titolo}</li>
		<li> Testo - {$msg} </li>
		<li> ".$pr->post('c1')." - ".$pr->post('v1')." [ {$s1} ]</li>
		<li> ".$pr->post('c2')." - ".$pr->post('v2')." [ {$s2} ]</li>
	</ul> ";
	
	
	$aErrorQueue = $push->getErrors();
	
	if (!empty($aErrorQueue)) {
		$alert .= '<div class="focus red"> Messaggo non inviato <br>'.var_export($aErrorQueue,true).' </div>';
	}else{
		$alert .= '<div class="focus green"> Messaggo inviato <br>'.$result.' </div>';
	}
	
	ob_end_flush();
	$pr->addHtml('container',$alert)->response();
	
	
	/////////////////////////////////
	
	//$pr->alert($pr->getLocalPath('/cert/'.$cert));
	
	$ctx = stream_context_create();
	stream_context_set_option($ctx, 'ssl', 'local_cert', $pr->getLocalPath('/cert/'.$cert));
	stream_context_set_option($ctx, 'ssl', 'passphrase', $pass);
	
	$apnUrl = 'api.development.push.apple.com:443';
	//$apnUrl = 'api.push.apple.com:443';
	$apnUrl = 'ssl://api.development.push.apple.com:2197';
	//$apnUrl = 'api.push.apple.com:2197';
	$apnUrl = 'tls://gateway.sandbox.push.apple.com:2195';
	
	// Open a connection to the APNS server
	$fp = stream_socket_client(
	  $apnUrl, $err,
	  $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

	if (!$fp){
		$pr->error("Connessione fallita: $err $errstr");
	}
	
	$obj['aps'] = array(
		'alert' => $msg,
		'sound' => 'default',
		'content-available' => '1'
		);
	
	if($pr->getNumber('count')){
		$obj["count"] = $pr->getNumber('count');
	}
	
	$s1 = $s2 = ' -- ';
	
	if($pr->post('c1') != ''){ $obj[$pr->post('c1')] = $pr->post('v1'); $s1 = 'OK';}
	if($pr->post('c2') != ''){ $obj[$pr->post('c2')] = $pr->post('v2'); $s2 = 'OK';}
	
	$payload = chr(0) . pack('n', 32) . pack('H*', $deviceKey) . pack('n', strlen($payload)) . json_encode($obj);
	
	$result = fwrite($fp, $payload, strlen($payload));

	fclose($fp);
	
	$alert = "<div class=\"panel\"> <b> Destinatario :</b> {$deviceKey}<br>
	<b> Certificato :</b> {$cert}<br>
	<b> Messaggio inviato :</b> 
	<ul> 
		<li> Titolo - {$titolo}</li>
		<li> Testo - {$msg} </li>
		<li> ".$pr->post('c1')." - ".$pr->post('v1')." [ {$s1} ]</li>
		<li> ".$pr->post('c2')." - ".$pr->post('v2')." [ {$s2} ]</li>
	</ul> ";
	
	if(!$result){
		$alert .= '<div class="focus red"> Messaggo non inviato <br>'.$result.' </div>';
	}else{
		$alert .= '<div class="focus green"> Messaggo inviato <br>'.$result.' </div>';
	}
		
	$pr->addHtml('container',$alert)->response();
	
	//$pr->add_msg('alert',$alert)->response();
?>