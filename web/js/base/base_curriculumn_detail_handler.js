//数据查询和提交对象
dataQueryObject = {
	
	queryDetail : function(){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/base/curriculumn_detail_api.php?action=detail_list',
			'type' : 'GET',
			'dataType' : 'jsonp',
			data : {
				source_type : TJDataCenter.get('source_type')
			},
			success : function(data){
				console.log(data);
				if(data){
					var e = new TJEvent.EventObject('query_detail_success');
					e.data.detail = data;
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
	
	
};


TJEvent.addListener('query_detail_success' , function(e){
	
	var detail = e.data.detail;
	
	$('.detail_item:visible').remove();
	
	for(var i = 0 ; i < detail.length ; i++){
		var clone = $('#detail_item_template').clone().attr('id' , '').show();
		clone.find('.detail_time').text(new Date(detail[i].create_time*1000).getString());
		clone.find('.detail_user').text(detail[i].username);
		clone.find('.detail_st').text(detail[i].type_name);
		clone.find('.detail_action').text(detail[i].action_name);
		clone.find('.detail_entity').text(detail[i].entity);
		clone.find('.detail_entity_name').text(detail[i].entity_name);
//		clone.text(detail[i].username+'在'+detail[i].type_name+'中'+detail[i].action_name+detail[i].entity_name+':' + detail[i].book_name).show();
		$('.detail_wrapper').append(clone);
	}
	
	
	
	
	
});

$(document).ready(function(){
	
	$('.source_type_wrapper .content_tab').click(function(){
		if($(this).hasClass('content_tab_select')){
			return;
		}
		
		$('.content_tab_select').removeClass('content_tab_select');
		$(this).addClass('content_tab_select');
			
		TJDataCenter.set('source_type' , $(this).attr('stid'));
		
		dataQueryObject.queryDetail();
		
	});
	
});
