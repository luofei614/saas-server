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

Repo-Ver: local-version   

如果服务端版本小于该版本，返回:
```
Array
(
    [errno] => 304
    [errmsg] => No new apps
)
```
如果没有Repo-Ver头或者服务端版本号大于Repo-Ver，返回：
```
Array
(
    [errno] => 0
    [title] => Demo app repository
    [contact] => demo@example.com
    [icon] => http://sae.sina.com.cn/static/image/store/createapp.png
    [src-url] => http://repos.lajipk.com/apps/
    [repo-ver] => 1
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

__注：__ 客户端需要保存repo-ver以减少服务端数据返回量，加快响应。

## 获取单个应用的信息
/repos/app/info/appname

__返回格式：__
```
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

## 根据应用名搜索应用
/repos/app/search/keyword

返回格式与/repos/list 一样。

## 下载应用安装包
/repos/app/download/appname


# 错误码定义
* 参数错误： [4000, 5000)
* 服务端错误：[5000, 6000)

