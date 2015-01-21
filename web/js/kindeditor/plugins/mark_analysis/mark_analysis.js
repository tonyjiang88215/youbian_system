KindEditor.plugin('mark_analysis', function(K) {
	var self = this , name = 'mark_analysis' , lang = self.lang(name + '.');
	
	
	self.clickToolbar(name, function() {
		
		var selectContent = self.cmd.range.html();
		
//		self.cmd.toggle('<markanalysis style="display:none;"></markanalysis>',{markanalysis:"*"});
		self.insertHtml(' ');
		var commonNode = self.cmd.commonNode({markanalysis : '*'});
		
		var e = new TJEvent.EventObject('split_analysis');
		
		e.data.content = selectContent;
//		if(commonNode){
			e.data.action = 'add';
//		}else{
//			e.data.action = 'undo';
//		}
		
		TJEvent.dispatch(e);
		
		
	});
});

