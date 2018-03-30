// define(['js/d'],function(n2){
// 	alert('这是E模块在执行了，也是有返回值...');
// 	var n1 = 300;
// 	return n1 + n2;
// })


//下面的定义 是在main.js里面进行的调用 
define(['d'],function(n2){
	alert('这是E模块在执行了，也是有返回值...');
	var n1 = 300;
	return n1 + n2;
})