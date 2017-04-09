# Request

## HttpRequest

获取一个HttpRequest的相关数据。

### 基本属性，初始化时即获取

- `method`：请求方式。
    > 正常为 `GET`,`POST`,`PUT`,`PATCH`,`DELETE`,`OPTIONS`,`HEAD` 之一，除此之外就抛异常。
    > 可用 `HttpRequest::GET_METHOD`, `HttpRequest::POST_METHOD`常量指代对应方法。
- `path[]`：path数组，且已经滤除了 DIDA_WWW。

### 扩展属性，需要用到时再获取

- `get[]`：$_GET。
- `post[]`：$_POST。
- `isAjax`：是否是Ajax请求。

### 附1：HTTP请求是不包含fragment的

虽然可以用PHP的原生函数 `parse_url()` 解析url中的书签部分(fragment)，但是实际上，标准的HTTP请求是不包括 `#` 的。（因为 `#` 是用来指导浏览器动作的，对服务器端完全无用，所以HTTP请求中并不包括`#`）

比如，访问下面的网址：
```
http://www.example.com/index.html#print
```

浏览器实际发出的请求是这样的：
```
GET /index.html HTTP/1.1
Host: www.example.com
```

可以看到，只是请求 `index.html`，根本没有 `#print` 的部分。

因此，在 `$_SERVER['REQUEST_URI']` 变量中，也是不包含 #fragment 部分的。

参考：<http://www.cnblogs.com/kaituorensheng/p/3776527.html>