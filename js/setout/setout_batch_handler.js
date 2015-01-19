//数据查询和提交对象
dataQueryObject = {
	
	queryBatchList : function(){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/setout/batch_api.php?action=list',
			'type' : 'GET',
			'dataType' : 'jsonp',
			success : function(data){
				
				$('.setout_batch_template:visible').remove();
				
				for(var i = 0 ; i < data.length ; i++){
					var clone = $('#setout_batch_template').clone();
					clone.attr('batch_id' , data[i].id);
					clone.removeAttr('id');
					clone.find('.batch_id').text(data[i].id);
					clone.find('.batch_name').text(data[i].name);
					clone.find('.batch_time').text(data[i].time);
					clone.insertAfter('.batch_table .table_header').show();
				}
			}
		});
	},
	
	queryBatchDetail : function(batch_id){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/setout/batch_api.php?action=detail',
			'type' : 'GET',
			'dataType' : 'jsonp',
			'data' : {
				batch_id : batch_id
			},
			success : function(data){
				
				TJDataCenter.set('current_batch_detail_info' , data);
				
				var e = new TJEvent.EventObject('query_detail_success');
				TJEvent.dispatch(e);
			
			}
		});
	}
	
};

dataSubmitObject = {
	
	insertBatch : function(name){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/setout/batch_api.php?action=insert',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				name : name
			},
			success : function(data){
				var e = new TJEvent.EventObject('add_setout_batch_success');
				TJEvent.dispatch(e);
			}
		});
	},
	
	removeDetail : function(detail_id){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/setout/batch_api.php?action=remove_detail',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				detail_id : detail_id,
				batch_id : TJDataCenter.get('current_batch_id')
			},
			success : function(data){
				var e = new TJEvent.EventObject('remove_detail_success');
				TJEvent.dispatch(e);
			}
		});
	}
	
};

TJEvent.addListener('batch_detail_remove' , function(e){
	
	dataSubmitObject.removeDetail(e.data.detail_id);
	
});

TJEvent.addListener('add_setout_batch_submit',function(e){
	
	dataSubmitObject.insertBatch(e.data.name);
	
});

TJEvent.addListener('add_setout_batch_success' , function(e){
	dataQueryObject.queryBatchList();
	
});

TJEvent.addListener('query_detail_success' , function(){
	var e = new TJEvent.EventObject('batch_detail_show');
	TJEvent.dispatch(e);
});

TJEvent.addListener('remove_detail_success' , function(){
	
	dataQueryObject.queryBatchDetail(TJDataCenter.get('current_batch_id'));
	
});


$(document).ready(function(){
	
	dataQueryObject.queryBatchList();
	
	$('.action_insert').click(function(){
		var e = new TJEvent.EventObject('add_setout_batch_show');
		TJEvent.dispatch(e);
	});
	
	$('.batch_table').delegate('.show_detail' , 'click' , function(){
		//先查信息，然后显示到列表里
		
		var batch_id = $(this).closest('tr').attr('batch_id');
		TJDataCenter.set('current_batch_id' , batch_id);
		
		dataQueryObject.queryBatchDetail(batch_id);
		
	});
	
});
