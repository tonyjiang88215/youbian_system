/**
 * 题目去重页面数据处理中心
 * @Author By TonyJiang
 */

//数据查询和提交对象
dataQueryObject = {
	queryQuestionData : function(){
		
		var subject = TJDataCenter.get('subject');
		
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/source/source_duplicate.php',			
			'type' : 'GET',
			'dataType' : 'jsonp',
			'data' : {
				action : 'list' , 
				subject : subject,
				offset : pagerHandler.offset,
				step : pagerHandler.step
			},
			success : function(data){
				if(!data || data.length == 0){
					data = [{id :0 , name : '暂无数据' , children : []}];
				}
				
				$('.question_table').find('tr:visible:not(.table_header)').remove();
				
				for(var i = 0 ; i < data.data.length ; i++){
					if(data.data[i].repeat_gid != ''){
						continue;
					}
					
					var clone = $('#question_template').clone().removeAttr('id').attr('gid' , data.data[i].gid);
					
					if(TJDataCenter.get('subject') != 3){
						clone.find('.question_answer , .question_analysis').hide();
					}
					
					clone.find('.q_id').html(data.data[i].gid);
					clone.find('.question_stem_content').html(data.data[i].content);
					clone.find('.question_text_content').html(data.data[i].question_text);
					clone.find('.question_answer_content').html(data.data[i].objective_answer);
					clone.find('.question_analysis_content').html(data.data[i].answer);
					
					clone.appendTo('.question_table').show();
					
				}
				
				pagerHandler.setTotalCount(data.count);
				
				var e = new TJEvent.EventObject('query_question_success');
				e.data.treeData = data;
				TJEvent.dispatch(e);
			},
			error : function(){
			}
		});
		
	}
};

dataSubmitObject = {
	
	duplicateQuestion : function(gid , gidArray){
		var subject = TJDataCenter.get('subject');
		
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/source/source_duplicate.php',			
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				action : 'duplicate' , 
				subject : subject,
				gid : gid,
				gidArray : gidArray
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('duplicate_success');
					TJEvent.dispatch(e);
				}else{
					var e = new TJEvent.EventObject('duplicate_failed');
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('duplicate_failed');
				TJEvent.dispatch(e);
			}
		});
		
	}
	
};

TJEvent.addListener('pager_change' , function(){
	dataQueryObject.queryQuestionData();
	
});

TJEvent.addListener('subject_change' ,  function(){
	dataQueryObject.queryQuestionData();
});

TJEvent.addListener('select_gid_submit' , function(e){
	
	var select_gid = e.data.gid;
	var gidArray = TJDataCenter.get('select_gids');
	
	dataSubmitObject.duplicateQuestion(select_gid , gidArray);
	
});

TJEvent.addListener('query_question_success' , function(){
	
});


TJEvent.addListener('duplicate_success' , function(){
	alert('去重成功');
	
	var e = new TJEvent.EventObject('select_gid_panel_hide');
	TJEvent.dispatch(e);
	
	dataQueryObject.queryQuestionData();
});


$(document).ready(function(){
	
	$('.action_deplicate').click(function(){
		
		var duplicateArray = [];
		$('.check_td:visible .input_check:checked').closest('.question_template').each(function(){
			duplicateArray.push($(this).attr('gid'));
		});
		if(duplicateArray.length == 0){
			alert('请选择题目');
			return;
		}
		
		dataSubmitObject.duplicateQuestion(duplicateArray[0] , duplicateArray);
		
//		TJDataCenter.set('select_gids' , duplicateArray);
		
//		var e= new TJEvent.EventObject('select_gid_panel_show');
//		e.data.array = duplicateArray;
//		TJEvent.dispatch(e);
		
		
	});
	
});

