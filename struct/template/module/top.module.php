<style type='text/css'>
.menu_title{
	color: #FFFFFF;
	font-size: 20px;
	padding: 5px 0 0 15px;
	float: left;
	background: url('/manage_system/pic/logo.png');
	width: 154px;
	height: 40px;
}
 .menubar{
	position:relative;
	float:right;
	margin-right:20px;
	margin-top:20px;
 }
 .menubar Li{
	float:right;
 	list-style:none;
 	padding-left: 20px;
 }
 
 .logout{
 	color:white;
 	text-decoration: none;
}
 
</style>
<?php 
//if(!$_SESSION['login']){
//	header("Location:/manage_system/front/login.php");
//}else{
//	$userInfo = json_decode($_SESSION['user_info'],true);
//}
?>
<div class='logo'>
<div class="menu_title"></div>
<div class="menubar">
<div class="">
<div class=''>
<ul>
	<li>
		<a class='logout' href="/manage_system/logout.php">退出</a>
	</li>
	<li>欢迎您，<strong><?=$userInfo['username']?></strong></li>
	<li>
		<div class="content_per version_switch" style="margin-top:-10px;">
			<span class="column column_align"></span>
			<span class="value">
				<select class="input_select search_select select_version_switch" >
					<option value="0">------请选择------</option>
						<? foreach($userInfo['version_info'] as $version){ ?>
							<option value="<?=$version['id'] ?>" <?=$_SESSION['select_version']['id']==$version['id'] ? 'selected="selected"' : ''; ?> ><?=$version['name'] ?></option>
						<?	} ?>
							</select>
			</span>
		</div>
	</li>
</ul>

<script type='text/javascript'>
$(document).delegate('.select_version_switch' , 'change' , function(){
	$.ajax({
		'url' : TJDataCenter.get('webroot')+'/manage_system/api/user/user_api.php?action=change_version',
		'type' : 'POST',
		'dataType' : 'jsonp',
		'data' : {
			version : $(this).val()
		},
		success : function(data){
			if(data){
				window.location.reload();
			}else{

			}
		},
		error : function(){
			
		}
	});
});
</script>

</div>
</div>
</div>
</div>
<div class='sep' style='*left:0;'></div>