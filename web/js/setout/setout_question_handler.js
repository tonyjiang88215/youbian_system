TJDataCenter._urldata['type'] = TJDataCenter._urldata['type'] ? TJDataCenter._urldata['type'] : 1;

//数据查询和提交对象
dataQueryObject = {
	
	queryQuestionData : function(config){
		
		var queryData = {
			subject : TJDataCenter.get('subject'),
			section : TJDataCenter.get('section'),
			type : TJDataCenter._urldata['type'],
			offset : pagerHandler.offset,
			step : pagerHandler.step
		};
		
		for(var i in config){
			queryData[i] = config[i];
		}
		
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/stat/question_api.php?action=list',
			'type' : 'GET',
			'dataType' : 'jsonp',
			'data' : queryData,
			success : function(data){
				var count = data.count;
				var max_gid = data.max_gid;
				var childData = data.children;
				var data = data.data;
				
				if(max_gid){
					var maxGidArray = max_gid.split('_');
					
					var id_pre = maxGidArray[0];
					
					if(maxGidArray.length > 2){
						var _max = parseInt(maxGidArray[2])+1;
					}else{
						var _max = 1;
					}
					
					TJDataCenter.set('new_index' , _max.pad(6));
				}
				
				
				TJDataCenter.set('question_data' , data);
				TJDataCenter.set('question_child_data' , childData);
				TJDataCenter.set('question_count' , count);
				
				questionTemplateObject.setData(data , childData);
	//			console.log(data);
				questionTemplateObject.show();
				
				pagerHandler.setTotalCount(count);
				
				var e = new TJEvent.EventObject('question_list_show_success');
				TJEvent.dispatch(e);
				
			},
			error : function(){
			}
		});
		
	},
	
	queryQuestionTypeData : function(){

		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/source/question_type_api.php?action=list',
			'type' : 'GET',
			'dataType' : 'jsonp',
			'data' : {
				subject : TJDataCenter.get('subject')
			},
			success : function(data){
				if(data){
					TJDataCenter.set('question_type' , data);
					
					var e = new TJEvent.EventObject('question_type_change');
					e.data.question_type = data;
					TJEvent.dispatch(e);
					
				}else{
					var e = new TJEvent.EventObject('ajax_error');
					e.data.source = 'setin_data_handler.js queryQuestionTypeData()';
					TJEvent.dispatch(e);
				}
				
			},
			error : function(){
				var e = new TJEvent.EventObject('ajax_error');
				e.data.source = 'setin_data_handler.js queryQuestionTypeData()';
				TJEvent.dispatch(e);
			}
		});
	},
};
dataSubmitObject = {
	
	add2Batch : function(batch_id){
		
		var param = {
			type : TJDataCenter._urldata['type'],
			add_type : TJDataCenter.get('type'),
			batch_id : batch_id,
			subject : TJDataCenter.get('subject'),
			section : TJDataCenter.get('section'),
			
		};
		
		if(param.add_type == 'check'){
			var qid = [];
			
			$('.input_check:checked:visible:not(.check_all)').each(function(){
				qid.push($(this).closest('.question_template').attr('gid'));
			});
			
			param.qid = qid;
			
		}
		
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/setout/batch_api.php?action=add_question',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : param,
			success : function(data){
				if(data){
					
					var e = new TJEvent.EventObject('add_batch_success');
					TJEvent.dispatch(e);
					
				}else{
					var e = new TJEvent.EventObject('ajax_error');
					e.data.source = 'setin_data_handler.js queryQuestionTypeData()';
					TJEvent.dispatch(e);
				}
				
			},
			error : function(){
				var e = new TJEvent.EventObject('ajax_error');
				e.data.source = 'setin_data_handler.js queryQuestionTypeData()';
				TJEvent.dispatch(e);
			}
		});
		
	}
	
};


var queryQuestion = function(){
	
	var subject = TJDataCenter.get('subject');
	var section = TJDataCenter.get('section');
	
	if(subject != 0  && section != 0){
		dataQueryObject.queryQuestionData();
	}
	
};

TJEvent.addListener('subject_change' , function(){
	dataQueryObject.queryQuestionTypeData();
	queryQuestion();
});

TJEvent.addListener('section_change' , function(){
	queryQuestion();
});

TJEvent.addListener('select_batch_submit' , function(e){
	
	dataSubmitObject.add2Batch(e.data.batch_id);
	
});

TJEvent.addListener('add_batch_success' , function(){
	
	var e= new TJEvent.EventObject('select_batch_success');
	TJEvent.dispatch(e);
	
});


$(document).ready(function(){
	$('.action_insert_all').click(function(){
		TJDataCenter.set('type' , 'all');
		var e = new TJEvent.EventObject('select_batch_show');
		TJEvent.dispatch(e);
	});
	
	$('.action_insert_condition').click(function(){
		TJDataCenter.set('type' , 'condition');
		var e = new TJEvent.EventObject('select_batch_show');
		TJEvent.dispatch(e);
	
	});
	
	$('.action_insert_check ').click(function(){
		TJDataCenter.set('type' , 'check');
		var e = new TJEvent.EventObject('select_batch_show');
		TJEvent.dispatch(e);
		
	});
	
});


