KindEditor.plugin('mark_children', function(K) {
	var self = this , name = 'mark_children' , lang = self.lang(name + '.');
	
	
	self.clickToolbar(name, function() {
		
		var selectContent = self.cmd.range.html();
		
//		console.log(selectContent);
		
//		self.cmd.toggle('<markchildren style="display:none;"></markchildren>',{markchildren:"*"});
		self.insertHtml(' ');
		var commonNode = self.cmd.commonNode({markchildren : '*'});
		
//		console.log(commonNode);
		
		var e = new TJEvent.EventObject('split_children');
		e.data.content = selectContent;
//		if(commonNode){
			e.data.action = 'add';
//		}else{
//			e.data.action = 'undo';
//		}
		
		TJEvent.dispatch(e);
		
	});
});

