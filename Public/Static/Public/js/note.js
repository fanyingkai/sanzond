
function message(title,content,callback){
	$(document.body).append('<div id="note_mask"></div><div id="note"><h4>'+title+'</h4><p>'+content+'</p><button>确定</button></div>');
	message_click(callback);
}

function message_click(callback){
	$('#note_mask').show();
	$('#note').show();
	note_click(callback);

}

function note_click(callback=mycall){
	$('#note_mask').click(function(){
		$('#note_mask').hide();	
		$('#note').hide();
		callback(callback);
	});
	$('#note button').click(function(){
		$('#note_mask').hide();
		$('#note').hide();
		callback(callback);
	});

}

function mycall(){}







