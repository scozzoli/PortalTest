/*
	Info Generali: 
		Trasforma un panel in un panel collassabile
	
	Dipendenze:
		Pi.JS ver 1.2 
	
	Attivazione:
		data-pi-component = collapse
		data-pic = collapse : { 
			close : < true / false* >, // Parte già chiuso
			triggerOnIcon : < true / false* > // deve usare solo l'icona come area cliccabile
		}
	
	Estensioni aggiuntive:	
		data-pi-close = <true / false*> 
			parte giò collassato
		data-pi-triggerOnIcon = <true / false*> 
			deve usare solo l'icona come area cliccabile
		
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
	
	var defaults = { 
		close : false,
		triggerOnIcon : false
	};
	
	var cfg = $.extend(null, defaults, settings);
	if(panel.attr('data-pi-close') ){
		cfg.close = panel.attr('data-pi-close');
	}
	
	if(panel.attr('data-pi-triggerOnIcon') ){
		cfg.triggerOnIcon = panel.attr('data-pi-triggerOnIcon');
	}
	
	if(headerOriginal.length == 0){
		header.addClass('header');
		innerHeader += '&nbsp;';
	}else{
		innerHeader += headerOriginal.html();
		header.attr('class',headerOriginal.attr('class'));
		header.attr('style',headerOriginal.attr('style'));
		headerOriginal.detach();
	}
	
	header.html(innerHeader);
	
	var content = $('<div></div>');
	content.addClass('content');
	var panelContent = panel.children().detach();
	
	//content.html(panel.html());
	panel.addClass('pi-collapse');
	panel.html('');
	panel.append(header);
	panel.append(content);
	content.append(panelContent);
	
	if(cfg.close){
		panel.addClass('close');
		content.hide();
	}else{
		panel.addClass('open');
	}
	if(cfg.triggerOnIcon){
		panel.addClass('triggerIcon');
		header.find('.icons').on('click',function(e){
			if(panel.hasClass('close')){
				panel.removeClass('close').addClass('open');
				content.slideDown('fast');
			}else{
				panel.removeClass('open').addClass('close');
				content.slideUp('fast');
			}
		});
	}else{
		panel.addClass('triggerBar');
		header.on('click',function(e){
			if(panel.hasClass('close')){
				panel.removeClass('close').addClass('open');
				content.slideDown('fast');
			}else{
				panel.removeClass('open').addClass('close');
				content.slideUp('fast');
			}
		});
	}
	
	
});