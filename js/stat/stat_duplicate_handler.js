/**
 * 题目去重页面数据处理中心
 * @Author By TonyJiang
 */

//数据查询和提交对象
dataQueryObject = {
	queryDuplicateList : function(){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/stat/duplicate_api.php?action=list',
			'type' : 'GET',
			'data' : {
				subject : TJDataCenter.get('subject')
			},
			'dataType' : 'jsonp',
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('query_duplicate_success');
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
	
};


TJEvent.addListener('subject_change' , function(){
	dataQueryObject.queryDuplicateList();
});

TJEvent.addListener('query_duplicate_success' , function(e){
	$('.question_table tr:not(:eq(0))').remove();
	for(var i = 0 ; i < e.data.length ; i++){
		$('.question_table').append('<tr><td>'+e.data[i].user_id+'</td><td></td><td>'+e.data[i].count+'</td></tr>');
	}
});


$(document).ready(function(){
	
	
});

