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
	var txt = obj.val();
	//obj.val('');
	var simplemde = new SimpleMDE({ 
		element: obj[0],
		spellChecker: false,
		autoDownloadFontAwesome:false,
		forceSync:true,
	});
	
	//simplemde.value(txt);
	
	//simplemde.codemirror.on("change", function(){
	//	obj.val(simplemde.value());
	//});
});