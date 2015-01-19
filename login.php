<?php
session_start();

 if($_SESSION['login'] ===true){
 	header('Location: index.php');
 	exit;
 }
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>华夏优编</title>
		<link href="/manage_system/css/common.css" type="text/css" rel="stylesheet" />
		
		<script type="text/javascript" src="/manage_system/js/jquery/jquery.js"></script>
		<script type="text/javascript" src="/manage_system/js/md5.js"></script>
		<script type='text/javascript'>
			$(document).ready(function(){

				$('.login_passwd').keypress(function(e){
					if(e.keyCode == 13){
						$('.login_btn').click();
					}
				});
				
				$('.login_btn').click(function(){
					
					if($(this).attr('login') == true){
						return;
					}
					
					$('.login_text , .login_passwd').removeClass('verify_unpass');
					
					var acc = $.trim($('.login_text').val());
					
					var pass = $.trim($('.login_passwd').val());
					
					if(!acc && !pass){
						$('.error_info').text('请输入用户名和密码').show();
						$('.login_text , .login_passwd').addClass('verify_unpass');
						return;
					}
					
					if(!acc){
						$('.error_info').text('请输入用户名').show();
						$('.login_text').addClass('verify_unpass');
						return;
					}
					
					if(!pass){
						$('.error_info').text('请输入密码').show();
						$('.login_passwd').addClass('verify_unpass');
						return;
					}
					
					$('.error_info').text('').hide();
					
					$(this).val('正在登录...').attr('login' , true);;
					
					$.ajax({
						'url' : '/manage_system/api/user/user_api.php?action=login',
						'type' : 'POST',
						'data' : {
							account : acc,
							passwd : hex_md5(pass)
						},
						'dataType' : 'jsonp',
						success : function(data){
							if(data.length > 0){
								window.location.href = 'index.php';
								
							}else{
								$('.error_info').text('用户名或密码错误，请重试').show();
								$('.login_btn').attr('login' , false).val('登 录');
							}
						},
						error : function(){
							$('.error_info').text('连接失败，请重试').show();
							$('.login_btn').attr('login' , false).val('登 录');
						}
					});
					
					
				});
			});
			
		</script>
		<style type='text/css'>
			
			.bg_cover{
				position:absolute;
				top:0;
				left:0;
				right:0;
				bottom:0;
				background:#bfcee6;
			}
			
			.logo{
				position: absolute;
				background: url('/manage_system/pic/logo.png');
				width: 157px;
				height: 38px;
				top: 50%;
				left: 50%;
				margin-top: -174px;
				margin-left: -186px;
			}
			
			.login_panel{
				width:350px;
				height:250px;
				border:1px solid #a1a1a1;
				margin-left:-175px;
				margin-top:-125px;
			}
			
			.panel_wrapper{
				position:relative;
				margin:0 26px;
				padding:15px 0;
			}
			
			.login_panel .popup_content{
				top:0px;
			}
			
			.login_label , .login_input{
				position:relative;
				margin:2px;
				padding:2px;
				font-size:14px;
			}
			
			.login_text , .login_passwd{
				border:1px solid #c1c1c1;
				line-height:24px;
				padding:3px 6px 3px 30px;
				font-size:14px;
				height:24px;
				width:242px;
				color:#666;
			}
			
			.login_text{
				background:url('/manage_system/pic/client/bg_info.png') no-repeat 4px 4px #f5f5f5;
			}
			
			.login_passwd{
				background:url('/manage_system/pic/client/bg_lock.png') no-repeat 4px 4px #f5f5f5;
			}
			
			.login_text:focus , .login_passwd:focus{
				border:1px solid #333;
			}
			
			.login_btn{
				border:0;
				background:url('/manage_system/pic/client/c.png');
				height:32px;
				line-height:32px;
				width:280px;
				font-size:14px;
				color:#fff;
				text-align:center;
				cursor:pointer;
			}
			
			.login_btn:hover{
				background-position:0 -33px;
			}
			
			.error_info{
				position:relative;
				border:1px solid #ff8080;
				padding : 1px 6px 1px 24px;
				height:24px;
				line-height:25px;
				color:#666;
				margin:2px 4px;
				width:248px;
				background:url('/manage_system/pic/client/bg_error.png') no-repeat 5px 5px #fff2f2;
			}
			
			
			.verify_unpass{
				border:solid 1px #f63;
			}
			
			
		</style>
	</head>
	<body>
		<div class='bg_cover'></div>
		<div class='logo'></div>
		<div class="popup_panel login_panel" style="">
			<div class="popup_content" style="overflow:hidden;">
				<div class='panel_wrapper'>
					<div class='error_info' style='display:none;'></div>
					<div class='login_label'>登录名:</div>
					<div class='login_input'>
						<input type='text' class='login_text' />
					</div>
					<div class='login_label'>登录密码:</div>
					<div class='login_input'>
						<input type='password' class='login_passwd' />
					</div>
					
					<div class='login_input' style='margin-top:20px;'>
						<input type='button' class='login_btn' value='登 录' />
					</div>
				</div>
			</div>
			<div class="popup_panel_shadow"></div>
		</div>
	
	</body>
</html>