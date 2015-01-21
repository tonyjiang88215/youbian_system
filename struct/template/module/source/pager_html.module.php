<?php 
if($pager['type'] == 'php'){
	
?>

<?php 
	$pagerHandler = new pager_tool_bar($pager['totalcount'] , $pager['offset'] , $pager['step']);
	$pagerHTML = $pagerHandler->disp_pager_tool_bar($pager['url'] , $pager['linkMax']);
?>

<?=$pagerHTML; ?>

<?
}else if($pager['type'] == 'js'){
?>
<script type="text/javascript" src='/manage_system/js/pager/pager.js'></script>
<script type='text/javascript'>
		var pagerHandler = new Pager();
		pagerHandler.linkMax = <?=$pager['linkMax']; ?>;
		var pagerHTML = pagerHandler.showHTML(<?=$pager['totalcount'] ?> , <?=$pager['offset'] ?> , <?=$pager['step'] ?>);
		document.write(pagerHTML);
		$(document).ready(function(){
			pagerHandler.addStyle();
			pagerHandler.bindEvent();
			pagerHandler.change(function(offset , step){

				var e = new TJEvent.EventObject('pager_change');
				e.data.offset = offset;
				e.data.step = step;
				TJEvent.dispatch(e);
				
			});
		});


		TJEvent.addListener('pager_reset' , function(){
			pagerHandler.setOffset(0);
		});
		
</script>
<?	
}
?>
