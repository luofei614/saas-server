<?php
class AppApi extends Api{
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
	public function info($appname){
		$data=get_line("select name,icon,cat,services,runtime,mem,disk,cpu,license from apps where access<='{$this->user_level}' and name='".s($appname)."'");
		if(empty($data)){
			error(5005,'Apps not found');
		}
		success($data);
	}
	public function search($keyword,$pagesize=20,$page=1){
		$this->lists($keyword,$pagesize,$page);
	}
	public function download($appname){
		$src=get_var("select src from apps where access<='{$this->user_level}' and name='".s($appname)."'");
		if(!$src){
			error(5005,'Apps not found');
		}
		success(array('src'=>$src));
	}
}
