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

.user_role_table{
	border-collapse:collapse;
	margin:10px 5px;
}

.user_role_table td{
	border:1px solid #c1c1c1;
	text-align:center;
	padding:8px 5px;
}

.pager_container{
	float:right;
	padding:2px 5px;
	margin-top:5px;
	display:none;
}

td.role_id{
	width:30px;
}

td.role_name{
	width:220px;
}

.pager_container  a , .pager_container  span{
	color:#666;
}

td.role_action{
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
		<table class="user_role_table"  cellpadding=0 cellspacing=0>
			<tr class="table_header">
				<td class="role_id" rowspan="1">ID</td>
				<td class="role_name" style="">角色名称</td>
				<td class="role_action"></td>
			</tr>
			
			
			<tr class="user_role_record" id="user_role_record_template" style="display:none;">
				<td class="role_id" rowspan="1"></td>
				<td class="role_name" ></td>
				<td>
					<a class='table_action role_privilege' href='javascript:void(0);'>功能权限</a>
					<a class='table_action create_privilege' href='javascript:void(0);'>创建权限</a>
				</td>
			</tr>
			
		</table>
		<?=$pagerHTML; ?>
		<div class='clear_float'></div>
	</div>
	<?=$popPanels; ?>
	<?=$floatPanels; ?>
</div>