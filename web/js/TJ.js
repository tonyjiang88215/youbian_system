/**
 * JS端事件中心
 * Author By TonyJiang
 */

var TJ = {};

var TJEvent = {

	/**
	 * 可调用的事件对象
	 * eventNameKey:{ 'eventName':eventNameValue , 'defaultHandler':handlerName }
	 */
//	eventList : {},
	//存放事件的堆栈
	
	
	/** 
	 * 自定义事件机制，在系统内部添加不依靠于底层的事件机制，
	 * 自定义事件机制使用统一的事件，可在AS和JS端分别派发事件，使系统代码清晰，结构简单
	 *
	 * eventStack: {
	 * 			eventNameValue:handlerArray[handler1,handler2....],
	 * 			...
	 *		} 
	 */
	eventStack : {},
	
	delayStack : {
		js : [],
		as : []
	},
	
	addEvent: function(event){
		!this.eventStack[event] && (this.eventStack[event] = new Array());
	},
	
	/**
	 *自定义事件类，包装系统的event类，在其之上利用自己的事件名称来定义事件
	 * 
	 * @param {String} eName 	用于保存事件名称，在自定义事件系统中使用
	 * @  data  					用于保存自定义事件系统中，事件所伴随的值
	 * @  sourceEvent  			用来保存系统事件对象，保证可以获取事件所需的必要参数 
	 * 
	 **/
	EventObject : function(eName){
		this.eventName = eName;
		this.data = {};
		this.data.extraInfo = {};
		this.sourceEvent = null;
	},
	
	
	eventInit:function(){
		for(var k in this.eventList){
			this.addEvent(this.eventList[k].eventName);
		}
	},
	
	addListenerBase: function(eventName, listener, times, prepend){
		if(this.eventStack[eventName]==='undefined' || !this.eventStack[eventName]){
			this.eventStack[eventName] = [];
		}
		var handlerObject = new Object();
		handlerObject.handler = listener;
		handlerObject.times = times;
		if(prepend){
			this.eventStack[eventName] && this.eventStack[eventName].unshift(handlerObject);
		} else {
			this.eventStack[eventName] && this.eventStack[eventName].push(handlerObject);
		}
	},
	
	addListener: function(eventName,listener){
		this.addListenerBase(eventName, listener, -1, false);
	},
	
	addListenerOnce : function(eventName,listener){
		this.addListenerBase(eventName, listener, 1, false);
	},
	
	/** 
	 * 提供给内部使用, 保证事件处理在第一个执行
	 * @param {Object} eventName
	 * @param {Object} listener
	 */
	addListenerPrepend: function(eventName,listener){
		this.addListenerBase(eventName, listener, -1, true);
	},
	
	addListenerPrependOnce: function(eventName,listener){
		this.addListenerBase(eventName, listener, 1, true);
	},
	
	removeListener:function(event , listener){
		if(FBSEvent.eventStack[event]==='undefined' || !FBSEvent.eventStack[event]){
			return;
		}
		for(var i in FBSEvent.eventStack[event]){
			if (FBSEvent.eventStack[event][i].handler == listener) {
				FBSEvent.eventStack[event].splice(i, 1);
				return;
			}
		}
	},
	
	dispatch: function(eventObject, fromAS){
		var flag = true;
		var eventName = eventObject.eventName;
		if(!this.eventStack[eventName]){
			this.eventStack[eventName] = [];
		}
		var eventStackLength = this.eventStack[eventName].length;
		for(var i = 0 ; i < eventStackLength; i++){
			var handlerObject = this.eventStack[eventName].shift();
			if(handlerObject.times != 1){
				this.eventStack[eventName].push(handlerObject);
			}
			if(flag){
				try{
					var result = handlerObject.handler(eventObject);
					if(result===false){
						flag = false;
					}
				} catch(e){
					//捕获监听处理出错
				}
			}
		}
		if(!fromAS && flag){//如果不是从AS端派发的事件，而且中途没有终止，则派发给AS端
			try{
//				Global.AS_Object.dispatch(eventObject , true);
				FBS.AS_Object.dispatch(eventObject , true);
			}catch(e){
				this.delayStack.as.push(eventObject);
			}
		}
		return true;
	}
};

//数据分享中心
var TJDataCenter = {
	
	_urldata : {},	
		
	_data : {},
	
	set : function(key , value){
		this._data[key] = value;
	},
	
	get : function(key){
		return this._data[key] ? this._data[key] : 0;
	},
	
	_once_geturldata : function(){
			var _tmp = window.location.href.split('?')[1];
			if(_tmp){
				_tmp = _tmp.split('&');
			}
			
			if(_tmp){
				for(var i = 0 ; i < _tmp.length ; i++){
					var _t = _tmp[i].split('=');
					this._urldata[_t[0]] = _t[1];
				}
			}
			
			delete this._once_geturldata;
	}
		
};

TJDataCenter._once_geturldata();

//用于AJAX回调函数的堆栈
var TJAjaxCallbackStack = {
		_stack : {},
		addCallback : function(func){
			var name = '_'+new Date().getTime();
			this._stack[name] = func;
			return name;
		},
		
		finishCallback : function(name , result){
			try{
				this._stack[name](result);
			}catch(nothing){}
			
			this._stack[name] = null;
		}
		
		
		
};

var dataQueryObject = {};
var dataSubmitObject = {};

var TJExtends = {
	
	baseExtends : function(){
		
		Number.prototype.pad = function(n) {
		  return Array(n>(''+this).length?(n-(''+this).length+1):0).join(0)+this;
		};
		
		//兼容IE8 数组没有indexOf方法
		if (!Array.prototype.indexOf){
		  Array.prototype.indexOf = function(elt)
		  {
		    var len = this.length >>> 0;
		    var from = Number(arguments[1]) || 0;
		    from = (from < 0)
		         ? Math.ceil(from)
		         : Math.floor(from);
		    if (from < 0)
		      from += len;
		    for (; from < len; from++)
		    {
		      if (from in this &&
		          this[from] === elt)
		        return from;
		    }
		    return -1;
		  };
		}
		
		Date.prototype.getString = function(){
			return this.getFullYear() + '-' + (this.getMonth()+1).pad(2) + '-' + this.getDate().pad(2) + ' ' + this.getHours().pad(2) + ':'+this.getMinutes().pad(2) + ':' + this.getSeconds().pad(2);
		}
		
		
		this.base64 = {
			_keyStr : 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=',
			
			
 			_utf8_encode : function (string) {  
		        string = string.replace(/\r\n/g,"\n");  
		        var utftext = "";  
		        for (var n = 0; n < string.length; n++) {  
		            var c = string.charCodeAt(n);  
		            if (c < 128) {  
		                utftext += String.fromCharCode(c);  
		            } else if((c > 127) && (c < 2048)) {  
		                utftext += String.fromCharCode((c >> 6) | 192);  
		                utftext += String.fromCharCode((c & 63) | 128);  
		            } else {  
		                utftext += String.fromCharCode((c >> 12) | 224);  
		                utftext += String.fromCharCode(((c >> 6) & 63) | 128);  
		                utftext += String.fromCharCode((c & 63) | 128);  
		            }  
		   
		        }  
		        return utftext;  
		    }  ,
			
			 _utf8_decode : function (utftext) {  
		        var string = "";  
		        var i = 0;  
		        var c = c1 = c2 = 0;  
		        while ( i < utftext.length ) {  
		            c = utftext.charCodeAt(i);  
		            if (c < 128) {  
		                string += String.fromCharCode(c);  
		                i++;  
		            } else if((c > 191) && (c < 224)) {  
		                c2 = utftext.charCodeAt(i+1);  
		                string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));  
		                i += 2;  
		            } else {  
		                c2 = utftext.charCodeAt(i+1);  
		                c3 = utftext.charCodeAt(i+2);  
		                string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));  
		                i += 3;  
		            }  
		        }  
		        return string;  
		    } , 
			
			encode : function (input) {  
		        var output = "";  
		        var chr1, chr2, chr3, enc1, enc2, enc3, enc4;  
		        var i = 0;  
		        input = this._utf8_encode(input);  
		        while (i < input.length) {  
		            chr1 = input.charCodeAt(i++);  
		            chr2 = input.charCodeAt(i++);  
		            chr3 = input.charCodeAt(i++);  
		            enc1 = chr1 >> 2;  
		            enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);  
		            enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);  
		            enc4 = chr3 & 63;  
		            if (isNaN(chr2)) {  
		                enc3 = enc4 = 64;  
		            } else if (isNaN(chr3)) {  
		                enc4 = 64;  
		            }  
		            output = output +  
		            _keyStr.charAt(enc1) + _keyStr.charAt(enc2) +  
		            _keyStr.charAt(enc3) + _keyStr.charAt(enc4);  
		        }  
		        return output;  
		    }  ,
			
			decode : function (input) {  
		        var output = "";  
		        var chr1, chr2, chr3;  
		        var enc1, enc2, enc3, enc4;  
		        var i = 0;  
		        input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");  
		        while (i < input.length) {  
		            enc1 = this._keyStr.indexOf(input.charAt(i++));  
		            enc2 = this._keyStr.indexOf(input.charAt(i++));  
		            enc3 = this._keyStr.indexOf(input.charAt(i++));  
		            enc4 = this._keyStr.indexOf(input.charAt(i++));  
		            chr1 = (enc1 << 2) | (enc2 >> 4);  
		            chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);  
		            chr3 = ((enc3 & 3) << 6) | enc4;  
		            output = output + String.fromCharCode(chr1);  
		            if (enc3 != 64) {  
		                output = output + String.fromCharCode(chr2);  
		            }  
		            if (enc4 != 64) {  
		                output = output + String.fromCharCode(chr3);  
		            }
					
		        }  
		        output = this._utf8_decode(output);  
		        return output;  
		    }
		};
		
		
		
	}
	
};

TJExtends.baseExtends();

//全局基本设置

//设置webroot
TJDataCenter.set('webroot' , 'http://hxyoubian.hxpad.com');


//设置默认主子题

TJDataCenter.set('question_combine_parent_template' , {
	name : '主子题主题默认模版',
	question_stem : 1,
	question_column_single : 0,
	question_column_multi : 0,
	question_column_judge : 0,
	question_answer : 0,
	question_analysis : 0,
	column_id : 1,
	column_package : 1,
	column_from : 1,
	column_grade : 1,
	column_combine : 1,
	column_type : 1,
	column_template : 1,
	column_obj_flag : 1,
	column_knowledge : 1,	
	column_difficulty : 1,
	column_num : 0,
	column_score : 1,
	column_time : 1,
	column_keyword : 1
});

TJDataCenter.set('question_combine_children_template' , {
	name : '主子题子题默认模版',
	question_stem : 1,
	question_column_single : 0,
	question_column_multi : 0,
	question_column_judge : 0,
	question_answer : 1,
	question_analysis : 1,
	column_id : 0,
	column_from : 0,
	column_package : 0,
	column_grade : 0,
	column_combine : 0,
	column_type : 1,
	column_template : 1,
	column_obj_flag : 1,
	column_knowledge : 0,	
	column_difficulty : 0,
	column_num : 0,
	column_score : 1,
	column_time : 1,
	column_keyword : 1
});

TJDataCenter.set('question_combine_children_column' , {
//	column_id : 0,
//	column_package : 0,
//	column_from : 0,
//	column_grade : 0,
//	column_combine : 0,
//	column_obj_flag : 1,
//	column_knowledge : 0,	
//	column_type : 1,
//	column_difficulty : 0,
//	column_num : 0,
//	column_score : 1
	column_id : 1,
	column_from : 0,
	column_package : 0,
	column_grade : 0,
	column_combine : 0,
	column_type : 1,
	column_template : 1,
	column_obj_flag : 1,
	column_knowledge : 1,	
	column_difficulty : 1,
	column_num : 0,
	column_score : 1,
	column_time : 1,
	column_keyword : 1

});


//设置全局AJAX加载开始和结束后的显示效果

