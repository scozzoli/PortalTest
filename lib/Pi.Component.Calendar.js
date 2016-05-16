/*
	Info Generali: 
		Crea un calendario
	
	Dipendenze:
		Pi.JS ver 1.2 
	
	Attivazione:
		data-pic = calendar : {
			showToday : <true* / false>,
			year : <anno>,
			month : <mese>,
			lang : <"it"* / "en">,
			style : < "red" / "green" / "blue"* / "orange" / "purple" >,
			currentClass : < "red" / "green" / "blue"* / "orange" / "purple" / false >,
			eventClass : < "red" / "green" / "blue"* / "orange" / "purple" / false >,
			holidayClass : < "red" / "green" / "blue" / "orange"* / "purple" / false >,
			request : {
				Q : "nomechiamata",
				<nome variabile> : "valore variabile"
				<sono passate di default le variabili "Y" "M" "D">
			}
		}
	
	Estensioni aggiuntive:
		Evento giorno singolo:
			<div data-event=" <opzioni> "> Titolo + altre cose</div>
			
			data-event = "
				allDay : <true* / false>, // Se si tratta di giornata intera
				start :  "YYYY-MM-DD [HH:MM]", // data inizio evento. L'orario è opzionale. ES : "2016-05-13" / "2016-05-16 20:00"
				end : "YYYY-MM-DD [HH:MM]", // data fine evento. L'orario è opzionale ma se l'evento è "giornaliero" allora viene ignorato (il campo può essere omesso)
				link : <true / false*>, // Se impostato a true crea un link sull'evento che prenderà i campi input all'interno del DIV
				class : < "red" / "green" / "blue" / "orange" / "purple" / false >, //classe css dell'evento (diversa dal default)
			"
	
	Esempio : 
		<div data-pic="calendar : { year : 2016, month : 5, request : { Q : 'Win_Show_All_Day' }}">
			<div data-event=" fullday: true, start:'2016-05-18', link:true"> 
				<input type="hidden" name="Q" value="Win_dett_event"> 
				<input type="hidden" name="id" value="<id dell'evento>"> 
				Ciao mondo 
			</div>
		</div>
*/

pi.component.register('calendar',function(obj,settings){
	
	var iCal = obj;
	var iEvents = iCal.find('[data-event]');
	var defSettings = {
		showToday : true,
		year : null,
		month : null,
		lang : "it",
		style : "blue",
		currentClass : "blue",
		eventClass : "blue",
		holidayClass : "orange",
		request : null
	}
	
	var CalendarId = 'Cal_' + Date.now().toString() + Math.random().toString().substr(2,4);
	
	var cfg = $.extend(null,defSettings,settings);
	
	cfg.month--;
	
	var lang = {
		it : {
			week : ['Domenica','Lunedì','Martedì','Mercoledì','Giovedì','Venerdì','Sabato'],
			weekShort : ['Dom','Lun','Mar','Mer','Gio','Ven','Sab'],
			month : ['Gennaio','Febbraio','Marzo','Aprile','Maggio','Giugno','Luglio','Agosto','Settembre','Ottobre','Novembre','Dicembre'],
			monthShort : ['Gen','Feb','Mar','Apr','Mag','Giu','Lug','Ago','Set','Ott','Nov','Dic']
		},
		en : {
			week : ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
			weekShort : ['Sun','Mon','Tue','Wen','Thu','Fri','Sat'],
			month : ["January","February","March","April","May","June","July","August","September","October","November","December"],
			monthShort : ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']
		}
	}
	
	var tNow = new Date();
	var Today = new Date();
	var dayIdx = 1;
	
	tNow.setDate(1);
	tNow.setFullYear(cfg.year);
	tNow.setMonth(cfg.month);
	
	var monthTo
	
	tNow.setMonth(cfg.month + 1);
	monthTo = tNow.getMonth();
	tNow.setMonth(cfg.month);
	
	dayIdx = tNow.getDay() == 0 ? -5 : 2 - tNow.getDay();
	
	var hCalendar = $('<table></table>');
	hCalendar.addClass('calendar');
	hCalendar.addClass('bold');
	hCalendar.addClass('fix');
	hCalendar.addClass(cfg.style);
	hCalendar.addClass('nohover');
	
	var row = $('<tr></tr>');
	var cell;
	var myId = '';
	for(var i = 0; i<7; i++){
		cell = $('<th></th>');
		cell.html(lang[cfg.lang].week[i == 6 ? 0 : i+1]);
		row.append(cell);
	}
	
	tNow.setDate(dayIdx);
	
	while(tNow.getMonth() != monthTo){
		if(tNow.getDay() == 1){
			hCalendar.append(row)
			row = $('<tr></tr>');
		}
		cell = $('<td></td>');
		cell.append($('<div></div>').addClass('day').html(tNow.getDate()));
		myId = CalendarId + '_' + tNow.getFullYear() + ('0'+(tNow.getMonth() + 1).toString() ).slice(-2) + ('0'+tNow.getDate()).slice(-2);
		cell.attr('id',myId);
		if(tNow.getMonth() != cfg.month){
			cell.addClass('nomonth');
		}else{
			
			if(tNow.getDay() == 6 || tNow.getDay() == 0){
				cell.addClass(cfg.holidayClass);
			}else{
				cell.addClass(cfg.eventClass);
			}
			
			if((tNow.getDate() == Today.getDate()) && (tNow.getMonth() == Today.getMonth()) ){
				cell.addClass('thisday');
			}
			
			if(cfg.request != null){
				cell.attr('onclick','pi.request(this.id)');
				cell.append($('<input type="hidden" name="Q">').val(cfg.request.Q));
				cell.append($('<input type="hidden" name="Y">').val(tNow.getFullYear()));
				cell.append($('<input type="hidden" name="M">').val(tNow.getMonth() + 1));
				cell.append($('<input type="hidden" name="D">').val(tNow.getDate()));
				cell.attr('style','cursor:pointer');
			}
		}
		
		row.append(cell);
		dayIdx++;
		tNow.setDate(1);
		tNow.setFullYear(cfg.year);
		tNow.setMonth(cfg.month);
		tNow.setDate(dayIdx);
	}
	
	while(tNow.getDay() != 1){
		cell = $('<td></td>');
		myId = CalendarId + '_' + tNow.getFullYear() + tNow.getMonth() + tNow.getDate();
		cell.attr('id',myId);
		cell.addClass('nomonth');
		cell.append($('<div></div>').addClass('day').html(tNow.getDate()));
		row.append(cell);
		dayIdx++;
		tNow.setDate(1);
		tNow.setFullYear(cfg.year);
		tNow.setMonth(cfg.month);
		tNow.setDate(dayIdx);
	}
	hCalendar.append(row);
	
	var eSettings;
	var datepart;
	for(var i = 0; i < iEvents.length; i++){
		cell = $('<div></div>').addClass('event')
		cell.html(iEvents[i].innerHTML);
		eSettings = eval('({'+iEvents[i].getAttribute('data-event')+'})');
		datepart = eSettings.start.split(' ')[0].split('-');
		cell.addClass(eSettings.class || cfg.eventClass)
		//hCalendar.find('#' + CalendarId + '_' + datepart.join('')).append(cell);
		hCalendar.find('#' + CalendarId + '_' + datepart[0] + ('0'+datepart[1]).slice(-2) + ('0'+datepart[2]).slice(-2)).append(cell);
	}

	iCal.html('');
	iCal.append(hCalendar);
});