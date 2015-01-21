<style type='text/css'>
	.pager_container{
		float:right;
		padding:2px 5px;
		margin-top:5px;
	}
	
	.book_condition{
		position:relative;
	}
	
	.book_wrapper{
		position:relative;
	}
	
	.book_list{
		postion: relative;
		padding: 2px 0 2px 5px;
		cursor: pointer;
	}
	
	.book_list_selected{
		background:#DFE8F3;
	}
	
	.book_list:hover{
		background:#eef2f7;
	}
	
	
	.select_version{
		text-decoration: none;
	}
	
	.content_tab{
		color:#333;
	}
	
	.unactive{
		color: #c1c1c1;
		background: #f5f5f5;
	}
	
	.action_panel_icon{
		background:url('/manage_system/pic/client/unit_chapter_btn.png');
		width:40px;
		height:24px;
		top:0;
	}
	
	.action_insert_unit .action_panel_icon{
		background-position:-134px 0px;
	}
	
	.action_insert_chapter .action_panel_icon{
		background-position:-201px 0px;
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
	
	.action_disabled  .action_panel_icon{
		background-position-y:-66px;
	}
	
	.action_panel_icon:hover{
		background-position-y:24px;
	}
	
	.action_disabled{
		cursor:not-allowed;
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
<div class='content_title' style='display:none;'>章节单元维护</div>
<div class='content_main' >
	<div class='content_element'  style='min-height: 200px;'>
		<div class='content_per_wrapper' style='margin-top:10px;margin-bottom:10px;padding-bottom:10px;border-bottom:1px solid #c1c1c1;'>
			<?=$searchBar; ?>
			<div class='clear_float'></div>
		</div>
		<div class='content_element' style='margin-right:10px;margin-left:10px;margin-top:0px;min-height:400px;'>
			<div class='content_element_left'  style='width:180px;'>
				<div class='book_wrapper'>
					<div style='color:#c1c1c1;'>暂无</div>
				</div>
			</div>
			<div class='content_element_right'  style='left:189px;'>
				<div class='content_list_action' style='padding:5px;margin-bottom:5px;height:30px;'>
					
					<span class='action_panel action_setin action_disabled' style='float:left;'>
						<span class="action_panel_icon" title='导入' ></span>
						<span class="action_panel_label">导入</span>
					</span>
					<span class='action_panel action_clear action_disabled' style='float:left;'>
						<span class="action_panel_icon"  title='清空'></span>
						<span class="action_panel_label">清空</span>
					</span>
					
					<span class='action_panel action_insert_unit action_disabled' style='float:left;margin-left:80px;'>
						<span class="action_panel_icon"  title='插入单元'></span>
						<span class="action_panel_label">插入单元</span>
					</span>
					<span class='action_panel action_insert_chapter action_disabled' style='float:left;'>
						<span class="action_panel_icon" title='插入章节'></span>
						<span class="action_panel_label">插入章节</span>
					</span>
					<span class='action_panel action_move_up action_disabled' style='float:left;'>
						<span class="action_panel_icon"  title='上移'></span>
						<span class="action_panel_label">上移</span>
					</span>
					<span class='action_panel action_move_down action_disabled' style='float:left;'>
						<span class="action_panel_icon"  title='下移'></span>
						<span class="action_panel_label">下移</span>
					</span> 
					
					<span class='action_panel action_delete action_disabled' style='float:left;'>
						<span class="action_panel_icon"  title='删除'></span>
						<span class="action_panel_label">删除</span>
					</span>
					<div class='clear_float'></div>
				</div>
				<div class='tree_wrapper origin_tree' style='position:relative;overflow-y:scroll;'>
					<?=$treeHTML; ?>
				</div>
			</div>
			<div class='clear_float'></div>
		</div>
		<div class="info_tag">知识体系维护</div>
	</div>
	<?=$popPanels; ?>
</div>