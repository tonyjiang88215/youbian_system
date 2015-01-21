KindEditor.plugin('mark_answer', function(K) {
	var self = this , name = 'mark_answer' , lang = self.lang(name + '.');
	
	
	self.clickToolbar(name, function() {
		
		var selectContent = self.cmd.range.html();
		
//		self.cmd.toggle('<markanswer style="display:none;"></markanswer>',{markanswer:"*"});
		self.insertHtml(' ');
		var commonNode = self.cmd.commonNode({markanswer : '*'});
		
		var e = new TJEvent.EventObject('split_answer');
		
		e.data.content = selectContent;
//		if(commonNode){
			e.data.action = 'add';
//		}else{
//			e.data.action = 'undo';
//		}
		
		TJEvent.dispatch(e);
		
		
	});
});

