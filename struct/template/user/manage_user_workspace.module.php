<style type='text/css'>

.content{
	background:#F1F1F1;
}

.content_main{
	min-width:800px;
/* 	margin:5px auto 0; */
}

.content_element{
	background:#fff;
}

.workspace_table{
	border-collapse:collapse;
	margin:10px 5px;
	position:relative;
	width:99.5%;
}

.workspace_table td{
	border:1px solid #c1c1c1;
	text-align:center;
	padding:8px 5px;
}

.pager_container{
	float:right;
	padding:2px 5px;
	margin-top:5px;
}


td.ws_name{
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

td.ws_action{
	width:180px;
}

.pager_container  a , .pager_container  span{
	color:#666;
}

.tree_content{
	position:relative;
	margin:10px 5px;
}

.tree_list{
	display: block;
	position: relative;
	margin: 0;
	padding: 0;
	list-style: none
}

.tree_list .tree_list{
	padding-left:30px;
}

.tree_list li{
	display:block;
}

.tree_item{
	display: block;
	position: relative;
	margin: 0;
	padding: 0;
	min-height: 20px;
	line-height: 20px;
}

.tree_handle{
	display: block;
	margin: 5px 0;
	padding: 8px 12px;
	background: #f8faff;
	border: 1px solid #dae2ea;
}

.tree_handle > div{
	display:inline-block;
}

.item_member_count{
	position:absolute;
	width:40px;
	right:480px;
	text-align:center;
}

.item_create_time{
	position:absolute;
	right:330px;
	width:120px;
}

.item_creator_name{
	position:absolute;
	width:120px;	
	right:190px;
	text-align:center;
}


.item_ws_action{
	position:absolute;
	width:170px;	
	right:10px;
}



.item_icon{
	position:relative;
	display:inline-block;
	background:url('/manage_system/pic/client/bg_square_add.png');
	width:14px;
	height:14px;
	top:2px;
}

.item_span{
	display:inline-block;
}


</style>
<?php echo $this->headElement; ?>
<div class='content_main' >
	<div class='content_element'  style='padding:5px 10px;'>
		<div class="content_list_action" style="padding:5px;border-bottom:0;">
			<span class="action_panel action_insert" style="float:left;">
				<span class="action_panel_icon" style="background:url('/manage_system/pic/manage_system/plus.jpg');"></span>
				<span class="action_panel_label">添加工作组</span>
			</span>
			<div class='clear_float'></div>
		</div>
		
		<table class="workspace_table"  cellpadding=0 cellspacing=0>
			<tr class="table_header">
				<td class="ws_name" style="">工作组名称</td>
				<td class='member_count'>成员数量</td>
				<td class="create_time">创建时间</td>
				<td class="creator_name">创建人</td>
				<td class="ws_action">操作</td>
			</tr>
		</table>
		
		<div class='tree_content'>
			<ol class='tree_list'>
				<li class='tree_item' id='tree_item_template' style='display:none;'>
					<div class='tree_handle'>
						<div class='item_icon'></div>
						<div class='item_ws_name'></div>
						<div class='item_member_count'></div>
						<div class='item_create_time'></div>
						<div class='item_creator_name'></div>
						<div class='item_ws_action'>
							<a class="table_action" href="javascript:void(0);">修改信息</a>
							<a class="table_action edit_workset_source" href="javascript:void(0);">资源权限</a>
							<a class="table_action edit_version_visible" href="javascript:void(0);">设置版本</a>
						</div>
					</div>
					<ol class='tree_list' style='display:none;'></ol>
				</li>
			</ol>
			
		</div>
		
		<div class='clear_float'></div>
	</div>
	<?=$popPanels; ?>
	<?=$floatPanels; ?>
</div>