shortcut('esc', function(){pi.win.close();});

function onEnterUsr(){ pi.request('cerca_utente'); }	
function onEnterMod(){ pi.request('cerca_modulo'); }	
function onEnterGrp(){ pi.request('cerca_gruppo'); }	
function onEnterMenu(){ pi.request('cerca_menu'); }	
function onEnterDB(){ pi.request('cerca_db'); }	

function modReplaceIco(obj){
	var elem = $('#anchor_img_to_save');
	var root = $('#icon_list');
	root.find('.'+elem.val()).removeClass('green');
	elem.val($(obj).attr('data-pi-icon'));
	root.find('.'+elem.val()).addClass('green');
}

function modFilterIcon(){
	var root = $('#icon_list');
	var list = root.find('.j-icon');
	var val = $('#search_icon_field').val();
	for (var i= 0; i<list.length; i++){
		if(val){
			if(list[i].getAttribute('data-pi-icon').indexOf(val) > -1){
				list[i].style.display = 'block';
			}else{
				list[i].style.display = 'none';
			}
		}else{
			list[i].style.display = 'block';
		}
	}
	if(val){
		root.find('.j-letter').hide();
	}else{
		root.find('.j-letter').show();
	}
}

function menuFilterMod(){
	var val = $('#search_module_field').val().toLowerCase();
	var list = $('#win_menu_module_list').find('.j-module');
	for (var i= 0; i<list.length; i++){
		if(val){
			if(list[i].getAttribute('data-pi-des').indexOf(val) > -1){
				list[i].style.display = 'table-row';
			}else{
				list[i].style.display = 'none';
			}
		}else{
			list[i].style.display = 'table-row';
		}
	}
	
}