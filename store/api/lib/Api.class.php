<?php
/**
 * Api 基类，每个Api都继承了这个类， 基类主要实现对用户的认证 
 * 
 * @package Api 
 */
class Api{

	/**
	 * 应用仓库详细描述信息 
	 * 
	 * @var array
	 * @access protected
	 */
	protected $description=array();
	/**
	 * 当前访问用户的用户等级
	 * 
	 * @var int
	 * @access protected
	 */
	protected $user_level=0;
	/**
	 * 构造函数，实现对用户签名的验证，以及对版本的验证 
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct(){
		if(empty($_SERVER['HTTP_APP_STORE_AUTH']) || empty($_SERVER['HTTP_APP_STORE_ACCESS_KEY'])){
			error(4000,'App-Store-Auth or App-Store-Access-Key is empty');
		}
		$sign=$_SERVER['HTTP_APP_STORE_AUTH'];
		$ak=($_SERVER['HTTP_APP_STORE_ACCESS_KEY']);
		if(!$arr=get_line("select skey,level from user where akey='{$ak}'")){
			error(4001,'Access Key does not exist');
		}
		$sk=$arr['skey'];
		$this->user_level=$arr['level'];
		//签名验证
		if($sign!=sha1(REQUEST_URI.'+'.$ak.'+'.$sk)){
			error(4002,'Auth error');
		}
		//config数据表加入配置
		$configs=get_data("select * from config");
		foreach($configs as $config){
			$value=is_serialized($config['val'])?unserialize($config['val']):$config['val'];
			c(strtoupper($config['opt']),$value);	
		}
		$this->description=c('DESCRIPTION');
		//版本检测
		$server_version=c('REPO-VER');
		$client_version=isset($_SERVER['HTTP_REPO_VER'])?$_SERVER['HTTP_REPO_VER']:$server_version;
		if(version_compare($client_version,$server_version,'>')){
			error(304,'No new apps');
		}
	}
}
