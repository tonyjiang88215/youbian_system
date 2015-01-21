		<link href='/manage_system/css/common.css' type='text/css' rel='stylesheet' />	
		<link href='/manage_system/js/jquery/jquery.custom.min.css' type='text/css' rel='stylesheet' />	
		<!--  加载JQuery，作为基础类库 -->
		<script type="text/javascript" src='/manage_system/js/jquery/jquery.js'></script>	
		<script type="text/javascript" src='/manage_system/js/jquery/jquery.custom.min.js'></script>	
		<!-- 加载TJ对象，包含基础事件流、数据共享对象 -->
		<script type='text/javascript' src='/manage_system/js/TJ.js'></script>
		<?php echo $this->headerTagElement; ?>
		<div class='main'>
			<div class='top'>
			<?=$top;?>
			</div>
			<div class='nav'>
			<?=$left;?>
			</div>
			<div class='content'>
			<?=$content;?>
			</div>
		</div>
		<?=$popup;?>
		
		<script type='text/javascript'>

		var heightAuto = setInterval(function(){
			var newHeight = Math.max($('.content_element_right').height() , $('.content_element_left').height());
			var oldHeight = Math.min($('.content_element_right').height() , $('.content_element_left').height());
			if(newHeight > oldHeight){
				$('.content_element_right').parent().css('height', newHeight+10);
				$('.content_element_right , .content_element_left').css('min-height' , newHeight);
			}
		},100);
		
		</script>