# index.php 入口文件

## 入口文件示例
```php
define('DIDA_ROOT', realpath(__DIR__ . '/../src') . '/');
define('COMPOSER_ROOT', realpath(__DIR__ . '/../vendor') . '/');
define('APP_ROOT', realpath(__DIR__ . '/../App') . '/');
define('VAR_ROOT', realpath(__DIR__ . '/../Var') . '/');
define('APP_ENVIRON', 'dev');

require(DIDA_ROOT . 'index.php');
```

## 常量说明

```
DIDA_ROOT           指明Dida框架目录的位置。
COMPOSER_ROOT       指明Composer的vendor目录的位置
APP_ROOT            指明App目录的位置。
                        App目录是项目目录，保存App项目的相关程序和配置。
VAR_ROOT            指明Var目录的位置。
                        Var目录是用于存储动态生成文件的目录（如cache文件，log文件等），此目录要有可写权限。
APP_ENVIRON         指明APP的当前运行环境。
                        其值一般可为：dev（开发环境），live（生产环境），test（测试环境）等。
                        App启动时，会根据这个常量，加载App_ROOT/Config/目录中的不同的配置文件。
                        如：开发环境会加载App.dev.php，生产环境加载App.live.php，等等。
```
