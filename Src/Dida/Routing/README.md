# Routing 路由

Routing 的主要工作是：
1. 把 HttpRequest ，按照既定规则，解析为 `[controller, action]` 。
2. 检查 `controller` 是否存在？
3. 调用 `controller::actionExists()`，`action` 是否存在？
4. 如果 `action` 存在，则执行 `dispatch()` 操作。

Routing 只负责从 Request 中解析出 controller 和 action ，而：
1. 不负责获取controller或者action的具体执行参数（parameters）。
    > 这个属于业务代码，应该在controller或者action里面去完成。
2. 不负责检查用户的执行权限。
    > 这个属于业务代码，应该在controller或者action里面中去完成。

Routing 主要用 `Router` 和 `Route` 这两个类来实现功能。

## Router 路由器类

一般在 `App/Bootstraps/Index.php` 中初始化 Router：

```php
/* 设置路由规则 */
Dida::$app->router = function () {
    /* 生成 Router实例 */
    $router = new Router;

    /* 设置若干路由规则 */
    $router->addRoute(new 路由规则1);
    $router->addRoute(new 路由规则2);
    $router->addRoute(new 路由规则N);

    /* 返回生成的路由器实例 */
    return $router;
};
```

然后在 `App/Index.php` 中调用 `Dida:$app->router->start()`，逐个检查注册的Routes，找到第一个匹配的Route，执行对应的Action。

## Route 路由规则类

**方法**

- match()
- setRequest()
- loadRouteMap()

**属性**

- matched 是否匹配成功
- controller Controller的类全名（仅在匹配成功后可读取）
- action （仅在匹配成功后可读取）

## 参考

- [Request](../Request/README.md)
