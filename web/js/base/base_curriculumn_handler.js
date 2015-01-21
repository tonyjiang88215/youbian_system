//数据查询和提交对象
dataQueryObject = {
	queryCurriculumn : function(){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/base/curriculumn_api.php?action=curriculumn_list',
			'type' : 'GET',
			'dataType' : 'jsonp',
			'data' : {
				offset : pagerHandler.offset,
				step : pagerHandler.step
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('query_curriculumn_success');
					e.data = data;
					TJEvent.dispatch(e);
					
				}else{
					var e = new TJEvent.EventObject('ajax_error');
					e.data.source = 'base_curriculumn_handler.js queryCurriculumn()';
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('ajax_error');
				e.data.source = 'base_curriculumn_handler.js queryCurriculumn()';
				TJEvent.dispatch(e);
			}
		});
	},
	
	queryActive : function(vid){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/base/curriculumn_api.php?action=query_active',
			'type' : 'GET',
			'dataType' : 'jsonp',
			'data' : {
				version : vid
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('query_active_success');
					e.data.active = data;
					e.data.version_id = vid;
					TJEvent.dispatch(e);
					
				}else{
					var e = new TJEvent.EventObject('ajax_error');
					e.data.source = 'base_curriculumn_handler.js queryCurriculumn()';
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('ajax_error');
				e.data.source = 'base_curriculumn_handler.js queryCurriculumn()';
				TJEvent.dispatch(e);
			}
		});
	},
	
	queryDetail : function(vid){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/base/curriculumn_detail_api.php?action=detail_list',
			'type' : 'GET',
			'dataType' : 'jsonp',
			'data' : {
				version : vid
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('query_detail_success');
					e.data.detail = data;
					e.data.version_id = vid;
					TJEvent.dispatch(e);
					
				}else{
					var e = new TJEvent.EventObject('ajax_error');
					e.data.source = 'base_curriculumn_handler.js queryCurriculumn()';
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('ajax_error');
				e.data.source = 'base_curriculumn_handler.js queryCurriculumn()';
				TJEvent.dispatch(e);
			}
		});
	}
	
};

dataSubmitObject = {
	
	addCurriculumn : function(data){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/base/curriculumn_api.php?action=add',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				name : data.name,
				version : data.version , 
				extend : data.extend,
				ref : data.ref
			},
			success : function(data){
				if(data.result){
					var e = new TJEvent.EventObject('add_curriculumn_success');
					e.data = data;
					TJEvent.dispatch(e);
					
				}else{
					var e = new TJEvent.EventObject('ajax_error');
					e.data.source = 'base_curriculumn_handler.js addCurriculumn()';
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('ajax_error');
				e.data.source = 'base_curriculumn_handler.js addCurriculumn()';
				TJEvent.dispatch(e);
			}
		});
	},
	
	activeCurriculumn: function(version_id , activeList){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/base/curriculumn_api.php?action=active',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				version : version_id,
				active : activeList
			},
			success : function(data){
				console.log(data);
				if(data){
					var e = new TJEvent.EventObject('active_curriculumn_success');
					e.data = data;
					TJEvent.dispatch(e);
					
				}else{
					var e = new TJEvent.EventObject('ajax_error');
					e.data.source = 'base_curriculumn_handler.js addCurriculumn()';
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('ajax_error');
				e.data.source = 'base_curriculumn_handler.js addCurriculumn()';
				TJEvent.dispatch(e);
			}
		});
	},
	
	createTongbuChange : function(){
		
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/base/curriculumn_detail_api.php?action=create_tongbu',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				version : TJDataCenter.get('current_curriculumn') , 
				subject : TJDataCenter.get('first_subject'),
				section : TJDataCenter.get('first_section'),
				publisher : TJDataCenter.get('first_publisher'),
				book : TJDataCenter.get('tongbu_new_book')
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('create_detail_success');
					e.data = data;
					TJEvent.dispatch(e);
					
				}else{
					var e = new TJEvent.EventObject('ajax_error');
					e.data.source = 'base_curriculumn_handler.js activeTongbu()';
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('ajax_error');
				e.data.source = 'base_curriculumn_handler.js activeTongbu()';
				TJEvent.dispatch(e);
			}
		});
		
	},
	
	createKnowledgeChange : function(){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/base/curriculumn_detail_api.php?action=create_knowledge',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				version : TJDataCenter.get('current_curriculumn') , 
				subject : TJDataCenter.get('first_subject'),
				section : TJDataCenter.get('first_section'),
				text : TJDataCenter.get('new_knowledge/zhuanti_text')
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('create_detail_success');
					e.data = data;
					TJEvent.dispatch(e);
					
				}else{
					var e = new TJEvent.EventObject('ajax_error');
					e.data.source = 'base_curriculumn_handler.js activeTongbu()';
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('ajax_error');
				e.data.source = 'base_curriculumn_handler.js activeTongbu()';
				TJEvent.dispatch(e);
			}
		});
	},
	
	createZhuantiChange : function(){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/base/curriculumn_detail_api.php?action=create_zhuanti',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				version : TJDataCenter.get('current_curriculumn') , 
				subject : TJDataCenter.get('first_subject'),
				section : TJDataCenter.get('first_section'),
				text : TJDataCenter.get('new_knowledge/zhuanti_text')
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('create_detail_success');
					e.data = data;
					TJEvent.dispatch(e);
					
				}else{
					var e = new TJEvent.EventObject('ajax_error');
					e.data.source = 'base_curriculumn_handler.js activeTongbu()';
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('ajax_error');
				e.data.source = 'base_curriculumn_handler.js activeTongbu()';
				TJEvent.dispatch(e);
			}
		});
	},
	
	setinTongbuData : function(){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/base/curriculumn_detail_api.php?action=setin_tongbu',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				detail : TJDataCenter.get('setin_data_id'),
				to_version : TJDataCenter.get('current_curriculumn') ,
				to_subject : TJDataCenter.get('setin_data_subject') ,
				to_book : TJDataCenter.get('setin_data_book') ,
				from_version : TJDataCenter.get('second_curriculumn_version') , 
				from_subject : TJDataCenter.get('second_subject'),
				from_book : TJDataCenter.get('second_book') , 
				ref : TJDataCenter.get('setin_data_ref')
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('setin_tongbu_success');
					e.data = data;
					TJEvent.dispatch(e);
					
				}else{
					var e = new TJEvent.EventObject('ajax_error');
					e.data.source = 'base_curriculumn_handler.js activeTongbu()';
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('ajax_error');
				e.data.source = 'base_curriculumn_handler.js activeTongbu()';
				TJEvent.dispatch(e);
			}
		});
	},
	
	setinKnowledgeData : function(){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/base/curriculumn_detail_api.php?action=setin_knowledge',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				detail : TJDataCenter.get('setin_data_id'),
				to_version : TJDataCenter.get('current_curriculumn') ,
				to_subject : TJDataCenter.get('setin_data_subject') ,
				to_section : TJDataCenter.get('setin_data_section'),
				from_version : TJDataCenter.get('second_curriculumn_version') , 
				from_subject : TJDataCenter.get('second_subject'),
				from_section : TJDataCenter.get('second_section') ,
				ref : TJDataCenter.get('setin_data_ref')
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('setin_knowledge_success');
					e.data = data;
					TJEvent.dispatch(e);
					
				}else{
					var e = new TJEvent.EventObject('ajax_error');
					e.data.source = 'base_curriculumn_handler.js activeTongbu()';
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('ajax_error');
				e.data.source = 'base_curriculumn_handler.js activeTongbu()';
				TJEvent.dispatch(e);
			}
		});
	},
	
	setinZhuantiData : function(){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/base/curriculumn_detail_api.php?action=setin_zhuanti',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				detail : TJDataCenter.get('setin_data_id'),
				to_version : TJDataCenter.get('current_curriculumn') ,
				to_subject : TJDataCenter.get('setin_data_subject') ,
				to_section : TJDataCenter.get('setin_data_section'),
				from_version : TJDataCenter.get('second_curriculumn_version') , 
				from_subject : TJDataCenter.get('second_subject'),
				from_section : TJDataCenter.get('second_section') ,
				ref : TJDataCenter.get('setin_data_ref')
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('setin_knowledge_success');
					e.data = data;
					TJEvent.dispatch(e);
					
				}else{
					var e = new TJEvent.EventObject('ajax_error');
					e.data.source = 'base_curriculumn_handler.js activeTongbu()';
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('ajax_error');
				e.data.source = 'base_curriculumn_handler.js activeTongbu()';
				TJEvent.dispatch(e);
			}
		});
	},
	
	clearTongbuData : function(){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/base/curriculumn_detail_api.php?action=clear_tongbu',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				detail : TJDataCenter.get('clear_data_id'),
				version : TJDataCenter.get('current_curriculumn') ,
				subject : TJDataCenter.get('clear_data_subject') ,
				book : TJDataCenter.get('clear_data_book') ,
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('clear_tongbu_success');
					e.data = data;
					TJEvent.dispatch(e);
					
				}else{
					var e = new TJEvent.EventObject('ajax_error');
					e.data.source = 'base_curriculumn_handler.js activeTongbu()';
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('ajax_error');
				e.data.source = 'base_curriculumn_handler.js activeTongbu()';
				TJEvent.dispatch(e);
			}
		});
	},
	
	clearKnowledgeData : function(){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/base/curriculumn_detail_api.php?action=clear_knowledge',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				detail : TJDataCenter.get('clear_data_id'),
				version : TJDataCenter.get('current_curriculumn') ,
				subject : TJDataCenter.get('clear_data_subject') ,
				section : TJDataCenter.get('clear_data_section') ,
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('clear_knowledge_success');
					e.data = data;
					TJEvent.dispatch(e);
					
				}else{
					var e = new TJEvent.EventObject('ajax_error');
					e.data.source = 'base_curriculumn_handler.js activeTongbu()';
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('ajax_error');
				e.data.source = 'base_curriculumn_handler.js activeTongbu()';
				TJEvent.dispatch(e);
			}
		});
		
	},
	
	clearZhuantiData : function(){
		
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/base/curriculumn_detail_api.php?action=clear_zhuanti',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				detail : TJDataCenter.get('clear_data_id'),
				version : TJDataCenter.get('current_curriculumn') ,
				subject : TJDataCenter.get('clear_data_subject') ,
				section : TJDataCenter.get('clear_data_section') ,
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('clear_zhuanti_success');
					e.data = data;
					TJEvent.dispatch(e);
					
				}else{
					var e = new TJEvent.EventObject('ajax_error');
					e.data.source = 'base_curriculumn_handler.js activeTongbu()';
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('ajax_error');
				e.data.source = 'base_curriculumn_handler.js activeTongbu()';
				TJEvent.dispatch(e);
			}
		});
	},
	
	deleteDetail : function(){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/base/curriculumn_detail_api.php?action=delete_detail',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				detail : TJDataCenter.get('delete_data_id'),
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('delete_detail_success');
					e.data = data;
					TJEvent.dispatch(e);
					
				}else{
					var e = new TJEvent.EventObject('ajax_error');
					e.data.source = 'base_curriculumn_handler.js activeTongbu()';
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('ajax_error');
				e.data.source = 'base_curriculumn_handler.js activeTongbu()';
				TJEvent.dispatch(e);
			}
		});
	},
	
	completeDetail : function(){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/base/curriculumn_detail_api.php?action=complete_detail',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				detail : TJDataCenter.get('complete_data_id'),
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('complete_detail_success');
					e.data = data;
					TJEvent.dispatch(e);
					
				}else{
					var e = new TJEvent.EventObject('ajax_error');
					e.data.source = 'base_curriculumn_handler.js activeTongbu()';
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('ajax_error');
				e.data.source = 'base_curriculumn_handler.js activeTongbu()';
				TJEvent.dispatch(e);
			}
		});
	}
	
};

TJEvent.addListener('pager_change' , function(){
	console.log('dasdsdas');
	dataQueryObject.queryCurriculumn();
});

TJEvent.addListener('query_curriculumn_success' , function(e){
	pagerHandler.setTotalCount(e.data.count);
	
	$('.version_record:visible').remove();
	
	var data = e.data.data;
	
	for(var i = 0 ; i < data.length ; i++){
		var tpl = $('#version_record_template').clone().attr('version_id' , data[i].id).removeAttr('id');
		tpl.find('.version_id').text(data[i].id);
		tpl.find('.name').text(data[i].name);
		tpl.find('.version').text(data[i].version);
		tpl.find('.extends').text(data[i].extends);
		tpl.find('.update_count').text(data[i].detail_count);
		tpl.appendTo('.version_table').show();
	}
	
});

TJEvent.addListener('add_curriculumn_submit' , function(e){
	dataSubmitObject.addCurriculumn(e.data);
});

TJEvent.addListener('add_curriculumn_success' , function(){
	
	window.location.reload();
	
//	dataQueryObject.queryCurriculumn();
//	
//	var e = new TJEvent.EventObject('add_curriculumn_finish');
//	TJEvent.dispatch(e);
	
});


TJEvent.addListener('query_active_success' , function(e){
	
	var ev = new TJEvent.EventObject('popup_show');
	ev.data.name = 'curriculumn_active';
	ev.data.data = e.data.active;
	ev.data.vid = e.data.version_id;
	
	TJEvent.dispatch(ev);
	
});

TJEvent.addListener('version_active_submit' , function(e){
	
	dataSubmitObject.activeCurriculumn(e.data.vid , e.data.active);
	
});

TJEvent.addListener('active_curriculumn_success' , function(){
	
	alert('激活成功');
	
});


TJEvent.addListener('query_detail_success' , function(e){
	
	console.log(e.data);
	
	var ev = new TJEvent.EventObject('popup_show');
	ev.data.name = 'curriculumn_detail';
	ev.data.data = e.data.detail;
	ev.data.vid = e.data.version_id;
	
	TJEvent.dispatch(ev);
	
	return;
	
	$('.curriculumn_detail_table tr:not(:eq(0))').remove();
	
	var list = TJDataCenter.get('current_detail_info');
	
	var stepLabel = ['创建完毕','数据完毕','修改完毕'];
	for(var i = 0 ; i < list.length ; i++){
		var html = 
		'<tr detail_id="'+list[i].id+'" version_id="'+list[i].version_id+'" subject_id="'+list[i].subject_id+'" section_id="'+list[i].section_id+'" book_id="'+list[i].book_id+'" >'+
			'<td>'+list[i].text+'</td>'+
				'<td>'+stepLabel[list[i].step]+'</td>'+
				'<td>'+
					'<a class="action_tag_a setin_data '+(list[i].step == 0 ? '' : 'unactive')+'" href="javascript:void(0);">导入数据</a>'+
					'<a class="action_tag_a clear_data '+(list[i].step == 1 ? '' : 'unactive')+'" href="javascript:void(0);">清除数据</a>'+
					'<a class="action_tag_a complete_detail '+(list[i].step == 1 ? '' : 'unactive')+'" href="javascript:void(0);">完成</a>'+
					'<a class="action_tag_a delete_detail '+(list[i].step == 0 ? '' : 'unactive')+'" href="javascript:void(0);">删除</a>'+
			'</td>'+
		'</tr>'
		$('.curriculumn_detail_table').append(html);
	}
	
});


//创建新的改变成功
TJEvent.addListener('create_detail_success' , function(){
	
	dataQueryObject.queryDetail();
	
	var e = new TJEvent.EventObject('add_curriculumn_detail_finish');
	TJEvent.dispatch(e);
});

//导入数据成功
TJEvent.addListener('setin_tongbu_success' , function(){
	var e= new TJEvent.EventObject('detail_data_finish');
	TJEvent.dispatch(e);
	
	dataQueryObject.queryDetail();
	
});

//导入数据成功
TJEvent.addListener('setin_knowledge_success' , function(){
	var e= new TJEvent.EventObject('detail_data_finish');
	TJEvent.dispatch(e);
	
	dataQueryObject.queryDetail();
	
});

//清除数据成功
TJEvent.addListener('clear_tongbu_success' , function(){
	dataQueryObject.queryDetail();
});

TJEvent.addListener('clear_knowledge_success' , function(){
	dataQueryObject.queryDetail();
});

TJEvent.addListener('clear_zhuanti_success' , function(){
	dataQueryObject.queryDetail();
});

//删除成功
TJEvent.addListener('delete_detail_success' , function(){
	dataQueryObject.queryDetail();
});

//新增一个版本改动时，查询出版社信息
TJEvent.addListener('subject_change' , function(e){
	
	switch(TJDataCenter.get('current_pop_panel')){
		//如果是新增detail，查询教材
		case 'add_curriculumn_detail':
			
			dataQueryObject.queryBookData();
		
			break;
		//如果是导入数据，查询树结构
		case 'detail_data':
			dataQueryObject.queryBookDataForTree();
		
			dataQueryObject.queryTree();
			break;
	}
	
	
});

//新增一个版本改动时，查询教材信息
TJEvent.addListener('section_change' , function(){
	switch(TJDataCenter.get('current_pop_panel')){
		//如果是新增detail，查询教材
		case 'add_curriculumn_detail':
			
			dataQueryObject.queryBookData();
		
			break;
		//如果是导入数据，查询树结构
		case 'detail_data':
			dataQueryObject.queryBookDataForTree();
		
			dataQueryObject.queryTree();
			break;
	}
});

//新增一个版本改动时，查询教材信息
TJEvent.addListener('publisher_change' , function(){
	switch(TJDataCenter.get('current_pop_panel')){
		//如果是新增detail，查询教材
		case 'add_curriculumn_detail':
			
			dataQueryObject.queryBookData();
		
			break;
		//如果是导入数据，查询树结构
		case 'detail_data':
			dataQueryObject.queryBookDataForTree();
			break;
	}
});

TJEvent.addListener('book_change' , function(){
	
	switch(TJDataCenter.get('current_pop_panel')){
		//如果是导入数据，查询树结构
		case 'detail_data':
			dataQueryObject.queryTree();
			break;
	}
	
});

TJEvent.addListener('curriculumn_version_change' , function(){
	
	if(TJDataCenter.get('current_pop_panel') == 'detail_data'){
		var current_type = parseInt(TJDataCenter.get('current_type'));
		if(current_type == 1){//同步
			dataQueryObject.queryTree();
			
		}else{//2,3 知识点 专题
			dataQueryObject.queryTree();
		}
	}
	
});


TJEvent.addListener('query_tree_success' , function(e){
	
	var current_type = TJDataCenter.get('current_type') ;
	var data = TJDataCenter.get('current_tree');
	var treeData = [];
	
	switch(parseInt(current_type)){
		case 1://同步
			//	同步结构有PHP生成，无需变动
			treeData = data;
			break;
			
		case 2://知识点
		case 3://专题
		
			var max = 0;
			
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
			treeData.push({id : -1 , name : '专题树' , children : tmpDataArray[0] ? tmpDataArray[0] : [] ,  attributes : {level : 0 , parent_id : 0 , sort_id : 0}});
			
			break;
		
	}
	
	if(treeData.length == 0){
		treeData= [{id :0 , name : '暂无数据' , children : []}];
	}
	
	var ev = new TJEvent.EventObject('refresh_tree');
	ev.data.treeData = treeData;
	ev.data.classSelector = '.treeClass';
	TJEvent.dispatch(ev);
	
//	$('#treeNavDIV').html('').append(TJTree.treeRender(treeData));
	
});

TJEvent.addListener('query_publisher_success' , function(e){
	var ev = new TJEvent.EventObject('search_bar_publisher_update');
	ev.data.info = e.data.info;
	TJEvent.dispatch(ev);
	
});

TJEvent.addListener('query_book_success' , function(e){
	
	$('.combo_select').html('');
	for(var i = 0 ; i < e.data.info.length ; i++){
		$('.book_list').append('<div class="book_content_list" book_id="'+e.data.info[i].id+'">'+e.data.info[i].book_name+'</div>');
	}
	
	var ev = new TJEvent.EventObject('search_bar_book_update');
	ev.data.info = e.data.info;
	TJEvent.dispatch(ev);
	
});

TJEvent.addListener('add_curriculumn_detail_submit' , function(e){
	var type = TJDataCenter.get('current_type');
	
	switch(parseInt(type)){
		case 1://同步
			dataSubmitObject.createTongbuChange();
			
			break;
			
		case 2:
			dataSubmitObject.createKnowledgeChange();
		
			break;
			
		case 3:
			dataSubmitObject.createZhuantiChange();
		
			break;
	}
	
});

TJEvent.addListener('detail_data_submit' , function(e){
	
	var current_tree = TJDataCenter.get('current_tree');
	if(current_tree.length == 0){
		alert('当前选项无数据，不能导入');
		return;
	}
	
	var type = TJDataCenter.get('current_type');
	
	switch (parseInt(type)) {
		case 1://同步
			dataSubmitObject.setinTongbuData();
			
			break;
			
		case 2:
			dataSubmitObject.setinKnowledgeData();
			
			break;
			
		case 3:
			dataSubmitObject.setinZhuantiData();
			
			break;
	}
	
});


$(document).ready(function(){
	
	//点击版本时处理
	$('.curriculumn_wrapper').delegate('a','click',function(){
		$('.curriculumn_wrapper .content_tab_select').removeClass('content_tab_select');
		$(this).addClass('content_tab_select');
		
		TJDataCenter.set('current_curriculumn' , $(this).attr('cid'));
		TJDataCenter.set('current_curriculumn_tongbu' , $(this).attr('tongbu'));
		TJDataCenter.set('current_curriculumn_knowledge' , $(this).attr('knowledge'));
		TJDataCenter.set('current_curriculumn_zhuanti' , $(this).attr('zhuanti'));
		
		var e = new TJEvent.EventObject('curriculumn_change');
		e.data.target = this;
		TJEvent.dispatch(e);
		
		
	});
	
	
	
	$('.type_wrapper').delegate('a' , 'click' , function(){
		
		var flag = true;
	
		switch(parseInt($(this).attr('type'))){
			case 1:
				if(TJDataCenter.get('current_curriculumn_tongbu') == 0){
				flag = false;
				}
				break;
				
			case 2:
				if(TJDataCenter.get('current_curriculumn_knowledge') == 0){
					flag = false;
				}
			
				break;
			case 3:
				if(TJDataCenter.get('current_curriculumn_zhuanti') == 0){
					flag = false;
				}
			
				break;
		}
		
		if($(this).hasClass('content_tab_select')){
			flag = false;
		}
		
		if(!flag){
			return;
		}
		
		$('.deny_cover').hide();
		
		$('.type_wrapper .content_tab_select').removeClass('content_tab_select');
		$(this).addClass('content_tab_select');
		
		TJDataCenter.set('current_type' , $(this).attr('type'));

		var e = new TJEvent.EventObject('type_change');
		e.data.target = this;
		TJEvent.dispatch(e);
		
	});
	
	$('.type_wrapper').delegate('.unactive' , 'dblclick' , function(){
		
		var curriculumn = TJDataCenter.get('current_curriculumn');
		if(curriculumn == 0){
			alert('请先选择版本');
			exit;
		}
		
		switch(parseInt($(this).attr('type'))){
			case 1:
				dataSubmitObject.activeTongbu();
				break;
				
			case 2:
				dataSubmitObject.activeKnowledge();
				break;
				
			case 3:
				dataSubmitObject.activeZhuanti();
				break;
		}
		
	});
	
	
	$('.new_curriculumn').click(function(){
		
		var e = new TJEvent.EventObject('popup_show');
		e.data.name = 'add_curriculumn';
		TJEvent.dispatch(e);
		
	});
	
	$('.add_detail').click(function(){
		
		var e = new TJEvent.EventObject('popup_show');
		e.data.name = 'add_curriculumn_detail';
		TJEvent.dispatch(e);
		
	});
	
	$('.book_list').delegate('.book_content_list' , 'click' , function(){
		if($('.book_selected .book_content_list[book_id='+$(this).attr('book_id')+']').length == 0){
			var clone = $(this).clone();
			$('.book_selected').append(clone);
		}
		
		$(this).css('background' , '#DFE8F3');
		
	});
	
	$('.book_selected').delegate('.book_content_list' , 'click' , function(){
		$('.book_list .book_content_list[book_id='+$(this).attr('book_id')+']').css('background' , '');
		$(this).remove();
		
	});
	
	//载入数据
	$('.curriculumn_detail_table').delegate('.setin_data' , 'click' , function(){
		
		if($(this).hasClass('unactive')){
			return;
		}
		
		var tr = $(this).closest('tr');
		
		var detail_id = tr.attr('detail_id');
		
		var subject_id = tr.attr('subject_id');
		var section_id = tr.attr("section_id");
		var book_id = tr.attr('book_id');
		
		TJDataCenter.set('setin_data_id' , detail_id);
		TJDataCenter.set('setin_data_subject' , subject_id);
		TJDataCenter.set('setin_data_section' , section_id);
		TJDataCenter.set('setin_data_book' , book_id);
		
		var e = new TJEvent.EventObject('popup_show');
		e.data.name = 'detail_data';
		TJEvent.dispatch(e);
		
	});
	
	//清除数据
	$('.curriculumn_detail_table').delegate('.clear_data' , 'click' , function(){
		if($(this).hasClass('unactive')){
			return;
		}
		
		var detail_id = $(this).closest('tr').attr('detail_id');
		var subject_id = $(this).closest('tr').attr('subject_id');
		var section_id = $(this).closest('tr').attr('section_id');
		var book_id = $(this).closest('tr').attr('book_id');
		
		TJDataCenter.set('clear_data_id' , detail_id);
		TJDataCenter.set('clear_data_subject' , subject_id);
		TJDataCenter.set('clear_data_section' , section_id);
		TJDataCenter.set('clear_data_book' , book_id);
		
		if(confirm('确认清除“'+$(this).closest('tr').children('td:eq(0)').text()+'”的数据吗')){
			
			var current_type = TJDataCenter.get('current_type');
			switch(parseInt(current_type)){
				case 1:
					dataSubmitObject.clearTongbuData();
					break;
					
				case 2:
					dataSubmitObject.clearKnowledgeData();
					break;
					
				case 3:
					dataSubmitObject.clearZhuantiData();
					break;
				
			}
			
			
		}
		
	});
	
	//删除修改
	$('.curriculumn_detail_table').delegate('.delete_detail' , 'click' , function(){
		if($(this).hasClass('unactive')){
			return;
		}
		
		var detail_id = $(this).closest('tr').attr('detail_id');
		
		TJDataCenter.set('delete_data_id' , detail_id);
		
		if(confirm('确认删除“'+$(this).closest('tr').children('td:eq(0)').text()+'”吗')){
			dataSubmitObject.deleteDetail();
		}
		
	});
	
	
	$('.curriculumn_detail_table').delegate('.complete_detail' , 'click' , function(){
		if($(this).hasClass('unactive')){
			return;
		}
		
		var detail_id = $(this).closest('tr').attr('detail_id');
		
		TJDataCenter.set('complete_data_id' , detail_id);
		
		
	});
	
	
	$('.version_table').delegate('.version_active' , 'click' , function(){
		
		var version_id = $(this).closest('tr').attr('version_id');
		dataQueryObject.queryActive(version_id);
		
	});
	
	$('.version_table').delegate('.version_detail' , 'click' , function(){
		
		var version_id = $(this).closest('tr').attr('version_id');
		dataQueryObject.queryDetail(version_id);
		
	});
	
	
	//提示框
	$('.type_wrapper a').poshytip({
		className : 'tip-twitter',
		content : '双击激活',
		showTimeout : 0,
		hideTimeout : 0,
		alignTo : 'target',
		alignX : 'center',
		alignY : 'bottom',
		offsetX : 0,
		offsetY : 0
	}).poshytip('disable');
	
	$('.deny_cover').poshytip({
		className : 'tip-twitter',
		content : '选择版本和类型即可使用',
		showTimeout : 0,
		hideTimeout : 0,
		alignTo : 'cursor',
		alignX : 'center',
		alignY : 'bottom',
		offsetX : 0,
		offsetY : 0
	});
	
	dataQueryObject.queryCurriculumn();
	
});

