<?php 
$navArray = array_keys($manage);

$inArray = in_array($names[1], $navArray);
?>

<style type='text/css'>
	
	.nav{
		position:absolute;
		width:181px;
		top:54px;
		bottom:0px;
		background:#fafafa;
		border-right:1px solid #ccc;
	}
	
	.nav_mini{
		width:48px;
	}
	
	
	.nav_shadow{
		position: absolute;
		width: 183px;
		height: 100%;
		top: 0;
		left: 0;
		background: #ebebeb;
		z-index: -1;
	}

	
	.nav_ul{
		margin:0;
		padding:0;
		list-style:none;
	}
	
	.nav_sub_ul{
		display:none;
		margin:0;
		padding:0;
		list-style:none;
		border-top: 1px solid #e5e5e5;
		background:#fff;
	}
	
	/* 第一层 */
	.nav-list > li > .nav_text{
		border-left:4px solid #fafafa;
	}
	
	.nav-list > li > .nav_text:hover{
		border-left:4px solid #2b7dbc;
	}
	
	.nav_mini .nav-list > .nav_active > .nav_text > .nav_label{
		border-left:1px solid #2b7dbc;
	}
	
	.nav-list > li > .nav_selected{
		font-weight:bold;
		color:#2b7dbc;
	}
	
	
	/* 第二层 */
	.nav-list>li>.nav_sub_ul>li>.nav_text{
		padding-left:36px;
		background:url('/manage_system/pic/client/bg_nav1.png') no-repeat 16px -3px;
	} 
	
	.nav-list> li>.nav_sub_ul>li.nav_active>.nav_text{
		background:url('/manage_system/pic/client/bg_nav_select.png') no-repeat 16px -3px;
	}
	
	.nav-list>li>.nav_sub_ul>li>.nav_text:hover{
		background:url('/manage_system/pic/client/bg_nav_select.png') no-repeat 16px -3px;
	}
	
	/* 第三层 */
	.nav-list>li>.nav_sub_ul>li>.nav_sub_ul>li>.nav_text{
		padding-left:53px;
		background:url('/manage_system/pic/client/bg_nav2.png') no-repeat 16px 0px;
	}
	
	.nav-list>li>.nav_sub_ul>li>.nav_sub_ul>li>.nav_text:hover{
		color:#2b7dbc;
		text-decoration:underline;
	}
	
	/* 第4层 */
	.nav-list>li>.nav_sub_ul>li>.nav_sub_ul>li>.nav_sub_ul>li>.nav_text{
		padding-left:69px;
		background:url('/manage_system/pic/client/bg_nav2.png') no-repeat 16px 0px;
	}
	
	.nav-list>li>.nav_sub_ul>li>.nav_sub_ul>li>.nav_sub_ul>li>.nav_text:hover{
		color:#2b7dbc;
		text-decoration:underline;
	}
	
	/* 第5层 */
	.nav-list>li>.nav_sub_ul>li>.nav_sub_ul>li>.nav_sub_ul>li.nav_sub_ul>li>.nav_text{
		padding-left:75px;
		background:url('/manage_system/pic/client/bg_nav2.png') no-repeat 16px 0px;
	}
	
	.nav_sub_ul>li:first-child{
		border-top: 1px solid #fafafa;
	}
	
	.nav_sub_ul>li:last-child{
		border-bottom: 0;
	}
	
	.nav_li{
		padding: 0;
		margin: 0;
		border: 0;
		border-top: 1px solid #fcfcfc;
		border-bottom: 1px solid #e5e5e5;
		position: relative;
		cursor:pointer;
	}
	
	
	
	.nav-list>li>.nav_sub_ul>li{
	}
	
	.nav_text{
		height:38px;
		line-height:36px;
		color:#585858;
		font-size:12px;
		padding:0 16px 0 7px;
		text-decoration:none;
		display:block;
		vertical-align:middle;
	}
	
	.nav_icon{
		display:inline-block;
		min-width:26px;
		height:26px;
		margin-right:5px;
		margin-top:5px;
		background-image:url("/manage_system/pic/client/bg_nav_total.png");
		float:left;
	}
	
	.nav_open .nav_icon{
		background-position-y : -23px;
	}
	
	.nav_icon_user{
		background-position:-24px -0px;
	}
	
	.nav_icon_nsource{
		background-position:-48px 0px;
	}
	
	.nav_icon_isource{
		background-position:-96px 0px;
	}
	
	.nav_icon_base{
		background-position:-120px -0px;
	}
	
	.nav_icon_setout{
		background-position:-72px  0px;
	}
	
	.nav_icon_stat{
		background-position:26px 0px;
	}
	
	
	.nav_label{
		display:inline;
		line-height:36px;
	}
	
	.nav_parent>a>.nav_toggle{
		display:inline-block;
	}
	
	.nav_toggle{
		display:none;
		width:14px;
		height:14px;
		position:absolute;
		top:10px;
		right:11px;
		background:url('/manage_system/pic/client/bg_nav_slide.png') 0px 14px;
	}
	
	.nav_select_tag{
		display:none;
	}
	
	.nav_active > .nav_text > .nav_select_tag{
		display:inline-block;
		width:14px;
		height:40px;
		position:absolute;
		top:-1px;
		right:-2px;
		background:url('/manage_system/pic/client/bg_nav_select_tag.png') no-repeat 0px 1px;
	}
	
	.nav_open > .nav_text{
		color:#2b7dbc;
	}
	
	.nav_active > .nav_text{
		color:#2b7dbc;
	}
	
	.nav_active > .nav_text > .nav_toggle{
		background-position:0px 0px;
	}
	
	.nav_open > .nav_text > .nav_toggle{
		background-position:0px 0px;
	}
	
	.nav-list > .nav_active{
		width:180px;
		border-right:2px solid #577abe;
	}
	
	.nav_hide{
		position:relative;
		height:20px;
		border-bottom:1px solid #e5e5e5;
	}
	
	.nav_hide_bg{
		position:absolute;
		top:10px;
		height:1px;
		left:0;
		right:0;
		background:#e5e5e5;
	}
	
	
	.nav_hide_btn{
		position:relative;
		width:20px;
		height:20px;
		left:75px;
		background:url('/manage_system/pic/client/bg_nav_mini.png') no-repeat 0px 0px;
		cursor:pointer;
	}
	
	.nav_footer{
		position:absolute;
		bottom:0px;
		height:30px;
		line-height:30px;
		width:100%;
		background:#FFF;
		border-top:1px solid #CCE0EC;
		text-align:center;
		font-size:10px;
	}
	
	
	
	
	/* 第一层 */
	.nav_mini .nav-list > li{
		width:48px;
	}
	.nav_mini .nav-list > li > .nav_sub_ul{
		position: absolute;
		top: 38px;
		left: 48px;
		width: 181px;
		border: 1px solid #c1c1c1;
		background: #fff;
		z-index: 3;
		display:none!important;
		-webkit-box-shadow: rgba(0, 0, 0, 0.2) 2px 1px 2px 0px;
		box-shadow: rgba(0, 0, 0, 0.2) 2px 1px 2px 0px;
	}
	
	.nav_mini .nav-list > li.mini_hover > .nav_sub_ul{
		display:block!important;
	}
	
	.nav_mini .nav-list > li > .nav_text > .nav_label {
		display: none;
		position: absolute;
		width: 173px;
		top:-2px;
		left: 48px;
		height:39px;
		padding-left: 8px;
		background: #f5f5f5;
		z-index: 3;
		border: 1px solid #c1c1c1;
		-webkit-box-shadow: rgba(0, 0, 0, 0.2) 2px 1px 2px 0px;
		box-shadow: rgba(0, 0, 0, 0.2) 2px 1px 2px 0px;
	}
	
	.nav_mini .nav-list > li.mini_hover > .nav_text > .nav_label {
		display:block;
	}
	
	.nav_mini  .nav-list > li > .nav_text >.nav_toggle{
		display:none;
	}
	
	
	/* 第二层 */
	.nav_mini .nav-list>li>.nav_sub_ul>li>.nav_text{
		padding-left:36px;
		background:none;
	} 
	
	.nav_mini .nav-list>li>.nav_sub_ul>li.nav_active>.nav_text{
		background:url('/manage_system/pic/client/bg_nav3.png') no-repeat 16px 0px;
	}
	
	.nav_mini .nav-list>li>.nav_sub_ul>li>.nav_text:hover{
		background:url('/manage_system/pic/client/bg_mini_nav.png') no-repeat 16px 0px;
	}
	
	
	/* 第三层 */
	.nav_mini .nav-list>li>.nav_sub_ul>li>.nav_sub_ul>li>.nav_text{
		padding-left:53px;
		background:none;
	}
	
	.nav_mini .nav-list>li>.nav_sub_ul>li>.nav_sub_ul>li>.nav_text:hover{
		color:#2b7dbc;
		text-decoration:underline;
	}
	
	/* 第4层 */
	.nav_mini .nav-list>li>.nav_sub_ul>li>.nav_sub_ul>li>.nav_sub_ul>li>.nav_text{
		padding-left:69px;
		background:none;
	}
	
	.nav_mini .nav-list>li>.nav_sub_ul>li>.nav_sub_ul>li>.nav_sub_ul>li>.nav_text:hover{
		color:#2b7dbc;
		text-decoration:underline;
	}
	
	/* 第5层 */
	.nav_mini .nav-list>li>.nav_sub_ul>li>.nav_sub_ul>li>.nav_sub_ul>li.nav_sub_ul>li>.nav_text{
		padding-left:75px;
		background:none;
	}
	
	.nav_mini .nav_shadow{
		width: 59px;
	}
	
	.nav_mini .nav_hide_btn{
		left:16px;
		background:url('/manage_system/pic/client/bg_nav_mini2.png');
	}
	
</style>

<div class='nav_content'>


<ul class='nav_ul nav-list'>
<?
	foreach($manage as $type => $nav){
?>
	<li class='nav_li <?=count($nav['children']) > 0? 'nav_parent' :'' ?>'>
		<a class='nav_text'  href='<?=$nav['link']; ?>'>
			<div class='nav_icon nav_icon_<?=$nav['key']; ?>'></div>
			<span class='nav_label'><?=$nav['name'] ?></span>
			<div class='nav_toggle'></div>
			<div class='nav_select_tag'></div>
		</a>
		<ul class='nav_sub_ul'>
			<?
			foreach($nav['children'] as $nav2){
			?>
			<li class='nav_li <?=count($nav2['children']) > 0? 'nav_parent' :'' ?> <?=$current_file == $nav2['link'] ? 'nav_active' : '' ?>'>
				<a class='nav_text'  href='/manage_system/<?=$type . '/' . $nav2['link']; ?>'>
					<span class='nav_label'><?=$nav2['name'] ?></span>
					<div class='nav_toggle'></div>
					<div class='nav_select_tag' ></div>
				</a>
				<ul class='nav_sub_ul'>
				</ul>
			</li>
			<?
			}
			?>
		</ul>
	</li>
<?
	}
?>
</ul>
<div class='nav_hide'>
	<div class='nav_hide_bg'></div>	
	<div class='nav_hide_btn'></div>
</div>


</div>
<div class='nav_footer' style='display:none;'>Powered By TonyJiang ©2013</div>
<script type='text/javascript'>
			
			$(document).ready(function(){
				
				/** 菜单展开 */
				$('.nav_parent').click(function(){
					
					if ($('.nav').hasClass('nav_mini') && $(this).parent().hasClass('nav-list')) {
						return;
					}
					
					//如果已经展开
					if($(this).hasClass('nav_open')){
						
						//关闭
						$(this).removeClass('nav_open').children('.nav_sub_ul').slideUp(200);
						
						//如果有子项被选中，关闭以后，设置当前被选中
						if($(this).find('.nav_active').length > 0){
							$(this).children('.nav_text').children('.nav_select_tag').show(200);
						}
						
					//如果没有展开	
					}else{
						
						//先把其他展开关闭（不关闭当前激活项）
						$(this).siblings('.nav_open:not(.nav_active)').removeClass('nav_open').children('.nav_sub_ul').slideUp(200);
						
						//展开
						$(this).addClass('nav_open').children('.nav_sub_ul').slideDown(200);
						
						//如果有子项被选中，隐藏当前被选中
						if($(this).find('.nav_active').length > 0){
							$(this).children('.nav_text').children('.nav_select_tag').hide(200);
						}
						
						
					}
					
					return false;
						
				});
				
				$('.nav-list > li').mouseenter(function(){
					if($('.nav').hasClass('nav_mini')){
						$(this).addClass('mini_hover');
//						$(this).children('.nav_sub_ul').show();
						
						//如果有子项被选中，隐藏当前被选中
						if($(this).find('.nav_active').length > 0){
							$(this).children('.nav_text').children('.nav_select_tag').hide(200);
						}
					}
				});
				
				$('.nav-list > li').mouseleave(function(){
					if($('.nav').hasClass('nav_mini')){
						$(this).removeClass('mini_hover');
//						$(this).children('.nav_sub_ul').hide();
						
						//如果有子项被选中，关闭以后，设置当前被选中
						if($(this).find('.nav_active').length > 0){
							$(this).children('.nav_text').children('.nav_select_tag').show(200);
						}
						
					}
				});
				
				$('.nav_text').click(function(){
					if($(this).next().children().length == 0){
						window.location.href = $(this).attr('href');
						return false;
					}
				});
				
				/** 收缩按钮 */
				$('.nav_hide_btn').click(function(){
					//如果已经隐藏，则展开
					if($(this).attr('hide') == 'hide'){
						
						$('.nav').removeClass('nav_mini');
						
						$('.nav-list > li:has(.nav_select_tag:visible)').children('a').children('.nav_select_tag').hide(200);
						
						$(this).attr('hide' , 'show')
						
						$('.content').css('left','182px');

						var e = new TJEvent.EventObject('nav_toggle');
						e.data.toggle = 'show';
						TJEvent.dispatch(e);
						
					}else{//隐藏
					
						//有子项被选中的，显示选中效果
						$('.nav-list > li:has(.nav_select_tag:visible)').children('a').children('.nav_select_tag').show(200);
						
						$('.nav').addClass('nav_mini');
						$(this).attr('hide' , 'hide');
						
						$('.content').css('left','50px');

						var e = new TJEvent.EventObject('nav_toggle');
						e.data.toggle = 'hide';
						TJEvent.dispatch(e);
						
					}

				});


				$('.nav_active').parents('li').click().addClass('nav_open nav_active').children('.nav_text').children('.nav_select_tag').hide();
				
			});
			
</script>