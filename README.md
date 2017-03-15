# Dida框架

当你轻声说出“滴答”两个字的时候，工作已经完成！效率，就是Dida框架努力追求的唯一目标。

我们努力做到：

1. **开发快**。
    * 自带应用代码生成器，开箱即用，让初级使用者也能轻松上手。
    * 框架结构简单，流程清晰，方便高级使用者的深入研究。
    * 面向项目，不过度编码。

2. **运行快**。
    * 系统轻巧。
    * 按需加载。实际使用的时候才会生成实例。
    * 优化执行流程。

官网 <http://dida.zeupin.com>  
源码 <https://github.com/zeupin/dida>


## 运行环境要求

* PHP：v5.5及以上，v7.0及以上。

> 为什么要PHP 5.5以上？
> * 在中国主流主机商（如阿里云、新网等）的主流主机允许的范围内，尽可能选用较高的PHP版本。
> * PHP v5.5以上的运行性能要明显优于较低PHP版本。有条件的话，建议运行在PHP v7.0中，性能会更好。
> * 会用到PHP高级概念，比如生成器（Generator），以提高程序性能，为此需要PHP在5.5.0以上。

## 命名规范

### 目录和文件命名规范

* 需要对web前端用户隐藏的目录和文件，首字母一律用大写字母。例如：`App/`，`Dida/Index.php`。
* 可以开放给web前端用户的目录和文件，首字母用小写，例如：`www/index.php`。

### 类、方法、属性的命名规则

> * PascalCase规则：首字母大写的Pascal命名规则。
> * camelCase规则：首字母小写的驼峰命名规则。
> * 这里所说的类包含：类Class、接口Interface、特性Trait。

* 遵循PSR-4自动加载规范。
* 对有特定意义的Class和method，一律采用后缀命名法，便于实现自动加载、按需加载。参见如下这些示例名称的后缀： `FooController`, `BarView`, `FooInterface`, `$conntroller->barAction()`, `$obj->fooSet()`, `$obj->barGet()` 等等。
* 类名使用PascalCase规则，例如：`RouteRule`。
* 类的方法名使用camelCase规则，例如：`getUserIP()`。
* 类的属性名使用camelCase规则，例如：`userName`。
* 接口名要加上Interface后缀，例如：`RouteInterface`。
* 特性名要加上Trait后缀，例如：`SingletonTrait`。
* MVC的Controller、Model、View需要加上对应的后缀。
* 对类变量的Set和Get分别加上Set和Get后缀。例如：`fooSet($value)`, `fooGet()`。

### 全局函数

* 函数名以小写字母和下划线组成，例如：`foo_bar()`。
* Dida框架的全局函数以 `dida_` 开头，例如：`dida_halt()`。
* App级别的全局函数以 `appf_`开头，例如：`appf_dump_array()`。

### 常量

* 常量以大写字母和下划线组成，例如：`DIDA_ROOT`。
* DIDA框架级别的所有常量均以`DIDA_`开头，以避免和第三方常量发生冲突。

## 编码规范

1. Dida框架目录的所有文件都应该是和具体项目无关的，和项目有关的文件都应该放到App目录中。

    > 在决定一个文件究竟应该放到Dida目录还是放到App目录时，问自己一个问题：这个文件可以用于所有项目还是只能用于当前项目？

2. Dida框架的命名空间统一用`Dida`，App的命名空间可由用户自定，默认为`App`。

3. MVC的设计原则是：瘦Controller，胖Model，这样可以尽可能增强代码的可重用性。

4. require, include, require_once, include_once 文件时，推荐用不加括号的形式。

    > 推荐的写法：   `require 'target_file_name.php'`;  
    > 不推荐写法： `require('target_file_name.php')`;  

## 处理流程

1. 服务器把用户请求rewrite到 **Web入口文件** `{/your/www/}index.php`。

2. 在Web入口文件中设置好各个关键目录的文件路径和必要的其它标记，然后加载 **DIDA框架的入口文件** `{/dida/framework/root/}Index.php`。

3. 在 **DIDA框架的入口文件Index.php** 设置好基础运行环境：

    3.1. 设置全局常量
    3.2. 加载Dida的autoload机制
    3.3. 加载composer的autoload机制
    3.4. 生成$app实例
    3.5. 调用**$app->start()**，启动app，执行app初始化工作。

4. app启动后：

    4.1. 先调用 **Foundation::init()** 执行基础环境初始化。
    4.2. 生成**基本对象**，`config`, `response`。
    4.3. **载入App配置**， `App/Config/App.dev.php`。
    4.4. **载入App函数库**， 按照 `App/Functions/Index.php` 要求，载入app级别的函数库（如果有的话）。
    4.5. **载入App自举程序**，按照 `App/Bootstraps/Index.php` 要求，对app环境和可能用到的服务进行初始配置。

5. 工作环境ready，执行**$app->run()**，正式开始处理Reuqest。

6. **Middleware中间件环境初始化**。

7. Middleware对Request以及环境做些前期处理。

8. **Router** 逐一用登记的 **路由规则route** 去解析 **Request**，检查Request是否可以匹配这个规则route。如果匹配上，列出 **Controller** 和 **action**。

9.  Middleware处理 pre-action，比如进行身份认证等工作。

10. 执行标准的**MVC流程**：**Controller** 从 **Model** 取数据，输出给 **View**。

11. Middleware处理 post-action，比如一些过滤和收尾工作。

12. **app()->response->output()** 输出最终内容给用户。
