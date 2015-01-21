 
 <!--  新增用户组面板  -->
 			
<style type='text/css'>

.add_workspace_popup{
	width:230px;
	height:110px;
/* 	margin-top:-160px; */
/* 	margin-left:-120px; */
	left:480px;
	top:280px;
}

.add_workspace_popup .column{
	width:55px;
}

.treeWrapper{
	position:relative;
	border-top:1px solid #c1c1c1;
	border-bottom:1px solid #c1c1c1;
	padding: 2px 5px;
	margin: 5px 2px;
}

</style>
<div class='popup_panel add_workspace_popup' style='display:none;'>
	<div class='popup_head'>
		<div class='popup_title'>添加工作组</div>
		<div class='popup_close'></div>
	</div>
	<div class='popup_content' style='overflow:hidden;'>
		<div class="content_per">
			<span class="column column_align">*工作组名</span>
			<span class="value">
				<input type='text' class='input_text workspace_name'></input>
			</span>
		</div>
		
		<div class='clear_float'></div>
		<div class='confirm_panel'>
			<input type='button' class='input_btn add_workspace_cancel' value='取消' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<input type='button' class='input_btn add_workspace_submit' value='确定' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<div class='clear_float'></div>
		</div>
	</div>
	<div class='popup_panel_shadow'></div>
</div>
<script type='text/javascript'>

/**新增试卷弹出框JS **/

TJEvent.addListener('add_workspace_success' , function(e){

	$('.add_workspace_popup').hide();
	$('.add_workspace_popup .workspace_name').val('');

});

TJEvent.addListener('add_workspace_error' , function(e){

	alert('新增工作组失败，请稍后再试');
	
});

//添加考卷
$('.add_workspace_popup .add_workspace_submit').click(function(){

	var work_name = $.trim($('.add_workspace_popup .workspace_name').val());

	if(!work_name){
		alert('请输入工作组名');
		return;
	}

	var e = new TJEvent.EventObject('add_workspace_submit');
	e.data.work_name = work_name;
	TJEvent.dispatch(e);
});

$('.add_workspace_popup .add_workspace_cancel').click(function(){
	$('.add_workspace_popup .workspace_name').val('')
	$('.add_workspace_popup').hide();
});

</script>



<!--  编辑用户组资源限制面板  -->
 			
<style type='text/css'>

.workset_source_popup{
	width:230px;
	height:350px;
/* 	margin-top:-160px; */
/* 	margin-left:-120px; */
	left:480px;
	top:280px;
}

.workset_source_popup .column{
	width:55px;
}

.treeWrapper{
	position:relative;
	margin: 5px 0px;
	padding : 2px 5px;
	border-top:1px solid #c1c1c1;
	border-bottom:1px solid #c1c1c1;
	height:250px;
	overflow-y:scroll;
}

.select_source{
	position:relative;
	top:2px;
	right:2px;
}

</style>
<div class='popup_panel workset_source_popup' style='display:none;'>
	<div class='popup_head'>
		<div class='popup_title'>工作组资源权限</div>
		<div class='popup_close'></div>
	</div>
	<div class='popup_content' style='overflow:hidden;'>
		<div class='head_panel'>
			<input type='button' class='input_btn edit_workset_source' value='编辑' style='margin-right:10px;padding:2px 10px;'></input>
			
			<div class='clear_float'></div>
		</div>
		<div class='treeWrapper'>
			<?=$treeHTML; ?>
		</div>
	
	
		<div class='confirm_panel' style='display:none;'>
			<input type='button' class='input_btn edit_workset_source_cancel' value='取消' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<input type='button' class='input_btn edit_workset_source_submit' value='确定' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<div class='clear_float'></div>
		</div>
	</div>
	<div class='popup_panel_shadow'></div>
</div>
<script type='text/javascript'>

$('.edit_workset_source').click(function(){
	$('.workset_source_popup .head_panel').hide();
	$('.workset_source_popup .confirm_panel').show();

	$('#treeNavDIV a').prepend('<input type="checkbox" class="select_source" />');

	$('#treeNavDIV a[selected=true]').find('.select_source').attr('checked' , true);
});


$('#treeNavDIV').delegate('.select_source' , 'click' , function(){
	
	//如果是选中，则当前父元素都需要被选中
	var checked = this.checked;
	if(this.checked){
		$(this).parents('.child_li').prev().find('.select_source').each(function(){
			this.checked = true;
		});

	//如果是取消，则当前子元素，都要被取消
	}

	$(this).closest('li').next('.child_li').find('.select_source').each(function(){
		this.checked = checked;
	});

	
});



$('.edit_workset_source_cancel').click(function(){
	$('#treeNavDIV .select_source').remove();

	$('.workset_source_popup .confirm_panel').hide();
	$('.workset_source_popup .head_panel').show();
	
});

$('.edit_workset_source_submit').click(function(){
	
	var dataArray = [];

	$('.select_source:checked').closest('a').each(function(){
		
		if($(this).attr('type') == 'section'){
			dataArray.push({
				'section_id':$(this).attr('elementid'),
				'subject_id' : $(this).closest('.child_li').prev().find('a').attr('elementid')
			});
		}
	});


	var e= new TJEvent.EventObject('workset_source_submit');
	e.data.source = dataArray;
	TJEvent.dispatch(e);
	
});

TJEvent.addListener('update_workset_source_success' , function(){
	
	$('.workset_source_popup').hide();
	
});

</script>




<!--  编辑用户组可见版本  -->
 			
<style type='text/css'>

.workset_version_visible_popup{
	width:330px;
	height:350px;
/* 	margin-top:-160px; */
/* 	margin-left:-120px; */
	left:480px;
	top:280px;
}

.workset_version_visible_popup .column{
	width:55px;
}

.version_list{
	position:relative;
	margin-top:10px;
	height:260px;
	overflow-y:auto;
	border-top:1px solid #c1c1c1;
	border-bottom:1px solid #c1c1c1;
	padding:0px 10px;
}

.version_list_item{
	position:relative;
	padding:4px 5px;
	border:1px solid #ccc;
	margin-top:-1px;
}

.version_list_item:nth-child(even) {
	background: #f3f3f3;
}

.workset_version_visible_popup .confirm_panel{
	margin-top:10px;
}

.version_name{
	float:left;
}

.version_select_wrapper input{
	position:relative;
	top:2px;
}


</style>
<div class='popup_panel workset_version_visible_popup' style='display:none;'>
	<div class='popup_head'>
		<div class='popup_title'>工作组版本可见</div>
		<div class='popup_close'></div>
	</div>
	<div class='popup_content' style='overflow:hidden;'>
		<div class='version_list'>
		<?php 
			foreach($versionList as $version){
		?>
			<div class='version_list_item' version_id='<?=$version['id']; ?>'>
				<span class='version_name'><?=$version['name'] ?></span>
				<div class='version_select_wrapper' style='float:right;'>
					<input type='radio' class='version_select'  name='r_<?=$version['id']; ?>' value='0'/>
					<span class=''>隐藏</span>
					<input type='radio' class='version_select'  name='r_<?=$version['id']; ?>' value='3'/>
					<span class=''>操作</span>
					<input type='radio' class='version_select'  name='r_<?=$version['id']; ?>' value='1'/>
					<span class=''>参考</span>
				</div>
				<div class='clear_float'></div>
			</div>
		<?
			}
		?>
		
		</div>
	
	
		<div class='confirm_panel' >
			<input type='button' class='input_btn workset_version_visible_cancel' value='取消' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<input type='button' class='input_btn workset_version_visible_submit' value='确定' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<div class='clear_float'></div>
		</div>
	</div>
	<div class='popup_panel_shadow'></div>
</div>

<script type='text/javascript'>

$('.workset_version_visible_cancel').click(function(){

	$('.workset_version_visible_popup').hide();
});

$('.workset_version_visible_submit').click(function(){

	var version = [];
	$('.version_list_item').each(function(){

		var privilege = $(this).find('.version_select:checked').val();
		if(privilege != 0){
			version.push({'version_id':$(this).attr('version_id') , 'privilege' : privilege});
		}
		
	});


// 	$('.version_select:checked').closest('.version_list_item').each(function(){
// 		version.push($(this).attr('version_id'));
// 	});
	var e = new TJEvent.EventObject('workset_version_visible_submit');
	e.data.version = version;
	TJEvent.dispatch(e);
	
});

TJEvent.addListener('update_workset_version_success' , function(){
	$('.workset_version_visible_popup').hide();
});

</script>









<script type='text/javascript'>

TJEvent.addListener('popup_show' , function(e){
	$('.popup_panel').hide();
	switch(e.data.name){

		case 'workset_source':

			$('.edit_workset_source_cancel').click();
						
			break;

		case 'workset_version_visible':

			$('.version_list_item .version_select[value=0]').each(function(){
				this.checked = true;
			});
			
			for(var i = 0 ; i < e.data.version.length ; i++){
				var element = $('.version_list_item[version_id='+e.data.version[i].version_id+'] .version_select[value='+e.data.version[i].privilege+']')[0];
				if(element){
					element.checked = true;
				}
			}
			
			break;
	
	}
	
	$('.'+e.data.name+'_popup').show();
});


$('.popup_panel .popup_close').click(function(){
	$(this).closest('.popup_panel').hide();
});

$( ".popup_panel" ).draggable({ handle: ".popup_head" });
</script>
