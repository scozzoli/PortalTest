/*
	Info Generali: 
		Trasforma un panel in un panel collassabile
	
	Dipendenze:
		Pi.JS ver 1.2 
	
	Attivazione:
		data-pi-component = collapse
		data-pic = collapse : { close : false }
	
	Estensioni aggiuntive:	
		data-pi-close = <true / false*> 
		parte giò collassato
		
	Esempio : 
		<div class="panel" data-pi-component="collapse">
			<div class="header"> Titolo </div>
			
			tanta roba
			
		</div>
*/

pi.component.register('collapse',function(obj,settings){
	
	var panel = obj;
	var headerOriginal = obj.find('> .header');
	var header = $('<div></div>');
	var innerHeader = '<span class="icons"><i class="icon-open l2 mdi mdi-minus-circle"></i> <i class="icon-close l2 mdi mdi-plus-circle"></i> </span>';
	
	var defaults = { close : false }
	
	var cfg = $.extend(null, defaults, settings);
	if(panel.attr('data-pi-close') ){
		cfg.close = panel.attr('data-pi-close') ;
	}
	
	if(headerOriginal.length == 0){
		header.addClass('header');
		innerHeader += '&nbsp;';
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
	
	if(cfg.close){
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