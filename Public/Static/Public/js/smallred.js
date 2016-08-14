function smallred_init(size,width,height,top,right,font){
		$('.smallred').append('<div class="smallredin">0</div>');
		var indiv = $('.smallred .smallredin');
		if(width && width!=0){
			$(indiv).css('width',width+'px');
		}
		if(height && height!=0){
			$(indiv).css('height',height+'px');
			$(indiv).css('line-height',height+'px');
		}
		if(top){
			$(indiv).css('top',top+'px');
		}
		if(right){
			$(indiv).css('right',right+'px');
		}
		if(font){
			$(indiv).css('font-size',font+'px');
		}
		if(size){
			$(indiv).css('border-radius',font+'px');
		}

}

function smallred_setnum(num) {
	$('.smallred .smallredin').text(num);
}