function empty(type,url){
	switch(type){
		case 'cart':
			$(document.body).append('<div id="emptydiv"><span class="iconfont">&#xe643;</span><h4>购物车为空！！！</h4><a href="'+url+'"><button class="btn btn-default">去逛逛！</button></a></div>');
			break;
		case 'order':
			$(document.body).append('<div id="emptydiv"><span class="iconfont">&#xe636;</span><h4>订单为空！！！</h4><a href="'+url+'"><button class="btn btn-default">去逛逛！</button></a></div></div>');
			break;
		case 'coupon':
			$(document.body).append('<div id="emptydiv"><span class="iconfont">&#xe683;</span><h4>购物券为空！！！</h4><a href="'+url+'"><button class="btn btn-default">去逛逛！</button></a></div></div>');
			break;
		case 'address':
			$(document.body).append('<div id="emptydiv"><span class="iconfont">&#xe61e;</span><h4>地址为空！！！</h4><a href="'+url+'"><button class="btn btn-default">去逛逛！</button></a></div></div>');
			break;
		case 'activity':
			$(document.body).append('<div id="emptydiv"><span class="iconfont">&#x3455;</span><h4>暂无活动！</h4><a href="'+url+'"><button class="btn btn-default">去逛逛！</button></a></div></div>');
			break;
		case 'food':
			$(document.body).append('<div id="emptydiv"><span class="iconfont">&#xe639;</span><h4>食品分类为空！！！</h4><a href="'+url+'"><button class="btn btn-default">去逛逛！</button></a></div></div>');
			break;
		default:break;
	}
}
	
    
	



	
	
