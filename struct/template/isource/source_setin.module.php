<style type='text/css'>
	.content_tab{
		text-decoration: none;
		color:black;
	}
	
	.column{
		width:36px;
	}
	
	.pager_container{
		float:right;
		padding:2px 5px;
		margin-top:5px;
	}
	
	.content_element_middle{
		position:absolute;
		left:211px;
		right:234px;
		border-left: 1px solid #c1c1c1;
		border-right: 1px solid #c1c1c1;
		padding: 5px;
		
	}
	
	.intro_left{
		position:relative;
		float:left;
		font-size: 32px;
		line-height: 46px;
		padding: 5px 10px;
		width:192px;
		text-align: center;
		color:green;
	}
	
	.intro_middle{
		position: absolute;
		top: 0;
		bottom: 0;
		left: 212px;
		right: 234px;
	}
	
	.intro_right{
		position:relative;
		float:right;
		font-size: 32px;
		line-height: 46px;
		padding: 5px 10px;
		width:216px;
		text-align: center;
		color:#ff0033;
	}
	
</style>
<?php echo $this->headElement; ?>
<div class='content_title' style='display:none;'>资源管理</div>
<div class='content_main' >
	<div class='content_element'>
		<div class='intro_left'>到这里</div>
		<div class='intro_middle'></div>
		<div class='intro_right'>从这里</div>
		<div class='clear_float'></div>
	</div>
	<div class='content_element main_wrapper' style='min-height: 264px;'>
		
		<div class='content_element_left' style='width:202px;'>
			<div class='content_tab_wrapper setin_question_tab' style=';'>
				<? $type=$_GET['type'] ? $_GET['type'] : 2; ?>
			
				<span class='content_tab <?=$type==1?'content_tab_select':''; ?>' type=1 >试卷</span>
				<span class='content_tab <?=$type==2?'content_tab_select':''; ?>' type=2 >同步</span>
				<span class='content_tab <?=$type==3?'content_tab_select':''; ?>' type=3 >专题</span>
				<div class='clear_float'></div>
			</div>
			<div class='content_per_wrapper in_wrapper'  search_key='in_wrapper' style='margin-top:10px;border-bottom:1px solid #c1c1c1;'>
				<?=$searchBarIn; ?>
				<div class='clear_float'></div>
			</div>
			<?=$treeHTMLIn; ?>
		</div>
		
		<div class='content_element_middle' style=''>
			<?=$questionListSetting; ?>
			<div class='content_list_action' style='padding:5px;' >
				<span class='action_panel action_insert' style='float:left;'>
					<span class='action_panel_icon' style='background:url("/manage_system/pic/manage_system/plus.jpg");'></span>
					<span class='action_panel_label'>插入</span>
				</span>
				<?=$pagerHTML; ?>
				<div class='clear_float'></div>
			</div>
			<?=$questionList ;?>
			<div class='content_list_action' style='padding:5px;border-bottom:0;border-top:1px solid #d1d1d1;' >
				<span class='action_panel action_insert' style='float:left;'>
					<span class='action_panel_icon' style='background:url("/manage_system/pic/manage_system/plus.jpg");'></span>
					<span class='action_panel_label'>插入</span>
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
		
		<div class='content_element_right' style='width:224px;left:inherit;'>
			<div class='content_tab_wrapper select_question_tab' >
				<span class='content_tab <?=$type==1?'content_tab_select':''; ?>'  type=1 ><a class='action_panel_label' href='javascript:void(0);' >试卷</a></span>
				<span class='content_tab <?=$type==2?'content_tab_select':''; ?>'  type=2><a class='action_panel_label' href='javascript:void(0);' >同步</a></span>
				<span class='content_tab'<?=$type==3?'content_tab_select':''; ?>  type=3><a class='action_panel_label' href='javascript:void(0);' >专题</a></span>
				<span class='content_tab <?=$type==4?'content_tab_select':''; ?>'  type=4 style='display: none;'><a class='action_panel_label' href='javascript:void(0);' >知识点</a></span>
				<div class='clear_float'></div>
			</div>
			<div class='content_per_wrapper select_wrapper'  search_key='select_wrapper' style='margin-top:10px;border-bottom:1px solid #c1c1c1;'>
				<?=$searchBarQuestion; ?>
				<div class='clear_float'></div>
			</div>
			<?=$treeHTMLQuestion; ?>
		</div>
		<div class='clear_float'></div>
<!-- 		<div class="info_tag">试题入库</div> -->
	</div>
	<?=$popPanels; ?>
	<?=$tmpPopPanels; ?>
</div>