 
 <!--  新增用户组面板  -->
 			
<style type='text/css'>

.add_user_group_popup{
	width:230px;
	height:110px;
/* 	margin-top:-160px; */
/* 	margin-left:-120px; */
	left:480px;
	top:280px;
}

.add_user_group_popup .column{
	width:55px;
}
</style>
<div class='popup_panel add_user_group_popup' style='display:none;'>
	<div class='popup_head'>
		<div class='popup_title'>添加角色组</div>
		<div class='popup_close'></div>
	</div>
	<div class='popup_content' style='overflow:hidden;'>
		<div class="content_per">
			<span class="column column_align">*角色组名</span>
			<span class="value">
				<input type='text' class='input_text group_name'></input>
			</span>
		</div>
		<div class='clear_float'></div>
		<div class='confirm_panel'>
			<input type='button' class='input_btn add_group_cancel' value='取消' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<input type='button' class='input_btn add_group_submit' value='确定' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<div class='clear_float'></div>
		</div>
	</div>
	<div class='popup_panel_shadow'></div>
</div>
<script type='text/javascript'>

/**新增用户组弹出框JS **/

TJEvent.addListener('add_user_group_success' , function(e){

	$('.add_user_group_popup').hide();
	$('.add_user_group_popup .group_name').val('');

});

TJEvent.addListener('add_user_group_error' , function(e){

	alert('新增用户组失败，请稍后再试');
	
});

//添加考卷
$('.add_user_group_popup .add_group_submit').click(function(){

	var group_name = $.trim($('.add_user_group_popup .group_name').val());

	if(!group_name){
		alert('请输入角色组名');
		return;
	}

	var e = new TJEvent.EventObject('add_user_group_submit');
	e.data.group_name = group_name;
	TJEvent.dispatch(e);
});

$('.add_user_group_popup .add_group_cancel').click(function(){
	$('.add_user_group_popup .group_name').val('')
	$('.add_user_group_popup').hide();
});

</script>


 <!--  用户组权限面板  -->

<style type='text/css'>

.group_privilege_popup{
	width:330px;
	height:370px;
/* 	margin-top:-160px; */
/* 	margin-left:-120px; */
	left:480px;
	top:280px;
}

.group_privilege_popup .column{
	width:55px;
}

.treeWrapper{
	position:relative;
	margin: 5px 0px;
	padding : 2px 5px;
	border-top:1px solid #c1c1c1;
	border-bottom:1px solid #c1c1c1;
	height:270px;
	overflow-y:scroll;
}

.select_privilege{
	top:2px;
	margin-right:2px;
}

</style>


<div class='popup_panel group_privilege_popup' style='display:none;'>
	<div class='popup_head'>
		<div class='popup_title'>角色组权限</div>
		<div class='popup_close'></div>
	</div>
	<div class='popup_content' style='overflow:hidden;'>
		<div class='head_panel'>
			<input type='button' class='input_btn edit_group_privilege' value='编辑' style='margin-right:10px;padding:2px 10px;'></input>
			
			<div class='clear_float'></div>
		</div>
		<div class='treeWrapper'>
			<?=$treeHTML; ?>
		</div>
	
	
		<div class='confirm_panel' style='display:none;'>
			<input type='button' class='input_btn edit_privilege_cancel' value='取消' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<input type='button' class='input_btn edit_privilege_submit' value='确定' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<div class='clear_float'></div>
		</div>
	</div>
	<div class='popup_panel_shadow'></div>
</div>

<script type="text/javascript">

TJEvent.addListener('update_group_success' , function(){
	$('.edit_privilege_cancel').click();
	$('.group_privilege_popup').hide();
});

$('.edit_group_privilege').click(function(){
	$('.head_panel').hide();
	$('.confirm_panel').show();

	$('#treeNavDIV a').prepend('<input type="checkbox" class="select_privilege" />');

	$('#treeNavDIV a[privilege!=0]').find('.select_privilege').attr('checked' , true);
	 
});

$('#treeNavDIV').delegate('.select_privilege' , 'click' , function(){
	
	//如果是选中，则当前父元素都需要被选中
	var checked = this.checked;
	if(this.checked){
		$(this).parents('.child_li').prev().find('.select_privilege').each(function(){
			this.checked = true;
		});

	//如果是取消，则当前子元素，都要被取消
	}

	$(this).closest('li').next('.child_li').find('.select_privilege').each(function(){
		this.checked = checked;
	});

	
});

$('.edit_privilege_cancel').click(function(){
	 $('#treeNavDIV').find('.select_privilege').remove();
	 $('.group_privilege_popup .head_panel').show();
	 $('.group_privilege_popup .confirm_panel').hide();
	 
});

$('.edit_privilege_submit').click(function(){
	var moduleArray = [];
	$('.select_privilege:checked').closest('a').each(function(){
		moduleArray.push($(this).attr('elementid'));
	});

	var e = new TJEvent.EventObject('edit_privilege_submit');
	e.data.module = moduleArray;
	TJEvent.dispatch(e);
	
});

</script>


<script type='text/javascript'>

TJEvent.addListener('popup_show' , function(e){

	switch(e.data.name){

		case 'group_privilege':

			$('.edit_privilege_cancel').click();
	
			break;
	
	}
	
	$('.popup_panel').hide();
	$('.'+e.data.name+'_popup').show();
});


$('.popup_panel .popup_close').click(function(){
	$(this).closest('.popup_panel').hide();
});

$( ".popup_panel" ).draggable({ handle: ".popup_head" });
</script>
