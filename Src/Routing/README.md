# Routing 路由

Routing的主要任务是：

1. 把 Request ，按照既定规则，解析为[controller, action]。
2. 询问 controller ：action 是否存在。
3. 如果 action 存在，则执行 dispatch()。

Routing 只负责从 Request 中解析出 controller 和 action ，不负责以下事情：

1. 获取controller或者action的具体执行参数。
    > 这个属于业务代码，应该在controller或者action里面去完成。
2. 检查用户有无执行权限。
    > 这个属于业务代码，应该在controller或者action里面中去完成。

## 参考

- [Request](../Request/README.md)
