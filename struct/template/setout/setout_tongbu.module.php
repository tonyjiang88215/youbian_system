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
	
</style>
<? echo $this->headElement; ?>
<div class='content_title' style='display:none;'>版本维护</div>
<div class='content_main' >
	<div class='content_element'  style='min-height: 180px;padding:0;'>
		<div class='content_element' style='border:0;padding:0;border-bottom:1px solid #c1c1c1;'>
			<div class='content_element_title' style=''>版本</div>
			<div class='content_element_wrapper curriculumn_wrapper'>
				<? foreach($curriculumns as $c){ ?>
				<a class='content_tab' href='javascript:void(0);' cid='<?=$c['id']; ?>' tongbu='<?=$c['tongbu']; ?>' knowledge='<?=$c['knowledge']; ?>' zhuanti='<?=$c['zhuanti']; ?>'  ><?=$c['name'] ?></a>
				<? } ?>
			</div>
			<div class='clear_float'></div>
		</div>
		<div class='content_element' style='border:0;padding:0;margin-bottom:0px;'>
			<div class='content_element_title' style=''>类型</div>
			<div class='content_element_wrapper type_wrapper'>
				<a class='content_tab unactive' href='javascript:void(0);'  type='1'>同步</a>
				<a class='content_tab unactive' href='javascript:void(0);'  type='2' >知识点</a>
				<a class='content_tab unactive' href='javascript:void(0);'  type='3' >专题</a>
			</div>
			<div class='clear_float'></div>
		</div>
		
		<div class='content_element' style='border:0;border-top:1px solid #c1c1c1;margin:0;padding:5px 10px 10px;'>
			<div class="content_list_action" style="padding:5px;border-bottom:0;">
				<span class="action_panel action_insert" style="float:left;">
					<span class="action_panel_icon" style="background:url(&quot;/manage_system/pic/manage_system/plus.jpg&quot;);"></span>
					<span class="action_panel_label">导出到更新包</span>
				</span>
				<div class='clear_float'></div>
			</div>
		
			<table class='curriculumn_detail_table' cellpadding='0' cellspacing='0' >
				<tr style='background:#f4f4f4;'>
					<td><input type='checkbox' class='input_check check_all'/></td><td width='300px;'>更新</td><td class='textcenter' width='50px;'>状态</td>
<!-- 					<td>操作 </td> -->
				</tr>
			</table>
		</div>
		
		<div class="info_tag">版本维护</div>
	</div>
	<?=$popPanels; ?>
</div>