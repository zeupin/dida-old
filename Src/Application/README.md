# Application

## 加载流程

Dida 框架启动 Application 时，先从用户的 App 目录中依次载入：

1. **App配置文件**： `App/Config/App.dev.php`。其中`dev`是当前环境名，可以在 `webroot/index.php` 中配置。
2. **App级别的函数库文件**： `App/Functions/Index.php`。
3. **App的自举文件**： `App/Bootstrap/Index.php`。

最后，才是载入 App 的入口文件： `App/Index.php`。