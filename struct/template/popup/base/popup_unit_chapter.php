<style type='text/css'>

	.edit_name_panel{
		width:204px;
		height:106px;
		margin-top:-50px;
		margin-left:-140px;
	}
	
					
</style>
<div class='popup_panel edit_name_panel' style='display:none;'>
	<div class='popup_head'>
		<div class='popup_title'>编辑</div>
		<div class='popup_close'></div>
	</div>
	<div class='popup_content' style='overflow:hidden;'>
		<div class="content_per">
			<span class="column column_align">*名称</span>
			<span class="value">
				<input type='text' class='input_text edit_name'></input>
			</span>
		</div>
		<div class='confirm_panel'>
			<input type='button' class='input_btn edit_name_cancel' value='取消' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<input type='button' class='input_btn edit_name_submit' value='确定' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<div class='clear_float'></div>
		</div>
	</div>
	<div class='popup_panel_shadow'></div>
</div>
<script type="text/javascript">

//1:编辑，2:插入单元，3:插入章节
TJDataCenter.set('edit_name_type' , 1);

TJEvent.addListener('edit_name_show' , function(e){

	TJDataCenter.set('edit_name_type' , 1);
	$('.edit_name').val(e.data.name);
	$('.edit_name_panel .popup_title').html('*编辑');
	$('.edit_name_panel').show();
	
});

TJEvent.addListener('insert_unit_show' , function(e){

	TJDataCenter.set('edit_name_type' , 2);
	$('.edit_name').val('');
	$('.edit_name_panel .popup_title').html('*新元素');
	$('.edit_name_panel').show();
	
});

TJEvent.addListener('insert_chapter_show' , function(e){

	TJDataCenter.set('edit_name_type' , 3);
	$('.edit_name').val('');
	$('.edit_name_panel .popup_title').html('*新元素');
	$('.edit_name_panel').show();
	
});

TJEvent.addListener('edit_finish' , function(){
	$('.edit_name').val('');
	$('.edit_name_panel').hide();
});

$('.edit_name_cancel').click(function(){
	$('.edit_name').val('');
	$('.edit_name_panel').hide();
	
});

$('.edit_name_submit').click(function(){
	var type = TJDataCenter.get('edit_name_type');
	if(type == 1){
		var e = new TJEvent.EventObject('edit_name_submit');
	}else if(type == 2){
		var e = new TJEvent.EventObject('insert_unit_submit');
	}else if(type == 3){
		var e = new TJEvent.EventObject('insert_chapter_submit');
	}
	e.data.name = $.trim($('.edit_name').val());
	TJEvent.dispatch(e);
});


</script>



<style type='text/css'>

	.data_setin_popup{
		width:640px;
		height:506px;
		margin-top:-250px;
		margin-left:-320px;
	}
	
	.data_setin_popup .column{
		width:40px;
	}
	
	.inner_tree_wrapper{
		position:relative;
		border-top:1px solid #ccc;
		margin-top:5px;
		margin-bottom:10px;
		height:350px;
		border-bottom:1px solid #ccc;
		overflow:auto;
	}
	
	.setin_relation_wrapper{
		position:relative;
		float:right;
		top:6px;
		margin-right:10px; 
		color:#888;
	}
	
	.setin_relation{
		position:relative;
		top:2px;
	}
					
</style>
<div class='popup_panel data_setin_popup' style='display:none;'>
	<div class='popup_head'>
		<div class='popup_title'>导入数据</div>
		<div class='popup_close'></div>
	</div>
	<div class='popup_content' style='overflow:hidden;'>
		
		<?=$search; ?>
		<div class='clear_float'></div>
		<div class='inner_tree_wrapper'>
		<?=$treeHTML; ?>
		</div>
		<div class='confirm_panel'>
			<input type='button' class='input_btn setin_data_cancel' value='取消' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<input type='button' class='input_btn setin_data_submit' value='确定' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<div class='setin_relation_wrapper'>
				<input type='checkbox' class='setin_relation'  id='setin_relation'/><label for='setin_relation'>导入题目数据</label>
			</div>
			<div class='clear_float'></div>
		</div>
	</div>
	<div class='popup_panel_shadow'></div>
</div>
<script type='text/javascript'>

dataQueryObject.popup_unit_chapter = {
	queryTreeData : function(version_id , subject_id , book_id){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/base/unit_chapter_api.php?action=tree_data',
			'type' : 'GET',
			'dataType' : 'jsonp',
			'data' : {
				version : version_id,
				subject : subject_id,
				book : book_id
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('query_tree_success');
					e.data = data;
					e.data.group = 'setin';
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
	}
};

dataSubmitObject.popup_unit_chapter = {
	setinData : function(from_version , from_subject , from_book , to_subject , to_book , relation){

		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/base/unit_chapter_api.php?action=setin_data',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				from_version : from_version,
				from_subject : from_subject,
				from_book : from_book,
				to_subject: to_subject,
				to_book : to_book,
				relation : relation
			},
			success : function(data){
				if(data){
					var e = new TJEvent.EventObject('setin_data_success');
					e.data = data;
					e.data.group = 'setin';
					TJEvent.dispatch(e);
					
				}else{
					var e = new TJEvent.EventObject('setin_data_failed');
					e.data.source = 'unit_chapter_handler.js queryTreeData()';
					TJEvent.dispatch(e);
				}
			},
			error : function(){
				var e = new TJEvent.EventObject('setin_data_failed');
				e.data.source = 'unit_chapter_handler.js queryTreeData()';
				TJEvent.dispatch(e);
			}
		});
		
	}
		
		
};


TJEvent.addListener('book_change' , function(e){

	if(e.data.group == 'setin_search'){

		var version_id = TJDataCenter.get('setin_search_curriculumn_version');
		if(version_id != 0){

			var subject_id = TJDataCenter.get('setin_search_subject');
			var book_id = TJDataCenter.get('setin_search_book');

			dataQueryObject.popup_unit_chapter.queryTreeData(version_id , subject_id , book_id);
			
		}
	}
	
});

TJEvent.addListener('query_tree_success' , function(e){

	if(e.data.group != 'setin'){
		return;
	}


var data = e.data;
	
	var treeData = [];
	
	if(data.unit.length == 0 && data.chapter.length == 0){
		
		treeData.push({id:-1 , name:'暂无数据' , children : [] , attributes : {level : 1 , parent_id : 0 , sort_id : 0}});
		
	}else{
		
		for(var i = 0 ; i < data.unit.length ; i++){
			treeData.push({
				id : data.unit[i].id , 
				name : data.unit[i].unit_name , 
				children : [] , 
				attributes : {
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
							chapter_index : data.chapter[i].chapter_index , 
							type : 'chapter'
						}
					});
				}
			}
		}
		
		
	}
	
// 	var lastElement = TJDataCenter.get('selected_tree_element');
// 	if(lastElement){
// 		TJDataCenter.set('last_tree_element_id' , lastElement.attr('elementid'));
// 	}else{
// 		TJDataCenter.set('last_tree_element_id' , 0);
// 	}
	
	var e1 = new TJEvent.EventObject('refresh_tree');
	e1.data.treeData = treeData;
	e1.data.classSelector = '.setin_tree';
	e1.data.flag = true;
	TJEvent.dispatch(e1);
	
	
});

TJEvent.addListener('setin_data_success' , function(e){
	alert('导入成功');
	$('.data_setin_popup').hide();

	var ev = new TJEvent.EventObject('select_book_change');
	TJEvent.dispatch(ev);
	
});

$('.setin_data_submit').click(function(){
	var book_id = TJDataCenter.get('book_id');

	if(confirm('确认将数据导入到“'+$('.book_list[book_id='+book_id+']').text()+'”中吗?')){

		var to_subject = TJDataCenter.get('origin_search_subject');
		var to_book = TJDataCenter.get('book_id');

		var from_version = TJDataCenter.get('setin_search_curriculumn_version');
		var from_subject = TJDataCenter.get('setin_search_subject');
		var from_book = TJDataCenter.get('setin_search_book');

		var relation = $('.setin_relation')[0].checked ? 1 : 0;
		
		dataSubmitObject.popup_unit_chapter.setinData(from_version , from_subject , from_book , to_subject , to_book , relation);
		
	}
	
});

$('.setin_data_cancel').click(function(){

	$(this).closest('.popup_panel').hide();
	
});

</script>




<script type='text/javascript'>


TJEvent.addListener('popup_show' , function(e){

	$('.popup_panel').hide();
	$('.'+e.data.name+'_popup').show();
	

	TJDataCenter.set('current_pop_panel' , e.data.name);
});


$('.popup_panel .popup_close').click(function(){
	$(this).closest('.popup_panel').hide();
});

$( ".popup_panel" ).draggable({ handle: ".popup_head" });
</script>