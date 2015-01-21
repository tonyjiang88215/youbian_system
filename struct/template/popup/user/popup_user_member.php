<style type='text/css'>

.add_user_popup{
	width:230px;
	height:242px;
/* 	margin-top:-160px; */
/* 	margin-left:-120px; */
	left:480px;
	top:280px;
}

.add_user_popup .column{
	width:55px;
}
</style>
<div class='popup_panel add_user_popup' style='display:none;'>
	<div class='popup_head'>
		<div class='popup_title'>添加用户</div>
		<div class='popup_close'></div>
	</div>
	<div class='popup_content' style='overflow:hidden;'>
		<div class="content_per">
			<span class="column column_align">*用户名</span>
			<span class="value">
				<input type='text' class='input_text username'></input>
			</span>
		</div>
		<div class="content_per">
			<span class="column column_align">*真实姓名</span>
			<span class="value">
				<input type='text' class='input_text realname'></input>
			</span>
		</div>
		<div class="content_per">
			<span class="column column_align">*登录密码</span>
			<span class="value">
				<input type='text' class='input_text passwd'></input>
			</span>
		</div>
		<div class="content_per">
			<span class="column column_align">*角色</span>
			<span class="value">
				<select class='input_select user_role'>
					<option value=0>------请选择------</option>
					<?
						foreach($user_role as $role){
					?>
					<option value='<?=$role['id'] ?>'><?=$role['name']; ?></option>
					<?
						}
					 ?>
				</select>
			</span>
		</div>
		<div class="content_per" style='display:none;'>
			<span class="column column_align">*用户组</span>
			<span class="value">
				<select class='input_select user_group'>
					<option value=0>------请选择------</option>
					<?
						foreach($user_group as $group){
					?>
					<option value='<?=$group['id'] ?>'><?=$group['name']; ?></option>
					<?
						}
					 ?>
				</select>
			</span>
		</div>
		<div class="content_per">
			<span class="column column_align">*工作组</span>
			<span class="value">
				<select class='input_select user_workset'>
					<option value=0>------请选择------</option>
					<?
						foreach($worksets as $workset){
					?>
					<option value='<?=$workset['id'] ?>'><?=$workset['name']; ?></option>
					<?
						}
					 ?>
				</select>
			</span>
		</div>
		<div class='clear_float'></div>
		<div class='confirm_panel'>
			<input type='button' class='input_btn add_user_cancel' value='取消' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<input type='button' class='input_btn add_user_submit' value='确定' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<div class='clear_float'></div>
		</div>
	</div>
	<div class='popup_panel_shadow'></div>
</div>
<script type='text/javascript'>

var _popup_user_type = 0;

/**新增试卷弹出框JS **/


TJEvent.addListener('add_user_success' , function(e){

	$('.add_user_popup').hide();
	$('.add_setout_batch_popup .add_setout_batch_cancel').val('');

});

TJEvent.addListener('add_user_error' , function(e){

	alert('新增试卷失败，请稍后再试');
	
});

//添加考卷
$('.add_user_popup .add_user_submit').click(function(){

	var username = $.trim($('.add_user_popup .username').val());
	var realname =  $.trim($('.add_user_popup .realname').val());
	var passwd =  $.trim($('.add_user_popup .passwd').val());
	var user_group = parseInt($('.add_user_popup .user_group').val());
	var user_role = parseInt($('.add_user_popup .user_role').val());
	var user_workset = parseInt($('.add_user_popup .user_workset').val());

	if(!username){
		alert('请输入用户名');
		return;
	}
	if(!realname){
		alert('请输入真实姓名');
		return;
	}
	if(!passwd){
		alert('请输入登陆密码');
		return;
	}
// 	if(!user_group){
// 		alert('请选择用户组');
// 		return;
// 	}

	if(!user_role){
		alert('请选择角色');
		return;
	}
	
	if(!user_workset){
		alert('请选择工作组');
		return;
	}

	var e = new TJEvent.EventObject('add_user_submit');
	e.data.username = username;
	e.data.realname = realname;
	e.data.passwd = passwd;
	e.data.user_group = user_group;
	e.data.user_role = user_role;
	e.data.user_workset = user_workset;
	TJEvent.dispatch(e);
});

$('.add_user_popup .add_user_cancel').click(function(){
	$('.add_user_popup .username').val('');
	$('.add_user_popup .realname').val('');
	$('.add_user_popup .passwd').val('');
	$('.add_user_popup .user_group').val(0);
	$('.add_user_popup .user_workset').val(0);
	$('.add_user_popup').hide();
});

</script>




<script type='text/javascript'>

TJEvent.addListener('popup_show', function(e){
	switch(e.data.name){
		case 'add_user':
			_popup_user_type = 1;
			break;

		case 'modify_user':
			_popup_user_type = 2;

			$('.add_user_popup .username').val(e.data.username);
			$('.add_user_popup .realname').val(e.data.realname);
			$('.add_user_popup .user_group').val(e.data.group_id);
			$('.add_user_popup .user_workset').val(e.data.workset_id);
			
			
			break;
	}

	$('.add_user_popup').show();
	
});

$('.popup_panel .popup_close').click(function(){
	$(this).closest('.popup_panel').hide();
});

$( ".popup_panel" ).draggable({ handle: ".popup_head" });
</script>
