<style type='text/css'>
	.pager_container{
		float:right;
		padding:2px 5px;
		margin-top:5px;
	}
	
	.title_label{
		position:relative;
		padding:3px ;
		margin:2px 5px;
		font-size:12px;
	}
	
</style>
<?php echo $this->headElement; ?>
<div class='content_title' style='display:none;'>题目导出</div>
<div class='content_main' >
	<div class='content_element' style='border:0;padding:0;border-bottom:1px solid #c1c1c1;'>
	<? $type=$_GET['type'] ? $_GET['type'] : 1; ?>
		<a class='content_tab <?=$type==1?'content_tab_select':''; ?>' href='?type=1' ><span class='action_panel_label' >新增</span></a>
		<a class='content_tab <?=$type==2?'content_tab_select':''; ?>' href='?type=2' ><span class='action_panel_label' >修改</span></a>
		<a class='content_tab <?=$type==3?'content_tab_select':''; ?>' href='?type=3' ><span class='action_panel_label' >删除</span></a>
		<div class='clear_float'></div>
	</div>

	<div class='content_element'  style='min-height: 200px;'>
		<div class='content_list_action' style='padding:5px;' >
			<div class='title_label' style='float:left;'>新增题目数量：332</div>
			<span class='action_panel action_insert_all' style='float:left;'>
				<span class='action_panel_icon' style='background:url("/manage_system/pic/manage_system/plus.jpg");'></span>
				<span class='action_panel_label'>全部导出</span>
			</span>
			<div class='clear_float'></div>
		</div>
		<div class='content_per_wrapper' style='margin-top:10px;margin-bottom:10px;padding-bottom:10px;'>
			<?=$searchBar; ?>
			<span class='action_panel action_insert_condition' style='float:left;'>
				<span class='action_panel_icon' style='background:url("/manage_system/pic/manage_system/plus.jpg");'></span>
				<span class='action_panel_label'>条件导出</span>
			</span>
			<div class='clear_float'></div>
		</div>
		
		
		<div class='content_element' style='margin-right:10px;margin-left:10px;margin-top:0px;min-height:400px;'>
			<div class='content_element_right' style='left:0;border-left:0;'>
				<div class='content_list_action' style='padding:5px;' >
					<span class='action_panel action_insert_check' style='float:left;'>
						<span class='action_panel_icon' style='background:url("/manage_system/pic/manage_system/plus.jpg");'></span>
						<span class='action_panel_label'>导出</span>
					</span>
					<?=$pagerHTML; ?>
					<div style='clear:right;'></div>
				</div>
				<?=$questionList; ?>
				<div class='content_list_action' style='padding:5px;border-bottom:0;border-top:1px solid #d1d1d1;' >
					<span class='action_panel action_insert_check' style='float:left;'>
						<span class='action_panel_icon' style='background:url("/manage_system/pic/manage_system/plus.jpg");'></span>
						<span class='action_panel_label'>导出</span>
					</span>
					<?=$pagerHTML; ?>
					<div style='clear:right;'></div>
				</div>
				<div class='clear_float'></div>
			</div>
			<div class='clear_float'></div>
		</div>
		<div class="info_tag">题目导出</div>
	</div>
	<?=$popPanels; ?>
</div>