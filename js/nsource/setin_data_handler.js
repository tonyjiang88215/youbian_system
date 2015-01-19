/**
 * 入库页面数据处理中心
 * @Author By TonyJiang
 */

var queryDelay = null;

TJDataCenter._urldata['type'] = TJDataCenter._urldata['type'] ? TJDataCenter._urldata['type'] : 2;


//数据查询和提交对象
dataQueryObject = {
	
	queryTreeData : function(config){
		var section = TJDataCenter.get('section');
		var subject = TJDataCenter.get('subject');
		var year = TJDataCenter.get('year');
		var area = TJDataCenter.get('area');
		var zhenti = TJDataCenter.get('zhenti');
		var publisher = TJDataCenter.get('publisher');
		var book = TJDataCenter.get('book');
		
		//如果都为0，则表示没有选择，不显示数据
		
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
				
			default:
				queryFlag = false;
				break;
		}
		
		if(!queryFlag){
			data = [];
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
					data = [];
				}
				var e = new TJEvent.EventObject('query_tree_success');
				e.data.treeData = data;
				TJEvent.dispatch(e);
			},
			error : function(){
			}
		});
		
	},
	
	queryQuestionData : function(config){
		
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
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/source/question_api.php?action=list',
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

	queryBatchData : function(){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/source/batch_api.php?action=list',
			'type' : 'GET',
			'dataType' : 'jsonp',
			'data' : {
				subject : TJDataCenter.get('subject'),
				section : TJDataCenter.get('section')
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('query_batch_success');
					e.data = data;
					TJEvent.dispatch(e);
					
				}else{
					var e = new TJEvent.EventObject('ajax_error');
					e.data.source = 'setin_data_handler.js queryBatchData()';
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('ajax_error');
				e.data.source = 'setin_data_handler.js queryBatchData()';
				TJEvent.dispatch(e);
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
				subject : TJDataCenter.get('subject'),
				section : TJDataCenter.get('section')
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
	}
	
	
};

dataSubmitObject = {
	
	resetExam : function(exam_id){
		
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/source/exam_api.php?action=reset',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				subject : TJDataCenter.get('subject'),
				exam_id : exam_id  
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('reset_exam_success');
					e.data.exam_id = exam_id;
					TJEvent.dispatch(e);
				}else{
					var e = new TJEvent.EventObject('reset_exam_failed');
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('reset_exam_failed');
				TJEvent.dispatch(e);
			}
		});
		
	},
	
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
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/source/question_api.php?action=modify',
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
	
	removeQuestion : function(question_id , type){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/source/question_api.php?action=remove',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				subject : TJDataCenter.get('subject'),
				section : TJDataCenter.get('section'),
				question_id : question_id,
				type : type
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
	
	insertExamElements : function(insertArray , element_id){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/source/question_api.php?action=setin_exam',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				subject : TJDataCenter.get('subject'),
				section : TJDataCenter.get('section'),
				inserts : insertArray,
				element : element_id
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('insert_question_success');
					TJEvent.dispatch(e);
				}else{
					var e = new TJEvent.EventObject('insert_question_failed');
					e.data.content = 'dataSubmitObject.insertElements()';
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('insert_question_failed');
				e.data.content = 'dataSubmitObject.insertElements()';
				TJEvent.dispatch(e);
			}
		});
	},
	
	insertChapterElements : function(insertArray , element_id){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/source/question_api.php?action=setin_chapter',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				inserts : insertArray,
				element : element_id,
				subject : TJDataCenter.get('subject'),
				section : TJDataCenter.get('section')
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('insert_question_success');
					TJEvent.dispatch(e);
				}else{
					var e = new TJEvent.EventObject('insert_question_failed');
					e.data.content = 'dataSubmitObject.insertElements()';
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('insert_question_failed');
				e.data.content = 'dataSubmitObject.insertElements()';
				TJEvent.dispatch(e);
			}
		});
	},
	
	insertKnowledgeElements : function(insertArray , element_id){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/source/question_api.php?action=setin_knowledge',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				inserts : insertArray,
				element : element_id,
				subject : TJDataCenter.get('subject'),
				section : TJDataCenter.get('section')
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('insert_knowledge_success');
					TJEvent.dispatch(e);
				}else{
					var e = new TJEvent.EventObject('insert_knowledge_failed');
					e.data.content = 'dataSubmitObject.insertKnowledgeElements()';
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('insert_knowledge_failed');
				e.data.content = 'dataSubmitObject.insertKnowledgeElements()';
				TJEvent.dispatch(e);
			}
		});
	},
	
	insertZhuantiElements : function(insertArray , element_id){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/source/question_api.php?action=setin_zhuanti',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				inserts : insertArray,
				element : element_id,
				subject : TJDataCenter.get('subject')
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('insert_zhuanti_success');
					TJEvent.dispatch(e);
				}else{
					var e = new TJEvent.EventObject('insert_zhuanti_failed');
					e.data.content = 'dataSubmitObject.insertZhuantiElements()';
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('insert_zhuanti_failed');
				e.data.content = 'dataSubmitObject.insertZhuantiElements()';
				TJEvent.dispatch(e);
			}
		});
	},
	
	finishExam : function(exam_id){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/source/exam_api.php?action=complete',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				exam_id : exam_id,
				type : TJDataCenter._urldata['type']
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('finish_exam_success');
					TJEvent.dispatch(e);
				}else{
					var e = new TJEvent.EventObject('finish_exam_failed');
					e.data.content = 'dataSubmitObject.finishExam()';
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('finish_exam_failed');
				e.data.content = 'dataSubmitObject.finishExam()';
				TJEvent.dispatch(e);
			}
		});
	},
	
	setoutExam : function(exam_id){
		
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/source/exam_api.php?action=setout',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				subject : TJDataCenter.get('subject'),
				type : TJDataCenter._urldata['type'],
				exam_id : exam_id
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('setout_exam_success');
					TJEvent.dispatch(e);
				}else{
					var e = new TJEvent.EventObject('setout_exam_failed');
					e.data.content = 'dataSubmitObject.finishExam()';
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('setout_exam_failed');
				e.data.content = 'dataSubmitObject.finishExam()';
				TJEvent.dispatch(e);
			}
		});
		
	},
	
	insertWordQuestion : function(questionContent){
		
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/source/question_api.php?action=insert_word_data',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				subject : TJDataCenter.get('subject'),
				section : TJDataCenter.get('section'),
				content : questionContent
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('preview_word_success');
					TJEvent.dispatch(e);
				}else{
					var e = new TJEvent.EventObject('preview_word_failed');
					e.data.content = 'dataSubmitObject.finishExam()';
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('preview_word_failed');
				e.data.content = 'dataSubmitObject.finishExam()';
				TJEvent.dispatch(e);
			}
		});
		
		
	}
	
};


/************* START 搜索条件改变监听 START *************/
TJEvent.addListener('section_change' , function(){
	clearTimeout(queryDelay);
	queryDelay = setTimeout(function(){
		dataQueryObject.queryBatchData();
		dataQueryObject.queryTreeData();
		dataQueryObject.queryKnowledgeData();
		dataQueryObject.queryQuestionTypeData();
	},100);
	
	//变更年级的显示
});

TJEvent.addListener('subject_change' , function(){
	clearTimeout(queryDelay);
	queryDelay = setTimeout(function(){
		
		switch(TJDataCenter._urldata['type']){
			case 1 ://直接查询数据
				dataQueryObject.queryTreeData();
				break;
				
			case 2 : //如果是同步，则需要依次查询出版社和教材
				break;
				
			case 3 : //如果是专题，需要依次
				break;
		}
		
		dataQueryObject.queryBatchData();
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
			dataQueryObject.queryTreeData();
		},100);
	}
});

TJEvent.addListener('query_tree_success' , function(e){
	
	var treeData = [];
	if(TJDataCenter._urldata['type'] == 3){
		
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
		treeData = tmpDataArray[0];
//		treeData.push({id : -1 , name : '专题树' , children : tmpDataArray[0] ? tmpDataArray[0] : [] ,  attributes : {level : 0 , parent_id : 0 , sort_id : 0}});
		
	}else{
		treeData = e.data.treeData;
	}
	
	var ev = new TJEvent.EventObject('refresh_tree');
	ev.data.treeData = treeData;
	ev.data.classSelector = '.treeClass';
	TJEvent.dispatch(ev);
	
});

TJEvent.addListener('reload_tree_data' , function(){
	dataQueryObject.queryTreeData();
});

/************* END 搜索条件改变监听 END *************/

/*************  切换导入批次监听  *************/

TJEvent.addListener('in_batch_change' , function(e){
	
//	TJDataCenter.set('current_source' , e.data.source);
//	TJDataCenter.set('current_exam_name' , e.data.exam_name);
//	TJDataCenter.set('current_source_code' , e.data.source_code);

	//先重置pager
	var e = new TJEvent.EventObject('pager_reset');
	TJEvent.dispatch(e);
	
	dataQueryObject.queryQuestionData({setin_id : TJDataCenter.get('setin_exam_id')});
	
});


TJEvent.addListener('exam_reset' , function(e){
	
	dataSubmitObject.resetExam(e.data.exam_id);
	
});

TJEvent.addListener('exam_setout' , function(e){
	
	dataSubmitObject.setoutExam(e.data.exam_id);
	
});


TJEvent.addListener('reset_exam_success' , function(e){
	alert('试卷还原完成');
	
//	dataQueryObject.queryBatchData();

	var exam_id = TJDataCenter.get('reset_exam_id');

	$('.setin_exam[exam_id='+exam_id+']').siblings('.setin_exam_setting').find('.exam_finished').text('完成').addClass('exam_finish').removeClass('exam_finished');

	
	if(e.data.exam_id == TJDataCenter.get('setin_exam_id')){
		dataQueryObject.queryQuestionData({setin_id : TJDataCenter.get('setin_exam_id')});
	}
	
	TJDataCenter.set('reset_exam_id', 0);
	
	
});

TJEvent.addListener('pager_change' , function(e){
	if(TJDataCenter.get('pager_offset') == e.data.offset && TJDataCenter.get('pager_step') == e.data.step){
		return;
	}
//	console.log(TJDataCenter.get('pager_offset'), e.data.offset , TJDataCenter.get('pager_step') , e.data.step);
	TJDataCenter.set('pager_offset' , e.data.offset);
	TJDataCenter.set('pager_step' , e.data.step);
	
	dataQueryObject.queryQuestionData({setin_id : TJDataCenter.get('setin_exam_id')});
	
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

TJEvent.addListener('preview_word_submit' , function(){
	if(!TJDataCenter.get('subject')){
		alert('请选择学科');
		return;
	}
	
	if(!TJDataCenter.get('section')){
		alert('请选择学段');
		return;
	}
	
	dataSubmitObject.insertWordQuestion($('.preview_word_wrapper').html());
	
	
	
});

TJEvent.addListener('update_question_success' , function(e){
	
	alert('修改成功');
	
	$('.question_template:visible').remove();
	
	dataQueryObject.queryQuestionData({setin_id : TJDataCenter.get('setin_exam_id')});
	
});

TJEvent.addListener('insert_question_success' , function(e){
	
	alert('插入成功');
	
	$('.question_template:visible').remove();
	
	dataQueryObject.queryQuestionData({setin_id : TJDataCenter.get('setin_exam_id')});
	
});

TJEvent.addListener('insert_knowledge_success' , function(){
	
	alert('插入成功');
	
	$('.question_template:visible').remove();
	
	dataQueryObject.queryQuestionData({setin_id : TJDataCenter.get('setin_exam_id')});
	
});

TJEvent.addListener('insert_zhuanti_success' , function(){
	
	alert('插入成功');
	
	$('.question_template:visible').remove();
	
	dataQueryObject.queryQuestionData({setin_id : TJDataCenter.get('setin_exam_id')});
	
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

TJEvent.addListener('query_batch_success', function(e){
	
	var data = {};
	for(var i = 0 ; i < e.data.length ; i++){
		if(!data[e.data[i].source]){
			data[e.data[i].source] = [];
		}
		data[e.data[i].source].push(e.data[i]);
	}
	
	
	var finishColumn = {1 : 'exam_finish' , 2 : 'tongbu_finish' , 3 : 'zhuanti_finish'};
	var html = '';
	for(var i in data){
		html += '<div class="setin_batch" >'+i+'</div>';
		html += '<div class="setin_batch_children">';
		if(data[i].length == 0){
			html += '<div class="setin_exam setin_exam_none">暂无数据</div>';
		}else{
			for(var j in data[i]){
				html +='<div class="setin_exam_wrapper">';
				html +=		'<div class="setin_exam" exam_code="'+data[i][j].exam_code+'" exam_id="'+data[i][j].id+'" >'+data[i][j].exam_name+'</div>';
				html += 	'<div class="setin_exam_setting">';
				if(parseInt(data[i][j][finishColumn[TJDataCenter._urldata['type']]]) == 0){
					html +=    '<a class="exam_finish" href="javascript:void(0);">完成</a>';
				}else{
					html +=    '<a class="exam_finished" href="javascript:void(0);">已完成</a>';
				}
				html +=    '<a class="exam_reset" href="javascript:void(0);">重载</a>';
				html +=    '<a class="exam_setout" href="javascript:void(0);">整体出库</a>';
				html += '</div>';
				html +='</div>';
			}
		}
		html += '</div>';
	}
	if(html){
		$('.question_list_setting').html(html).show();
	}else{
		$('.question_list_setting').hide();
	}
	
	questionTemplateObject.clear();
	
});



TJEvent.addListener('modify_exam_success', function(){
	
	alert('修改成功');
});

TJEvent.addListener('finish_exam_success' , function(){
	
	alert('试卷完成');
	
	var exam_id = TJDataCenter.get('finish_exam_id');
	
	$('.setin_exam[exam_id='+exam_id+']').siblings('.setin_exam_setting').find('.exam_finish').text('已完成').removeClass('exam_finish').addClass('exam_finished');

	TJDataCenter.set('finish_exam_id', 0);

	
//	dataQueryObject.queryBatchData();
	
});

TJEvent.addListener('setout_exam_success' , function(){
	
	alert('整体出库完成');
	
	dataQueryObject.queryQuestionData({setin_id : TJDataCenter.get('setin_exam_id')});
	
});

TJEvent.addListener('preview_word_success' , function(){
	
	alert('导入成功');
	
	var e = new TJEvent.EventObject('upload_word_finish');
	TJEvent.dispatch(e);
	
	dataQueryObject.queryBatchData();
	
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
		
		updateData.push($(this).data('newData'));
		
	});
	
	dataSubmitObject.modifyQuestions(updateData);
	
});

$(document).delegate('.action_insert' , 'click' , function(){
	
	var insertArray = [];
	$('.check_td:visible .input_check:checked').closest('.question_template').each(function(){
		insertArray.push($(this).attr('gid'));
	});
	if(insertArray.length == 0){
		alert('请选择题目');
		return;
	}
	
	var insertElement = TJDataCenter.get('origin_tree_selected_tree_element');
	
	if(TJDataCenter._urldata['type'] == 1){//插入试卷
		if(!insertElement){
			alert('请选择试卷');
			return;
		}
		
		var insertElementID = insertElement.attr('elementid');
		
		dataSubmitObject.insertExamElements(insertArray , insertElementID);
		
	}else if(TJDataCenter._urldata['type'] == 2){//插入章节
		
		if(!insertElement || !TJTree.checkTail()){
			alert('请选择章节');
			return;
		}
		
		var insertElementID = insertElement.attr('elementid');
		
		dataSubmitObject.insertChapterElements(insertArray , insertElementID);
		
		
	}else if(TJDataCenter._urldata['type'] == 3){//插入专题
	
		if(!insertElement){
			alert('请选择专题');
			return;
		}
		
		var insertElementID = insertElement.attr('elementid');
		
		dataSubmitObject.insertZhuantiElements(insertArray , insertElementID);
		
	}
	
	
	
});

$(document).delegate('.action_upload' , 'click' , function(){
	if(TJDataCenter.get('subject') == 0 || TJDataCenter.get('section') == 0){
		alert('请先选择学科和学段');
		return;
	}
	var e = new TJEvent.EventObject('upload_word_panel_show');
	TJEvent.dispatch(e);
	
});


$(document).ready(function(){
	
	$('.content').scroll(function(){
		
		if($('.content').scrollTop()>($('.content_list_action').offset().top+$('.content_list_action').outerHeight())){
			$('.content_list_action_float').slideDown(200);
		}else{
			$('.content_list_action_float').slideUp(200);
		}
		
	});
	
});



