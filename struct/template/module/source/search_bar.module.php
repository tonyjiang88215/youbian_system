<!--  版本 -->
<div class='content_per search_curriculumn_version' style='<?=$search['curriculumn_version']['show'] ? '' : 'display:none'; ?>;' search_group='<?=$search['group']; ?>'>
	<span class='column column_align'>版本</span>
	<span class='value'>
		<select class='input_select search_select select_curriculumn_version' search_type='curriculumn_version' search_group='<?=$search['group']; ?>'>
			<option value=0>------请选择------</option>
			<?
				foreach($search['curriculumn_version']['data'] as $v){
			?>
			<option value='<?=$v['id'] ?>' support='<?=$v['support_subject']; ?>' ><?=$v['name']; ?></option>
			<?		
				}	
			?>
		</select>
	</span>
</div>

<!--  学科 -->
<div class='content_per search_subject' style='<?=$search['subject']['show'] ? '' : 'display:none'; ?>;' search_group='<?=$search['group']; ?>'>
	<span class='column column_align'>学科</span>
	<span class='value'>
		<select class='input_select search_select select_subject' search_type='subject' search_group='<?=$search['group']; ?>'>
			<option value=0>------请选择------</option>
			<?
				foreach($search['subject']['data'] as $v){
			?>
			<option value='<?=$v['id'] ?>' attr='<?=implode('_' , $v['attr']); ?>'><?=$v['name']; ?></option>
			<?		
				}	
			?>
		</select>
	</span>
</div>

<!--  学段 -->
<div class='content_per search_section' style='<?=$search['section']['show'] ? '' : 'display:none'; ?>;' search_group='<?=$search['group']; ?>'>
	<span class='column column_align'>学段</span>
	<span class='value'>
		<select class='input_select search_select select_section' search_type='section' search_group='<?=$search['group']; ?>'>
			<option value=0>------请选择------</option>
			<?
				foreach($search['section']['data'] as $v){
			?>
			<option value='<?=$v['id'] ?>' attr='<?=implode('_' , $v['attr']); ?>' style='display:none;' ><?=$v['name']; ?></option>
			<?		
				}	
			?>
		</select>
	</span>
</div>

<!--  年级 -->
<div class='content_per search_grade' style='<?=$search['grade']['show'] ? '' : 'display:none'; ?>;' search_group='<?=$search['group']; ?>'>
	<span class='column column_align'>年级</span>
	<span class='value'>
		<select class='input_select search_select select_grade' search_type='grade' search_group='<?=$search['group']; ?>'>
			<option value=0>------请选择------</option>
			<?
				foreach($search['grade']['data'] as $v){
			?>
			<option value='<?=$v['id'] ?>' section_id='<?=$v['section_id'] ?>' style='display:none;' ><?=$v['name']; ?></option>
			<?		
				}	
			?>
		</select>
	</span>
</div>

<!--  年份 -->
<div class='content_per search_year' style='<?=$search['year']['show'] ? '' : 'display:none'; ?>;' search_group='<?=$search['group']; ?>'>
	<span class='column column_align'>年份</span>
	<span class='value'>
		<select class='input_select search_select select_year' search_type='year' search_group='<?=$search['group']; ?>'>
			<option value=0>------请选择------</option>
			<?
				foreach($search['year']['data'] as $v){
			?>
			<option value='<?=$v['id'] ?>'><?=$v['name']; ?></option>
			<?		
				}	
			?>
		</select>
	</span>
</div>

<!--  地区 -->
<div class='content_per search_area' style='<?=$search['area']['show'] ? '' : 'display:none'; ?>;' search_group='<?=$search['group']; ?>'>
	<span class='column column_align'>地区</span>
	<span class='value'>
		<select class='input_select search_select select_area' search_type='area' search_group='<?=$search['group']; ?>'>
			<option value=0>------请选择------</option>
			<?
				foreach($search['area']['data'] as $v){
			?>
			<option value='<?=$v['id'] ?>'><?=$v['name']; ?></option>
			<?		
				}	
			?>
		</select>
	</span>
</div>

<!--  真题 -->
<div class='content_per search_zhenti_flag' style='<?=$search['zhenti_flag']['show'] ? '' : 'display:none'; ?>;' search_group='<?=$search['group']; ?>'>
	<span class='column column_align'>真题</span>
	<span class='value'>
		<select class='input_select search_select select_zhenti' search_type='zhenti' search_group='<?=$search['group']; ?>'>
			<option value=0>------请选择------</option>
			<option value='1'>是</option>
			<option value='2'>否</option>
		</select>
	</span>
</div>

<!--  出版社 -->
<div class='content_per search_publisher' style='<?=$search['publisher']['show'] ? '' : 'display:none'; ?>;' search_group='<?=$search['group']; ?>'>
	<span class='column column_align'>出版社</span>
	<span class='value'>
		<select class='input_select search_select select_publisher' search_type='publisher' search_group='<?=$search['group']; ?>'>
			<option value=0>------请选择------</option>
			<?
				foreach($search['publisher']['data'] as $v){
			?>
			<option value='<?=$v['id'] ?>' style='display:none;' ><?=$v['name']; ?></option>
			<?		
				}	
			?>
		</select>
	</span>
</div>

<!--  教材 -->
<div class='content_per search_book' style='<?=$search['book']['show'] ? '' : 'display:none'; ?>;' search_group='<?=$search['group']; ?>' size='10'>
	<span class='column column_align'>教材</span>
	<span class='value'>
		<select class='input_select search_select select_book' search_type='book' search_group='<?=$search['group']; ?>'>
			<option value=0>------请选择------</option>
			<?
				foreach($search['book']['data'] as $v){
			?>
			<option value='<?=$v['id'] ?>' subject_id='<?=intval($v['subject_id']); ?>' section_id='<?=intval($v['section_id']); ?>' grade_id='<?=intval($v['grade_id']); ?>' publisher_id='<?=intval($v['publisher_id']); ?>' style='display:none;'><?=$v['name']; ?></option>
			<?		
				}	
			?>
		</select>
	</span>
</div>

<!--  角色组 -->
<div class='content_per search_role' style='<?=$search['role']['show'] ? '' : 'display:none'; ?>;' search_group='<?=$search['group']; ?>'>
	<span class='column column_align'>角色组</span>
	<span class='value'>
		<select class='input_select search_select select_role' search_type='role' search_group='<?=$search['group']; ?>' refresh_next='no'>
			<option value=0>------请选择------</option>
			<?
				foreach($search['role']['data'] as $v){
			?>
			<option value='<?=$v['id'] ?>'><?=$v['name']; ?></option>
			<?		
				}	
			?>
		</select>
	</span>
</div>

<!--  工作组 -->
<div class='content_per search_workset' style='<?=$search['workset']['show'] ? '' : 'display:none'; ?>;' search_group='<?=$search['group']; ?>'>
	<span class='column column_align'>工作组</span>
	<span class='value'>
		<select class='input_select search_select select_workset' search_type='workset' search_group='<?=$search['group']; ?>' refresh_next='no'>
			<option value=0>------请选择------</option>
			<?
				foreach($search['workset']['data'] as $v){
			?>
			<option value='<?=$v['id'] ?>' ><?=$v['name']; ?></option>
			<?		
				}	
			?>
		</select>
	</span>
</div>

<div class='content_per search_gid' style='<?=$search['gid']['show'] ? '' : 'display:none'; ?>;' search_group='<?=$search['group']; ?>'>
	<span class='column column_align'>题目ID号</span>
	<span class='value'>
		<input type='text' class='input_text search_text select_gid' search_type='gid' search_group='<?=$search['group']; ?>' style='width:600px;'></input>
		<input type='button' class='input_btn search_btn select_gid_btn' search_type='gid' search_group='<?=$search['group']; ?>' value='搜索'></input>
	</span>
</div>

<!-- <div class='clear_float'></div> -->


<script type='text/javascript'>

if(!TJSearchBar){
	var TJSearchBar = {

			data : {
				'subject' : <?=json_encode($search['subject']['data']) ;?>,
				'section' : <?=json_encode($search['section']['data']) ;?>,
				'grade' : <?=json_encode($search['grade']['data']) ;?>,
				'publisher' : <?=json_encode($search['publisher']['data']) ;?>,
				'book' : <?=json_encode($search['book']['data']) ;?>,
			},

			showSwitch : {
				
			},
			
			render : function(group){
				for(var i in this.showSwitch[group]){
					if(this.showSwitch[group][i].show){
						$('.search_'+i+'[search_group="'+group+'"]').show();
						$('.select_'+i+'[search_group="'+group+'"]').val(this.showSwitch[group][i].value).trigger('change');
					}else{
						$('.search_'+i+'[search_group="'+group+'"]').hide();
					}
				}
			},

			allhide : function(group){
				for(var i in this.showSwitch[group]){
					this.showSwitch[group][i].show = false;
				}

				this.render(group);
			},

			allshow : function(group){
				for(var i in this.showSwitch[group]){
					this.showSwitch[group][i].show = true;
				}

				this.render(group);
			},

			hide : function(group , keyArray){
				for(var i = 0 ; i < keyArray.length ; i++){
					if(!this.showSwitch[group][keyArray[i]]){
						this.showSwitch[group][keyArray[i]] = {show : false};
					}
					this.showSwitch[group][keyArray[i]].show = false;
				}
				this.render(group);
			},

			show : function(group , keyArray){
				for(var i = 0 ; i < keyArray.length ; i++){
					if(!this.showSwitch[group][keyArray[i].key]){
						this.showSwitch[group][keyArray[i].key] = {show : false};
					}
					this.showSwitch[group][keyArray[i].key].show = true;
					this.showSwitch[group][keyArray[i].key].value = keyArray[i].value;
				}
				this.render(group);
			}
			
	};

	var e = new TJEvent.EventObject('TJSearchBar_ready');
	TJEvent.dispatch(e);

	
	$(document).delegate('.search_select' , 'change' ,function(){
	
		var type = $(this).attr('search_type');
		var group = $(this).attr('search_group');

		if(group){
			TJDataCenter.set(group+'_'+type , $(this).val());
		}else{
			TJDataCenter.set( type , $(this).val());
		}
		TJDataCenter.set('current_search_group' , group);

		if($(this).attr('refresh_next') != 'no'){
			//当前条件后的所有条件，重置为0
			$(this).closest('.content_per').closest('.content_per').next().find('.input_select').val(0).trigger('change');
		}
		
		var e = new TJEvent.EventObject(type+'_change');
		e.data.group = $(this).attr('search_group');
		
		e.data.value = $(this).val();
		TJEvent.dispatch(e);
	});

	$(document).delegate('.select_gid_btn' , 'click' , function(){

		var type = $(this).attr('search_type');
		var group = $(this).attr('search_group');

		if(group){
			TJDataCenter.set(group+'_'+type , $(this).prev('.select_gid').val());
		}else{
			TJDataCenter.set( type , $(this).prev('.select_gid').val());
		}


		TJDataCenter.set('current_search_group' , group);
		
		var e = new TJEvent.EventObject(type+'_change');
		e.data.group = $(this).attr('search_group');
		
		e.data.value = $(this).prev('.select_gid').val();
		
		TJEvent.dispatch(e);
		
	});
	
	
	TJEvent.addListener('subject_change' , function(e){
		var group = e.data.group;

		//如果存在分组，则更新相应分组里的
		if(group){
			var subject = TJDataCenter.get(group+'_subject');
		}else{//如果不存在分组，说明全局只有一个searchbar 直接更新
			var subject = TJDataCenter.get('subject');
		}
		
		//根据用户工作组权限，查询当前学科所允许访问的学段
		$('.select_section[search_group="'+group+'"] option[value!=0]').hide();
		var allowSection = $('.select_subject[search_group="'+group+'"] option:checked').attr('attr').split('_');
		for(var i = 0 ; i < allowSection.length ; i++){
			$('.select_section[search_group="'+group+'"] option[value='+allowSection[i]+']').show();
		}

	});
	
	//学段改变时，相应修改年级的值
	TJEvent.addListener('section_change' , function(e){
		var group = e.data.group;
		
		if(group){
			var subject = TJDataCenter.get(group+'_subject');
			var section = TJDataCenter.get(group+'_section');
		}else{
			var subject = TJDataCenter.get('subject');
			var section = TJDataCenter.get('section');
		}
		
		$('.select_grade[search_group="'+group+'"] option[value!=0]').hide();
		$('.select_grade[search_group="'+group+'"] option[section_id='+section+']').show();

		$('.select_publisher[search_group="'+group+'"] option[value!=0]').remove();
		
		var publisherArr = [];
		for(var i = 0 ; i < TJSearchBar.data.book.length ; i++){
			if(TJSearchBar.data.book[i].subject_id == subject && TJSearchBar.data.book[i].section_id == section){
				publisherArr.push(TJSearchBar.data.book[i].publisher_id);
			}
		}

		for(var i = 0 ; i < TJSearchBar.data.publisher.length ; i++){
			if(publisherArr.indexOf(TJSearchBar.data.publisher[i].id) != -1){
				$('.select_publisher[search_group="'+group+'"]').append('<option value="'+TJSearchBar.data.publisher[i].id+'">'+TJSearchBar.data.publisher[i].name+'</option>');
			}
		}
		
	});
	
	
	TJEvent.addListener('grade_change' , function(e){
		var group = e.data.group;

		if(group){
			var subject = TJDataCenter.get(group+'_subject');
			var grade = TJDataCenter.get(group+'_grade');
		}else{
			var subject = TJDataCenter.get('subject');
			var grade = TJDataCenter.get('grade');
		}
		
		//对教材做过滤
// 		$('.select_book[search_group="'+group+'"] option').hide();

		$('.select_publisher[search_group="'+group+'"] option[value!=0]').remove();

		var publisherArr = [];
		for(var i = 0 ; i < TJSearchBar.data.book.length ; i++){
			if(TJSearchBar.data.book[i].subject_id == subject && TJSearchBar.data.book[i].grade_id == grade){
				publisherArr.push(TJSearchBar.data.book[i].publisher_id);
			}
		}

		for(var i = 0 ; i < TJSearchBar.data.publisher.length ; i++){
			if(publisherArr.indexOf(TJSearchBar.data.publisher[i].id) != -1){
				$('.select_publisher[search_group="'+group+'"]').append('<option value="'+TJSearchBar.data.publisher[i].id+'">'+TJSearchBar.data.publisher[i].name+'</option>');
			}
		}
		
// 		$('.select_book[search_group="'+group+'"] option[subject_id='+subject+'][grade_id='+grade+']').each(function(){
// 			$('.select_publisher[search_group="'+group+'"] option[value='+$(this).attr('publisher_id')+']').show();
// 		});
	});
	
	TJEvent.addListener('publisher_change' , function(e){
		var group = e.data.group;

		if(group){
			var subject = TJDataCenter.get(group+'_subject');
			var section = TJDataCenter.get(group+'_section');
			var grade = TJDataCenter.get(group+'_grade');
			var publisher = TJDataCenter.get(group+'_publisher');
		}else{
			var subject = TJDataCenter.get('subject');
			var section = TJDataCenter.get('section');
			var grade = TJDataCenter.get('grade');
			var publisher = TJDataCenter.get('publisher');
		}
		
		$('.select_book[search_group="'+group+'"] option[value!=0]').remove();
		
		for(var i = 0 ; i < TJSearchBar.data.book.length ; i++){
			if(TJSearchBar.data.book[i].subject_id == subject && 
					TJSearchBar.data.book[i].section_id == section && 
					(grade == 0 ? true : TJSearchBar.data.book[i].grade_id == grade) && 
					TJSearchBar.data.book[i].publisher_id == publisher){
				
				$('.select_book[search_group="'+group+'"]').append('<option value="'+TJSearchBar.data.book[i].id+'">'+TJSearchBar.data.book[i].name+'</option>');
			
			}
		}
	});
	
}

TJSearchBar.showSwitch['<?=$search['group'] ?>'] = {
	<?
	foreach($search as $v=>$k){
		if($v == 'group'){
			continue;
		}
	 	echo $v.' : {"show" : '.json_encode($k['show']).'} ,';
	}
	?>
};


</script>