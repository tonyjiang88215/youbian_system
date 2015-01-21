/**
 * 校对页面数据处理中心
 * @Author By TonyJiang
 */

var queryDelay = null;

TJDataCenter._urldata['type'] = TJDataCenter._urldata['type'] ? TJDataCenter._urldata['type'] : 1;

//数据查询和提交对象
dataQueryObject = {
	
	queryQuestionData : function(){
		
		questionTemplateObject.clear();
		
		var queryData = {
			subject : TJDataCenter.get('subject'),
			section : TJDataCenter.get('section'),
			modify_only : TJDataCenter.get('modify_only'),
			offset : pagerHandler.offset,
			step : pagerHandler.step
		};
		
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/isource/temp_question_api.php?action=temp1',
			'type' : 'GET',
			'dataType' : 'jsonp',
			'data' : queryData,
			success : function(data){
				
				var count = data.count;
				var max_gid = data.max_gid;
				$('.modify_count').text(data.modify_count);
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
				
				//禁止主题干被编辑
				$('.content_td').click(function(){
					return false;
				});
				
				$('.question_table .input_select').attr('disabled' , 'disabled');
				$('.question_table .input_text:not(.q_knowledge)').attr('disabled' , 'disabled');
				
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
				subject : TJDataCenter.get('subject'),
				section : TJDataCenter.get('section')
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
	
	queryKnowledgeData : function(){
		
		var subject = TJDataCenter.get('subject');
		var section = TJDataCenter.get('section');

		if(subject == 0 || section == 0){
			return;
		}
		
		
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/base/knowledge_api.php?action=tree_data',
			'type' : 'GET',
			'dataType' : 'jsonp',
			'data' : {
				subject : subject,
				section : section
			},
			success : function(data){
				if(data){
					TJDataCenter.set('knowledge_list' , data);
					
					var e = new TJEvent.EventObject('knowledge_list_refresh');
					e.data.list = data;
					e.data.newData = true;
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
	
	queryQuestionHandler : function(question_ids){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/isource/question_api.php?action=query_handler',
			'type' : 'GET',
			'dataType' : 'jsonp',
			'data' : {
				question : question_ids
			},
			success : function(data){
				if(data){
					TJDataCenter.set('current_book_info' , data);
					
					var e = new TJEvent.EventObject('query_question_handler_success');
					e.data.info = data;
					TJEvent.dispatch(e);
					
				}else{
					var e = new TJEvent.EventObject('ajax_error');
					e.data.source = 'setin_data_handler.js queryBookData()';
					TJEvent.dispatch(e);
				}
				
			},
			error : function(){
				var e = new TJEvent.EventObject('ajax_error');
				e.data.source = 'setin_data_handler.js queryBookData()';
				TJEvent.dispatch(e);
			}
		});
	},
	
};

dataSubmitObject = {
	
	modifyQuestions : function(questions){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/isource/temp_question_api.php?action=modify',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				subject : TJDataCenter.get('subject'),
				section : TJDataCenter.get('section'),
				question : questions
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('update_question_success');
					TJEvent.dispatch(e);
				}else{
					var e = new TJEvent.EventObject('update_question_failed');
					e.data.content = 'dataSubmitObject.modifyQuestions()';
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('update_question_failed');
				e.data.content = 'dataSubmitObject.modifyQuestions()';
				TJEvent.dispatch(e);
			}
		});
		
	},
	
};




/************* START 搜索条件改变监听 START *************/
TJEvent.addListener('section_change' , function(){
	clearTimeout(queryDelay);
	queryDelay = setTimeout(function(){
		dataQueryObject.queryQuestionTypeData();
		dataQueryObject.queryKnowledgeData();
		dataQueryObject.queryQuestionData();
	},100);
});

TJEvent.addListener('subject_change' , function(){
	clearTimeout(queryDelay);
	queryDelay = setTimeout(function(){
		dataQueryObject.queryKnowledgeData();
	},100);
	
});


TJEvent.addListener('question_list_show_success' , function(){
	var questionData = TJDataCenter.get('question_data');
	
	var question_ids = [];
	
	for(var i = 0 ; i < questionData.length ; i++){
		question_ids.push(questionData[i].gid);
	}
	
	dataQueryObject.queryQuestionHandler(question_ids);
	
});

TJEvent.addListener('query_question_handler_success' , function(e){
	
	TJDataCenter.set('curernt_question_handler_data' ,  e.data.info);
	
	var data = e.data.info;
	
	for(var i = 0 ; i < data.length ; i++){
		if(data[i].action == 2){
			$('.question_template[gid='+data[i].gid+']').find('.seal_modify').show();;		
		}else if(data[i].action == 3){
			$('.question_template[gid='+data[i].gid+']').find('.seal_delete').show();;		
		}
		
//		if($('.modify_only')[0].checked){
//			$('.question_template[gid='+data[i].gid+']').hide();
//		}
		
	}
	
});

/************* END 搜索条件改变监听 END *************/

TJEvent.addListener('pager_change' , function(e){
	if(TJDataCenter.get('pager_offset') == e.data.offset && TJDataCenter.get('pager_step') == e.data.step){
		return;
	}
//	console.log(TJDataCenter.get('pager_offset'), e.data.offset , TJDataCenter.get('pager_step') , e.data.step);
	TJDataCenter.set('pager_offset' , e.data.offset);
	TJDataCenter.set('pager_step' , e.data.step);
	
	dataQueryObject.queryQuestionData({element_id:TJDataCenter.get('tree_element_id')});
	
});



TJEvent.addListener('update_question_success' , function(e){
	
	alert('修改成功');
	
	$('.question_template:visible').remove();
	
	dataQueryObject.queryQuestionData({element_id:TJDataCenter.get('tree_element_id')});
	
});

$(document).delegate('.action_save' , 'click' , function(){
	
	if(window.editor){
		var content = window.editor.html();
					
		window.editor.remove();
		window.editor = null;
		
		$('.editing').data('newData')[$(TJDataCenter.get('editor_column_element')).attr('key')] = content;
		$('.editing').removeClass('editing');
		
	}
	
	var updateData = [];
	
	$('.question_template:visible[combine=parent]').each(function(){
		var newData = $(this).data('newData');
		var oldData = $(this).data('oldData');
		
			
			
		if(newData.knowledge.toString() != oldData.knowledge.toString() && newData.knowledge_text.toString() != oldData.knowledge_text.toString()){
			updateData.push({
				gid : newData.gid , 
				knowledge : newData.knowledge , 
				knowledge_text : newData.knowledge_text,
				subject_id : newData.subject_id,
				section_id : newData.section_id
			});
		}
		
		
	});
	
	if(updateData.length == 0){
		alert('没有修改，无需保存');
		return;
	}
	
	dataSubmitObject.modifyQuestions(updateData);
	
});

$(document).ready(function(){
	
	$('.content').scroll(function(){
		
		if($('.content').scrollTop()>($('.content_list_action').offset().top+$('.content_list_action').outerHeight())){
			$('.content_list_action_float').slideDown(200);
		}else{
			$('.content_list_action_float').slideUp(200);
		}
		
	});
	
	$('.modify_only').click(function(){
//		
		TJDataCenter.set('modify_only' , this.checked ? 1 : 0),
		
		dataQueryObject.queryQuestionData();
//		
//		for(var i = 0 ; i < data.length ; i++ ){
//			
//			if(this.checked){
//				$('.question_template[gid='+data[i].gid+']').hide();
//			}else{
//				$('.question_template[gid='+data[i].gid+']').show();
//			}
//			
//		}
//		
//		
//		
	});
	
});

