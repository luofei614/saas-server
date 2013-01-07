<?php
class Api{
	protected $version=0;
	protected $description=array();
	protected $user_level=0;
	//构造函数实现签名认证
	public function __construct(){
		if(empty($_SERVER['HTTP_APP_STORE_AUTH']) || empty($_SERVER['HTTP_APP_STORE_ACCESS_KEY'])){
			error(4000,'The header Store_Auth or Store_Access_Key is empty');
		}
		$sign=$_SERVER['HTTP_APP_STORE_AUTH'];
		$ak=($_SERVER['HTTP_APP_STORE_ACCESS_KEY']);
		if(!$arr=get_line("select skey,level from user where akey='{$ak}'")){
			error(40001,'Access Key does not exist');
		}
		$sk=$arr['skey'];
		$this->user_level=$arr['level'];
		//签名验证
		if($sign!=sha1(REQUEST_URI.'+'.$ak.'+'.$sk)){
			error(40002,'Auth error');
		}
		//config数据表加入配置
		$configs=get_data("select * from config");
		foreach($configs as $config){
			$value=is_serialized($config['val'])?unserialize($config['val']):$config['val'];
			c(strtoupper($config['opt']),$value);	
		}
		$this->description=c('DESCRIPTION');
		//版本检测
		$this->version=c('REPO-VER');
		$client_version=isset($_SERVER['HTTP_REPO_VER'])?$_SERVER['HTTP_REPO_VER']:$this->version;
		if(version_compare($client_version,$this->version,'>')){
			error(304,'No new apps');
		}
	}
}
