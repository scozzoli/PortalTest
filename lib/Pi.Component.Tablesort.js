/*
	Info Generali: 
		trasforma le tablle in tablle ordinabili.
	
	Dipendenze:
		Pi.JS ver 1.2 
		jquery.sortElements.js
	
	Attivazione:
		data-pi-component = tablesort
	
	Estensioni aggiuntive:
		sui TH della prima riga è possibile specificare il tipo di metadataro usando:
			data-pi-sort:
				numeric 	--> Ordinamento numerico 
				data 		--> Ordinamento data
				none		--> Nessun Ordinamento
	
	Esempio : 
		<table data-pi-component="tablesort">
			<tr> 
				<th> stringa </th>
				<th data-pi-sort='numeric'> numerico </th>
				<th data-pi-sort='data'> data </th>
				<th data-pi-sort='none'> non ordinabile </th>
			</tr> 
			...
		</table>
*/

pi.component.register('tablesort',function(obj){
	var table = obj;
	if(table.length == 0) return false;
	
	table.find("tr:first > th").each(function(){
		var th = $(this);
		var thIndex = th.index();
		var reverse = false;
		var opt = (this.getAttribute('data-pi-sort') && this.getAttribute('data-pi-sort').toLowerCase()) || 'string';
		var sortFn;
		
		var iconAscending 	= 'mdi-arrow-up';			//'mdi-sort-ascending';
		var iconDescending 	= 'mdi-arrow-down';			//'mdi-sort-descending';
		var iconSort 		= 'mdi-swap-vertical'; 		//'mdi-sort-variant';
		
		switch(opt){
			case 'data':
				sortFn = function(a,b){
					var ta = $.text([a]).split('/').reverse().join('');
					var tb = $.text([b]).split('/').reverse().join('');
					return ta > tb ? (reverse ? -1 : 1) : (reverse ? 1 : -1); 
				};
			break;
			case 'numeric':
				sortFn = function(a,b){
					var ta = parseFloat($.text([a]).replace(',','.')) || 0;
					var tb = parseFloat($.text([b]).replace(',','.')) || 0;
					return ta > tb ? (reverse ? -1 : 1) : (reverse ? 1 : -1); 
				};
			break;
			default : 
				sortFn = function(a,b){ return $.text([a]) > $.text([b]) ? (reverse ? -1 : 1) : (reverse ? 1 : -1); };
		}
	
		if(opt != 'none'){
			th.html('<i class="j-sort mdi ' + iconSort + '"></i>' + th.html());
			th.css('cursor','pointer');
			th.click(function(){
				
				if(!$(this).hasClass('pi-sort')){
					var prev = table.find('.pi-sort');
					prev.find(".j-sort").removeClass(iconAscending).removeClass(iconDescending).addClass(iconSort);
					prev.removeClass('pi-sort');
					$(this).addClass('pi-sort');
					$(this).find(".j-sort").removeClass(iconSort).addClass(iconDescending);
					reverse=false;
				}else{							
					if(reverse){ 
						$(this).find(".j-sort").removeClass(iconDescending).addClass(iconAscending);
					}else{
						$(this).find(".j-sort").removeClass(iconAscending).addClass(iconDescending);
					}
				}
				
				table.find('td').filter(function(){                    
					return $(this).index() === thIndex;
				}).sortElements( sortFn, function(){        
					return this.parentNode; 
				});
				
				reverse = !reverse;
			});
		}
		
	});
});