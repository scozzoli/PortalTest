/*
	Info Generali: 
		Trasforma una textarea in un editor MakeDown
	
	Dipendenze:
		Pi.JS ver 1.2 
		js/simplemde.min.js
	
	Attivazione:
		data-pi-component = markdowneditor
		
		data-pic = markdowneditor 
	
	Esempio : 
		<textarea data-pic="markdowneditor">
			... 
		</textarea>
*/

pi.component.register('markdowneditor',function(obj,settings){
	
	var def = { 
		element: obj[0],
		spellChecker: false,
		autoDownloadFontAwesome: false,
		forceSync: true,
		autofocus: false 
	};
	
	var cfg = $.extend(null,def,settings)
	cfg.element = obj[0]; // Per sicurezza ... ne caso qualcuno si sia sbagliato
	
	var simplemde = new SimpleMDE(cfg);
});