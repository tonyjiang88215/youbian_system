<style type='text/css'>
	.pager_container{
		float:right;
		padding:2px 5px;
		margin-top:5px;
	}
	
	.action_panel_icon{
		background:url('/manage_system/pic/client/unit_chapter_btn.png');
		width:40px;
		height:24px;
		top:0;
	}
	
	.action_insert_sibling .action_panel_icon{
		background-position:0px 0px;
	}
	
	.action_insert_children .action_panel_icon{
		background-position:-67px 0px;
	}
	
	.action_move_up  .action_panel_icon{
		background-position:-268px 0px;
	}
	
	.action_move_down .action_panel_icon{
		background-position:-335px 0px;
	}
	
	.action_delete .action_panel_icon{
		background-position:-469px 0px;
	}
	
	
	.action_setin .action_panel_icon{
		background-position:-402px 0px;
	}
	
	.action_clear .action_panel_icon{
		background-position:-536px 0px;
	}
	
	.action_panel_icon:hover{
		background-position-y:24px;
	}
	
	.action_disabled{
		cursor:not-allowed;
	}
	
	.action_disabled  .action_panel_icon{
		background-position-y:-66px;
	}
	
	.action_panel{
		padding:2px;
	}
	
	.action_panel:hover{
		background:#f3f3f3;
	}
	
	.action_panel_label{
		display:none;
	}
	
</style>
<?php echo $this->headElement; ?>
<div class='content_title' style='display:none;'>知识体系维护</div>
<div class='content_main' >
	<div class='content_element'  style='min-height: 200px;'>
		<div class='content_per_wrapper' style='margin-top:10px;margin-bottom:10px;padding-bottom:10px;border-bottom:1px solid #c1c1c1;'>
			<?=$searchBar; ?>
			<div class='clear_float'></div>
		</div>
		<div class='content_element' style='margin-right:10px;margin-left:10px;margin-top:0px;min-height:400px;'>
			<div class='content_element_left'  style='width:510px;'>
				<div class='content_list_action' style='padding:5px;margin-bottom:5px;'>
					<span class='action_panel action_setin action_disabled' style='float:left;'>
						<span class="action_panel_icon" ></span>
						<span class="action_panel_label">导入</span>
					</span>
					<span class='action_panel action_clear action_disabled' style='float:left;'>
						<span class="action_panel_icon" ></span>
						<span class="action_panel_label">清空</span>
					</span>
					
				
					
					<span class='action_panel action_delete action_disabled' style='float:right;'>
						<span class="action_panel_icon" ></span>
						<span class="action_panel_label">删除</span>
					</span>
					<span class='action_panel action_move_down action_disabled' style='float:right;'>
						<span class="action_panel_icon" ></span>
						<span class="action_panel_label">下移</span>
					</span>
					<span class='action_panel action_move_up action_disabled' style='float:right;'>
						<span class="action_panel_icon" ></span>
						<span class="action_panel_label">上移</span>
					</span>
					<span class='action_panel action_insert_children action_disabled' style='float:right;'>
						<span class="action_panel_icon" ></span>
						<span class="action_panel_label">插入子层</span>
					</span>
					<span class='action_panel action_insert_sibling action_disabled' style='float:right;'>
						<span class="action_panel_icon" ></span>
						<span class="action_panel_label">插入同层</span>
					</span>
					<div class='clear_float'></div>
				</div>
				<div class='tree_wrapper origin_tree' style='height:500px;position:relative;overflow-y:scroll;'>
					<?=$treeHTML; ?>
				</div>
			</div>
			<div class='content_element_right'  style='left:519px;'>
				
			</div>
			<div class='clear_float'></div>
		</div>
	</div>
	<?=$popPanels; ?>
</div>