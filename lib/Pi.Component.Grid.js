/*
	Info Generali:
		Trasforma qualunque elemento html una griglia ordinabile con filtri e paginazione lato server

	Dipendenze:
		Pi.JS ver 1.2

	Attivazione:
		data-pic = grid : {
					sortCol : 'colonna',
					sortDir : < asc / desc* >,
					filtersId : 'id del campo contenente i filtri',
					call : 'chiamata del servizio da effetuare per aggiornare i dati',
					id : 'id da usare per le request esterne',
					pages : [ <numero di record per pagina> ],
					refreshCount : < true / false* > // ad ogni pagina o ordinamento viene richiesta la count * dei record,
					callOnStart : < true / false* > // indica se deve eseguire SUBITO una chiamata per popolare i dati,
				}

	Elementi interni:
		<div data-col = " 
			name : 'nome colonna', 
			sort : < true* / false >, 
			align : < left*, right, center >, 
			size : 'dimensione in pixel' ,
			action : 'Id della chiamata da fare',
			post : [ <dati da passare via post> ]"> 
				etichetta colonna 
		</div>

	Esempio :
		<div data-pic=" grid : { filtersId : 'data', call : 'Udate_Grid', id : 'PiGrid' }">
			<div data-col=" name: 'nomeColonna' "> nome colonna </div>
			<div data-col=" name: 'Nome2', align:'right' "> <i18n>nomeColonna:inLingua</i18n> </div>
			...
		</div>
*/

/* global pi */

pi.component.register('grid',function(obj,settings){
	var defaults = {
		pages : [50,75,100],
		refreshCount : false,
		id : 'GridID_'+ Date.now() + '_' + Math.random().toString().substr(4),
		callOnStart: false
	};
	
	// Variabili per la formattazione
	var iconAscending 	= 'mdi-arrow-up-bold';		//'mdi-sort-ascending';
	var iconDescending 	= 'mdi-arrow-down-bold';	//'mdi-sort-descending';
	var iconSort 		= 'mdi-swap-vertical'; 		//'mdi-sort-variant';

	var grid = obj;
	var cfg = $extend(null, defaults, settings || {});
	var cols = [];
	var i,table,inputsArea ;
	
	
	// Funzione per la prima creazione degli header della griglia.
	// Dopo vengono sempre riutilizzati quelli presenti nel DOM
	var fnGetHeader = function(){
		var i, tItem, tCell, tRow;
		var inputCols = grid.find("[data-col]");
		var tmp = {
			sort : true,
			align: 'left',
			size : false,
			action : false,
			post : []
		};
		tRow = $('<tr></tr>');
		tRow.addClass('j-header');
		for(i = 0; i < inputCols.length; i++){
			tItem = eval('({'+inputCols[i].getAttribute('data-col')+'})');
			tItem = $.extend(null,tmp,tItem);
			tItem.label = inputCols[i].innerHTML;
			tItem.class = inputCols[i].getAttribute('class');
			cols.push(tItem);
			tCell = $('<th></th>');
			if(tItem.sort){
				tCell.addClass('j-sort');
				tCell.html('<i class="mdi '+iconSort+'"></i>'+tItem.label);
			}else{
				tCell.html(tItem.label);
			}
			tCell.attr('data-name',tItem.name);
			tCell.appendTo(tRow);
		}
		return tRow;
	};
	
	// Funzione per la creazione della griglia (usata anche per aggiornamenti e paginazione)
	var fnGetGrid = function(cols, data, header){
		var tTable = $('<table></table>');
		var i, k, j, tRow, tCell, tInput, tId;
		tTable.attr('class',grid.attr('class'));
		header.appendTo(tTable);
		for(i = 0; i< data.length; i++){
			tRow = $('<tr></tr>');
			for(k = 0; k < cols.lenght; k++){
				tCell = $('<tr></tr>');
				tCell.css('text-align',cols[k].align);
				tCell.attr('class',cols[k].class);
				tCell.html(data[i][cols[k].name]);
				if(cols[k].action){
					for (j = 0; j< cols[k].post.length; j++){
						tInput = $('<input>');
						tInput.attr('type','hidden');
						tInput.attr('name',cols[k].post[j]);
						tInput.attr('value',data[i][cols[k].post[j]]);
						tInput.appendTo(tCell);
						tCell.css('cursor','pointer');
						tId = cfg.id + '_' + i + '_' + k;
						tCell.attr('id',tId);
						tCell.click(function(){pi.request(tId, cols[k].action);});
						
					}
				}
				tCell.appendTo(tRow);
			}
			tRow.appendTo(tTable);
		}
		return tTable;
	};
	
	// funzione per il calcolo delle pagine (ritorna la dropdown)
	var fnCreatePagesSelector = function(page,rows){
		var sel = grid.find('.j-pages');
		var pageSize = grid.find('.j-pages-selector').val();
		var tItem, i, tot;
		tot = Math.ceil(rows/pageSize);
		sel.off('change');
		if(rows === 0){
			tItem = $('<option>');
			tItem.html(' - / - ');
			tItem.appendTo(sel);
		}else{
			sel.html('');
			for(i = 1; i <= tot; i++){
				tItem = $('<option>');
				tItem.val(i);
				tItem.html(i + ' / ' + tot);
				tItem.appendTo(sel);
			}
			sel.val(page);
			sel.on('change',function(){ pi.request(cfg.id, cfg.call); });
		}
	};
	
	// funzione per gestire il ritorno delle infromazioni
	var fnOnUpdate = function(){
		/*
		 * data { 
		 *	data : [{ nome : valore }, ...],
		 *	sort : {
		 *			column : < nome colonna >,
		 *			direction : < asc / desc >
		 *		}
		 *	page : < pagina attuale >
		 *	pages : < numero totlae di pagine >
		 *	count : < numero  totlae di righe >
		 *	}
		 */
		var data = JSON.parse(grid.find('.j-hidden-input').val());
		grid.find('.j-sort').removeClass(iconAscending).removeClass(iconDescending).addClass(iconSort);
		grid.find('[data-name="' + data.sort.column + '"]').removeClass(iconSort).addClass( data.sort.direction === 'asc' ? iconAscending : iconDescending);
		var header = grid.find('.j-header');
		
		grid.find('j-table').children().remove();
		fnGetGrid(cols,data.data,header).appendTo(grid.find('j-table'));
	};

	grid.html('<div id="' + cfg.id + '">'
			+'<input type="hidden" name="Q" value="' + cfg.call + '">'
			+( cfg.filtersId ? '<input type="hidden" name=":LINK:GRP" value="' + cfg.filtersId + '">' : '' )
			+'<div class="j-table"></div>'
			+'<div class="j-footer focus ' + grid.attr('class') + '">'
			+'	<table class="form"><tr>'
			+'		<td style="width:40px;"><i class="mdi mdi-chevron-left l3"></i></td>'
			+'		<td style="width:100px;"><select class="small j-pages"></select></td>'
			+'		<td style="width:40px;"><i class="mdi mdi-chevron-right l3"></i></td>'
			+'		<th style="width:100px;"><select class="small j-pages-selector"></select></th>'
			+'	</tr></table>'
			+'</div>'
			+'<input type="hidden" name=":NULL" class="j-hidden-input">'
			+'</div>');
	fnGetGrid(cols,[],fnGetHeader()).appendTo(grid.find('.j-table'));
	fnCreatePagesSelector(0,0);
	grid.find('.j-hidden-input').on('change',fnOnUpdate());
});

/*
 
// recupero la configurazione delle colonne
	var inputCols = grid.find("[data-col]");
	tmp = {
		sort : true,
		align: 'left',
		size : false
	};
	tRow = $('<tr></tr>');
	for( i = 0; i< inputCols.length; i++ ){
		item = eval('({'+inputCols[i].getAttribute('data-col')+'})');
		item = $.extend(null,tmp,item);
		item.label = inputCols[i].innerHTML;
		cols.push(item);
		tCell = $('<th></th>');
		if(item.sort){
			tCell.addClass('j-sort');
			tCell.html('<i class="mdi '+iconSort+'"></i>'+item.label);
		}else{
			tCell.html(item.label);
		}
		tCell.attr('data-name',item.name);
	}

 */