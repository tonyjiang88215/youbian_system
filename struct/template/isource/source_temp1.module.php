<style type='text/css'>
	.pager_container{
		float:right;
		padding:2px 5px;
		margin-top:5px;
	}
	
	.content_element_right {
		position: absolute;
		float: right;
		left: 0;
		right: 0;
		padding: 5px;
		overflow: auto;
		border-left:0;
	}
	
	.content_list_action_float{
		left:219px;
	}
	
	.knowledge_list_column{
		width:800px!important;
	}
	
	.modify_count_div{
		position:relative;
		float:right;
		margin-right:10px;
		padding:9px 5px;
		color:#666
	}
	
	.modify_count{
		color:#4e72b8;
		padding:2px 5px;
	}
	
	.modify_only_div{
		position:relative;
		float:left;
		padding:5px 10px;
		color:#555;
	}
	
	.modify_only{
		position:relative;
		top:2px;
	}
	
</style>
<?php echo $this->headElement; ?>
<div class='content_title' style='display:none;'>资源管理</div>
<div class='content_main' >
	<div class='content_element' style='min-height: 200px;'>
		<div class='content_per_wrapper' style='margin-top:10px;'>
			<?=$searchBar; ?>
			<div class='clear_float'></div>
		</div>
		<div class='content_element' style='margin-right:10px;margin-left:10px;min-height:400px;'>
			<div class='content_element_right' >
				<div class='content_list_action' style='padding:5px;' >
					<span class='action_panel action_save' style='float:left;'>
						<span class='action_panel_icon' style='background:url("/manage_system/pic/manage_system/plus.jpg");'></span>
						<span class='action_panel_label'>保存</span>
					</span>
					<div class='modify_only_div'>
						<input type='checkbox' class='modify_only' id='modify_only'><label for='modify_only'>只显示未修改题目</label>
					</div>
					<?=$pagerHTML; ?>
					<div class='modify_count_div'>
						已修改<span class='modify_count'>0</span>条
					</div>
					<div style='clear:right;'></div>
				</div>
				<?=$questionList ;?>
				<div class='content_list_action_float'  >
					<span class='action_panel action_save' style='float:left;'>
						<span class='action_panel_icon' style='background:url("/manage_system/pic/manage_system/plus.jpg");'></span>
						<span class='action_panel_label'>保存</span>
					</span>
					<style type='text/css'>
						.pager_container{
							float:right;
							padding:2px 5px;
							margin-top:5px;
						}
					</style>
					<?=$pagerHTML; ?>
					<div class='clear_float'></div>
				</div>
			</div>
			<div class='clear_float'></div>
		</div>
	</div>
	<?=$popPanels; ?>
	<?=$tmpPopPanels; ?>
</div>