# 认证方式
通过验证签名进行授权。签名方法如下：
```
sha1(request_uri + accesskey + secretkey)
```
__请求头：__

    App-Store-Auth: xxxx  签名

    App-Store-Access-Key: accesskey   用户的accesskey

# API说明
## 获取应用列表
/repos/list

__请求头：__
```
Repo-Ver: local-version   
```

如果服务端版本小于该版本，返回:
``` php
Array
(
    [errno] => 304
    [errmsg] => No new apps
)
```
如果没有Repo-Ver头或者服务端版本号大于Repo-Ver，返回：
``` php
Array
(
    [errno] => 0
    [title] => Demo app repository
    [contact] => demo@example.com
    [icon] => http://sae.sina.com.cn/static/image/store/createapp.png
    [src-url] => http://repos.lajipk.com/apps/
    [repo-ver] => 1
	[count]=>1
	[total-pages]=>1
	[current-page]=>1
    [apps] => Array
        (
            [0] => Array
                (
                    [name] => Wordpress Basic
                    [icon] => http://www.wordpress.org/logo.png
                    [cat] => Blog
                    [services] => MySQL
                    [runtime] => PHP5.3
                    [mem] => 128
                    [disk] => 256
                    [cpu] => 1
                    [license] => LGPL
                )

        )

)
```

__返回字段说明：__ title 仓库名词， contact 仓库联系方式，icon 仓库图标 ， src-url 仓库地址 ， count 记录总条数  total-pages 总页数 ，  current-page 当前页数， apps 应用列表。 应用字段说明见info接口

__注：__ 客户端需要保存repo-ver以减少服务端数据返回量，加快响应。

## 获取单个应用的信息
/repos/app/info/appname

__返回格式：__
``` php
Array
(
    [errno] => 0
    [name] => Wordpress Basic
    [icon] => http://www.wordpress.org/logo.png
    [cat] => Blog
    [services] => MySQL
    [runtime] => PHP5.3
    [mem] => 128
    [disk] => 256
    [cpu] => 1
    [license] => LGPL
)
```
__返回字段说明：__ name 应用名称，icon 应用图标， cat 应用分类， services 应用需要开通的服务， runtime 应用运行环境， mem 应用所需最低内存大小，  disk 应用最低磁盘大小 ， cpu 应用最低cpu个数 ， license 应用遵循的协议。 
## 根据应用名搜索应用
/repos/app/search/keyword

返回格式与/repos/list 一样。

## 下载应用安装包
/repos/app/download/appname

__返回格式：__
``` php
Aarry
(
	[errno]=>0
	[src]=>http://downloadurl
)
```
__返回字段说明：__ src 下载地址
# 错误码定义
* 参数错误： [4000, 5000)
* 4000  The header App-Store-Auth or App-Store-Access-Key is empty  请求时没有携带 App-Store-Auth 或 App-Store-Access-Key 的header。
* 4001  Access Key does not exist   请求时携带的Access Key错误，数据库中查不到。
* 4002  Auth error 签名错误
* 4003  Paramter [xxx] must be non-empty  必传参数为空 
* 4004  Api Not Found   请求地址不正确
* 服务端错误：[5000, 6000)
* 5000 Mysql Error  数据库出错， 具体错误可以在日志中查到
* 5005 Apps not found  没有找到相关应用

