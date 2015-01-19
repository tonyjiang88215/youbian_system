/**
 * 管理章节单元页面数据处理中心
 * @Author By TonyJiang
**/
//数据查询和提交对象
dataQueryObject = {
	queryPublisherList : function(){
		
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/base/publisher_api.php?action=publisher_list',
			'type' : 'GET',
			'dataType' : 'jsonp',
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('query_publisher_success');
					e.data = data;
					TJEvent.dispatch(e);
					
				}else{
					var e = new TJEvent.EventObject('query_tree_failed');
					e.data.source = 'unit_chapter_handler.js queryTreeData()';
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('query_tree_failed');
				e.data.source = 'unit_chapter_handler.js queryTreeData()';
				TJEvent.dispatch(e);
			}
		});
		
	},
	
	queryBookList : function(){
		
		var subject = TJDataCenter.get('subject');
		var section = TJDataCenter.get('section');
		
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/base/publisher_api.php?action=book_list',
			'type' : 'GET',
			'dataType' : 'jsonp',
			'data' : {
				subject : subject,
				section : section,
				publisher : TJDataCenter.get('current_publisher_id')
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('query_book_success');
					e.data = data;
					TJEvent.dispatch(e);
					
				}else{
					var e = new TJEvent.EventObject('ajax_error');
					e.data.source = 'unit_chapter_handler.js queryBookData()';
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('ajax_error');
				e.data.source = 'unit_chapter_handler.js queryBookData()';
				TJEvent.dispatch(e);
			}
		});
	}
};

dataSubmitObject = {
	
	addPublisher : function(publisher_name){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/base/publisher_api.php?action=add_publisher',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				publisher_name : publisher_name
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('add_publisher_success');
					e.data = data;
					TJEvent.dispatch(e);
					
				}else{
					var e = new TJEvent.EventObject('ajax_error');
					e.data.source = 'unit_chapter_handler.js queryBookData()';
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('ajax_error');
				e.data.source = 'unit_chapter_handler.js queryBookData()';
				TJEvent.dispatch(e);
			}
		});
	},
	
	modifyPublisher : function(publisher_id , publisher_name){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/base/publisher_api.php?action=modify_publisher',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				publisher_id : publisher_id ,
				publisher_name : publisher_name
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('modify_publisher_success');
					e.data = data;
					TJEvent.dispatch(e);
					
				}else{
					var e = new TJEvent.EventObject('ajax_error');
					e.data.source = 'unit_chapter_handler.js queryBookData()';
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('ajax_error');
				e.data.source = 'unit_chapter_handler.js queryBookData()';
				TJEvent.dispatch(e);
			}
		});
	},
	
	deletePublisher : function(publisher_id){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/base/publisher_api.php?action=delete_publisher',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				publisher : publisher_id
			},
			success : function(data){
				if(data.result){
					var e = new TJEvent.EventObject('delete_publisher_success');
					e.data = data;
					TJEvent.dispatch(e);
					
				}else{
					if(data.reason == '1'){
						alert('当前出版社下还存在教材，删除失败');
					}
					var e = new TJEvent.EventObject('ajax_error');
					e.data.source = 'unit_chapter_handler.js queryBookData()';
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('ajax_error');
				e.data.source = 'unit_chapter_handler.js queryBookData()';
				TJEvent.dispatch(e);
			}
		});
	},
	
	addBook : function(book_name , book_grade){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/base/book_api.php?action=insert_book',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				name : book_name,
				grade : book_grade,
				subject : TJDataCenter.get('subject'),
				section : TJDataCenter.get('section'),
				publisher : TJDataCenter.get('current_publisher_id')				
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('add_book_success');
					TJEvent.dispatch(e); 
				}else{
					var e = new TJEvent.EventObject('add_book_failed');
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('add_book_failed');
				TJEvent.dispatch(e);
			}
		});
	},
	
	modifyBook : function(book_id , book_name , subject_id){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/base/book_api.php?action=modify_book',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				id : book_id , 
				name : book_name,
				subject : subject_id
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('modify_book_success');
					TJEvent.dispatch(e);
				}else{
					var e = new TJEvent.EventObject('modify_book_failed');
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('modify_book_failed');
				TJEvent.dispatch(e);
			}
		});
		
	},
	
	deleteBook : function(book_id , subject_id){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/base/book_api.php?action=delete_book',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				book : book_id,
				subject : subject_id
			},
			success : function(data){
				if(data.result){
					var e = new TJEvent.EventObject('delete_book_success');
					e.data = data;
					TJEvent.dispatch(e);
					
				}else{
					if(data.reason == '1'){
						alert('当前教材下还存在单元或章节，删除失败');
					}
					var e = new TJEvent.EventObject('ajax_error');
					e.data.source = 'unit_chapter_handler.js queryBookData()';
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('ajax_error');
				e.data.source = 'unit_chapter_handler.js queryBookData()';
				TJEvent.dispatch(e);
			}
		});
	}
	
};

TJEvent.addListener('subject_change' , function(){
	dataQueryObject.queryBookList();
});

TJEvent.addListener('section_change' , function(){
	dataQueryObject.queryBookList();
});

TJEvent.addListener('add_publisher_submit' , function(e){
	dataSubmitObject.addPublisher(e.data.publisher_name);
});

TJEvent.addListener('add_publisher_success' , function(e){
	dataQueryObject.queryPublisherList();
});

TJEvent.addListener('delete_publisher_success' , function(e){
	dataQueryObject.queryPublisherList();
});

TJEvent.addListener('query_publisher_success' , function(e){
	
	$('.publisher_list:visible').remove();
	for(var i = 0 ; i < e.data.length ; i++){
		var template = $('#publisher_list_template').clone().removeAttr('id').show();
		template.attr('publisher_id' , e.data[i].id).find('.publisher_name').text(e.data[i].name);
		$('.publisher_wrapper').append(template);
	}
	
});

TJEvent.addListener('query_book_success' , function(e){
	
	$('.book_list:visible').remove();
	
	var data = e.data['data'];
	
	if(data.length > 0){
		for(var i = 0 ; i < data.length ; i++){
			var template = $('#book_list_template').clone().removeAttr('id').show();
			template.attr({
				'book_id' : data[i].id,
				'subject_id' : data[i].subject_id	
			}).find('.book_name').text(data[i].book_name);
			$('.book_wrapper').append(template);
		}
	}else{
		$('.book_wrapper').append('<div class="book_list" style="color:#c1c1c1;" >暂无</div>');
	}
	
});

TJEvent.addListener('modify_publisher_success' , function(){
	dataQueryObject.queryPublisherList();
});

TJEvent.addListener('add_book_submit' , function(e){
	dataSubmitObject.addBook(e.data.book_name , e.data.book_grade);
});

TJEvent.addListener('add_book_success' , function(){
	dataQueryObject.queryBookList();
});

TJEvent.addListener('modify_book_success' , function(){
	dataQueryObject.queryBookList();
});

TJEvent.addListener('delete_book_success' , function(){
	dataQueryObject.queryBookList();
});

$(document).ready(function(){
	
	//添加出版社
	$('.action_insert_publisher').click(function(){
		var e = new TJEvent.EventObject('add_publisher_show');
		TJEvent.dispatch(e);
	});
	
	//添加教材
	$('.action_insert_book').click(function(){
		if(TJDataCenter.get('subject') ==0 || TJDataCenter.get('section') == 0){
			alert('请先选择学科和选段');
			return;
		}
		var e = new TJEvent.EventObject('add_book_show');
		TJEvent.dispatch(e);
	});
	
	//出版社列表中点击删除
	$('.publisher_wrapper').delegate('.delete_publisher' , 'click' , function(){
		
		if(confirm('确认删除 "'+$(this).parent().prev().text()+'" 吗？')){
			dataSubmitObject.deletePublisher($(this).closest('.publisher_list').attr('publisher_id'));
		}
	});
	
	//出版社列表中点击编辑
	$('.publisher_wrapper').delegate('.edit_publisher' , 'click' , function(){
		
		var publisher_list = $(this).closest('.publisher_list');
		publisher_list.addClass('editing');
		publisher_list.find('.action_span').hide();
		publisher_list.find('.edit_action_span').show();
		
		var name = $(this).closest('.publisher_list').find('.publisher_name').text();
		TJDataCenter.set('current_editing_publisher_name' , name);
		
		$(this).closest('.publisher_list').find('.publisher_name').html('<input class="publisher_name_edit" value="'+name+'"></input>');
		$('.publisher_name_edit').focus();
		
	});
	
	//编辑状态中点击取消，回复编辑前的状态
	$('.publisher_wrapper').delegate('.edit_cancel' , 'click' , function(){
		
		if(!$(this).closest('.publisher_list').hasClass('editing')){
			return;
		}
		
		var publisher_list = $(this).closest('.publisher_list');
		publisher_list.removeClass('editing');
		
		publisher_list.find('.publisher_name').text(TJDataCenter.get('current_editing_publisher_name'));
		
		publisher_list.find('.edit_action_span').hide();
		publisher_list.find('.action_span').show();
		
	});
	
	//编辑状态中点击保存
	$('.publisher_wrapper').delegate('.edit_save' , 'click' , function(){
		
		if(!$(this).closest('.publisher_list').hasClass('editing')){
			return;
		}
		
		var publisher_list = $(this).closest('.publisher_list');
		
		var publisher_id = publisher_list.attr('publisher_id');
		var publisher_name = $.trim(publisher_list.find('.publisher_name_edit').val());
		
		if(publisher_name == TJDataCenter.get('current_editing_publisher_name')){
			publisher_list.find('.edit_cancel').click();
		}else{
			dataSubmitObject.modifyPublisher(publisher_id , publisher_name)
		}
		
		
	});
	
	//编辑状态下监听快捷键
	$('.publisher_wrapper').delegate('.publisher_name_edit' , 'keydown' , function(e){
		if(e.keyCode == 27){//esc
			$(this).closest('.publisher_list').find('.edit_cancel').click();
		}else if(e.keyCode == 13){//enter
			$(this).closest('.publisher_list').find('.edit_save').click();
		}
	});
	
	$('.publisher_wrapper').delegate('.publisher_list:not(.editing)' , 'mouseover' , function(){
		$(this).find('.action_span').show();
	});
	
	$('.publisher_wrapper').delegate('.publisher_list' , 'mouseout' , function(){
		$(this).find('.action_span').hide();
	});
	
	//选择一个出版社的时候，查询包含教材
	$('.publisher_wrapper').delegate('.publisher_list' , 'click' , function(){
		$('.publisher_list').css('background' , '');
		$(this).css('background' , 'rgb(223, 232, 243)');
		
		if($(this).attr('publisher_id') != TJDataCenter.get('current_publisher_id')){
			TJDataCenter.set('current_publisher_id' , $(this).attr('publisher_id'));
			
			dataQueryObject.queryBookList();
			
		}
		
	});
	
	
	//编辑状态下监听快捷键
	$('.book_wrapper').delegate('.book_name_edit' , 'keydown' , function(e){
		if(e.keyCode == 27){//esc
			$(this).closest('.book_list').find('.edit_cancel').click();
		}else if(e.keyCode == 13){//enter
			$(this).closest('.book_list').find('.edit_save').click();
		}
	});
	
	
	$('.book_wrapper').delegate('.book_list:not(.editing)' , 'mouseover' , function(){
		$(this).find('.action_span').show();
	});
	
	$('.book_wrapper').delegate('.book_list' , 'mouseout' , function(){
		$(this).find('.action_span').hide();
	});
	
	
	//教材列表中点击编辑
	$('.book_wrapper').delegate('.edit_book' , 'click' , function(){
		
		var book_list = $(this).closest('.book_list');
		book_list.addClass('editing');
		book_list.find('.action_span').hide();
		book_list.find('.edit_action_span').show();
		
		var name = book_list.find('.book_name').text();
		TJDataCenter.set('current_editing_book_name' , name);
		
		book_list.find('.book_name').html('<input class="book_name_edit" value="'+name+'"></input>');
		$('.book_name_edit').focus();
		
	});
	
	//编辑状态中点击取消，回复编辑前的状态
	$('.book_wrapper').delegate('.edit_cancel' , 'click' , function(){
		
		if(!$(this).closest('.book_list').hasClass('editing')){
			return;
		}
		
		var book_list = $(this).closest('.book_list');
		book_list.removeClass('editing');
		
		book_list.find('.book_name').text(TJDataCenter.get('current_editing_book_name'));
		
		book_list.find('.edit_action_span').hide();
		book_list.find('.action_span').show();
		
	});
	
	//编辑状态中点击保存
	$('.book_wrapper').delegate('.edit_save' , 'click' , function(){
		
		if(!$(this).closest('.book_list').hasClass('editing')){
			return;
		}
		
		var book_list = $(this).closest('.book_list');
		
		var book_id = book_list.attr('book_id');
		var subject_id = book_list.attr('subject_id');
		var book_name = $.trim(book_list.find('.book_name_edit').val());
		
		if(book_name == TJDataCenter.get('current_editing_book_name')){
			book_list.find('.edit_cancel').click();
		}else{
			dataSubmitObject.modifyBook(book_id , book_name , subject_id)
		}
		
		
	});
	
	//教材列表中点击删除
	$('.book_wrapper').delegate('.delete_book' , 'click' , function(){
		
		if(confirm('确认删除 "'+$(this).parent().prev().text()+'" 吗？')){
			dataSubmitObject.deleteBook($(this).closest('.book_list').attr('book_id') , $(this).closest('.book_list').attr('subject_id'));
		}
	});
	
	
	
	
	
	
});


dataQueryObject.queryPublisherList();
