//数据查询和提交对象
dataQueryObject = {
	queryUserGroupList : function(){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/user/user_group_api.php?action=list',
			'type' : 'GET',
			'dataType' : 'jsonp',
			'data' : {
				offset : pagerHandler.offset,
				step : pagerHandler.step
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('query_user_group_success');
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
	
	queryPrivilegeData : function(group_id){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/user/user_group_api.php?action=privilege_data',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				group : group_id
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('query_privilege_success');
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
	addGroup : function(group_name){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/user/user_group_api.php?action=add_group',
			'type' : 'POST',
			'data' : {
				group_name : group_name
			},
			'dataType' : 'jsonp',
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('add_user_group_success');
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
	
	updateGroupPrivilege : function(group_id , moduleArray){
		
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/user/user_group_api.php?action=update_group_privilege',
			'type' : 'POST',
			'data' : {
				group : group_id,
				module : moduleArray
			},
			'dataType' : 'jsonp',
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('update_group_success');
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
	dataQueryObject.queryUserGroupList();
});

TJEvent.addListener('add_user_group_submit' , function(e){
	dataSubmitObject.addGroup(e.data.group_name);
});

TJEvent.addListener('add_user_group_success' , function(e){
	dataQueryObject.queryUserGroupList();
});

TJEvent.addListener('query_user_group_success' , function(e){
	
	var data = e.data.data;
	var count = e.data.count;
	
	pagerHandler.setTotalCount(count);
	
	$('.user_group_record:visible').remove();
	for(var i = 0 ; i < data.length ; i++){
		var clone = $('#user_group_record_template').clone().removeAttr('id').show();
		clone.attr('group_id' , data[i].id);
		clone.find('.group_id').text(data[i].id);
		clone.find('.group_name').text(data[i].name);
		clone.find('.member_count').text(data[i].member_count);
		clone.find('.create_time').text(new Date(data[i].create_time*1000).getString());
		clone.find('.creator_name').text(data[i].username);
		
		$('.user_group_table').append(clone);
		
	}
});

TJEvent.addListener('query_privilege_success' , function(e){
	
	var data = e.data.tree;
	
	var treeData = [];
	
	if(data.length == 0){
		
		treeData.push({id:-1 , name:'暂无数据' , children : [] , attributes : {level : 1 , parent_id : 0 , key : 0 , privilege : 0}});
		
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
						id:data[j].id , 
						name:data[j].name , 
						parent_id : data[j].parent_id , 
						children : []  , 
						attributes : {
							level : data[j].level , 
							parent_id : data[j].parent_id , 
							key : data[j].key,
							privilege : parseInt(data[j].privilege+0)
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
		treeData.push({id : -1 , name : '权限' , children : tmpDataArray[0] ,  attributes : {level : 0 , parent_id : 0 , key : 0 , privilege : 0}});
		
	}
	
	var ev = new TJEvent.EventObject('refresh_tree');
	ev.data.treeData = treeData;
	ev.data.classSelector = '.treeClass';
	
	TJEvent.dispatch(ev);
	
	var ev2 = new TJEvent.EventObject('popup_show');
	ev2.data.name = 'group_privilege';
	TJEvent.dispatch(ev2);
	
});

TJEvent.addListener('edit_privilege_submit' , function(e){
	
	var group_id = TJDataCenter.get('current_group_id');
	var module = e.data.module ;
	
	dataSubmitObject.updateGroupPrivilege(group_id , module);
	
});

TJEvent.addListener('update_group_success' , function(){
	alert('提交成功');
});

$(document).ready(function(){
	
	dataQueryObject.queryUserGroupList();
	
	$('.action_insert').click(function(){
		var e = new TJEvent.EventObject('popup_show');
		e.data.name = 'add_user_group';
		TJEvent.dispatch(e);
	});
	
	$('.user_group_table').delegate('.group_privilege' , 'click' , function(){
		
		var group_id = $(this).closest('tr').attr('group_id');
		
		TJDataCenter.set('current_group_id' , group_id);
		
		dataQueryObject.queryPrivilegeData(group_id);
		
//		var e = new TJEvent.EventObject('popup_show');
//		e.data.name = 'group_privilege';
//		TJEvent.dispatch(e);
	});
	
	
});
