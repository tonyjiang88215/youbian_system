<?
	if($type == 1){
?>
<style type="text/css">
.tree_setting{
	position:relative;
	padding:5px;
	border-bottom:1px solid #d1d1d1;
	margin-bottom:5px;
}
</style>
<div class='tree_setting'>

<span class="action_panel add_exam" style="float:left;">
	<span class="action_panel_icon" style="background:url(&quot;/manage_system/pic/manage_system/plus.jpg&quot;);"></span>
	<span class="action_panel_label">新增试卷</span>
</span>
<div class='clear_float'></div>

</div>
<script type='text/javascript'>
$('.add_exam').click(function(){
	var e = new TJEvent.EventObject('add_exam_show');
	TJEvent.dispatch(e);
});
</script>
<?		
	}
?>