// JavaScript Document
// Portal 1 Obj (richede jQuery)
// versione per il JSON 

pi = (function(){ // membri privati
	// Per semplificare la lettura definisco tutti i metodi privati con un "underscore" davanti
	var _loader = {
		focusElem: null,
		text: "Caricamento in corso ... ",
		active: function(){ return (!$(".pi-loader").hasClass("hide")); },
		start: function(){
			if(this.active()){ 
				return false;
			}else{
				this.focusElem = document.activeElement;
				$(".pi-loader").removeClass("hide");
				$(".pi-wrapper").addClass("lock");
				$(".pi-loader .pi-modal-content").removeClass("hide").html('<div class="row"><i class="mdi mdi-refresh rotate"></i><span class="text">'+this.text+'</span><input style="width: 0px; height:0px; opacity:0;"></div>');
				$(".pi-loader .pi-modal-content input").focus();
			}
		},
		stop: function(){
			if(!this.active()){
				return false;
			}else{
				var elem = $(".pi-loader .pi-modal-content input");
				if(elem.is(':focus')){
					_loader.focusElem.focus();
				}
				$(".pi-loader").addClass("hide");
				$(".pi-wrapper").removeClass("lock");
				$(".pi-loader .pi-modal-content").addClass("hide").html("");
			}
		},
		updateText: function(txt){
			if(this.active()){
				$(".pi-loader .text").html(txt);
			}
		}
	}
	
	var _win = {
		options: {},
		active: function(){ return (!$(".pi-win").hasClass("hide")); },
		open: function(opt){
			if(_win.active()){ return false; }
			var def = {
				width: 500,
				height: 0,
				header: "Portal 1",
				content: "",
				footer: "",
				closeButton: true
			};
			_win.options = $.extend(null,def,opt);
			var $win = $(".pi-win .pi-modal-content");
			var closeButton = '<i class="mdi mdi-close pi-win-close" onclick="pi.win.close();"></i>';
			$(".pi-wrapper").addClass("lock");
			
			var winContent;
			winContent = '<div class="header">' + _win.options.header + ( _win.options.closeButton ? closeButton : '' ) + '</div>';
			winContent += '<div class="content">' + _win.options.content + '</div>';
			if(_win.options.footer){
				winContent += '<div class="footer">' + _win.options.footer + '</div>';
			}
			$win.html(winContent);
			
			$(".pi-win").removeClass("hide");
			
			_win.resize({width: _win.options.width, height:_win.options.height});
			
			$win.removeClass("hide")

			_component.apply($win);
			
			setTimeout(_win.resize,20);
			setTimeout(_win.resize,200);
			
			$(window).on('resize.win',$.proxy(_win.resize,_win));
			
		},
		close: function(){
			if(!_win.active()){ return false; }
			
			$(".pi-win .pi-modal-content").addClass('hide').html("");
			$(".pi-wrapper").removeClass("lock");
			$(".pi-win").addClass("hide");
			
			$(window).off('resize.win');
			
			_win.options = {};
			
			return true;
		},
		resize: function(){
			if(!_win.active()){ return false; }
			var options = _win.options || {};
			var $win = $(".pi-win .pi-modal-content");
			var width = options.width * 1 || $win.outerWidth();
			var height = options.height * 1 || 0;
			var documentHeight = $(window).innerHeight();
			var maxHeight =  documentHeight - $win.find(".header").outerHeight() - $win.find(".footer").outerHeight() - 20; // sfrido di 10 pixel sopra e sotto
			var maxWidth = $(document).innerWidth(); // sfrido di 10 pixel detra e sinistra è considerato nel posizionamento
			$win.find('.content').css('height','auto');
			if(height == 0){
				height = $win.find('.content')[0].scrollHeight;
				height = height > maxHeight ? maxHeight : height;
			}
			$win.find('.content').css('height',height);
			$win.css('height',height + $win.find(".header").outerHeight() + $win.find(".footer").outerHeight() );
			$win.css('width',width);
			var winTotalH = height + $win.find(".header").outerHeight() + $win.find(".footer").outerHeight();
			var posH = documentHeight - winTotalH > 20 ? (documentHeight - winTotalH) / 2 : 10;
			var posW = maxWidth - width > 20 ? (maxWidth - width) / 2 : 10;
			$win.css('top',posH);
			$win.css('left',posW);
			
			
		},
		update: function(opt){
			if(opt.header){ _win.header(opt.header); }
			if(opt.content){ _win.content(opt.content); }
			if(opt.footer){ _win.content(opt.footer); }
			_win.options.width = opt.width != undefined ? opt.width : _win.options.width;
			_win.options.height = opt.height != undefined ? opt.height : _win.options.height;
			_win.resize();
		},
		content: function(htm){
			if(!_win.active()){ return false; }
			$(".pi-win .pi-modal-content .content").html(htm);
			_win.options.content = htm;
			_component.apply($(".pi-win .pi-modal-content .content"));
			return true;
		},
		header: function(htm){
			if(!_win.active()){ return false; }
			$(".pi-win .pi-modal-content .header").html(htm);
			_win.options.header = htm;
			return true;
		},
		footer: function(htm){
			if(!_win.active()){ return false; }
			if(htm){				
				if(_win.options.footer){
					$(".pi-win .pi-modal-content .footer").html(htm);
				}else{
					$(".pi-win .pi-modal-content").htm($(".pi-win .pi-modal-content").htm() + '<div class="footer">' + htm + '</div>');
				}
			}else{
				$(".pi-win .pi-modal-content .footer").remove();
			}
			_win.options.footer = htm;
			return true;
		},
	};
	
	var _msg = {
		active: function(){ return (!$(".pi-message").hasClass("hide")); },
		open: function(iType, iMsg, iActions){
			var $msg = $(".pi-message .pi-modal-content");
			var mdiClass;
			var defaultActions = [];
			var msg = iMsg || '';
			defaultActions.push({
				title:"Chiudi", 
				onClick: $.proxy(this.close,this),
				style:'',
			});
			
			if(_msg.active()){
				$msg.removeClass($msg.attr('data-pi-type'));
			}
			
			$(".pi-wrapper").addClass("lock");
			$(".pi-message").removeClass("hide");
			
			switch(iType || 'bug'){
				case 'info' : mdiClass = 'mdi-information'; break;
				case 'error' : mdiClass = 'mdi-message-alert'; break;
				case 'alert' : mdiClass = 'mdi-message-alert'; break;
				case 'bug' : 
					mdiClass = 'mdi-bug'; 
					msg = "Si &eacute; verificato un errore imprevisto!";
					defaultActions.push({
						title:"Debug", 
						onClick: function(){ alert(iMsg.substr(0,400)); },
						style:'red',
						keepOpen: true
					});
					defaultActions.reverse();
				break;
			}
			var msgBody = '<div class="row"><i class="mdi '+mdiClass+'"></i><div class="text">'+(msg || '')+'</div></div>';
			var msgActions = '<div class="actions"></div>';
			var actions = iActions || defaultActions ;
			$msg.html(msgBody+msgActions);
			for(var k in actions){
				var elem = document.createElement('button');
				elem.className = actions[k].style || '';
				elem.innerHTML = actions[k].title || '';
				
				if(typeof actions[k].onClick == 'function'){
					if(actions[k].keepOpen){
						elem.onclick = actions[k].onClick;
					}else{
						elem.onclick = $.proxy(function(fn) { 
							_msg.close(); fn(); 
						},this,actions[k].onClick)
					}
				}else{
					if(actions[k].keepOpen){
						elem.onclick = eval(actions[k].onClick|| '');
					}else{
						elem.onclick = function() { _msg.close(); eval(actions[k].onClick|| ''); }
					}
				}
				$msg.find('.actions').append(elem);
			}
			$msg.addClass(iType || 'bug');
			$msg.removeClass('hide');
			$msg.attr('data-pi-type',iType || 'bug');
			elem.focus();
			_i18n.parse($msg);
			return true;
		},
		close: function(){
			if(_msg.active()){
				var $msg = $(".pi-message .pi-modal-content");
				var classToRemove = $msg.attr('data-pi-type');
				
				var elem = $(".pi-loader .pi-modal-content input");
				if(_loader.focusElem) _loader.focusElem.focus();
				_loader.focusElem = null;
				
				$msg.html("");
				$msg.addClass('hide').removeClass(classToRemove).removeAttr('data-pi-type');
				$(".pi-wrapper").removeClass("lock");
				$(".pi-message").addClass("hide");
				return true;
			}else{
				return false;
			}

		}
	};	
	
	var _component = {
		
		items : {},
		apply : function(obj){
			var elem = obj || $(document);
			var items = elem.find('[data-pi-component]');
			
			var mod;
			var item;
			
			while(items.length > 0){
				
				for(var i = 0; i< items.length; i++){
					item = $(items[i]);
					mod = item.attr('data-pi-component').toLowerCase();
					if(_component.items[mod]){
						_component.items[mod](item);
						item.removeAttr('data-pi-component');
					} else {
						console.error('PI Component : '+mod+' non registrato');
					}
				}
				
				items = elem.find('[data-pi-component]');
			}
			
			// Notazione compressa
			items = elem.find('[data-pic]');
			var settings;
			
			while(items.length > 0){
				for(var i = 0; i< items.length; i++){
					item = $(items[i]);
					if(item.data('pic').indexOf(':') > -1){
						settings = eval('({'+item.data('pic')+'})');
						mod = Object.keys(settings);
						if(mod.length != 1){
							console.error('Pi Component (PIC): numero di componenti specificato diverso da 1 (' + mod.length + ' : ' + mod.join(', ') + ')');
							mod = false;
						}
						
						settings = settings[mod[0]];
						mod = mod[0].toLowerCase();
					}else{
						mod = item.data('pic').trim().toLowerCase();
						settings = undefined;
					}
					
					if(mod && _component.items[mod]){
						_component.items[mod](item,settings);
					} else {
						if(mod !== false)
							console.error('PI Component (PIC): '+mod+' non registrato');
					}
					
					item.removeAttr('data-pic');
				}
				
				items = elem.find('[data-pic]');
			}
			
			_component.inputsParse(elem);
		},
		register : function(id,fn){
			var mod = id.toLowerCase();
			if(_component.items[mod] == undefined){
				_component.items[mod] = fn;
			} else {
				console.error('PI Component : '+mod+' Già registrato');
			}
		},
		unregister : function(id){
			_component.items[id] = undefined;
		},
		inputsParse : function(elem){
			var items = elem.find('input[type=checkbox], input[type=radio]');
			var label, id;
			
			for(var i = 0; i < items.length; i++){
				if(items[i].getAttribute('data-pi-inputParse')){ continue; }
				id = items[i].id || 'PiInputParse_' + Date.now().toString() + '_' + Math.random().toString().substr(2,5);
				items[i].id = id;
				label = document.createElement('label');
				label.setAttribute('for',id);
				$(label).insertAfter(items[i]);
				items[i].setAttribute('data-pi-inputParse',true);
			}
		}
	};
	
	var _silentCall = false;
	var _silentCallPreserve = false;
	var _defaultVarsId = 'Pi_Mod_Vars';
	var _promise = (function(){var x = new $.Deferred(); x.resolve(); return x;})();
	var _defaultLang = 'it';
	
	function _initPromise(){
		var promise = $.Deferred();
		promise.fail(function(){ _promise = new $.Deferred(); _promise.resolve(); });
		return promise;
	}
	
	function _getInputsByName(id){
		var lista = {};
		var inputs = $("#"+id+" :input");
		for(var i in inputs ){
			if(inputs[i].name){
				switch(inputs[i].type){
					case "text" :
					case "password" :
					case "select-one" :
					case "hidden" :
					case "textarea" :
						lista[inputs[i].name] = inputs[i].value;
					break;
					case "radio" :
						if(inputs[i].checked){ lista[inputs[i].name] = inputs[i].value; }
					break;
					case "checkbox" :
						lista[inputs[i].name] = inputs[i].checked ? 1 : 0;
					break;
				}
			}			
		}
		return lista;
	};
	
	function _fill(opt){
		var inputs = $("#"+opt.obj+" :input");
		for(var i in inputs ){
			if(opt.items[inputs[i][opt.get||'name']] !== undefined){
				var val = opt.items[inputs[i][opt.get||'name']];
				switch(inputs[i].type){
					case "text" :
					case "password" :
					case "select-one" :
					case "hidden" :
					case "textarea" :
						inputs[i].value = val;
					break;
					case "radio" :
						inputs[i].checked = inputs[i].value == val
					break;
					case "checkbox" :
						inputs[i].checked = val == 1;
					break;
				}
			}
		}
	};
	
	function _response(d){
		var val;
		var l_close,w_close;	
		var json;
		
		try{
			json = JSON.parse(d);
		}catch(e){
			_msg.open('bug',e+' '+d);
			_loader.stop();
			return false;
		}

		l_close = json.response.CloseLoader;
		w_close = json.response.CloseWin;
		if(json.response.DoItBefore == '1'){
			if(json.response.CloseLoader == '1'){_loader.stop();}
			if(json.response.CloseWin == '1'){_win.close();}
		}
		
		for(i in json.actions){
			var action = json.actions[i]
			switch(action.type.toLowerCase()){
				case 'html' :
					switch(action.position.toLowerCase()){
						case 'innerhtml' : 		$('#'+action.obj).html(action.content);		break;
						case 'append' : 		$('#'+action.obj).html($('#'+action.obj).html() + action.content);	break;
						case 'appendbefore' :	$('#'+action.obj).html(action.content + $('#'+action.obj).html());	break;
					}
					_component.apply($('#'+action.obj));
				break;
				case 'win' :
					w_close = '0';
					if(_win.active()){
						_win.update(action);
					}else{
						_win.open(action);
					}
				break;
				case 'script' :
					eval(action.src);
				break;
				case 'fill' :
					_fill(action);
				break;
				case 'message' :
					_msg.open(action.face,action.msg,action.actions);
				break;
				case 'component':
					if(_component[action.component]){
						_component[action.component](action.params)
					}else{
						console.error('Pi -> Component : ' + action.component + ' Non registrato');
					}
				break;
			}
			_i18n.parse();
		}
		
		if(json.response.DoItBefore == '0'){
			if(l_close == '1'){_loader.stop();}
			if(w_close == '1'){_win.close();}
		}
	}
	
	function _request(id,Q,rawfile){
		var sendVars = {pi:{}, call:{}};
		var chk, tmp;
			
		if(id && (typeof id == 'object')){
			var listVars = id;
		}else{
			var listVars = _getInputsByName(id);
		}
		if(Q != undefined){listVars['Q'] = Q;}
		var systemVars = _getInputsByName(_defaultVarsId);
		
		sendVars.pi = JSON.stringify(systemVars);
		sendVars.call = JSON.stringify(listVars);
		sendVars.module = systemVars['module'];
				
		if(_silentCall){
			_silentCall = false || _silentCallPreserve;
		}else{
			_loader.start();
		}
		if(rawfile){
			var form =  $('<form></form>').attr('action', $.ajaxSetup().url).attr('method', 'post').attr('target','_blank');
			form.append($("<input></input>").attr('type', 'hidden').attr('name', 'pi').attr('value', sendVars.pi));
			form.append($("<input></input>").attr('type', 'hidden').attr('name', 'call').attr('value', sendVars.call));
			form.append($("<input></input>").attr('type', 'hidden').attr('name', 'module').attr('value', sendVars.module));
			
			form.appendTo('body').submit().remove();
			_loader.stop();
		}else{			
			$.ajax({
				type : "POST",
				dataType : "text",
				data : sendVars,
				success : _response,
				error : _response
			});
		}
	}
	
	var _i18n = {
		remoteUrl: './i18n/Pi.I18n.php',
		dic: null,
		init: function(){			
			if (_i18n.dic === null){
				
				var parseResponse = function(d){
					try{
						json = JSON.parse(d);
						_i18n.dic = json;
					}catch(e){
						json = { def : {}, local: {}, common: {}, sys:{}, lang : _defaultLang, module:'' };
					}
					_i18n.dic = json;
					var trTitle = $('title').html();
					if(json.sys[json.lang][trTitle]){
						$('title').html(json.sys[json.lang][trTitle]);
					}
					_i18n.parse();
				}
				
				var systemVars = _getInputsByName(_defaultVarsId);
		
				var sendVars = {
					pi: JSON.stringify(systemVars),
					call: JSON.stringify({ Q : 'init' }),
				};
				
				$.ajax({
					url: _i18n.remoteUrl,
					type : "POST",
					dataType : "text",
					data : sendVars,
					success : parseResponse,
					error : parseResponse
				});
			}
		},
		
		getString: function(lang, strKey, scope){
			var myScope = scope || 'local';
			var myLang = lang || _defaultLang;
			var params = strKey.split(';')
			var tr = _i18n.dic[scope][lang][params[0]] != undefined ? _i18n.dic[scope][lang][params[0]] : (_i18n.dic.def[lang][params[0]] != undefined ? _i18n.dic.def[lang][params[0]] : false);
			if(tr !== false){
				if(tr!=''){
					if(params.length > 1){
						for(var i = 0 ; i < params.length; i++){
							tr = tr.replace('{'+i+'}',params[i+1]);
						}
						while(tr.indexOf('{'+i+'}') > -1){
							tr = tr.replace('{'+i+'}','');
							i++;
						}
					}
					return micromarkdown.parse(tr);
				}else{
					return '<span class="i18n-miss" data-lang="' + lang +' ">' + params[0] + '</span>';
				}
			}else{
				_i18n.notFound(lang,scope,params[0]);
				return '<span class="i18n-miss" data-lang="' + lang +' ">' + params[0] + '</span>';
			}
			
		},
		
		parse: function(obj){
			var items = obj ? obj.find('i18n') : $('i18n');
			var item;
			var tmp;
			var scope;
			
			for(var i = 0; i < items.length; i++){
				item = $(items[i]);
				scope = item.attr('scope') || 'local';
				tmp = $('<span></span>');
				tmp.attr('data-i18nkey',item.html());
				tmp.html(_i18n.getString(_i18n.dic.lang, item.html(), scope)).insertBefore(item);
				item.detach();
			}
		},
		
		notFound: function(lang,scope,strKey){
			_i18n.dic[scope][lang][strKey] = '';
			var parseResponse = function(d){
				console.log('i18n : Not Found --> ' + d);
			}
			
			var systemVars = _getInputsByName(_defaultVarsId);
	
			var sendVars = {
				pi: JSON.stringify(systemVars),
				call: JSON.stringify({ 
					Q : 'notfound',
					key: strKey,
					lang: lang,
					scope: scope,
					module: _i18n.dic.module
				}),
			};
			
			$.ajax({
				url: _i18n.remoteUrl,
				type : "POST",
				dataType : "text",
				data : sendVars,
				success : parseResponse,
				error : parseResponse
			});
		}
		
	}
	
	return { // membri pubblici
		request: function(id,Q){
			_promise.done(function(){
				if(_msg.active() || _loader.active() || _win.active()){ return false; }
				_request(id,Q);
			});
		},
		requestOnModal: function(id,Q){
			_promise.done(function(){
				if(_loader.active()){ return false;	}
				_request(id,Q);
			});
		},
		requestOnLoad: function(id,Q){
			_promise.done(function(){
				_request(id,Q);
			});
		},
		silent: function(preserve){
			_silentCall = true;
			_silentCallPreserve = preserve === true;
			return this;
		},
		download: function(id,Q){
			_promise.done(function(){
				if(_msg.active() || _loader.active() || _win.active()){ return false; }
				_request(id,Q,true);
			});
		},
		downloadOnModal: function(id,Q){
			_promise.done(function(){
				if(_loader.active()){ return false;	}
				_request(id,Q,true);
			});
		},
		downloadOnLoad: function(id,Q){
			_promise.done(function(){
				_request(id,Q,true);
			});
		},
		chk:function(fn){
			_promise = _initPromise();
			if(typeof fn == 'function'){
				setTimeout(function(){
					if(fn()){
						_promise.resolve();
					}else{
						_promise.reject();
					}
				},10);
				
			}else{
				var actions = [];
				actions.push({
					title:"Annulla", 
					onClick: _promise.reject,
					style:'red'
				});
				
				actions.push({
					title:"Ok", 
					onClick: _promise.resolve,
					style:'blue'
				});
				_msg.open('info',fn,actions);
			}
			return this;
		},
		win: {
			open: _win.open,
			close: _win.close,
			content: _win.content,
			header: _win.header,
			footer: _win.footer,
			active: _win.active,
		},
		msg: {
			info: function(msg,actions){ _msg.open('info',msg,actions); },
			error: function(msg,actions){ _msg.open('error',msg,actions);},
			alert: function(msg,actions){ _msg.open('alert',msg,actions);},
			bug: function(msg,actions){ _msg.open('bug',msg,actions);},
			confirm: function(msg,fn){ 
				var actions = [];
				if(fn !== undefined ){
					
					actions.push({
						title:"Annulla", 
						onClick: _msg.close,
						style:'red'
					});
					
					actions.push({
						title:"Ok", 
						onClick: fn || function(){alert('Ok')},
						style:'blue'
					});
					_msg.open('info',msg,actions);
					
				}else{
					var promise = $.Deferred();
					actions.push({
						title:"Annulla", 
						onClick: function(){ promise.reject(); },
						style:'red'
					});
					
					actions.push({
						title:"Ok", 
						onClick: function(){ 
							promise.resolve(); 
						},
						style:'blue'
					});
					_msg.open('info',msg,actions);
					return promise;
				}
			},
		},
		component: {
			register : _component.register,
			unregister : _component.unregister,
			apply : _component.apply
		},
		loader: function(val){
			if(val === undefined){
				return _loader.active();
			}else{
				if(val){
					return _loader.start();
				}else{
					return _loader.stop();
				}
			}
		},
		loaderText: function(txt){
			_loader.updateText(txt);
		},
		getInputsByName: _getInputsByName,
		init: function(){
			_i18n.init();
			_component.apply();
		}
	};
})();