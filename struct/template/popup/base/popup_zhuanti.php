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

//1:编辑，2:插入子层，3:插入同层
TJDataCenter.set('edit_name_type' , 1);

TJEvent.addListener('edit_name_show' , function(e){

	TJDataCenter.set('edit_name_type' , 1);
	$('.edit_name').val(e.data.name);
	$('.edit_name_panel .popup_title').html('*编辑');
	$('.edit_name_panel').show();
	
});

TJEvent.addListener('insert_children_show' , function(e){

	TJDataCenter.set('edit_name_type' , 2);
	$('.edit_name').val('');
	$('.edit_name_panel .popup_title').html('*新元素');
	$('.edit_name_panel').show();
	
});

TJEvent.addListener('insert_sibling_show' , function(e){

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
		var e = new TJEvent.EventObject('insert_children_submit');
	}else if(type == 3){
		var e = new TJEvent.EventObject('insert_sibling_submit');
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

dataQueryObject.popup_zhuanti = {
	queryTreeData : function(version_id , subject_id , section_id){
		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/base/zhuanti_api.php?action=tree_data',
			'type' : 'GET',
			'dataType' : 'jsonp',
			'data' : {
				version : version_id,
				subject : subject_id,
				section : section_id
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

dataSubmitObject.popup_zhuanti = {
	setinData : function(from_version , from_subject , from_section , to_subject , to_section , relation){

		$.ajax({
			'url' : TJDataCenter.get('webroot')+'/manage_system/api/base/zhuanti_api.php?action=setin_data',
			'type' : 'POST',
			'dataType' : 'jsonp',
			'data' : {
				from_version : from_version,
				from_subject : from_subject,
				from_section : from_section,
				to_subject: to_subject,
				to_section : to_section,
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


TJEvent.addListener('section_change' , function(e){
	
	if(e.data.group != 'setin_search'){
		return;
	}

	var version_id = TJDataCenter.get('setin_search_curriculumn_version');
	var subject_id = TJDataCenter.get('setin_search_subject');
	var section_id = TJDataCenter.get('setin_search_section');

	if(version_id !=0 && subject_id != 0 && section_id !=0){
		
		//选择了学科，学段和版本后，才能获取数据
		dataQueryObject.popup_zhuanti.queryTreeData(version_id , subject_id , section_id);
	}
	
});

TJEvent.addListener('query_tree_success' , function(e){

	if(e.data.group != 'setin'){
		return;
	}


	var data = e.data;
		
	var treeData = [];
	
	if(data.length == 0){
		
		
	}else{
		
		var max = 0;
		//计算最大层数
		for(var i = 0 ; i < data.length ; i++){
			max = Math.max(max , data[i].level);
		}
		
		var tmpDataArray = [];
		//将数据按层次拆分
		for(var i = 0 ; i < max ; i ++){
			tmpDataArray[i] = [];
			
			for(var j = 0 ; j < data.length ; j++){
				if(data[j].level == i+1){
					tmpDataArray[i].push({
						id:e.data[j].id , 
						name:e.data[j].name , 
						parent_id : e.data[j].parent_id , 
						children : []  , 
						attributes : {
							level : data[j].level , 
							parent_id : data[j].parent_id , 
							sort_id : data[j].sort_id , 
							grade_id : data[j].grade_id
						}
					});
				}
			}
		}
		
		//从底层开始寻找元素的父节点
		for(var i = tmpDataArray.length - 1 ; i >= 0 ; i--){
			//遍历当前层
			for(var j = 0 ; j < tmpDataArray[i].length ; j++){
				//如果不是第一层，索引值比层数小1，所以用大于0判断而不是大于1
				if(i > 0){
					//遍历当前层的上一层
					for(var k = 0 ; k < tmpDataArray[i-1].length ; k++){
						//如果当前层当前元素是上一层当前元素的子元素，则赋值,退出循环 
						if(tmpDataArray[i][j].parent_id == tmpDataArray[i-1][k].id){
							tmpDataArray[i-1][k].children.push(tmpDataArray[i][j]);
							break;
						}
					}
				}
			}
		}
		
		//都插入以后，第一层就是所需结果
		treeData = tmpDataArray[0];
// 		treeData.push({id : -1 , name : '专题树' , children : tmpDataArray[0] ,  attributes : {level : 0 , parent_id : 0 , sort_id : 0}});
		
	}
	
	var e1 = new TJEvent.EventObject('refresh_tree');
	e1.data.treeData = treeData;
	e1.data.flag = true;
	e1.data.classSelector = '.setin_tree';
	TJEvent.dispatch(e1);
	
	
});

TJEvent.addListener('setin_data_success' , function(e){
	alert('导入成功');
	$('.data_setin_popup').hide();
// 	var ev = new TJEvent.EventObject('select_book_change');
// 	TJEvent.dispatch(ev);
// 	dataQueryObject.queryTreeData();
	
});

$('.setin_data_submit').click(function(){

	if(confirm('确认导入数据吗?')){

		var to_subject = TJDataCenter.get('origin_search_subject');
		var to_section = TJDataCenter.get('origin_search_section');

		var from_version = TJDataCenter.get('setin_search_curriculumn_version');
		var from_subject = TJDataCenter.get('setin_search_subject');
		var from_section = TJDataCenter.get('setin_search_section');

		var relation = $('.setin_relation')[0].checked ? 1 : 0;
		
		dataSubmitObject.popup_zhuanti.setinData(from_version , from_subject , from_section , to_subject , to_section , relation);
		
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