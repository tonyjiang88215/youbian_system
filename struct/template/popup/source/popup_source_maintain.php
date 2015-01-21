<!--  新增版本弹出面板  -->
<style  type='text/css'>

.insource_show_popup{
	width :800px;
	height:500px;
	margin-left:-115px;
	margin-top:-90px;
	
}

</style>

<div class='popup_panel insource_show_popup' style='display:none;'>
	<div class='popup_head'>
		<div class='popup_title'>新增版本</div>
		<div class='popup_close'></div>
	</div>
	<div class='popup_content' style='overflow:hidden;'>
	
		<div class='clear_float'></div>
		<div class='confirm_panel'>
			<input type='button' class='input_btn add_curriculumn_cancel' value='取消' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<input type='button' class='input_btn add_curriculumn_submit' value='确定' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<div class='clear_float'></div>
		</div>
	</div>
	<div class='popup_panel_shadow'></div>
</div>













<script type='text/javascript'>

TJEvent.addListener('popup_show' , function(e){
	$('.popup_panel').hide();
	$('.'+e.data.name+'_popup').show();
	console.log(e.data.name);

});

$('.popup_panel .popup_close').click(function(){
	$(this).closest('.popup_panel').hide();
	TJDataCenter.set('current_pop_panel' , 0);
});

$( ".popup_panel" ).draggable({ handle: ".popup_head" });
</script>