<?php
/**
 * 应用接口。用于获取应用列表，应用详细信息，搜索应用，下载应用等。 
 * 
 * @uses Api
 */
class AppApi extends Api{
	/**
	 * 应用列表接口地址
	 * 请求URL： /app/lists 可简化为 /list 
	 * 支持分页：/list/pagesize/{pagesize}/page/{page} , 传递参数pagesize为每页显示记录条数，page为页数
	 * 示例： curl -H 'App-Store-Access-Key:aaa' -H 'App-Store-Auth:2332c114d6c9e48ae0d2aa1dea2e9310cf87d0fe' "http://yourdomain/store/api/list"
	 * 返回数据：{"errno":0,"title":"Demo app repository","contact":"demo@example.com","icon":"http:\/\/sae.sina.com.cn\/static\/image\/store\/createapp.png","src-url":"http:\/\/repos.lajipk.com\/apps\/","count":"2","total-pages":1,"current-page":1,"apps":[{"name":"wordpress","icon":"http:\/\/wordpress.org\/icon.png","cat":"blog","services":"mysql","runtime":"PHP-5.3","mem":"32","disk":"100","cpu":"1","license":"'GPL'"},{"name":"drupal","icon":"http:\/\/drupal.org\/icon.png","cat":"cms","services":"mysql","runtime":"PHP-5.3","mem":"32","disk":"100","cpu":"1","license":"'GPL'"}]}
	 * 返回字段说明： title 仓库名词， contact 仓库联系方式，icon 仓库图标 ， src-url 仓库地址 ， count 记录总条数  total-pages 总页数 ，  current-page 当前页数， apps 应用列表。 应用字段说明见info接口
	 * @param string $keyword 查询关键词 
	 * @param int $pagesize 每页显示记录条数
	 * @param int $page 页数
	 * @access public
	 * @return void
	 */
	public function lists($keyword='',$pagesize=20,$page=1){
		$pagesize=intval($pagesize);
		$page=intval($page);
		$where="access<='{$this->user_level}'";
		if(!empty($keyword))
			$where.=" and name like '%".s($keyword)."%'";
		$total=get_var("select count(1) from apps where {$where}");
		if(0==$total){
			error(5005,'Apps not found');
		}
		$total_pages=ceil($total/$pagesize);
		if($page<1) $page=1;
		if($page>$total_pages) $page=$total_pages;
		$start=($page-1)*$pagesize;
		$data=get_data("select name,icon,cat,services,runtime,mem,disk,cpu,license from apps where {$where} limit {$start},{$pagesize}");
		$result=$this->description;
		$result['count']=$total;
		$result['total-pages']=$total_pages;
		$result['current-page']=$page;
		$result['apps']=$data;
		success($result);
	}
	/**
	 * 获得单个应用的详细信息
	 * 请求地址 /app/info/{appname}
	 * 示例：curl -H 'App-Store-Access-Key:aaa' -H 'App-Store-Auth:2a48dd6f09541960c080fdb93a8f72f10c474e7e' "http://yourdomain/store/api/app/info/wordpress"
	 * 返回结果：{"errno":0,"name":"wordpress","icon":"http:\/\/wordpress.org\/icon.png","cat":"blog","services":"mysql","runtime":"PHP-5.3","mem":"32","disk":"100","cpu":"1","license":"'GPL'"}
	 * 返回字段说明：name 应用名称，icon 应用图标， cat 应用分类， services 应用需要开通的服务， runtime 应用运行环境， mem 应用所需最低内存大小，  disk 应用最低磁盘大小 ， cpu 应用最低cpu个数 ， license 应用遵循的协议。
	 * 
	 * @param mixed $appname 应用名称 
	 * @access public
	 * @return void
	 */
	public function info($appname){
		$data=get_line("select name,icon,cat,services,runtime,mem,disk,cpu,license from apps where access<='{$this->user_level}' and name='".s($appname)."'");
		if(empty($data)){
			error(5005,'Apps not found');
		}
		success($data);
	}
	/**
	 * 搜索应用 
	 * 请求地址： /app/search/{keyword}
	 * 支持分页： /app/search/{keyword}/pagesize/{pagesize}/page/{page}
	 * 示例：curl -H 'App-Store-Access-Key:aaa' -H 'App-Store-Auth:ba4b52a53803d6f78e8d8366e04c33c3d2db4f28' "http://yourdomain/store/api/app/search/wordpress"
	 * 返回结果：同list接口
	 *
	 * @param string $keyword 搜索关键词 
	 * @param int $pagesize 每页显示条数 
	 * @param int $page 页数
	 * @access public
	 * @return void
	 */
	public function search($keyword,$pagesize=20,$page=1){
		$this->lists($keyword,$pagesize,$page);
	}
	/**
	 * 下载应用
	 * 请求地址：/app/download/{appname}
	 * 示例：curl -H 'App-Store-Access-Key:aaa' -H 'App-Store-Auth:f10d034aa14996b9bdc0d07608522365c421216f' "http://yourdomain/store/api/app/download/wordpress"
	 * 返回结果：{"errno":0,"src":"http:\/\/wordpress.org"}
	 * 返回字段说明：src 下载地址 
	 * 
	 * @param string $appname 应用名称
	 * @access public
	 * @return void
	 */
	public function download($appname){
		$src=get_var("select src from apps where access<='{$this->user_level}' and name='".s($appname)."'");
		if(!$src){
			error(5005,'Apps not found');
		}
		success(array('src'=>$src));
	}
}
