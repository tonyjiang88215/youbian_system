if(!TJTree){
	
	var TJTree = {
		webroot : '',
		flag : false,
		treeRender : function(rootElement , flag){
			//设置是否默认展开
			this.flag = !!flag;
			
			if (rootElement.length == 0) {
				var resultContent = '<div class="tree_nonedata">暂无数据</div>';
				return resultContent;
			}
			else {
				var resultContent = this.elementTreeRender(rootElement);
				
				var tempHandler = document.createElement('ul');
				tempHandler.setAttribute('class' , 'treeNav');
				tempHandler.id = 'treeNav';
				
		//		resultContent += '<input id="tree_selected" class="tree_selected" type="button" value="已选择" disabled=true />';
				
				tempHandler.innerHTML = resultContent;
				var ulListsObject = tempHandler.getElementsByTagName('ul');
				var ulLists = [tempHandler];
				for(var i in ulListsObject){
					if(typeof ulListsObject[i] == 'number' || typeof ulListsObject[i] == 'function'){
						continue;
					}
					ulLists.push(ulListsObject[i]);
				}
				ulListsObject = false;
				for(var i=0;i<ulLists.length;i++){//遍历所有ul
					if(ulLists[i].parentNode && !ulLists[i].parentNode.nextSibling){
						ulLists[i].style.background = 'none';
					}
					
					if(ulLists[i].childNodes.length == 0){
						continue;
					}
					
					
					for(var j=ulLists[i].childNodes.length -1;j>-1;j--){//在ul的子节点中，从后往前寻找li，修改最后一个li的img图片
						if(ulLists[i].childNodes[j].tagName.toLowerCase()=='li' && ulLists[i].childNodes[j].className != 'child_li'){
							var img = ulLists[i].childNodes[j].childNodes[0].childNodes[0];
							if(ulLists[i].childNodes[j].className=='link'){
								img.setAttribute('src',this.webroot+'/manage_system/pic/tree_nav/tree_linebottom.gif');
							}else{
								img.setAttribute('src',this.webroot+'/manage_system/pic/tree_nav/tree_plusbottom.gif');
							}
							break;
						}
					}
				}
				ulLists.length = 0;
		//		console.log(tempHandler.childNodes[1].childNodes[0]);
		//		tempHandler.childNodes[1].childNodes[0].style.background = 'url("")';
				return tempHandler;
			}
	
		},
		
		elementTreeRender : function(treeElement){
			var resultContent = "";
			
			for(var i = 0 ; i < treeElement.length ; i++){
				
				var hasChild = false;
				var liClass = '';
				var pic1 = '';
				var pic2 = '';
		//		for(var i in treeElement.children){
		//			if(treeElement.children[i].sortid){
		//				hasChild = true;
		//				break;
		//			}
		//		}
		//		if(!hasChild){
				if(treeElement[i].children && treeElement[i].children.length == 0){
					liClass = 'link';
					pic1 = 'tree_linemiddle.gif';
					pic2 = 'tree_file.gif';
				}else{
					liClass = 'parent';
					pic1 = 'tree_minusmiddle.gif';
					pic2 = 'tree_folderopen.gif';
				}
				
				var attrStr = '';
				
				if(treeElement[i].attributes){
					for(var k in treeElement[i].attributes){
						attrStr += k+'="'+treeElement[i].attributes[k]+'" ';
					}
				}
				
				// resultContent += '<li class="'+liClass+'" typeid="'+treeElement.typeid+'" sortid="'+treeElement.sortid+'"  '+(Config.loadMode==Const.LOAD_MODE.WEB?'wtypeid="'+treeElement.wtypeid+'"':'')+' >';
				resultContent += '<li class="'+liClass+'" elementid="'+treeElement[i].id+'" >';
				resultContent += '<span class="toggle_div">';
				resultContent += '<img class="tree_line" src="'+this.webroot+'/manage_system/pic/tree_nav/'+pic1+'"></img><img class="tree_folder" src="'+this.webroot+'/manage_system/pic/tree_nav/'+pic2+'"></img>';
				resultContent += '</span>';
				// resultContent += '<a href="javascript:void(0);" typeid="'+treeElement.typeid+'" sortid="'+treeElement.sortid+'"  '+(Config.loadMode==Const.LOAD_MODE.WEB?'wtypeid="'+treeElement.wtypeid+'"':'')+'  >'+treeElement.name+'</a>';
				resultContent += '<a href="javascript:void(0);" elementid="'+treeElement[i].id+'" '+attrStr+' title="'+treeElement[i].name+'" >'+treeElement[i].name+'</a>';
				resultContent +='</li>';
				resultContent +='<li class="child_li" parentid="'+treeElement[i].id+'" >';
				resultContent +='<ul class="child_ul" parentid="'+treeElement[i].id+'">';
	//			for(var element in treeElement.children){
	//				var ele = treeElement.children[element];
				resultContent += this.elementTreeRender(treeElement[i].children);
	//			}
				resultContent +='</ul parentid="'+treeElement.sortid+'" >';
				resultContent += '</li>';
				delete liClass;
				delete pic1;
				delete pic2;
			}
			
			return resultContent;		
		},
	
		treeEventBind : function(){
			var _this = this;
			$(document).delegate('#treeNav li:not([class*="link"])[class!="child_li"] .toggle_div','click',function(){
				$(this).children('img:eq(0)').attr('src', _this.webroot+'/manage_system/pic/tree_nav/tree_' + (!this.unopen ? 'plus' : 'minus') + ($(this).parent().next().is(':last-child')? 'bottom' : 'middle') + '.gif');
				$(this).children('img:eq(1)').attr('src', _this.webroot+'/manage_system/pic/tree_nav/tree_folder' + (!this.unopen ? '' : 'open') + '.gif');
				$(this).parent().attr('open' , !this.unopen ? 'parent' : 'open');
				$(this).parent().next().css('display' , !this.unopen ? 'none' : 'block');
				this.unopen = !this.unopen;
				if(document.all){
					$('#treeNav').hide().show();
				}
			});
			
			$(document).delegate('#treeNav a','click',function(){
				
				$(this).closest('#treeNavDIV').find('.tree_select').removeClass('tree_select');
				$(this).closest('li').addClass('tree_select');
				
			});
			
		},
		
		checkTail : function(){
			return $('.tree_select').next().find('.child_ul').children().length == 0 ;
		},
		
		checkFirst : function(){
			return $('.tree_select').is(':first-child');
		},
		
		checkLast : function(){
			return $('.tree_select').next().is(':last-child');
		}
			
	};
	
	
	
	TJTree.draggable = {
		
		switcher : false,
		
		eventBind : function(){
			$('#treeNavDIV li[elementid]').draggable({
	//			$(this).closest('li').prev().andSelf().draggable({
					addClasses : false , 
	//				handle : 'li[elementid]' , 
	//				helper:function(){
	//					var container = $('<div class="image-group"/>');
	//			        container.append($(this).next().andSelf().clone());
	////			        console.log('container', container);
	//			        return container;
	//				} , 
					helper : 'clone',
					delay : 500,
					opacity:0.35 , 
					containment: '#treeNavDIV' ,  
					cursor:'pointer' , 
					start : function(){
						$(this).css('opacity','0.7');
					},
					stop : function(){
						$(this).css('opacity','');
					}
	//				scope : i,
	//				stack : 'a'
	//			});
			});
			
			$('#treeNavDIV li[elementid]').droppable({
				addClasses : false,
				accept : 'li',
				over : function(e , ui){
					$(this).addClass('ui-state-highlight');
					$(this).next().children('.child_ul').append(ui.draggable.clone());
					
				},
				out : function(e , ui){
					$(this).removeClass('ui-state-highlight');
					$(this).next().children('.child_ul').children(':last').remove();
				},
				drop : function(e , ui){
					$(this).removeClass('ui-state-highlight');
					$(this).next().children('.child_ul').children(':last').remove();
					
					var e = new TJEvent.EventObject('drop_tree_element');
					e.data.object = ui.draggable[0];
					e.data.target = this;
					TJEvent.dispatch(e);
				}
			});
			
		},
		
		on : function(){
			this.switcher = true;
		},
		
		off : function(){
			this.switcher = false;
		},
		
		calculateTreeData : function(){
			
		}
		
	};
	
	var e = new TJEvent.EventObject('TJTreeReady');
	TJEvent.dispatch(e);
	
}

