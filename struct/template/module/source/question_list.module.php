<style type='text/css'>

.question_table *{
	text-align:left;
}

.question_table td{
	position:relative;
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

.question_stem_content{
	background:#f5f5f5;
	position:relative;;
	padding:10px 5px;
	word-wrapper:break-word;
	overflow:auto;
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
	overflow:auto;
}

.question_column_each{
	position:relative;
	padding:5px 10px;
}

.question_column_label{
	position:relative;
	margin-right : 10px;
	margin-left : 3px;
/* 	display:none; */
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
	overflow:auto;
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
	overflow:auto;
}

.content_td{
	vertical-align:top;
	min-width:500px;
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

.q_template .rcmd_option{
	background:#f5bac0;
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

.seal_img_wrapper{
	position: absolute;
	float: right;
	z-index: 3;
	top: 16px;
	right: 122px;
}

.seal_img{
	display: none;
	height: 110px;
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
		
		<!-- 
		单选
		<tr class='question_objective_single' id='question_single_template' style='display:none;'>
			<td class='check_td'><input type='checkbox' class='input_check'></input></td>
			<td class='content_td'>
				<div class='question_stem'>
					<div class='question_stem_title'>
						<div class='title_line_left'></div>
						<div class='title_label'>题干</div>
						<div class='title_line_right'></div>
						<div class='clear_float'></div>
					</div>
					<div class='question_stem_content'>
						<h1 style='font-size:20px;'>单选题模版:</h1><br/>
						说明：如果同一题分属多个试卷，那么库中只保留一次，各个试卷只是调用关系，对于在新导入中，出现重复，查重后，从库中选出
					</div>
				</div>
				<div class='question_column'>
					<div class='question_column_title'>
						<div class='title_line_left' style='background:#f9dd7e;'></div>
						<div class='title_label'>选项</div>
						<div class='title_line_right' style='background:#f9dd7e;'></div>
						<div class='clear_float'></div>
					</div>
					<div class='question_column_content'>
						<div class='question_column_each'>
							<input type='radio' class='input_radio' name='_radio1'></input><span class='question_column_label'>A</span><span>选项A的内容啊</span>
						</div>
						<div class='question_column_each'>
							<input type='radio' class='input_radio' name='_radio1'></input><span class='question_column_label'>B</span><span>选项B的内容啊</span>
						</div>
						<div class='question_column_each'>
							<input type='radio' class='input_radio' name='_radio1'></input><span class='question_column_label'>C</span><span>选项C的内容啊</span>
						</div>
						<div class='question_column_each'>
							<input type='radio' class='input_radio' name='_radio1'></input><span class='question_column_label'>D</span><span>选项D的内容啊</span>
						</div>
					</div>
				</div>
				<div class='question_answer'>
					<div class='question_answer_title'>
						<div class='title_line_left' style='background:#c0e8f4;'></div>
						<div class='title_label'>答案</div>
						<div class='title_line_right' style='background:#c0e8f4;'></div>
						<div class='clear_float'></div>
					</div>
					<div class='question_answer_content'>
						dsadsada
					</div>
				</div>
				<div class='question_analysis'>
					<div class='question_analysis_title'>
						<div class='title_line_left' style='background:#ffccff;'></div>
						<div class='title_label'>解析</div>
						<div class='title_line_right' style='background:#ffccff;'></div>
						<div class='clear_float'></div>
					</div>
					<div class='question_analysis_content'>
						dsadsada
					</div>
				</div>
				
			</td>
			<td class='setting_td' width='220px'>
				<div class='question_attr_setting'>
					<div class='content_per'>
						<span class="column column_align" style='width:48px;'>题目编号</span>
						<span class="value q_id">ti1000001</span>
					</div><br/><br/>
					<div class='content_per'>
						<span class="column column_align" style='width:48px;'>主子题</span>
						<span class="value">
							<select class="input_select q_combine">
								<option value=1>是</option>
								<option value=0>否</option>
							</select>
						</span>
					</div><br/><br/>
					<div class='content_per'>
						<span class="column column_align" style='width:48px;'>知识点</span>
						<span class='value'>
							<input type='text' class='input_text q_knowledge'></input>
						</span>
					</div><br/><br/>
					<div class='content_per'>
						<span class="column column_align" style='width:48px;'>题型</span>
						<span class='value'>
							<select class="input_select q_type">
								<option>单选题</option>
								<option>多选题</option>
								<option>填空题</option>
							</select>
						</span>
					</div><br/><br/>
					<div class='content_per'>
						<span class="column column_align" style='width:48px;'>难度</span>
						<span class='value'>
							<select class="input_select q_diffculty">
								<option value=1 >容易</option>
								<option value=2 >较易</option>
								<option value=3 >中等</option>
								<option value=4 >较难</option>
								<option value=5 >困难</option>
							</select>
						</span>
					</div><br/><br/>
					<div class='content_per'>
						<span class="column column_align" style='width:48px;'>主客观</span>
						<span class='value'>
							<select class="input_select q_obj_flag">
								<option>主观题</option>
								<option>客观题</option>
							</select>
						</span>
					</div><br/><br/>
					<div class='content_per'>
						<span class="column column_align" style='width:48px;'>选项个数</span>
						<span class='value'>
							<select class="input_select q_column_num">
								<option>1</option>
								<option>2</option>
								<option>3</option>
								<option selected='selected'>4</option>
								<option>5</option>
								<option>6</option>
								<option>7</option>
								<option>8</option>
							</select>
						</span>
					</div><br/><br/>
					<div class='content_per'>
						<span class="column column_align" style='width:48px;'>分值</span>
						<span class='value'>
							<input type='text' class='input_text q_score'></input>
						</span>
					</div><br/><br/>
				</div>
			</td>
		</tr>
		
		
		判断
		
		<tr class='question_objective_judge' id='question_single_judge' style='display:none;'>
			<td class='check_td'><input type='checkbox' class='input_check'></input></td>
			<td class='content_td'>
				<div class='question_stem'>
					<div class='question_stem_title'>
						<div class='title_line_left'></div>
						<div class='title_label'>题干</div>
						<div class='title_line_right'></div>
						<div class='clear_float'></div>
					</div>
					<div class='question_stem_content'>
						<h1 style='font-size:20px;'>判断题模版:</h1><br/>
						说明：如果同一题分属多个试卷，那么库中只保留一次，各个试卷只是调用关系，对于在新导入中，出现重复，查重后，从库中选出
					</div>
				</div>
				<div class='question_column'>
					<div class='question_column_title'>
						<div class='title_line_left' style='background:#f9dd7e;'></div>
						<div class='title_label'>选项</div>
						<div class='title_line_right' style='background:#f9dd7e;'></div>
						<div class='clear_float'></div>
					</div>
					<div class='question_column_content'>
						<div class='question_column_each'>
							<input type='radio' class='input_radio' name='_radio2'></input><span class='question_column_label'>对</span>
						</div>
						<div class='question_column_each'>
							<input type='radio' class='input_radio' name='_radio2'></input><span class='question_column_label'>错</span>
						</div>
					</div>
				</div>
				<div class='question_answer'>
					<div class='question_answer_title'>
						<div class='title_line_left' style='background:#c0e8f4;'></div>
						<div class='title_label'>答案</div>
						<div class='title_line_right' style='background:#c0e8f4;'></div>
						<div class='clear_float'></div>
					</div>
					<div class='question_answer_content'>
						dsadsada
					</div>
				</div>
				<div class='question_analysis'>
					<div class='question_analysis_title'>
						<div class='title_line_left' style='background:#ffccff;'></div>
						<div class='title_label'>解析</div>
						<div class='title_line_right' style='background:#ffccff;'></div>
						<div class='clear_float'></div>
					</div>
					<div class='question_analysis_content'>
						dsadsada
					</div>
				</div>
				
			</td>
			<td class='setting_td' width='220px'>
				<div class='question_attr_setting'>
					<div class='content_per'>
						<span class="column column_align" style='width:48px;'>题目编号</span>
						<span class="value q_id">ti1000001</span>
					</div><br/><br/>
					<div class='content_per'>
						<span class="column column_align" style='width:48px;'>主子题</span>
						<span class="value">
							<select class="input_select q_combine">
								<option value=1>是</option>
								<option value=0>否</option>
							</select>
						</span>
					</div><br/><br/>
					<div class='content_per'>
						<span class="column column_align" style='width:48px;'>知识点</span>
						<span class='value'>
							<input type='text' class='input_text q_knowledge'></input>
						</span>
					</div><br/><br/>
					<div class='content_per'>
						<span class="column column_align" style='width:48px;'>题型</span>
						<span class='value'>
							<select class="input_select q_type">
								<option>单选题</option>
								<option>多选题</option>
								<option>填空题</option>
							</select>
						</span>
					</div><br/><br/>
					<div class='content_per'>
						<span class="column column_align" style='width:48px;'>难度</span>
						<span class='value'>
							<select class="input_select q_diffculty">
								<option value=1 >容易</option>
								<option value=2 >较易</option>
								<option value=3 >中等</option>
								<option value=4 >较难</option>
								<option value=5 >困难</option>
							</select>
						</span>
					</div><br/><br/>
					<div class='content_per'>
						<span class="column column_align" style='width:48px;'>主客观</span>
						<span class='value'>
							<select class="input_select q_obj_flag">
								<option>主观题</option>
								<option>客观题</option>
							</select>
						</span>
					</div><br/><br/>
					<div class='content_per'>
						<span class="column column_align" style='width:48px;'>分值</span>
						<span class='value'>
							<input type='text' class='input_text q_score'></input>
						</span>
					</div><br/><br/>
				</div>
			</td>
		</tr>
		
		
		
		多选
		<tr class='question_objective_multi' id='question_single_multi' style='display:none;'>
			<td class='check_td'><input type='checkbox' class='input_check'></input></td>
			<td class='content_td'>
				<div class='question_stem'>
					<div class='question_stem_title'>
						<div class='title_line_left'></div>
						<div class='title_label'>题干</div>
						<div class='title_line_right'></div>
						<div class='clear_float'></div>
					</div>
					<div class='question_stem_content'>
						<h1 style='font-size:20px;'>多选题模版:</h1><br/>
						说明：如果同一题分属多个试卷，那么库中只保留一次，各个试卷只是调用关系，对于在新导入中，出现重复，查重后，从库中选出
					</div>
				</div>
				<div class='question_column'>
					<div class='question_column_title'>
						<div class='title_line_left' style='background:#f9dd7e;'></div>
						<div class='title_label'>选项</div>
						<div class='title_line_right' style='background:#f9dd7e;'></div>
						<div class='clear_float'></div>
					</div>
					
				</div>
				<div class='question_answer'>
					<div class='question_answer_title'>
						<div class='title_line_left' style='background:#c0e8f4;'></div>
						<div class='title_label'>答案</div>
						<div class='title_line_right' style='background:#c0e8f4;'></div>
						<div class='clear_float'></div>
					</div>
					<div class='question_answer_content'>
						dsadsada
					</div>
				</div>
				<div class='question_analysis'>
					<div class='question_analysis_title'>
						<div class='title_line_left' style='background:#ffccff;'></div>
						<div class='title_label'>解析</div>
						<div class='title_line_right' style='background:#ffccff;'></div>
						<div class='clear_float'></div>
					</div>
					<div class='question_analysis_content'>
						dsadsada
					</div>
				</div>
				
			</td>
			<td class='setting_td' width='220px'>
				<div class='question_attr_setting'>
					<div class='content_per'>
						<span class="column column_align" style='width:48px;'>题目编号</span>
						<span class="value q_id">ti1000001</span>
					</div><br/><br/>
					<div class='content_per'>
						<span class="column column_align" style='width:48px;'>主子题</span>
						<span class="value">
							<select class="input_select q_combine">
								<option value=1>是</option>
								<option value=0>否</option>
							</select>
						</span>
					</div><br/><br/>
					<div class='content_per'>
						<span class="column column_align" style='width:48px;'>知识点</span>
						<span class='value'>
							<input type='text' class='input_text q_knowledge'></input>
						</span>
					</div><br/><br/>
					<div class='content_per'>
						<span class="column column_align" style='width:48px;'>题型</span>
						<span class='value'>
							<select class="input_select q_type">
								<option>单选题</option>
								<option>多选题</option>
								<option>填空题</option>
							</select>
						</span>
					</div><br/><br/>
					<div class='content_per'>
						<span class="column column_align" style='width:48px;'>难度</span>
						<span class='value'>
							<select class="input_select q_diffculty">
								<option value=1 >容易</option>
								<option value=2 >较易</option>
								<option value=3 >中等</option>
								<option value=4 >较难</option>
								<option value=5 >困难</option>
							</select>
						</span>
					</div><br/><br/>
					<div class='content_per'>
						<span class="column column_align" style='width:48px;'>主客观</span>
						<span class='value'>
							<select class="input_select q_obj_flag">
								<option>主观题</option>
								<option>客观题</option>
							</select>
						</span>
					</div><br/><br/>
					<div class='content_per'>
						<span class="column column_align" style='width:48px;'>选项个数</span>
						<span class='value'>
							<select class="input_select q_column_num">
								<option>1</option>
								<option>2</option>
								<option>3</option>
								<option selected='selected'>4</option>
								<option>5</option>
								<option>6</option>
								<option>7</option>
								<option>8</option>
							</select>
						</span>
					</div><br/><br/>
					<div class='content_per'>
						<span class="column column_align" style='width:48px;'>分值</span>
						<span class='value'>
							<input type='text' class='input_text q_score'></input>
						</span>
					</div><br/><br/>
				</div>
			</td>
		</tr>
		
		
		主观题
		
		<tr class='question_objective_single' id='question_obj_template' style='display:none;'>
			<td class='check_td'><input type='checkbox' class='input_check'></input></td>
			<td class='content_td'>
				<div class='question_stem'>
					<div class='question_stem_title'>
						<div class='title_line_left'></div>
						<div class='title_label'>题干</div>
						<div class='title_line_right'></div>
						<div class='clear_float'></div>
					</div>
					<div class='question_stem_content'>
						<h1 style='font-size:20px;'>主观题模版:</h1><br/>
						说明：如果同一题分属多个试卷，那么库中只保留一次，各个试卷只是调用关系，对于在新导入中，出现重复，查重后，从库中选出
					</div>
				</div>
				<div class='question_answer'>
					<div class='question_answer_title'>
						<div class='title_line_left' style='background:#c0e8f4;'></div>
						<div class='title_label'>答案</div>
						<div class='title_line_right' style='background:#c0e8f4;'></div>
						<div class='clear_float'></div>
					</div>
					<div class='question_answer_content'>
						dsadsada
					</div>
				</div>
				<div class='question_analysis'>
					<div class='question_analysis_title'>
						<div class='title_line_left' style='background:#ffccff;'></div>
						<div class='title_label'>解析</div>
						<div class='title_line_right' style='background:#ffccff;'></div>
						<div class='clear_float'></div>
					</div>
					<div class='question_analysis_content'>
						dsadsada
					</div>
				</div>
				
			</td>
			<td class='setting_td' width='220px'>
				<div class='question_attr_setting'>
					<div class='content_per'>
						<span class="column column_align" style='width:48px;'>题目编号</span>
						<span class="value q_id">ti1000001</span>
					</div><br/><br/>
					<div class='content_per'>
						<span class="column column_align" style='width:48px;'>主子题</span>
						<span class="value">
							<select class="input_select q_combine">
								<option value=1>是</option>
								<option value=0>否</option>
							</select>
						</span>
					</div><br/><br/>
					<div class='content_per'>
						<span class="column column_align" style='width:48px;'>知识点</span>
						<span class='value'>
							<input type='text' class='input_text q_knowledge'></input>
						</span>
					</div><br/><br/>
					<div class='content_per'>
						<span class="column column_align" style='width:48px;'>题型</span>
						<span class='value'>
							<select class="input_select q_type">
								<option>单选题</option>
								<option>多选题</option>
								<option>填空题</option>
							</select>
						</span>
					</div><br/><br/>
					<div class='content_per'>
						<span class="column column_align" style='width:48px;'>难度</span>
						<span class='value'>
							<select class="input_select q_diffculty">
								<option value=1 >容易</option>
								<option value=2 >较易</option>
								<option value=3 >中等</option>
								<option value=4 >较难</option>
								<option value=5 >困难</option>
							</select>
						</span>
					</div><br/><br/>
					<div class='content_per'>
						<span class="column column_align" style='width:48px;'>主客观</span>
						<span class='value'>
							<select class="input_select q_obj_flag">
								<option>主观题</option>
								<option>客观题</option>
							</select>
						</span>
					</div><br/><br/>
					<div class='content_per'>
						<span class="column column_align" style='width:48px;'>分值</span>
						<span class='value'>
							<input type='text' class='input_text q_score'></input>
						</span>
					</div><br/><br/>
				</div>
			</td>
		</tr>
		
		
		主子题
		
		<tr class='question_objective_combie combie_parent' id='question_combie_parent_template' style='display:none;'>
			<td class='check_td' rowspan="3" style='border-bottom:1px dashed #d1d1d1;'><input type='checkbox' class='input_check'></input></td>
			<td class='content_td' style='border-bottom:1px dashed #d1d1d1;'>
				<div class='question_stem'>
					<div class='question_stem_title'>
						<div class='title_line_left'></div>
						<div class='title_label'>题干</div>
						<div class='title_line_right'></div>
						<div class='clear_float'></div>
					</div>
					<div class='question_stem_content'>
						<h1 style='font-size:20px;'>主子题主题模版:</h1><br/>
						说明：如果同一题分属多个试卷，那么库中只保留一次，各个试卷只是调用关系，对于在新导入中，出现重复，查重后，从库中选出
					</div>
				</div>
			</td>
			<td class='setting_td' width='220px' style='border-bottom:1px dashed #d1d1d1;'>
				<div class='question_attr_setting'>
					<div class='content_per'>
						<span class="column column_align" style='width:48px;'>题目编号</span>
						<span class="value q_id">ti1000001</span>
					</div><br/><br/>
					<div class='content_per'>
						<span class="column column_align" style='width:48px;'>主子题</span>
						<span class="value">
							<select class="input_select q_combine">
								<option value=1>是</option>
								<option value=0>否</option>
							</select>
						</span>
					</div><br/><br/>
					<div class='content_per'>
						<span class="column column_align" style='width:48px;'>知识点</span>
						<span class='value'>
							<input type='text' class='input_text q_knowledge'></input>
						</span>
					</div><br/><br/>
					<div class='content_per'>
						<span class="column column_align" style='width:48px;'>题型</span>
						<span class='value'>
							<select class="input_select q_type">
								<option>单选题</option>
								<option>多选题</option>
								<option>填空题</option>
							</select>
						</span>
					</div><br/><br/>
					<div class='content_per'>
						<span class="column column_align" style='width:48px;'>难度</span>
						<span class='value'>
							<select class="input_select q_diffculty">
								<option value=1 >容易</option>
								<option value=2 >较易</option>
								<option value=3 >中等</option>
								<option value=4 >较难</option>
								<option value=5 >困难</option>
							</select>
						</span>
					</div><br/><br/>
					<div class='content_per'>
						<span class="column column_align" style='width:48px;'>主客观</span>
						<span class='value'>
							<select class="input_select q_obj_flag">
								<option>主观题</option>
								<option>客观题</option>
							</select>
						</span>
					</div><br/><br/>
					<div class='content_per'>
						<span class="column column_align" style='width:48px;'>分值</span>
						<span class='value'>
							<input type='text' class='input_text q_score'></input>
						</span>
					</div><br/><br/>
				</div>
			</td>
		</tr>
		<tr class='question_objective_combie  combie_son' id='question_combie_son_obj_template' style='display:none;'>
			<td class='content_td' style='border-top:1px dashed #d1d1d1;'>
				<div class='question_stem'>
					<div class='question_stem_title'>
						<div class='title_line_left'></div>
						<div class='title_label'>题干</div>
						<div class='title_line_right'></div>
						<div class='clear_float'></div>
					</div>
					<div class='question_stem_content'>
						<h1 style='font-size:20px;'>子题模版（选择）:</h1><br/>
						说明：如果同一题分属多个试卷，那么库中只保留一次，各个试卷只是调用关系，对于在新导入中，出现重复，查重后，从库中选出
					</div>
				</div>
				<div class='question_column' >
					<div class='question_column_title'>
						<div class='title_line_left' style='background:#f9dd7e;'></div>
						<div class='title_label'>选项</div>
						<div class='title_line_right' style='background:#f9dd7e;'></div>
						<div class='clear_float'></div>
					</div>
					<div class='question_column_content'>
						<div class='question_column_each'>
							<input type='checkbox' class='input_checkbox'></input><span class='question_column_label'>A</span><span>选项A的内容啊</span>
						</div>
						<div class='question_column_each'>
							<input type='checkbox' class='input_checkbox'></input><span class='question_column_label'>B</span><span>选项B的内容啊</span>
						</div>
						<div class='question_column_each'>
							<input type='checkbox' class='input_checkbox'></input><span class='question_column_label'>C</span><span>选项C的内容啊</span>
						</div>
						<div class='question_column_each'>
							<input type='checkbox' class='input_checkbox'></input><span class='question_column_label'>D</span><span>选项D的内容啊</span>
						</div>
					</div>
				</div>
				<div class='question_answer'>
					<div class='question_answer_title'>
						<div class='title_line_left' style='background:#c0e8f4;'></div>
						<div class='title_label'>答案</div>
						<div class='title_line_right' style='background:#c0e8f4;'></div>
						<div class='clear_float'></div>
					</div>
					<div class='question_answer_content'>
						dsadsada
					</div>
				</div>
				<div class='question_analysis'>
					<div class='question_analysis_title'>
						<div class='title_line_left' style='background:#ffccff;'></div>
						<div class='title_label'>解析</div>
						<div class='title_line_right' style='background:#ffccff;'></div>
						<div class='clear_float'></div>
					</div>
					<div class='question_analysis_content'>
						dsadsada
					</div>
				</div>
				
			</td>
			<td class='setting_td' width='220px' style='border-top:1px dashed #d1d1d1;'>
				<div class='question_attr_setting'>
					<div class='content_per'>
						<span class="column column_align" style='width:48px;'>题型</span>
						<span class='value'>
							<select class="input_select q_type">
								<option>单选题</option>
								<option>多选题</option>
								<option>填空题</option>
							</select>
						</span>
					</div><br/><br/>
					<div class='content_per' style='display:none;'>
						<span class="column column_align" style='width:48px;'>主客观</span>
						<span class='value'>
							<select class="input_select q_obj_flag">
								<option>主观题</option>
								<option>客观题</option>
							</select>
						</span>
					</div>
					<div class='content_per'>
						<span class="column column_align" style='width:48px;'>选项个数</span>
						<span class='value'>
							<select class="input_select q_column_num">
								<option>1</option>
								<option>2</option>
								<option>3</option>
								<option selected='selected'>4</option>
								<option>5</option>
								<option>6</option>
								<option>7</option>
								<option>8</option>
							</select>
						</span>
					</div><br/><br/>
					<div class='content_per'>
						<span class="column column_align" style='width:48px;'>分值</span>
						<span class='value'>
							<input type='text' class='input_text q_score'></input>
						</span>
					</div><br/><br/>
				</div>
			</td>
		</tr>
		<tr class='question_objective_combie  combie_son' id='question_combie_son_sub_template' style='display:none;'>
			<td class='content_td' style='border-top:1px dashed #d1d1d1;'>
				<div class='question_stem'>
					<div class='question_stem_title'>
						<div class='title_line_left'></div>
						<div class='title_label'>题干</div>
						<div class='title_line_right'></div>
						<div class='clear_float'></div>
					</div>
					<div class='question_stem_content'>
						<h1 style='font-size:20px;'>子题模版（主观题）:</h1><br/>
						说明：如果同一题分属多个试卷，那么库中只保留一次，各个试卷只是调用关系，对于在新导入中，出现重复，查重后，从库中选出
					</div>
				</div>
				<div class='question_answer'>
					<div class='question_answer_title'>
						<div class='title_line_left' style='background:#c0e8f4;'></div>
						<div class='title_label'>答案</div>
						<div class='title_line_right' style='background:#c0e8f4;'></div>
						<div class='clear_float'></div>
					</div>
					<div class='question_answer_content'>
						dsadsada
					</div>
				</div>
				<div class='question_analysis'>
					<div class='question_analysis_title'>
						<div class='title_line_left' style='background:#ffccff;'></div>
						<div class='title_label'>解析</div>
						<div class='title_line_right' style='background:#ffccff;'></div>
						<div class='clear_float'></div>
					</div>
					<div class='question_analysis_content'>
						dsadsada
					</div>
				</div>
				
			</td>
			<td class='setting_td' width='220px' style='border-top:1px dashed #d1d1d1;'>
				<div class='question_attr_setting'>
					<div class='content_per'>
						<span class="column column_align" style='width:48px;'>题型</span>
						<span class='value'>
							<select class="input_select q_type">
								<option>单选题</option>
								<option>多选题</option>
								<option>填空题</option>
							</select>
						</span>
					</div><br/><br/>
					<div class='content_per' style='display:none;'>
						<span class="column column_align" style='width:48px;'>主客观</span>
						<span class='value'>
							<select class="input_select q_obj_flag">
								<option>主观题</option>
								<option>客观题</option>
							</select>
						</span>
					</div>
					<div class='content_per'>
						<span class="column column_align" style='width:48px;'>分值</span>
						<span class='value'>
							<input type='text' class='input_text q_score'></input>
						</span>
					</div><br/><br/>
				</div>
			</td>
		</tr>
		
		
		 -->
		
		
		<!-- 综合模版 -->
		<tr class='question_template' id='question_template' style='display:none;'>
			<td class='check_td' rowspan=1><input type='checkbox' class='input_check'></input></td>
			<td class='content_td'>
				<div class='question_stem'>
					<div class='question_stem_title'>
						<div class='title_line_left'></div>
						<div class='title_label'>题干</div>
						<div class='title_line_right'></div>
						<div class='clear_float'></div>
					</div>
					<div class='question_stem_content'  key='question_content'></div>
				</div>
				
				<div class='question_column question_column_single' style='display:none;'>
					<div class='question_column_title'>
						<div class='title_line_left' style='background:#f9dd7e;'></div>
						<div class='title_label'>选项</div>
						<div class='title_line_right' style='background:#f9dd7e;'></div>
						<div class='clear_float'></div>
					</div>
					<div class='question_column_content question_column_single_content'  key='column_content'>
						<div class='question_column_each'>
							<input type='radio' class='input_radio' name='_radio1' value='A'></input><span class='question_column_label'>A</span><span>undefined</span>
						</div>
						<div class='question_column_each'>
							<input type='radio' class='input_radio' name='_radio1' value='B'></input><span class='question_column_label'>B</span><span>undefined</span>
						</div>
						<div class='question_column_each'>
							<input type='radio' class='input_radio' name='_radio1' value='C'></input><span class='question_column_label'>C</span><span>undefined</span>
						</div>
						<div class='question_column_each'>
							<input type='radio' class='input_radio' name='_radio1' value='D'></input><span class='question_column_label'>D</span><span>undefined</span>
						</div>
					</div>
				</div>
				
				<div class='question_column question_column_judge' style='display:none;' >
					<div class='question_column_title'>
						<div class='title_line_left' style='background:#f9dd7e;'></div>
						<div class='title_label'>选项</div>
						<div class='title_line_right' style='background:#f9dd7e;'></div>
						<div class='clear_float'></div>
					</div>
					<div class='question_column_content question_column_judge_content' >
						<div class='question_column_each'>
							<input type='radio' class='input_radio' name='_radio2' value='对'></input><span class='question_column_label'>对</span>
						</div>
						<div class='question_column_each'>
							<input type='radio' class='input_radio' name='_radio2' value='错'></input><span class='question_column_label'>错</span>
						</div>
					</div>
				</div>
				
				<div class='question_column question_column_multi' style='display:none;'  >
					<div class='question_column_title'>
						<div class='title_line_left' style='background:#f9dd7e;'></div>
						<div class='title_label'>选项</div>
						<div class='title_line_right' style='background:#f9dd7e;'></div>
						<div class='clear_float'></div>
					</div>
					<div class='question_column_content question_column_multi_content' key='column_content'>
						<div class='question_column_each'>
							<input type='checkbox' class='input_checkbox' value='A'></input><span class='question_column_label'>A</span><span class=''>undefined</span>
						</div>
						<div class='question_column_each'>
							<input type='checkbox' class='input_checkbox' value='B'></input><span class='question_column_label'>B</span><span>undefined</span>
						</div>
						<div class='question_column_each'>
							<input type='checkbox' class='input_checkbox' value='C'></input><span class='question_column_label'>C</span><span>undefined</span>
						</div>
						<div class='question_column_each'>
							<input type='checkbox' class='input_checkbox' value='D'></input><span class='question_column_label'>D</span><span>undefined</span>
						</div>
					</div>
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
			
			<td class='setting_td' width='220px'>
				<div class='seal_img_wrapper'>
					<img class='seal_img seal_modify' src='/manage_system/pic/seal/modify.png'></img>
					<img class='seal_img seal_delete' src='/manage_system/pic/seal/delete.png'></img>
				</div>
			
				<div class='question_role_handler'>
					<img class='question_remove' src='/manage_system/pic/manage_system/trash.png' title='删除本题'></img>
				</div>
				<div class='question_attr_setting'>
					<div class='content_per column_id'>
						<span class="column column_align" style='width:48px;'>编号</span>
						<span class="value q_id"></span>
					</div>
					<div class='clear_float'></div>
					<div class='content_per column_package'>
						<span class="column column_align" style='width:48px;'>包名</span>
						<span class="value q_package"></span>
					</div>
					<div class='clear_float'></div>
					<div class='content_per column_from'>
						<span class="column column_align" style='width:48px;'>出处</span>
						<span class="value q_from"></span>
					</div>
					<div class='content_per column_grade'>
						<span class="column column_align" style='width:48px;'>年级</span>
						<span class='value'>
							<select class="input_select q_grade">
								<option value=0 >请选择</option>
								<?
									foreach($grade as $g){
										echo '<option value='.$g['id'].' section_id='. $g['section_id'].'>'.$g['name'].'</option>';
									}
								?>
							</select>
						</span>
					</div>
					<div class='content_per column_combine'>
						<span class="column column_align" style='width:48px;'>主子题</span>
						<span class="value">
							<select class="input_select q_combine">
								<option value=0 >否</option>
								<option value=1>是</option>
							</select>
						</span>
					</div>
					<div class='content_per column_template'>
						<span class="column column_align" style='width:48px;'>试题模版</span>
						<span class='value'>
							<select class="input_select q_template">
								<?
									foreach($templates as $t){
										echo '<option value='.$t['id'].' combine_flag='.$t['combine_flag'].'>'.$t['name'].'</option>';
									}
								?>
							</select>
						</span>
					</div>
					<div class='content_per column_type'>
						<span class="column column_align" style='width:48px;'>题型</span>
						<span class='value'>
							<select class="input_select q_type">
							</select>
						</span>
					</div>
					<div class='content_per column_obj_flag'>
						<span class="column column_align" style='width:48px;'>主客观</span>
						<span class='value'>
							<select class="input_select q_obj_flag">
								<option value=0>主观题</option>
								<option value=1>客观题</option>
							</select>
						</span>
					</div>
					<div class='content_per column_knowledge'>
						<span class="column column_align" style='width:48px;'>知识点</span>
						<span class='value'>
							<input type='text' class='input_text q_knowledge'></input>
						</span>
					</div>
					<div class='content_per column_difficulty'>
						<span class="column column_align" style='width:48px;'>难度</span>
						<span class='value'>
							<select class="input_select q_difficulty">
								<option value=1 >容易</option>
								<option value=2 >较易</option>
								<option value=3  selected='selected'>中等</option>
								<option value=4 >较难</option>
								<option value=5 >困难</option>
							</select>
						</span>
					</div>
					<div class='content_per column_num' style='display:none;'>
						<span class="column column_align" style='width:48px;'>选项个数</span>
						<span class='value'>
							<select class="input_select q_column_num">
								<option value=1 >1</option>
								<option value=2 >2</option>
								<option value=3 >3</option>
								<option value=4 selected='selected'  checked='checked'>4</option>
								<option value=5 >5</option>
								<option value=6 >6</option>
								<option value=7 >7</option>
								<option value=8 >8</option>
							</select>
						</span>
					</div>
					<div class='content_per column_score'>
						<span class="column column_align" style='width:48px;'>分值</span>
						<span class='value'>
							<input type='text' class='input_text q_score'></input>
						</span>
					</div>
					<div class='content_per column_time'>
						<span class="column column_align" style='width:48px;'>时长</span>
						<span class='value'>
							<input type='text' class='input_text q_time'></input>
						</span>
					</div>
					<div class='content_per column_keyword'>
						<span class="column column_align" style='width:48px;'>关键字</span>
						<span class='value'>
							<input type='text' class='input_text q_keyword'></input>
						</span>
					</div>
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
<script type='text/javascript' src='/manage_system/js/module/question_list.module.js'></script>
<?php 
	if($edit !== false){
?>
<script type='text/javascript'>
questionTemplateObject.bindEvent();
</script>
<?php 
	}
?>