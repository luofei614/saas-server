## 提供的接口:
### 获取应用列表
/repos/list

__返回格式：__
```
Array
(
    [errno] => 0
    [title] => Demo app repository
    [contact] => demo@example.com
    [icon] => http://sae.sina.com.cn/static/image/store/createapp.png
    [src-url] => http://repos.lajipk.com/apps/
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

### 获取单个应用的信息
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

### 根据应用名搜索应用
/repos/app/search/keyword

返回格式与/repos/list 一样。

### 下载应用安装包
/repos/app/download/appname


## 错误码定义
* 参数错误： [4000, 5000)
* 服务端错误：[5000, 6000)

