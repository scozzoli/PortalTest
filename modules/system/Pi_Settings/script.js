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

function mandatoryFieldsChk(mandatoryFields){
	/*
	mandatoryFields (Array of Objects):
	Array of mandatory fields
	e.g.:
	[
		{
			"name": "id",
			"label":"UID"
		}
	]
	*/
	if (typeof(mandatoryFields) != "object") {
		console.error("mandatoryFields should be an Array of Objects.");
		mandatoryFields = [mandatoryFields];
	}
	var validation = true;
	var missingFieldsList = "";

	for (i in mandatoryFields) {
		if (typeof(mandatoryFields[i]) != "object") {
			console.error("Items in mandatoryFields Array should be Objects.");
			mandatoryFields[i] = {
				"name":mandatoryFields[i]
			};
		}
		const name = mandatoryFields[i].name;
		const selector = "input[name='" + name + "']";
		const $selected = $(selector);
		if (!$selected.length) {
			console.error("Field named "+ name + " doesn't exist.");
			continue;
		}
		if ($selected.val() == "") {
			validation = false;
			if (mandatoryFields[i].label === undefined) {
			/*
			if no label is given, we suppose that input fields are wrapped in <td></td>
			and its the label is in the previous <th></th>
			*/
				mandatoryFields[i].label = $selected.parent().prev().text();
			}
			missingFieldsList += mandatoryFields[i].label;
			missingFieldsList += "<br/>";
		}
	}

	if (!validation) {
		pi.msg.alert("Mancano campi obbligatori:<br/>" + missingFieldsList);
		return false;
	}

	return true;
}
