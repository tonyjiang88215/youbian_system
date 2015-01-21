<style type='text/css'>
	.pager_container{
		float:right;
		padding:2px 5px;
		margin-top:5px;
	}
</style>
<?php echo $this->headElement; ?>
<div class='content_title' style='display:none;'>题目去重维护</div>
<div class='content_main' >
	<div class='content_element'  style='min-height: 200px;'>
		<div class='content_per_wrapper' style='margin-top:10px;margin-bottom:10px;padding-bottom:10px;border-bottom:1px solid #c1c1c1;'>
			<?=$searchBar; ?>
			<div class='clear_float'></div>
		</div>
		<div class='content_element' style='margin-right:10px;margin-left:10px;margin-top:0px;min-height:400px;'>
			<div class='content_element_right' style='left:0;'>
			
				<?=$pagerHTML; ?>
				<div class='clear_float'></div>
				<?=$questionList ;?>
				<?=$pagerHTML; ?>
				<div class='clear_float'></div>
			</div>
			<div class='clear_float'></div>
		</div>
		<div class="info_tag">知识体系维护</div>
	</div>
	<?=$popPanels; ?>
	<?=$floatPanels; ?>
</div>