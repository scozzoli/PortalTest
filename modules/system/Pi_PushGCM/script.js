	/*
pi.loader.focusOnExit = 'f1';
pi.loader.focusOnError = 'f1';
*/
function shortcut_onload(){
	if($('#f1').length>0){
		shortcut("enter",on_enter,{type:'keydown',propagate:false,target:'f1'});
	}
	/*shortcut("F9",cerca);*/
	shortcut("esc",win_close);
}

function win_close(){pi.win.close();}

$(document).ready(shortcut_onload);

function on_enter(){
	if($("#on_keypress_enter_first").length){
		$("#on_keypress_enter_first").click()
	}else{
		if($("#on_keypress_enter").length){
			$("#on_keypress_enter").click()
		}
	}
}