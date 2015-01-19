KindEditor.plugin('mark_question', function(K) {
	var self = this , name = 'mark_question' , lang = self.lang(name + '.');
	
	
	self.clickToolbar(name, function() {
		
		var selectContent = self.cmd.range.html();
		
//		console.log(selectContent);
//		self.cmd.wrap('<markcolumn style="display:none;"></markcolumn>',{markcolumn:"*"});
		self.insertHtml(' ');
//		self.cmd.toggle('<markquestion style="display:none;"></markcolumn>',{markquestion:"*"});
//		var commonNode = self.cmd.commonNode({markquestion : '*'});
//		var commonNode = true;
		
//		console.log(commonNode);
		
		var e = new TJEvent.EventObject('split_question');
		e.data.content = selectContent;
//		if(commonNode){
			e.data.action = 'add';
//		}else{
//			e.data.action = 'undo';
//		}
		
		TJEvent.dispatch(e);
		
	});
});

