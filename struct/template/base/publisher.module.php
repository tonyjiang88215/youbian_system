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
		width:360px;
	}
	
	.publisher_list , .book_list{
		postion: relative;
		padding: 2px 0 2px 5px; 
	}
	
	.publisher_list:hover , .book_list:hover{
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
	
	.action_span , .edit_action_span{
		float:right;
		margin-right : 5px;
	}
	
	.action_span a , .edit_action_span a{
		color:#08c;
		text-decoration: none;
	}
	
</style>
<?php echo $this->headElement; ?>
<div class='content_title' style='display:none;'>出版社数据维护</div>
<div class='content_main' >
	<div class='content_element'  style='min-height: 200px;'>
		<div class='content_element_left'  style='width:280px;'>
			<div class='content_list_action' style='padding:5px;margin-bottom:5px;height:30px;'>
				<span class='action_panel action_insert_publisher' style='float:left;'>
					<span class="action_panel_icon" style="background:url('/manage_system/pic/manage_system/plus.jpg');"></span>
					<span class="action_panel_label">新增出版社</span>
				</span>
			</div>
			<div class='publisher_wrapper'>
				<div class='publisher_list' style='color:#c1c1c1;'>暂无</div>
				<div class="publisher_list" id='publisher_list_template'  style='display:none;'>
					<span class='publisher_name'>人民教育出版社_新课标</span>
					<span class='action_span' style='display:none;'>
						<a href='javascript:void(0);' class='edit_publisher'>编辑</a>
						<a href='javascript:void(0);' class='delete_publisher'>删除</a>
					</span>
					<span class='edit_action_span' style='display:none;'>
						<a href='javascript:void(0);' class='edit_save'>保存</a>
						<a href='javascript:void(0);' class='edit_cancel'>取消</a>
					</span>
				</div>
			</div>
		</div>
		<div class='content_element_right'  style='left:289px;'>
			<div class='content_per_wrapper' style='margin-top:2px;margin-bottom:5px;padding-bottom:3px;border-bottom:1px solid #c1c1c1;'>
				<?=$searchBar; ?>
				<div class='clear_float'></div>
			</div>
			<div class='content_list_action' style='padding:5px;margin-bottom:5px;height:30px;'>
				<span class='action_panel action_insert_book' style='float:left;'>
					<span class="action_panel_icon" style="background:url('/manage_system/pic/manage_system/plus.jpg');"></span>
					<span class="action_panel_label">新增教材</span>
				</span>
				<div class='clear_float'></div>
			</div>
			<div class='book_wrapper' style='min-height:200px;position:relative;'>
				<div class="book_list"  style='color:#c1c1c1;'>暂无</div>
				<div class="book_list" id='book_list_template'  style='display:none;'>
					<span class='book_name'>人民教育出版社_新课标</span>
					<span class='action_span' style='display:none;'>
						<a href='javascript:void(0);' class='edit_book'>编辑</a>
						<a href='javascript:void(0);' class='delete_book'>删除</a>
					</span>
					<span class='edit_action_span' style='display:none;'>
						<a href='javascript:void(0);' class='edit_save'>保存</a>
						<a href='javascript:void(0);' class='edit_cancel'>取消</a>
					</span>
				</div>
				
			</div>
		</div>
		<div class='clear_float'></div>
		<div class="info_tag">知识体系维护</div>
	</div>
	<?=$popPanels; ?>
</div>