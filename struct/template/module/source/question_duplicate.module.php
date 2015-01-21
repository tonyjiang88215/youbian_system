<style type='text/css'>

.question_table *{
	text-align:left;
}

.input_radio , .input_checkbox{
	position:relative;
	top:2px;
}

.question_objective_single{
	
}

.question_objective_multi{
	
}

.question_objective_combie{
	
}

.question_objective_single{
	
}

.question_stem{
	border-bottom:1px solid  #d1d1d1;
	min-height:50px;
}

<!-- -->
/*
.question_stem_title{
	position:relative;
	padding:5px;
	text-align:left;
	background:#aeddbc;
}

.question_column_title{
	position:relative;
	padding:5px;
	text-align:left;	
	border-bottom:1px solid #d1d1d1;
	background:#f9dd7e;
}
*/

.question_stem_title{
	position:relative;
	padding:5px 2px;
	border-bottom:1px solid #d1d1d1;
}

.question_stem_content , .question_text_content{
	background:#f5f5f5;
	position:relative;;
	padding:10px 5px;
	word-wrapper:break-word;
}

.question_column{
	min-height:50px;
}

.question_column_title{
	position:relative;
	padding:5px 2px;
	border-bottom:1px solid #d1d1d1;
}

.question_column_content{
	position:relative;
	padding:10px 5px;
	background:#f5f5f5;
	border-bottom:1px solid #d1d1d1;
	word-wrapper:break-word;
}

.question_column_each{
	position:relative;
	padding:5px 10px;
}

.question_column_label{
	position:relative;
	margin-right : 10px;
	margin-left : 3px;
}

.question_answer{
	position:relative;
}

.question_answer_title{
	position:relative;
	padding:5px 2px;
}

.question_answer_content{
	position:relative;
	padding:10px 5px;
	border-top:1px solid #d1d1d1;
	border-bottom:1px solid #d1d1d1;
	min-height:40px;
	background:#f5f5f5;
	word-wrapper:break-word;
}

.question_analysis{
	position:relative;
}

.question_analysis_title{
	position:relative;
	padding:5px 2px;
}

.question_analysis_content{
	position:relative;
	padding:10px 5px;
	border-top:1px solid #d1d1d1;
	min-height:40px;
	background:#f5f5f5;
	word-wrapper:break-word;
}

.content_td{
	vertical-align:top;
	min-width:430px;
}

.setting_td{
	width:220px;
	vertical-align:top;
}

.setting_td .content_per{
	margin : 0 2px;
}

.question_attr_setting{
	position:relative;
}

.question_role_handler{
	position:relative;
	padding:5px;
	border-bottom:1px solid #c1c1c1;
}

.question_role_handler img{
	position:relative;
	cursor:pointer;
}

</style>
<style type="text/css">

.ke-icon-mark_column {
	background-image: url('/manage_system/pic/editor/column.png');
	width: 32px;
	height: 16px;
}

.ke-icon-mark_answer {
	background-image: url('/manage_system/pic/editor/answer.png');
	width: 32px;
	height: 16px;
}

.ke-icon-mark_analysis {
	background-image : url('/manage_system/pic/editor/analysis.png');
	width: 32px;
	height: 16px;
}

.ke-icon-mark_children {
	background-image : url('/manage_system/pic/editor/children.png');
	width: 32px;
	height: 16px;
}

.ke-icon-mark_question {
	background-image : url('/manage_system/pic/editor/question.png');
	width: 32px;
	height: 16px;
}

.ke-icon-mark_reload {
	background-image : url('/manage_system/pic/editor/reload.png');
	width: 32px;
	height: 16px;
}

.ke-icon-upload_image {
	background-image : url('/manage_system/js/kindeditor/themes/default/default.png');
	background-position: 0px -496px;
	width: 16px;
	height: 16px;
}

</style>
<?=$this->headElement; ?>
<div class='content_list'>
	<table class='question_table' cellpadding="0" cellspacing="0">
		<tr class='table_header'>
			<td class='check_td' rowspan=1><input type='checkbox' class='input_check check_all'></input></td>
			<td class='content_td' style=''>题目内容</td>
			<td class='setting_td'>题目属性</td>
		</tr>
		
		
		
		<!-- 综合模版 -->
		<tr class='question_template' id='question_template' style='display:none;'>
			<td class='check_td' rowspan=1><input type='checkbox' class='input_check'></input></td>
			<td class='content_td'>
				<div class='content_per column_id'>
					<span class="column column_align" style='width:48px;'>编号</span>
					<span class="value q_id"></span>
				</div>
				<div class='clear_float'></div>
				<div class='question_stem'>
					<div class='question_stem_title'>
						<div class='title_line_left'></div>
						<div class='title_label'>题干</div>
						<div class='title_line_right'></div>
						<div class='clear_float'></div>
					</div>
					<div class='question_stem_content'  key='question_content'></div>
				</div>
				
				<div class='question_answer'>
					<div class='question_answer_title'>
						<div class='title_line_left' style='background:#c0e8f4;'></div>
						<div class='title_label'>答案</div>
						<div class='title_line_right' style='background:#c0e8f4;'></div>
						<div class='clear_float'></div>
					</div>
					<div class='question_answer_content' key='answer_content'>
					</div>
				</div>
				
				<div class='question_analysis'>
					<div class='question_analysis_title'>
						<div class='title_line_left' style='background:#ffccff;'></div>
						<div class='title_label'>解析</div>
						<div class='title_line_right' style='background:#ffccff;'></div>
						<div class='clear_float'></div>
					</div>
					<div class='question_analysis_content' key='analysis_content'>
					</div>
				</div>
				
			</td>
			
			<td class='content_td' >
				<div class='content_per column_id'>
					<span class="column column_align" style='width:48px;'>编号</span>
					<span class="value q_id"></span>
				</div>
				<div class='clear_float'></div>
				<div class='question_stem'>
					<div class='question_stem_title'>
						<div class='title_line_left'></div>
						<div class='title_label'>参考</div>
						<div class='title_line_right'></div>
						<div class='clear_float'></div>
					</div>
					<div class='question_text_content'  key='question_content'></div>
				</div>
			
			</td>
		</tr>
		
		<!--  单选模版  -->
		
		<!-- 判断题模版  -->
		
		<!--  多选模版  -->
		
		<!--  主子题模版  -->
		
		<!--  主观题模版  -->
		
	</table>
</div>
<script type='text/javascript' src='/manage_system/js/kindeditor/kindeditor-min.js'></script>
<script type='text/javascript'>
//全选按钮
$(document).delegate('.check_all' , 'click' , function(e){
	var checked = this.checked;
	$('.question_table .input_check:not(.check_all)').each(function(){
		this.checked = checked;
	});
});
</script>