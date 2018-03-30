require.config({
	baseUrl:'/assets/vendors',
	paths:{
		jquery:'jquery/jquery',
		bootstrap:'bootstrap/js/bootstrap'
	},
	shim:{ //本来不支持某些功能的库或是插件，使用某个小技艺改善一下，就让它达到某种功能
		bootstrap:{
			deps:['jquery']   //dependence 依赖
		}
	}
});