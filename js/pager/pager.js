/**
 * JS分页
 * 
 * author：TonyJiang
 * 
 */
(function(){
    window.Pager = function(){
    
        var _this = this;
        
        this.linkMax = 2;
		
		this.label = {
			'firstPage' : '第一页',
			'prevPage' : '上一页',
			'nextPage' : '下一页',
			'lastPage' : '最后一页'
		},
		
		this.stepOption = [ 10 , 20 , 40 , 60 , 80 , 100 ];
        
        this.style = {
            'default': '/manage_system/js/pager/default.css'
        };
		
		this.setting = {};
        
        
        this.paramName = 'offset';
        this.changeListener = false;
        
        //设置参数名称
        this.setParamName = function(name){
            this.paramName = name;
        };
        
        //获取分页个数
        this.getPageCount = function(){
            return Math.ceil(this.totalCount / this.step);
        }
        
        this.getPrevOffset = function(){
            var prevOffset = this.offset - this.step;
            return prevOffset >= 0 ? prevOffset : false;
        }
        
        this.getNextOffset = function(){
            var nextOffset = this.offset + this.step;
            return nextOffset < this.totalCount ? nextOffset : false;
        }
        
        this.getFirstOffset = function(){
            return 0;
        }
        
        this.getLastOffset = function(){
            return (this.getPageCount() - 1) * this.step;
        }
        
        this.getOffsetList = function(){
            var offsetList = [];
            var currentOffset = 0;
            for (var i = 0; i < this.getPageCount(); i++) {
                offsetList.push(currentOffset);
                currentOffset = currentOffset + this.step;
            }
            return offsetList;
        }
		
		this.setOffset = function(offset , flag){
			this.offset = offset;
			$('.pager_container').replaceWith(_this.showHTML(_this.totalCount, 0, _this.step));
            _this.bindEvent();
			if (flag) {
				try {
					_this.changeListener(_this.offset, _this.step);
				} 
				catch (e) {
				}
			}
			
		},
        
        this.setStep = function(step , flag){
        	this.step = step;
        	$('.pager_container').replaceWith(_this.showHTML(_this.totalCount, 0, _this.step));
            _this.bindEvent();
			if(flag){
	            try {
	                _this.changeListener(_this.offset, _this.step);
	            } 
	            catch (e) {
	            }
			}
        }	
        
        this.setTotalCount = function(total){
        	this.totalCount = total;
        	$('.pager_container').replaceWith(_this.showHTML(_this.totalCount, _this.offset, _this.step));
            _this.bindEvent();
        }
        
        this.showHTML = function(totalCount, offset, step){
            this.totalCount = totalCount;
            this.offset = offset;
            this.step = step;
            
            var startPage = this.getFirstOffset();
            var prevPage = this.getPrevOffset();
            var pageList = this.getOffsetList();
            var nextPage = this.getNextOffset();
            var endPage = this.getLastOffset();
            
            var html = '<div class="pager_container paginator" >';
            
			html += '<span class="pager_totalcount_show">总数&nbsp;'+this.totalCount+'&nbsp;条</span>';
			
            html += '<span class="pager_step_set">每页&nbsp;';
            html += '<select class="pager_step_select">';
            
            for(var i = 0 ; i < this.stepOption.length ; i++){
            	html += '<option value="'+this.stepOption[i]+'" '+(this.stepOption[i]==this.step ? 'selected="selected"':'')+'  >'+this.stepOption[i]+'</option>';
            }
            html += '</select>';
			
			html += '<span class="pager_jump_label">跳转至</span><input type="text" class="pager_jump"></input>';
			
            html += '</span>';
            
            html += '<span class="">';
            
            html += '<a class="pager_first tn-page-prev tn-page-thumb" href="javascript:void(0);" offset=' + startPage + ' >' + this.label.firstPage + '</a>&nbsp;';
            html += '<a class="pager_prev tn-page-prev tn-page-thumb" href="javascript:void(0);" offset=' + prevPage + ' >' + this.label.prevPage + '</a>';
            
            html += '</span>';
            
            html += '<span>';
            
            var currentPage = parseInt(this.offset / this.step);
            var pageCount = this.getPageCount();
            
            var firstLink = currentPage > this.linkMax ? currentPage - this.linkMax : 0;
            var lastLink = currentPage + this.linkMax + 1 < pageCount ? currentPage + this.linkMax + 1 : pageCount;
            
            if (firstLink > 0) {
                html += '<a class="tn-page-number" href="javascript:void(0);" offset=' + pageList[0] + ' >' + (0 + 1) + '</a>';
                if (firstLink > 1) {
                    html += '<a>...</a>';
                }
            }
            
            if (pageCount > 1) {
                for (var link = firstLink; link < lastLink; link++) {
                    if (currentPage == link) {
                        html += '<a class="pager_current" " href="javascript:void(0);" offset=' + pageList[link] + ' ><span class="tn-page-number tn-selected">' + (link + 1) + '</span></a>';
                    }
                    else {
                        html += '<a class="pager_page tn-page-number" href="javascript:void(0);" offset=' + pageList[link] + ' >' + (link + 1) + '</a>';
                    }
                }
            }
            
            if (lastLink < pageCount) {
                if (lastLink + 1 < pageCount) {
                    html += '<a>...</a>';
                }
                html += '<a class="pager_page tn-page-number"  href="javascript:void(0);" offset=' + pageList[pageCount - 1] + ' >' + (pageCount) + '</a>';
            }
            html += '</span>';
            
            html += '<span class="">';
            
            html += '<a class="pager_next tn-page-thumb tn-page-next" href="javascript:void(0);" offset=' + nextPage + ' >' + this.label.nextPage + '</a>&nbsp;';
            html += '<a class="pager_last tn-page-thumb tn-page-next" href="javascript:void(0);" offset=' + endPage + ' style="border-right:1px solid #E5E5E5;" >' + this.label.lastPage + '</a>';
            
            html += '</span>';
            html += '</div>';
            
            return html;
            
        };
        
        this.addStyle = function(type , src){
        	var cssElement = document.createElement('link');
        	cssElement.type = 'text/css';
        	cssElement.rel = 'stylesheet';
			if(src){
				cssElement.href = src;
//				document.head.appendChild('<link type="text/css" href="' + src + '" rel="stylesheet" />');
			}else{
	            type = type ? type : 'default';
//	            document.head.appendChild('<link type="text/css" href="' + this.style[type] + '" rel="stylesheet" />');
	            cssElement.href = this.style[type];
			}
//			document.head.appendChild(cssElement);
			$('head').append(cssElement);
        }
        
        this.bindEvent = function(){
            $('.pager_container .pager_first').click(function(){
                if (_this.offset > $(this).attr('offset')) {
                	_this.offset = 0;
                    $('.pager_container').replaceWith(_this.showHTML(_this.totalCount, _this.offset, _this.step));
                    _this.bindEvent();
                    try {
                        _this.changeListener(_this.offset, _this.step);
                    } 
                    catch (e) {
                    }
                }
            });
            
            $('.pager_container .pager_prev').click(function(){
                if ($(this).attr('offset') != 'false') {
                	_this.offset -= _this.step;
                    $('.pager_container').replaceWith(_this.showHTML(_this.totalCount, _this.offset , _this.step));
                    _this.bindEvent();
                    try {
                        _this.changeListener(_this.offset, _this.step);
                    } 
                    catch (e) {
                    }
                }
            });
            
            $('.pager_container .pager_next').click(function(){
                if ($(this).attr('offset') != 'false') {
                	_this.offset += _this.step;
                    $('.pager_container').replaceWith(_this.showHTML(_this.totalCount, _this.offset , _this.step));
                    _this.bindEvent();
                    try {
                        _this.changeListener(_this.offset, _this.step);
                    } 
                    catch (e) {
                    }
                }
            });
            
            $('.pager_container .pager_last').click(function(){
                if (_this.offset < $(this).attr('offset')) {
                	_this.offset = parseInt($(this).attr('offset'));
                    $('.pager_container').replaceWith(_this.showHTML(_this.totalCount, _this.offset, _this.step));
                    _this.bindEvent();
                    try {
                        _this.changeListener(_this.offset, _this.step);
                    } 
                    catch (e) {
                    }
                }
            });
            
            $('.pager_container .pager_page').click(function(){
                if (_this.offset != $(this).attr('offset')) {
                	_this.offset = parseInt($(this).attr('offset'));
                    $('.pager_container').replaceWith(_this.showHTML(_this.totalCount, _this.offset, _this.step));
                    _this.bindEvent();
                    try {
                        _this.changeListener(_this.offset, _this.step);
                    } 
                    catch (e) {
                    }
                }
            });
            
            $('.pager_step_select').change(function(){
            	_this.setStep(parseInt($(this).val()));
				try {
                    _this.changeListener(_this.offset, _this.step);
                } 
                catch (e) {
                }
            });
			
			$('.pager_jump').blur(function(){
				var pageIndex = parseInt($(this).val());
				var offset = (pageIndex - 1) * _this.step;
				 if (_this.offset != offset) {
                	_this.offset = offset;
                    $('.pager_container').replaceWith(_this.showHTML(_this.totalCount, _this.offset, _this.step));
                    _this.bindEvent();
                    try {
                        _this.changeListener(_this.offset, _this.step);
                    } 
                    catch (e) {
                    }
                }
			});
			
			$('.pager_jump').keypress(function(e){
				if(e.keyCode != 13){
					return;
				}
				var pageIndex = parseInt($(this).val());
				var offset = (pageIndex - 1) * _this.step;
				 if (_this.offset != offset) {
                	_this.offset = offset;
                    $('.pager_container').replaceWith(_this.showHTML(_this.totalCount, _this.offset, _this.step));
                    _this.bindEvent();
                    try {
                        _this.changeListener(_this.offset, _this.step);
                    } 
                    catch (e) {
                    }
                }
			});
        };
        
        this.change = function(func){
            this.changeListener = func;
        }
        
    };
})();