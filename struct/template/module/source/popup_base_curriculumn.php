<!--  新增版本弹出面板  -->
<style  type='text/css'>

.add_curriculumn_popup{
	width :230px;
	height:220px;
	margin-left:-115px;
	margin-top:-90px;
	
}

.add_curriculumn_popup .column{
	width:55px;
}

.confirm_panel{
	position:relative;
	margin-top:6px;
}
</style>

<div class='popup_panel add_curriculumn_popup' style='display:none;'>
	<div class='popup_head'>
		<div class='popup_title'>新增版本</div>
		<div class='popup_close'></div>
	</div>
	<div class='popup_content' style='overflow:hidden;'>
		<div class="content_per">
			<span class="column column_align">*版本名</span>
			<span class="value">
				<input type='text' class='input_text curriculumn_name'></input>
			</span>
		</div>
		<div class="content_per">
			<span class="column column_align">*版本号</span>
			<span class="value">
				<input type='text' class='input_text curriculumn_version'></input>
			</span>
		</div>
		<div class="content_per">
			<span class="column column_align">*扩展编号</span>
			<span class="value">
				<input type='text' class='input_text curriculumn_extends'></input>
			</span>
		</div>
		<div class='content_per'>
			<span class='column column_align'>*参照版本</span>
			<span class='value'>
				<select class='input_select ref_curriculumn' >
					<option value=0>------请选择------</option>
					<?
						foreach($popPanels['addCurriculumn']['data'] as $v){
					?>
					<option value='<?=$v['id'] ?>'><?=$v['name']; ?></option>
					<?		
						}	
					?>
				</select>
			</span>
		</div>
		<div class='clear_float'></div>
		<div class='confirm_panel'>
			<input type='button' class='input_btn add_curriculumn_cancel' value='取消' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<input type='button' class='input_btn add_curriculumn_submit' value='确定' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<div class='clear_float'></div>
		</div>
	</div>
	<div class='popup_panel_shadow'></div>
</div>

<script type="text/javascript">

	TJEvent.addListener('ref_curriculumn_change' , function(e){
		$('.ref_curriculumn option[value!=0]').remove();
		for(var i = 0 ; i < e.data.length ; i ++){
			$('.ref_curriculumn').append('<option value='+e.data[i].id+'>'+e.data[i].name+'</option>');
		}

	});

	TJEvent.addListener('add_curriculumn_finish' , function(){

		$('.curriculumn_name').val('');
		$('.curriculumn_version').val('');
		$('.curriculumn_extends').val('');
		$('.ref_curriculumn').val(0);
		
		$('.add_curriculumn_popup').hide();
	});

	$('.add_curriculumn_submit').click(function(){
		var name = $.trim($('.curriculumn_name').val());
		if(name == ''){
			alert('版本名不能为空');
			return;
		}
			
		var version = $.trim($('.curriculumn_version').val());
		if(version == ''){
			alert('版本号不能为空');
			return;
		}

		var extend = $.trim($('.curriculumn_extends').val());
		if(extend == ''){
			alert('扩展编号不能为空');
			return;
		}
		
		var ref = $('.ref_curriculumn').val();

		var e = new TJEvent.EventObject('add_curriculumn_submit');
		e.data.name = name;
		e.data.version = version;
		e.data.extend = extend;
		e.data.ref = ref;
		TJEvent.dispatch(e);
		
	});				

	$('.add_curriculumn_cancel').click(function(){
		$(this).closest('.popup_panel').hide();		
	});

</script>


<!--  版本新增改动弹出面板  -->
<style type="text/css">
					
.add_curriculumn_detail_popup{
	width:600px;
	height:380px;
	margin-left:-289px;
	margin-top:-190px;
}

.book_select_wrapper{
	position:relative;
	padding:5px 10px;
}

.combo_select{
	position:relative;
	width:276px;
	height:234px;
	border:1px solid #c1c1c1;
	overflow-y:scroll;
	float:left;
}

.book_content_list{
	postion: relative;
	padding: 2px 0 2px 5px;
	cursor: pointer;
}

.book_content_list:hover{
	background: #eef2f7;
}
					
</style>

<div class='popup_panel add_curriculumn_detail_popup' style='display:none;'>
	<div class='popup_head'>
		<div class='popup_title'>新增记录</div>
		<div class='popup_close'></div>
	</div>
	<div class='popup_content' style='overflow:hidden;'>
		<?=$popPanels['searchBarFirst']; ?>
		<div class="knowledge_list_title">
			<div class="title_line_left"></div>
			<div class="title_label">教材</div>
			<div class="title_line_right" style="left:58px;top:50px;"></div>
			<div class="clear_float"></div>
		</div>
		<div class='book_select_wrapper'>
			<div class='combo_select book_list'>
			
			</div>
			<div class='combo_select book_selected' style='margin-left:10px;'></div>
			<div class='clear_float'></div>
		</div>
		<div class='clear_float'></div>
		<div class='confirm_panel'>
			<input type='button' class='input_btn add_curriculumn_detail_cancel' value='取消' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<input type='button' class='input_btn add_curriculumn_detail_submit' value='确定' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<div class='clear_float'></div>
		</div>
	</div>
	<div class='popup_panel_shadow'></div>
</div>

<script type="text/javascript">

$('.add_curriculumn_detail_submit').click(function(){

	var type = TJDataCenter.get('current_type');

	var e = new TJEvent.EventObject('add_curriculumn_detail_submit');
	
	switch(parseInt(type)){

		case 1:

			if($('.book_selected .book_content_list').length == 0){
				alert('教材不能为空');
				return;
			}

			var book = [];

			$('.book_selected .book_content_list').each(function(){
				book.push({
					id:$(this).attr('book_id'),
					text : $('.add_curriculumn_detail_popup .select_subject option:checked').text() + '-' + 
					$('.add_curriculumn_detail_popup .select_section option:checked').text() + '-' + 
					$('.add_curriculumn_detail_popup .select_publisher option:checked').text() + '-' +
					$(this).text()
				});
			});

			TJDataCenter.set('tongbu_new_book' , book);
			
			break;

		case 2: // 知识点，学科和学段必填
		case 3://专题，学科和学段必填
			if(TJDataCenter.get('first_subject') == 0){
				alert('学科不能为空');
				return;
			}

			if(TJDataCenter.get('first_subject') == 0){
				alert('学科不能为空');
				return;
			}

			var text = $('.add_curriculumn_detail_popup .select_subject option:checked').text() + '-' + 
			$('.add_curriculumn_detail_popup .select_section option:checked').text();

			TJDataCenter.set('new_knowledge/zhuanti_text' , text);
			
			
			break;
	}
	TJEvent.dispatch(e);
});

$('.add_curriculumn_detail_cancel').click(function(){
	$(this).closest('.popup_panel').hide();		
});

//类型改变时，新增detail的窗口内容跟着改变
TJEvent.addListener('type_change' , function(){
	switch(parseInt(TJDataCenter.get('current_type'))){
		case 1:
			$('.add_curriculumn_detail_popup').css({
				'width' : '600px',
				'height' : '380px'
			});
			$('.add_curriculumn_detail_popup .knowledge_list_title , .book_select_wrapper').show();
			TJSearchBar.show([{key : 'publisher' , value : 0}]);
			
			break;

		case 2:
		case 3:
			$('.add_curriculumn_detail_popup').css({
				'width' : '389px',
				'height' : '110px'
			});
			$('.add_curriculumn_detail_popup .knowledge_list_title , .book_select_wrapper').hide();
			TJSearchBar.hide(['publisher']);
			
			break;
	}
});

TJEvent.addListener('add_curriculumn_detail_finish' , function(){

	$('.add_curriculumn_detail_popup').hide();
});
</script>


<!--  追加输入弹出面板  -->
<style type="text/css">
					
.detail_data_popup{
	width:620px;
	height:530px;
	margin-left:-325px;
	margin-top:-190px;
}

.detail_data_popup .column{
	width:38px;
}

.tree_wrapper{
	border:1px solid #c1c1c1;
	margin:10px -5px 10px -6px;
	padding:5px 10px;
	height : 356px;
	overflow-y:scroll;
}

</style>

<div class='popup_panel detail_data_popup' style='display:none;'>
	<div class='popup_head'>
		<div class='popup_title'>导入数据</div>
		<div class='popup_close'></div>
	</div>
	<div class='popup_content' style='overflow:hidden;'>
		<?=$popPanels['searchBarSecond']; ?>
		<div class='clear_float'></div>
		<div class='tree_wrapper'>
			<?=$popPanels['treeHTML']; ?>
		</div>
		<div class='confirm_panel'>
			<input type='button' class='input_btn detail_data_cancel' value='取消' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<input type='button' class='input_btn detail_data_submit' value='确定' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<div class='clear_float'></div>
		</div>
	</div>
	<div class='popup_panel_shadow'></div>
</div>

<script type='text/javascript'>

$('.detail_data_submit').click(function(){
	var current_type = TJDataCenter.get('current_type');
	var ref = '';
	
	switch(parseInt(current_type)){

		case 1://同步数据来源

			ref = $('.detail_data_popup .select_subject option:checked').text() + '-' + 
			$('.detail_data_popup .select_section option:checked').text() + '-' + 
			$('.detail_data_popup .select_publisher option:checked').text() + '-' +
			$('.detail_data_popup .select_book option:checked').text() + '-' +
			$('.detail_data_popup .select_curriculumn_version option:checked').text();


			TJDataCenter.set('setin_data_ref' , ref);

			var curriculumn = TJDataCenter.get('second_curriculumn_version');
			var book = TJDataCenter.get('second_book');
			
			if(curriculumn != 0 && book != 0){
				var e = new TJEvent.EventObject('detail_data_submit');
				e.data.curriculumn = curriculumn;
				e.data.book = book;
				TJEvent.dispatch(e);
			}else{
				alert('教材和版本不能为空');
			}
			
			break;

		case 2://知识点数据来源
		case 3://专题数据来源

			ref = $('.detail_data_popup .select_subject option:checked').text() + '-' + 
			$('.detail_data_popup .select_section option:checked').text() + '-' + 
			$('.detail_data_popup .select_curriculumn_version option:checked').text();


			TJDataCenter.set('setin_data_ref' , ref);

			var subject = TJDataCenter.get('second_subject');
			var section = TJDataCenter.get('second_section');
			var curriculumn = TJDataCenter.get('second_curriculumn_version');
			
			if(curriculumn != 0 && subject != 0 && section != 0){
				var e = new TJEvent.EventObject('detail_data_submit');
				e.data.subject = subject;
				e.data.section = section;
				e.data.curriculumn = curriculumn;
				TJEvent.dispatch(e);
			}else{
				alert('学科、学段和版本不能为空');
			}
			
			break;
			
	}
	
});

$('.detail_data_cancel').click(function(){
	$(this).closest('.popup_panel').hide();		
});


TJEvent.addListener('detail_data_finish' , function(){

	$('.detail_data_popup').hide();
});

</script>



<script type='text/javascript'>

TJEvent.addListener('popup_show' , function(e){
	$('.popup_panel').hide();
	$('.'+e.data.name+'_popup').show();


	var current_type = TJDataCenter.get('current_type');
	
	if(e.data.name == 'add_curriculumn_detail'){
		$('.combo_select').html('');

		//根据不同类型，确定searchBar的显示内容
		switch(parseInt(current_type)){
			case 1://同步
				TJSearchBar.allhide('first');
				TJSearchBar.show('first' , [
					{ key : 'subject' , value : 0},
					{ key : 'section' , value : 0},
					{ key : 'publisher' , value : 0},
				]);
				break;

			case 2://知识点
			case 3://专题
				
				TJSearchBar.allhide('first');
				TJSearchBar.show('first' , [
					{ key : 'subject' , value : 0},
					{ key : 'section' , value : 0}
				]);
				break;
		}
	}else if(e.data.name == 'detail_data'){

		switch(parseInt(current_type)){
			case 1://同步
				TJSearchBar.allhide('second');
				TJSearchBar.show('second' , [
					{ key : 'subject' , value : 0},
					{ key : 'section' , value : 0},
					{ key : 'publisher' , value : 0},
					{ key : 'book' , value : 0},
					{ key : 'curriculumn_version' , value : 0}
				]);
				break;
	
			case 2://知识点
			case 3://专题
				
				TJSearchBar.allhide('second');
				TJSearchBar.show('second' , [
					{ key : 'subject' , value : 0},
					{ key : 'section' , value : 0},
					{ key : 'curriculumn_version' , value : 0}
				]);
				break;
		}
		
	}
	$('#treeNavDIV').html('').append(TJTree.treeRender([{id :0 , name : '暂无数据' , children : []}]));
	
	TJDataCenter.set('current_pop_panel' , e.data.name);
	
});

$('.popup_panel .popup_close').click(function(){
	$(this).closest('.popup_panel').hide();
	TJDataCenter.set('current_pop_panel' , 0);
});

$( ".popup_panel" ).draggable({ handle: ".popup_head" });
</script>