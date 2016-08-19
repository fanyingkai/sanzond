/* 超级简易模板引擎(字符串解析替换) */
function assign(id,data) {
	var html=document.getElementById(id).innerHTML;
	var result="var p=[];with(obj){p.push('"
		+html.replace(/[\r\n\t]/g," ")
		.replace(/<%=(.*?)%>/g,"');p.push($1);p.push('")
		.replace(/<%/g,"');")
		.replace(/%>/g,"p.push('")
		+"');}return p.join('');";
	var fn = new Function("obj",result);
	return fn(data);
}