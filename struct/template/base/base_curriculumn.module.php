<style type='text/css'>
	.pager_container{
		float:right;
		padding:2px 5px;
		margin-top:5px;
	}
	
	.content_element_title{
		position: relative;
		float: left;
		height: 32px;
		width:50px;
		line-height: 32px;
		font-size: 14px;
		margin-right: 5px;
		color: #a1a1a1;
	}
	
	.content_tab{
		text-decoration: none;
		color:black;
	}
	
	.curriculumn_detail_table{
		position:relative;
		border-collapse: collapse;
	}
	
	.curriculumn_detail_table td{
		border:1px solid #c1c1c1;
		padding:4px 8px;
	}
	
	.action_tag_a{
		position:relative;
		color:#ff8400;
		margin-left:5px;
	}
	
	.textcenter{
		text-align: center;
	}
	
	.unactive{
		color:#c1c1c1;
		background:#f5f5f5;
	}
	
	.deny_cover{
		position:absolute;
		top:0;
		left:0;
		right:0;
		bottom:0;
		background:#c1c1c1;
		z-index:2;
		opacity:0.4;
		cursor:not-allowed;
	}
	
	
	.version_table{
		border-collapse:collapse;
		margin:10px 5px;
	}
	
	.version_table td{
		border:1px solid #c1c1c1;
		text-align:center;
		padding:8px 5px;
	}
	
	.pager_container{
		float:right;
		padding:6px 5px;
		margin-top:5px;
	}
	
	td.version_id{
		width:30px;
	}
	
	td.name{
		width:120px;
	}
	
	td.extends{
		width:70px;
	}
	
	td.update_count{
		width:6`0px;
	}
	
	td.version_action{
		width:146px;
	}
	
	.status_column{
		position:relative;
		display:inline-block;
		width:40px;
	}
	
	.pager_container{
		float:left;
	}
	
</style>
<? echo $this->headElement; ?>
<div class='content_main' >
	<div class='content_element'  style='min-height: 180px;padding:0;'>
		<div class="content_list_action" style="padding:5px;border-bottom:0;">
			<span class="action_panel new_curriculumn" style="float:left;">
				<span class="action_panel_icon" style="background:url('/manage_system/pic/manage_system/plus.jpg');"></span>
				<span class="action_panel_label">新增</span>
			</span>
			<div style="clear:both;"></div>
		</div>
	
		<table class="version_table"  cellpadding=0 cellspacing=0>
			<tr class="table_header">
				<td class="version_id" rowspan="1">ID</td>
				<td class="name" style="">版本名称</td>
				<td class="version" style="">版本号</td>
				<td class='extends'>扩展编号</td>
				<td class='update_count'>更新条数</td>
				<td class="version_action">操作</td>
			</tr>
			
			
			
			<tr class="version_record" id="version_record_template" style="display:none;">
				<td class="version_id" rowspan="1"></td>
				<td class="name" ></td>
				<td class="version" style=""></td>
				<td class="extends" ></td>
				<td class='update_count'>0</td>
				<td>
					<a class='table_action version_detail' href='javascript:void(0);'>更新管理</a>
				</td>
			</tr>
			
		</table>
		<?=$pagerHTML; ?>
		<div class='clear_float'></div>
	</div>
	<?=$popPanels; ?>
</div>