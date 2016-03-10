<?php
	$dbList = $sysConfig->loadDB();
	
	$vis = '<optgroup label="Attivi">';
	$hid = '<optgroup label="Nascosti">';
	foreach($dbList as $k => $v){
		$lis = $v['hide']=='1' ? 'hid' : 'vis';
		
		$$lis.= '<option value="'.$k.'"> '.$v['des'].' ('.$k.') </option>';
	}
	$vis.= '</optgroup>';
	$hid.= '</optgroup>';
	$selDB = '<select name="db">'.$vis.$hid.'</select>';
	$fill = array('db' => $pr->getUsr('db'));
	$js = "$('#cerca').attr('disabled',false); $('#cerca').focus(); 
		$('#SubmitBtn').attr('disabled',false); 
		$('#SessionBtn').attr('disabled',false);
		$('#LockBtn').attr('disabled',false);
		shortcut('enter',function(){pi.request('data','Cerca');},{type:'keydown',propagate:false,target:'cerca'});";
	$pr->addHtml('DBList',$selDB)->addScript($js)->addFill('DBList',$fill)->response();
?>