# index.php 入口文件

## 入口文件示例
```php
<?php
/* 必填的常量 */
define('DIDA_ROOT',           __DIR__ . '/../src/');
define('DIDA_COMPOSER_ROOT',  __DIR__ . '/../vendor/');
define('DIDA_APP_ROOT',       __DIR__ . '/../App/');
define('DIDA_VAR_ROOT',       __DIR__ . '/../Var/');
define('DIDA_WEB_ROOT',       __DIR__ . '/');
define('DIDA_ENV',            'dev');

/* 选填的常量 */
define('DIDA_WWW',                '/');
define('DIDA_DEBUG',              true);
define('DIDA_APP_NAMESPACE',      'App');
define('DIDA_DEFAULT_CONTROLLER', 'Index');
define('DIDA_DEFAULT_ACTION',     'index');

/* 开始 */
require(DIDA_ROOT . 'Index.php');
```

## 常量说明

### 必填的常量

```
DIDA_ROOT               指明Dida框架目录的文件路径。

DIDA_COMPOSER_ROOT      指明Composer的vendor目录的文件路径。

DIDA_APP_ROOT           指明App目录的文件路径。
                            App目录是项目目录，保存App项目的相关程序和配置。

DIDA_VAR_ROOT           指明Var目录的文件路径。
                            Var目录是用于存储动态生成文件的目录（如cache文件，log文件等），此目录要有可写权限。

DIDA_WEB_ROOT           指明Web目录的文件路径。
                            一般就是入口文件的所在目录。

DIDA_ENV                指明APP的当前运行环境。
                            其值一般可为：dev（开发环境），production（生产环境），test（测试环境）等。
                            App启动时，会根据这个常量，加载DIDA_APP_ROOT/Config/目录中的不同的配置文件。
                            如：开发环境会加载App.dev.php，生产环境加载App.live.php，等等。
                            注意，因为会载入对应文件，所以这个值对大小写敏感。
```

### 选填的常量

```
DIDA_WWW                指明web的根路径，默认是入口文件所在的web路径。
                            一般这个值为/，虚拟目录则可能为/foo/(注意：最后一个字符应为/）。
                            程序在路由时，会忽略网址中 DIDA_WWW 对应的开头部分，以获取一个和主机无关的web路径。

DIDA_DEBUG         指明是否开启调试模式，值为true或者false。默认是开启true。
                            开启后，会显示所有错误信息。

DIDA_APP_NAMESPACE      指明App的命名空间，默认是App。

DIDA_DEFAULT_CONTROLLER 指明默认的Controller名称，默认是Index。

DIDA_DEFAULT_ACTION     指明默认的Action名称，默认是index。
                            default是PHP的保留关键字，不能使用。
```
