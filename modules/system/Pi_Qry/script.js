
shortcut('esc', function(){pi.win.close();});
shortcut('enter',on_enter,{'propagate':true});

function hs(id){
	if($('#'+id).css('display') == 'none'){
		$('#'+id).css('display','block');
	}else{
		$('#'+id).css('display','none');
	}
}
function on_enter(){
	if(!pi.win.active()){return;}
	if($('#toexecute').length>0){
		eval($('#toexecute').val());
	}
}

function chk_first_run(){
	if($('#first_execute').val()=='0'){
		$('#hs_user').css('display','none');
		$('#hs_global').css('display','none');
		$('#hs_group').css('display','none');
		$('#first_execute').val('1');
	}
}

function copy_sel(){
	if(pi.loader.active()||!pi.win.active()){return;}
	var d = pi.getInputByName('win_mask');
	var i = 1;
	var out = ''
	while(d['mask_auto_'+i] != undefined){
		out += d['mask_auto_'+i];
		i++;
	}
	$('#destination_mask').val(out);
	pi.win.close();
}
