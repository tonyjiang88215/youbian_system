KindEditor.plugin('mark_column', function(K) {
	var self = this , name = 'mark_column' , lang = self.lang(name + '.');
	
	
	self.clickToolbar(name, function() {
		
		var selectContent = self.cmd.range.html();
		
//		console.log(selectContent);
//		self.cmd.wrap('<markcolumn style="display:none;"></markcolumn>',{markcolumn:"*"});
		self.insertHtml(' ');
//		self.cmd.toggle('<markcolumn style="display:none;"></markcolumn>',{markcolumn:"*"});
//		var commonNode = self.cmd.commonNode({markcolumn : '*'});
//		var commonNode = true;
		
//		console.log(commonNode);
		
		var e = new TJEvent.EventObject('split_column');
		e.data.content = selectContent;
//		if(commonNode){
			e.data.action = 'add';
//		}else{
//			e.data.action = 'undo';
//		}
		
		TJEvent.dispatch(e);
		
		var triggerEvent = new jQuery.Event('keypress');
		
		triggerEvent.keyCode = 13;
		
		$('.ke-edit-iframe').trigger(triggerEvent);
		
		
	});
});

