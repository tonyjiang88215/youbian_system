
<style type='text/css'>
	#treeNavDIV{position:relative;margin-bottom:5px;overflow-y:hidden;overflow-x:auto;}

	#treeNav *{margin:0;padding-top:0;position:relative;}
		
	#treeNav,#treeNav  ul,#mousefollower ul {padding: 0px;margin:0;list-style: none; font:12px/1.5 Arial,"宋体",sans-serif;_margin-top:-16px;}
	
	#treeNav{_margin-top:6px;}
	
	#treeNav li , #mousefollower li {list-style: none;white-space: nowrap;
													  text-overflow: ellipsis;min-width:100px;height:18px;font:12px/1.5 Arial,"宋体",sans-serif;_margin-top:-6px;padding:0px 6px;}

	#treeNav .link,#treeNav .parent,#treeNav .open{}
	
	#treeNav li img{width:18px;height:18px;}
	
	#treeNav a,#mousefollower a {text-decoration:none;color:#004276;padding:2px;margin:2px;top:-4px;}
	
	#treeNav .child_li{height:auto;}
	
	#treeNav .child_ul{background:url("/manage_system/pic/tree_nav/tree_line.gif") repeat-y scroll 0px 0px transparent;padding-left:18px;}
	
	#treeNav .toggle_div{}
	
	.tree_selected{border: 1px solid #B9B9B9;position:relative;font-size: 10px; line-height:10px;
								 width: 49px; height: 16px; padding: 0; left: 4px; display:none;background-color: #F0FFE5;cursor:default;}
	
	 .tree_select a{
	 	border:1px solid #999;
	 	background : #dfe8f3;
	 }
								 
								 
	.treeNav li ul.show {display: block;}
	
	.tree_drag_clone{position:absolute;}
	 
	 #treeNavDIV .tree_nonedata{
	 	color:#888;
	 	padding:5px;
	 	cursor:default;
	 }
	
</style>
<?php 
if($type == 'php'){
?>

<?=$treeHTML; ?>

<script type='text/javascript'>
	function treeEventBind(){
		document.getElementById('tree_selected').onclick = function(){
		return false;
	};
	
	if (!document.getElementsByClassName) {
		document.getElementsByClassName = function(){
			var tree = document.getElementById('treeNav');
			if(tree.hasChildNodes && arguments[0]){
			var data = new Array();
			var resultList = tree.getElementsByTagName("*");
			for(a=0;a<resultList.length;a++){
					if(resultList[a].className == arguments[0]){
					data.push(resultList[a]);
					}
				}
				return data;
			}
		}
	}
	var parentLi = document.getElementsByClassName('parent');
	for (var i = 0; i < parentLi.length; i++) {
		var toggleDiv = parentLi[i].childNodes[parentLi[i].childNodes.length - 2];
		toggleDiv.onclick = function(){
			if(this.parentNode.nextSibling.childNodes[0].childNodes.length == 0){
				return;
			}
			this.getElementsByTagName('img')[0].setAttribute('src', '/manage_system/pic/tree_nav/tree_' + (this.open ? 'plus' : 'minus') + (this.parentNode.nextSibling.nextSibling ? 'middle' : 'bottom') + '.gif');
			this.getElementsByTagName('img')[1].setAttribute('src', '/manage_system/pic/tree_nav/tree_folder' + (this.open ? '' : 'open') + '.gif');
			this.parentNode.className = this.open ? 'parent' : 'open';
			this.parentNode.nextSibling.style.display = this.open ? 'none' : 'block';
			this.open = !this.open;
			if(document.all){
				document.getElementById('treeNav').style.display = 'none';
				document.getElementById('treeNav').style.display = 'block';
			}
		}
	}
	var openLi = document.getElementsByClassName('open');
	for (var i = 0; i < openLi.length; i++) {
		var toggleDiv = openLi[i].childNodes[openLi[i].childNodes.length - 2];
		toggleDiv.onclick = function(){
			if(this.parentNode.nextSibling.childNodes[0].childNodes.length == 0){
				return;
			}
			this.getElementsByTagName('img')[0].setAttribute('src', '/manage_system/pic/tree_nav/tree_' + (this.unopen ? 'minus' : 'plus') + (this.parentNode.nextSibling.nextSibling ? 'middle' : 'bottom') + '.gif');
			this.getElementsByTagName('img')[1].setAttribute('src', '/manage_system/pic/tree_nav/tree_folder' + (this.unopen ? 'open' : '') + '.gif');
			this.parentNode.className = this.unopen ? 'open' : 'parent';
			this.parentNode.nextSibling.style.display = this.unopen ? 'block' : 'none';
			this.unopen = !this.unopen;
			if(document.all){
				document.getElementById('treeNav').style.display = 'none';
				document.getElementById('treeNav').style.display = 'block';
			}
		}
	}
	
	var aLink = document.getElementById('treeNav').getElementsByTagName('a');
	for(var i = 0 ; i < aLink.length ; i ++){
		aLink[i].onclick = function(){
			document.getElementById('tree_selected').style.display = 'inline-block';
//			this.appendChild(document.getElementById('tree_selected'));
		}
	}
	
	var ulLists = document.getElementById('treeNavDIV').getElementsByTagName('ul');
	for (var i = 0; i < ulLists.length; i++) {
		var ul = ulLists[i];
		if(ul.childNodes.length == 0){
			continue;
		}
		var className = ul.childNodes[ul.childNodes.length - 1].className;
		if (className && className == 'child_li') {
			ul.childNodes[ul.childNodes.length - 1].childNodes[0].style.background = 'url()';
		}
	}
	
}



function showTreeElementFromTree(sortid){
	var lis = document.getElementsByClassName('open');
	for(var i = lis.length -1 ; i > -1 ; i--){
		lis[i].childNodes[0].onclick && lis[i].childNodes[0].onclick();
	}
	document.getElementById('treeNav').childNodes[0].childNodes[0].onclick();
	document.getElementById('tree_selected').style.display='none';
	document.getElementById('treeNavDIV').appendChild(document.getElementById('tree_selected'));
	if(!sortid){
		return;
	}
	sortid = sortid.toString();
	var root = document.getElementById('treeNav');
	rootid = root.getAttribute('rootid').toString();
	var tempid = rootid;
	var tempElement = root;
	for(var i = rootid.length ; i < sortid.length  ; i++ ){
		for(var j = 0 ; j < tempElement.childNodes.length ; j++){
			if(tempElement.childNodes[j].className.toLowerCase()=='child_li' && tempElement.childNodes[j].getAttribute('parentid')==tempid){
				if(i != rootid.length && tempElement.childNodes[j-1].className.toLowerCase() != 'open' ){
					tempElement.childNodes[j-1].getElementsByTagName('span')[0].onclick();
				}
				tempElement = tempElement.childNodes[j].childNodes[0];
				break;
			}
		}
		tempid = [tempid , sortid.substr(i,1)].join('');
	}
	for(var i = 0 ; i < tempElement.childNodes.length ; i++){
		if(tempElement.childNodes[i].getAttribute('sortid') == sortid){
			document.getElementById('tree_selected').style.display = 'inline-block';
			tempElement.childNodes[i].getElementsByTagName('a')[0].appendChild(document.getElementById('tree_selected'));
			break;
		}
	}
}
treeEventBind();
if(document.getElementById('treeNav').childNodes.length > 1){
	var rootShow = document.getElementById('treeNav').childNodes[0].childNodes[0];
	rootShow.onclick && rootShow.onclick();
}
</script>

<?php 	
}else if($type == 'js'){
?>
<div id="treeNavDIV"  class='<?=$treeClass; ?>' group='<?=$treeGroup; ?>'></div>

<script type='text/javascript' src='/manage_system/js/tree.js'></script>
<script type='text/javascript'>
var rootElement = [];
$('.<?=$treeClass; ?>').append(TJTree.treeRender(rootElement));
TJTree.treeEventBind();
</script>
<script type='text/javascript'>
if(treeInterval === undefined){
	
	var treeInterval = 0;
	
	TJEvent.addListener('refresh_tree' , function(e){
		
		TJDataCenter.set('selected_tree_element' , false);
		TJDataCenter.set('dbclick_tree_element' , false);
		
		$(e.data.classSelector).html('').append(TJTree.treeRender(e.data.treeData , e.data.flag)).append('<div class="tree_drag_clone"></div>');
	
	// 	setTimeout(function(){
		TJTree.draggable.eventBind();
	// 	},1);
		
		var ev = new TJEvent.EventObject('refresh_tree_success');
		TJEvent.dispatch(ev);
		
		//如果是展开，则触发所有展开按钮(现在已经默认展开)
// 		if(TJTree.flag){
// 	// 		$('#treeNav .toggle_div').trigger('click');
// 			//兼容IE，防止浏览器卡死，分批处理进行展开
// 			var tmp = $('#treeNav .toggle_div');
// 			var i = 0;
// 			clearInterval(treeInterval);
// 			treeInterval = setInterval(function(){
// 				for(var k = 0 ; k < 10 ; k ++){
// 					tmp.eq(i++).trigger('click');
// 				}
// 			},1);
// 		}
		
	});
	
	$(document).delegate('#treeNavDIV li a' , 'click' , function(){
	
		var group = $(this).closest('#treeNavDIV').attr('group');
		if(group){
			TJDataCenter.set(group+'_selected_tree_element' , $(this));
		}else{
			TJDataCenter.set('selected_tree_element' , $(this));
		}
		
		var e = new TJEvent.EventObject('tree_element_selected');
		e.data.id = $(this).attr('elementid');
		e.data.group = group;
		TJEvent.dispatch(e);
	});
	
	$(document).delegate('#treeNavDIV li a' , 'dblclick' , function(){	

		var group = $(this).closest('#treeNavDIV').attr('group');
		if(group){
			TJDataCenter.set(group+'_dbclick_tree_element' , $(this));
		}else{
			TJDataCenter.set('dbclick_tree_element' , $(this));
		}
		
		var e = new TJEvent.EventObject('tree_element_dbclick');
		e.data.id = $(this).attr('elementid');
		e.data.htmlObject = this;
		e.data.group = group;
		TJEvent.dispatch(e);
		
	});
}

</script>
<?php 	
}
?>

