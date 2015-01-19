/**
 * 校对页面数据处理中心
 * @Author By TonyJiang
 */

var queryDelay = null;

TJDataCenter._urldata['type'] = TJDataCenter._urldata['type'] ? TJDataCenter._urldata['type'] : 2;

var leftPrefix = 'setin';

var rightPrefix = 'question';

//数据查询和提交对象
dataQueryObject = {
	
	queryTreeData : function(config){
		
		var searchType = TJDataCenter.get('current_search_group');
		
		var section = TJDataCenter.get(searchType+'_section');
		var subject = TJDataCenter.get(searchType+'_subject');
		var year = TJDataCenter.get(searchType+'_year');
		var area = TJDataCenter.get(searchType+'_area');
		var zhenti = TJDataCenter.get(searchType+'_zhenti');
		var publisher = TJDataCenter.get(searchType+'_publisher');
		var book = TJDataCenter.get(searchType+'_book');
		var curriculumn_version = TJDataCenter.get(searchType+'_curriculumn_version');
		
		var queryFlag = true;
		
		var type = searchType == 'setin' ? parseInt(TJDataCenter._urldata['type']) : TJDataCenter.get('current_question_search_type');
		
		switch(parseInt(type)){
			case 1 :
				if(section + subject + year + area + zhenti == 0){
					queryFlag = false;
				}
			
				break;
			
			case 2 :
				if(book == 0 || curriculumn_version == 0){
					console.log('not pass');
					queryFlag = false;
				}
				break;
				
			case 3 :
				if(curriculumn_version == 0){
					queryFlag = false;
				}
			
				break;
				
			case 4 :
				if(curriculumn_version == 0){
					queryFlag = false;
				}
				
				break;
				
			default:
				queryFlag = false;
				break;
		}
		
		if(!queryFlag){
			console.log('xxx');
			data = [];
			$('.'+searchType+'_tree').html('').append(TJTree.treeRender(data));
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
			book : book ,
			cv : curriculumn_version
		};
		
		for(var i in config){
			queryData[i] = config[i];
		}
		console.log('?');
		
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
				
	//			TJTree.treeEventBind();
			},
			error : function(){
				var data = [];
				var e = new TJEvent.EventObject('query_tree_success');
				e.data.treeData = data;
				TJEvent.dispatch(e);
				
				
			}
		});
		
	},
	
	queryQuestionData : function(config){
		
		var queryData = {
			subject : TJDataCenter.get(rightPrefix+'_subject'),
			type : $('.select_question_tab .content_tab_select').attr('type'),
			version: TJDataCenter.get(rightPrefix+'_curriculumn_version'),
			
			
			filter_subject : TJDataCenter.get(leftPrefix+'_subject'),
			offset : pagerHandler.offset,
			step : pagerHandler.step
		};
		
		for(var i in config){
			queryData[i] = config[i];
		}
		
		
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/base/question_api.php?action=list',
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
	
	querySetinQuestionData : function(config){
		
		var queryData = {
			subject : TJDataCenter.get(leftPrefix+'subject'),
			type : $('.setin_question_tab .content_tab_select').attr('type'),
			cv : TJDataCenter.get(leftPrefix+'curriculumn_version'),
//			offset : pagerHandler.offset,
//			step : pagerHandler.step
			offset : 0,
			step : 1000
		};
		
		if(!queryData.cv){
			alert('请选择版本');
			return;
		}
		
		for(var i in config){
			queryData[i] = config[i];
		}
		
		
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/source/question_api.php?action=list',
			'type' : 'GET',
			'dataType' : 'jsonp',
			'data' : queryData,
			success : function(data){
				console.log(data);
//				var count = data.count;
//				var max_gid = data.max_gid;
//				var childData = data.children;
//				var data = data.data;
				
//				if(max_gid){
//					var maxGidArray = max_gid.split('_');
//					
//					var id_pre = maxGidArray[0];
//					
//					if(maxGidArray.length > 2){
//						var _max = parseInt(maxGidArray[2])+1;
//					}else{
//						var _max = 1;
//					}
//					
//					TJDataCenter.set('new_index' , _max.pad(6));
//				}
				
				
//				TJDataCenter.set('question_data' , data);
//				TJDataCenter.set('question_child_data' , childData);
//				TJDataCenter.set('question_count' , count);
//				
//				questionTemplateObject.setData(data , childData);
//	//			console.log(data);
//				questionTemplateObject.show();
//				
//				pagerHandler.setTotalCount(count);
//				
//				var e = new TJEvent.EventObject('question_list_show_success');
//				TJEvent.dispatch(e);
				
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
				subject : TJDataCenter.get(rightPrefix+'subject'),
				section : TJDataCenter.get(rightPrefix+'section')
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
		
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/source/knowledge_api.php?action=list',
			'type' : 'GET',
			'dataType' : 'jsonp',
			'data' : {
				subject : TJDataCenter.get(rightPrefix+'subject')
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
	
	queryPublisherData : function(){
		
		var prefix = TJDataCenter.get('current_search_group')+'_' == leftPrefix ? leftPrefix : rightPrefix;
		
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/source/book_api.php?action=publisher',
			'type' : 'GET',
			'dataType' : 'jsonp',
			'data' : {
				subject : TJDataCenter.get(prefix+'subject'),
				grade : TJDataCenter.get(prefix+'grade')
			},
			success : function(data){
				if(data){
					TJDataCenter.set('current_publisher_info' , data);
					
					var e = new TJEvent.EventObject('query_publisher_success');
					e.data.info = data;
					TJEvent.dispatch(e);
					
				}else{
					var e = new TJEvent.EventObject('ajax_error');
					e.data.source = 'setin_data_handler.js queryPublisherData()';
					TJEvent.dispatch(e);
				}
				
			},
			error : function(){
				var e = new TJEvent.EventObject('ajax_error');
				e.data.source = 'setin_data_handler.js queryPublisherData()';
				TJEvent.dispatch(e);
			}
		});
		
	},
	
	queryBookData : function(){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/source/book_api.php?action=book',
			'type' : 'GET',
			'dataType' : 'jsonp',
			'data' : {
				subject : TJDataCenter.get(TJDataCenter.get('current_search_group')+'_subject'),
				grade : TJDataCenter.get(TJDataCenter.get('current_search_group')+'_grade'),
				publisher : TJDataCenter.get(TJDataCenter.get('current_search_group')+'_publisher')
			},
			success : function(data){
				if(data){
					TJDataCenter.set('current_book_info' , data);
					
					var e = new TJEvent.EventObject('query_book_success');
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

dataQueryObject.leftSearch = {
	
	queryTreeData : function(config){
		var section = TJDataCenter.get(leftPrefix+'_section');
		var subject = TJDataCenter.get(leftPrefix+'_subject');
		var year = TJDataCenter.get(leftPrefix+'_year');
		var area = TJDataCenter.get(leftPrefix+'_area');
		var zhenti = TJDataCenter.get(leftPrefix+'_zhenti');
		var publisher = TJDataCenter.get(leftPrefix+'_publisher');
		var book = TJDataCenter.get(leftPrefix+'_book');
		
		var queryFlag = true;
		
		var type = TJDataCenter.get('current_setin_search_type');
		
		switch(parseInt(type)){
			case 1 :
				if(section + subject + year + area + zhenti == 0){
					queryFlag = false;
				}
			
				break;
			
			case 2 :
				if(subject == 0 || book == 0){
					queryFlag = false;
				}
				break;
				
			default:
				queryFlag = false;
				break;
		}
		
		if(!queryFlag){
			data = [];
			$('.'+leftPrefix+'_tree').html('').append(TJTree.treeRender(data));
			return;
		}
		
		var queryData = {
			type : type,
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
				
	//			TJTree.treeEventBind();
			},
			error : function(){
				var data = [];
				var e = new TJEvent.EventObject('query_tree_success');
				e.data.treeData = data;
				TJEvent.dispatch(e);
				
				
			}
		});
	}
	
};

dataQueryObject.rightSearch = {
	
	queryTreeData : function(config){
		
		var version = TJDataCenter.get(rightPrefix+'_curriculumn_version');
		var section = TJDataCenter.get(rightPrefix+'_section');
		var subject = TJDataCenter.get(rightPrefix+'_subject');
		var year = TJDataCenter.get(rightPrefix+'_year');
		var area = TJDataCenter.get(rightPrefix+'_area');
		var zhenti = TJDataCenter.get(rightPrefix+'_zhenti');
		var publisher = TJDataCenter.get(rightPrefix+'_publisher');
		var book = TJDataCenter.get(rightPrefix+'_book');
		
		var queryFlag = true;
		
		var type = TJDataCenter.get('current_question_search_type');
		
		switch(parseInt(type)){
			case 1 :
				if(section + subject + year + area + zhenti == 0){
					queryFlag = false;
				}
			
				break;
			
			case 2 :
				if(subject == 0 || book == 0 || version == 0){
					queryFlag = false;
				}
				break;
				
			case 3 :
				if(version == 0 || subject == 0 || section == 0){
					queryFlag = false;
				}
			
				break;
				
			default:
				queryFlag = false;
				break;
		}
		
		if(!queryFlag){
			data = [];
			$('.'+rightPrefix+'_tree').html('').append(TJTree.treeRender(data));
		//	TJTree.treeEventBind();
			return;
		}
		
		var queryData = {
			type : type,
			section : section,
			subject : subject,
			year : year,
			area : area,
			zhenti : zhenti,
			publisher : publisher,
			book : book ,
			version : version
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
				
	//			TJTree.treeEventBind();
			},
			error : function(){
				var data = [];
				var e = new TJEvent.EventObject('query_tree_success');
				e.data.treeData = data;
				TJEvent.dispatch(e);
				
				
			}
		});
		
	}
	
	
};

dataSubmitObject = {
	
	insertChapterElements : function(insertArray , insertElementID){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/base/question_api.php?action=setin_chapter',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				inserts : insertArray,
				element : insertElementID,
				subject : TJDataCenter.get(leftPrefix+'_subject')
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
	}
	
};




/************* START 搜索条件改变监听 START *************/




/**       START     左侧搜索条改变的监听         START        **/

TJEvent.addListener('subject_change' , function(e){
	if(e.data.group != 'setin'){
		return;
	}
	clearTimeout(queryDelay);
	queryDelay = setTimeout(function(){
			dataQueryObject.leftSearch.queryTreeData();
	},100);
});

TJEvent.addListener('section_change' , function(e){
	if(e.data.group != 'setin'){
		return;
	}
	clearTimeout(queryDelay);
	queryDelay = setTimeout(function(){
			dataQueryObject.leftSearch.queryTreeData();
	},100);
});

TJEvent.addListener('year_change' , function(e){
	if(e.data.group != 'setin'){
		return;
	}
	clearTimeout(queryDelay);
	queryDelay = setTimeout(function(){
			dataQueryObject.leftSearch.queryTreeData();
	},100);
});

TJEvent.addListener('area_change' , function(e){
	if(e.data.group != 'setin'){
		return;
	}
	clearTimeout(queryDelay);
	queryDelay = setTimeout(function(){
			dataQueryObject.leftSearch.queryTreeData();
	},100);
});

TJEvent.addListener('zhenti_change' , function(e){
	if(e.data.group != 'setin'){
		return;
	}
	clearTimeout(queryDelay);
	queryDelay = setTimeout(function(){
			dataQueryObject.leftSearch.queryTreeData();
	},100);
});



TJEvent.addListener('book_change' , function(e){
	if(e.data.group != 'setin'){
		return;
	}
	if(TJDataCenter.get(leftPrefix + '_book') != 0){
		clearTimeout(queryDelay);
		queryDelay = setTimeout(function(){
				dataQueryObject.leftSearch.queryTreeData();
		},100);
	}
});


/**       END     左侧搜索条改变的监听         END        **/






/**       START     右侧搜索条改变的监听         START        **/


TJEvent.addListener('subject_change' , function(e){
	if(e.data.group != 'question'){
		return;
	}

	clearTimeout(queryDelay);
	queryDelay = setTimeout(function(){
		dataQueryObject.queryKnowledgeData();
	},100);
	
});

TJEvent.addListener('section_change' , function(){
	if(e.data.group != 'question'){
		return;
	}
	
	clearTimeout(queryDelay);
	queryDelay = setTimeout(function(){
		dataQueryObject.queryQuestionTypeData();
		dataQueryObject.queryKnowledgeData();
	},100);
	
});

TJEvent.addListener('book_change' , function(e){
	if(e.data.group != 'question'){
		return;
	}
	if(TJDataCenter.get(rightPrefix + '_book') != 0){
		clearTimeout(queryDelay);
		queryDelay = setTimeout(function(){
				dataQueryObject.rightSearch.queryTreeData();
		},100);
	}
});


/**       END     右侧搜索条改变的监听         END        **/








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
		if(tmpDataArray[0]){
			treeData.push({id : -1 , name : '专题树' , children : tmpDataArray[0]  ,  attributes : {level : 0 , parent_id : 0 , sort_id : 0}});
		}else{
			treeData.push({id : -1 , name : '暂无数据' , children : []  ,  attributes : {level : 0 , parent_id : 0 , sort_id : 0}});
		}
		
	}else{
		treeData = e.data.treeData;
	}
	
	var ev = new TJEvent.EventObject('refresh_tree');
	ev.data.treeData = treeData;
	ev.data.classSelector = '.'+TJDataCenter.get('current_search_group')+'_tree';
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

TJEvent.addListener('insert_question_success' , function(e){
	
	alert('插入成功');
	dataQueryObject.queryQuestionData({element_id:TJDataCenter.get('question_tree_element_id') , filter_id : TJDataCenter.get('setin_tree_element_id')});

});

TJEvent.addListener('question_list_show_success' , function(){
	$('.setting_td').hide();
});

TJEvent.addListener('reload_tree_data' , function(){
	dataQueryObject.queryTreeData();
});

/************* END 搜索条件改变监听 END *************/

TJEvent.addListener('pager_change' , function(e){
	if(TJDataCenter.get('pager_offset') == e.data.offset && TJDataCenter.get('pager_step') == e.data.step){
		return;
	}
//	console.log(TJDataCenter.get('pager_offset'), e.data.offset , TJDataCenter.get('pager_step') , e.data.step);
	TJDataCenter.set('pager_offset' , e.data.offset);
	TJDataCenter.set('pager_step' , e.data.step);
	
	dataQueryObject.queryQuestionData({element_id:TJDataCenter.get('question_tree_element_id') , filter_id : TJDataCenter.get('setin_tree_element_id')});
	
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
	if(e.data.group == 'setin_tree'){
		
		dataQueryObject.querySetinQuestionData({element_id : TJDataCenter.get('setin_tree_element_id')});
	
	
		var ev = new TJEvent.EventObject('popup_show');
		ev.data.name = 'insource_show';
		TJEvent.dispatch(ev);
		
	}
	
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


TJEvent.addListener('update_question_success' , function(e){
	
	alert('修改成功');
	
	$('.question_template:visible').remove();
	
	dataQueryObject.queryQuestionData({element_id:TJDataCenter.get('question_tree_element_id') , filter_id : TJDataCenter.get('setin_tree_element_id')});
	
});

TJEvent.addListener('tree_element_selected' , function(e){
	if( e.data.group == 'question_tree' ){
		if(TJDataCenter.get('question_tree_element_id') != e.data.id){
			
			//先重置pager
//			var e1 = new TJEvent.EventObject('pager_reset');
//			TJEvent.dispatch(e1);
			
			TJDataCenter.set('question_tree_element_id' , e.data.id);
			
			dataQueryObject.queryQuestionData({element_id:TJDataCenter.get('question_tree_element_id') , filter_id : TJDataCenter.get('setin_tree_element_id')});
		}
		
	}else if(e.data.group == 'setin_tree'){
		
		//先重置pager
//		var e1 = new TJEvent.EventObject('pager_reset');
//		TJEvent.dispatch(e1);
		
		TJDataCenter.set('setin_tree_element_id' , e.data.id);
		
		if(TJDataCenter.get('question_tree_element_id') != 0){
			dataQueryObject.queryQuestionData({element_id:TJDataCenter.get('question_tree_element_id') , filter_id : TJDataCenter.get('setin_tree_element_id')});
		}

	}
	
	
});

TJEvent.addListener('setout_question_success' , function(e){
	
	alert('出库成功');
	
	dataQueryObject.queryQuestionData({element_id:TJDataCenter.get('question_tree_element_id') , filter_id : TJDataCenter.get('setin_tree_element_id')});
	
});

TJEvent.addListener('setout_knowledge_success' , function(e){
	
	alert('出库成功');
	
	dataQueryObject.queryQuestionData({element_id:TJDataCenter.get('question_tree_element_id') , filter_id : TJDataCenter.get('setin_tree_element_id')});

});

TJEvent.addListener('setout_zhuanti_success' , function(e){
	
	alert('出库成功');
	
	dataQueryObject.queryQuestionData({element_id:TJDataCenter.get('question_tree_element_id') , filter_id : TJDataCenter.get('setin_tree_element_id')});

});


TJEvent.addListener('tree_element_dbclick' , function(e){
	
	
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
	
	var insertElement = TJDataCenter.get('setin_tree_selected_tree_element');
	
	if(TJDataCenter._urldata['type'] == 1){//插入试卷
		if(!insertElement){
			alert('请选择试卷');
			return;
		}
		
		var insertElementID = insertElement.attr('elementid');
		
//		dataSubmitObject.insertExamElements(insertArray , insertElementID);
		
	}else if(TJDataCenter._urldata['type'] == 2){//插入章节
		
//		if(!insertElement || !TJTree.checkTail()){
		if(!insertElement){
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
		
//		var insertElementID = insertElement.attr('elementid');
		
		dataSubmitObject.insertZhuantiElements(insertArray , insertElementID);
		
	}
	
});

$(document).delegate('.setin_question_tab .content_tab' , 'click' , function(){
	console.log('xxx');
	$('.setin_question_tab .content_tab_select').removeClass('content_tab_select');
	$(this).addClass('content_tab_select');
	
	var type = $(this).attr('type');
	
	TJDataCenter.set('current_setin_search_type' , type);
	
	switch( parseInt(type) ){
		
		case 1:
			
			TJSearchBar.allhide('setin');
			TJSearchBar.show('setin' , [{key : 'subject' , value : 0} , {key : 'section' , value : 0} , {key : 'year' , value : 0} , {key : 'area' , value : 0} , {key : 'zhenti_flag' , value : 0} , ]);
	
		
			break;
		 
		case 2:
			
			TJSearchBar.allhide('setin');
			TJSearchBar.show('setin' , [{key : 'subject' , value : 0} , {key : 'section' , value : 0} , {key : 'grade' , value : 0} , {key : 'publisher' , value : 0} , {key : 'book' , value : 0}]);
		
			break;
			
		case 3:
		
			TJSearchBar.allhide('setin');
			TJSearchBar.show('setin' , [{key : 'subject' , value : 0} , {key : 'section' , value : 0}]);

		
			break;
			
		case 4:
			break;
		
	}
});

TJDataCenter.set('current_setin_search_type' , 2);

$(document).delegate('.select_question_tab .content_tab' , 'click' , function(){
	
	$('.select_question_tab .content_tab_select').removeClass('content_tab_select');
	$(this).addClass('content_tab_select');
	
	var type = $(this).attr('type');
	
	TJDataCenter.set('current_question_search_type' , type);
	
	switch( parseInt(type) ){
		
		case 1:
			
			TJSearchBar.allhide('question');
			TJSearchBar.show('question' , [{key : 'subject' , value : 0} , {key : 'section' , value : 0} , {key : 'year' , value : 0} , {key : 'area' , value : 0} , {key : 'zhenti_flag' , value : 0} , ]);
	
		
			break;
		 
		case 2:
			
			TJSearchBar.allhide('question');
			TJSearchBar.show('question' , [{key : 'subject' , value : 0} , {key : 'section' , value : 0} , {key : 'grade' , value : 0} , {key : 'publisher' , value : 0} , {key : 'book' , value : 0} , {key : 'curriculumn_version' , value : 0}]);
		
			break;
			
		case 3:
		
			TJSearchBar.allhide('question');
			TJSearchBar.show('question' , [{key : 'subject' , value : 0} , {key : 'section' , value : 0} , {key : 'curriculumn_version' , value : 0}]);

		
			break;
			
		case 4:
			break;
		
	}
});
 
 TJDataCenter.set('current_question_search_type' , 2);
 
 
 var heightFixInterval = setInterval(function(){
 	var currentHeight = $('.main_wrapper').height();
	var innerHeight = Math.max($('.content_element_left').height() , $('.content_element_middle').height() , $('.content_element_right').height())+10;
	if(currentHeight != innerHeight){
		$('.main_wrapper').height(innerHeight);
	}
	
 },100);
 
 
 