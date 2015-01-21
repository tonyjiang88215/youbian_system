/**
 * 管理章节单元页面数据处理中心
 * @Author By TonyJiang
**/
//数据查询和提交对象
dataQueryObject = {
	queryTreeData : function(){
		
		$('.action_insert_chapter').hide();
		
		var book_id = TJDataCenter.get('book_id');
		
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/source/unit_chapter_api.php?action=tree_data',
			'type' : 'GET',
			'dataType' : 'jsonp',
			'data' : {
				version : TJDataCenter.get('curriculumn_version'),
				subject : TJDataCenter.get('subject'),
				book : book_id
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('query_tree_success');
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
	
	queryBookData : function(){
		
		var treeData = [{id:-1 , name:'暂无数据' , children : [] , attributes : {level : 1 , parent_id : 0 , sort_id : 0}}];

		var e1 = new TJEvent.EventObject('refresh_tree');
		e1.data.treeData = treeData;
		e1.data.classSelector = '.treeClass';
		e1.data.flag = true;
		TJEvent.dispatch(e1);
		
		
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/source/unit_chapter_api.php?action=book_data',
			'type' : 'GET',
			'dataType' : 'jsonp',
			'data' : {
				subject : TJDataCenter.get('subject'),
				section : TJDataCenter.get('section'),
				publisher : TJDataCenter.get('publisher')
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
	
	insertBook : function(){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/source/unit_chapter_api.php?action=insert_book',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				name : TJDataCenter.get('new_book_name'),
				subject : TJDataCenter.get('new_book_subject'),
				section : TJDataCenter.get('new_book_section'),
				grade : TJDataCenter.get('new_book_grade'),
				publisher : TJDataCenter.get('new_book_publisher')
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('insert_book_success');
					TJEvent.dispatch(e);
				}else{
					var e = new TJEvent.EventObject('insert_book_failed');
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('insert_book_failed');
				TJEvent.dispatch(e);
			}
		});
	},
	
	modifyBook : function(){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/source/unit_chapter_api.php?action=modify_book',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				id : TJDataCenter.get('book_id'),
				name : TJDataCenter.get('new_book_name'),
				subject : TJDataCenter.get('new_book_subject'),
				section : TJDataCenter.get('new_book_section'),
				grade : TJDataCenter.get('new_book_grade'),
				publisher : TJDataCenter.get('new_book_publisher')
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
	
	insertUnit : function(newData){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/source/unit_chapter_api.php?action=insert_unit',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				new_data : newData , 
				version : TJDataCenter.get('curriculumn_version')
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('insert_unit_success');
					TJEvent.dispatch(e);
				}else{
					var e = new TJEvent.EventObject('insert_unit_failed');
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('insert_unit_failed');
				TJEvent.dispatch(e);
			}
		});
	},
	
	insertChapter : function(newData){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/source/unit_chapter_api.php?action=insert_chapter',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				new_data : newData , 
				version : TJDataCenter.get('curriculumn_version')
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('insert_chapter_success');
					TJEvent.dispatch(e);
				}else{
					var e = new TJEvent.EventObject('insert_chapter_failed');
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('insert_chapter_failed');
				TJEvent.dispatch(e);
			}
		});
	},
	
	removeUnit : function(id){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/source/unit_chapter_api.php?action=remove_unit',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				id : id, 
				subject : TJDataCenter.get('subject'),
				version : TJDataCenter.get('curriculumn_version')
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('remove_unit_success');
					TJEvent.dispatch(e);
				}else{
					var e = new TJEvent.EventObject('remove_unit_failed');
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('remove_unit_failed');
				TJEvent.dispatch(e);
			}
		});
	},
	
	removeChapter : function(id){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/source/unit_chapter_api.php?action=remove_chapter',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				id : id, 
				subject : TJDataCenter.get('subject'),
				version : TJDataCenter.get('curriculumn_version')
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('remove_chapter_success');
					TJEvent.dispatch(e);
				}else{
					var e = new TJEvent.EventObject('remove_chapter_failed');
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('remove_chapter_failed');
				TJEvent.dispatch(e);
			}
		});
	},
	
	modifyElement : function(type , id , name){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/source/unit_chapter_api.php?action=modify',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				id : id, 
				subject : TJDataCenter.get('subject'),
				version : TJDataCenter.get('curriculumn_version'),
				name : name,
				type : type
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('modify_element_success');
					TJEvent.dispatch(e);
				}else{
					var e = new TJEvent.EventObject('modify_element_failed');
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('modify_element_failed');
				TJEvent.dispatch(e);
			}
		});
	},
	
	moveUpElement : function(id , type){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/source/unit_chapter_api.php?action=move_up',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				id : id, 
				subject : TJDataCenter.get('subject'),
				version : TJDataCenter.get('curriculumn_version'),
				type : type
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
	
	moveDownElement : function(id ,type){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/source/unit_chapter_api.php?action=move_down',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				id : id, 
				subject : TJDataCenter.get('subject'),
				version : TJDataCenter.get('curriculumn_version'),
				type : type
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
	
	dragChapter : function(info){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/source/unit_chapter_api.php?action=drag',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				chapter : info , 
				subject : TJDataCenter.get('subject'),
				version : TJDataCenter.get('curriculumn_version'),
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('drag_chapter_success');
					TJEvent.dispatch(e);
				}else{
					var e = new TJEvent.EventObject('drag_chapter_failed');
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('drag_chapter_failed');
				TJEvent.dispatch(e);
			}
		});
	}
};

TJEvent.addListener('subject_change' , function(e){
	
	//选择了学科，学段和出版社后，才能获取数据
	if(TJDataCenter.get('subject') != 0 && TJDataCenter.get('section') != 0 && TJDataCenter.get('publisher') != 0){
		dataQueryObject.queryBookData();
	}
	
});

TJEvent.addListener('section_change' , function(e){
	
	//选择了学科，学段和出版社后，才能获取数据
	if(TJDataCenter.get('subject') != 0 && TJDataCenter.get('section') != 0 && TJDataCenter.get('publisher') != 0){
		dataQueryObject.queryBookData();
	}
	
});

TJEvent.addListener('publisher_change' , function(e){
	
	//选择了学科，学段和出版社后，才能获取数据
	if(TJDataCenter.get('subject') != 0 && TJDataCenter.get('section') != 0 && TJDataCenter.get('publisher') != 0){
		dataQueryObject.queryBookData();
	}
});


TJEvent.addListener('book_change' , function(){
	
	var book_id = TJDataCenter.get('book_id');
	var version_id = TJDataCenter.get('curriculumn_version');
	if(book_id != 0 && version_id != 0){
		dataQueryObject.queryTreeData();
	}
	
});

TJEvent.addListener('curriculumn_version_change' , function(){
	
	var book_id = TJDataCenter.get('book_id');
	var version_id = TJDataCenter.get('curriculumn_version');
	if(book_id != 0 && version_id != 0){
		dataQueryObject.queryTreeData();
	}
	
});

TJEvent.addListener('tree_element_selected' , function(e){
	var current_element = TJDataCenter.get('selected_tree_element');
	if(current_element.attr('type') == 'unit'){
		TJDataCenter.set('current_unit_id' , current_element.attr('elementid'));
		TJDataCenter.set('current_unit_code' , current_element.attr('unit_code'));
		$('.action_insert_chapter').show();
	}else{
		$('.action_insert_chapter').hide();
	}
});

TJEvent.addListener('query_book_success' , function(e){
	
	$('.book_wrapper').html('');
	
	var bookHTML = '';
	
	for(var i = 0 ; i < e.data.length ; i++){
		bookHTML += '<div class="book_list" book_id="'+e.data[i].id+'" grade_id="'+e.data[i].grade_id+'" publisher_id="'+e.data[i].publisher_id+'" pub_id="'+e.data[i].pub_id+'" book_code="'+e.data[i].book_code+'">'+e.data[i].book_name+'</div>';
	} 
	
	if(e.data.length == 0){
		bookHTML = '<div style="color:#C1C1C1;">暂无</div>';
	}
	
//	console.log($('.select_book'));
	$('.book_wrapper').append(bookHTML);
	
	TJDataCenter.set('book_id' , 0);
	
});

TJEvent.addListener('query_tree_success',function(e){
	
	var data = e.data;
	
	var treeData = [];
	
	if(data.unit.length == 0 && data.chapter.length == 0){
		
		treeData.push({id:-1 , name:'暂无数据,请导入' , children : [] , attributes : {level : 1 , parent_id : 0 , sort_id : 0}});
		
	}else{
		
		for(var i = 0 ; i < data.unit.length ; i++){
			treeData.push({
				id : data.unit[i].id , 
				name : data.unit[i].unit , 
				children : [] , 
				attributes : {
					unit_code : data.unit[i].unit_code , 
					unit_index : data.unit[i].unit_index , 
					type : 'unit'
				} 
			});
		}
		
		for(var i = 0 ; i < data.chapter.length ; i++){
			for(var j = 0 ; j < treeData.length ; j++){
				if(data.chapter[i].unit_id == treeData[j].id){
					treeData[j].children.push({
						id : data.chapter[i].id , 
						name : data.chapter[i].chapter_name , 
						children : [],
						attributes : {
							chapter_code : data.chapter[i].chapter_code , 
							chapter_index : data.chapter[i].chapter_index , 
							type : 'chapter'
						}
					});
				}
			}
		}
		
		
	}
	
	var lastElement = TJDataCenter.get('selected_tree_element');
	if(lastElement){
		TJDataCenter.set('last_tree_element_id' , lastElement.attr('elementid'));
	}else{
		TJDataCenter.set('last_tree_element_id' , 0);
	}
	
	var e1 = new TJEvent.EventObject('refresh_tree');
	e1.data.treeData = treeData;
	e1.data.classSelector = '.treeClass';
	e1.data.flag = true;
	TJEvent.dispatch(e1);
});

TJEvent.addListener('query_tree_failed' , function(){
	var treeData = [];
	treeData.push({id:-1 , name:'暂无数据' , children : [] , attributes : {level : 1 , parent_id : 0 , sort_id : 0}});
	var e = new TJEvent.EventObject('refresh_tree');
	e.data.classSelector = '.treeClass';
	e.data.treeData = treeData;
	
	TJEvent.dispatch(e);
});

TJEvent.addListener('refresh_tree_success' , function(e){
	var last_id = TJDataCenter.get('last_tree_element_id');
	if(last_id){
		setTimeout(function(){
			$('li[elementid='+last_id+']').find('a').click().focus();
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
	
	var id = TJDataCenter.get('dbclick_tree_element').attr('elementid');
	var type = TJDataCenter.get('dbclick_tree_element').attr('type');
	
	dataSubmitObject.modifyElement(type ,  id , e.data.name);

});


TJEvent.addListener('insert_unit_submit' , function(e){
	
	var data = {
		pub_id : TJDataCenter.get('pub_id'),
		book_id : TJDataCenter.get('book_id'),
		book_code : TJDataCenter.get('book_code'),
		unit : e.data.name,
		unit_index : parseInt($('#treeNavDIV a[type=unit]:last').attr('unit_index'))+1,
		subject_id : TJDataCenter.get('subject'),
		grade_id : TJDataCenter.get('grade_id'),
		section_id : TJDataCenter.get('section'),
		source : '',
		version_id : TJDataCenter.get('curriculumn_version')
	};
	
	data.unit_code = data.unit_index.pad(2);
	
	dataSubmitObject.insertUnit(data);	
	
});

TJEvent.addListener('modify_element_success' , function(){
	dataQueryObject.queryTreeData();
	
	var ev = new TJEvent.EventObject('edit_finish');
	TJEvent.dispatch(ev);
	
});

TJEvent.addListener('insert_unit_success' , function(){
	
	dataQueryObject.queryTreeData();
	
	var ev = new TJEvent.EventObject('edit_finish');
	TJEvent.dispatch(ev);
	
});

TJEvent.addListener('insert_chapter_submit' , function(e){
	var data = {
		chapter_name : e.data.name,
		chapter_index : parseInt(TJDataCenter.get('selected_tree_element').closest('li').next().find('a:last').attr('chapter_index'))+1,
		book_id : TJDataCenter.get('book_id'),
		unit_id : TJDataCenter.get('current_unit_id'),
		unit_code : TJDataCenter.get('current_unit_code'),
		pub_id : TJDataCenter.get('pub_id'),
		book_code : TJDataCenter.get('book_code'),
		subject_id : TJDataCenter.get('subject'),
		grade_id : TJDataCenter.get('grade_id'),
		section_id : TJDataCenter.get('section'),
		source : '',
		version_id : TJDataCenter.get('curriculumn_version')
	};
	
	data.chapter_code = data.chapter_index.pad(2);
	
	dataSubmitObject.insertChapter(data);	
	
});

TJEvent.addListener('insert_chapter_success', function(){
	dataQueryObject.queryTreeData();
	
	var ev = new TJEvent.EventObject('edit_finish');
	TJEvent.dispatch(ev);
});

TJEvent.addListener('remove_unit_success' , function(){
	
	dataQueryObject.queryTreeData();
	
});

TJEvent.addListener('remove_chapter_success' , function(){
	
	dataQueryObject.queryTreeData();
	
});

TJEvent.addListener('move_up_success' , function(){
	
	dataQueryObject.queryTreeData();
	
});

TJEvent.addListener('move_down_success' , function(){
	
	dataQueryObject.queryTreeData();
	
});

TJEvent.addListener('new_book_submit' , function(){
	dataSubmitObject.insertBook();
});

TJEvent.addListener('edit_book_submit' , function(){
	dataSubmitObject.modifyBook();
});


TJEvent.addListener('insert_book_success' , function(){
	
	dataQueryObject.queryBookData();
	
	var e = new TJEvent.EventObject('add_book_finish');
	TJEvent.dispatch(e);
});

TJEvent.addListener('modify_book_success' , function(){
	dataQueryObject.queryBookData();
	
	var e = new TJEvent.EventObject('edit_book_finish');
	TJEvent.dispatch(e);
});

//拖拽修改位置时处理
TJEvent.addListener('drop_tree_element' , function(e){
	
	if($(e.data.object).find('a').attr('type') != 'chapter'){
		alert('只能拖拽章节');
		return;
	}
	
	if($(e.data.target).find('a').attr('type') != 'unit'){
		alert('请将章节拖拽到单元上');
		return;
	}
	
	var info = {
		id : $(e.data.object).attr('elementid'),
		unit_id : $(e.data.target).attr('elementid'),
		unit_code : $(e.data.target).attr('unit_code'),
		chapter_index : $(e.data.target).next().children('.child_ul').children('li[elementid]').length + 1
	};
	info.chapter_code = info.chapter_index.pad(2);
	
	dataSubmitObject.dragChapter(info);
	
});

TJEvent.addListener('drag_chapter_success' , function(e){
	dataQueryObject.queryTreeData();
});

$(document).ready(function(){
	
	//点击版本时效果及事件
	$('.select_version').click(function(){
		
		if($(this).hasClass('unactive')){
			return;
		}
		
		$('.content_tab_select').removeClass('content_tab_select');
		$(this).addClass('content_tab_select');
		
		TJDataCenter.set('curriculumn_version' , $(this).attr('version_id'));
		
		var e = new TJEvent.EventObject('curriculumn_version_change');
		TJEvent.dispatch(e);
		
	});
	
	$('.book_wrapper').delegate('.book_list' , 'click' , function(){
		
		var book = $(this);
		
		TJDataCenter.set('book_id' , book.attr('book_id'));
		TJDataCenter.set('book_code' , book.attr('book_code'));
		TJDataCenter.set('pub_id' , book.attr('pub_id'));
		TJDataCenter.set('publisher_id' , book.attr('publisher_id'));
		TJDataCenter.set('grade_id' , book.attr('grade_id'));
		
		$('.book_list').css('background' , '');
		$(this).css('background' , '#DFE8F3');
		
		var e = new TJEvent.EventObject('book_change');
		TJEvent.dispatch(e);
	});
	
//	$('.book_wrapper').delegate('.book_list' , 'dblclick' , function(){
//		
//		TJDataCenter.set('current_book_name' , $(this).text());
//		TJDataCenter.set('current_book_grade' , $(this).attr('grade_id'));
//		
//		var e = new TJEvent.EventObject('popup_show');
//		e.data.name = 'edit_book';
//		TJEvent.dispatch(e);
//		
//	});
	
	$('.action_insert_unit').click(function(){
		var e = new TJEvent.EventObject('insert_unit_show');
		TJEvent.dispatch(e);
	});
	
	$('.action_insert_chapter').click(function(){
		var e = new TJEvent.EventObject('insert_chapter_show');
		TJEvent.dispatch(e);
	});
	
	$('.action_delete').click(function(){
		var selectElement = TJDataCenter.get('selected_tree_element');
		if(!selectElement){
			alert('请选择单元或章节');
			return;
		}else{
			if(selectElement.attr('type') == 'unit'){
				dataSubmitObject.removeUnit(selectElement.attr('elementid'));
			}else if(selectElement.attr('type') == 'chapter'){
				dataSubmitObject.removeChapter(selectElement.attr('elementid'));
			}
		}
	});
	
	//节点上移
	$('.action_move_up').click(function(){
		if(TJTree.checkFirst()){
			alert('已经到顶啦');
			return;
		}else{
			var selectElement = TJDataCenter.get('selected_tree_element');
			dataSubmitObject.moveUpElement(selectElement.attr('elementid') , selectElement.attr('type'));
		}
	});
	
	//节点下移
	$('.action_move_down').click(function(){
		if(TJTree.checkLast()){
			alert('已经到底啦');
			return;
		}else{
			var selectElement = TJDataCenter.get('selected_tree_element');
			dataSubmitObject.moveDownElement(selectElement.attr('elementid') , selectElement.attr('type'));
		}
	});
	
	$('.action_insert_book').click(function(){
		
		var e = new TJEvent.EventObject('popup_show');
		e.data.name = 'add_book';
		TJEvent.dispatch(e);
		
	});
	
});
