<style type='text/css'>
	.detail_wrapper{
		position:relative;
	}
	
	.detail_item{
		position:relative;
		padding:2px 5px;
		color:#666;
	}
	
</style>
<? echo $this->headElement; ?>
<div class='content_main' >
	<div class="content_element" style="border:0;padding:0;border-bottom:1px solid #c1c1c1;">
		<div class="content_element_wrapper source_type_wrapper">
		<?php 
			foreach($sourceType as $type){
		?>
			<a class="content_tab" href="javascript:void(0);" stid='<?=$type['id']; ?>'><?=$type['name']; ?></a>
		<?php 
			}
		?>
		</div>
		<div class="clear_float"></div>
	</div>
	<div class='content_element'  style='min-height: 180px;padding:0;'>
	
	
		<div class='detail_wrapper'>
			<div class='detail_item' id='detail_item_template' style='display:none;'>
				<span class='detail_time'></span>
				<span class='detail_user'></span>
				<span class='detail_st'></span>
				<span class='detail_action'></span>
				<span class='detail_entity'></span>
				<span class='detail_entity_name'></span>
				<span class='detail_note'></span>
			</div>
		</div>
	
	</div>
	<?=$popPanels; ?>
</div>