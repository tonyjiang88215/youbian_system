<?php
class tree_handler{
	private  $rootInfo = array();
	//需要被生成的树
//	private $tree = false;
	private $data = array();
	
	/**
	 * 构造函数，完成整棵树的初始化，获取根节点信息，查询所有后代节点信息，依次添加，组成树形结构
	 * @param $sortid
	 * @param $model  生成树的模式:view(default)-查看模式，给普通用户提供导航 ; manage-管理模式，给管理员提供管理结构)
	 * @return unknown_type
	 */
	public function __construct($data = null){
		
		$this->data = $data;
		
		//获取根节点的信息，保存在$rootInfo数组中
		
		//实例化树对象，生成根节点
		//echo $this->tree->getName();
		//获取子节点信息,进行排序,然后添加到根节点中,组成树结构
//		$sons = $this->getSonsElements();
	}
	
	/**
	 * 
	 * @param $data [obj : {info : object , children : array ()}]
	 * @return unknown_type
	 */
	public function setData($data){
		$this->data = $data;
	}
	
	/**
	 * @return the $tree
	 */
	public function getData() {
		return $this->data;
	}
	
	/**
	 * 获取当前节点的HTML内容
	 * @return String
	 */
	public function getTreeRenderHTML(){
		/*
		$cssCode = <<<EOT
<style type='text/css'>
	#treeNavDIV{position:relative;margin-bottom:5px;}

	#treeNav *{margin:0;padding-top:0;position:relative;}
		
	#treeNav,#treeNav  ul,#mousefollower ul {padding: 0px;margin:0;list-style: none; font:12px/1.5 Arial,"宋体",sans-serif;_margin-top:-16px;}
	
	#treeNav{_margin-top:6px;}
	
	#treeNav li , #mousefollower li {list-style: none;white-space: nowrap;
													  text-overflow: ellipsis;min-width:100px;height:18px;font:12px/1.5 Arial,"宋体",sans-serif;_margin-top:-6px;}

	#treeNav .link,#treeNav .parent,#treeNav .open{}
	
	#treeNav li img{width:18px;height:18px;}
	
	#treeNav a,#mousefollower a {text-decoration:none;color:#004276;padding:4px;top:-4px;}
	
	#treeNav .child_li{height:auto;display:none;}
	
	#treeNav .child_ul{background:url("/manage_system/pic/tree_nav/tree_line.gif") repeat-y scroll 0px 1px transparent;padding-left:18px;}
	
	#treeNav .toggle_div{}
	
	.tree_selected{border: 1px solid #B9B9B9;position:relative;font-size: 10px; line-height:10px;
								 width: 49px; height: 16px; padding: 0; left: 4px; display:none;background-color: #F0FFE5;cursor:default;}
	
	.treeNav li ul.show {display: block;}
</style>
EOT;
		$javascriptCode = <<<EOT
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
			this.appendChild(document.getElementById('tree_selected'));
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
EOT;
*/
		$html = $this->rootTreeRender();
//		$resultHTML = $cssCode . $html . $javascriptCode;
		$resultHTML = $html;
		return $resultHTML;
	}
	
	/**
	 * 根节点渲染方法
	 * @return string
	 */
	private function rootTreeRender(){
		$resultHTML ='<div id="treeNavDIV">';
		$resultHTML .= '<ul id="treeNav" class="treeNav" >';
		$resultHTML .= $this->elementTreeRender($this->data);
		$resultHTML .= '</ul>';
//		$resultHTML .= $this->elementTreeRender($this->tree);
		$resultHTML .= '<input id="tree_selected" class="tree_selected" type="button" value="已选择" disabled=true />';
		$resultHTML .= '</div>';
		return $resultHTML;
	}
	
	private function elementTreeRender($dataArray){
		foreach($dataArray as $k => $data){
			if(count($data['children'])==0){
				$diffArray = array(
											'imgbottom'	=>		'tree_linebottom.gif',
											'imgmiddle'	=>		'tree_linemiddle.gif',
											'imgnormal'	=>		'tree_file.gif'
										);
			}else{
				$diffArray = array(
											'imgbottom'	=>		'tree_plusbottom.gif',
											'imgmiddle'	=>		'tree_plusmiddle.gif',
											'imgnormal'	=>		'tree_folder.gif'
										);
			}
			$resutHTML = '';
			$resultHTML .= '<li class="parent" elementid="'.$data['id'].'" >';
			$resultHTML .= '<span class="toggle_div" >';
			
			if($k >= count($dataArray) - 1){
				$resultHTML .= '<img class="tree_line" src="/manage_system/pic/tree_nav/'.$diffArray['imgbottom'].'" ></img>';
			}else{
				$resultHTML .= '<img class="tree_line" src="/manage_system/pic/tree_nav/'.$diffArray['imgmiddle'].'" ></img>';
			}
			$resultHTML .= '<img class="tree_folder" src="/manage_system/pic/tree_nav/'.$diffArray['imgnormal'].'"></img>';
			$resultHTML .= '</span>';
			$resultHTML .= '<a class="nav_label" href="javascript:void(0);" elementid="'.$data['id'].'" >'.$data['name'].'</a>';
			$resultHTML .= '</li>';
			$resultHTML .= '<li parentid="'.$data['id'].'" class="child_li">';
			$resultHTML .= '<ul parentid="'.$data['id'].'" class="child_ul">';
			$resultHTML .= $this->elementTreeRender($data['children']);
			$resultHTML .= '</ul parentid="'.$data['id'].'">';
			$resultHTML .= '</li>';
		}
		return $resultHTML;
	}
	
	
	
}