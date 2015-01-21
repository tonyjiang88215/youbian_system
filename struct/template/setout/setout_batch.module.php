<style type='text/css'>

.batch_table{
	border-collapse:collapse;
}

.batch_table td{
	border:1px solid #c1c1c1;
	text-align:center;
	padding:2px 5px;
}

	.pager_container{
		float:right;
		padding:2px 5px;
		margin-top:5px;
	}
</style>
<?php echo $this->headElement; ?>
<div class='content_title' style='display:none;'>导出批次管理</div>
<div class='content_main' >
	<div class='content_element'  style='min-height: 200px;padding:5px 10px;'>
		<div class="content_list_action" style="padding:5px;border-bottom:0;">
			<span class="action_panel action_insert" style="float:left;">
				<span class="action_panel_icon" style="background:url(&quot;/manage_system/pic/manage_system/plus.jpg&quot;);"></span>
				<span class="action_panel_label">新建更新包</span>
			</span>
			<div class='clear_float'></div>
		</div>
	
		<div class='clear_float'></div>
		<table class="batch_table"  cellpadding=0 cellspacing=0>
			<tr class="table_header">
				<td class="batch_id" rowspan="1">更新包ID</td>
				<td class="batch_name" style="">更新包名称</td>
				<td class="batch_time">创建时间</td>
				<td class="batch_action">操作</td>
			</tr>
			
			
			<tr class="setout_batch_template" id="setout_batch_template" style="display:none;">
				<td class="batch_id" rowspan="1"></td>
				<td class="batch_name" style=""></td>
				<td class="batch_time"></td>
				<td class="batch_action">
					<a class="action_tag_a show_detail" href="javascript:void(0);">查看详情</a>
				</td>
			</tr>
			
		</table>
		<div class='clear_float'></div>
		<div class="info_tag">知识体系维护</div>
	</div>
	<?=$popPanels; ?>
	<?=$floatPanels; ?>
</div>