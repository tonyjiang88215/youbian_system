/** kindEditor 添加打标按钮 **/

/** kindeditor-all.js 6130 line   lang/zh-Cn.js 241line*/
//KindEditor.lang({
//	mark_column : '标记选项',
//	mark_answer : '标记答案',
//	mark_analysis : '标记解析',
//	mark_children : '标记子题',
//	mark_question : '标记题目',
//	mark_reload : '内容还原'
//});

var questionTemplateObject = {

	rootTable : $('.question_table'),

	cloneHTMLObject : $('#question_template'),

	_data : [],
	
	_childData : [],

	editorElement : ['question_stem_content' , 'question_column_single_content' , 
		         		'question_column_multi_content' , 
		         		'question_answer_content' , 'question_analysis_content'],
						
	columnElement : ['column_combine' , 'column_difficulty' , 'column_from' , 'column_grade' , 'column_id',
						'column_knowledge' , 'column_num' , 'column_obj_flag' , 'column_score' , 'column_type'],
		
	clear : function(){
		this.rootTable.find('tr:visible:not(.table_header)').remove();
	},

	setData : function(data , childData){
		this._data = data;
		this._childData = childData;
	},

	
	show : function(){
		this.clear();
		
		if(this._data.length == 0){
			alert('暂无数据');
			return;
		}
		
		
		for(var i = 0 ; i < this._data.length ; i++){
			
			var clone = this.cloneHTMLObject.clone().removeAttr('id').attr({
				'index' : i , 
				'combine' : 'parent' , 
				'gid' :this._data[i].gid,
				'net' : 'true'
			});
			
			clone.find('.question_column_single_content .input_radio').attr('name' , 'single_radio_'+i);
			clone.find('.question_column_judge_content .input_radio').attr('name' , 'judge_radio_'+i);
			
//			console.log(this._data[i].column_content);
//			var _column_tmp = eval(this._data[i].column_content);
//			var _column_tmp = eval('var _column_tmp='+this._data[i].column_content+';');
//			console.log(_column_tmp);
			
			var currentNewData = {
				gid : this._data[i].gid,
				subject_id : this._data[i].subject_id,
				grade_id : this._data[i].grade_id,
				section_id : TJDataCenter.get('section'),
				combine_flag : this._data[i].combine_flag ? this._data[i].combine_flag : 0,
				objective_flag : this._data[i].objective_flag ? this._data[i].objective_flag : 0,
				knowledge : this._data[i].knowledge_id ? this._data[i].knowledge_id.split(',') : [],
				knowledge_text : this._data[i].knowledge_text ? this._data[i].knowledge_text.split(',') : [],
				children : [],
				question_type :	this._data[i].question_type,
				question_template : this._data[i].question_template ? this._data[i].question_template : 1,
				difficulty : this._data[i].difficulty,
//				column : this._data[i].column_content ? this._data[i].column_content.split('@hx_column@') : [],
				column : this._data[i].column_content ? (this._data[i].column_content == 'null' ? [] : eval(this._data[i].column_content)) : [],
				column_count : this._data[i].option_count,
				score : this._data[i].score ? this._data[i].score : 0,
				question_content : this._data[i].content,
				answer_content :  this._data[i].answer,
				analysis_content :  this._data[i].analysis,
				setin_exam_id : this._data[i].setin_exam_id ? this._data[i].setin_exam_id : 0,
				exam_name : TJDataCenter.get('setin_exam_name') ,
				source : TJDataCenter.get('setin_source') ,
				time : this._data[i].time ? this._data[i].time : 0,
				keyword : String(this._data[i].keyword ? this._data[i].keyword : '') 
				
			};
			
			var currentData = {
				gid : this._data[i].gid,
				subject_id : this._data[i].subject_id,
				grade_id : this._data[i].grade_id,
				section_id : TJDataCenter.get('section'),
				combine_flag : this._data[i].combine_flag ? this._data[i].combine_flag : 0,
				objective_flag :  this._data[i].objective_flag ? this._data[i].objective_flag : 0,
				knowledge : this._data[i].knowledge_id ? this._data[i].knowledge_id.split(',') : [],
				knowledge_text : this._data[i].knowledge_text ? this._data[i].knowledge_text.split(',') : [],
				children : [],
				question_type :	this._data[i].question_type,
				question_template : this._data[i].question_template ? this._data[i].question_template : 1,
				difficulty : this._data[i].difficulty,
//				column : this._data[i].column_content ? this._data[i].column_content.split('@hx_column@') : [],
				column : this._data[i].column_content ? (this._data[i].column_content == 'null' ? [] : eval(this._data[i].column_content)) : [],
				column_count : this._data[i].option_count,
				score : this._data[i].score ? this._data[i].score : 0,
				question_content : this._data[i].content,
				answer_content :  this._data[i].answer,
				analysis_content :  this._data[i].analysis,
				setin_exam_id : this._data[i].setin_exam_id ? this._data[i].setin_exam_id : 0,
				exam_name : TJDataCenter.get('setin_exam_name') ,
				source : TJDataCenter.get('setin_source') , 
				time : this._data[i].time ? this._data[i].time : 0,
				keyword : String(this._data[i].keyword ? this._data[i].keyword : '')
			};
			
			clone.data('oldData' , currentData);
			clone.data('newData' , currentNewData );
			
//				this.question_render(clone , 'subjective');

			clone.appendTo('.question_table');
			
			this._data[i].package_name = TJDataCenter.get('setin_source');
			
			this._data[i].exam_name = TJDataCenter.get('setin_exam_name');
			
			this.fillValues(clone , this._data[i]);
//			this.fillValues(clone , currentData);

			var template_id = this._data[i].question_template;

			if(template_id && template_id != 0){
				var config = TJDataCenter.get('question_templates')[template_id];
				this.question_render(clone , config);
			}
			
			clone.show();
			
			//如果是主子题，则继续渲染子题
			if(this._data[i].combine_flag == 1){
				//将模版替换成主题模版
				this.question_render(clone , TJDataCenter.get('question_combine_parent_template'));
				this.showChildren(currentNewData);
			}
			
			//隐藏不可用模版
			clone.find('.q_template option[combine_flag!='+currentNewData.combine_flag+']').hide();
			
			delete clone;
		}
		
		$(window).triggerHandler('resize');
		
	},
	
	showChildren : function(parent_data){
		for(var i = 0 ; i < this._childData.length ; i++){
			if(this._childData[i].parent_gid == parent_data.gid){
				
				var currentData = this._childData[i];
				
				var clone = this.cloneHTMLObject.clone().removeAttr('id').attr('combine','children').attr({
					'index': i,
					'combine': 'children',
					'gid': currentData.gid,
					'net': 'true'
				});
			
				clone.find('.question_column_single_content .input_radio').attr('name' , 'sub_single_radio_'+i);
				clone.find('.question_column_judge_content .input_radio').attr('name' , 'sub_judge_radio_'+i);
				
				//删除checkbox，并将主题的checkbox的rowspan加1
				var parentElement = $('.question_template[gid='+currentData.parent_gid+']');
				
				clone.find('.check_td').remove();
				parentElement.find('.check_td').attr('rowspan' , parseInt(parentElement.find('.check_td').attr('rowspan'))+1);
				
				var _currentData = {
					gid : currentData.gid,
					objective_flag : currentData.objective_flag,
					combine_flag : 1,
					question_type :	currentData.question_type,
					question_template : currentData.question_template,
//					column : currentData.column_content ? currentData.column_content.split('@hx_column@') : [],
					column : currentData.column_content ? (currentData.column_content == 'null' ? [] : eval(currentData.column_content)) : [],
					column_count : currentData.option_count,
					score : currentData.score,
					question_content : currentData.content,
					answer_content :  currentData.answer,
					analysis_content :  currentData.analysis,
					exam_name : TJDataCenter.get('setin_exam_name') ,
					source : TJDataCenter.get('setin_source') , 
					parent_gid : currentData.parent_gid ,
					
					knowledge : currentData.knowledge_id ? currentData.knowledge_id.split(',') : [],
					knowledge_text : currentData.knowledge_text ? currentData.knowledge_text.split(',') : [],
					difficulty : currentData.difficulty,
					time : currentData.time ? currentData.time : 0,
					keyword : String(currentData.keyword ? currentData.keyword : '')
			
				};
				
				var currentNewData = {
					gid : currentData.gid,
					objective_flag : currentData.objective_flag,
					combine_flag : 1,
					question_type :	currentData.question_type,
					question_template : currentData.question_template,
//					column : currentData.column_content ? currentData.column_content.split('@hx_column@') : [],
					column : currentData.column_content ? (currentData.column_content == 'null' ? [] : eval(currentData.column_content)) : [],
					column_count : currentData.option_count,
					score : currentData.score,
					question_content : currentData.content,
					answer_content :  currentData.answer,
					analysis_content :  currentData.analysis,
					exam_name : TJDataCenter.get('setin_exam_name') ,
					source : TJDataCenter.get('setin_source') , 
					parent_gid : currentData.parent_gid,
					
					knowledge : currentData.knowledge_id ? currentData.knowledge_id.split(',') : [],
					knowledge_text : currentData.knowledge_text ? currentData.knowledge_text.split(',') : [],
					difficulty : currentData.difficulty,
					time : currentData.time ? currentData.time : 0,
					keyword : String(currentData.keyword ? currentData.keyword : '')
				};
				
				clone.data( 'oldData', _currentData );
				clone.data('newData' , currentNewData);
				
				parent_data.children.push(currentNewData);
				
				clone.appendTo('.question_table');
				
				this.fillValues(clone , currentData);

				var template_id = currentData.question_template;
				
				//先按照选择的题型进行渲染
				if(template_id && template_id != 0){
					var config = TJDataCenter.get('question_templates')[template_id];
					this.question_render(clone , config);
				}else{
					this.question_render(clone ,  TJDataCenter.get('question_combine_children_column'));
				}
				
				
				//隐藏不可用模版
				clone.find('.q_template option[combine_flag=0]').hide();
				
				clone.show();
				
			}
		}
	},

	fillValues : function(questionHTMLObj , data){

		//题号
		questionHTMLObj.find('.q_id').html(data.gid);
		
		//年级
		questionHTMLObj.find('.q_grade').val(data.grade_id);

		//包名，不保存
		questionHTMLObj.find('.q_package').html(data.package_name);
		
		//来源
		questionHTMLObj.find('.q_from').html(data.exam_name);
		
		//题干
		questionHTMLObj.find('.question_stem_content').html(data.content);
		//选项

		var e = new TJEvent.EventObject('question_info_change');
		e.data.object = questionHTMLObj;
		e.data.change = 'column';
		TJEvent.dispatch(e);
		
		//答案
		questionHTMLObj.find('.question_answer_content').html(data.answer);
		//解析
		questionHTMLObj.find('.question_analysis_content').html(data.analysis);
		//题号
		questionHTMLObj.find('.q_id').text(data.id);
		//主子题
		questionHTMLObj.find('.q_combine').val(data.combine_flag);
		//主客观
		questionHTMLObj.find('.q_obj_flag').val(data.objective_flag);
		//知识点
		questionHTMLObj.find('.q_knowledge').val(data.knowledge_text).attr('title',data.knowledge_text);
		
		if(data.question_type != 0){
			//题型
			questionHTMLObj.find('.q_type').val(data.question_type).trigger('change');
			//试题模版
			var _tid = data.question_template;
			
			questionHTMLObj.find('.q_template').val(_tid);
			data.question_template = _tid;
		}
		//难度
		questionHTMLObj.find('.q_difficulty').val(data.difficulty);
		//选项个数
		questionHTMLObj.find('.q_column_num').val(data.option_count);
		//分值
		questionHTMLObj.find('.q_score').val(data.score);
		//时长
		questionHTMLObj.find('.q_time').val(data.time);
		//关键字
		questionHTMLObj.find('.q_keyword').val(data.keyword);
	},

	question_render : function(questionHTMLObj , config){

		//根据配置文件，设置题目主显示区需要显示的内容
		for(var i in config){
			if(i.indexOf('question') == -1 && i.indexOf('column') == -1){
				continue;
			}else{
				if(config[i] == 0){
					questionHTMLObj.find('.'+i).hide();
				}else{
					questionHTMLObj.find('.'+i).show();
				}
				
			}
		}
	},

	showEditor : function(element){
//			setTimeout(function(){
		
			window.editor = KindEditor.create(element , {
	         	minWidth:'200px',
	         	width :	$(element).width()+5,
				height :$(element).height() > 500 ? '500px': $(element).height()+120,
//				height : $(element).height()+120,
				filterMode : false,
				items : [
					 'justifyleft', 'justifycenter', 'justifyright',
			         'justifyfull', 'subscript', 'superscript', 'formatblock', 'fontname', 'fontsize', 'forecolor','bold',
			         'italic', 'underline', '|', 'upload_image' , 'table', 'hr' ,  '/' ,
			         'mark_column' , 'mark_answer' , 'mark_analysis' , 'mark_children' , 'mark_question' , '|' , 'mark_reload'
	         	]
			});

			$(element).closest('.question_template').addClass('editing');

			TJDataCenter.set('editor_column_element' , element);
			TJDataCenter.set('editor_show' , true);
		
//			},100);
	},

	analysisContent : function(element){

	},
	
	extend : function(key , object){
		this[key] = object;
	},

	bindEvent : function(){
		var _this = this;

		TJEvent.addListener('question_type_change' , function(e){
			var typeHTMLObject = _this.cloneHTMLObject.find('.q_type');
			typeHTMLObject.html('');
			typeHTMLObject.append('<option value=0>------请选择------</option>');
			
			for(var i in e.data.question_type){
				typeHTMLObject.append('<option value="'+e.data.question_type[i].question_type_id+'" index='+i+' objective_flag='+e.data.question_type[i].objective_flag+'>'+e.data.question_type[i].type_name+'</option>');
			}
			
		});

		//监听 对选项 打标
		TJEvent.addListener('split_column' , function(e){
			
			var newData = $('.editing').data('newData');
			
			if(e.data.action == 'add'){
				var columnContent = e.data.content.replace('A．','').replace('B．','').replace('C．','').replace('D．','').replace('E．','');
				var _updateFlag = false;
				for(var i = 0 ; i < newData.column.length ; i++){
					if(newData.column[i] == ''){
						newData.column[i] = columnContent;
						_updateFlag = true;
						break;
					}
				}
				if(!_updateFlag){
					newData.column.push(columnContent);
				}
			}
//			else if(e.data.action == 'undo'){
//				newData.column.pop();
//			}
			
			newData.column_count = newData.column.length > 4 ? newData.column.length : 4;
			
			var e = new TJEvent.EventObject('question_info_change');
			e.data.object = $('.editing');
			e.data.change = 'column';

			TJEvent.dispatch(e);
		});

		//监听 对 答案 打标
		TJEvent.addListener('split_answer' , function(e){
			var newData = $('.editing').data('newData');
			
			if(e.data.action == 'add'){
				newData.answer_content = e.data.content;
			}else if(e.data.action == 'undo'){
				newData.answer_content = '';
			}
			
			var e = new TJEvent.EventObject('question_info_change');
			e.data.object = $('.editing');
			e.data.change = 'answer';

			TJEvent.dispatch(e);
		});

		//监听 对 解析 打标
		TJEvent.addListener('split_analysis' , function(e){
			var newData = $('.editing').data('newData');
			
			if(e.data.action == 'add'){
				newData.analysis_content = e.data.content;
			}else if(e.data.action == 'undo'){
				newData.analysis_content = '';
			}
			
			var e = new TJEvent.EventObject('question_info_change');
			e.data.object = $('.editing');
			e.data.change = 'analysis';

			TJEvent.dispatch(e);
		});

		
		//监听 对 子题 打标
		TJEvent.addListener('split_children' , function(e){

			var newData = $('.editing').data('newData');

			if(!newData.children){
				newData.children = [];
			}
			
			var childrenData = {
					gid : newData.gid+'_'+newData.children.length,
					objective_flag : 0,
					question_type :	0,
					question_template : 0,
					column_count : 0,
					column : [],
					score : 0,
					question_content : e.data.content ,
					answer_content : '',
					analysis_content : '',
					parent_gid : newData.gid,
					exam_name : TJDataCenter.get('setin_exam_name') ,
					setin_exam_id : TJDataCenter.get('setin_exam_id'),
					source : TJDataCenter.get('setin_source')
			};
			
			newData.children.push(childrenData);
			
			$('.editing').find('.q_combine').val(1).trigger('change');
			
			var clone = $('#question_template').clone().removeAttr('id').attr('combine','children').attr('gid' , childrenData.gid);
			clone.data('newData' , childrenData);
			clone.find('.question_stem_content').html(e.data.content);
			clone.find('.q_template option[combine_flag=0]').hide();
			
			$('.editing').find('.check_td').attr('rowspan',parseInt($('.editing').find('.check_td').attr('rowspan'))+1);
			clone.find('td:eq(0)').remove();
			
			clone.insertAfter('.editing').show();
			
			
			_this.question_render($('.editing') , TJDataCenter.get('question_combine_parent_template'));

			_this.question_render(clone , TJDataCenter.get('question_combine_children_template'));
			
		});

		TJEvent.addListener('split_question' , function(e){
			
			var _gid = TJDataCenter.get('setin_exam_code');
			
			var _index = TJDataCenter.get('new_index');
			
			_gid += '_'+ _index;
			
			var currentNewData = {
				gid : _gid,
				subject_id : TJDataCenter.get('subject'),
				section_id : TJDataCenter.get('section'),
				combine_flag : 0,
				objective_flag : 0,
				knowledge : [],
				knowledge_text : [],
				children : [],
				question_type :	0,
				question_template : 0,
				difficulty : 3,
				column : [],
				column_count : 0,
				score : 0,
				question_content : e.data.content,
				answer_content :  '',
				analysis_content :  '',
				exam_name : TJDataCenter.get('setin_exam_name') ,
				setin_exam_id : TJDataCenter.get('setin_exam_id'),
				source : TJDataCenter.get('setin_source')
				
			};
			
			var clone = $('#question_template').clone().removeAttr('id').attr({
				'combine' : 'parent',
				'gid' : _gid,
				'net' : 'false'
			});
			clone.data('newData' , currentNewData);
			clone.find('.question_stem_content').html(e.data.content);
			
			clone.find('.q_id').html('新题目').css('color', '#ff3300');
			clone.find('.q_from').html(currentNewData.exam_name);
			clone.find('.q_template option[combine_flag!='+currentNewData.combine_flag+']').hide();
			
			clone.insertAfter('.editing').show();
			
			
			TJDataCenter.set('new_index' , (parseInt(TJDataCenter.get('new_index'))+1).pad(6));
			
		});

		TJEvent.addListener('question_info_change' , function(e){

			var changeHTMLObject = e.data.object;
			var changeData = changeHTMLObject.data('newData');
			
			switch(e.data.change){

				case 'question':

					break;
			
				case 'column':

					changeHTMLObject.find('.q_column_num').val(changeData.column_count);

					var columnHTML = '';
					var checkHTML = '';

					var indexLabel = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N'];

					for(var i = 0 ; i < changeData.column_count ; i++){
						
						columnHTML += 
							'<div class="question_column_each">'+
								'<input type="radio" class="input_radio" name="single_radio_'+changeHTMLObject.attr('gid')+'" value="'+indexLabel[i]+'">'+
								'<span class="question_column_label">'+indexLabel[i]+'</span><span>'+changeData.column[i]+'</span>'+
							'</div>';

						checkHTML += 
						'<div class="question_column_each">'+
							'<input type="checkbox" class="input_checkbox" name="multi_radio_'+changeHTMLObject.attr('gid')+'" value="'+indexLabel[i]+'">'+
							'<span class="question_column_label">'+indexLabel[i]+'</span><span>'+changeData.column[i]+'</span>'+
						'</div>';
						
					}
					
					changeHTMLObject.find('.question_column_single_content').html(columnHTML);
					changeHTMLObject.find('.question_column_multi_content').html(checkHTML);
					
					break;

				case 'answer':

					changeHTMLObject.find('.question_answer_content').html(changeData.answer_content);

					break;

				case 'analysis':

					changeHTMLObject.find('.question_analysis_content').html(changeData.analysis_content);
					
					break;
					
			}
			
		});
		
		TJEvent.addListener('editing_content_reload' , function(e){
			var column_key = $(TJDataCenter.get('editor_column_element')).attr('key');
			
			//如果是选项，需要重新生成选项HTML
			if(column_key == 'column_content'){
				var html = '';
				
				var indexLabel = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N'];

				var columnData = $('.editing').data('oldData')['column'];
				
				var type = '';
				if(TJDataCenter._data.editor_column_element.className.indexOf('single') != -1){
					type = 'single';
				}else if(TJDataCenter._data.editor_column_element.className.indexOf('multi') != -1){
					type = 'multi';
				}
				
				for(var i = 0 ; i < columnData.length ; i++){
					if(type == 'single'){
						html += 
							'<div class="question_column_each">'+
								'<input type="radio" class="input_radio" name="single_radio_'+$('.editing').attr('gid')+'" value="'+indexLabel[i]+'">'+
								'<span class="question_column_label">'+indexLabel[i]+'</span><span>'+columnData[i]+'</span>'+
							'</div>';
					}else if(type == 'multi'){
						html += 
						'<div class="question_column_each">'+
							'<input type="checkbox" class="input_checkbox" name="multi_radio_'+$('.editing').attr('gid')+'" value="'+indexLabel[i]+'">'+
							'<span class="question_column_label">'+indexLabel[i]+'</span><span>'+columnData[i]+'</span>'+
						'</div>';
					}
				}
				
			}else{//其他直接读取原值
				var html = $('.editing').data('oldData')[column_key];
			}
			window.editor.html(html);
			
		});

		TJEvent.addListener('select_knowledge_submit' , function(e){
			
			var whichone = TJDataCenter.get('select_knowledge_whichone');
			var newData = $('.question_template[gid='+whichone+']').data('newData');
			newData.knowledge = e.data.id.slice();
			newData.knowledge_text = e.data.text.slice();
			
			$('.question_template[gid='+whichone+']').find('.q_knowledge').val(e.data.text.join(',')).attr('title' , e.data.text.join(','));
			
		});
		
		TJEvent.addListener('question_remove' , function(e){
			TJDataCenter.set('current_remove_question_id' , e.data.id);
			if($('.question_template[gid='+e.data.id+']').attr('net') == 'true'){
				dataSubmitObject.removeQuestion(e.data.id , e.data.type);
			}else{
				var e = new TJEvent.EventObject('remove_question_success');
				e.data.id = e.data.id;
				TJEvent.dispatch(e);
			}
			
		});
		
		TJEvent.addListener('remove_question_success' , function(e){
			
			alert('删除成功');
			var gid = TJDataCenter.get('current_remove_question_id');
			var htmlObject = $('.question_template[gid='+gid+']');
			
			//如果删除的是子题，则需要把父题的数据中的children进行更新
			if(htmlObject.attr('combine') == 'children'){
				var parent_id = htmlObject.data('newData')['parent_gid'];
				
				var parentData = $('.question_template[gid='+parent_id+']').data('newData');
				
				for(var i = 0 ; i < parentData.children.length ; i++){
					if(parentData.children[i].gid == gid){
						parentData.children.splice(i , 1);
					}
				}
				
			}
			
			htmlObject.remove();
			TJDataCenter.set('current_remove_question_id' , 0);
			
		});
		
		TJEvent.addListener('reset_exam_success',function(e){
			
			if(TJDataCenter.get('setin_source') == e.data.source && TJDataCenter.get('setin_exam_name') == e.data.exam_name){
				dataQueryObject.queryQuestionData();
	
			}
			
		});
		
		//修改年级
		$(document).delegate('.q_grade' , 'change' , function(){
			$(this).closest('.question_template').data('newData').grade_id = $(this).val();
		});
		

		//主子题切换
		$(document).delegate('.q_combine' , 'change' , function(){
			$(this).closest('.question_template').data('newData').combine_flag = $(this).val();
			
			$(this).closest('.question_template').find('.q_template option').show();
			$(this).closest('.question_template').find('.q_template option[combine_flag!='+$(this).val()+']').hide();
			
			
			
		});

		//改变主观题/客观题
		$(document).delegate('.q_obj_flag' , 'change' , function(){
			$(this).closest('.question_template').data('newData').objective_flag = $(this).val();
		});
		
		//点击知识点输入框
		$(document).delegate('.q_knowledge' , 'click' , function(){

			TJDataCenter.set('select_knowledge_whichone' , $(this).closest('.question_template').attr('gid'));
			
			var e = new TJEvent.EventObject('knowledge_list_refresh');

			var newData = $(this).closest('.question_template').data('newData');
			e.data.knowledge_id = newData.knowledge;
			e.data.knowledge_text = newData.knowledge_text;
			
			TJEvent.dispatch(e);
			
			var e =  new TJEvent.EventObject('knowledge_panel_show');
			TJEvent.dispatch(e);
		});
		
		
		//改变试题模版时
		$(document).delegate('.q_template' , 'change' , function(){
			
			$(this).closest('.question_template').find('.q_type option').remove();
			
			var template_id = $(this).val();
			
			$(this).closest('.question_template').data('newData').question_template = template_id;
			
			
			var typeData = TJDataCenter.get('question_type');
			
			for(var i = 0 ; i< typeData.length ; i++){
				if(typeData[i].template[template_id]){
					$(this).closest('.question_template').find('.q_type').append(
						'<option value="'+typeData[i].question_type_id+'" index="'+i+'" objective_flag="'+typeData[i].objective_flag+'">'+typeData[i].type_name+'</option>'
					);
				}
			}
			
			$(this).closest('.question_template').find('.q_type').trigger('change');
			
			var config = TJDataCenter.get('question_templates')[$(this).val()];
			_this.question_render($(this).closest('.question_template') , config);
			
			
			
			
		});
		
		//改变题目类型时
		$(document).delegate('.q_type' , 'change' , function(){

/** 
 
  //根据题型修改模版
			var typeData = TJDataCenter.get('question_type')[$(this).find('option:checked').attr('index')];

			var templateHTMLObject = $(this).closest('.question_template')

			$(this).closest('.question_template').data('newData').question_type = $(this).val();

//			templateHTMLObject.html('');

			for(var i in typeData.template){
				
//				templateHTMLObject.append('<option value="'+typeData.template[i].template_id+'" index='+i+'  >'+typeData.template[i].template_name+'</option>');
//				if(typeData.template[i]['default'] == 1){
//					var config = TJDataCenter.get('question_templates')[typeData.template[i].template_id];
//					_this.question_render($(this).closest('.question_template') , config);
//				}

//				if (typeData.template[i]['default'] == 1 && $(this).closest('.question_template').data('newData').combine_flag == typeData.template[i]['combine_flag']) {
				if (templateHTMLObject.data('newData').combine_flag == typeData.template[i]['combine_flag']) {
					templateHTMLObject.find('.rcmd_option').removeClass('rcmd_option');
					templateHTMLObject.find('.q_template option[value='+typeData.template[i]['template_id']+']').addClass('rcmd_option').prependTo($(this).closest('.question_template').find('.q_template'));
					templateHTMLObject.find('.q_template').val(typeData.template[i]['template_id']);
					templateHTMLObject.find('.q_template').trigger('change');
				}

			}
  
  
  
 * 
 */
			if($(this).val() == 0){
				return;
			}
			
			

			$(this).closest('.question_template').data('newData').question_type = $(this).val();
			//根据提醒修改主客观
			$(this).closest('.question_template').find('.q_obj_flag').val($(this).find('option[value='+$(this).val()+']').attr('objective_flag'));
			
		});

		//改变题目难度时
		$(document).delegate('.q_difficulty' , 'change' , function(){
			$(this).closest('.question_template').data('newData').difficulty = $(this).val();
		});

		//改变题目难度时
		$(document).delegate('.q_score' , 'change' , function(){
			$(this).closest('.question_template').data('newData').score = $(this).val();
		});
		
		//改变题目时长
		$(document).delegate('.q_time' , 'change' , function(){
			$(this).closest('.question_template').data('newData').time = $(this).val();
		});
		
		//改变题目关键字
		$(document).delegate('.q_keyword' , 'change' , function(){
			$(this).closest('.question_template').data('newData').keyword = $(this).val();
		});
		
		
		for(var i in this.editorElement){

			$(document).delegate('.'+this.editorElement[i] , 'click' , function(){
				console.log('dsadas');
				if(window.editor){

					var content = window.editor.html();
					
					window.editor.remove();
					window.editor = null;
					
					var key = $(TJDataCenter.get('editor_column_element')).attr('key');
					if(key == 'column_content'){
					
						$('.editing').data('newData').column.length = 0;
						$('.editing').find('.question_column input:visible').each(function(){
							$('.editing').data('newData').column.push($(this).siblings('.question_column_label').next().html());
						});
						
						$('.editing').data('newData').column_count = $('.editing').data('newData').column.length;
						
						var e = new TJEvent.EventObject('question_info_change');
						e.data.change = 'column';
						e.data.object = $('.editing');
						TJEvent.dispatch(e);
						
						
					}else{
						$('.editing').data('newData')[key] = content;
					}

					$('.editing').removeClass('editing');
					TJDataCenter.set('editor_show' , false);
					
				}
				_this.showEditor(this);
				return false;
			});
		}
		
		$(document).click(function(e){
			if(window.editor && TJDataCenter.get('editor_show') && $(e.target).attr('class') && $(e.target).attr('class').indexOf('ke') == -1){

				var content = window.editor.html();
				window.editor.remove();
				window.editor = null;
				
				var key = $(TJDataCenter.get('editor_column_element')).attr('key');
				if(key == 'column_content'){
					
					$('.editing').data('newData').column.length = 0;
					$('.editing').find('.question_column input:visible').each(function(){
						$('.editing').data('newData').column.push($(this).siblings('.question_column_label').next().html());
					});
					
					$('.editing').data('newData').column_count = $('.editing').data('newData').column.length;
					
					var e = new TJEvent.EventObject('question_info_change');
					e.data.change = 'column';
					e.data.object = $('.editing');
					TJEvent.dispatch(e);
					
					
				}else{
					$('.editing').data('newData')[key] = content;
				}

				$('.editing').removeClass('editing');

				TJDataCenter.set('editor_show' , false);
			}
		});

		//点击单选选项
		$(document).delegate('.question_template .input_radio', 'mousedown' , function(e){
			
			$(this).closest('.question_template').find('.question_answer_content').text($(this).val());
			$(this).closest('.question_template').data('newData').answer_content = $(this).closest('.question_template').find('.question_answer_content').html();
			
			if(e.stopPropagation) { //W3C阻止冒泡方法  
		        e.stopPropagation();  
		    } else {  
		        e.cancelBubble = true; //IE阻止冒泡方法  
		    }  
			
			return false;
		});
		
		//点击判断题的选项
		$(document).delegate('.question_template .question_column_judge_content .input_radio', 'mousedown' , function(e){
			
			$(this).closest('.question_template').find('.question_answer_content').text($(this).val() == '对' ? 'T' : 'F');
			$(this).closest('.question_template').data('newData').answer_content = $(this).closest('.question_template').find('.question_answer_content').html();
			
			if(e.stopPropagation) { //W3C阻止冒泡方法  
		        e.stopPropagation();  
		    } else {  
		        e.cancelBubble = true; //IE阻止冒泡方法  
		    }  
			
			return false;
		});
		
		//点击多选选项
		$(document).delegate('.question_template .input_checkbox', 'mousedown' , function(e){
			
			var text = '';
			$(this).closest('.question_column_multi').find('.input_checkbox').each(function(){
				if(  (this != e.target && $(this).is(':checked')) || (this == e.target && $(this).is(':not(:checked)'))){
					text += $(this).val();
				}
			});
			
			$(this).closest('.question_template').find('.question_answer_content').text(text);
			$(this).closest('.question_template').data('newData').answer_content = $(this).closest('.question_template').find('.question_answer_content').html();

			if(e.stopPropagation) { //W3C阻止冒泡方法  
		        e.stopPropagation();  
		    } else {  
		        e.cancelBubble = true; //IE阻止冒泡方法  
		    }  
			
			return false;
		});
		
		//修改选项个数
		$(document).delegate('.q_column_num' , 'change' , function(e){
			
			var questionTemplate = $(this).closest('.question_template');
			var data = questionTemplate.data('newData');
			
			var count = Math.abs(parseInt($(this).val()) - data.column.length);
			
			data.column_count = parseInt($(this).val());
			
			if(parseInt($(this).val()) > data.column.length){
				for(var i = 0 ; i < count  ; i++){
					data.column.push('');
				}
			}else{
				for(var i = 0 ; i < count ; i++){
					data.column.pop();
				}
			}
			var e = new TJEvent.EventObject('question_info_change');
			e.data.object = questionTemplate;
			e.data.change = 'column';
			TJEvent.dispatch(e);
		});
		
		//改变题目分值
		$(document).delegate('.q_score' , 'change' , function(e){
			
			var templateElement = $(this).closest('.question_template');
			if(templateElement.attr('combine') == 'parent'){
				var _data = templateElement.data('newData');
				_data.score = parseInt($(this).val());
				
				var _per = Math.floor(parseInt($(this).val())/_data.children.length);
				
				var _tmp = templateElement.next();
				
				var _sum = 0;
				
				for(var i = 0 ; i < _data.children.length - 1 ; i++){
					_tmp.data('newData').score = _per;
					_tmp.find('.q_score').val(_per);
					_sum += _per;
					
					_tmp = _tmp.next();
				}
				
				_tmp.data('newData').score = _data.score - _sum;
				_tmp.find('.q_score').val( _data.score - _sum);
				
			}else{
				
				var _data = templateElement.data('newData');
				_data.score = parseInt($(this).val());
				
				
				//.prevUntil('.question_template[combine=parent]'); //prevUntil BUG
				var parentElement = $(this).closest('.question_template');
				
				while(parentElement.attr('combine') != 'parent'){
					parentElement = parentElement.prev();
				}
				
				var _parentData = parentElement.data('newData');
				
				_parentData.score = 0;
				
				for(var i = 0 ; i < _parentData.children.length ; i++){
					_parentData.score += _parentData.children[i].score;
				}
				
				parentElement.find('.q_score').val(_parentData.score);
				
			}
		});
		
		
		//删除题目
		$(document).delegate('.question_remove' , 'click' , function(e){
			if(confirm('确认删除当前题目？')){
				var e = new TJEvent.EventObject('question_remove');
				e.data.id = $(this).closest('.question_template').attr('gid');
				e.data.type = $(this).closest('.question_template').attr('combine');
				TJEvent.dispatch(e);
			}
			
		});
		
		
		TJEvent.addListener('section_change' , function(){
	
			$('#question_template .q_grade option[value!=0]').show();
			$('#question_template .q_grade option[value!=0][section_id!=' + TJDataCenter.get('section') + ']').hide();
		
		});
		
		TJEvent.addListener('nav_toggle' , function(){
			$('.question_table .content_td > div').css('width' , $('.question_table').parent().width() - 200 - 45);
		});
		
		
		$(window).resize(function(){
			$('.question_table .content_td > div:not(.seal_img_wrapper)').css('width' , $('.question_table').parent().width() - 200 - 45);
		});
		
		
	}
	
};

//全选按钮
$(document).delegate('.check_all' , 'click' , function(e){
	var checked = this.checked;
	$('.question_table .input_check:not(.check_all)').each(function(){
		this.checked = checked;
	});
});
	
