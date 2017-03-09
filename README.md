# Dida框架

当你轻声说出“滴答”两个字的时候，工作已经完成！这就是Dida框架的目标。

官网 <http://dida.zeupin.com>  
源码 <https://github.com/zeupin/dida>

## 运行环境要求

PHP：v5.5及以上，v7.0及以上。

## 命名规范

### 目录和文件命名规范

* 需要对web前端用户隐藏的目录和文件，首字母一律用大写字母。例如：`App/`，`Dida/Index.php`。
* 可以开放给web前端用户的目录和文件，首字母用小写，例如：`www/index.php`。

### 类、方法、属性的命名规则

> * PascalCase规则：首字母大写的Pascal命名规则。
> * camelCase规则：首字母小写的驼峰命名规则。
> * 这里所说的类包含：类Class、接口Interface、特性Trait。

* 遵循PSR-4自动加载规范。
* 类名使用PascalCase规则，例如：`RouteRule`、`RouteInterface`。
* 类的方法名使用camelCase规则，例如：`getUserIP()`。
* 类的属性名使用camelCase规则，例如：`userName`。
* 接口名要加上Interface后缀，例如：`RouteInterface`。
* 特性名要加上Trait后缀，例如：`SingletonTrait`。

### 全局函数

* 函数名以小写字母和下划线组成，例如：`foo_bar()`。
* Dida框架的全局函数以 `dida_` 开头，例如：`dida_halt()`。
* App级别的全局函数以 `appf_`开头，例如：`appf_dump_array()`。

### 常量

* 常量以大写字母和下划线组成，例如：`DIDA_ROOT`。

## 编码规范

1. Dida框架目录的所有文件都应该是和具体项目无关的，和项目有关的文件都应该放到App目录中。

  > 在决定一个文件究竟应该放到Dida目录还是放到App目录时，问自己一个问题：这个文件可以用于所有项目还是只能用于当前项目？

2. Dida框架的命名空间统一用`Dida`，App的命名空间用`App`。

3. MVC的设计原则是：瘦Controller，胖Model，这样可以尽可能增强代码的可重用性。

4. require, include, require_once, include_once 文件时，推荐用不加括号的形式。

  > 推荐的写法：   `require 'target_file_name.php'`;  
  > 不推荐写法： `require('target_file_name.php')`;  

## 处理流程

1. 服务器把用户请求rewrite到Web入口文件 **<www>/index.php**。

2. 在 **index.php** 文件中设置好各个关键目录的文件路径，然后加载DIDA框架的入口文件 **DIDA_ROOT/Index.php**。

3. 在 **DIDA框架的入口文件Index.php** 设置好基础运行环境：加载常量，加载autoload机制，加载全局函数库，生成$app实例等，然后启动**$app->bootstrap()**，进行app启动准备。
	1. 载入 **App/Config/App.dev.php** 配置文件。
	2. 载入 **App/Functions/** 中的函数库（如果有的话）。
	3. 载入 **App/Bootstrap/Index.php** ，对App环境和可能用到的服务进行初始配置。

4. 工作环境ready，执行**$app->run()**，正式开始处理Reuqest。

5. 中间件环境初始化。

6. **Middleware处理**，可以对Request以及环境做些前期处理。

7. **Router** 逐一用登记的 **路由规则route** 去解析 **Request**，检查Request是否可以匹配这个规则route。

8. 如果可以匹配，则执行 **route->route()**。

9. 执行标准的**MVC流程**，**Controller** 从 **Model** 取数据，赋值给 **View**。

10. **Middlewarec处理**，可以对View做些后期处理。

11. **app()->response->output()** 输出最终内容给用户。
