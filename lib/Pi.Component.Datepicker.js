/*
	Info Generali: 
		Trasforma un input in datepicker
	
	Dipendenze:
		Pi.JS ver 1.2 
		jquery.datetimepicker.full.min
	
	Attivazione:
		data-pi-component = datepicker
		data-pic = datepicker : {
				timepicker : false, 
				format : 'd/m/Y', 
				locale: 'it'
			}
	
	Estensioni aggiuntive:
		
	Esempio : 
		<input type="text" data-pi-component="datepicker" >
			
*/

pi.component.register('datepicker',function(obj,settings){
	
	var defaults = { 
			timepicker:false,
			format: 'd/m/Y',
			locale: 'it'
		}
		
	var cfg = $.extend(null,defaults,settings);
	
	obj.attr('placeholder','dd/mm/yyyy');
	jQuery.datetimepicker.setLocale(cfg.locale);
	obj.datetimepicker({
		i18n:{
			it:{
				months:[
				'Gennaio','Febbraio','Marzo','Aprile',
				'Maggio','Giugno','Luglio','Agosto',
				'Settembre','Ottobre','Novembre','Dicembre'
				],
				dayOfWeek:[
					"Do.", "Lu", "Ma", "Me", 
					"Gi", "Ve", "Sa.",
				]
			},
		},
		timepicker:cfg.timepicker,
		format: cfg.format
	});
});