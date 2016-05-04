/*
	Info Generali: 
		Crea un'area con schede.
	
	Dipendenze:
		Pi.JS ver 1.2 
	
	Attivazione:
		data-pi-component = tabstripe
		data-pic = tabstripe : {
			tabs : [ 'titolo1','titolo2' ] || i18n : [ 'titolo in lingua 1', 'key2' ]
		}
	
	Estensioni aggiuntive:
		sui tab interni 
			data-pi-tab = <nome del tab>
			data-pi-i18n = <nome del tab in i18n>
			class = <classe da applicare agli elementi interni>
	
	Esempio : 
		<div data-pi-component="tabstripe">
			<div data-pi-tab="tab 1"> ... </div>
			<div data-pi-tab="tab 2" class="red"> ... </div>
		</div>
*/

pi.component.register('tabstripe',function(obj,settings){
	
	var tabContainer = obj;
	var inner = tabContainer.children();
	var tabs = [];
	var cfgTitle = settings && settings.tabs || [];
	var cfgTitleI18n = settings && settings.i18n || [];
	var tabsTitle = [];
	var tabsSelector = $('<div></div>');
	
	tabsSelector.addClass('tablist');
	
	//tabsSelector.css('display','flex');
	//tabsSelector.css('align-items','stretch');
		
	for(var i = 0; i < inner.length; i++){
		var title = inner[i].getAttribute('data-pi-tab') || cfgTitle[i];
		var i18n = inner[i].getAttribute('data-pi-i18n') || cfgTitleI18n[i];
		
		if(i18n){
			title = '<i18n>'+i18n+'</i18n>';
		}
		inner[i].style.display = "none";
		if(title){
			tabs.push(inner[i]);
			tabsTitle.push(title);
		}
	}
	tabs[0].style.display = "block";
	
	for(var i = 0; i<tabs.length; i++){
		var item = $('<div></div>');
		if(tabs[i].getAttribute('class')){ item.addClass(tabs[i].getAttribute('class')); }
		item.html(tabsTitle[i]);
		item.addClass('tabvoice');
		tabs[i].classList.add('j-tab');
		tabs[i].classList.add('j-tab-'+i);
		item.attr('data-tabid',i);
		item.on('click',function(e){
			tabContainer.find('.j-tab').css('display','none');
			tabContainer.find('.j-tab-'+e.target.getAttribute('data-tabid')).css('display','block');
			//tabContainer.find('.j-tab').slideUp();
			//tabContainer.find('.j-tab-'+e.target.getAttribute('data-tabid')).slideDown('fast');
			tabContainer.find('.tabvoice').removeClass('selected');
			e.target.classList.add('selected');
			$(window).resize();
		});
		if(i == 0){
			item.addClass('selected');
		}
		tabsSelector.append(item);
	}
	tabsSelector.insertBefore(tabContainer.children()[0])
	tabContainer.addClass('pi-tabstripe');
});