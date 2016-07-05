<?php
	$dbList = $sysConfig->loadDB();
	
	$vis = '<optgroup label="Attivi">';
	$hid = '<optgroup label="Nascosti">';
	
	foreach($dbList as $k => $v){
		$lis = $v['hide']=='1' ? 'hid' : 'vis';
		//$enable = $v['DB']!= 'MSSQL' ? 'disabled' : '';
		switch($v['DB']){
			case 'MSSQL':
			case 'OCI8' :
				$enable = '';
				break;
			default :
				$enable = 'disabled';
		}
		
		$$lis.= '<option value="'.$k.'" '.$enable.'> '.$v['des'].' ('.$k.') </option>';
	}
	$vis.= '</optgroup>';
	$hid.= '</optgroup>';
	$selDB = '<select name="db">'.$vis.$hid.'</select>';
	switch($dbList[$pr->getUsr('db')]['DB']){
		case 'MSSQL':
		case 'OCI8' :
			$fill = array('db' => $pr->getUsr('db'));
			break;
		default :
			$fill = array();
	}
	$js = "$('#cerca').attr('disabled',false); $('#cerca').focus(); 
		$('#SubmitBtn').attr('disabled',false); 
		$('#SessionBtn').attr('disabled',false);
		$('#LockBtn').attr('disabled',false);
		shortcut('enter',function(){pi.request('data','Cerca');},{type:'keydown',propagate:false,target:'cerca'});";
	$pr->addHtml('DBList',$selDB)->addScript($js)->addFill('DBList',$fill)->response();
?>