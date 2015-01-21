<style type='text/css'>

.content{
	background:#F1F1F1;
}

.content_main{
	min-width:800px;
	width:860px;
/* 	margin:5px auto 0; */
}

.content_element{
	background:#fff;
}

.user_group_table{
	border-collapse:collapse;
	margin:10px 5px;
}

.user_group_table td{
	border:1px solid #c1c1c1;
	text-align:center;
	padding:8px 5px;
}

.pager_container{
	float:right;
	padding:2px 5px;
	margin-top:5px;
}

td.group_id{
	width:30px;
}

td.group_name{
	width:220px;
}

td.member_count{
	width:60px;
}

td.create_time{
	width:140px;
}

td.creator_name{
	width:120px;
}

.pager_container  a , .pager_container  span{
	color:#666;
}

td.group_action{
	width:110px;
}

</style>
<?php echo $this->headElement; ?>
<div class='content_main' >
	<div class='content_element'  style='padding:5px 10px;'>
		<div class="content_list_action" style="padding:5px;border-bottom:0;">
			<span class="action_panel action_insert" style="float:left;">
				<span class="action_panel_icon" style="background:url(&quot;/manage_system/pic/manage_system/plus.jpg&quot;);"></span>
				<span class="action_panel_label">添加角色组</span>
			</span>
			<?=$pagerHTML; ?>
			<div class='clear_float'></div>
		</div>
		<table class="user_group_table"  cellpadding=0 cellspacing=0>
			<tr class="table_header">
				<td class="user_id" rowspan="1">ID</td>
				<td class="group_name" style="">角色组名称</td>
				<td class='member_count'>成员数量</td>
				<td class="create_time">创建时间</td>
				<td class='creator_name'>创建人</td>
				<td class="group_action">操作</td>
			</tr>
			
			
			<tr class="user_group_record" id="user_group_record_template" style="display:none;">
				<td class="group_id" rowspan="1"></td>
				<td class="group_name" ></td>
				<td class="member_count" ></td>
				<td class='create_time'></td>
				<td class='creator_name'></td>
				<td>
					<a class='table_action' href='javascript:void(0);'>修改信息</a>
					<a class='table_action group_privilege' href='javascript:void(0);'>查看权限</a>
				</td>
			</tr>
			
		</table>
		<?=$pagerHTML; ?>
		<div class='clear_float'></div>
	</div>
	<?=$popPanels; ?>
	<?=$floatPanels; ?>
</div>