<?php
	$apiKey = $pr->post('serverkey');
	$titolo = $pr->post('title');
	$msg = $pr->post('text');
	//$ico = $_POST['icona'];
	$deviceKey = $pr->post('device'); 
	
	if($apiKey == '*'){
		$apiKey = $pr->post("CustomAPI");
	}
	
	if($deviceKey == '*'){
		$deviceKey = trim($pr->post('CustomDevice')); 
	}
	
	include $pr->getLocalPath('/lib/adp.php');
	
	$pusher = new \AndroidPusher\Pusher($apiKey);//$apiKey 'AIzaSyAxvr46w5IGL6oiU5Qz9DPB1cDHRPkfLkk'
	
	//$obj['message'] = $msg;
	//$obj['title'] = 'Rts Notify';
	//$obj['message'] = $msg
	$obj = Array(
		"title" => $titolo,
		"message" => $msg, //"Ci sono %n% notifiche",
		"style" => "inbox",
		//"image" =>"www/images/bell-{$ico}.png",
		//"image" =>"www/images/logo.png",
		"summaryText" => "Ci sono %n% notifiche",
		//"count" => 5,
		"ledColor" => [0, $pr->getNumber('r'), $pr->getNumber('g'), $pr->getNumber('b')]
		//"url" =>'ddd',
		//"Pk" => 39,
	);
	
	if($pr->getNumber('count')){
		$obj["count"] = $pr->getNumber('count');
	}
	
	$s1 = $s2 = ' -- ';
	
	if($pr->post('c1') != ''){ $obj[$pr->post('c1')] = $pr->post('v1'); $s1 = 'OK';}
	if($pr->post('c2') != ''){ $obj[$pr->post('c2')] = $pr->post('v2'); $s2 = 'OK';}
	
	
	$pusher->notify($deviceKey,$obj);
	
	$alert = "<div class=\"panel\"> <b> Destinatario :</b> {$deviceKey}<br>
	<b> API Key :</b> {$apiKey}<br>
	<b> Messaggio inviato :</b> 
	<ul> 
		<li> Titolo - {$titolo}</li>
		<li> Testo - {$msg} </li>
		<li> ".$pr->post('c1')." - ".$pr->post('v1')." [ {$s1} ]</li>
		<li> ".$pr->post('c2')." - ".$pr->post('v2')." [ {$s2} ]</li>
	</ul> ";
	
	$arr = $pusher->getOutputAsArray();
	//$arr = $pusher->output;
	
	if(isset($arr['success'])){
		if($arr['success'] == '1'){
			$alert .= '<div class="focus green"> '
					. 'Esito : <b>OK</b> <br>'
					. '<b>Multicast ID</b> : '.$arr['multicast_id'].' <br>';
		}else{
			$alert .= '<div class="focus red"> '
					. 'Esito : <b>Errore</b> <br>'
					. '<b>Multicast ID</b> : '.$arr['multicast_id'].' <br>';
		}
		foreach($arr['results'] as $key => $val){
			foreach($val as $k => $v){
				$alert.='<b>'.$k.'</b> : '.$v.'<br>';
			}
		}
		
		$alert.= '</div>';
	}else{
		$alert.='<br><br><div class="focus blue">'.var_export($arr,true).'</div></div>';
	}
	
	$pr->addHtml('container',$alert)->response();
	
	//$pr->add_msg('alert',$alert)->response();
?>