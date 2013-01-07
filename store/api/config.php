<?php
return array(
	//路由规则
	'ROUTES'=>array(
		'list'=>'app/lists',
		'app\/search\/([^\/]+)\/'=>'app/search/keyword/$1/'
	),
	'DB_HOST'=>'localhost',
	'DB_NAME'=>'app_repos',
	'DB_USER'=>'root',
	'DB_PASS'=>'123456',
	'DB_PORT'=>3306,
	'DB_ERR_LOG'=>ROOT.'log/db_err.log'


);
