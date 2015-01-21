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

.user_table{
	border-collapse:collapse;
	margin:10px 5px;
}

.user_table td{
	border:1px solid #c1c1c1;
	text-align:center;
	padding:8px 5px;
}

.pager_container{
	float:right;
	padding:6px 5px;
	margin-top:5px;
}

td.user_id{
	width:30px;
}

td.username{
	width:120px;
}

td.realname{
	width:70px;
}

td.user_role{
	width:90px;
}

td.user_workset{
	width:110px;
}

td.create_time{
	width:140px;
}

td.user_action{
	width:146px;
}

.pager_container  a , .pager_container  span{
	color:#666;
}

.modify_user , .view_privilege , .disabled{
}

</style>
<?php echo $this->headElement; ?>
<div class='content_main' >
	<div class='content_element'  style='padding:5px 10px;'>
		<div class='search_wrapper'>
			<?=$searchBar; ?>
		</div>	
		<div class='clear_float'></div>
		<div class="content_list_action" style="padding:5px;border-bottom:0;">
			<span class="action_panel action_insert" style="float:left;top:4px;">
				<span class="action_panel_icon" style="background:url(&quot;/manage_system/pic/manage_system/plus.jpg&quot;);"></span>
				<span class="action_panel_label">添加用户</span>
			</span>
			<?=$pagerHTML; ?>
			<div class='clear_float'></div>
		</div>
		<table class="user_table"  cellpadding=0 cellspacing=0>
			<tr class="table_header">
				<td class="user_id" rowspan="1">ID</td>
				<td class="username" style="">用户名称</td>
				<td class='realname'>真实姓名</td>
				<td class="user_role">角色</td>
				<td class="user_workset">工作组</td>
				<td class="create_time">创建时间</td>
				<td class="user_action">操作</td>
			</tr>
			
			
			<tr class="user_record" id="user_record_template" style="display:none;">
				<td class="user_id" rowspan="1"></td>
				<td class="username" ></td>
				<td class="realname" ></td>
				<td class="user_role"></td>
				<td class="user_workset"></td>
				<td class='create_time'></td>
				<td>
					<a class='table_action modify_user' href='javascript:void(0);'>修改信息</a>
					<a class='table_action view_privilege' href='javascript:void(0);'>查看权限</a>
					<a class='table_action disabled' href='javascript:void(0);'>禁用</a>
				</td>
			</tr>
			
		</table>
		<?=$pagerHTML; ?>
		<div class='clear_float'></div>
	</div>
	<?=$popPanels; ?>
	<?=$floatPanels; ?>
</div>