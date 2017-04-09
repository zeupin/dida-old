# Request

## HttpRequest

把一个HttpRequest解析为路径 `path[]`和查询串 `query[]`。

- `path[]`：滤除了 DIDA_WWW 外的部分。
- `query[]`：等效为 $_GET。

另外，还可以请求如下属性：

- `method`：标准的 Http Method，正常为 `GET`,`POST`,`PUT`,`PATCH`,`DELETE`,`OPTIONS`,`HEAD` 之一。除此之外就抛异常。
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