/**
 * 校对页面数据处理中心
 * @Author By TonyJiang
 */

var queryDelay = null;

TJDataCenter._urldata['type'] = TJDataCenter._urldata['type'] ? TJDataCenter._urldata['type'] : 1;

//数据查询和提交对象
dataQueryObject = {
	
	queryTreeData : function(config){
		
		questionTemplateObject.clear();
		
		var section = TJDataCenter.get('section');
		var subject = TJDataCenter.get('subject');
		var year = TJDataCenter.get('year');
		var area = TJDataCenter.get('area');
		var zhenti = TJDataCenter.get('zhenti');
		var publisher = TJDataCenter.get('publisher');
		var book = TJDataCenter.get('book');
		
		var queryFlag = true;
		
		switch(parseInt(TJDataCenter._urldata['type'])){
			case 1 :
				if(section + subject + year + area + zhenti == 0){
					queryFlag = false;
				}
			
				break;
			
			case 2 :
				if(book == 0){
					queryFlag = false;
				}
				break;
				
			case 3 :
			
				break;
				
			case 4 :
				
				break;
				
			default:
				queryFlag = false;
				break;
		}
		
		if(!queryFlag){
			data = [{id :0 , name : '暂无数据' , children : []}];
			$('#treeNavDIV').html('').append(TJTree.treeRender(data));
		//	TJTree.treeEventBind();
			return;
		}
		
		var queryData = {
			type : TJDataCenter._urldata['type'],
			section : section,
			subject : subject,
			year : year,
			area : area,
			zhenti : zhenti,
			publisher : publisher,
			book : book 
		};
		
		for(var i in config){
			queryData[i] = config[i];
		}
		
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/source/tree_data.php',			
			'type' : 'GET',
			'dataType' : 'jsonp',
			'data' : queryData,
			success : function(data){
				if(!data || data.length == 0){
					data = [{id :0 , name : '暂无数据' , children : []}];
				}
				var e = new TJEvent.EventObject('query_tree_success');
				e.data.treeData = data;
				TJEvent.dispatch(e);
				
	//			TJTree.treeEventBind();
			},
			error : function(){
			}
		});
		
	},
	
	queryQuestionData : function(config){
		
		questionTemplateObject.clear();
		
		var queryData = {
			subject : TJDataCenter.get('subject'),
			type : TJDataCenter._urldata['type'],
			offset : pagerHandler.offset,
			step : pagerHandler.step
		};
		
		for(var i in config){
			queryData[i] = config[i];
		}
		
		
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/isource/question_api.php?action=list',
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
	
	queryExamInfoData : function(exam_id){
		
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/source/exam_api.php?action=info',
			'type' : 'GET',
			'dataType' : 'jsonp',
			'data' : {
				exam_id : exam_id
			},
			success : function(data){
				if(data){
					TJDataCenter.set('current_exam_info' , data);
					
					var e = new TJEvent.EventObject('query_exam_info_success');
					e.data.info = data;
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
	
	queryQuestionByID : function(){
		var subject = TJDataCenter.get('subject');
		var gid = TJDataCenter.get('gid');
		
		if(!subject){
			alert('请选择学科');
			return;
		}
		
		if(!gid){
			alert('请输入题目ID');
			return;
		}
		
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/isource/question_api.php?action=query_by_id',
			'type' : 'GET',
			'dataType' : 'jsonp',
			'data' : {
				subject : subject,
				question : gid
			},
			success : function(data){
				if(data){
					TJDataCenter.set('current_question_list' , data);
					
					questionTemplateObject.setData(data , []);
	//			console.log(data);
					questionTemplateObject.show();
					
					pagerHandler.setTotalCount(data.length);
					
					var e = new TJEvent.EventObject('query_question_by_id_success');
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
		
		
	}
	
};

dataSubmitObject = {
	
	newExam : function(examInfo){
		
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/source/exam_api.php?action=new',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				examinfo : examInfo
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('new_exam_success');
					TJEvent.dispatch(e);
				}else{
					var e = new TJEvent.EventObject('new_exam_failed');
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('new_exam_failed');
				TJEvent.dispatch(e);
			}
		});
		
	},
	
	modifyExam : function(examInfo){
		
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/source/exam_api.php?action=modify',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				examinfo : examInfo
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('modify_exam_success');
					TJEvent.dispatch(e);
				}else{
					var e = new TJEvent.EventObject('modify_exam_failed');
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('modify_exam_failed');
				TJEvent.dispatch(e);
			}
		});
		
	},
	
	modifyQuestions : function(questions){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/isource/question_api.php?action=modify',
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
	
	removeQuestion : function(question_id){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/isource/question_api.php?action=remove',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				subject : TJDataCenter.get('subject'),
				section : TJDataCenter.get('section'),
				question_id : question_id
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('remove_question_success');
					TJEvent.dispatch(e);
				}else{
					var e = new TJEvent.EventObject('remove_question_failed');
					e.data.content = 'dataSubmitObject.removeQuestion()';
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('remove_question_failed');
				e.data.content = 'dataSubmitObject.removeQuestion()';
				TJEvent.dispatch(e);
			}
		});
	},
	
	removeExamElements : function(removeArray , exam_id){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/source/question_api.php?action=setout_exam',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				subject  : TJDataCenter.get('subject'),
				removes : removeArray,
				element : exam_id
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('setout_question_success');
					TJEvent.dispatch(e);
				}else{
					var e = new TJEvent.EventObject('setout_question_failed');
					e.data.content = 'dataSubmitObject.removeElements()';
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('setout_question_failed');
				e.data.content = 'dataSubmitObject.removeElements()';
				TJEvent.dispatch(e);
			}
		});
		
	},
	
	removeChapterElements : function(removeArray , chapter_id){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/source/question_api.php?action=setout_chapter',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				removes : removeArray,
				element : chapter_id,
				subject : TJDataCenter.get('subject')
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('setout_question_success');
					TJEvent.dispatch(e);
				}else{
					var e = new TJEvent.EventObject('setout_question_failed');
					e.data.content = 'dataSubmitObject.removeElements()';
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('setout_question_failed');
				e.data.content = 'dataSubmitObject.removeElements()';
				TJEvent.dispatch(e);
			}
		});
	},
	
	removeKnowledgeElements : function(removeArray , knowledge_id){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/source/question_api.php?action=setout_knowledge',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				removes : removeArray,
				element : knowledge_id,
				subject : TJDataCenter.get('subject')
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('setout_knowledge_success');
					TJEvent.dispatch(e);
				}else{
					var e = new TJEvent.EventObject('setout_knowledge_failed');
					e.data.content = 'dataSubmitObject.removeKnowledgeElements()';
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('setout_knowledge_failed');
				e.data.content = 'dataSubmitObject.removeKnowledgeElements()';
				TJEvent.dispatch(e);
			}
		});
	},
	
	removeZhuantiElements : function(removeArray , zhuanti_id){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/source/question_api.php?action=setout_zhuanti',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				removes : removeArray,
				element : zhuanti_id,
				subject : TJDataCenter.get('subject')
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('setout_zhuanti_success');
					TJEvent.dispatch(e);
				}else{
					var e = new TJEvent.EventObject('setout_zhuanti_failed');
					e.data.content = 'dataSubmitObject.removeZhuantiElements()';
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('setout_zhuanti_failed');
				e.data.content = 'dataSubmitObject.removeZhuantiElements()';
				TJEvent.dispatch(e);
			}
		});
	}
	
};




/************* START 搜索条件改变监听 START *************/
TJEvent.addListener('section_change' , function(){
	clearTimeout(queryDelay);
	queryDelay = setTimeout(function(){
		dataQueryObject.queryTreeData();
		dataQueryObject.queryKnowledgeData();
		dataQueryObject.queryQuestionTypeData();
	},100);
});

TJEvent.addListener('subject_change' , function(){
	clearTimeout(queryDelay);
	queryDelay = setTimeout(function(){
		dataQueryObject.queryTreeData();
		dataQueryObject.queryKnowledgeData();
	},100);
	
});

TJEvent.addListener('year_change' , function(){
	clearTimeout(queryDelay);
	queryDelay = setTimeout(function(){
		dataQueryObject.queryTreeData();
	},100);
});

TJEvent.addListener('area_change' , function(){
	clearTimeout(queryDelay);
	queryDelay = setTimeout(function(){
		dataQueryObject.queryTreeData();
	},100);
});


TJEvent.addListener('zhenti_change' , function(){
	clearTimeout(queryDelay);
	queryDelay = setTimeout(function(){
		dataQueryObject.queryTreeData();
	},100);
});

TJEvent.addListener('book_change' , function(){
	if(TJDataCenter.get('book') != 0){
		clearTimeout(queryDelay);
		queryDelay = setTimeout(function(){
			if(TJDataCenter.get('book') != 0){
				dataQueryObject.queryTreeData();
			}
		},100);
	}
});

TJEvent.addListener('gid_change' , function(e){
	dataQueryObject.queryQuestionByID();
});


TJEvent.addListener('query_tree_success' , function(e){
	
	var treeData = [];
	if(TJDataCenter._urldata['type'] == 3 || TJDataCenter._urldata['type'] == 4){
		
		var max = 0;
		var data = e.data.treeData;
		
		//计算最大层数
		for(var i = 0 ; i < data.length ; i++){
			max = Math.max(max , data[i].level);
		}
		
		var tmpDataArray = [];
		
		//将数据按层次拆分
		for(var i = 0 ; i < max ; i ++){
			tmpDataArray[i] = [];
			
			for(var j = 0 ; j < data.length ; j++){
				
				if(data[j].level == i+1){
					
					tmpDataArray[i].push({
						id:data[j].id , 
						name:data[j].name , 
						parent_id : data[j].parent_id , 
						children : []  , 
						attributes : {
							level : data[j].level , 
							parent_id : data[j].parent_id , 
							sort_id : data[j].sort_id , 
							grade_id : data[j].grade_id
						}
					});
					
				}
			}
		}
		
		//从底层开始寻找元素的父节点
		for(var i = tmpDataArray.length - 1 ; i >= 0 ; i--){
			//遍历当前层
			for(var j = 0 ; j < tmpDataArray[i].length ; j++){
				//如果不是第一层，索引值比层数小1，所以用大于0判断而不是大于1
				if(i > 0){
					//遍历当前层的上一层
					for(var k = 0 ; k < tmpDataArray[i-1].length ; k++){
						//如果当前层当前元素是上一层当前元素的子元素，则赋值,退出循环 
						if(tmpDataArray[i][j].parent_id == tmpDataArray[i-1][k].id){
							tmpDataArray[i-1][k].children.push(tmpDataArray[i][j]);
							break;
						}
					}
				}
			}
		}
		
		//都插入以后，第一层就是所需结果
//		treeData = tmpDataArray[0];
		treeData.push({id : -1 , name : '知识点树' , children : tmpDataArray[0] ,  attributes : {level : 0 , parent_id : 0 , sort_id : 0}});
		
	}else{
		treeData = e.data.treeData;
	}
	
	var ev = new TJEvent.EventObject('refresh_tree');
	ev.data.treeData = treeData;
	ev.data.classSelector = '.treeClass';
	TJEvent.dispatch(ev);
	
});

TJEvent.addListener('query_publisher_success' , function(e){
	
	var ev = new TJEvent.EventObject('search_bar_publisher_update');
	ev.data.info = e.data.info;
	TJEvent.dispatch(ev);
	
});

TJEvent.addListener('query_book_success' , function(e){
	
	var ev = new TJEvent.EventObject('search_bar_book_update');
	ev.data.info = e.data.info;
	TJEvent.dispatch(ev);
	
});

TJEvent.addListener('reload_tree_data' , function(){
	dataQueryObject.queryTreeData();
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
	
	var data = e.data.info;
	
	for(var i = 0 ; i < data.length ; i++){
		if(data[i].action == 2){
			$('.question_template[gid='+data[i].gid+']').find('.seal_modify').show();;		
		}else if(data[i].action == 3){
			$('.question_template[gid='+data[i].gid+']').find('.seal_delete').show();;		
		}
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


TJEvent.addListener('add_exam_submit',function(e){
	var examinfo = {};
	examinfo.section = e.data.exam_section;
	examinfo.subject = e.data.exam_subject;
	examinfo.year = e.data.exam_year;
	examinfo.area = e.data.exam_area;
	examinfo.zhenti = e.data.exam_zhenti;
	examinfo.name = e.data.exam_name;
	examinfo.time = e.data.exam_time;
//	console.log(examinfo);
	
	dataSubmitObject.newExam(examinfo);
	
});

TJEvent.addListener('tree_element_dbclick' , function(e){
	TJEvent.addListenerOnce('query_exam_info_success' , function(e1){
		var e2 = new TJEvent.EventObject('modify_exam_show');
		e2.data.section = e1.data.info.section_id;
		e2.data.subject = e1.data.info.subject_id;
		e2.data.year = e1.data.info.year;
		e2.data.area = e1.data.info.province_id;
		e2.data.exam_type = e1.data.info.exam_type;
		e2.data.exam_name = e1.data.info.name;
		e2.data.exam_time = e1.data.info.exam_time;
		TJEvent.dispatch(e2);
		
	});
	
	dataQueryObject.queryExamInfoData(e.data.id);
	
});


TJEvent.addListener('modify_exam_submit' , function(e){
	
	var examinfo = {};
	examinfo.id = TJDataCenter.get('current_exam_info').id;
	examinfo.section = e.data.exam_section;
	examinfo.subject = e.data.exam_subject;
	examinfo.year = e.data.exam_year;
	examinfo.area = e.data.exam_area;
	examinfo.zhenti = e.data.exam_zhenti;
	examinfo.name = e.data.exam_name;
	examinfo.time = e.data.exam_time;
	
	dataSubmitObject.modifyExam(examinfo);
	
});

TJEvent.addListener('remove_question_success' , function(){
	
	$('.question_template:visible').remove();
	
	dataQueryObject.queryQuestionData({element_id:TJDataCenter.get('tree_element_id')});
});


TJEvent.addListener('update_question_success' , function(e){
	
	alert('修改成功');
	
	$('.question_template:visible').remove();
	
	dataQueryObject.queryQuestionData({element_id:TJDataCenter.get('tree_element_id')});
	
});

TJEvent.addListener('tree_element_selected' , function(e){
	
	if(TJDataCenter.get('tree_element_id') != e.data.id){
		
		//先重置pager
		var e1 = new TJEvent.EventObject('pager_reset');
		TJEvent.dispatch(e1);
		
		TJDataCenter.set('tree_element_id' , e.data.id);
		
		dataQueryObject.queryQuestionData({element_id:TJDataCenter.get('tree_element_id')});
	}
	
});

TJEvent.addListener('setout_question_success' , function(e){
	
	alert('出库成功');
	
	dataQueryObject.queryQuestionData({element_id:TJDataCenter.get('tree_element_id')});
	
});

TJEvent.addListener('setout_knowledge_success' , function(e){
	
	alert('出库成功');
	
	dataQueryObject.queryQuestionData({element_id:TJDataCenter.get('tree_element_id')});

});

TJEvent.addListener('setout_zhuanti_success' , function(e){
	
	alert('出库成功');
	
	dataQueryObject.queryQuestionData({element_id:TJDataCenter.get('tree_element_id')});

});


TJEvent.addListener('tree_element_dbclick' , function(e){
	
	console.log(e.data);
	
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
		
		for(var i in newData){
			
//			if( i == 'question_template'){
//				continue ;
//			}
			
			if(newData[i].toString() != oldData[i].toString()){
//				console.log(i , newData[i] , oldData[i])
				updateData.push(newData);
				break;
			}
		}
//		if(newData.question_content != oldData.question_content || newData.answer_content != oldData.answer_content || newData.analysis_content != oldData.analysis_content){
//			updateData.push($(this).data('newData'));
//		}
		
		
	});
	
	if(updateData.length == 0){
		alert('没有修改，无需保存');
		return;
	}
	
	dataSubmitObject.modifyQuestions(updateData);
	
});

$(document).delegate('.action_setout' , 'click' , function(){
	var removeArray = [];
	$('.check_td:visible .input_check:checked').closest('.question_template').each(function(){
		removeArray.push($(this).attr('gid'));
	});
	if(removeArray.length == 0){
		alert('请选择题目');
		return;
	}
	
	var element_id = TJDataCenter.get('tree_element_id');
	
	
	switch(parseInt(TJDataCenter._urldata['type'])){
		case 1 ://从试卷出库
			dataSubmitObject.removeExamElements(removeArray , element_id);
			break;
			
		case 2 ://从章节出库
			dataSubmitObject.removeChapterElements(removeArray , element_id);
			break;
			
		case 3 ://从专题出库
			dataSubmitObject.removeZhuantiElements(removeArray , element_id);
			break;
			
		case 4 ://知识点
			 alert('知识点目前不支持出库');
			break;
	}
	
});


TJEvent.addListener('nav_toggle' , function(e){
	if(e.data.toggle == 'hide'){
		$('.content_list_action_float').css('left' , '291px');
	}else{
		$('.content_list_action_float').css('left' , '429px');
	}
});

$(document).ready(function(){
	
	if(TJDataCenter._urldata['type'] == 5){
		$('.content_element_left').hide();
		$('.content_element_right').css('left' , '0px');
		$('.action_panel').hide();
	}
	
	$('.content').scroll(function(){
		
		if($('.content').scrollTop()>($('.content_list_action').offset().top+$('.content_list_action').outerHeight())){
			$('.content_list_action_float').slideDown(200);
		}else{
			$('.content_list_action_float').slideUp(200);
		}
		
	});
});


