<style type='text/css'>

.add_setout_batch_popup{
	width:230px;
	height:110px;
	margin-top:-160px;
	margin-left:-120px;
}

.add_setout_batch_popup .column{
	width:55px;
}
</style>
<div class='popup_panel add_setout_batch_popup' style='display:none;'>
	<div class='popup_head'>
		<div class='popup_title'>新增批次</div>
		<div class='popup_close'></div>
	</div>
	<div class='popup_content' style='overflow:hidden;'>
		<div class="content_per">
			<span class="column column_align">*批次名称</span>
			<span class="value">
				<input type='text' class='input_text setout_batch_name'></input>
			</span>
		</div>
		<div class='clear_float'></div>
		<div class='confirm_panel'>
			<input type='button' class='input_btn add_setout_batch_cancel' value='取消' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<input type='button' class='input_btn add_setout_batch_submit' value='确定' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<div class='clear_float'></div>
		</div>
	</div>
	<div class='popup_panel_shadow'></div>
</div>
<script type='text/javascript'>

/**新增试卷弹出框JS **/

TJEvent.addListener('add_setout_batch_show' , function(e){

	$('.add_setout_batch_popup').show();
	
});

TJEvent.addListener('add_setout_batch_success' , function(e){

	$('.add_setout_batch_popup').hide();
	$('.add_setout_batch_popup .add_setout_batch_cancel').val('');

});

TJEvent.addListener('add_setout_batch_error' , function(e){

	alert('新增试卷失败，请稍后再试');
	
});

//添加考卷
$('.add_setout_batch_submit').click(function(){

	var name = $.trim($('.setout_batch_name').val());

	if(!name){
		alert('请输入名称');
		return;
	}

	var e = new TJEvent.EventObject('add_setout_batch_submit');
	e.data.name = name;
	TJEvent.dispatch(e);
});

$('.add_exam_popup .add_setout_batch_cancel').click(function(){
	$('.exam_name').val('');
	$('.exam_time').val('');
	$('.add_exam_popup').hide();
});

</script>



<style type='text/css'>

.batch_detail_popup{
	width:700px;
	height:500px;
	margin-top:-250px;
	margin-left:-350px;
}

.content_slide{
	position:relative;
	padding:2px;
	margin : 2px;
}

.slide_head{
	position:relative;
	padding:2px 5px;
}

.slide_head_title{
	position:relative;
	font-size:14px;
	float:left;
}

.slide_head_mid{
	position:relative;
	float:left;
}

.slide_head_icon{
	position:relative;
	float:right;
}

.slide_content{
	position:relative;
	background:#f5f5f5;
	color:#666;
	min-height:40px;
	padding:2px 5px;
}

.question_label{
	margin-left:20px;
}

.title_line_right{
	top:12px;
	left:87px;
}

.detail_text{
	float:left;
}

.detail_action{
	float:right;
	display:none;
}

.detail_remove{
	text-decoration: none;
}

.version_text{
	color:#F9A31A;
}

</style>
<div class='popup_panel batch_detail_popup' style='display:none;'>
	<div class='popup_head'>
		<div class='popup_title'>更新包详细信息</div>
		<div class='popup_close'></div>
	</div>
	<div class='popup_content' style='overflow:hidden;'>
		<div class="content_slide">
			<div class='slide_head'>
				<div class="title_line_left"></div>
				<div class="title_label">题目更新</div>
				<div class="title_line_right"></div>
				<div class="clear_float"></div>
			</div>
			<div class='slide_content'>
				<span class='question_label' >新增题目数量：<label class='new_question'>332</label></span>
				<span class='question_label' >修改题目数量：<label class='modify_question'>332</label></span>
				<span class='question_label' >删除题目数量：<label class='delete_question'>332</label></span>
			</div>
		</div>
		
		<div class="content_slide tongbu_detail">
			<div class='slide_head'>
				<div class="title_line_left"></div>
				<div class="title_label">同步更新</div>
				<div class="title_line_right"></div>
				<div class="clear_float"></div>
			</div>
			<div class='slide_content'>
				<div class='curriculumn_detail' id='curriculumn_detail_template' style='display:none;'>
					<div class='detail_text'>
						<span class='version_text'></span>
						<span class='info_text'></span>
					</div>
					<div class='detail_action'>
						<a class='detail_remove' href='javascript:void(0);'>删除</a>
					</div>
					<div class='clear_float'></div>
				</div>
			</div>
		</div>
		
		<div class="content_slide knowledge_detail">
			<div class="title_line_left"></div>
				<div class="title_label">知识点更新</div>
				<div class="title_line_right" style='left:98px;'></div>
				<div class="clear_float"></div>
			<div class='slide_content'>
			</div>
		</div>
		
		<div class="content_slide zhuanti_detail">
			<div class='slide_head'>
				<div class="title_line_left"></div>
				<div class="title_label">专题更新</div>
				<div class="title_line_right"></div>
				<div class="clear_float"></div>
			</div>
			<div class='slide_content'>
			</div>
		</div>
		
		<div class='clear_float'></div>
	</div>
	<div class='popup_panel_shadow'></div>
</div>

<script type='text/javascript'>

$('.batch_detail_popup').delegate('.curriculumn_detail' , 'mouseover' , function(){
	$(this).find('.detail_action').show();
});

$('.batch_detail_popup').delegate('.curriculumn_detail' , 'mouseout' , function(){
	$(this).find('.detail_action').hide();
});

$('.batch_detail_popup').delegate('.detail_remove' , 'click' , function(){

	var e = new TJEvent.EventObject('batch_detail_remove');
	e.data.detail_id = $(this).closest('.curriculumn_detail').attr('detail_id');
	TJEvent.dispatch(e);
	
});

TJEvent.addListener('batch_detail_show' , function(e){

	var data = TJDataCenter.get('current_batch_detail_info');

	$('.batch_detail_popup').find('.new_question').text(parseInt(data.question[1] ? data.question[1] : 0));
	$('.batch_detail_popup').find('.modify_question').text(parseInt(data.question[2] ? data.question[2] : 0));
	$('.batch_detail_popup').find('.delete_question').text(parseInt(data.question[3] ? data.question[3] : 0));


	$('.curriculumn_detail:visible').remove();

	var detail = data.detail;
	
	for(var i = 0 ; i < detail.length ; i++){

		var html = $('#curriculumn_detail_template').clone().removeAttr('id').show();
		html.attr('detail_id' , detail[i].id);
		html.find('.version_text').text('['+detail[i].curriculumn_name+']');
		html.find('.info_text').text(detail[i].text);
		
		if(detail[i].type == 1){//tongbu

			$('.tongbu_detail .slide_content').append(html);
			
		}else if(detail[i].type == 2){//knowledge

			$('.knowledge_detail .slide_content').append(html);
			
		}else if(detail[i].type == 3){//zhuanti

			$('.zhuanti .slide_content').append(html);
			
		}
	}
	
	
	
	$('.batch_detail_popup').show();
	
});


</script>






<script type='text/javascript'>

$('.popup_panel .popup_close').click(function(){
	$(this).closest('.popup_panel').hide();
});

$( ".popup_panel" ).draggable({ handle: ".popup_head" });
</script>
