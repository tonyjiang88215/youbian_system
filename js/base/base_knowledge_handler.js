/**
 * 知识体系管理页面数据处理中心
 * @Author By TonyJiang
 */

var queryDelay = null;

var origin_data = null;

var new_data = null;

//数据查询和提交对象
dataQueryObject = {
	queryTreeData : function(){
		
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/base/knowledge_api.php?action=tree_data',
			'type' : 'GET',
			'dataType' : 'jsonp',
			'data' : {
				subject : TJDataCenter.get('origin_search_subject'),
				section : TJDataCenter.get('origin_search_section')
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('query_tree_success');
					e.data = data;
					e.data.group ='origin';
					TJEvent.dispatch(e);
					
				}else{
					var e = new TJEvent.EventObject('ajax_error');
					e.data.source = 'knowledge_system_handler.js queryTreeData()';
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('ajax_error');
				e.data.source = 'knowledge_system_handler.js queryTreeData()';
				TJEvent.dispatch(e);
			}
		});
		
	}
};

dataSubmitObject = {
	insertKnowledgeData : function(newData){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/base/knowledge_api.php?action=insert',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				new_data : newData
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('insert_knowledge_success');
					TJEvent.dispatch(e);
				}else{
					var e = new TJEvent.EventObject('insert_knowledge_failed');
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('insert_knowledge_failed');
				TJEvent.dispatch(e);
			}
		});
	},
	
	moveUpKnowledge : function(knowledge_id , target_id , oldname){
		
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/base/knowledge_api.php?action=move_up',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				knowledge_id : knowledge_id , 
				target_id : target_id,
				subject : TJDataCenter.get('origin_search_subject'),
				section : TJDataCenter.get('origin_search_section'),
				oldname : oldname
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('move_up_success');
					TJEvent.dispatch(e);
				}else{
					var e = new TJEvent.EventObject('move_up_failed');
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('move_up_failed');
				TJEvent.dispatch(e);
			}
		});
	},
	
	moveDownKnowledge : function(knowledge_id ,target_id , oldname){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/base/knowledge_api.php?action=move_down',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				knowledge_id : knowledge_id , 
				target_id : target_id,
				subject : TJDataCenter.get('origin_search_subject'),
				section : TJDataCenter.get('origin_search_section'),
				oldname : oldname
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('move_down_success');
					TJEvent.dispatch(e);
				}else{
					var e = new TJEvent.EventObject('move_down_failed');
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('move_down_failed');
				TJEvent.dispatch(e);
			}
		});
	},
	
	modifyKnowledge : function(info , oldname){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/base/knowledge_api.php?action=modify',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				knowledge : info , 
				subject : TJDataCenter.get('origin_search_subject') , 
				section : TJDataCenter.get('origin_search_section'),
				oldname : oldname
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('modify_knowledge_success');
					TJEvent.dispatch(e);
				}else{
					var e = new TJEvent.EventObject('modify_knowledge_failed');
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('modify_knowledge_failed');
				TJEvent.dispatch(e);
			}
		});
	},
	
	dragKnowledge : function(info , levelDiff , childs , oldname){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/base/knowledge_api.php?action=drag',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				knowledge : info , 
				levelDiff : levelDiff , 
				childs : childs,
				oldname : oldname,
				subject : TJDataCenter.get('origin_search_subject'),
				section : TJDataCenter.get('origin_search_section')
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('drag_knowledge_success');
					TJEvent.dispatch(e);
				}else{
					var e = new TJEvent.EventObject('drag_knowledge_failed');
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('drag_knowledge_failed');
				TJEvent.dispatch(e);
			}
		});
	},
	
	deleteKnowledge : function(id , oldname){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/base/knowledge_api.php?action=delete',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				knowledge_id : id , 
				subject : TJDataCenter.get('origin_search_subject'),
				section : TJDataCenter.get('origin_search_section'),
				oldname : oldname
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('delete_knowledge_success');
					TJEvent.dispatch(e);
				}else{
					var e = new TJEvent.EventObject('delete_knowledge_failed');
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('delete_knowledge_failed');
				TJEvent.dispatch(e);
			}
		});
	},
	
	clearData : function(){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/base/knowledge_api.php?action=clear_data',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				subject : TJDataCenter.get('origin_search_subject'),
				section : TJDataCenter.get('origin_search_section')
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('clear_data_success');
					TJEvent.dispatch(e);
				}else{
					var e = new TJEvent.EventObject('clear_data_failed');
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('clear_data_failed');
				TJEvent.dispatch(e);
			}
		});
	}
};

TJEvent.addListener('section_change' , function(e){
	
	if(e.data.group != 'origin_search'){
		return;
	}
	
	//选择了学科，学段和版本后，才能获取数据
	if(TJDataCenter.get('origin_search_subject') != 0 && TJDataCenter.get('origin_search_section') != 0){
		
		dataQueryObject.queryTreeData();
		
	}else{
		
		$('.action_panel').addClass('action_disabled');
		
		var ev = new TJEvent.EventObject('refresh_tree');
		ev.data.treeData = [];
		ev.data.flag = true;
		ev.data.classSelector = '.treeClass';
		TJEvent.dispatch(ev);
	}
	
});

TJEvent.addListener('tree_element_selected' , function(e){
	var current_element = TJDataCenter.get('origin_tree_selected_tree_element');
	
	//如果是单元节点
		
	if(current_element.closest('li').next().find('li.link').length == 0){
		$('.action_delete').removeClass('action_disabled');
	}else{
		$('.action_delete').addClass('action_disabled');
	}
		
	
	$('.action_insert_children , .action_move_up , .action_move_down').removeClass('action_disabled');
});


TJEvent.addListener('query_tree_success' , function(e){
	
	$('.action_setin , .action_clear , .action_insert_sibling').removeClass('action_disabled');
		
	$('.action_insert_children , .action_move_up , .action_move_down , .action_delete').addClass('action_disabled');
	
	if(e.data.group != 'origin'){
		return;
	}
	
	var data = e.data;
	
	var treeData = [];
	
	if(data.length == 0){
		
//		treeData.push({id:-1 , name:'暂无数据' , children : [] , attributes : {level : 1 , parent_id : 0 , sort_id : 0}});
		
	}else{
		
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
						id:e.data[j].id , 
						name:e.data[j].name , 
						parent_id : e.data[j].parent_id , 
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
		
	}
	
	TJDataCenter.set('origin_tree_data' , data);
	var _data = [];
	for(var i = 0 ; i < data.length ; i++){
		_data.push({
			id : data[i].id,
			level : data[i].level,
			name : data[i].name,
			parent_id : data[i].parent_id,
			section_id : data[i].section_id ,
			subject_id : data[i].subject_id,
			grade_id : data[i].grade_id
		});
	}
	TJDataCenter.set('new_tree_data' , _data);
	
	var lastElement = TJDataCenter.get('origin_tree_selected_tree_element');
	if(lastElement){
		TJDataCenter.set('last_tree_element_id' , lastElement.attr('elementid'));
	}else{
		TJDataCenter.set('last_tree_element_id' , 0);
	}
	
	
	var e1 = new TJEvent.EventObject('refresh_tree');
	e1.data.treeData = treeData;
	e1.data.flag = true;
	e1.data.classSelector = '.treeClass';
	TJEvent.dispatch(e1);
});

TJEvent.addListener('refresh_tree_success' , function(e){
	var last_id = TJDataCenter.get('last_tree_element_id');
	if(last_id){
		setTimeout(function(){
			var element = $('li[elementid='+last_id+']');
			if(element.length > 0){
				$('li[elementid='+last_id+']').find('a').click().focus();
			}else{
				TJDataCenter.set('last_tree_element_id' , 0);
				TJDataCenter.set('origin_tree_selected_tree_element' , 0);
			}
		},100);
	}
});

TJEvent.addListener('tree_element_dbclick' , function(e){
	
	var ev = new TJEvent.EventObject('edit_name_show');
	ev.data.name = $(e.data.htmlObject).text();
	TJEvent.dispatch(ev);
	
});

//编辑保存时处理
TJEvent.addListener('edit_name_submit' , function(e){
	
	var id = TJDataCenter.get('origin_tree_dbclick_tree_element').attr('elementid');
	var oldname = TJDataCenter.get('origin_tree_dbclick_tree_element').attr('title');
	
	dataSubmitObject.modifyKnowledge({ id : id , name : e.data.name} , oldname);

});

TJEvent.addListener('modify_knowledge_success' , function(){
	
	dataQueryObject.queryTreeData();
	
	var ev = new TJEvent.EventObject('edit_finish');
	TJEvent.dispatch(ev);
	
});

TJEvent.addListener('modify_knowledge_failed' , function(){
	
	alert('修改失败，请稍后再试');
	
});

//插入同层时处理
TJEvent.addListener('insert_sibling_submit' , function(e){
	
	var baseElement = TJDataCenter.get('origin_tree_selected_tree_element');
	
	var newData = {
		name : e.data.name,
		subject_id : TJDataCenter.get('origin_search_subject'),
		section_id : TJDataCenter.get('origin_search_section'),
		level : baseElement ? baseElement.attr('level') : 1,//和目标同层
		parent_id : baseElement ? baseElement.attr('parent_id') : 0,//和目标同父
		grade_id : baseElement ? baseElement.attr('grade_id') : 0,//和目标同年级，暂定
		sort_id : baseElement ? parseInt(baseElement.closest('li').siblings(':last').prev().find('a').attr('sort_id'))+1 : $('#treeNavDIV[group=origin_tree]>ul>li.link').length+1,//在当前层尾部添加
//		version_id : TJDataCenter.get('curriculumn_version')
	};
	
	dataSubmitObject.insertKnowledgeData(newData);
	
});

//插入子层时处理
TJEvent.addListener('insert_children_submit' , function(e){
	
	var baseElement = TJDataCenter.get('origin_tree_selected_tree_element');
	
	var newData = {
		name : e.data.name,
		subject_id : TJDataCenter.get('origin_search_subject'),
		section_id : TJDataCenter.get('origin_search_section'),
		level : parseInt(baseElement.attr('level'))+1,//和目标同层
		parent_id : baseElement.attr('elementid'),//和目标同父
		grade_id : baseElement.attr('grade_id'),//和目标同年级，暂定
//		version_id : TJDataCenter.get('curriculumn_version')
	};

	//如果没有子项，则当前添加的排序为第一位
	if(TJTree.checkTail()){
		newData.sort_id = 0;
	}else{
		newData.sort_id = parseInt($('.child_li[parentid='+baseElement.attr('elementid')+']').find('li:last').prev().find('a').attr('sort_id'))+1
	}
	
	
	dataSubmitObject.insertKnowledgeData(newData);
	
});

//插入成功保存后，重新加载树形结构
TJEvent.addListener('insert_knowledge_success' , function(){
	
	dataQueryObject.queryTreeData();
	
	var ev = new TJEvent.EventObject('edit_finish');
	TJEvent.dispatch(ev);
});

TJEvent.addListener('insert_knowledge_failed' , function(){
	alert('插入失败，请稍后再试');
});

TJEvent.addListener('delete_knowledge_success',function(){
	dataQueryObject.queryTreeData();
});

TJEvent.addListener('delete_knowledge_failed',function(){
	alert('删除失败，请稍后再试');
});


//上移成功
TJEvent.addListener('move_up_success' , function(){
	dataQueryObject.queryTreeData();
});

TJEvent.addListener('move_up_failed' , function(){
	alert('上移失败，请稍后再试');
});

//下移成功
TJEvent.addListener('move_down_success' , function(){
	dataQueryObject.queryTreeData();
});

TJEvent.addListener('move_down_failed' , function(){
	alert('下移失败，请稍后再试');
});

//拖拽修改位置时处理
TJEvent.addListener('drop_tree_element' , function(e){
	
	
	
	var info = {
		id : $(e.data.object).attr('elementid'),
		parent_id : $(e.data.target).attr('elementid'),
		level : parseInt($(e.data.target).find('a').attr('level')) + 1,
		sort_id : $(e.data.target).next().children('.child_ul').children('li[elementid]').length + 1
		
	};
	
	var levelDiff = info.level - $(e.data.object).find('a').attr('level');
	
	var childs = [];
	
	$(e.data.object).next().find('a').each(function(){
		childs.push($(this).attr('elementid'));
	});
	
	var oldname = $(e.data.object).find('a').attr('title');
	
	dataSubmitObject.dragKnowledge(info , levelDiff , childs , oldname);
	
});

TJEvent.addListener('drag_knowledge_success' , function(e){
	dataQueryObject.queryTreeData();
});

TJEvent.addListener('setin_data_success' , function(){
	dataQueryObject.queryTreeData();
});

TJEvent.addListener('clear_data_success' , function(){
	alert('数据清除成功');
	
	$('.action_insert_children , .action_move_up , .action_move_down , .action_delete').addClass('.action_disabled');
	
	dataQueryObject.queryTreeData();
});

$(document).ready(function(){
	
	//点击插入同层时事件
	$('.action_insert_sibling').click(function(){
		
		if($(this).hasClass('action_disabled')){
			return;
		}
		
//		if(!TJDataCenter.get('origin_tree_selected_tree_element')){
//			alert('请选择知识点');
//			return;
//		}
		
		var e = new TJEvent.EventObject('insert_sibling_show');
		TJEvent.dispatch(e);
	});
	
	//点击插入子层时事件
	$('.action_insert_children').click(function(){
		
		if($(this).hasClass('action_disabled')){
			return;
		}
		
		if(!TJDataCenter.get('origin_tree_selected_tree_element')){
			alert('请选择知识点');
			return;
		}
		
		var e = new TJEvent.EventObject('insert_children_show');
		TJEvent.dispatch(e);
	});
	
	//节点上移
	$('.action_move_up').click(function(){
		if($(this).hasClass('action_disabled')){
			return;
		}
		
		if(TJTree.checkFirst()){
			alert('已经到顶啦');
			return;
		}else{
			dataSubmitObject.moveUpKnowledge(
				TJDataCenter.get('origin_tree_selected_tree_element').attr('elementid') , 
				TJDataCenter.get('origin_tree_selected_tree_element').closest('li').prev().prev().find('a').attr('elementid'),
				TJDataCenter.get('origin_tree_selected_tree_element').attr('title') 
			);
		}
	});
	
	//节点下移
	$('.action_move_down').click(function(){
		if($(this).hasClass('action_disabled')){
			return;
		}
		
		if(TJTree.checkLast()){
			alert('已经到底啦');
			return;
		}else{
			dataSubmitObject.moveDownKnowledge(
				TJDataCenter.get('origin_tree_selected_tree_element').attr('elementid') ,  
				TJDataCenter.get('origin_tree_selected_tree_element').closest('li').next().next().find('a').attr('elementid'),
				TJDataCenter.get('origin_tree_selected_tree_element').attr('title') 
			);
		}
	});
	
	$('.action_delete').click(function(){
		if($(this).hasClass('action_disabled')){
			return;
		}
		
		if(!TJDataCenter.get('origin_tree_selected_tree_element')){
			alert('请选择知识点');
			return;
		}
		
		if(!TJTree.checkTail()){
			alert('只能删除最底层知识点');
			return;
		}else{
			if(confirm('确认删除“'+TJDataCenter.get('origin_tree_selected_tree_element').attr('title')+'”吗？此操作不可恢复')){
				var id = TJDataCenter.get('origin_tree_selected_tree_element').attr('elementid');
				var oldname = TJDataCenter.get('origin_tree_selected_tree_element').attr('title');
				
				dataSubmitObject.deleteKnowledge(id , oldname);
			}
		}
		
	});
	
	$('.action_setin').click(function(){
		if($(this).hasClass('action_disabled')){
			return;
		}
		
		if($('.origin_tree .link[elementid!=-1] , .origin_tree .parent').length > 0){
			alert('请先清空数据，在进行导入');
			return;
		}
		
		var e = new TJEvent.EventObject('popup_show');
		e.data.name = 'data_setin';
		TJEvent.dispatch(e);
		
	});
	
	$('.action_clear').click(function(){
		if($(this).hasClass('action_disabled')){
			return;
		}
		
		if(confirm('确认清除数据吗？此操作不可恢复')){
			
			dataSubmitObject.clearData();
			
		}
	});
	
});


