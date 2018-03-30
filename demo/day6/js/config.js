require.config({
	baseUrl:'/demo/day6',
	paths:{
		mm:'js/mm',
		kk:'js/kk',
		yy:'js/yy'
	},
	shim:{
		mm:{
			exports:'str'
		},
		kk:{
			exports:'oojj'
		},
		yy:{
			exports:'testYY'
		}
	}
})

// 1. 要看当前的文件支持不支持模块，就要看当前文件里面，有没有define定义的函数
// 2. 如果要是没有define定义的函数，而有依赖项的话，设置一个shim  deps
// 3. 没有define定义的函数，也没有依赖项,也要设置一下shim   exports 