//数据查询和提交对象
dataQueryObject = {
	
	queryDetail : function(){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/base/curriculumn_detail_api.php?action=list',
			'type' : 'GET',
			'dataType' : 'jsonp',
			'data' : {
				version : TJDataCenter.get('current_curriculumn') , 
				type : TJDataCenter.get('current_type')
			},
			success : function(data){
				if(data){
					TJDataCenter.set('current_detail_info' , data);
					
					var e = new TJEvent.EventObject('query_detail_success');
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
	
	
};

dataSubmitObject = {
	add2Batch: function(batch_id){
		
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/setout/batch_api.php?action=add_detail',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				batch_id : batch_id,
				detail : TJDataCenter.get('update_element')
			},
			success : function(data){
				if(data){
					
					var e = new TJEvent.EventObject('select_batch_success');
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




//版本改变的时候，清空已选中的类别，根据激活状态改变类别状态
TJEvent.addListener('curriculumn_change' , function(e){
	var curriculumn = TJDataCenter.get('current_curriculumn');
	var type = TJDataCenter.get('current_type');
	
	var zhuanti = $(e.data.target).attr('zhuanti');
	var tongbu = $(e.data.target).attr('tongbu');
	var knowledge = $(e.data.target).attr('knowledge');
	
	$('.type_wrapper a').removeClass('unactive');
	
	if(tongbu == 0){
		$('.type_wrapper a[type=1]').addClass('unactive');
	}
	
	if(knowledge == 0){
		$('.type_wrapper a[type=2]').addClass('unactive');
	}
	
	if(zhuanti == 0){
		$('.type_wrapper a[type=3]').addClass('unactive');
	}
	
	
	//清空类型的值
	$('.type_wrapper .content_tab_select').removeClass('content_tab_select');
	TJDataCenter.set('current_type' , 0);
	
	//清除detail数据
	$('.curriculumn_detail_table tr:not(:eq(0))').remove();
	
//	$('.deny_cover').show();
	
});

//类别改变的时候，先判断当前类别是否激活
TJEvent.addListener('type_change' , function(){
	var curriculumn = TJDataCenter.get('current_curriculumn');
	var type = TJDataCenter.get('current_type');
	
	dataQueryObject.queryDetail();
	
	return;
	
});


TJEvent.addListener('query_detail_success' , function(){
	
	$('.curriculumn_detail_table tr:not(:eq(0))').remove();
	
	var list = TJDataCenter.get('current_detail_info');
	
	var stepLabel = ['创建完毕','数据完毕','修改完毕'];
	for(var i = 0 ; i < list.length ; i++){
		var html = 
		'<tr detail_id="'+list[i].id+'" version_id="'+list[i].version_id+'" subject_id="'+list[i].subject_id+'" section_id="'+list[i].section_id+'" book_id="'+list[i].book_id+'" >'+
			'<td><input type="checkbox" class="input_check"/></td>'+
			'<td>'+list[i].text+'</td>'+
			'<td>'+stepLabel[list[i].step]+'</td>'+
//				'<td>'+
//					'<a class="action_tag_a setin_data '+(list[i].step == 0 ? '' : 'unactive')+'" href="javascript:void(0);">导入数据</a>'+
//					'<a class="action_tag_a clear_data '+(list[i].step == 1 ? '' : 'unactive')+'" href="javascript:void(0);">清除数据</a>'+
//					'<a class="action_tag_a delete_detail '+(list[i].step == 0 ? '' : 'unactive')+'" href="javascript:void(0);">删除</a>'+
//			'</td>'+
		'</tr>'
		$('.curriculumn_detail_table').append(html);
	}
	
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

TJEvent.addListener('select_batch_submit' , function(e){
	
	dataSubmitObject.add2Batch(e.data.batch_id);
	
});

TJEvent.addListener('select_batch_success' , function(){
	alert('添加成功');
	
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
	
	$('.check_all').click(function(){
		$('.curriculumn_detail_table .input_check').attr('checked' , this.checked);
		
	});
	
	$('.action_insert').click(function(){
		
		var insertArray = [];
		$('.input_check:checked:not(.check_all)').each(function(){
			insertArray.push($(this).closest('tr').attr('detail_id'));
		});
		
		if(insertArray.length == 0){
			alert('请选择导出内容');
			return;
		}
		
		TJDataCenter.set('update_element' , insertArray );
		
		var e = new TJEvent.EventObject('select_batch_show');
		TJEvent.dispatch(e);
	});
	
});

