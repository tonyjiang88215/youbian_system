<style type='text/css'>

.select_batch_popup{
	width:248px;
	height:110px;
	margin-top:-160px;
	margin-left:-120px;
}

.select_batch_popup .column{
	width:73px;
}
</style>
<div class='popup_panel select_batch_popup' style='display:none;'>
	<div class='popup_head'>
		<div class='popup_title'>选择更新包</div>
		<div class='popup_close'></div>
	</div>
	<div class='popup_content' style='overflow:hidden;'>
		<div class="content_per">
			<span class="column column_align">*更新包名称</span>
			<span class="value">
				<select class='select_batch_val' style='width:137px;'>
					<option value=0>----请选择----</option>
					<?php 
					
						foreach($batch as $v){
					?>
					<option value='<?=$v['id']; ?>'><?=$v['name']; ?></option>
					<?php 
						}
					?>
				</select>
			</span>
		</div>
		<div class='clear_float'></div>
		<div class='confirm_panel'>
			<input type='button' class='input_btn select_batch_cancel' value='取消' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<input type='button' class='input_btn select_batch_submit' value='确定' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<div class='clear_float'></div>
		</div>
	</div>
	<div class='popup_panel_shadow'></div>
</div>
<script type='text/javascript'>

/**新增试卷弹出框JS **/

TJEvent.addListener('select_batch_show' , function(e){

	$('.select_batch_popup').show();
	
});

TJEvent.addListener('select_batch_success' , function(e){

	$('.select_batch_popup').hide();
	$('.select_batch_popup .select_batch_val').val(0);

});

TJEvent.addListener('select_batch_error' , function(e){

	alert('新增试卷失败，请稍后再试');
	
});

//添加考卷
$('.select_batch_submit').click(function(){

	var batch_id = parseInt($('.select_batch_val').val());

	if(!batch_id){
		alert('请选择更新包');
		return;
	}

	var e = new TJEvent.EventObject('select_batch_submit');
	e.data.batch_id = batch_id;
	TJEvent.dispatch(e);
});

$('.select_batch_cancel').click(function(){
	$('.select_batch_val').val(0);
	$('.select_batch_popup').hide();
});

</script>

<script type='text/javascript'>

$('.popup_panel .popup_close').click(function(){
	$(this).closest('.popup_panel').hide();
});

$( ".popup_panel" ).draggable({ handle: ".popup_head" });
</script>
