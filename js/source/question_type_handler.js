/**
 * 题型管理页面数据处理中心
 * @Author By TonyJiang
 */

var queryDelay = null;

var origin_data = null;

var new_data = null;

//数据查询和提交对象
dataQueryObject = {
	
	queryQuestionType : function(){
		
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/source/question_type_api.php?action=list',
			'type' : 'GET',
			'dataType' : 'jsonp',
			'data' : {
				subject : TJDataCenter.get('subject')
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('query_question_type_success');
					e.data = data;
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

dataSubmitObject = {};

TJEvent.addListener('subject_change' , function(e){
		dataQueryObject.queryQuestionType();
});

TJEvent.addListener('query_question_type_success' , function(e){
	
	var treeData = [];
	for(var i in e.data){
		treeData.push({
			id : e.data[i].question_type_id , 
			name : e.data[i].type_name , 
			attributes : {
				objective_flag : e.data[i].objective_flag
//				template : 
			},
			children : []
		});
	}
	
	var ev = new TJEvent.EventObject('refresh_tree');
	ev.data.treeData = treeData;
	TJEvent.dispatch(ev);
	
});

$(document).ready(function(){
	
	$('.action_insert').click(function(){
		if(TJDataCenter.get('subject') == 0){
			alert('请选择学科');
			return;
		}
		
		
		
		
	});
});

