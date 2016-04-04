/*
	Info Generali: 
		Trasforma un panel in un panel collassabile
	
	Dipendenze:
		Pi.JS ver 1.2 
	
	Attivazione:
		data-pi-component = collapse
	
	Estensioni aggiuntive:	
		data-pi-close = <true / false*> 
		parte giò collassato
		
	Esempio : 
		<div class="panel" data-pi-component="collapse">
			<div class="header"> Titolo </div>
			
			tanta roba
			
		</div>
*/

pi.component.register('collapse',function(obj){
	
	var panel = obj;
	var headerOriginal = obj.find('.header');
	var header = $('<div></div>');
	var innerHeader = '<span class="icons"><i class="icon-open l2 mdi mdi-minus-circle"></i> <i class="icon-close l2 mdi mdi-plus-circle"></i> </span>';
	
	if(header.length == 0){
		header.addClass('header');
	}else{
		innerHeader += headerOriginal.html();
		header.attr('class',headerOriginal.attr('class'));
		headerOriginal.detach();
	}
	
	header.html(innerHeader);
	
	var content = $('<div></div>');
	content.addClass('content');
	content.html(panel.html());
	panel.addClass('pi-collapse');
	panel.html('');
	panel.append(header);
	panel.append(content);
	
	if(panel.attr('data-pi-close') == 'true' ){
		panel.addClass('close');
		content.hide();
	}else{
		panel.addClass('open');
	}
	
	header.on('click',function(e){
		if(panel.hasClass('close')){
			panel.removeClass('close').addClass('open');
			content.slideDown('fast');
		}else{
			panel.removeClass('open').addClass('close');
			content.slideUp('fast');
		}
	});
	
});