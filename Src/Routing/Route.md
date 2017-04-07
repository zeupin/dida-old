# Route

Route的主要任务就是把一个Request，按照既定规则，解析为[controller, action, arguments, flags]，然后执行dispatch()。

Request的可用属性包括：

- path[]：已被分解的url路径，且已被解除转义
- query[]：已被分解的查询串，且已被解除转义
- fragment：书签，且已被解除转义
- method：标准的HTTP方法（只能为：GET，POST，PUT，PATCH，DELETE，OPTIONS，HEAD之一）
- isAjax：是否是Ajax请求