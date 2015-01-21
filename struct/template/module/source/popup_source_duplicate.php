<style type='text/css'>

	.select_gid_panel{
		width:204px;
		height:106px;
		margin-top:-50px;
		margin-left:-140px;
	}
	
					
</style>
<div class='popup_panel select_gid_panel' style='display:none;'>
	<div class='popup_head'>
		<div class='popup_title'>选择重题为主的ID号</div>
		<div class='popup_close'></div>
	</div>
	<div class='popup_content' style='overflow:hidden;'>
		<div class="content_per">
			<span class="column column_align">*选择</span>
			<span class="value">
				<select class="input_select select_gid">
					<option value=0>请选择</option>
				</select>
			</span>
		</div>
		<div class='confirm_panel'>
			<input type='button' class='input_btn select_gid_cancel' value='取消' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<input type='button' class='input_btn select_gid_submit' value='确定' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<div class='clear_float'></div>
		</div>
	</div>
	<div class='popup_panel_shadow'></div>
</div>
<script type="text/javascript">

TJEvent.addListener('select_gid_panel_show' , function(e){

	if(e.data.array){
		$('.select_gid option[value!=0]').remove();
		for(var i = 0 ; i < e.data.array.length ; i ++){

			$('.select_gid').append('<option value="'+e.data.array[i]+'">'+e.data.array[i]+'</option>');
		}
	}

	$('.select_gid').val(0);
	$('.select_gid_panel').show();
	
});

TJEvent.addListener('select_gid_panel_hide' , function(e){
	$('.select_gid_panel').hide();
});

$('.select_gid_cancel').click(function(){

	$('.select_gid').val(0);
	$(this).closest('.popup_panel').hide();
	
});

$('.select_gid_submit').click(function(){

	var gid = $('.select_gid').val();
	
	if(gid == 0){
		alert('请选择GID号');
		return;
	}

	var e = new TJEvent.EventObject('select_gid_submit');
	e.data.gid = gid;
	TJEvent.dispatch(e);
	
	
});


</script>

<script type='text/javascript'>

$('.popup_panel .popup_close').click(function(){
	$(this).closest('.popup_panel').hide();
});

$( ".popup_panel" ).draggable({ handle: ".popup_head" });


</script>