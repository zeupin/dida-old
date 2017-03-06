# Dida框架

当你轻声说出“滴答”两个字的时候，工作已经完成！这就是Dida框架的目标。

官网 <http://dida.zeupin.com>  
源码 <https://github.com/zeupin/dida>

## 运行环境要求

PHP：v5.5及以上，v7.0及以上。

## 命名规范

### 目录和文件命名规范

* 需要对web浏览者隐藏的目录和文件，首字母一律用大写字母。例如：App/，Dida/Index.php。
* 可以开放给web浏览者的目录和文件，首字母用小写，例如：www/index.php。

### 类、方法、属性的命名规则

> * PascalCase规则：首字母大写的驼峰命名规则。
> * camelCase规则：首字母小写的驼峰命名规则。
> * 这里所说的类包含：类Class、接口Interface、特性Trait。

* 遵循PSR-4自动加载规范。
* 类名使用PascalCase规则，例如：`RouteRule`、`RouteInterface`。
* 类的方法名使用camelCase规则，例如：`getUserIP()`。
* 类的属性名使用camelCase规则，例如：`userName`。
* 接口名要加上Interface后缀，例如：`RouteInterface`。
* 特性名要加上Trait后缀，例如：`SingletonTrait`。

### 全局函数

* 函数名以小写字母和下划线，例如：`foo_bar()`。
* Dida框架的全局函数以 `dida_` 开头，例如：`dida_halt()`。
* App级别的全局函数以 `appf_`开头，例如：`appf_dump_array()`。

### 常量

* 常量以大写字母和下划线组成，例如：`DIDA_ROOT`。