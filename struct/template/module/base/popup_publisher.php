<!-- 新增出版社弹出面板 -->
<style type='text/css'>
.add_publisher_panel{
	width:204px;
	height:104px;
	left:480px;
	top:280px;
}
</style>

<div class='popup_panel add_publisher_panel' style='display:none;'>
	<div class='popup_head'>
		<div class='popup_title'>新增出版社</div>
		<div class='popup_close'></div>
	</div>
	<div class='popup_content' style='overflow:hidden;'>
		<div class="content_per">
			<span class="column column_align">*名称</span>
			<span class="value">
				<input type='text' class='input_text publisher_name'></input>
			</span>
		</div>
		<div class='confirm_panel'>
			<input type='button' class='input_btn add_publisher_cancel' value='取消' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<input type='button' class='input_btn add_publisher_submit' value='确定' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<div class='clear_float'></div>
		</div>
	</div>
	<div class='popup_panel_shadow'></div>
</div>
<script type='text/javascript'>

TJEvent.addListener('add_publisher_show' , function(){
	$('.add_publisher_panel').show();
});

TJEvent.addListener('add_publisher_success' , function(){
	$('.add_publisher_panel , .publisher_name').val('');
	$('.add_publisher_panel').hide();
});


$('.add_publisher_cancel').click(function(){
	$('.add_publisher_panel , .publisher_name').val('');
	$('.add_publisher_panel').hide();
});

$('.add_publisher_submit').click(function(){

	var publisher_name = $.trim($('.add_publisher_panel .publisher_name').val());


	if(!publisher_name){
		alert('请填写出版社名称');
		return;
	}
	
	var e = new TJEvent.EventObject('add_publisher_submit');
	e.data.publisher_name = publisher_name;
	TJEvent.dispatch(e);
});

</script>

<!-- 新增教材弹出面板 -->

<style type='text/css'>
.add_book_panel{
	width:204px;
	height:140px;
	left:754px;
	top:326px;
}
</style>

<div class='popup_panel add_book_panel' style='display:none;'>
	<div class='popup_head'>
		<div class='popup_title'>新增教材</div>
		<div class='popup_close'></div>
	</div>
	<div class='popup_content' style='overflow:hidden;'>
		<div class="content_per">
			<span class="column column_align">*名称</span>
			<span class="value">
				<input type='text' class='input_text book_name'></input>
			</span>
		</div>
		<div class="content_per">
			<span class="column column_align">*年级</span>
			<span class="value">
				<select class="input_select book_grade" >
					<option value="0" >------请选择------</option>
					<? foreach($grade as $g){
						echo '<option value="'.$g['id'].'">'.$g['name'].'</option>';
					}?>
				</select>
			</span>
		</div>
		<div class='confirm_panel'>
			<input type='button' class='input_btn add_book_cancel' value='取消' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<input type='button' class='input_btn add_book_submit' value='确定' style='float:right;margin-right:10px;padding:5px 10px;'></input>
			<div class='clear_float'></div>
		</div>
	</div>
	<div class='popup_panel_shadow'></div>
</div>
<script type='text/javascript'>

TJEvent.addListener('add_book_show' , function(){
	$('.add_book_panel').show();
});

TJEvent.addListener('add_book_success' , function(){
	$('.add_book_panel , .book_name').val('');
	$('.add_book_panel').hide();
});


$('.add_publisher_cancel').click(function(){
	$('.add_book_panel , .book_name').val('');
	$('.add_book_panel').hide();
});

$('.add_book_submit').click(function(){

	var book_name = $.trim($('.add_book_panel .book_name').val());
	var book_grade = parseInt($('.add_book_panel .book_grade').val());

	if(!book_name){
		alert('请填写教材名称');
		return;
	}

	if(!book_grade){
		alert('请选择年级');
		return;
	}
	
	var e = new TJEvent.EventObject('add_book_submit');
	e.data.book_name = book_name;
	e.data.book_grade = book_grade;
	TJEvent.dispatch(e);
});

</script>




<script type='text/javascript'>

$('.popup_panel .popup_close').click(function(){
	$(this).closest('.popup_panel').hide();
});

$( ".popup_panel" ).draggable({ handle: ".popup_head" });
</script>
