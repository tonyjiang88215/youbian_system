<?
if($popPanels['knowledgeList']['show']){
?>
<style type='text/css'>

.popup_panel{
	width:850px;
	height:500px;
	margin-top:-250px;
	margin-left:-350px;
}

.knowledge_list_popup{
	height:533px;
}

.knowledge_list_popup  .popup_content{
	overflow:auto;
}

.knowledge_select_wrapper{
	position:relative;
	border-bottom:1px solid #c1c1c1;	
	padding:5px 10px;
	padding-bottom:10px;
	min-height:50px;
}

.knowledge_select_wrapper_title{
	position:relative;
}

.knowledge_select{
	position:relative;
	float:left;
	border:1px solid #d1d1d1;
	padding:2px 3px;
	margin-right:5px;
	margin-top:5px;
}

.knowledge_select_cancel{
	cursor:pointer;
	position:relative;
	display:inline-block;
	width:13px;
	height:13px;
	top:2px;
	*top:-2px;
	background:url('/manage_system/pic/manage_system/orange_cancel.png');
}

.knowledge_list{
	position:relative;
	padding:5px 10px;
	padding-bottom:10px;
	border-bottom:1px solid #c1c1c1;
	height:340px;
	overflow-y:auto;
}

.knowledge_list_title{
	position:relative;
}

.knowledge_list_content{
	position:relative;
	padding:5px 10px;
}

.knowledge_list_column{
	position:relative;
	float:left;
	width:150px;
	height:260px;
	margin:0px 3px;
}

.knowledge_column_title{
	position:relative;
}

.knowledge_column_content{
	position: absolute;
	top: 18px;
	left: 0;
	right: 0;
	bottom: 0;
	border:1px solid #d1d1d1;
	overflow-y:scroll;
}

.knowledge_content_list{
	postion:relative;
	padding:2px 0 2px 5px;
	cursor:pointer;
}

.knowledge_content_list:hover{
	background:#eef2f7;
}

.knowledge_content_list_select{
	background  :rgb(223, 232, 243);
}

.confirm_panel{
	position:relative;
	padding:5px 10px;
}

</style>
<div class='popup_panel knowledge_list_popup' style='display:none;'>
	<div class='popup_head'>
		<div class='popup_title'>知识点</div>
		<div class='popup_close'></div>
	</div>
	<div class='popup_content'>
		<div class='knowledge_select_wrapper'>
			<div class='knowledge_select_wrapper_title'>
				<div class='title_line_left'></div>
				<div class='title_label'>已选择知识点</div>
				<div class='title_line_right' style='left:110px;top:10px;'></div>
				<div class='clear_float'></div>
			</div>
			<div class='knowledge_select' id='knowledge_select_template' style='display:none'>
				<span class='knowledge_select_label'></span>
				<span class='knowledge_select_cancel'></span>
			</div>
			<div class='clear_float'></div>
		</div>
		<div class='knowledge_list'>
			<div class='knowledge_list_title'>
				<div class='title_line_left'></div>
				<div class='title_label'>知识点</div>
				<div class='title_line_right' style='left:68px;top:10px;'></div>
				<div class='clear_float'></div>
			</div>
			<div class='knowledge_list_content'>
				<div class='knowledge_list_column' id='knowledge_list_column_template' style='display:none;'>
					<div class='knowledge_column_title'>一级知识点</div>
					<div class='knowledge_column_content'></div>
				</div>
				<div class='knowledge_content_list' id='knowledge_content_list_template' style='display:none;'></div>
				<div class='clear_float'></div>
				
			</div>
		</div>
		<div class='confirm_panel'>
			<input type='button' class='input_btn select_knowledge_cancel' value='取消' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<input type='button' class='input_btn select_knowledge_submit' value='确定' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<div class='clear_float'></div>
		</div>
	</div>
	<div class='popup_panel_shadow'></div>
</div>
<script type='text/javascript'>
/** 知识点弹出框JS */
TJDataCenter.set('select_knowledge_list' , []);

TJEvent.addListener('knowledge_panel_show' , function(e){

	$('.knowledge_list_popup').show();
	
});

//监听外部需要刷新知识点列表
TJEvent.addListener('knowledge_list_refresh' , function(e){
	
	var knowledge_list = TJDataCenter.get('knowledge_list');

	var columnCount = [];

	var level1 = [];

	var indexChinese = ['一','二','三','四','五','六','七','八','九'];

	for(var i = 0 ; i < knowledge_list.length ; i++){
		if(columnCount.indexOf(knowledge_list[i].level) == -1){
			columnCount.push(knowledge_list[i].level);
		}
		if(knowledge_list[i].level == 1){
			level1.push(knowledge_list[i]);
		}
	}
	
	
	if(e.data.knowledge_id){
		TJDataCenter.set('select_knowledge_list' , e.data.knowledge_id);
	}else{
		TJDataCenter.set('select_knowledge_list' , []);
	}
	
	var select_knowledge_list = TJDataCenter.get('select_knowledge_list');
	var knowledge_list_bak = select_knowledge_list.slice(0);

	TJDataCenter.set('select_knowledge_list_bak' , knowledge_list_bak);

	$('.knowledge_select:not(:last)').remove()
	//显示已经选中的
	for(var i = 0 ; i < select_knowledge_list.length ; i++){
		for(var j = 0 ; j < knowledge_list.length ; j++){
			if(select_knowledge_list[i] == knowledge_list[j].id){
				var clone = $('#knowledge_select_template').clone().removeAttr('id');
				clone.find('.knowledge_select_label').text(knowledge_list[j].name).attr('knowledge_id' , knowledge_list[j].id);
				clone.insertBefore('#knowledge_select_template').show();
				break;
			}
			
		}
	}

	if(e.data.newData){
		$('.knowledge_list_column:not(:eq(0))').remove();
		
		//	根据知识点层数，先显示每层的边框
		for(var i = 0 ; i <columnCount.length ; i++){
			var clone = $('#knowledge_list_column_template').clone().removeAttr('id').attr('index' , i);
			clone.find('.knowledge_column_title').html(indexChinese[i]+'级知识点');
			clone.appendTo($('#knowledge_list_column_template').parent()).show();
		}

		$('.knowledge_list_content').append('<div class="clear_float"></div>');
	
		//将第一层的节点做出来
		for(var i = 0 ; i < level1.length ; i++){
	
			var clone = $('#knowledge_content_list_template').clone().removeAttr('id');
			clone.text(level1[i].name).attr('knowledge_id',level1[i].id);
			clone.appendTo($('.knowledge_list_column[index=0]').find('.knowledge_column_content')).show();
			
		}
	}
	
});
	
//选择知识点时的事件
$(document).delegate('.knowledge_content_list' , 'click' , function(){
	$(this).closest('.knowledge_column_content').find('.knowledge_content_list').css('background','');
	$(this).css('background' , '#DFE8F3');

	var knowledge_id = $(this).attr('knowledge_id');

	var hasChildren = false;

	//如果还有自节点，选遍历当前层下一层的节点
	if( $(this).closest('.knowledge_list_column').next('.knowledge_list_column').length > 0 ){

		var parent = $(this).closest('.knowledge_list_column').next('.knowledge_list_column');

		parent.find('.knowledge_content_list').remove();

		var knowledge_list = TJDataCenter.get('knowledge_list');

		var index = parseInt($(this).closest('.knowledge_list_column').attr('index'))+1;

		for(var i = 0 ; i < knowledge_list.length ; i++){
			//如果找到了，说明当前不是子层
			if(knowledge_list[i].level == index+1 && knowledge_list[i].parent_id == knowledge_id){
				hasChildren = true;
				var clone = $('#knowledge_content_list_template').clone().removeAttr('id');
				clone.text(knowledge_list[i].name).attr('knowledge_id' , knowledge_list[i].id).appendTo(parent.find('.knowledge_column_content')).show();
			}	
		}
	}

	//如果没有找到，而且ID号不存在在已选列表里
	if(!hasChildren && TJDataCenter.get('select_knowledge_list').indexOf(knowledge_id) == -1){
		var clone = $('#knowledge_select_template').clone().removeAttr('id');
		clone.find('.knowledge_select_label').text($(this).text()).attr('knowledge_id' , knowledge_id);
		clone.insertBefore('#knowledge_select_template').show();
		TJDataCenter.get('select_knowledge_list').push(knowledge_id);
	
	}
});

$(document).delegate('.knowledge_content_list' , 'dblclick' , function(){

	var knowledge_id = $(this).attr('knowledge_id');
	
	//如果没有找到，而且ID号不存在在已选列表里
	if(TJDataCenter.get('select_knowledge_list').indexOf(knowledge_id) == -1){
		var clone = $('#knowledge_select_template').clone().removeAttr('id');
		clone.find('.knowledge_select_label').text($(this).text()).attr('knowledge_id' , knowledge_id);
		clone.insertBefore('#knowledge_select_template').show();
		TJDataCenter.get('select_knowledge_list').push(knowledge_id);
	
	}
	
});

//删除已选择知识点按钮
$(document).delegate('.knowledge_select_cancel' , 'click' , function(){

	var knowledge_id = $(this).siblings('.knowledge_select_label').attr('knowledge_id');
	$(this).closest('.knowledge_select').remove();

	var selectList = TJDataCenter.get('select_knowledge_list');

	selectList.splice(selectList.indexOf(knowledge_id) , 1);

	TJDataCenter.set('select_knowledge_list', selectList);
	
});

$('.select_knowledge_cancel').click(function(){

	var knowledge_list = TJDataCenter.get('select_knowledge_list');
	knowledge_list.length = 0;

	var bak = TJDataCenter.get('select_knowledge_list_bak');
	
	for(var i = 0 ; i < bak.length ; i++){
		knowledge_list.push(bak[i]);
	}
	$(this).closest('.popup_panel').hide();
	
});

$('.select_knowledge_submit').click(function(){
	var text = [];
	$('.knowledge_select_label:visible').each(function(){
		text.push($(this).text());
	});

	var e = new TJEvent.EventObject('select_knowledge_submit');
	e.data.text = text;
	e.data.id = TJDataCenter.get('select_knowledge_list');
	TJEvent.dispatch(e);

	$(this).closest('.popup_panel').hide();
	
});

</script>
<?
}
?>



<?
if($popPanels['addExam']['show']){
?>
<style type='text/css'>

.add_exam_popup{
	width:240px;
	height:320px;
	margin-top:-160px;
	margin-left:-120px;
}

.add_exam_popup .column{
	width:55px;
}
</style>
<div class='popup_panel add_exam_popup' style='display:none;'>
	<div class='popup_head'>
		<div class='popup_title'>新增试卷</div>
		<div class='popup_close'></div>
	</div>
	<div class='popup_content' style='overflow:hidden;'>
		<div class="content_per">
			<span class="column column_align">*学段</span>
			<span class="value">
				<select class='input_select new_exam_section'>
					<option value=0>------请选择------</option>
					<?
						foreach($popPanels['addExam']['data']['section'] as $v){
					?>
						<option value='<?=$v['id'] ?>'><?=$v['name']; ?></option>
					<?		
						}	
					?>
				</select>
			</span>
		</div>
		<div class="content_per">
			<span class="column column_align">*学科</span>
			<span class="value">
				<select class='input_select new_exam_subject'>
					<option value=0>------请选择------</option>
					<?
						foreach($popPanels['addExam']['data']['subject'] as $v){
					?>
						<option value='<?=$v['id'] ?>'><?=$v['name']; ?></option>
					<?		
						}	
					?>
				</select>
			</span>
		</div>
		<div class='content_per search_year'>
			<span class='column column_align'>*年份</span>
			<span class='value'>
				<select class='input_select new_exam_year' >
					<option value=0>------请选择------</option>
					<?
						foreach($popPanels['addExam']['data']['year'] as $v){
					?>
					<option value='<?=$v['id'] ?>'><?=$v['name']; ?></option>
					<?		
						}	
					?>
				</select>
			</span>
		</div>
		<div class='content_per search_area'>
			<span class='column column_align'>*地区</span>
			<span class='value'>
				<select class='input_select new_exam_area'>
					<option value=0>------请选择------</option>
					<?
						foreach($popPanels['addExam']['data']['area'] as $v){
					?>
					<option value='<?=$v['id'] ?>'><?=$v['name']; ?></option>
					<?		
						}	
					?>
				</select>
			</span>
		</div>
		<div class='content_per search_zhenti_flag'>
			<span class='column column_align'>*真题</span>
			<span class='value'>
				<select class='input_select new_exam_zhenti'>
					<option value=0>------请选择------</option>
					<option value='1'>是</option>
					<option value='2'>否</option>
				</select>
			</span>
		</div>
		<div class="content_per">
			<span class="column column_align">*试卷名称</span>
			<span class="value">
				<input type='text' class='input_text exam_name'></input>
			</span>
		</div>
		<div class="content_per">
			<span class="column column_align">*试卷时长</span>
			<span class="value">
				<input type='text' class='input_text exam_time'></input>
			</span>
		</div>
		<div class='clear_float'></div>
		<div class='confirm_panel'>
			<input type='button' class='input_btn add_exam_cancel' value='取消' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<input type='button' class='input_btn add_exam_submit' value='确定' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<div class='clear_float'></div>
		</div>
	</div>
	<div class='popup_panel_shadow'></div>
</div>
<script type='text/javascript'>

/**新增试卷弹出框JS **/

TJEvent.addListener('section_change' , function(e){

	$('.add_exam_popup .new_exam_section').val(TJDataCenter.get('section'));
	
});

TJEvent.addListener('subject_change' , function(e){

	$('.add_exam_popup .new_exam_subject').val(TJDataCenter.get('subject'));
	
});

TJEvent.addListener('year_change' , function(e){

	$('.add_exam_popup .new_exam_year').val(TJDataCenter.get('year'));
	
});

TJEvent.addListener('area_change' , function(e){

	$('.add_exam_popup .new_exam_area').val(TJDataCenter.get('area'));
	
});

TJEvent.addListener('zhenti_change' , function(e){

	$('.add_exam_popup .new_exam_zhenti').val(TJDataCenter.get('zhenti'));
	
});

TJEvent.addListener('add_exam_show' , function(e){

	$('.add_exam_popup').show();
	
});

TJEvent.addListener('new_exam_success' , function(e){

	$('.add_exam_popup').hide();
	$('.add_exam_popup .exam_name').val('');
	$('.add_exam_popup .exam_time').val('');

	var e = new TJEvent.EventObject('reload_tree_data');
	TJEvent.dispatch(e);
	
});

TJEvent.addListener('new_exam_failed' , function(e){

	alert('新增试卷失败，请稍后再试');
	
});

//添加考卷
$('.add_exam_submit').click(function(){

	var exam_section = parseInt($('.add_exam_popup .new_exam_section').val());

	if(!exam_section){
		alert('请选择学段');
		return;
	}

	var exam_subject = parseInt($('.add_exam_popup .new_exam_subject').val());

	if(!exam_subject){
		alert('请选择学科');
		return;
	}

	var exam_year = $('.add_exam_popup .new_exam_year').val();
	
	if(exam_year== 0){
		alert('请选择年份');
		return;
	}

	var exam_area = parseInt($('.add_exam_popup .new_exam_area').val());

	if(!exam_area){
		alert('请选择地区');
		return;
	}

	var exam_zhenti = parseInt($('.add_exam_popup .new_exam_zhenti').val());

	if(!exam_zhenti){
		alert('请选择是否为真题');
		return;
	}

	var exam_name =$.trim($('.add_exam_popup .exam_name').val());

	if(exam_name == ''){
		alert('请填写试卷名称');
		return;
	}

	var exam_time = $.trim($('.add_exam_popup .exam_time').val());
	
	if(exam_time == ''){
		alert('请填写试卷时长');
		return;
	}

	var e = new TJEvent.EventObject('add_exam_submit');
	e.data.exam_section = exam_section;
	e.data.exam_subject = exam_subject;
	e.data.exam_year = exam_year;
	e.data.exam_area = exam_area;
	e.data.exam_zhenti = exam_zhenti;
 	e.data.exam_name = exam_name;
	e.data.exam_time = exam_time;
	TJEvent.dispatch(e);
});

$('.add_exam_popup .add_exam_cancel').click(function(){
	$('.exam_name').val('');
	$('.exam_time').val('');
	$('.add_exam_popup').hide();
});

</script>

<?
}
?>


<?
if($popPanels['modifyExam']['show']){
?>
<style type='text/css'>

.modify_exam_popup{
	width:240px;
	height:320px;
	margin-top:-160px;
	margin-left:-120px;
}

.modify_exam_popup .column{
	width:55px;
}
</style>
<div class='popup_panel modify_exam_popup' style='display:none;'>
	<div class='popup_head'>
		<div class='popup_title'>编辑试卷</div>
		<div class='popup_close'></div>
	</div>
	<div class='popup_content' style='overflow:hidden;'>
		<div class="content_per">
			<span class="column column_align">*学段</span>
			<span class="value">
				<select class='input_select modify_exam_section'>
					<option value=0>------请选择------</option>
					<?
						foreach($popPanels['modifyExam']['data']['section'] as $v){
					?>
						<option value='<?=$v['id'] ?>'><?=$v['name']; ?></option>
					<?		
						}	
					?>
				</select>
			</span>
		</div>
		<div class="content_per">
			<span class="column column_align">*学科</span>
			<span class="value">
				<select class='input_select modify_exam_subject'>
					<option value=0>------请选择------</option>
					<?
						foreach($popPanels['modifyExam']['data']['subject'] as $v){
					?>
						<option value='<?=$v['id'] ?>'><?=$v['name']; ?></option>
					<?		
						}	
					?>
				</select>
			</span>
		</div>
		<div class='content_per search_year'>
			<span class='column column_align'>*年份</span>
			<span class='value'>
				<select class='input_select modify_exam_year' >
					<option value=0>------请选择------</option>
					<?
						foreach($popPanels['modifyExam']['data']['year'] as $v){
					?>
					<option value='<?=$v['id'] ?>'><?=$v['name']; ?></option>
					<?		
						}	
					?>
				</select>
			</span>
		</div>
		<div class='content_per search_area'>
			<span class='column column_align'>*地区</span>
			<span class='value'>
				<select class='input_select modify_exam_area'>
					<option value=0>------请选择------</option>
					<?
						foreach($popPanels['modifyExam']['data']['area'] as $v){
					?>
					<option value='<?=$v['id'] ?>'><?=$v['name']; ?></option>
					<?		
						}	
					?>
				</select>
			</span>
		</div>
		<div class='content_per search_zhenti_flag'>
			<span class='column column_align'>*真题</span>
			<span class='value'>
				<select class='input_select modify_exam_zhenti'>
					<option value=0>------请选择------</option>
					<option value='1'>是</option>
					<option value='2'>否</option>
				</select>
			</span>
		</div>
		<div class="content_per">
			<span class="column column_align">*试卷名称</span>
			<span class="value">
				<input type='text' class='input_text exam_name'></input>
			</span>
		</div>
		<div class="content_per">
			<span class="column column_align">*试卷时长</span>
			<span class="value">
				<input type='text' class='input_text exam_time'></input>
			</span>
		</div>
		<div class='clear_float'></div>
		<div class='confirm_panel'>
			<input type='button' class='input_btn modify_exam_cancel' value='取消' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<input type='button' class='input_btn modify_exam_submit' value='确定' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<div class='clear_float'></div>
		</div>
	</div>
	<div class='popup_panel_shadow'></div>
</div>
<script type='text/javascript'>

/**新增试卷弹出框JS **/


TJEvent.addListener('modify_exam_show' , function(e){
	
	$('.modify_exam_popup .modify_exam_section').val(e.data.section);
	$('.modify_exam_popup .modify_exam_subject').val(e.data.subject);
	$('.modify_exam_popup .modify_exam_year').val(e.data.year);
	$('.modify_exam_popup .modify_exam_area').val(e.data.area);
	$('.modify_exam_popup .modify_exam_zhenti').val(e.data.exam_type);
	$('.modify_exam_popup .exam_name').val(e.data.exam_name);
	$('.modify_exam_popup .exam_time').val(e.data.exam_time);

	$('.modify_exam_popup').show();
});


TJEvent.addListener('modify_exam_success' , function(e){

	$('.modify_exam_popup').hide();
	$('.modify_exam_popup .exam_name').val('');
	$('.modify_exam_popup .exam_time').val('');

	var e = new TJEvent.EventObject('reload_tree_data');
	TJEvent.dispatch(e);
	
});

TJEvent.addListener('new_exam_failed' , function(e){

	alert('新增试卷失败，请稍后再试');
	
});

//保存考卷
$('.modify_exam_submit').click(function(){

	var exam_section = parseInt($('.modify_exam_popup .modify_exam_section').val());

	if(!exam_section){
		alert('请选择学段');
		return;
	}

	var exam_subject = parseInt($('.modify_exam_popup .modify_exam_subject').val());

	if(!exam_subject){
		alert('请选择学科');
		return;
	}

	var exam_year = $('.modify_exam_popup .modify_exam_year').val();

	if(exam_year == 0){
		alert('请选择年份');
		return;
	}

	var exam_area = parseInt($('.modify_exam_popup .modify_exam_area').val());

	if(!exam_area){
		alert('请选择地区');
		return;
	}

	var exam_zhenti = parseInt($('.modify_exam_popup .modify_exam_zhenti').val());

	if(!exam_zhenti){
		alert('请选择是否为真题');
		return;
	}

	var exam_name =$.trim($('.modify_exam_popup .exam_name').val());

	if(exam_name == ''){
		alert('请填写试卷名称');
		return;
	}

	var exam_time = $.trim($('.modify_exam_popup .exam_time').val());
	
	if(exam_time == ''){
		alert('请填写试卷时长');
		return;
	}

	var e = new TJEvent.EventObject('modify_exam_submit');
	e.data.exam_section = exam_section;
	e.data.exam_subject = exam_subject;
	e.data.exam_year = exam_year;
	e.data.exam_area = exam_area;
	e.data.exam_zhenti = exam_zhenti;
 	e.data.exam_name = exam_name;
	e.data.exam_time = exam_time;
	TJEvent.dispatch(e);
});

$('.modify_exam_popup .modify_exam_cancel').click(function(){
	$('.exam_name').val('');
	$('.exam_time').val('');
	$('.modify_exam_popup').hide();
});

</script>

<?
}
?>



<?
if($popPanels['uploadImg']['show']){
?>

<style type='text/css'>

	.upload_image_popup{
		width:280px;
		height:100px;
		margin-top:-50px;
		margin-left:-140px;
	}
	
	.upload_image_wrapper{
		position:relative;
		padding:5px;
	}
	
	.input_file{
		filter: alpha(opacity:0);
		opacity: 0;
		position: absolute;
		top: 5px;
		left: 5px;
		width: 188px;
		height: 24px;
		cursor:pointer;
	}
					
</style>
<div class='popup_panel upload_image_popup ke_filter' style='display:none;'>
	<div class='popup_head ke_filter'>
		<div class='popup_title ke_filter'>上传图片</div>
		<div class='popup_close ke_filter'></div>
	</div>
	<div class='popup_content ke_filter' style='overflow:hidden;'>
		<div class='upload_image_wrapper ke_filter'>
			<form class='upload_image_form' action="<?=$popPanels['uploadImg']['data']['uploadPath'] ?>?callback=uploadImageCallBack" method="post" enctype="multipart/form-data" target='upload_image_iframe'> 
				<input type='text' name='textfield' class='input_file_text input_text ke_filter' id='_file_text' /> 
				<input type='button' class='input_file_btn input_btn ke_filter' value='浏览...' /> 
				<input type="file" name="image" class="input_file input_file_plugin  ke_filter"  size="28" onchange="document.getElementById('_file_text').value=this.value" /> 
				<input type="submit" name="submit" class="input_btn upload_image_submit ke_filter"  value="上传" /> 
				<iframe src='' id='upload_image_iframe' style='display:none;'></iframe>
			</form> 
		</div>
	</div>
	<div class='popup_panel_shadow ke_filter'></div>
</div>
<script type='text/javascript'>
var uploadImageCallBack = function(data){

	$('.input_file_text').val('');
	$('.input_file_plugin').val('');
	$('.upload_image_popup').hide();
	
	var e = new TJEvent.EventObject('upload_image_success');
	e.data.content = data;
	TJEvent.dispatch(e);
	
};

TJEvent.addListener('upload_image_panel_show' , function(e){

	$('.upload_image_popup').show();
	
});

$('.upload_image_submit').click(function(){
	var e = new TJEvent.EventObject('upload_image_submit');
});

</script>
<?
}
?>



<?
if($popPanels['uploadWord']['show']){
?>

<style type='text/css'>

	.upload_word_popup{
		width:250px;
		height:70px;
		margin-top:-50px;
		margin-left:-140px;
	}
	
	.upload_word_wrapper{
		position:relative;
		padding:5px;
	}
	
	.word_preview_popup .confirm_panel{
		position: absolute;
		bottom: 0;
		right: 0;
		left: 0;
		border-top: 1px solid #c1c1c1;
	}
	
	.preview_word_wrapper{
		position: absolute;
		overflow: auto;
		top: 0;
		bottom: 41px;
		left: 0;
		right: 0;
		padding:5px;
	}
	
	
	.input_file{
		filter: alpha(opacity:0);
		opacity: 0;
		position: absolute;
		top: 5px;
		left: 5px;
		width: 188px;
		height: 24px;
		cursor:pointer;
	}
	
	.word_preview_popup{
		width:800px;
		height:600px;
		margin-top:-300px;
		margin-left:-400px;
	}
					
</style>
<div class='popup_panel upload_word_popup ke_filter' style='display:none;'>
	<div class='popup_head ke_filter'>
		<div class='popup_title ke_filter'>上传Word</div>
		<div class='popup_close ke_filter'></div>
	</div>
	<div class='popup_content ke_filter' style='overflow:hidden;'>
		<div class='upload_word_wrapper ke_filter'>
			<form class='upload_word_form' action="<?=$popPanels['uploadWord']['data']['uploadPath']; ?>?callback=uploadWordCallBack" method="post" enctype="multipart/form-data" target='upload_word_iframe'> 
				<input type='text' name='textfield' class='input_file_text input_text ke_filter' id='_word_text' /> 
				<input type='button' class='input_file_btn input_btn ke_filter' value='浏览...' /> 
				<input type="file" name="word" id='input_word_file' class="input_file input_file_plugin  ke_filter"  size="28" onchange="document.getElementById('_word_text').value=this.value" /> 
				<input type="submit" name="submit" class="input_btn upload_word_submit ke_filter"  value="上传" /> 
				<iframe src='' id='upload_word_iframe' style='display:none;'></iframe>
			</form> 
		</div>
	</div>
	<div class='popup_panel_shadow ke_filter'></div>
</div>
<div class='popup_panel word_preview_popup ke_filter' style='display:none'>
	<div class='popup_head ke_filter'>
		<div class='popup_title ke_filter'>Word预览</div>
		<div class='popup_close ke_filter'></div>
	</div>
	<div class='popup_content ke_filter' style='overflow:auto;'>
		<div class='preview_word_wrapper'></div>
		<div class='confirm_panel'>
			<input type='button' class='input_btn preview_word_cancel' value='取消' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<input type='button' class='input_btn preview_word_submit' value='确定' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<div class='clear_float'></div>
		</div>
	</div>
	<div class='popup_panel_shadow ke_filter'></div>
</div>
<script type='text/javascript'>

var uploadWordCallBack = function(data , flag){
	$('.word_preview_popup .preview_word_wrapper').html(TJExtends.base64.decode(data.content)).closest('.popup_panel').show();
// 	return;
	$('.input_file_text').val('');
	$('.input_file_plugin').val('');
	$('.upload_word_popup').hide();
	
	var e = new TJEvent.EventObject('upload_word_success');
	e.data.content = data;
	TJEvent.dispatch(e);
	
};

TJEvent.addListener('upload_word_panel_show' , function(e){

	$('.upload_word_popup').show();
	
});

TJEvent.addListener('upload_word_finish' , function(){

	$('.upload_word_popup , .word_preview_popup').hide();
	
});

$('.preview_word_submit').click(function(){
	var e = new TJEvent.EventObject('preview_word_submit');
	TJEvent.dispatch(e);
});


$('.preview_word_cancel').click(function(){
	$(this).closest('.popup_panel').hide();
});


</script>
<?
}
?>



<script type='text/javascript'>

$('.popup_panel .popup_close').click(function(){
	$(this).closest('.popup_panel').hide();
});

$( ".popup_panel" ).draggable({ handle: ".popup_head" });
</script>