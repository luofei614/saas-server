<?php
/**
 * 核心函数文件
 */


/**
 * app_run ，在入口文件中调用，实现单一入口，路由解析，参数绑定 
 * 
 * @access public
 * @return void
 */
function app_run(){
	//加载Api基类
	require_once ROOT.'lib/Api.class.php';
	//解析URL,如果用户环境不支持PATHINFO，可以用传递s变量
	if(!isset($_GET['s']) && !isset($_SERVER['PATH_INFO'])) error(4004,'Api Not Found');
    $pathinfo=isset($_GET['s'])?$_GET['s']:$_SERVER['PATH_INFO'];	
	define('REQUEST_URI',$pathinfo);
	$pathinfo=ltrim($pathinfo,'/');
	//路由
	$routes=c('ROUTES');
	if(!empty($routes)){
		foreach($routes as $rule=>$route){
			if(preg_match('/'.$rule.'/i',$pathinfo)){
				$pathinfo=preg_replace('/^'.$rule.'/i',$route,$pathinfo);
				break;
			}
		}
	}	
	$paths=explode('/',$pathinfo);
	if(count($paths)<2) error(4004,'Api Not Found');
	$module=ucfirst(strtolower(basename(array_shift($paths))));
	$action=array_shift($paths);
	$count_paths=count($paths);
	$arg=null;
	if(1==$count_paths){
		$arg=$paths[0];	
	}elseif($count_paths>=2){
 		preg_replace('@(\w+)\/([^\/]+)@e', '$var[\'\\1\']=\'\\2\';', implode('/',$paths));
    	$_GET   =  array_merge($var,$_GET);
	}
	if(is_file(ROOT.'lib/'.$module.'Api.class.php'))
		require ROOT.'lib/'.$module.'Api.class.php';
	else
		error(4004,'Api Not Found');
	$class_name=$module.'Api';
    $class=new $class_name;
	if(!method_exists($class,$action)){
		error(4004,'Api Not Found');
	}
	//参数绑定
	$method=new ReflectionMethod($class,$action);
	if($method->isPublic()){
		if($method->getNumberOfRequiredParameters()<=1 && !is_null($arg)){//只有一个参数时，直接调用方法
			call_user_func(array($class,$action),$arg);
			return ;
		}
		if($method->getNumberOfParameters()>0){
			$params =  $method->getParameters();
			$args=array();
			$vars='POST'==$_SERVER['REQUEST_METHOD']?$_POST:$_GET;
			foreach ($params as $param){
				$name = $param->getName();
				if(isset($vars[$name])) {
					$args[] =  $vars[$name];
				}elseif($param->isDefaultValueAvailable()){
					$args[] = $param->getDefaultValue();
				}else{
					error(4003,'Parameter ['.$name.'] must be non-empty');
				}
			}
            $method->invokeArgs($class,$args);
		}else{
			$method->invoke($class);
		}	
	}else{
		error(4004,'Api Not Found');
	}
}
/**
 * 配置函数，应用获取或设置配置 
 * 
 * @param string $name 配置项名称 
 * @param mixed $value 配置项的值（如果这个参数不为空则会设置配置项，如果为空为获取配置项） 
 * @access public
 * @return mixed|null  如果是获取配置项，返回配置项的值
 */
function c($name,$value=null){
	/**
	 * _config 
	 * 
	 * @static
	 * @var mixed
	 * @access protected
	 */
	static $_config=null;
	if(is_null($_config)) $_config=require ROOT.'config.php';
	if(!is_null($value)){
		$_config[$name]=$value;
		return ;
	}
	return isset($_config[$name])?$_config[$name]:null;
}
/**
 * 显示接口错误 
 * 
 * @param int $errno 错误码 
 * @param string $errmsg 错误信息
 * @access public
 * @return void
 */
function error($errno,$errmsg){
	exit(json_encode(array('errno'=>$errno,'errmsg'=>$errmsg)));
}
/**
 * 显示接口结果 
 * 
 * @param mixed $data 接口返回的数据 
 * @access public
 * @return void
 */
function success($data){
	exit(json_encode(array_merge(array('errno'=>0),$data)));
}
/**
 * 判断数据是否为一个序列化的数据
 * 
 * @param string $data 
 * @access public
 * @return void
 */
function is_serialized( $data ) {
         $data = trim( $data );
         if ( 'N;' == $data )
             return true;
         if ( !preg_match( '/^([adObis]):/', $data, $badions ) )
             return false;
         switch ( $badions[1] ) {
             case 'a' :
             case 'O' :
             case 's' :
                 if ( preg_match( "/^{$badions[1]}:[0-9]+:.*[;}]\$/s", $data ) )
                     return true;
                 break;
             case 'b' :
             case 'i' :
             case 'd' :
                 if ( preg_match( "/^{$badions[1]}:[0-9.E-]+;\$/", $data ) )
                     return true;
                 break;
         }
         return false;
}
/**
 * 链接数据库 
 * 
 * @access public
 * @return void
 */
function db()
{
	if(!is_null($_link)) return $_link;
	if(!extension_loaded('mysqli')) db_error('not support mysqli');
	$host=c('DB_HOST');
	$port=c('DB_PORT');
	$user=c('DB_USER');
	$password=c('DB_PASS');
	$db_name=c('DB_NAME');
	$_link=new mysqli($host,$user,$password,$db_name,$port);
	if(mysqli_connect_errno()) db_error(mysqli_connect_error());
	return $_link;
}

/**
 * 数据库执行错误时的处理方法,接口返回5000错误， 详细的错误信息可以通过日志查询 
 * 
 * @param string $errmsg 
 * @access public
 * @return void
 */
function db_error($errmsg=''){
	if(empty($errmsg)){
		$errmsg=db()->error;
	}
	if(empty($errmsg)) return ;
	$log_file=c('DB_ERR_LOG');
	if(!empty($log_file)) error_log(date('[ c ]').$errmsg.(isset($GLOBALS['last_sql'])?'[sql:'.$GLOBALS['last_sql'].']':'').PHP_EOL,3,$log_file);
	error(5000,'Mysql Error');
}

/**
 * 安全过滤 
 * 
 * @param mixed $str 
 * @access public
 * @return void
 */
function s($str)
{
	return db()->real_escape_string($str);
}




/**
 * 执行sql语句获得数据集合 
 * 
 * @param string $sql sql语句 
 * @access public
 * @return void
 */
function get_data($sql){
	$GLOBALS['last_sql']=$sql;
	if(!$query=db()->query($sql)){
		db_error();
	}
	$rows=$query->num_rows;
	$result=array();
	if($rows>0){
		for($i=0;$i<$rows;$i++){
			$result[$i]=$query->fetch_assoc();
		}
		$query->data_seek(0);
	}
	return $result;
}

/**
 * 执行sql语句获得一条数据 
 * 
 * @param string $sql 
 * @access public
 * @return void
 */
function get_line( $sql)
{
    $data = get_data( $sql);
    return @reset($data);
}

/**
 * 执行sql语句获得一列数据 
 * 
 * @param string $sql 
 * @access public
 * @return void
 */
function get_col($sql){

    $data=get_data($sql);
    if(!$data) return false;
    $ret=array();
    foreach($data as $d)
        $ret[]=reset($d);
    return $ret;
}

/**
 * 执行sql语句，获得单个字段值
 * 
 * @param string $sql 
 * @access public
 * @return void
 */
function get_var( $sql)
{
    $data = get_line( $sql);
    return $data[ @reset(@array_keys( $data )) ];
}


/**
 * 运行sql语句，应用执行删除，插入等操作
 * 
 * @param string $sql 
 * @access public
 * @return void
 */
function run_sql($sql)
{
	$GLOBALS['last_sql']=$sql;
	if(!$query=db()->query($sql)){
		db_error();
	}
	return true;
}


?>
