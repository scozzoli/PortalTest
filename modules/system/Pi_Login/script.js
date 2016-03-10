shortcut('esc', function(){pi.win.close();});
shortcut('enter', on_enter,{'propagate':true} );

function on_enter(){
	if(pi.loader()){return;}
	if(pi.win.active()){
		if($("#pwd_data").length > 0)
			pi.requestOnModal('pwd_data');
	}else{
		if($('#UID').length > 0){
			pi.request('login');
		}
	}
}
