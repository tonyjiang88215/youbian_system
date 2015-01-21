<style type='text/css'>
	.pager_container{
		float:right;
		padding:2px 5px;
		margin-top:5px;
	}
	

	
</style>
<?php echo $this->headElement; ?>
<div class='content_title' style='display:none;'>资源管理</div>
<div class='content_main' >
	<div class='content_element' style='border:0;padding:0;border-bottom:1px solid #c1c1c1;'>
	<? $type=$_GET['type'] ? $_GET['type'] : 1; ?>
		<a class='content_tab <?=$type==1?'content_tab_select':''; ?>' href='?type=1' ><span class='action_panel_label' >试卷</span></a>
		<a class='content_tab <?=$type==2?'content_tab_select':''; ?>' href='?type=2' ><span class='action_panel_label' >同步</span></a>
		<a class='content_tab <?=$type==3?'content_tab_select':''; ?>' href='?type=3' ><span class='action_panel_label' >专题</span></a>
		<a class='content_tab <?=$type==4?'content_tab_select':''; ?>' href='?type=4' ><span class='action_panel_label' >知识点</span></a>
		<a class='content_tab <?=$type==5?'content_tab_select':''; ?>' href='?type=5' ><span class='action_panel_label' >其他</span></a>
		<div class='clear_float'></div>
	</div>
	<div class='content_element' style='min-height: 200px;'>
		<div class='content_per_wrapper' style='margin-top:10px;'>
			<?=$searchBar; ?>
			<div class='clear_float'></div>
		</div>
		<div class='content_element' style='margin-right:10px;margin-left:10px;min-height:400px;'>
			<div class='content_element_left'>
				<?=$treeSetting; ?>
				<?=$treeHTML; ?>
			</div>
			<div class='content_element_right' >
				<?=$questionListSetting; ?>
				<div class='content_list_action' style='padding:5px;' >
					<span class='action_panel action_save' style='float:left;'>
						<span class='action_panel_icon' style='background:url("/manage_system/pic/manage_system/plus.jpg");'></span>
						<span class='action_panel_label'>保存</span>
					</span>
					<span class='action_panel action_setout' style='float:left;'>
						<span class='action_panel_icon' style='background:url("/manage_system/pic/manage_system/plus.jpg");'></span>
						<span class='action_panel_label'>出库</span>
					</span>
					<?=$pagerHTML; ?>
					<div style='clear:right;'></div>
				</div>
				<?=$questionList ;?>
				<div class='content_list_action_float'  >
					<span class='action_panel action_save' style='float:left;'>
						<span class='action_panel_icon' style='background:url("/manage_system/pic/manage_system/plus.jpg");'></span>
						<span class='action_panel_label'>保存</span>
					</span>
					<span class='action_panel action_setout' style='float:left;'>
						<span class='action_panel_icon' style='background:url("/manage_system/pic/manage_system/plus.jpg");'></span>
						<span class='action_panel_label'>出库</span>
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