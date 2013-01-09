<?php
return array(
	//数据库配置
	'DB_HOST'=>'localhost',//mysql地址
	'DB_NAME'=>'app_repos',//数据库名称
	'DB_USER'=>'root',//数据库用户名
	'DB_PASS'=>'123456',//数据库密码
	'DB_PORT'=>3306,//端口
	'DB_ERR_LOG'=>ROOT.'log/db_err.log',//数据库错误日志记录地址
	//路由规则
	'ROUTES'=>array(
		'list'=>'app/lists',
		'app\/search\/([^\/]+)\/'=>'app/search/keyword/$1/'
	)


);
