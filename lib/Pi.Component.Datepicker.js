/*
	Info Generali: 
		Trasforma un input in datepicker
	
	Dipendenze:
		Pi.JS ver 1.2 
		jquery.datetimepicker.full.min
	
	Attivazione:
		data-pi-component = datepicker
	
	Estensioni aggiuntive:
		
	Esempio : 
		<input type="text" data-pi-component="datepicker" >
			
*/

pi.component.register('datepicker',function(obj){
	obj.attr('placeholder','dd/mm/yyyy');
	jQuery.datetimepicker.setLocale('it');
	obj.datetimepicker({
		i18n:{
			it:{
				months:[
				'Gennaio','Febbraio','Marzo','Aprile',
				'MAggio','Giugno','Luglio','Agosto',
				'Settembre','Ottobre','Novembre','Dicembre'
				],
				dayOfWeek:[
					"Do.", "Lu", "Ma", "Me", 
					"Gi", "Ve", "Sa.",
				]
			},
		},
		timepicker:false,
		format: 'd/m/Y'
	});
});