<div class='content_list_action float_action_panel' style='position: fixed;left: 153px;top: 220px;text-align: center;border: 0;padding-bottom: 5px;' >
	<span class='action_panel action_deplicate' style='float:left;width: 16px;padding-bottom: 10px;'>
		<span class='action_panel_icon' style='background:url("/manage_system/pic/manage_system/plus.jpg");'></span>
		<span class='action_panel_label' style='line-height: 14px;top:4px;'>去重</span>
	</span>
	<div class='clear_float'></div>
</div>

<script type='text/javascript'>
TJEvent.addListener('nav_panel_hide' , function(){
	$('.float_action_panel').css('left' , 0);
});


TJEvent.addListener('nav_panel_show' , function(){
	$('.float_action_panel').css('left' , 153);
});

</script>