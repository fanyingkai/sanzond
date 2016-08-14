function smallred(num,width,height,top,right){
		$('.smallred').append('<div class="smallredin">'+num+'</div>');
		var indiv = $('.smallred .smallredin');
		if(width && width!=0){
			$(indiv).css('width',width+'px');
		}
		if(height && height!=0){
			$(indiv).css('height',height+'px');
		}
		if(top){
			$(indiv).css('top',top+'px');
		}
		if(right){
			$(indiv).css('right',right+'px');
		}

}