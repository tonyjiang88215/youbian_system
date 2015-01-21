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

<script type='text/javascript'>
$('.popup_panel .popup_close').click(function(){
	$(this).closest('.popup_panel').hide();
});

$( ".popup_panel" ).draggable({ handle: ".popup_head" });
</script>