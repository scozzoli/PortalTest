/*
	Info Generali: 
		Trasforma qualunque elemento html in un editor evoluto
	
	Dipendenze:
		Pi.JS ver 1.2 
		ace/ace.js (versione min noconflict)
	
	Attivazione:
		data-pi-component = code
		
		data-pic = code : { 
					mode : '', 
					style: 'chrome', 
					readOnly: false, 
					lines: false 
				}
	
	Estensioni aggiuntive:
		data-pi-mode = 
			javascript,
			mysql,
			mssql,
			sql,
			php,
			css,
			less,
			html
		
		data-pi-style = 
			chrome --> chiaro
			twilight --> scuro 
			...
		data-pi-readony = <true / false*>
	Esempio : 
		<textarea data-pi-component="code" data-pi-mode="mysql">
			... 
		</textarea>
*/

pi.component.register('code',function(obj,settings){
	var myEditArea = obj[0];
	
	var cfg = settings || {};
	
	var mode = obj.attr('data-pi-mode') || cfg.mode || '';
	var style = obj.attr('data-pi-style') || cfg.style || 'chrome';
	var readOnly = obj.attr('data-pi-readonly') || cfg.readOnly || false;
	var lines = obj.attr('data-pi-lines') || cfg.lines || false;
	var editor = ace.edit(myEditArea);
	editor.setTheme("ace/theme/"+style);
	if(lines){
		editor.setOptions({maxLines: lines});
	}
	switch(mode){
		case 'javascript': 	editor.session.setMode('ace/mode/javascript'); break;
		case 'mysql':		editor.session.setMode('ace/mode/mysql'); break;
		case 'mssql':		editor.session.setMode('ace/mode/sqlserver'); break;
		case 'sql':			editor.session.setMode('ace/mode/sql'); break;
		case 'php':			editor.session.setMode('ace/mode/php'); break;
		case 'css':			editor.session.setMode('ace/mode/css'); break;
		case 'less':		editor.session.setMode('ace/mode/less'); break;
		case 'html':		editor.session.setMode('ace/mode/html'); break;
	}
	
	if(readOnly){ editor.setReadOnly(true); }
	
	var input = document.createElement('input');
	input.setAttribute('type','hidden');
	input.setAttribute('name',obj.attr('name'));
	input.setAttribute('value',editor.getValue());
	editor.on('change',function(e){ input.setAttribute('value',editor.getValue());});
	obj.append(input);
});