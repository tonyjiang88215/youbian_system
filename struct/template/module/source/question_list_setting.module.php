<style type='text/css'>
.question_list_setting{
	position:relative;
	padding:5px;
	border:1px solid #c1c1c1;
	min-height:80px;
	background:#f5f5f5;
	max-height: 150px;
	overflow-y: auto;
}

.setin_batch{
	position:relative;
	padding:2px 5px;
}


.setin_batch_children{
	position:relative;
	border:1px solid #d1d1d1;
	background:white;
}

.setin_exam{
	position:relative;
	padding:2px 10px;
}

.setin_exam_select{
	background : rgb(223, 232, 243);
}

.setin_exam:hover{
	background:#eef2f7;
	cursor:pointer;
}

.setin_exam_setting{
	position:absolute;
	top:2px;
	right:0;	
	width:124px;
}

.setin_exam_none:hover{
	background:white;
	cursor:default;;
}

.exam_reset , .exam_finish , .exam_finished , .exam_setout{
	position:relative;
	float:right;
	margin-right:5px;
	
}

.exam_finish{
	width:36px;	
	
}

.exam_finished{
	color:#c1c1c1;
	text-decoration: none;
}

.setin_exam_wrapper{
	position:relative;
}



</style>

<div class='question_list_setting' style='display:none;' >
<? 
	foreach($batch_array as $batch =>$exam_name){
?>
	<div class='setin_batch'><?=$batch ;?></div>
	<div class='setin_batch_children'>
		<?
			if(count($exam_name) == 0){
		?>		
			<div class='setin_exam setin_exam_none'>暂无数据</div>
		<?		
			}else{
				foreach($exam_name as $name){
		?>
					<div class='setin_exam'><?=$name; ?></div>
					<div class='setin_exam_setting'><a class='exam_finish' href='javascript:void(0);'>完成</a><a class='exam_reset' href='javascript:void(0);'>重载</a></div>
		<?		
				}	
				
			}
		?>
	</div>
<?		
	}
?>
	<div class="info_tag">导入批次</div>
</div>
<script type='text/javascript'>
$(document).delegate('.setin_exam:not(.setin_exam_none)' , 'click',function(){

	var exam_name =  $.trim($(this).text());
	var exam_id = $.trim($(this).attr('exam_id'));
	var exam_code = $(this).attr('exam_code');
	var source = $(this).closest('.setin_batch_children').prev().text();
	
	if( exam_name == TJDataCenter.get('exam_name')){
		return;
	}
	
	$('.setin_exam_select').removeClass('setin_exam_select');
	$(this).addClass('setin_exam_select');

	TJDataCenter.set('setin_exam_name' , exam_name);
	TJDataCenter.set('setin_exam_code' , exam_code);
	TJDataCenter.set('setin_exam_id' , exam_id);
	TJDataCenter.set('setin_source' , source);
	
	var e = new TJEvent.EventObject('in_batch_change');
// 	e.data.source = $(this).closest('.setin_batch_children').prev().text();
// 	e.data.source_code = $.trim($(this).closest('.setin_batch_children').prev().attr('code'));
// 	e.data.exam_name = $.trim($(this).text());
	e.data.exam_id = exam_id;
	e.data.exam_code = exam_code;
	TJEvent.dispatch(e);
	
});


$(document).delegate('.exam_reset' , 'click' , function(){

	var exam_name =  $.trim($(this).parent().prev().text());
	var exam_id = $.trim($(this).parent().prev().attr('exam_id'));

	TJDataCenter.set('reset_exam_id' , exam_id);
	
	
	if(!confirm('确认重载“'+exam_name+'”卷子的内容吗？')){
		return;
	}	
	var source = $(this).closest('.setin_batch_children').prev().text();

	var e = new TJEvent.EventObject('exam_reset');
// 	e.data.exam_name = exam_name;
// 	e.data.source = source;
	e.data.exam_id = exam_id;
	TJEvent.dispatch(e);
	
});

$(document).delegate('.exam_finish' , 'click' , function(){
	var exam_id = $(this).closest('.setin_exam_wrapper').find('.setin_exam').attr('exam_id');

	TJDataCenter.set('finish_exam_id' , exam_id);
	
	dataSubmitObject.finishExam(exam_id);
});

$(document).delegate('.exam_setout' , 'click' , function(){

	var exam_id = $(this).closest('.setin_exam_wrapper').find('.setin_exam').attr('exam_id');

	var e = new TJEvent.EventObject('exam_setout');
	e.data.exam_id = exam_id;
	TJEvent.dispatch(e);
	
});

</script>
