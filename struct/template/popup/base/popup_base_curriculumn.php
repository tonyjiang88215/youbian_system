<!--  新增版本弹出面板  -->
<style  type='text/css'>

.add_curriculumn_popup{
	width :230px;
	height:220px;
	margin-left:-115px;
	margin-top:-90px;
	
}

.add_curriculumn_popup .column{
	width:55px;
}

.confirm_panel{
	position:relative;
	margin-top:6px;
}

</style>

<div class='popup_panel add_curriculumn_popup' style='display:none;'>
	<div class='popup_head'>
		<div class='popup_title'>新增版本</div>
		<div class='popup_close'></div>
	</div>
	<div class='popup_content' style='overflow:hidden;'>
		<div class="content_per">
			<span class="column column_align">*版本名</span>
			<span class="value">
				<input type='text' class='input_text curriculumn_name'></input>
			</span>
		</div>
		<div class="content_per">
			<span class="column column_align">*版本号</span>
			<span class="value">
				<input type='text' class='input_text curriculumn_version'></input>
			</span>
		</div>
		<div class="content_per">
			<span class="column column_align">*扩展编号</span>
			<span class="value">
				<input type='text' class='input_text curriculumn_extends'></input>
			</span>
		</div>
		<div class='content_per'>
			<span class='column column_align'>*参照版本</span>
			<span class='value'>
				<select class='input_select ref_curriculumn' >
					<option value=0>------请选择------</option>
					<?
						foreach($popPanels['addCurriculumn']['data'] as $v){
					?>
					<option value='<?=$v['id'] ?>'><?=$v['name']; ?></option>
					<?		
						}	
					?>
				</select>
			</span>
		</div>
		
		<div class='content_per'>
			<div class=''>
			
			</div>
		</div>
		<div class='clear_float'></div>
		<div class='confirm_panel'>
			<input type='button' class='input_btn add_curriculumn_cancel' value='取消' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<input type='button' class='input_btn add_curriculumn_submit' value='确定' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<div class='clear_float'></div>
		</div>
	</div>
	<div class='popup_panel_shadow'></div>
</div>

<script type="text/javascript">

	TJEvent.addListener('ref_curriculumn_change' , function(e){
		$('.ref_curriculumn option[value!=0]').remove();
		for(var i = 0 ; i < e.data.length ; i ++){
			$('.ref_curriculumn').append('<option value='+e.data[i].id+'>'+e.data[i].name+'</option>');
		}

	});

	TJEvent.addListener('add_curriculumn_finish' , function(){

		$('.curriculumn_name').val('');
		$('.curriculumn_version').val('');
		$('.curriculumn_extends').val('');
		$('.ref_curriculumn').val(0);
		
		$('.add_curriculumn_popup').hide();
	});

	$('.add_curriculumn_submit').click(function(){
		var name = $.trim($('.curriculumn_name').val());
		if(name == ''){
			alert('版本名不能为空');
			return;
		}
			
		var version = $.trim($('.curriculumn_version').val());
		if(version == ''){
			alert('版本号不能为空');
			return;
		}

		var extend = $.trim($('.curriculumn_extends').val());
		if(extend == ''){
			alert('扩展编号不能为空');
			return;
		}
		
		var ref = $('.ref_curriculumn').val();

		var e = new TJEvent.EventObject('add_curriculumn_submit');
		e.data.name = name;
		e.data.version = version;
		e.data.extend = extend;
		e.data.ref = ref;
		TJEvent.dispatch(e);
		
	});				

	$('.add_curriculumn_cancel').click(function(){
		$(this).closest('.popup_panel').hide();		
	});

</script>


<style type='text/css'>

.curriculumn_active_popup{
	height: 108px;
	width:480px;					
}
					
.slide_element{
	position:relative;
	margin:5px 0;
}

.slide_title{
	position:relative;
	padding:5px 10px;
	line-height:20px;
	border:1px solid rgb(220, 226, 232);
	background:rgb(248, 250, 255);
}

.slide_title_btn{
	position:relative;
	width:14px;
	height:14px;
	top:2px;
	margin-right:2px;
	float:left;
	background:url('/manage_system/pic/client/bg_square_remove.png');
}

.slide_title_btn_open{
	position:relative;
	width:14px;
	height:14px;
	top:2px;
	margin-right:2px;
	float:left;
	background:url('/manage_system/pic/client/bg_square_add.png');
}

.slide_title_label{
	display:inline-block;
	float:left;
}

.slide_content_element{
	position:relative;
}

.slide_content{
	position:relative;
	padding:5px 10px;
	border:1px solid rgb(220, 226, 232);
	border-top:0;
	background:#f7f7f7;
	color:#666;
}

.subject_select{
	position:relative;
	top:2px;
	left:5px;
	margin-right:5px;
	opacity: 0;
	z-index:-1;
}

.subject_select_show{
	position:absolute;
	width:15px;
	height:15px;
	top:1px;
	left:4px;
	background:url('/manage_system/pic/client/bg_input.png');
	background-position:0px -16px;
}

.subject_select_show:hover{
	background-position:0px -32px;
}

.select_checked{
	background-position:0px -64px;
}

.select_checked:hover{
	background-position:0px -80px;
}


					
</style>

<div class='popup_panel curriculumn_active_popup' style='display:none;'>
	<div class='popup_head'>
		<div class='popup_title'>激活状态</div>
		<div class='popup_close'></div>
	</div>
	<div class='popup_content' style='overflow:hidden;'>
		
		<div class='slide_element' '>
			<div class='slide_title' style='display:none;'>
				<div class='slide_title_btn' ></div>
				<div class='slide_title_label'></div>
				<div class='clear_float'></div>
			</div>
			<div class='slide_content' style='border-top:1px solid rgb(220, 226, 232);'>
				<? foreach($subject as $_s){ ?>
				<span class='slide_content_element' subject_id='<?=$_s['id']; ?>'>
					<div class='subject_select_show'></div>
					<input type='checkbox' class='subject_select' value=''  />
					<span><?=$_s['name']; ?></span>
				</span>
				<? } ?>
			</div>
		</div>
		
		<div class='clear_float'></div>
		<div class='confirm_panel'>
			<input type='button' class='input_btn curriculumn_active_submit' value='保存' style='float:right;padding:5px 10px;'></input>
			<div class='clear_float'></div>
		</div>
	</div>
	<div class='popup_panel_shadow'></div>
</div>

<script type='text/javascript'>

$(document).delegate('.subject_select_show ' , 'click' ,function(){

	var checked = $(this).siblings('.subject_select')[0].checked;

	if(checked){
		$(this).removeClass('select_checked');
	}else{
		$(this).addClass('select_checked');
	}
	
	$(this).siblings('.subject_select')[0].checked = !checked;
	
});

$(document).delegate('.slide_title_btn' , 'click' , function(){
	$(this).toggleClass('slide_title_btn , slide_title_btn_open');
	$(this).closest('.slide_element').children('.slide_content').hide();
});

$(document).delegate('.slide_title_btn_open' , 'click' , function(){
	$(this).toggleClass('slide_title_btn , slide_title_btn_open');
	$(this).closest('.slide_element').children('.slide_content').show();
});

$('.curriculumn_active_submit').click(function(){
	var e = new TJEvent.EventObject('version_active_submit');
	e.data.vid = $('.curriculumn_active_popup').attr('version_id');

	var activeArray = [];

	$('.curriculumn_active_popup .subject_select:checked').each(function(){
		activeArray.push({
			'subject_id' : $(this).closest('.slide_content_element').attr('subject_id'),
// 			'type_id' : $(this).closest('.slide_element').attr('source_type_id')
		});
	});

	e.data.active = activeArray;
	console.log(activeArray);
	TJEvent.dispatch(e);
	
	
	
});


</script>



<!--  新增版本弹出面板  -->
<style  type='text/css'>

.curriculumn_detail_popup{
	width :798px;
	height:420px;
	margin-left:-399px;
	margin-top:-210px;
	
}

.curriculumn_detail_popup .column{
	width:55px;
}

.detail_list_wrapper{
	position:relative;
	border-right:1px solid #ccc;
	width:330px;
	height:376px;
	padding:5px 10px;
	float:left;
}

.detail_list{
	position:relative;
	padding:2px 5px;
}

.detail_list:nth-child(even){
	background:#f5f5f5;
}

.action_span{
	float:right;
	margin-right:5px;
}

.action_span a {
	positionL:relative;
	color: #08c;
	text-decoration: none;
	display:inline-block;
	width:16px;
	height:15px;
	background:url('/manage_system/pic/client/bg_detail.png');
}

.action_span .detail_setin{
	background-position:32px 0px;
}

.action_span .detail_setout{
	background-position:16px 0px;
}

.action_span .detail_delete{
	background-position:-16px 0px;
}


.action_span a:hover{
	color:#04a;
}

.detail_content{
	position:relative;
	float:left;
}


</style>

<div class='popup_panel curriculumn_detail_popup' style='display:none;'>
	<div class='popup_head'>
		<div class='popup_title'>更新条目</div>
		<div class='popup_close'></div>
	</div>
	<div class='popup_content' style='overflow:hidden;'>
		
		<div class='detail_list_wrapper'>
		 <div class="detail_list"  id='detail_list_template' style='display:none;'>
			<span class="detail_name"></span>
			<span class="action_span" style="display: none;">
				<a href="javascript:void(0);" class="detail_setin" title='导入数据'></a>
				<a href="javascript:void(0);" class="detail_setout" title='清除数据'></a>
				<a href="javascript:void(0);" class="detail_delete" title='删除'></a>
			</span>
		</div>
		</div>
		<div class='detail_content' style='display:none;'>
			<div class='confirm_panel'>
				<input type='button' class='input_btn add_curriculumn_submit' value='确定' style='float:right;margin-right:10px;padding:5px 10px;'></input>
				<div class='clear_float'></div>
			</div>
		</div>
	</div>
	<div class='popup_panel_shadow'></div>
</div>

<script type='text/javascript'>
$(document).delegate('.detail_list' , 'mouseover' , function(){
	$(this).find('.action_span').show();
});

$(document).delegate('.detail_list' , 'mouseout' , function(){
	$(this).find('.action_span').hide();
});

</script>


<script type='text/javascript'>

TJEvent.addListener('popup_show' , function(e){
	$('.popup_panel').hide();
	$('.'+e.data.name+'_popup').show();

	switch(e.data.name){

		case 'curriculumn_active':
			$('.curriculumn_active_popup').attr('version_id' , e.data.vid);

			$('.curriculumn_active_popup .subject_select_show').removeClass('select_checked');
			$('.curriculumn_active_popup .subject_select').each(function(){
				this.checked = false;
			});
			
			var data = e.data.data;

			for(var i = 0 ; i < data.length ; i++){
				$('.curriculumn_active_popup .slide_element[source_type_id='+data[i].type_id+
						'] .slide_content_element[subject_id='+data[i].subject_id+'] .subject_select_show').click();
				
			}
			
			break;


		case 'curriculumn_detail':

			$('.curriculumn_detail_popup').attr('version_id' , e.data.vid);
			$('.curriculumn_detail_popup .detail_list:visible').remove();

			var data = e.data.data;

			for(var i = 0 ; i < data.length ; i++){

				var tpl = $('.curriculumn_detail_popup #detail_list_template').clone().attr({
					'id' : '',
					'detail_id' : data[i].id
				});

				tpl.find('.detail_name').text(data[i].text);
				tpl.appendTo('.detail_list_wrapper').show();
				
			}
			
			break;
			
	
	}
	

	TJDataCenter.set('current_pop_panel' , e.data.name);
	
});

$('.popup_panel .popup_close').click(function(){
	$(this).closest('.popup_panel').hide();
	TJDataCenter.set('current_pop_panel' , 0);
});

$( ".popup_panel" ).draggable({ handle: ".popup_head" });
</script>