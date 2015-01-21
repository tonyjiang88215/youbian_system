<style type='text/css'>
	.pager_container{
		float:right;
		padding:2px 5px;
		margin-top:5px;
	}
</style>
<?php echo $this->headElement; ?>
<div class='content_title' style='display:none;'>题型维护</div>
<div class='content_main' >
	<div class='content_element'  style='min-height: 200px;'>
		<div class='content_per_wrapper' style='margin-top:10px;margin-bottom:10px;padding-bottom:10px;border-bottom:1px solid #c1c1c1;'>
			<?=$searchBar; ?>
			<div class='clear_float'></div>
		</div>
		<div class='content_element' style='margin-right:10px;margin-left:10px;margin-top:0px;min-height:400px;'>
			<div class='content_element_left'  style='width:210px;'>
				<div class='content_list_action' style='padding:5px;margin-bottom:5px;'>
					<span class='action_panel action_insert' style='float:left;'>
						<span class="action_panel_icon" style="background:url('/manage_system/pic/manage_system/plus.jpg');"></span>
						<span class="action_panel_label">新增</span>
					</span>
					
					<span class='action_panel action_delete' style='float:right;'>
						<span class="action_panel_icon" style="background:url('/manage_system/pic/manage_system/plus.jpg');"></span>
						<span class="action_panel_label">删除</span>
					</span>
					<div class='clear_float'></div>
				</div>
				<div class='tree_wrapper' style='height:500px;position:relative;overflow-y:scroll;'>
					<?=$treeHTML; ?>
				</div>
			</div>
			<div class='content_element_right' >
				
			</div>
			<div class='clear_float'></div>
		</div>
		<div class="info_tag">知识体系维护</div>
	</div>
	<?=$popPanels; ?>
</div>