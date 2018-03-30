// require(['js/a','js/b','c','js/e','js/aa/f','js/bb/cc/m'],function(){
// 	alert('main模块的函数开始执行了...');
// });

require(['a','b','../c','e','aa/f','bb/cc/m'],function(){
	alert('main模块的函数开始执行了...');
});

// 路径还是相对于当前的调用 者而言