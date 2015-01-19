//数据查询和提交对象
dataQueryObject = {
	queryUserList : function(){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/user/user_api.php?action=list',
			'type' : 'GET',
			'data' : {
				offset : pagerHandler.offset,
				step : pagerHandler.step,
				role : TJDataCenter.get('role'),
				workset : TJDataCenter.get('workset')
				
			},
			'dataType' : 'jsonp',
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('query_user_success');
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
};

dataSubmitObject = {
	addUser : function(username , realname , passwd , role , workset){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/user/user_api.php?action=add_user',
			'type' : 'POST',
			'data' : {
				username : username ,
				realname : realname ,
				passwd : hex_md5(passwd) , 
				role : role,
				workset : workset
			},
			'dataType' : 'jsonp',
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('add_user_success');
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

TJEvent.addListener('role_change' , function(){
	dataQueryObject.queryUserList();
});

TJEvent.addListener('workset_change' , function(){
	dataQueryObject.queryUserList();
});

TJEvent.addListener('add_user_submit' , function(e){
	dataSubmitObject.addUser(e.data.username , e.data.realname , e.data.passwd , e.data.user_role, e.data.user_workset)
});

TJEvent.addListener('add_user_success' , function(e){
	dataQueryObject.queryUserList();
});

TJEvent.addListener('query_user_success' , function(e){
	
	var data = e.data.data;
	var count = e.data.count;
	
	pagerHandler.setTotalCount(count);
	
	$('.user_record:visible').remove();
	for(var i = 0 ; i < data.length ; i++){
		var clone = $('#user_record_template').clone().removeAttr('id').show();
		clone.attr({
			'user_id' : data[i].id,
			'username' : data[i].username,
			'realname' : data[i].realname,
			'user_role' : data[i].role_id,
			'user_workset' : data[i].workset_id
		});
		clone.find('.user_id').text(data[i].id);
		clone.find('.username').text(data[i].username);
		clone.find('.realname').text(data[i].realname);
		clone.find('.user_role').text(data[i].role_name);
		clone.find('.user_workset').text(data[i].workset_name);
		clone.find('.create_time').text(new Date(data[i].create_time*1000).getString());
		
		$('.user_table').append(clone);
		
	}
});
TJEvent.addListener('pager_change' , function(){
	dataQueryObject.queryUserList();
});


$(document).ready(function(){
	
	dataQueryObject.queryUserList();
	
	$('.action_insert').click(function(){
		var e = new TJEvent.EventObject('popup_show');
		e.data.name = 'add_user';
		TJEvent.dispatch(e);
	});
	
	$('.user_table').delegate('.modify_user' , 'click' , function(){
		
		var trObject = $(this).closest('tr');
		
		var e = new TJEvent.EventObject('popup_show');
		e.data.name = 'modify_user';
		e.data.user_id = trObject.attr('user_id');
		e.data.username = trObject.attr('username');
		e.data.realname = trObject.attr('realname');
		e.data.group_id = trObject.attr('user_group');
		e.data.workset_id = trObject.attr('user_workset');
		TJEvent.dispatch(e);
	});
	
});
