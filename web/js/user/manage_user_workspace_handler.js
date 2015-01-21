//数据查询和提交对象
dataQueryObject = {
	queryWorkspaceList : function(){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/user/user_workspace_api.php?action=list',
			'type' : 'GET',
			'dataType' : 'jsonp',
			'data' : {
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('query_workspace_success');
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
	
	queryWorkspaceSource : function(workset_id , parent_id){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/user/user_workspace_api.php?action=source',
			'type' : 'GET',
			'dataType' : 'jsonp',
			'data':{
				workset : workset_id,
				parent : parent_id
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('query_workset_source_success');
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
	
	queryWorkspaceVersion: function(workset_id){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/user/user_workspace_api.php?action=version',
			'type' : 'GET',
			'dataType' : 'jsonp',
			'data':{
				workset : workset_id
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('query_workset_version_success');
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
		
	}
	
};

dataSubmitObject = {
	addWorkspace : function(name){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/user/user_workspace_api.php?action=add_workspace',
			'type' : 'POST',
			'data' : {
				work_name : name
			},
			'dataType' : 'jsonp',
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('add_workspace_success');
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
	
	updateWorkspaceSource : function(sourceArray){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/user/user_workspace_api.php?action=update_workspace_source',
			'type' : 'POST',
			'data' : {
				source : sourceArray,
				workset : TJDataCenter.get('current_workset_id')
			},
			'dataType' : 'jsonp',
			success : function(data){
				if(data !== false){
					var e = new TJEvent.EventObject('update_workset_source_success');
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
	
	updateWorkspaceVersion : function(versionArray){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/user/user_workspace_api.php?action=update_workspace_version',
			'type' : 'POST',
			'data' : {
				version : versionArray,
				workset : TJDataCenter.get('current_workset_id')
			},
			'dataType' : 'jsonp',
			success : function(data){
				if(data !== false){
					var e = new TJEvent.EventObject('update_workset_version_success');
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


TJEvent.addListener('pager_change' , function(){
	dataQueryObject.queryWorkspaceList();
});

TJEvent.addListener('add_workspace_submit' , function(e){
	dataSubmitObject.addWorkspace(e.data.work_name);
});

TJEvent.addListener('add_workspace_success' , function(e){
	dataQueryObject.queryWorkspaceList();
});

TJEvent.addListener('query_workspace_success' , function(e){
	
	var data = e.data.data;
	var count = e.data.count;
	
//	pagerHandler.setTotalCount(count);
	
	
	
	$('.workspace_record:visible').remove();
	for(var i = 0 ; i < data.length ; i++){
		var clone = $('#tree_item_template').clone().removeAttr('id').show();
//		var clone = $('#workspace_record_template').clone().removeAttr('id').show();
		clone.attr({
			'ws_id' : data[i].id , 
			'ws_name' : data[i].name,
			'level' : data[i].level,
			'parent_id' : data[i].parent_id			
		});
//		clone.find('.ws_id').text(data[i].id);
		clone.find('.item_ws_name').text(data[i].name);
		clone.find('.item_member_count').text(data[i].member_count);
		clone.find('.item_create_time').text(new Date(data[i].create_time*1000).getString());
		clone.find('.item_creator_name').text(data[i].username);
		
		$('.tree_content > .tree_list').append(clone);
	}
	
	$('.tree_item[level!=0][ws_id]').each(function(){
		if($(this).attr('level') != 1){
			$(this).appendTo('.tree_item[ws_id='+$(this).attr('parent_id')+'] > .tree_list');
		}
	});
	
	$('.tree_list').each(function(){
		if($(this).children().length == 0){
			$(this).closest('.tree_item').children('.tree_handle').children('.item_icon').hide();
		}
	});
	
});


TJEvent.addListener('workset_source_submit' , function(e){
	
	dataSubmitObject.updateWorkspaceSource(e.data.source);
	
});

TJEvent.addListener('query_workset_source_success' , function(e){
	
	var data = e.data.data;
	var select = e.data.select;
	
	var treeData = [];
	
	for(var i = 0 ; i < data.length ; i++){
		if(!treeData[data[i].subject_id]){
			treeData[data[i].subject_id] = {
				id: data[i].subject_id,
				name: data[i].subject_name,
				children: [],
				attributes: {'type' : 'subject'}
			};
		}
		treeData[data[i].subject_id].children.push({
			id: data[i].section_id,
			name: data[i].section_name,
			children: [],
			attributes: {'type' : 'section'}
		});
	}
	
	for(var i = 0 ; i < select.length ; i++){
		treeData[select[i].subject_id].attributes['selected'] = 'true';
		for(var j = 0 ; j < treeData[select[i].subject_id].children.length ; j++){
			if(treeData[select[i].subject_id].children[j].id == select[i].section_id){
				treeData[select[i].subject_id].children[j].attributes['selected'] = 'true';
			}
		}
	}
	
	treeData = treeData.slice(0 , treeData.length);
	var _treeData = [];
	for(var i = 0 ; i < treeData.length ; i++){
		if(treeData[i]){
			_treeData.push(treeData[i]);
		}
	}
	
	var treeEvent = new TJEvent.EventObject('refresh_tree');
	treeEvent.data.treeData = _treeData;
	treeEvent.data.classSelector = '.treeClass';
	
	TJEvent.dispatch(treeEvent);
	
	var ev = new TJEvent.EventObject('popup_show');
	ev.data.name = 'workset_source';
	TJEvent.dispatch(ev);
	
});


TJEvent.addListener('query_workset_version_success' , function(e){
	
	var ev = new TJEvent.EventObject('popup_show');
	ev.data.name = 'workset_version_visible';
	ev.data.version = e.data;
	TJEvent.dispatch(ev);
});

TJEvent.addListener('workset_version_visible_submit' , function(e){
	
	dataSubmitObject.updateWorkspaceVersion(e.data.version);
	
});

TJEvent.addListener('update_workset_version_success' , function(){
	
});

$(document).ready(function(){
	
	dataQueryObject.queryWorkspaceList();
	
	$('.action_insert').click(function(){
		var e = new TJEvent.EventObject('popup_show');
		e.data.name = 'add_workspace';
		TJEvent.dispatch(e);
	});
	
	$(document).delegate('.item_icon' , 'click' , function(){
		$(this).closest('.tree_handle').next().toggle();
	});
	
	$('.tree_content').delegate('.edit_workset_source' , 'click' , function(){
		var workset_id = $(this).closest('.tree_item').attr('ws_id');
		var parent_id = $(this).closest('.tree_item').attr('parent_id');
		TJDataCenter.set('current_workset_id' , workset_id);
		dataQueryObject.queryWorkspaceSource(workset_id , parent_id);
		
	});
	
	$('.tree_content').delegate('.edit_version_visible' , 'click' , function(){
		var workset_id = $(this).closest('.tree_item').attr('ws_id');
		TJDataCenter.set('current_workset_id' , workset_id);
		dataQueryObject.queryWorkspaceVersion(workset_id );
		
	});
	
	
	
});
