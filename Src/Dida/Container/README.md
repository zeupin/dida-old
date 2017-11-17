# Dida\Container\Container 服务容器

Container 是一个服务容器（Service Container），主要用于依赖注入和服务定位。

> 最开始设计时，Container 包含 **Service Container** 和 **Config Container** 的功能。但是在实际使用中，发现 Config 的配置项很多但是使用频率低，而 Services 的配置项很少使用频率却很高。为尽可能提高程序的运行效率， 最终决定， Container 只保留 Service Container 的功能， 而把 Config Container 独立为 Config 组件。不然，每次想引用一个 service ，都要从几十个 conf 中逐个找下来，会滞碍运行速度。

## 支持三种服务类型

- 类名 -- `CLASSNAME_TYPE`
- 闭包函数 -- `CLOSURE_TYPE`
- 服务实例 -- `INSTANCE_TYPE`

## 方法

- `has($id)` -- 是否存在某个服务
- `set($id, $service)` -- 设置一个服务
- `setSingleton($id, $service)` -- 设置一个单例服务
- `get($id)` -- 取回一个服务实例
- `getNew($id)` -- 取回一个新的服务实例（不可用于Singleton服务，会抛异常）
- `remove($id)` -- 删除一个服务
- `keys()` -- 获取所有已注册的服务id
