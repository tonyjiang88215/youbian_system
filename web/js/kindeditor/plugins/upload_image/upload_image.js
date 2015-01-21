KindEditor.plugin('upload_image', function(K) {
	var self = this , name = 'upload_image' , lang = self.lang(name + '.');
	
	
	TJEvent.addListener('upload_image_success' , function(e){
		
		var img = '<img src="'+e.data.content+'"></img>';
		
		window.editor.insertHtml(img);
		
	});
	
	self.clickToolbar(name, function() {
		
		var e = new TJEvent.EventObject('upload_image_panel_show');
		TJEvent.dispatch(e);
		
	});
});

