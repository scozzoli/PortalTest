/*
	Info Generali:
		Trasforma qualunque elemento html in un grafico

	Dipendenze:
		Pi.JS ver 1.2
		js/chart.bundle.min.js (versione min)

	Attivazione:

		data-pic = chart : {
					type : [ line / bar / area / radar / polar / pie / nut / mixed* ],
					title : < titolo del grafico >
				}

	Elementi interni:
		<div data-label = " separator : <separatore def: ",">"> Label1,Label2,Label3 ... </div>
		<div data-chart = "
			type: <tipologia solo se mixed,
			data : {
				color : < blue / red / orange / green / purple / main* >,
				values : [ array di dati ]
			}
			"> Nome della seria </div>
	Esempio :
		<div data-pic="chart:{ type : 'mixed' }">
			<div data-label>Ciao,Ciao2,Ciao3</div>
			<div data-chart="type='bar',data:{color:'blue',values: [10,5,6]">Prima serie</div>
			<div data-chart="type='bar',data:{color:'blue',values: [10,5,6]">Seconda serie</div>
		</div>
		<div data-pic="chart:{ type : 'pie' }">
			<div data-chart="data:{color:'blue',values: [10]">Prima serie</div>
			<div data-chart="data:{color:'blue',values: [6]">Seconda serie</div>
		</div>
*/

/* global pi */

pi.component.register('chart',function(inObj,settings){
	var defSettings = {
		type : 'mixed',
		title : '',
		borderWidth : 1,
		missLabelFill : ' '
	};

	var cfg = $.extend(null,defSettings,settings);

	var obj = {
		chart : null,
		labels : null,
		data : []
	};

	var colors = {
		red : { c1: '', c2: '' },
		blue : { c1: '', c2: '' },
		orange : { c1: '', c2: '' },
		green : { c1: '', c2: '' },
		purple : { c1: '', c2: '' },
		main : { c1: '', c2: '' }
	};

	obj.chart = inObj[0];
	obj.labels = $(obj.chart).find('[data-labels]').detach();
	obj.data = $(obj.chart).find('[data-chart]').detach();

	// Recupero i colori da usare in base ai fogli di stile
	var test = $('<div>').appendTo(obj.chart).addClass('focus');
	colors.main.c1 = test.css('color');
	colors.main.c2 = test.css('background-color');
	test.addClass('red');
	colors.red.c1 = test.css('color');
	colors.red.c2 = test.css('background-color');
	test.removeClass('red').addClass('blue');
	colors.blue.c1 = test.css('color');
	colors.blue.c2 = test.css('background-color');
	test.removeClass('blue').addClass('green');
	colors.green.c1 = test.css('color');
	colors.green.c2 = test.css('background-color');
	test.removeClass('green').addClass('orange');
	colors.orange.c1 = test.css('color');
	colors.orange.c2 = test.css('background-color');
	test.removeClass('orange').addClass('purple');
	colors.purple.c1 = test.css('color');
	colors.purple.c2 = test.css('background-color');
	test.detach();

	var getSerieCfg = function(obj,skipDefaultColor,alfa){
		var tmpOptions = {};
		var tmpColor = '';
		var tmpSerie = eval('({'+obj.getAttribute('data-chart')+'})');
		if(tmpSerie.data){
			if((tmpSerie.type && tmpSerie.type.toLowerCase()) === 'area'){
				tmpOptions.type = 'line';
				tmpOptions.fill = true;
			}else{
				tmpOptions.type = (tmpSerie.type && tmpSerie.type.toLowerCase());
			}
			tmpOptions.data = tmpSerie.data.values;
			tmpColor = tmpSerie.data.color;
		}else{
			tmpOptions.type = cfg.type;
			tmpOptions.data = tmpSerie.values;
			tmpColor = tmpSerie.color;
		}
		if(!skipDefaultColor || tmpColor){
			tmpOptions.backgroundColor = colors[tmpColor || 'main'].c2;
			tmpOptions.borderColor = colors[tmpColor || 'main'].c1;
			tmpOptions.hoverBackgroundColor = colors[tmpColor || 'main'].c1;

			if(alfa){
				tmpOptions.backgroundColor = tmpOptions.backgroundColor.replace(')',', 0.4)').replace('rgb','rgba');
				tmpOptions.borderColor = tmpOptions.borderColor.replace(')',', 0.8)').replace('rgb','rgba');
				//tmpOptions.hoverBackgroundColor = tmpOptions.hoverBackgroundColor.replace(')',', 0.2)').replace('rgb','rgba');
			}
		}
		tmpOptions.piColor = (tmpColor == undefined);
		
		tmpOptions.borderWidth = cfg.borderWidth;

		tmpOptions.label = obj.innerHTML;

		return tmpOptions;
	};

	// variabili usate per la creazione
	var chartData = {};
	var chartOption = {};
	var lableMaxLen = 0;

	//Recupero la lista delle etichette
	chartData.labels = [];
	if(obj.labels.length > 0){
		var sep = eval('({'+obj.labels[0].getAttribute('data-labels')+'})');
		chartData.labels = obj.labels[0].innerHTML.split(sep.separator || ',');
	}

	var arrayC1 = [ colors['blue'].c1, colors['green'].c1, colors['orange'].c1, colors['red'].c1, colors['purple'].c1];
	var arrayC2 = [ colors['blue'].c2, colors['green'].c2, colors['orange'].c2, colors['red'].c2, colors['purple'].c2];
	
	cfg.type = cfg.type.toLowerCase();
	switch(cfg.type){
		case 'area' : //l'area è una linea con il riempimento
		case 'line' :
			chartOption = { scales : { yAxes : [{ ticks : { beginAsZero:true }}]} }; // Si parte sempre da 0
			chartData.datasets = [];
			tmpOptions = getSerieCfg(obj.data[0]);
			tmpOptions.fill = cfg.type === 'area';
			cfg.type = 'line';

			lableMaxLen = lableMaxLen >= tmpOptions.data.length ? lableMaxLen : tmpOptions.data.length;

			chartData.datasets.push(tmpOptions);

		break;
		case 'mixed' : //il gafico misto parte dalla base di qullo a barre
			cfg.type = 'bar';
		case 'bar' :
			chartOption = { scales : { yAxes : [{ ticks : { beginAsZero:true }}]} }; // Si parte sempre da 0
			chartData.datasets = [];

			var tmpOptions = {};

			// Scorro tutti data-chart e li aggiungo alla visualizzazione
			for(var i = 0; i < obj.data.length; i++){
				tmpOptions = getSerieCfg(obj.data[i]);

				lableMaxLen = lableMaxLen >= tmpOptions.data.length ? lableMaxLen : tmpOptions.data.length;
				tmpOptions.type = tmpOptions.type || cfg.type;
				
				if(tmpOptions.piColor){
					tmpOptions.backgroundColor = (arrayC2[i % 5]);
					tmpOptions.borderColor = (arrayC1[i % 5]);
					tmpOptions.hoverBackgroundColor = (arrayC1[i % 5]);
				}
				
				chartData.datasets.push(tmpOptions);
			}
		break;
		case 'nut' :
			cfg.type = 'doughnut';
		case 'doughnut' :
		case 'pie' :
		case 'polar' :
			chartData.datasets = [];

			var tmpOptions = getSerieCfg(obj.data[0],true);
			//Se mi viene passato un colore allore lo lascio monocromatico ... se no ciclo quelli disponibili

			if(!tmpOptions.backgroundColor){
				
				tmpOptions.backgroundColor = [];
				tmpOptions.borderColor = [];
				tmpOptions.hoverBackgroundColor = [];

				for(var i = 0 ; i< tmpOptions.data.length; i++){
					tmpOptions.backgroundColor.push(arrayC2[i % 5]);
					tmpOptions.borderColor.push(arrayC1[i % 5]);
					tmpOptions.hoverBackgroundColor.push(arrayC1[i % 5]);
				}

			}
			if (cfg.type === 'polar') { cfg.type = 'polarArea' ;}
			tmpOptions.type = cfg.type;
			chartData.datasets.push(tmpOptions);
		break;
		case 'radar' :
			chartOption = { scales : { yAxes : [{ ticks : { beginAzZeto:true }}]} }; // Si parte sempre da 0
			chartData.datasets = [];

			var tmpOptions = {};

			// Scorro tutti data-chart e li aggiungo alla visualizzazione
			for(var i = 0; i < obj.data.length; i++){
				tmpOptions = getSerieCfg(obj.data[i],false,true);
				tmpOptions.type = 'radar';
				lableMaxLen = lableMaxLen >= tmpOptions.data.length ? lableMaxLen : tmpOptions.data.length;
				
				if(tmpOptions.piColor){
					tmpOptions.backgroundColor = (arrayC2[i % 5]);
					tmpOptions.borderColor = (arrayC1[i % 5]);
					tmpOptions.hoverBackgroundColor = (arrayC1[i % 5]);
				}

				chartData.datasets.push(tmpOptions);
			}
		break;
	}

	if(chartData.labels.length < lableMaxLen){
		for(var i = chartData.labels.length; i< lableMaxLen; i++){
			chartData.labels.push(cfg.missLabelFill);
		}
	}

	//$.extend(chartOption, { legend : { labels : { usePointStyle : true } } });

	var canvas = $('<canvas>').appendTo($(obj.chart));
	var myChart = new Chart(canvas,{ type : cfg.type || 'bar', data:chartData, options:{maintainAspectRatio : false} }, chartOption);
});
