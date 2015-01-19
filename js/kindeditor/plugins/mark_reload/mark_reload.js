KindEditor.plugin('mark_reload', function(K) {
	var self = this , name = 'mark_reload' , lang = self.lang(name + '.');
	
	
	self.clickToolbar(name, function() {
		
		var e = new TJEvent.EventObject('editing_content_reload');
		TJEvent.dispatch(e);
		
	});
});

